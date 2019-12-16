<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_apiController
 *
 * @author Nganthoiba
 */
class User_apiController extends Api{
    //public $response;
    public function __construct($request = "") {
        parent::__construct($request);
        $this->response = new Response();
    }
    public function index(){
        $params = $this->getParams();
        $user_id = isset($params[0])?$params[0]:"";
        $users = new Users();//creating user model
        $resp = new Response();
        if($user_id == ""){
            $columns = array(
                'user_id' , 
                'full_name' ,     
                'email'  ,        
                'phone_no'  ,     
                'role_id',       
                'verify',         
                'create_at',     
                'update_at',      
                'delete_at',      
                'profile_image',  
                'aadhaar',        
                'update_by',
                'role_name'
                );
            $cond = array("role_id !"=>1);
            
            $resp = $users->read($columns,$cond, "full_name");
        }
        else{
            $users = $users->find($user_id);
            if($users == null){
                $resp->status_code = 404;
                $resp->msg = "User not found";
            }
            else{
                $resp->status_code = 200;
                $resp->msg = "User found";
                $resp->data = $users;
            }
        }
        return $this->_response($resp, $resp->status_code);
    }
    
    //put your code here
    public function removeUser(){
        $login_id = getAuthorizedToken();
        if(trim($this->method)!="DELETE" || $login_id == null){
            $this->response->msg="Invalid request.";
            $this->response->status_code=403;
        }
        else if(!Logins::isValidLogin($login_id)){
            $this->response->msg="Please login again, your login token is expired.";
            $this->response->status_code=403;
        }
        else{
            $login = new Logins();
            $login = $login->find($login_id);
            //check if user is authorized to access this functionality
            if(!Users::isAdminUser($login->user_id)){
                //if user role is not admin
                $this->response->set(array(
                    "status"=>false,
                    "status_code"=>403,
                    "msg"=>"You are not authorized."
                ));
            }
            else{
                $param = $this->getParams();
                if(sizeof($param)){
                    $user = new Users();
                    $user = $user->find($param[0]);
                    if($user == null){
                        $this->response->msg="User not found.";
                        $this->response->status_code=404;
                    }
                    else{
                        $this->response = $user->remove();
                    }
                }
                else{
                    $this->response->msg="Invalid request.";
                    $this->response->status_code=403;
                }
            }
        }
        return $this->_response($this->response,$this->response->status_code);
    }
    
    public function updateUser(){
        $login_id = getAuthorizedToken();
        if(trim($this->method)!="POST" || $login_id == null){
            $this->response->msg="Invalid request.";
            $this->response->status_code=403;
        }
        else if(!Logins::isValidLogin($login_id)){
            $this->response->msg="Please login again, your login token is expired.";
            $this->response->status_code=403;
        }
        else{
            $login = new Logins();
            $login = $login->find($login_id);
            //check if user is authorized to access this functionality
            if(!Users::isAdminUser($login->user_id)){
                //if user role is not admin
                $this->response->set(array(
                    "status"=>false,
                    "status_code"=>403,
                    "msg"=>"You are not authorized."
                ));
            }
            else{
                $data = $this->request;
                if(sizeof($data)){
                    $user = new Users();
                    $user = $user->find($data['user_id']);
                    if($user == null){
                        $this->response->msg="User not found.";
                        $this->response->status_code=404;
                    }
                    else{
                        $user->full_name = $data['full_name'];
                        $user->email = $data['email'];
                        $user->phone_no = $data['phone_no'];
                        $user->role_id = $data['role_id'];
                        $user->update_at = date("Y-m-d H:i:s");
                        $user->update_by = $login->user_id;
                        $this->response = $user->save();
                    }
                }
                else{
                    $this->response->msg="Invalid request.";
                    $this->response->status_code=403;
                }
            }
        }
        
        return $this->_response($this->response,$this->response->status_code);
    }
    
}
