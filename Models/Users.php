<?php
/**
 * Description of users
 *
 * @author Nganthoiba
 */
class Users extends model{
    /*** data structures for user***/
    public  $user_id , 
            $full_name ,     
            $email  ,        
            $phone_number  ,     
            $role_id,        
            $user_password,  
            $verify,         
            $create_at,     
            $update_at,      
            $delete_at,      
            $profile_image,  
            $aadhaar,        
            $update_by;    
    
    /***********************/
    public function __construct($data = array()) {
        parent::__construct();
        $this->setTable("users");
        $this->setKey("user_id");
        
        /** setting default values **/
        
        if(sizeof($data)){
            $this->full_name = isset($data['full_name'])?$data['full_name']:"";
            $this->email = isset($data['email'])?$data['email']:"";
            $this->phone_number = isset($data['phone_number'])?$data['phone_number']:"";
            $this->role_id = isset($data['role_id'])?$data['role_id']:0;
            $this->user_password = isset($data['password'])? hash("sha256", $data['password']):"";
            $this->verify = 0;
            $this->create_at = date('Y-m-d H:i:s');
            $this->update_at = null;
            $this->delete_at = null;
            $this->profile_image = null;
            $this->aadhaar = null;
            $this->update_by = isset($data['update_by'])?$data['update_by']:$this->user_id;
        }
    }
    
    //populating data in user table
    public function add() {
        $this->user_id = UUID::v4();
        if(!$this->isValidated()){
            return $this->response;
        }
        //$rec = $this->toArray();
        $rec = json_decode(json_encode(new UserAddModel($this)),true);
        return parent::create($rec);
    }
    
    //For reading user data from users table
    public function read($columns = array(), $cond = array(), $order_by = "") {
        $cols = $this->getColumnStatement($columns);
        $where = $this->getWhereStatement($cond);
        if($order_by!=""){
            $order_by = " order by ".$order_by;
        }
        $qry = "select ".$cols." from "
                . " (select U.*,R.role_name "
                . " from users U left join role R "
                . " on U.role_id = R.role_id) as USER_TABLE "
                . " ".$where." ".$order_by;
        $stmt = self::$conn->prepare($qry);
        $res = is_array($cond)?$stmt->execute(array_values($cond)):$stmt->execute();
        if($res){
            if($stmt->rowCount()==0){
                return $this->response->set(array(
                            "status"=>false,
                            "status_code"=>404,
                            "msg"=>"No record found."
                        ));
            }
            $data = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data[] = (object)$row;
            }
            $this->response->set(array(
                            "status"=>true,
                            "status_code"=>200,
                            "msg"=>"List of users",
                            "data"=>$data
                        ));
        }
        else{
            $this->response->set(array(
                            "error"=>$stmt->errorInfo()
                        ));
        }
        return $this->response;
        //return parent::read($columns, $cond, $order_by);
    }
    
    //For updating user data
    public function save(){
        $this->verify = ($this->verify == false)?0:1;
        $params = $this->toArray();
        unset($params['user_id']);
        //return $params;
        $cond = array("user_id"=> $this->user_id);
        return parent::update($params, $cond);
    }
    
    //For removing data
    public function remove(){
        $cond = array("user_id"=> $this->user_id);
        return parent::delete($cond);
    }
    //finding a user 
    public function find($id) {
        //$user = parent::find($id);
        $resp = $this->read(array(), array("user_id"=>$id));
        
        if($resp->status == false){
            return null;
        }
        //unset($user->table_name);
        $user_data = $resp->data[0];
        unset($user_data->user_password);
        foreach ($user_data as $col_name=>$val){
            $this->$col_name = $val;
        }
        return $this;
    }
    
    /*** PRIVATE METHODS ***/
    
    /*** function to check whether an email already exist ***/
    private function isEmailExist($email){
        $qry = "select * from users where email = :email";
        $stmt = self::$conn->prepare($qry);
        $stmt->bindParam(":email",$email);
        $stmt->execute();
        return ($stmt->rowCount()>0);
    }
    /*** function to validate user data for login ***/
    private function isValidated(){
        $this->response->status = false;
        $this->response->status_code = 403;
        if($this->full_name === ""){
            $this->response->msg = "Missing full name";
            return false;
        }
        if($this->email === ""){
            $this->response->msg = "Missing email";
            return false;
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->response->msg = "Invalid email format";
            return false;
        }
        if($this->isEmailExist($this->email)){
            $this->response->msg = "The email already exists with another account, please try with another.";
            return false;
        }
        if($this->phone_number === ""){
            $this->response->msg = "Missing Phone No.";
            return false;
        }
        if($this->role_id === "" || $this->role_id === 0){
            $this->response->msg = "Missing User Role.";
            return false;
        }
        if($this->user_password === ""){
            $this->response->msg = "Missing password.";
            return false;
        }
        return true;
    } 
    
    //convert to associative array
    private function toArray(){
        $arr = array(
            "user_id" => $this->user_id,
            "full_name" => $this->full_name,
            "email" => $this->email,
            "phone_number" => $this->phone_number,
            "role_id" => $this->role_id,
            "verify" => $this->verify,
            "create_at" => $this->create_at,
            "update_at" => $this->update_at,
            "delete_at" => $this->delete_at,
            "aadhaar" => $this->aadhaar,
            "update_by" => $this->update_by
        );
        return $arr;
    }
    
    public static function isAdminUser($user_id){
        $user = new Users();
        $user = $user->find($user_id);
        if($user == null) {
            return false;
        }
        return ($user->role_id == 1);
    }
}