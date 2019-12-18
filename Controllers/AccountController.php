<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountController
 *
 * @author Nganthoiba
 */
class AccountController extends Controller{
    
    public function __construct($data = array()) {
        parent::__construct($data);
        $this->data['login_response']="";
        $this->data['email']="";
        $this->data['password']="";
    }
    public function index(){
        $this->data['content'] = "Hello! This is index file of AccountController";
        $this->data['test'] = "Hello! This is test file";
        return $this->view();
    }
    //login action
    public function login(){
        //first check whether a user is already logged in, if someone logged in then redirect the page to the home page  
        if(Logins::isAuthenticated()){
            //redirecting to the proper page if already logded in
            redirectTo();
        }
        $data = $this->_cleanInputs($_POST);
        if(sizeof($data)){
            //verify csrf token
            $res = verifyCSRFToken();
            if($res->status == false){
                $this->data['login_response'] = $res->msg." Please, refresh the page.";
                return $this->view();
            }
            //end token verification
            $res = $this->isLoginDataValid($data);
            $this->data['email']=$data['email'];
            $this->data['password']=$data['password'];
            
            if($res->status == true){
                $loginModel = new UserLoginModel($data['email'], $data['password']);
                $resLogin = $loginModel->isLoginSuccessfull();
                //echo json_encode($resLogin); exit();
                if($resLogin->status === true){
                    //storing user information in session
                    $_SESSION['user_info'] = $resLogin->data;
                    //redirecting to the proper page after login
                    redirectTo();
                    
                }
                else{
                    $this->data['login_response'] = "Login failed, please try with proper credentials.";
                }
            }
            else{
                $this->data['login_response'] = $res->msg;
            }  
        }
        return $this->view();
    }
    
    //logout action
    public function logout(){
        if(isset($_SESSION['user_info'])){
            $info = $_SESSION['user_info'];
            $login_id = $info['login_id'];
            if(Logins::isValidLogin($login_id)){
                $logins = new Logins();
                $resLogout=$logins->logout($login_id);
            }
        }
        if (session_status() !== PHP_SESSION_NONE){
            // If there is session
            session_destroy();
        }
        $this->data['content'] ="You have successfully logged out.";
        return $this->view();
    }
    
    //signup action
    public function signup(){
        $resp = new Response();
        //first check whether a user is already logged in, if someone logged in then redirect the page to the home page
        if(Logins::isAuthenticated()){
            redirectTo();
        }
        $data = $this->_cleanInputs($_POST);
        if(sizeof($data)){
            //captcha validation
            $captcha_code = isset($data['captcha_code'])?$data['captcha_code']:"";
            if(!$this->isValidCaptchaCode($captcha_code)){
                $resp->status_code=403;
                $resp->msg = "Captcha code is invalid";
            }
            else{
                $users = new Users($data);//creating user model
                $users->role_id = 14;//For applicants
                $resp = $users->add();//adding new record for user
                if($resp->status_code == 200){
                    $resp->msg = "You have successfully signed up. Thank you.";
                }
            }
            return $this->send_data($resp, $resp->status_code);
        }
        //if no data is sent from client
        return $this->view("");
    }
    
    //forgot password
    public function forgotPassword(){
        return $this->view();
    }
    //reset password
    public function changePassword(){
        if(!Logins::isAuthenticated()){
            $this->redirect("account", "login");
        }
        return $this->view();
    }
    /*** function to check whether captcha code is valid or not ***/
    private function isValidCaptchaCode($captcha_code){
        if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $captcha_code) != 0){  
            return false;
	}
        else{
            // Captcha verification is Correct. Final Code Execute here!		
            return true;
	}
    }
    //Manage Account
    public function manageAccount(){
        if(!Logins::isAuthenticated()){
            $this->redirect("account", "login");
        }
        $info = $_SESSION['user_info'];
        $user_id = $info['user_id'];
        $user = new Users();
        $user=$user->find($user_id);
        $this->data['user'] = $user;
        $this->data['update_response'] = "";
        $input_data = $this->_cleanInputs($_POST);
        if(sizeof($input_data)){
            //verify csrf token
            $response = verifyCSRFToken();
            if($response->status == false){
                $this->data['update_response'] = $response->msg;
                return $this->view();
            }
            /* validation for updating user information */
            if(!isset($input_data['full_name']) || $input_data['full_name']=== ""){
                $this->data['update_response'] = "Missing your full name.";
            }
            else if(!isset($input_data['email']) || $input_data['email']=== ""){
                $this->data['update_response'] = "Missing your email.";
            }
            else if(!filter_var($input_data['email'], FILTER_VALIDATE_EMAIL)){
                $this->data['update_response'] = "Your email is invalid.";
            }
            else if($this->isEmailExist($user->user_id,$input_data['email'])){
                $this->data['update_response'] = "Your new email '".$input_data['email']."' already exist with another account try another.";
            }
            else if(!isset($input_data['phone_no']) || $input_data['phone_no']=== ""){
                $this->data['update_response'] = "Missing your phone number";
            }
            else if(isset($input_data['aadhaar']) && $this->isAadhaarExist($user->user_id, $input_data['aadhaar'])){
                $this->data['update_response'] = "Please check your aadhaar, aadhaar no already exists with another account.";
            }
            else
            {
                $user->full_name = $input_data['full_name'];
                $user->email = $input_data['email'];
                $user->phone_no = $input_data['phone_no'];
                $user->aadhaar = $input_data['aadhaar']==""?null:$input_data['aadhaar'];
                $user->update_at = date('Y-m-d H:i:s');
                $user->update_by = $user->user_id;
                try{
                    $res = $user->save();//saving user details
                    $this->data['update_response'] = $res->msg;
                }catch(Exception $e){
                    $this->data['update_response'] = $e->getMessage();
                }
            }
        }
        return $this->view();
    }
    
    //Validating login information
    private function isLoginDataValid($data = array()){
        $resp = new Response();
        $resp->status_code = 403;
        if(!isset($data['email']) || $data['email']==="")
        {
            $resp->msg = "Please enter your email.";
            return $resp;
        }
        if(!isset($data['password']) || $data['password']==="")
        {
            $resp->msg = "Please enter password.";
            return $resp;
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $resp->msg = "Email is invalid, please enter correctly.";
            return $resp;
        }
        $resp->status = true;
        $resp->msg = "Validated";
        return $resp;
    }
    /*function to check whether an email to be updated already exists with another account*/
    private function isEmailExist($user_id,$email){
        $model = new model();
        $qry = "select * from users where user_id!='$user_id' and email='$email'";
        $res = $model::$conn->query($qry);
        return $res->rowCount()>0;
    }
    /*function to check whether an email to be updated already exists with another account*/
    private function isAadhaarExist($user_id,$aadhaar){
        $model = new model();
        $qry = "select * from users where user_id!='$user_id' and aadhaar='$aadhaar'";
        $res = $model::$conn->query($qry);
        return $res->rowCount()>0;
    }
}
