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
        if(!Logins::isAuthenticated()){
            $this->redirect("Account", "Login");
        }
        $this->applications = new Application();
        $this->response = new Response();
    }
    public function index(){
        return $this->view();
    }
    public function application_for(){
        //to read certificate type whether certify, uncertify, certify urgent or uncertify urgent
        $application_for = new application_for();
        $list = $application_for->read()->orderBy("application_for_id")->toList();
        if($list == null){
            $this->response->set([
                "msg"=>"No record found.",
                "status_code"=>404
            ]);
        }
        else{
            $this->response->set([
                "msg"=>"list of certificate types",
                "status"=>true,
                "status_code"=>200,
                "data"=>$list
            ]);
        }
        return $this->sendResponse($this->response);
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
        //$process_id = 8; // from user input 
        //$list = $application->readAppLog($user_id,$process_id);
        $list = $application->readAppTasksLog($user_id);
        //$list = $application->read()->where(['user_id'=>$user_id])->orderByDesc("create_at")->toList();
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
        $tasks_id = 6;// fixed 6 is task id for applying a new copy
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
                return $this->sendResponse($response);
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
            $is_third_party = $data['is_third_party'];
            
            $submit_date = date('Y-m-d H:i:s');
            
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
                $applicationModel->application_id = UUID::v4();
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
                $applicationModel->is_third_party = $is_third_party;
                
                $this->response = $applicationModel->add();
                
                if($this->response->status_code == 200){
                    $this->response->msg = "You have successfully submitted. Thank you.";
                }
                
            }
            return $this->sendResponse($this->response);
        }
        //to read certificate type whether certify, uncertify, certify urgent or uncertify urgent
        $application_for = new application_for();
        $application_for_list = $application_for->read()->orderBy("application_for_id")->toList();
        $this->data['application_for_list'] = $application_for_list;
        
        $caseType = new case_type();
        $this->data['case_type_list'] = $caseType->read(['case_type_id','type_name','full_form'])->orderBy('type_name')->toList();
        
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
            //$pending = isTaskPending(Database::connect(), $application_id, $process_id, $role_id);
            //$application->isTaskPending = $pending['status'];
            
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

    public function status(){
        return $this->view();
    }
    
    
    public function application_list(){
        $params = $this->getParams();
        $tasks_id = $params[0]??"";
        $task_type = $params[1]??"";
        $approve_reject = $params[2]??"";
        
        $_SESSION['tasks_id'] = $this->data['tasks_id'] = $tasks_id;
        $user_info = $_SESSION['user_info'];
        $role_id = $user_info['role_id'];
        
        $task = new Tasks();
        $task = $task->find($tasks_id);
        $this->data['tasks_name'] = "";
        if($task === null){
            $this->response->set([
                "msg"=>"Invalid request.",
                "status_code"=>404,
                "error"=>"Task not found."
            ]);
            $this->data['tasks_name'] = "Task Not Exists.";
        }
        else if($task->isRoleAllowed($role_id) === false){
            $this->response->set([
                "msg"=>"You don't have right to access.",
                "status_code"=>403
            ]);
        }
        else{
            $this->data['tasks_name'] = $task->tasks_name;
            
            $this->response = getApplicationTasksHistory($task::$conn,$tasks_id,$task_type);
            if($this->response->status){
                $all = $approve = $reject = array();
                foreach($this->response->data as $item){
                    if($item->action_name=='approve' || $item->action_name=='forward'){
                        $approve[] = $item;
                    }
                    else if($item->action_name === 'reject'){
                        $reject[] = $item;
                    }
                    $all[] = $item;
                }
                if($task_type == 'out'){
                    $this->response->data = (strtolower($approve_reject) == 'approve')?$approve:$reject;
                }
                else if($task_type === 'in'){
                    $this->response->data = $all;
                }
                $this->data['active_tab'] = ($task_type == "in" || $task_type == "")?"incoming":$approve_reject;

            }
        }
        $this->data['response'] = $this->response;
        return $this->view();
    }
    
    //view application for receipt and display details
    public function applicationDetails(){
        $this->response = new Response();
        $params = $this->getParams();
        
        $user_info = $_SESSION['user_info'];
        $this->data['role_id'] = $role_id = $user_info['role_id'];
        $this->data['tasks_id'] = $tasks_id = $_SESSION['tasks_id'];
        
        $task = new Tasks();
        $task = $task->find($tasks_id);
        $app = new Application();
        if(sizeof($params)==0){
            $this->response->set([
                "msg"=>"Invalid request.",
                "error"=>"Application id is not passed."
            ]);
        }
        else if($task === null){
            $this->response->set([
                "msg"=>"Invalid request.",
                "error"=>"Invalid task id."
            ]);
        }
        else if(!$task->isRoleAllowed($role_id)){
            $this->response->set([
                "msg"=>"You have no access right.",
                "error"=>"User role is not allowed to access this task."
            ]);
        }
        else if($app->find($params[0]) === null){
            $this->response->set([
                "msg"=>"Invalid application ID",
                "error"=>"User role is not allowed to access this task."
            ]);
        }
        else{
            $this->data['application_id'] = $application_id = $params[0];
            $this->data['process_id'] = $app->getProcessId();
            $this->response = getLatestApplicationDetails($task::$conn, $application_id);
            if($this->response->status){
                $app = $this->response->data;
            }
        }
        
        $this->data['response'] = $this->response;
        return $this->view();
    }
    
    public function applicationTasksLog(){
        $this->applications = new Application();
        //defining action values
        $action_values = ["create","approve","forward","reject"];
        
        $input_data = $this->_cleanInputs($_POST);
        
        $response = verifyCSRFToken();
        if($response->status == false){
            return $this->sendResponse($response);
        }
        $this->response->status_code = 403;//Bad Request
        if(sizeof($input_data) == 0){
            $this->response->set([
                "msg"=>"No input perameters."
            ]);
        }
        else if(!isset($input_data['application_id']) || $input_data['application_id']===""){
            $this->response->set([
                "msg"=>"Missing application ID"
            ]);
        }
        else if($this->applications->find($input_data['application_id']) === null){
            $this->response->set([
                "msg"=>"Application id is invalid"
            ]);
        }
        else if(!isset($input_data['tasks_id']) || $input_data['tasks_id']===""){
            $this->response->set([
                "msg"=>"Missing Tasks Id"
            ]);
        }
        else if(!isset($input_data['action_name']) || $input_data['action_name']===""){
            $this->response->set([
                "msg"=>"Missing Action name"
            ]);
        }
        else if(!in_array($input_data['action_name'],$action_values)){
            $this->response->set([
                "msg"=>"Invalid action name"
            ]);
        }
        else{
            $user_info = $_SESSION['user_info'];
            $user_id = $user_info['user_id'];
            $application_id = $input_data['application_id'];
            $tasks_id = $input_data['tasks_id'];
            $this->applications = $this->applications->find($application_id);
            //process id = 1 is for application for non order copy whereas 2 for order copy
            $process_id = $this->applications->getProcessId();//getProcessId
            $action_name = $input_data['action_name'];
            $remark = isset($input_data['remark'])??"";
            $this->response = insertApplicationTasksLog(Database::connect(), $application_id, $user_id, $action_name, $tasks_id, $process_id,$remark);
        }
        return $this->sendResponse($this->response);
    }
    
    public function uploadDocument(){
        $this->response = new Response();
        if(!Logins::isAuthenticated()){
            return $this->response->set([
                "msg"=>"Session expired, please login",
                "status_code"=>400
            ]);
        }
        
        $input_data = $this->_cleanInputs($_POST);
        
        if(!isset($input_data['application_id'])){
            return $this->response->set([
                "msg"=>'Invalid request.',
                "status_code"=>403
            ]);
        }
        
        /**** File Upload part ****/
        $application_id = $input_data['application_id'];
        $tasks_id = $input_data['tasks_id'];
        $upload_directory = UPLOAD_PATH."/documents/certificate/".$application_id."/";
        $file_upload = new Upload();
        $file_upload->setFileUploadKeyName("file-to-upload");
        $this->response = $file_upload->uploadSingleFile($upload_directory);
        //if upload is not successful
        if(!$this->response->status){
            return $this->sendResponse($this->response);
        }
        
        
        $user_info = $_SESSION['user_info'];
        $user_id = $user_info['user_id'];
        $file_path = $this->response->data['file_paths'][0];
        $document = new Document();
        $document->application_id = $application_id;
        $document->document_path = $file_path;
        $document->created_by = $user_id;
        $document::$conn->beginTransaction();
        $this->response = $document->add();
        $application = new Application();
        $application = $application->find($application_id);
        $process_id = $application->getProcessId();
        $remark = "Certificate upload.";
        if(!$this->response->status){
            return $this->sendResponse($this->response);
        }
        
        $this->response = insertApplicationTasksLog($document::$conn, $application_id, $user_id, "forward", $tasks_id, $process_id, $remark);
        if(!$this->response->status)
        {
            $document::$conn->rollback();
        }
        else{
            $document::$conn->commit();
        }
        return $this->sendResponse($this->response);
    }
    
    //load file for viewing
    public function displayFile(){
        $params = $this->getParams();
        if(sizeof($params)){
            $document_id = $params[0];
            $document = new Document();
            $document = $document->find($document_id);
            if($document!==null){
                //$casebody->loadFile();
                downloadFile($document->document_path,false);
            }
        }
    }
    
    public function downloadDocument(){
        $params = $this->getParams();
        if(sizeof($params)){
            $document_id = $params[0];
            $document = new Document();
            $document = $document->find($document_id);
            if($document !== null){
                downloadFile($document->document_path,true);
            }
        }
    }
    public function previewDocument(){
        $params = $this->getParams();
        if(sizeof($params)){
            $document_id = $params[0];
            $document = new Document();
            $document = $document->find($document_id);
            if($document !== null){
                downloadFile($document->document_path,false);
            }
        }
    }
    
}
