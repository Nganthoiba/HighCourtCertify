<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logins
 *
 * @author Nganthoiba
 */
class Logins extends model{
    public  $login_id,/*primary key*/
            $login_time,
            $logout_time,
            $expiry,   
            $source_ip,
            $device,
            $user_id;
    public function __construct($user_id="") {
        parent::__construct();
        /*** default values ***/
        $key = "login_id";// setting the key of this model
        $this->setTable("logins");
        $this->setKey($key);
        /**** table data ****/
        $this->user_id = $user_id;        
    }

    //Adding user login details
    public function add(){
        $this->login_id = randId(60);
        $this->source_ip = get_client_ip();
        $this->device = filter_input(INPUT_SERVER,'HTTP_USER_AGENT');
        $this->login_time = date('Y-m-d H:i:s');
        $Timestamp = strtotime($this->login_time);
        $TotalTimeStamp = strtotime('+ 3 hours', $Timestamp);//timestamp after 20 minutes
        $this->expiry = date('Y-m-d H:i:s',$TotalTimeStamp);//expiry date time set just at 20 minutes after login
        
        $data = array(
            "login_id"=>$this->login_id,
            "login_time"=>$this->login_time,
            "expiry"=>$this->expiry,
            "source_ip"=>$this->source_ip,
            "device"=>$this->device,
            "user_id"=>$this->user_id
        );
        return parent::create($data);
    }
    
    //getting role name
    public static function getRoleName(){
        if(self::isAuthenticated()){
            $user_info = $_SESSION['user_info'];
            $role_id = $user_info['role_id'];
            $role = new Role();
            $role = $role->find($role_id);
            return $role==null?"not_found":$role->role_name;
        }
        return "";
    }
    //To check whether someone is logged in
    public static function isAuthenticated(){
        if(!isset($_SESSION['user_info'])){
            return false;
        }
        $user_info = $_SESSION['user_info'];
        $isValid = self::isValidLogin($user_info['login_id']);
        if(!$isValid){
            if (session_status() !== PHP_SESSION_NONE){
                // If there is session
                session_destroy();
            }
        }
        return ($isValid);
    }
    /*this function checks whether login id is valid which means user is logged in 
     * otherwise the user is not logged in */
    public static function isValidLogin($login_id){
        /* this method is static, so it is required to check the connection */
        
        $model = new Logins();//require to create a new object
        
        $currentDatetime = date('Y-m-d H:i:s');
        $qry = "select * from ".$model->getTable()." "
                . "where login_id = :login_id "
                . "and   logout_time IS NULL "
                . "and   expiry > :curr_datetime";
        $stmt = self::$conn->prepare($qry);
        $stmt->bindParam(":login_id",$login_id);
        $stmt->bindParam(":curr_datetime",$currentDatetime);
        $stmt->execute();
        if($stmt->rowCount()==1){
            //if the login is valid, the update the expiry time
            //self::updateExpiryTime($login_id);
            return true;
        }
        return false;
    }
    
    private static function updateExpiryTime($login_id){
        $login = new Logins();
        $login = $login->find($login_id);
        
        $Timestamp = strtotime(date('Y-m-d H:i:s'));//current timestamp
        $TotalTimeStamp = strtotime('+ 20 minutes', $Timestamp);//timestamp after 20 minutes
        $expiry = date('Y-m-d H:i:s',$TotalTimeStamp);
                
        $qry = " update ".$login->getTable()." set expiry = :expiry "
                . " where login_id = :login_id ";
        $stmt = self::$conn->prepare($qry);
        $stmt->bindParam(":expiry",$expiry);
        $stmt->bindParam(":login_id",$login_id);
        return $stmt->execute();
    }
    
    public function logout($login_id) {
        $params = array(
            "logout_time"=>date('Y-m-d H:i:s')
        );
        $cond = array("login_id"=> $login_id);
        return parent::update($params, $cond);
    }
    //finding the object of the same class by some id (key)
    public function find($key) {        
        $m = parent::find($key);
        return $m;
    }
}
