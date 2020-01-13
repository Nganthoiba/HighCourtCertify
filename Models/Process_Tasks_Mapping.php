<?php
/**
 * Description of Process_Tasks_Mapping
 *
 * @author Nganthoiba
 */
class Process_Tasks_Mapping extends model{
    /*
     *  Table Structure:
     *  process_tasks_mapping_id  serial NOT NULL,
        process_id                integer,
        tasks_id                  integer,
        priority_level            integer
     */
    public  $process_tasks_mapping_id,
            $process_id,
            $tasks_id,
            $priority_level,
            $is_enabled;
    
    public function __construct() {
        parent::__construct();
        $this->setTable("process_tasks_mapping");
        $this->setKey("process_tasks_mapping_id");
        $this->priority_level = $this->findMaxColumnValue("priority_level")+1;
    }
    
    public function add(){
        $response = new Response();
        $cond = [
                    "process_id" => $this->process_id,
                    "tasks_id" => $this->tasks_id
                ];
        $response = $this->read(array(), $cond);
        if($response->status){
            //which means data already exists, so update the row as enabled i.e. y
            $params = [
                "priority_level" => $this->priority_level,
                "is_enabled"=>'y'
            ];
            $cond = [
                "process_id" => $this->process_id,
                "tasks_id" => $this->tasks_id
            ];
            $response = $this->update($params, $cond);
        }
        else{
            //Otherwise new record is inserted
            $this->process_tasks_mapping_id = $this->findMaxColumnValue("process_tasks_mapping_id")+1;
            $rec = [
                "process_tasks_mapping_id" => $this->process_tasks_mapping_id,
                "process_id" => $this->process_id,
                "tasks_id" => $this->tasks_id,
                "priority_level" => $this->priority_level,
                "is_enabled"=>'y'
            ];//record to be created
            $response = parent::create($rec);
        }
        return $response;
    }
    
    public function read($columns = array (), $cond = array (), $order_by = "priority_level") {
        return parent::read($columns, $cond, $order_by);
    }
    
    public function remove(){
        $cond = [
            "process_tasks_mapping_id" => $this->process_tasks_mapping_id
        ];
        return parent::delete($cond);
    }
    
    //read all the tasks included or not included in a process separately
    public function readTasksProcessMap($process_id){
        $this->response = new Response();
        $qry = " select T.*,PTM.process_id,PTM.priority_level from tasks T ".
               " LEFT JOIN ".
               " (select * from process_tasks_mapping where process_id = ? and is_enabled = ?) as PTM ".
               " ON PTM.tasks_id = T.tasks_id ".
               " WHERE T.delete_at IS NULL "
                . " ORDER BY PTM.priority_level ";
        
        $stmt = self::$conn->prepare($qry);
        if($stmt->execute([$process_id,'y'])){
            if($stmt->rowCount()==0){
                $this->response->set([
                    "msg"=>"No record found."
                ]);
            }
            else{
                $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
                $tasks_excluded = array();
                $tasks_included = array();
                foreach($rows as $row){
                    if($row['process_id'] == NULL || trim($row['process_id']) == "" ){
                        $tasks_excluded[] = $row;				
                    }
                    else{
                        $tasks_included[] = $row;		
                    }
                }
                $this->response->set([
                    "msg"=>"List of tasks",
                    "status"=>true,
                    "status_code"=>200,
                    "data"=> [ 'included'=>$tasks_included, 
                        'excluded'=>$tasks_excluded ]
                ]);
            }
        }
        else{
            $this->response->set([
                "error"=>$stmt->errorInfo()
            ]);
        }
        return $this->response;
    }
    
    public function setTasksProcessMap($tasks_ids=array()){
        self::$conn->beginTransaction();
        $response = new Response();
        $params = [
            "is_enabled"=>'n'//first disabling all the process and tasks mappings
        ];
        $cond = [
            "process_id" => $this->process_id
        ];
        $response = $this->update($params, $cond);
        if(!$response->status){
            return $response;
        }
        
        $this->priority_level = 1;
        foreach ($tasks_ids as $tasks_id){
            $this->tasks_id = $tasks_id;
            $response = $this->add();
            $this->priority_level++;
            if($response->status == false){
                self::$conn->rollback();
                break;
            }
        }
        if($response->status == true){
            self::$conn->commit(); 
            $response->set([
                "msg"=>"Record saved successfully."
            ]);
        }
        return $response;
    }
}
