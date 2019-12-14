<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoleController
 *
 * @author Nganthoiba
 */
class RoleController extends Controller{
    //these modules are only for admin
    public function addRoles(){
        if(!Logins::isAuthenticated() || Logins::getRoleName() != "Admin"){
            redirectTo();
        }
        $role = new Role();
        $data = $this->_cleanInputs($_POST);
        $this->data['addRoleResponse'] = "";
        if(isset($data['role_name']) && trim($data['role_name'])!==""){
            $role->role_name = $data['role_name'];
            $add_result= $role->add();
            $this->data['addRoleResponse']=$add_result->msg;
        }
        
        $res = $role->read();
        $this->data['roles'] = $res->data;
        return $this->view();
    }
    /*
    public function edit(){
        if(!Logins::isAuthenticated() || Logins::getRoleName() != "Admin"){
            redirectTo();
        }
        $param = $this->getParams();
        $role = new roles();
        $this->data['msg']="";
        if(sizeof($param)){
            $role_id = $param[0];
            $role = $role->find($role_id);
            $this->data['role'] = $role;
        }
        else{
            $this->data['msg'] = "Invalid request";
        }
        //if there is post data
        $data = $this->_cleanInputs($_POST);
        if(sizeof($data)){
            if(isset($data['role_name']) && isset($data['roles_id'])){
                $res = $this->updateRole($data['roles_id'],$data['role_name']);
                $this->data['msg'] = $res['msg'];
                if($res['status_code'] == 200){
                    $role->roles_id = $data['roles_id'];
                    $role->role_name = $data['role_name'];
                    $this->data['role'] = $role;
                }
            }
        }
        return $this->view();
    }
    */
    public function remove(){
        if(!Logins::isAuthenticated() || Logins::getRoleName() != "Admin"){
            redirectTo();
        }
        $param = $this->getParams();
        $this->data['msg'] = "";
        $this->data['role'] = null;
        if(sizeof($param)){
            $role_id = $param[0];
            $role = new Role();
            $role = $role->find($role_id);
            if($role == null){
                $this->data['msg'] = "Role does not exist.";
            }
            $this->data['role']=$role;
        }
        else{
            $this->data['msg'] = "Invalid request";
        }
        return $this->view();
    }
    
    public function confirmRemove(){
        if(!Logins::isAuthenticated() || Logins::getRoleName() != "Admin"){
            redirectTo();
        }
        $this->data['msg'] = "";
        $data = $this->_cleanInputs($_POST);
        if(isset($data['role_id'])){
            $role_id = $data['role_id'];
            $role = new Role();
            $role = $role->find($role_id);
            if($role == null){
                $this->data['msg'] = "Role does not exist.";
            }
            else{
                $res = $role->remove();
                $this->data['msg'] = $res->msg;
            }
        }
        return $this->view();
    }
    
    public function processRoleMapping(){
        
        if(Logins::getRoleName()!== "Admin"){
            redirectTo();// redirecting to proper page
        }
        $input_data = $this->_cleanInputs($_POST);
        if(isset($input_data['action'])){
            
            $response = new Response();
            $model = new model();
            $obj = new ProcessRoleMap(model::$conn);
            
            $action = $input_data['action'];
            model::$conn->beginTransaction();
            switch($action){
                case 'getprocess':
                    $response = ($obj->get_process());
                    break;
                case 'getprocessrolemap':
                    $process_id = $input_data['pid']??'';
                    $response =  ($obj->get_Process_Role_Map($process_id));
                    break;
                case 'setprocess':
                    $process_id = $input_data['pid']??'';
                    if($process_id==""){
                        //$response =  array('status'=>0, 'msg'=> 'Please select a process');
                        $response->msg = 'Please select a process';
                    }
                    else{
                        $data = $input_data['data']??array("included"=>"","excluded"=>"");
                        $response =  ($obj->set_Process_Role_Map($process_id,$data));
                    }
                    break;
                default : 
                    //$response =  (array('status'=>0, 'msg'=> 'Bad Request'));
                    $response->msg = 'Bad Request';
                    $response->status_code=403;
            }
            if($response->status){
                model::$conn->commit();
            }
            else {
                model::$conn->rollback();
            }
            
            return $this->send_data($response,$response->status_code);
        }

        $process = new Process();
        $res = $process->read();
        $this->data['processes'] = $res->data;
        return $this->view();
    }
    
    /*
    private function updateRole($role_id, $role_name){
        $role = new roles();
        $role->role_name = $role_name;
        $role->role_id = $role_id;
        return $role->save();
    }
    */
}
