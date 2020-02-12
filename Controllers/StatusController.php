<?php
/**
 * Description of StatusController
 *
 * @author Nganthoiba
 */
class StatusController extends Controller{
    private $request;
    public function __construct($data = array ()) {
        parent::__construct($data);
        $this->response = new Response();
        $this->request = new Request();
    }
    
    public function getStatus(){
        $status = new Status();
        $status_list = $status->read()->toList();
        $this->response->set([
            "data"=>$status_list,
            "status"=>($status_list==null)?false:true,
            "status_code"=>($status_list==null)?404:200,
            "msg"=>($status_list==null)?"No status found.":"Application status list"
        ]);
        return $this->sendResponse($this->response);
    }
    
    public function submitStatus(){
        if($this->request->isMethod("POST")){
            $input_data = $this->_cleanInputs($this->request->getData());
            $status = new Status();
            $status->status_id = $status->findMaxColumnValue("status_id")+1;
            $status->description = $input_data['description'];
            $status->application_id = $input_data['application_id'];
            $status->created_at = date("Y-m-d H:i:s");
            $status->user_id = Logins::getUserId();
            $this->response = $status->add();
        }
        else{
            $this->response->set([
                "status"=>false,
                "msg"=>"Invalid request",
                "status_code"=>403
            ]);
        }
        return $this->sendResponse($this->response);
    }
    
    public function viewStatus(){
        $param = $this->getParams();
        if(!isset($param[0]) || trim($param[0])===""){
            //don't do anything
            $this->response->set([
                "status"=>false,
                "msg"=>"Missing application ID",
                "status_code"=>403
            ]);
        }
        else{
            $application_id = $param[0];
            $app = new Application();
            $app = $app->find($application_id);
            if($app !== null){
                $appHistResp = getApplicationHistory($application_id);
                $stepsOfProcess = getProcessSteps($application_id);
                
                $this->response->set([
                    "status"=>true,
                    "msg"=>"Application status",
                    "status_code"=>404,
                    "data"=>[
                        "application_id"=>$application_id,
                        "stepsOfProcess"=>$stepsOfProcess,
                        "application_log_hist"=>($appHistResp->status==true)?$appHistResp->data:array()
                    ]
                ]);
            }
            else{
                $this->response->set([
                    "status"=>false,
                    "msg"=>"Application not found",
                    "status_code"=>404
                ]);
            }
        }
        $this->data['response'] = $this->response;
        return $this->view();
    }
}
