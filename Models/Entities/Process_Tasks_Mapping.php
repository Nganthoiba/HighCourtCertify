<?php
/**
 * Description of process_tasks_mapping
 *
 * @author Nganthoiba
 */
class Process_Tasks_Mapping extends EasyEntity{
    public  $process_tasks_mapping_id,
            $process_id,
            $tasks_id,
            $priority_level,
            $is_enabled;
    public function __construct() {
        parent::__construct();
        $this->setTable("process_tasks_mapping")->setKey("process_tasks_mapping_id");
        $this->priority_level = $this->findMaxColumnValue("priority_level")+1;
        
    }
    
    public function add(): Response {
        $this->is_enabled = 'y';
        //check if mapping already exists
        $cond = [
            "process_id"=>$this->process_id,
            "tasks_id"=>$this->tasks_id
        ];
        $list = $this->read()->where($cond)->getFirst();
        $this->getQueryBuilder()->clear();
        if($list!==null){ 
            $this->process_tasks_mapping_id = $list->process_tasks_mapping_id;
            return parent::save();
        }
        
        $this->process_tasks_mapping_id = $this->findMaxColumnValue("process_tasks_mapping_id")+1;
        
        return parent::add();
    }
    
    //read all the tasks included or not included in a process separately
    public function readTasksProcessMap($process_id){
        $conn = Database::connect();
        $this->response = new Response();
        $qry = " select T.*,PTM.process_id,PTM.priority_level from tasks T ".
               " LEFT JOIN ".
               " (select * from process_tasks_mapping where process_id = ? and is_enabled = ?) as PTM ".
               " ON PTM.tasks_id = T.tasks_id ".
               " WHERE T.delete_at IS NULL "
                . " ORDER BY PTM.priority_level ";
        
        $stmt = $conn->prepare($qry);
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
        $response = new Response();        
        $params = [
            "is_enabled"=>'n'//first disabling all the process and tasks mappings
        ];
        $cond = [
            "process_id" => $this->process_id
        ];
        
        $qryBuilder = $this->getQueryBuilder();
        $qryBuilder->beginTransaction();
        try{
            $stmt = $qryBuilder->update($this->getTable())
                ->setValues($params)
                ->where($cond)
                ->execute();
            $response->set([
                "status"=>true,
                "msg"=>"Record updated",
                "status_code"=>200
            ]);
            $qryBuilder->clear();
        }
        catch(Exception $e){
            $response->set([
                        "msg" => "Sorry, an error occurs while updating the record. ".$e->getMessage(),
                        "status"=>false,
                        "status_code"=>500,
                        "error"=>$qryBuilder->getErrorInfo()
                    ]);
        }
        
        if(!$response->status){
            return $response;
        }
        
        $this->priority_level = 1;
        foreach ($tasks_ids as $tasks_id){
            $this->tasks_id = $tasks_id;
            $this->is_enabled = 'y';
            $this->priority_level++;
            $response = $this->add();
            
            
            if($response->status == false){
                $qryBuilder->rollbackTransaction();
                break;
            }
        }
        
        if($response->status == true){
            $qryBuilder->commitTransaction();
            $response->set([
                "msg"=>"Record saved successfully."
            ]);
        }
        return $response;
    }
}
