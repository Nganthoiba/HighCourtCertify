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
            $is_third_party,
            $is_offline;
    
    private $response;
    public function __construct() {
        parent::__construct();
        $this->setTable("application");
        $this->setKey("application_id");
        $this->response = new Response();
    }
    
    public function getProcessId():int{
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
            if($this->is_offline === "y"){
                $offline_app = new offline_application();
                $offline_app = $offline_app->read()->where([
                    "application_id"=>$this->application_id
                ])->getFirst();
                $this->applicant_name = $offline_app!=null?$offline_app->applicant_name:"Not found!";
            }
        }
        else{
            return null;
        }
        return $this;
    }
    
    //read application details from application_tasks_log table
    public function readAppTasksLog($user_id,$is_offline="n"){
        
        $qryBuilder = new EasyQueryBuilder();   
        
        try{
            $stmt = $qryBuilder->select()
                ->from("application_tasks_log_view")
                ->where([
                        "action_user_id"=>["=",$user_id],
                        "is_offline"=>["=",$is_offline]
                    ])
                ->execute();
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
                        $obj->{$key} = $val;
                    }
                    //check if application is submitted in offline mode
                    if($obj->is_offline === "y"){
                        $offline_app = new offline_application();
                        $offline_app = $offline_app->read()->where([
                            "application_id"=>$obj->application_id
                        ])->getFirst();
                        $obj->applicant_name = $offline_app!=null?$offline_app->applicant_name:"Not found!";
                    }
                    $data[] = $obj;
                }
                $this->response->data = $data;
            }
        }
        catch(Exception $e){
            $this->response->status = false;
            $this->response->msg = "Oops! An internal error occurs.";
            $this->response->status_code = 500;
            $this->response->error = $e->getMessage();
        }
        return $this->response;
    }
    
    //methode to check whether case body exists for the particular application
    public function isCaseBodyFound(){
        $caseBody = new Casebody();
        return $caseBody->isCaseBodyExist($this->case_type_id, $this->case_no, $this->case_year);
    }
    
    //method to get case body if found
    public function getCaseBody(){
        $caseBody = new Casebody();
        return $caseBody->getCaseBody($this->case_type_id, $this->case_no, $this->case_year);
    }
    
    //method to get certificate (document) if already prepared
    public function getDocument(){
        $doc = new Document();
        $cond = [
            "application_id" => $this->application_id
        ];
        return $doc->read()->where($cond)->getFirst();
    }
    
    /** method to check if processing fee is completed for this application ***/
    public function isPaymentCompleted(): bool{
        $payment = new Payments();
        $payment = $payment->read()->where([
            "application_id"=> $this->application_id,
            "status"=>"Completed"
        ])->getFirst();
        if($payment === null){
            return false;
        }
        return true;
    }
    //getting user intemation
    public function getIntimation(){
        $status = new Status();
        $intemation = $status->read()->where([
            "application_id"=>$this->application_id,
            "deleted_at"=>["IS",NULL]
        ])->getFirst();
        return $intemation;
    }
    
    //generate appication ID
    public function generateID(){
        return "MNHC".date("m-Y")."-".randId(6);
    }
    
    //get total application request
    public static function count($type){
        
        $qryBuilder = new EasyQueryBuilder();
        //$conn = Database::connect();
        //$qry = "";
        switch($type){
            case 'all':
                //$qry = "select count(*) as cnt from application";
                $stmt = $qryBuilder->select("count(*) as cnt")->from("application")->execute();
                break;
            case 'completed':
                //$qry = "select count(*) as cnt from latest_application_tasks_log_view where next_tasks_id is NULL";
                $stmt = $qryBuilder->select("count(*) as cnt")
                        ->from("latest_application_tasks_log_view")
                        ->where([
                            "next_tasks_id"=>["IS",NULL]
                        ])
                        ->execute();
                break;
            case 'pending':
                //$qry = "select count(*) as cnt from latest_application_tasks_log_view where next_tasks_id IS NOT NULL";
                $stmt = $qryBuilder->select("count(*) as cnt")
                        ->from("latest_application_tasks_log_view")
                        ->where([
                            "next_tasks_id"=>["IS NOT",NULL]
                        ])
                        ->execute();
                break;
            default :
        }
        
        //$stmt = $conn->prepare($qry);
        
        if($stmt->rowCount() == 0){
            return 0;
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['cnt'];
    }
    
    public static function barchartInfo($year){
        $qryBuilder = new EasyQueryBuilder();
        $months = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
        $dataSet = [];
        
        for($i = 1; $i <= 12; $i++){
            /*** finding total request for every month ***/
            $m = $i<10? '0'.$i : $i;//month expression
            $obj = new EmptyClass();
            $stmt = $qryBuilder->select("count(*) as cnt")
                    ->from("latest_application_tasks_log_view")
                    ->where([
                        "EXTRACT(YEAR FROM create_at)"=>['=',$year],
                        "EXTRACT(MONTH FROM create_at)"=>['=',$m]
                    ])
                    ->execute();
            if($stmt->rowCount() == 0){
                $obj->total_request = 0;
            }
            else{
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $obj->total_request = $row['cnt'];
            }
            
            /*** finding completed request for a month ***/
            $stmt2 = $qryBuilder->select("count(*) as cnt")
                    ->from("latest_application_tasks_log_view")
                    ->where([
                        "EXTRACT(YEAR FROM create_at)"=>['=',$year],
                        "EXTRACT(MONTH FROM create_at)"=>['=',$m],
                        "next_tasks_id"=>["IS",null]
                    ])
                    ->execute();
            if($stmt2->rowCount() == 0){
                $obj->completed_request = 0;
            }
            else{
                $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                $obj->completed_request = $row['cnt'];
            }
            $obj->month = $months[$i-1];
            $dataSet[] = $obj;
        }
        return $dataSet;
    }
    
}
