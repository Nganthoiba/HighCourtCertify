<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TaskController
 *
 * @author Nganthoiba
 */
class TaskController extends Controller{
    public function __construct($data = array ()) {
        parent::__construct($data);
        if(!Logins::isAuthenticated() || Logins::getRoleName()!=="Admin"){
            $this->redirect("Account", "Login");
        }
    }

    public function getTasks(){
        $task = new Tasks();
        $resp = $task->read([],[],'tasks_id');
        if($resp->status){
            $tasks = $resp->data;
            $temp = array();
            foreach ($tasks as $task){
                $task->mapped_roles = $task->getMappedRoles($task->tasks_id);
                $temp[] = $task;
            }
            $resp->data = $temp;
        }
        return $this->sendResponse($resp);
    }
    
    public function createTask(){
        
        $this->data['resp_msg'] = "";
        $input_data = $this->_cleanInputs($_POST);
        if(sizeof($input_data)){
            $this->response = verifyCSRFToken();
            if($this->response->status === false){
                return $this->sendResponse($this->response);
            }
                //{"tasks_name":"","tasks_description":"","roles":["1","12","2","18","3"]}
            $this->response = $this->validateTask($input_data,"create");
            if($this->response->status === false){
                return $this->sendResponse($this->response);
            }
            
            $task = new Tasks();
            $task->tasks_name = $input_data['tasks_name'];
            $task->tasks_description = $input_data['tasks_description'];
            $user_info = $_SESSION['user_info'];
            $task->user_id = $user_info['user_id'];
            $task::$conn->beginTransaction();
            $this->response = $task->add();
            if($this->response->status === true){
                //Map roles with the tasks 
                $roles = isset($input_data['roles']) && is_array($input_data['roles'])?$input_data['roles']:array();
                $this->response = $task->mapTaskWithRoles($task::$conn,$task->tasks_id, $roles);
                if($this->response->status === false){
                    $task::$conn->rollback();
                }
            }
            $task::$conn->commit();
            $this->response->msg = "Task has been created and ".$this->response->msg;
            return $this->sendResponse($this->response);
        }
        $role = new Role();
        $this->data['response'] = $role->readAll();
        return $this->view();
    }
    
    //action for viewing created task
    public function viewTasks(){
        $task = new Tasks();
        $roles = new Role();
        $resp = $task->read();
        if($resp->status){
            $tasks = $resp->data;
            $temp = array();
            foreach ($tasks as $task){
                $task->mapped_roles = $task->getMappedRoles($task->tasks_id);
                $temp[] = $task;
            }
            $resp->data = $temp;
        }
        $this->data['response_tasks'] = $resp;
        $this->data['response_roles'] = $roles->readAll();
        return $this->view();
    }
    
    //public class to update Task
    public function updateTask(){
        $input_data = $this->_cleanInputs($_POST);
        if(sizeof($input_data)){
            $this->response = verifyCSRFToken();
            if($this->response->status === false){
                return $this->sendResponse($this->response);
            }
                //{"tasks_name":"","tasks_description":"","roles":["1","12","2","18","3"]}
            $this->response = $this->validateTask($input_data,"update");
            if($this->response->status === false){
                return $this->sendResponse($this->response);
            }
            
            $task = new Tasks();
            $task = $task->find($input_data['tasks_id']);
            $task->tasks_name = $input_data['tasks_name'];
            $task->tasks_description = $input_data['tasks_description'];
            $user_info = $_SESSION['user_info'];
            $task->user_id = $user_info['user_id'];
            $task::$conn->beginTransaction();
            $this->response = $task->save();
            if($this->response->status === true){
                //Map roles with the tasks
                $roles = isset($input_data['roles']) && is_array($input_data['roles'])?$input_data['roles']:array();
                $this->response = $task->mapTaskWithRoles($task::$conn,$task->tasks_id, $roles);
                if($this->response->status === false){
                    $task::$conn->rollback();
                    $this->response->msg = "Failed to update.";
                }
                else{
                    $task::$conn->commit();
                    $this->response->msg = "Successfully updated.";
                }
            }
            
        }
        else{
            $this->response->set([
                "status"=>false,
                "msg"=>"No input parameter.",
                "status_code"=>403
            ]);
        }
        return $this->sendResponse($this->response);
    }
    
