<?php
/**
 * Description of users
 *
 * @author Nganthoiba
 */
class Users extends EasyEntity{
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
    private $response;
    
    /***********************/
    public function __construct($data = array()) {
        parent::__construct();
        $this->setTable("users");
        $this->setKey("user_id");
        $this->response = new Response();
        /** setting default values **/
        $this->user_id = UUID::v4();
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
    public function add(): Response{
        if(!$this->isValidated()){
            return $this->response;
        }
        //$rec = json_decode(json_encode(new UserAddModel($this)),true);
        return parent::add();
        //return parent::create($rec);
    }
    
    //For reading user data from users table
    public function read($columns = array(), $cond = array(), $order_by = array()):EasyQueryBuilder {
        $qryBuilder = new EasyQueryBuilder();
        return $qryBuilder->select($columns)->from(
                " (select U.*,R.role_name "
                . " from users U left join role R "
                . " on U.role_id = R.role_id) as USER_TABLE "
                )->where($cond)->orderBy($order_by);        
    }
    
    //For updating user data
    public function save(): Response{
        $this->verify = ($this->verify == false)?0:1;
        return parent::save();
    }
    
    //For removing data
    public function remove(): Response{
        return parent::remove();
    }
    
    /*** START PRIVATE METHODS ***/
    
    /*** function to check whether an email already exist ***/
    private function isEmailExist($email){
        $qry = "select * from users where email = :email";
        $conn = Database::connect();
        $stmt = $conn->prepare($qry);
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
    
    public static function isAdminUser($user_id){
        $user = new Users();
        $user = $user->find($user_id);
        if($user == null) {
            return false;
        }
        return ($user->role_id == 1);
    }
}