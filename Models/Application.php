<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application
 *
 * @author Nganthoiba
 */

class Application extends model{
    public $response;
    /* Fields in the table applications */
    public  $application_id,
            $application_for,
            $case_type,
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
            $written_application;
    
    public function __construct() {
        parent::__construct();
        $this->setTable("application");
        $this->setKey("application_id");
        $this->response = new Response();
    }
    
    //insert a new application
    public function add() {
        $this->application_id = UUID::v4();
        $conn = self::$conn;
        $conn->beginTransaction();
        //Record to be inserted
        $is_order = $this->certificate_type_id==1?"y":"n";
        $rec = array(
            "application_id"=>$this->application_id ,
            "application_for"=>$this->application_for ,
            "case_type"=>$this->case_type ,
            "case_no"=>$this->case_no ,
            "case_year"=>$this->case_year ,
            "case_type_reference"=>$this->case_type_reference ,
            "case_no_reference"=>$this->case_no_reference ,
            "case_year_reference"=>$this->case_year_reference ,
            "petitioner"=>$this->petitioner ,
            "respondent"=>$this->respondent ,
            "certificate_type_id"=>$this->certificate_type_id ,
            "order_date"=>$this->order_date ,
            "create_at"=>$this->create_at, 
            "user_id"=>$this->user_id,
            "is_order"=>$is_order
        );
        $resp = parent::create($rec);
        
        if($resp->status_code!=200){
            return $resp;
        }
        //if the application is not for order copy
        if($is_order === "n"){
            if($this->written_application == ""){
                $conn->rollback();
                return $this->response->set(array(
                    "status"=>false,
                    "msg"=>"You must write an application letter.",
                    "status_code"=>403,
                    "error"=>null,
                    "data"=>null
                ));
            }
            $qry = "insert into written_application(application_id,body) values(?,?);";
            $stmt = $conn->prepare($qry);
            $res = $stmt->execute(array($this->application_id,$this->written_application));
            if(!$res){
                $conn->rollback();
                return $this->response->set(array(
                    "status"=>false,
                    "msg"=>"Failed to submit your application.",
                    "status_code"=>500,
                    "error"=>$stmt->errorInfo(),
                    "data"=>null
                ));
            }
        }
        
        // inserting a record about application submission in application log
        $action_name = "create";
        $process_id = 8;//8 means first process
        $remark = "Application is submitted";
        
        $app_log_res = insertApplicationLog($conn, $action_name,  $this->application_id, $process_id, $remark,$is_order);
        if(!$app_log_res['status']){
            $conn->rollback();
            return $this->response->set($app_log_res);
        }
        $conn->commit();
        $resp->msg = "You have submitted your application";
        return $resp;
    }
    
    public function read($columns = array(), $cond = array(), $order_by = "") {
        $order_by = $order_by==""?"create_at desc":$order_by;
        return parent::read($columns, $cond, $order_by);
    }
    
    public function readAppLog($user_id, $process_id){
        $qry = "select * from application_log_view where action_user_id = ? and from_process_id=? order by create_at desc limit 100";
        $stmt = self::$conn->prepare($qry);
        $res = $stmt->execute(array($user_id, $process_id));
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
                    $obj = new model();
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
    
    //Overriding parent method
    public function find($value){
        //parent::find($value);
        $qry = "select * from application_log_view where application_id=:application_id";
        $stmt = self::$conn->prepare($qry);
        $stmt->bindParam(":application_id",$value);
        $res = $stmt->execute();
        if(!$res || $stmt->rowCount()==0){
            return null;
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        /*
        $obj = new ModelObject();
        foreach ($row as $col_name=>$val){
            $obj->$col_name = $val;
        }
        return $obj;
        */
        return (object)$row;
    }
    
    public function application_history($id , $task_type='in',$process_id="" ,$role_flag = true){
        //$response = array('status'=>false , 'msg' => 'Internal Server Error');
        $response = new Response();
        if($process_id === ""){
            $response->msg="Process ID?";
            return $response;
        }
        $db = self::$conn;
        
        switch(trim($task_type)){
            case 'out' :
                if($role_flag){
                    $qry = "select * from application_log_view where from_role_id = ? and from_process_id=?";
                }
                else{
                    $qry = "select * from application_log_view where action_user_id = ? and from_process_id=?";
                }
                break;
            case 'in' :
                if($role_flag){
                    $qry = "select * from latest_application_log_view where to_role_id = ? and to_process_id=?";
                }
                else{
                    return $response;
                }
                break;
            default : return $response;
                break;
        }


        $stmt = $db->prepare($qry);
        $resp = $stmt->execute(array($id,(int)$process_id));
        if(!$resp){			
            $response->error = $stmt->errorInfo();
            $response->msg = "Internal Server Error";
            $response->status_code = 500;
            return $response;
        }
        
        $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
        $response->status = true;
        $response->status_code = 200;
        $response->data = $rows;
        $response->msg = "Record found";
        return $response;
    }
    /*
    public function application_approve_reject($application_id,$user_info,$flag){
        $response = array('status'=>false , 'msg' => 'Internal Server Error');
        $user_id = $user_info['user_id'];
        $role_id = $user_info['role_id'];
        switch($flag){
            case 'approve' : $qry = 'update application set ';
        }
        
    }
    
    */
    
}
