<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplicationController
 *  
 * @author Nganthoiba
 */
class ApplicationController extends Controller{
    public $applications;
    public function __construct($data = array()) {
        parent::__construct($data);
        $applications = new Application();
        $this->response = new Response();
    }
    public function index(){
        return $this->view();
    }
    public function viewApplications(){
        $user_id = "";
        /* Check user is authenticated */
        if(Logins::isAuthenticated() && (strtolower(Logins::getRoleName())=="applicant" || strtolower(Logins::getRoleName())=="admin")){
            $info = $_SESSION['user_info'];
            $user_id = $info['user_id'];
        }
        else{
            //redirect to login page if user is not authenticated
            $this->redirect("Account", "login");
        }
        
        $application = new Application();
        $process_id = 8; // from user input 
        $list = $application->readAppLog($user_id,$process_id);
        
        $this->data['applications'] = $list->data;
        $this->data['user_id'] = $user_id;
        return $this->view();
    }
    
    public function getCertificateTypes(){
        $certificateType = new certificate_type();
        $res = $certificateType->read();
        return $this->send_data($res, $res->status_code);
        //return $this->sendResponse($res['status'], $res['msg'], $res['status_code'],$res['error'],$res['data']);
    }
    
    /*** validation function for application */
    public function apply(){
        $user_id = "";
        /* Check user is authenticated */
        if(Logins::isAuthenticated()){
            $info = $_SESSION['user_info'];
            $user_id = $info['user_id'];
        }
        else{
            //redirect to login page if user is not authenticated
            $this->redirect("Account", "login");
        }
        $data = $this->_cleanInputs($_POST);
        
        if(sizeof($data)){
            $response = verifyCSRFToken();
            if($response->status == false){
                return $this->send_data($response, $response->status_code);
            }
            $this->response->status_code = 403;//Bad Request
            
            //$aadhaar = isset($data['aadhaar'])?str_replace(" ","",$data['aadhaar']):""; //Aadhaar 
            $appli_for = isset($data['urgent_ordinary'])?$data['urgent_ordinary']:""; //Application For
            $case_type = isset($data['case_type'])?$data['case_type']:""; //Case Type
            $case_no = isset($data['case_no'])?$data['case_no']:""; //Case No
            $case_year = isset($data['case_year'])?$data['case_year']:""; 
            $appel_petitioner = isset($data['appel_petitioner'])?$data['appel_petitioner']:""; 
            $respondant_opp = isset($data['respondant_opp'])?$data['respondant_opp']:""; 
            $certificate_type_id = isset($data['certificate_type_id'])?(int)$data['certificate_type_id']:""; 
            $order_date = isset($data['order_date'])?$data['order_date']:""; 
            
            $case_type_reference = isset($data['case_type_reference']) && ($data['case_type_reference']!="")?$data['case_type_reference']:-1;
            $case_no_reference = isset($data['case_no_reference']) && ($data['case_no_reference']!="")?$data['case_no_reference']:-1;
            $case_year_reference = isset($data['case_year_reference']) && ($data['case_year_reference']!="")?$data['case_year_reference']:-1;
            
            // application written by client if certificate type is not for order copy
            $written_application = htmlspecialchars(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $_POST['textData']));
            
            $submit_date = date('Y-m-d H:i:s');
            /*** input validations *****/
            /*if(strlen($aadhaar) != 12)
            {
                $this->response->msg = 'Invalid aadhaar number: '.trim($aadhaar,"\t ");
                $this->response->status = false;
            }
            */
            if(trim($case_type) == "")
            {
                $this->response->msg = 'Please select case type ';
                $this->response->status = false;
            }
            else if(trim($case_no) == "")
            {
                $this->response->msg = 'Please fill case no ';
                $this->response->status = false;
            }
            else if(trim($appel_petitioner) == "")
            {
                $this->response->msg = 'Please fill appellant/petitioner name ';
                $this->response->status = false;
            }
            else if(trim($respondant_opp) == "")
            {
                $this->response->msg = 'Please fill respondent/opposite party name ';
                $this->response->status = false;
            }
            else if(trim($certificate_type_id) == "")
            {
                $this->response->msg = 'Please select certificate type ';
                $this->response->status = false;
            }
            else if(trim($order_date) == "")
            {
                $this->response->msg = 'Please enter date of order or disposal ';
                $this->response->status = false;
            }
            /*************End input validation ***************/
            else{
                
                $applicationModel = new Application();
                //$applicationModel->aadhaar = $aadhaar;
                $applicationModel->application_for = $appli_for;
                $applicationModel->case_no = $case_no;
                $applicationModel->case_type = $case_type;
                $applicationModel->case_year = $case_year;
                
                $applicationModel->case_no_reference = $case_no_reference;
                $applicationModel->case_type_reference = $case_type_reference;
                $applicationModel->case_year_reference = $case_year_reference;
                
                $applicationModel->certificate_type_id = $certificate_type_id;
                $applicationModel->create_at = $submit_date;
                $applicationModel->order_date = $order_date;
                $applicationModel->petitioner = $appel_petitioner;
                $applicationModel->respondent = $respondant_opp;
                $applicationModel->user_id = $user_id;
                $applicationModel->written_application = $written_application;
                
                $this->response = $applicationModel->add();
                
                if($this->response->status_code == 200){
                    $this->response->msg = "You have successfully submitted. Thank you.";
                }
                
            }
            return $this->send_data($this->response, $this->response->status_code);
            //return $this->sendResponse($this->response->status,$this->response->msg,$status_code,$this->response['error']);
        }
        return $this->view();
    }
    
    public function viewDetails(){
        $user_info = $_SESSION['user_info'];
        $role_id = $user_info['role_id'];
        
        $this->data['msg'] = "";
        $this->data['status'] = false;
        $param = $this->getParams();
        if(sizeof($param)){
            $application_id = $param[0];
            $process_id = $param[1]??"";
            $this->data['process_id'] = $process_id;
            $application = new Application();
            $application = $application->find($application_id);
            $user = new Users();
            $user = $user->find($application->user_id);
            $application->applicant_name = $user->full_name;
            $pending = isTaskPending(Database::connect(), $application_id, $process_id, $role_id);
            $application->isTaskPending = $pending['status'];
            
            if($application == null){
                $this->data['status'] = false;
                $this->data['msg'] = "Application not found!";
            }
            else{
                $this->data['status'] = true;
                $this->data['application'] = $application;
            }
        }
        return $this->view();
    }
    
    
    public function application_list(){
        $params = $this->getParams();
        
        $process_id = $params[0]??""; 
        $task_type = $params[1]??"";
        $approve_reject = $params[2]??"";
        $user_info = $_SESSION['user_info'];
        $role_id = $user_info['role_id'];
        $app = new application;
        $resp = $app->application_history($role_id,$task_type,$process_id,true);

        $this->data['process_id'] = $process_id;
        if(!$resp->status){
                $this->data['status'] =  false;
                $this->data['msg'] =  $resp['msg'];
        }
        else{
            $approve = $reject = array();
            foreach($resp->data as $item){
                if($item['action_name']=='approve'){
                    $approve[] = $item;
                }
                else if($item['action_name']=='reject'){
                    $reject[] = $item;
                }
            }
            if($task_type == 'out'){
                if(strtolower($approve_reject) == 'approve'){
                    $resp->data = $approve;
                }
                else{
                    $resp->data = $reject;
                }
            }
            $this->data['status'] =  true;
            $this->data['data'] = $resp->data;
        }
        return $this->view();
    }
    
    public function approve(){
        $response = new Response(); //;
        $params = $this->getParams();
        if(sizeof($params)==0){
            $response->set(array(
                'msg'=>'Provide a valid application Id.', 
                'status'=>false,
                'status_code'=>403
                ));
            return $this->send_data($response, $response->status_code);
        }
        $application_id = $params[0];
        $process_id = $params[1]??'';
        $app = new application;
        $user_info = $_SESSION['user_info'];
        //$m = new model();
        $resp = insertApplicationLog(Database::connect(), 'approve', $application_id, $process_id , 'The application has been approved.');
        return $this->send_data($resp, $resp['status_code']);
    }
    
    public function reject(){
        $response = new Response();
        $params = $this->getParams();
        if(sizeof($params)==0){
            $response->set(array(
                'msg'=>'Provide a valid application Id.',
                'status'=>false,
                'status_code'=>403
                ));
            return $this->send_data($response, $response->status_code);
        }
        $application_id = $params[0];
        $process_id = $params[1]??'';
        $app = new application;
        $user_info = $_SESSION['user_info'];
        $resp = insertApplicationLog(Database::connect(), 'reject', $application_id, $process_id , 'The application has been rejected.');
        
        return $this->send_data($resp, $resp['status_code']);
    }
    
    public function status(){
        return $this->view();
    }
}