    public function removeTask(){
        $params = $this->getParams();
        if(sizeof($params) == 0){
            $this->response->set([
                "status_code"=>403,
                "msg"=>"invalid request"
            ]);
            return $this->sendResponse($this->response);
        }
        $this->response = verifyCSRFToken();
        if($this->response->status === false){
            return $this->sendResponse($this->response);
        }
        
        $tasks_id = $params[0];
        $tasks = new Tasks();
        $tasks = $tasks->find($tasks_id);
        if($tasks == null){
            $this->response->set([
                "status_code"=>404,
                "msg"=>"Task to be removed is not found."
            ]);
            return $this->sendResponse($this->response);
        }
        $this->response = $tasks->remove();
        return $this->sendResponse($this->response);
    }

    //action for process and task mapping
    public function ProcessTaskMapping(){
        $process = new Process();
        $process_list = $process->read()->toList();
        $this->data['processes'] = $process_list;
        return $this->view();
    }
    
    public function readProcessTasksMapping(){
        if(Logins::getRoleName()!== "Admin"){
            redirectTo();// redirecting to proper page
        }
        
        $params = $this->getParams();
        if(sizeof($params) == 0){
            $this->response->set([
                "msg"=>"Invalid Request",
                "status_code"=>403
            ]);
            return $this->sendResponse($this->response);
        }
        $process_id = trim($params[0]);
        $processTasksMapping = new Process_Tasks_Mapping();
        $this->response = $processTasksMapping->readTasksProcessMap($process_id);
        return $this->sendResponse($this->response);
    }
    
    public function saveProcessTasksMapping(){
        $input_data = $this->_cleanInputs($_POST);
        //Validation
        if(!isset($input_data['pid']) || $input_data['pid']===""){
            $this->response->set([
                "status"=>false,
                "status_code"=>403,
                "msg"=>"Invalid request."
            ]);
            return $this->sendResponse($this->response);
        }
        
        $included_tasks = !isset($input_data['included'])?array():$input_data['included'];
        $excluded_tasks = !isset($input_data['excluded'])?array():$input_data['excluded'];
        
        if(sizeof($included_tasks) === 0 && sizeof($excluded_tasks) === 0){
            $this->response->set([
                "status"=>false,
                "status_code"=>403,
                "data"=>["included"=>$included_tasks,"excluded"=>$excluded_tasks],
                "msg"=>"Invalid request. Set which tasks are to be included or which are not to be included."
            ]);
            return $this->sendResponse($this->response);
        }
        //end validation
        
        $process_id = $input_data['pid'];
        $Process_Tasks_Mapping = new Process_Tasks_Mapping();
        $Process_Tasks_Mapping->process_id=$process_id;
        $this->response = $Process_Tasks_Mapping->setTasksProcessMap($included_tasks);
        
        return $this->sendResponse($this->response);
    }
    // end of action for process and task mapping
    
    //This function will validate whether tasks to be inserted or updated is valid or not
    private function validateTask($data,$action="create"){
        $this->response = new Response();
        if(!isset($data['tasks_name']) || $data['tasks_name'] === ""){
            $this->response->set([
                "msg" => "Missing task name.",
                "status_code"=>403
            ]);
        }
        else if(!isset($data['tasks_description']) || $data['tasks_description'] === ""){
            $this->response->set([
                "msg" => "Missing task description.",
                "status_code"=>403
            ]);
        }
        /*
        else if(!isset($data['roles']) || sizeof($data['roles'])==0){
            $this->response->set([
                "msg" => "Missing user roles.",
                "status_code"=>403
            ]);
        }
        */
        else if($action === "update" && (!isset($data['tasks_id']) || $data['tasks_id'] === "")){
            $this->response->set([
                "msg" => "Missing Task Id.",
                "status_code"=>403
            ]);
        }
        else{
            $this->response->set([
                "msg" => "Valid",
                "status_code"=>200,
                "status"=>true
            ]);
        }
        return $this->response;
    }
    
    
}
