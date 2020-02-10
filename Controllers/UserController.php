<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @author Nganthoiba
 */
class UserController extends Controller{
    public $resp;
    public function __construct($data = array()) {
        parent::__construct($data);
        $this->resp = new Response();
    }
    public function viewUsers(){
        if(Logins::getRoleName()!="Admin"){
            redirectTo();
        }
        $users = new Users();//creating user model
        $columns = array(
                'user_id' , 
                'full_name' ,     
                'email'  ,        
                'phone_number'  ,     
                'role_id',        
                'role_name',        
                'user_password',  
                'verify',         
                'create_at',     
                'update_at',      
                'delete_at',      
                'profile_image',  
                'aadhaar',        
                'update_by');
        $cond = "role_name != 'Admin' ";//array();
        $res = $users->read($columns,$cond, ["full_name"]);
        $response = new Response();
        try{
            $user_list = $res->toList();
            if($user_list == null){
                $response->set([
                    "msg" => "No user found.",
                    "status"=>false,
                    "status_code"=>404
                ]);
            }
            else{
                $response->set([
                    "msg" => "List of users.",
                    "status"=>true,
                    "status_code"=>200,
                    "data"=>$user_list
                ]);
            }
        }
        catch(Exception $e){
            $response->set([
                    "msg" => "An error occurs.",
                    "status"=>false,
                    "status_code"=>500,
                    "error"=>$res->getErrorInfo()
                ]);
        }
        $this->data['response'] = $response;
        
        return $this->view();
    }
    public function addUsers(){
        if(!Logins::isAuthenticated()){
            redirect("account", "login");
        }
        
        if(Logins::getRoleName()!== "Admin"){
            redirectTo();//redirecting to the default authorized page
            //redirect("account", "signup");
        }
        
        
        $roles = new Role();
        $res = $roles->read();
        $this->data['roles'] = $res->data;
        $this->data['response'] = "";
        
        $data = $this->_cleanInputs($_POST);
        if(sizeof($data)){
            $this->response = verifyCSRFToken();//verifying csrf token
            if($this->response->status == false){
                $this->data['response'] = $this->response->msg;
                return $this->view();
            }
            if($data['password'] !== $data['confirm_password']){
                $this->data['response'] = "Please enter confirmation password correctly.";
            }
            else{
                $user = new Users($data);
                $res = $user->add();
                if($res->status_code == 200){
                    $this->data['response'] = "User has been added successfully.";
                }   
                else{
                    $this->data['response'] = $res->msg;
                }
            }
        }
        return $this->view();
    }
    
    public function editUser(){
        if(!Logins::isAuthenticated()){
            redirect("account", "login");
        }
        
        if(Logins::getRoleName()!== "Admin"){
            $this->response->set(array(
                "msg"=>"You are not authorized to access this page.",
                "status_code"=>403
            ));
        }
        $param = $this->getParams();
        if(sizeof($param)==0){
            $this->response->set(array(
                "msg"=>"Invalid request",
                "status_code"=>403
            ));
        }
        else{
            $user_id = $param[0];
            $user = new Users();
            $user = $user->find($user_id);
            if($user == null){
                $this->response->set(array(
                    "msg"=>"User not found",
                    "status_code"=>404
                ));
            }
            else{
                $this->response->set(array(
                    "msg"=>"User found",
                    "status_code"=>200,
                    "status"=>true,
                    "data"=>$user
                ));
            }
        }
        $roles = new Role();
        $res = $roles->read();
        $this->data['roles'] = $res->data;
        $this->data['response'] = $this->response;
        return $this->view();
    }
    
}
