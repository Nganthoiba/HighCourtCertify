<?php
/**
 * Description of ApplicationController
 *  
 * @author Nganthoiba
 */
class ApplicationController extends Controller{
    public $applications;
    private $request;
    public function __construct($data = array()) {
        parent::__construct($data);
        if(!Logins::isAuthenticated()){
            $this->redirect("Account", "Login");
        }
        $this->applications = new Application();
        $this->response = new Response();
        $this->request = new Request();
    }
    public function index(){
        $this->viewData->total_request = Application::count("all");
        $this->viewData->completed_request = Application::count("completed");
        $this->viewData->pending_request = Application::count("pending");
        $this->viewData->totalApplicants = Users::count();
        
        return $this->view();
    }
    
    public function viewApplications(){
        $user_id = "";
        /* Check user is authenticated */
        if(Logins::isAuthenticated() && (strtolower(Logins::getRoleName())=="applicant" || strtolower(Logins::getRoleName())=="admin")){
            
            $user_id = Logins::getUserId();
        }
        else{
            //redirect to login page if user is not authenticated
            $this->redirect("Account", "login");
        }
        
        $application = new Application();
        $list = $application->readAppTasksLog($user_id);
        $this->viewData->applications = $list->data;
        $this->viewData->user_id = $user_id;
        $this->viewData->selectedApplicationId = sizeof($this->getParams())?trim(($this->getParams())[0]):"";
        //$this->data['applications'] = $list->data;
        //$this->data['user_id'] = $user_id;
        return $this->view();
    }
    public function viewOfflineApplications(){
        $user_id = "";
        /* Check user is authenticated */
        if(Logins::isAuthenticated()){
            $user_id = Logins::getUserId();
        }
        else{
            //redirect to login page if user is not authenticated
            $this->redirect("Account", "login");
        }
        
        $application = new Application();
        $list = $application->readAppTasksLog($user_id,"y");
        
        $this->data['applications'] = $list->data;
        $this->data['user_id'] = $user_id;
        return $this->view();
    }
    
    public function getCertificateCopyTypes(){
        $copy_type = new copy_type();
        try{
            $copy_type_list = $copy_type->read()->orderBy("copy_type_id")->toList();
            if($copy_type_list == null){
                $this->response->set([
                    "status"=>false,
                    "status_code"=>404,
                    "msg"=>"No data found."
                ]);
            }
            else{
                $this->response->set([
                    "status"=>true,
                    "status_code"=>200,
                    "msg"=>"List of copy types.",
                    "data"=>$copy_type_list
                ]);
            }
        }
        catch (Exception $e){
            $this->response->set([
                    "status"=>false,
                    "status_code"=>500,
                    "msg"=>"An error occurs: ".$e->getMessage()
                ]);
        }
        return $this->sendResponse($this->response);
    }
    
