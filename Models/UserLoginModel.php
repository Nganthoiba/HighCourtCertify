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
        $res = new Response();
        $user = new Users();
        $queryBuilder;
        $cond = array(
            'email' => $this->email,
            'user_password' => $this->user_password
        );
        try{
            $queryBuilder = $user->read(array(
                'user_id',
                'full_name',
                'email',
                'phone_number',
                'role_id',
                'verify',
                'aadhaar'), $cond);
            $user = $queryBuilder->getFirst();
            if($user !== null){
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
                $res->set([
                    "status"=>false,
                    "status_code"=>404,
                    "msg"=>"User not found! Make sure you that you enter correct credentials."                    
                ]);
            }
        }
        catch(Exception $e){
            $res->set([
                    "status"=>false,
                    "status_code"=>500,
                    "msg"=>"Sorry, an error occurs.",
                    "error"=>$e->getMessage(),
                ]);
            $res->qry = $queryBuilder->getQuery();
            $res->values = $queryBuilder->getValues();
        }
        return $res;
    }
}
