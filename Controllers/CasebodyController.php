<?php
/**
 * Description of CasebodyController
 *
 * @author Nganthoiba
 */
class CasebodyController extends Controller{
    public function __construct($data = array ()) {
        parent::__construct($data);
        $this->response = new Response();
    }
    public function uploadCaseBody(){
        if(!Logins::isAuthenticated()){
            $this->response->set([
                "msg"=>"Please login and try again.",
                "status_code"=>400
            ]);
            return $this->sendResponse($this->response);
        }
        
        $input_data = $this->_cleanInputs($_POST);
        if(sizeof($input_data) === 0){
            $this->response->set([
                "msg"=>"No input data",
                "status_code"=>400
            ]);
            return $this->sendResponse($this->response);
        }
        
        $this->response = verifyCSRFToken();
        if(!$this->response->status){
            return $this->sendResponse($this->response);
        }
        //$application_id = $input_data['application_id'];

        //input validation for case body data
        $this->response = $this->validateCasebody($input_data);
        if(!$this->response->status){
            return $this->sendResponse($this->response);
        }
        
        $upload_directory = UPLOAD_PATH."/documents/case_body/".$input_data['case_number']."_".$input_data['case_year']."_".$input_data['case_type_id']."/";
        $file_upload = new Upload();
        $file_upload->setFileUploadKeyName("case_body_file");
        $this->response = $file_upload->uploadSingleFile($upload_directory);
        if(!$this->response->status){
            return $this->sendResponse($this->response);
        }
        
        $user_info = $_SESSION['user_info'];
        $user_id = $user_info['user_id'];
        
        $casebody = new Casebody();
        $casebody->case_number = $input_data['case_number'];
        $casebody->case_year = $input_data['case_year'];
        $casebody->case_type_id = $input_data['case_type_id'];
        $casebody->document_path = $this->response->data['file_paths'][0];
        $casebody->created_by = $user_id;
        
        $this->response = $casebody->add();
        if($this->response->status){
            $this->response->msg = "Case body has been created.";
        }
        return $this->sendResponse($this->response);
    }
    //load file for viewing
    public function displayFile(){
        $params = $this->getParams();
        if(sizeof($params)){
            $casebody_id = $params[0];
            $casebody = new Casebody();
            $casebody = $casebody->find($casebody_id);
            if($casebody!=null){
                //$casebody->loadFile();
                downloadFile($casebody->document_path,false);
            }
        }
    }
    
    //method to download case body file
    public function downloadFile(){
        $params = $this->getParams();
        if(sizeof($params)){
            $casebody_id = $params[0];
            $casebody = new Casebody();
            $casebody = $casebody->find($casebody_id);
            if($casebody!=null){
                downloadFile($casebody->document_path,true);
            }
        }
    }
    
    //function to validate case body
    private function validateCasebody($input_data = array()){
        if(!isset($input_data['case_type_id']) || !isset($input_data['case_number']) || !isset($input_data['case_year'])){
            $this->response->set([
                "status"=>false,
                "status_code"=>400,
                "msg"=>"Missing input perameters"
            ]);
        }
        else{
            $casebody = new Casebody();
            $res = $casebody->isCaseBodyExist($input_data['case_type_id'], $input_data['case_number'], $input_data['case_year']);
            if($res){
                $this->response->set([
                    "status"=>false,
                    "status_code"=>403,
                    "msg"=>"Case body already exist."
                ]);
            }
            else{
                $this->response->set([
                    "status"=>true,
                    "status_code"=>200,
                    "msg"=>"validated"
                ]);
            }
        }
        return $this->response;
    }
}