    /*** validation function for application */
    public function apply(){
        $user_id = "";
        /* Check user is authenticated */
        if(Logins::isAuthenticated()){
            $user_id = Logins::getUserId();
        }
        else{
            //redirect to login page if user is not authenticated
            $this->redirect("Account", "login");
        }
        
        if($this->request->isMethod("POST")){
            $data = $this->_cleanInputs($this->request->getData());
            
            $response = verifyCSRFToken();
            if($response->status == false){
                return $this->sendResponse($response);
            }
            
            $copy_type_id = isset($data['copy_type_id'])?$data['copy_type_id']:""; //Copy Type
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
            $third_party_reason = $data['third_party_reason'];
            
            $is_offline = isset($data['is_offline'])?$data['is_offline']:"n";
            
            //if application is submitted in offline mode i.e. is_offline=y, then 
            $aadhaar = isset($data['aadhaar'])?str_replace(" ","",$data['aadhaar']):""; //Aadhaar for applicant
            $applicant_name = isset($data['applicant_name'])?$data['applicant_name']:""; 
            
            $submit_date = date('Y-m-d H:i:s');
            $validationResponse = $this->validateApplicationData($data);
            if(!$validationResponse->status)
            {  
                return $this->sendResponse($validationResponse);
            } 
            
            $applicationModel = new Application();
            $applicationModel->application_id = $applicationModel->generateID();//UUID::v4();

            $applicationModel->case_no = $case_no;
            $applicationModel->case_type_id = $case_type;
            $applicationModel->case_year = $case_year;

            $applicationModel->case_no_reference = $case_no_reference;
            $applicationModel->case_type_reference = $case_type_reference;
            $applicationModel->case_year_reference = $case_year_reference;

            $applicationModel->certificate_type_id = $certificate_type_id;
            $applicationModel->copy_type_id = $copy_type_id;
            $applicationModel->create_at = $submit_date;
            $applicationModel->order_date = $order_date;
            $applicationModel->petitioner = $appel_petitioner;
            $applicationModel->respondent = $respondant_opp;
            $applicationModel->user_id = $user_id;
            $applicationModel->is_third_party = $is_third_party;

            $applicationModel->is_offline = $is_offline;

            $applicationModel->is_order = $applicationModel->copy_type_id==1?"y":"n";

            $applicationModel->getQueryBuilder()->beginTransaction();
            
            $this->response = $applicationModel->add();
            
            if($this->response->status_code!=200){
                $this->response->msg = "Failed to insert record";
                return $this->sendResponse($this->response);
            }
            
            /**** inserting record in application tasks log ***/
            $tasks_id = 1;//Task id for applying a new copy
            $process_id = $applicationModel->getProcessId();//process_id =2 for order copy whereas 1 for non order copy
            $remark = "Submit a new application.";
            $app_log_resp = insertApplicationTasksLog(EasyQueryBuilder::$conn, $applicationModel->application_id, $applicationModel->user_id, "create", $tasks_id, $process_id, $remark);
            if(!$app_log_resp->status){
                $applicationModel->getQueryBuilder()->rollbackTransaction();
                return $this->sendResponse($app_log_resp);
            }
            
            /*** if the applicant is third party ***/
            if($applicationModel->is_third_party === "y"){
                //Reason for requesting certificate by third party applicant
                $third_party_app_reason = new third_party_applicant_reasons();
                $third_party_app_reason->application_id = $applicationModel->application_id;
                $third_party_app_reason->reason = $third_party_reason;
                $third_party_app_reason->third_party_application_reasons_id = $third_party_app_reason->findMaxColumnValue("third_party_application_reasons_id")+1;
                $third_party_resp = $third_party_app_reason->add();
                if($third_party_resp->status_code !== 200){
                    $applicationModel->getQueryBuilder()->rollbackTransaction();
                    return $this->sendResponse($third_party_resp);
                }
            }
            
            /*** If application is submitted in offline mode ****/
            if($applicationModel->is_offline === "y"){
                $offline_app = new offline_application();

                $offline_app->offline_application_id = $offline_app->findMaxColumnValue("offline_application_id")+1;
                $offline_app->applicant_name = $applicant_name;
                $offline_app->aadhaar = $aadhaar;
                $offline_app->application_id = $applicationModel->application_id;
                $offline_response = $offline_app->add();
                if(!$offline_response->status){
                    $applicationModel->getQueryBuilder()->rollbackTransaction();
                    return $this->sendResponse($offline_response);
                }
            }
            
            $applicationModel->getQueryBuilder()->commitTransaction();
            $this->response->msg = "You have submitted your application.";
            $this->response->data = $applicationModel;
            return $this->sendResponse($this->response);
        }
        
        //to read certificate type whether certify, uncertify, certify urgent or uncertify urgent
        $certificate_type = new certificate_type();
        $certificate_list = $certificate_type->read()->orderBy("certificate_type_id")->toList();
        $this->data['certificate_list'] = $certificate_list;
        
        /***** getting copy type ****/
        $copy_type = new copy_type();
        $this->data['copy_type_list'] = $copy_type->read()->orderBy("copy_type_id")->toList();
        
        /**** Getting case type *****/
        $caseType = new case_type();
        $this->data['case_type_list'] = $caseType->read(['case_type_id','type_name','full_form'])->orderBy('type_name')->toList();
        
        $third_party_reasons = new third_party_reasons();
        $this->data['third_party_reasons'] = $third_party_reasons->read()->orderBy("third_party_reasons_id")->toList();
        
        return $this->view();
    }
    
