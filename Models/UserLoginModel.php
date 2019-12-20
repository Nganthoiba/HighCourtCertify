<?php
/**
 * Description of UserLoginModel
 *
 * @author Nganthoiba
 */
//User Login Model
class UserLoginModel{
    private $email;
    private $user_password;
    
    public function __construct($email,$password="") {
        $this->email = $email;
        $this->user_password = ($password == "")?"":hash("sha256", $password);
    }
    
    public function isLoginSuccessfull(){
        $model = new model();
        $model->setTable("users");
        $model->setKey("user_id");
        $cond = array(
            'email' => $this->email,
            'user_password' => $this->user_password
        );
        $res = $model->read(array(
            'user_id',
            'full_name',
            'email',
            'phone_number',
            'role_id',
            'verify',
            'aadhaar'), $cond);
        if($res->status_code == 200){
            $user = $res->data[0];
            //$users_id = $user['users_id'];
            $login = new Logins($user->user_id);
            $loginRes = $login->add();//adding login details
            if($loginRes->status_code==200){
                $loginRes->msg = "You have successfully logged in.";
                $user = json_decode(json_encode($user),true);
                $loginRes->data = array_merge($user,$loginRes->data);
            }
            return $loginRes;
        }
        else{
            return $res;
        }
    }
}
