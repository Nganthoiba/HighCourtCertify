<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Account_apiController
 *
 * @author Nganthoiba
 */
class Account_apiController extends Api{
    public $response,$content_type;
    public function __construct($request = "") {
        parent::__construct($request);
        $this->response = new Response();
        $headers = apache_request_headers();
        $this->content_type = get_data_from_array("Content-Type",$headers);
    }
    //put your code here
    public function changePassword(){
        if($this->method !== "POST"){
            $this->response->msg="Invalid Request";
            $this->response->status_code = 404;
            $this->response->status = false;
        }
        else{
            $data = $this->request;
            $this->response = $this->validateAndChangePassword($data);            
        }
        return $this->_response($this->response, $this->response->status_code);
    }
    
    private function validateAndChangePassword($data){
        if($this->content_type !== "application/json"){
            $data = (object)$data;//casting to object
        }
        
        $login_id = isset($data->login_id)?$data->login_id:"";
        $old_password = isset($data->old_password)?$data->old_password:"";
        $new_password = isset($data->new_password)?$data->new_password:"";
        $confirm_password = isset($data->conf_new_password)?$data->conf_new_password:"";
        
        $resp = new Response();
        $resp->status_code = 403;//forbidden
        
        if($login_id=="" || $old_password=="" || $new_password=="" || !(Logins::isValidLogin($login_id))){
            $resp->msg = "Invalid request.";
        }
        else if($new_password != $confirm_password){
            $resp->msg = "Your confirmation password is not matching with your new password.";   
        }
        else{
            $login = new Logins();
            $login = $login->find($login_id);
            $user_id = $login->user_id;
            $user = new Users();
            $user = $user->find($user_id);
            if($user->user_password != hash("sha256", $old_password)){
                $resp->msg = "Your old password is wrong.";
            }
            else{
                //$params = array("user_password"=>hash("sha256", $new_password));
                //$cond = array("user_id"=>$user_id);
                $user->user_password = hash("sha256", $new_password);
                $resp = $user->save();
            }
        }
        return $resp;
    }
}