    public function viewDetails(){
        //$user_info = $_SESSION['user_info'];
        //$role_id = $user_info['role_id'];
        
        $this->data['msg'] = "";
        $this->data['status'] = false;
        $param = $this->getParams();
        if(sizeof($param)){
            $application_id = $param[0];
            $process_id = $param[1]??"";
            $this->data['process_id'] = $process_id;
            $application = new Application();
            $application = $application->find($application_id);
            if($application == null){
                $this->data['status'] = false;
                $this->data['msg'] = "Application not found!";
            }
            else{
                $this->data['status'] = true;
                $this->data['application'] = $application;
                /* First check if application is submitted in offline mode */
                if($application->is_offline === "y"){
                    $offline_app = new offline_application();
                    $qry_builder = $offline_app->read()->where([
                        "application_id"=>["=",$application->application_id]
                    ]);
                    $offline_app = $qry_builder->getFirst();
                    $qry = $qry_builder->getQuery();
                    $application->applicant_name = $offline_app !== null?$offline_app->applicant_name:"Not found!";
                }
                else{
                    $user = new Users();
                    $user = $user->find($application->user_id);
                    $application->applicant_name = $user->full_name;
                }
            }
        }
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
            $conn = Database::connect();
            $this->response = getApplicationTasksHistory($conn,$tasks_id,$task_type);
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
            $user_id = Logins::getUserId();
            $application_id = $input_data['application_id'];
            $tasks_id = $input_data['tasks_id'];
            $process_id = $this->applications->getProcessId();//getProcessId
            $action_name = $input_data['action_name'];
            $remark = isset($input_data['remark'])?$input_data['remark']:"";          
            
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
        
        $user_id = Logins::getUserId();
        
        $file_path = $this->response->data['file_paths'][0];
        $document = new Document();
        $document->application_id = $application_id;
        $document->document_path = $file_path;
        $document->created_by = $user_id;
        $document->getQueryBuilder()->beginTransaction();
        $this->response = $document->add();
        $application = new Application();
        $application = $application->find($application_id);
        $process_id = $application->getProcessId();
        $remark = "Certificate upload.";
        if(!$this->response->status){
            return $this->sendResponse($this->response);
        }
        $this->response = insertApplicationTasksLog($document->getQueryBuilder()::$conn, $application_id, $user_id, "forward", $tasks_id, $process_id, $remark);
        if(!$this->response->status)
        {
            $document->getQueryBuilder()->rollbackTransaction();
        }
        else{
            $document->getQueryBuilder()->commitTransaction();
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
    public function downloadOfflinePayslip(){
        $params = $this->getParams();
        if(sizeof($params)){
            $application_id = $params[0];
            $offline_payment_receipt = new offline_payment_receipt();
            $receipt = $offline_payment_receipt->read()->where([
                "application_id"=>$application_id
            ])->getFirst();
            //$offline_payment_receipt = $offline_payment_receipt->find($offline_payment_receipt_id);
            if($receipt !== null){
                downloadFile($receipt->receipt_path,true);
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
    
    public function offlineEntry(){
        //to read certificate type whether certify, uncertify, certify urgent or uncertify urgent
        $certificate_type = new certificate_type();
        $certificate_list = $certificate_type->read()->orderBy("certificate_type_id")->toList();
        $this->data['certificate_list'] = $certificate_list;
        
        /***** getting copy type ****/
        $copy_type = new copy_type();
        $this->data['copy_type_list'] = $copy_type->read()->orderBy("copy_type_id")->toList();
        
        /**** Getting case type *****/
        $caseType = new case_type();
        $this->data['case_type_list'] = $caseType->read(['case_type_id','type_name','full_form'])->orderBy('type_name')->toList();
        
        $third_party_reasons = new third_party_reasons();
        $this->data['third_party_reasons'] = $third_party_reasons->read()->orderBy("third_party_reasons_id")->toList();
        
        return $this->view();
    }
    
    public function barchartInfo(){
        $year = sizeof($this->getParams())?$this->getParams()[0]:0;
        if($year == 0){
            $this->response->set([
                "status"=>false,
                "status_code"=>500,
                "msg"=>"Please pass the year"
            ]);
        }
        else{
            $this->response->set([
                "status"=>true,
                "status_code"=>200,
                "msg"=>"Month wide data collection",
                "data" => Application::barchartInfo($year)
            ]);
        }
        return $this->sendResponse($this->response);
    }
    
    private function validateApplicationData($data): Response{
        $copy_type_id = isset($data['copy_type_id'])?$data['copy_type_id']:""; //Copy Type
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
        $third_party_reason = $data['third_party_reason'];

        $is_offline = isset($data['is_offline'])?$data['is_offline']:"n";

        //if application is submitted in offline mode i.e. is_offline=y, then 
        $aadhaar = isset($data['aadhaar'])?str_replace(" ","",$data['aadhaar']):""; //Aadhaar for applicant
        $applicant_name = isset($data['applicant_name'])?$data['applicant_name']:"";
        
        $this->response->status_code = 403;//Bad Request
        if($is_offline === "y" && trim($aadhaar) === ""){
            $this->response->msg = 'Aadhaar number of the applicant is required for offline entry.';
            $this->response->status = false;            
        }
        else if($is_offline === "y" && trim($applicant_name) === ""){
            $this->response->msg = 'Name of the applicant is required for offline entry.';
            $this->response->status = false;
        }
        else if(trim($case_type) == "")
        {
            $this->response->msg = 'Please select case type ';
            $this->response->status = false;
        }
        else if(trim($case_no) == "")
        {
            $this->response->msg = 'Please fill case no ';
            $this->response->status = false;
        }
        else if(trim($case_year) == "")
        {
            $this->response->msg = 'Please fill case year ';
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
        else if($is_third_party === "y" && $third_party_reason===""){
            $this->response->msg = 'Please enter reason.';
            $this->response->status = false;
        }
        else if($copy_type_id === ""){
            $this->response->msg = 'Please select Certificate Copy type.';
            $this->response->status = false;
        }
        else{
            $this->response->msg = 'Validated';
            $this->response->status = true;
            $this->response->status_code = 200;
        }
        /*************End input validation ***************/
        return $this->response;
    }
    
}
