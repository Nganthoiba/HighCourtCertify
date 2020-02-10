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
            $response = verifyCSRFToken();//verifying csrf token
            if($response->status == false){
                $this->data['addRoleResponse']=$response->msg;
            }
            else{
                $role->role_name = $data['role_name'];
                $add_result= $role->add();
                $this->data['addRoleResponse']=$add_result->msg;
            }
        }
        
        $res = $role->read();
        $this->data['roles'] = $res->data;
        return $this->view();
    }
    
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
}
