<?php
/**
 * Description of Application
 * @author Nganthoiba
 */
class Application extends EasyEntity{
    public  $application_id,
            $copy_type_id,
            $case_type_id,
            $case_no,
            $case_year,
            $case_type_reference,
            $case_no_reference,
            $case_year_reference,
            $petitioner,
            $respondent,
            $certificate_type_id,
            $order_date,
            $create_at,
            $user_id,
            $is_order,
            $is_third_party;
    
    private $response;
    public function __construct() {
        parent::__construct();
        $this->setTable("application");
        $this->setKey("application_id");
        $this->response = new Response();
    }
    
    public function getProcessId(){
        if($this->is_order=="y"){
            return 2;
        }
        else if($this->is_third_party=="y"){
            return 3;
        }
        return 1;
    }
    
    //Overriding parent method
    public function find($id){
        $qryBuilder = $this->getQueryBuilder();
        
        $stmt = $qryBuilder->select()->from("application_tasks_log_view")->where([
            $this->getKey() => ['=',$id]
        ])->execute();
        if($stmt->rowCount()){
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach ($res as $col_name=>$val){
                $this->{$col_name} = $val;
            }
        }
        else{
            return null;
        }
        return $this;
    }
    //Overriding parent method
    public function add(): Response {
        $this->getQueryBuilder()->beginTransaction();
        $add_resp = parent::add();
        if($add_resp->status_code!=200){
            return $add_resp;
        }
        
        $tasks_id = 1;//Task id for applying a new copy
        $process_id = $this->getProcessId();//process_id =2 for order copy whereas 1 for non order copy
        $remark = "Submit a new application.";
        $app_log_resp = insertApplicationTasksLog(EasyQueryBuilder::$conn, $this->application_id, $this->user_id, "create", $tasks_id, $process_id, $remark);
        if(!$app_log_resp->status){
            $this->getQueryBuilder()->rollbackTransaction();
        }
        else{
            $this->getQueryBuilder()->commitTransaction();
            $app_log_resp->msg = "You have submitted your application";
        }
        return $app_log_resp;
    }
    
    //read application details from application_tasks_log table
    public function readAppTasksLog($user_id){
        $conn = Database::connect();
        $qry = "select * from application_tasks_log_view where action_user_id = ? order by create_at desc limit 100";
        $stmt = $conn->prepare($qry);
        $res = $stmt->execute([$user_id]);
        if($res){
            if($stmt->rowCount()==0){
                $this->response->status = false;
                $this->response->msg = "No record found";
                $this->response->status_code = 404;
            }
            else{
                $this->response->status = true;
                $this->response->msg = "Record found";
                $this->response->status_code = 404;
                $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
                $data =array();
                foreach ($rows as $row){
                    $obj = new Application();
                    foreach ($row as $key=>$val){
                        $obj->$key = $val;
                    }
                    $data[] = $obj;
                }
                $this->response->data = $data;
            }
        }
        else{
            $this->response->status = false;
            $this->response->msg = "Oops! An internal error occurs.";
            $this->response->status_code = 500;
            $this->response->error = $stmt->errorInfo();
        }
        return $this->response;
    }
    
    //methode to check whether case body exists for the particular application
    public function isCaseBodyFound(){
        $caseBody = new Casebody();
        return $caseBody->isCaseBodyExist($this->case_type, $this->case_no, $this->case_year);
    }
    
    //method to get case body if found
    public function getCaseBody(){
        $caseBody = new Casebody();
        return $caseBody->getCaseBody($this->case_type, $this->case_no, $this->case_year);
    }
    
    //method to get certificate (document) if already prepared
    public function getDocument(){
        $doc = new Document();
        $cond = [
            "application_id" => $this->application_id
        ];
        $res = $doc->read([], $cond);
        if($res->status){
            return $res->data[0];
        }
        return null;
    }
    
    /** method to check if processing fee is completed for this application ***/
    public function isPaymentCompleted(): bool{
        $payment = new Payments();
        $payment = $payment->read()->where([
            "application_id"=> $this->application_id,
            "status"=>"Completed"
        ])->getFirst();
        if($payment == null){
            return false;
        }
        return true;
    }
}
