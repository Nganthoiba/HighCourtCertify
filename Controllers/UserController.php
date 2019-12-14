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
    public function index(){
        $params = $this->getParams();
        $user_id = isset($params[0])?$params[0]:"";
        $users = new Users();//creating user model
        if($user_id == ""){
            $columns = array(
                'user_id' , 
                'full_name' ,     
                'email'  ,        
                'phone_no'  ,     
                'role_id',        
                'user_password',  
                'verify',         
                'create_at',     
                'update_at',      
                'delete_at',      
                'profile_image',  
                'aadhaar',        
                'update_by'
                
                );
            $cond = array();
            $this->resp = $users->read($columns,$cond, "full_name");
            return $this->send_data($this->resp, $this->resp->status_code);
        }
        else{
            $users = $users->find($user_id);
            if($users == null){
                
                $this->resp->set(array(
                    "status"=>false,
                    "msg"=>"User not found",
                    "status_code"=>404
                ));
            }
            else{
                $this->resp->set(array(
                    "status"=>true,
                    "msg"=>"User found",
                    "status_code"=>200,
                    "data"=>$users
                ));
            }
            return $this->send_data($this->resp, $this->resp->status_code);
        }
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
                'phone_no'  ,     
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
        $resp = $users->read($columns,$cond, "full_name");
        $this->data['response'] = $resp;
        
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
    
    
}
