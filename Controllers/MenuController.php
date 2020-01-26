<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuController
 *  All the operations of Menu (Create, Read, Update and Delete) are integrated in this controller
    Only Admin will be authorized for access
 * * @author Nganthoiba
 */
class MenuController extends Controller{
    private $menu;
    public function __construct($data = array ()) {
        parent::__construct($data);
        if(Logins::getRoleName()!== "Admin"){
            redirectTo();
        }
        $this->menu = new Menu();
    }
    
    public function index(){
        $param = $this->getParams();
        if(sizeof($param)){
            $role_id = $param[0];
            $menuReader = new MenuReader();
            $menus = $menuReader->readMenu($role_id);
            $data = ["msg"=>"Menu List","data"=>$menus];
        }
        else{
            $data = ["msg"=>"Invalid request, missing role perameter."];
        }
        return $this->send_data($data, 200);
    }

    public function displayMenu(){
        return $this->view();
    }
    public function displaySubMenu(){
        $this->data['parent_menu_id'] = "";
        $this->data['parent_menu'] = null;
        $param = $this->getParams();
        if(sizeof($param) == 0){
            $this->response->set(array(
                    "msg"=>"Missing parent menu id",
                    "status_code"=>403
                ));
        }
        else{
            $parent_menu_id = $param[0];
            $cond = [
                "parent_menu_id"=>$parent_menu_id
            ];
            $this->response = $this->menu->read([], $cond,"sequence");
            $this->data['parent_menu_id'] = $parent_menu_id;
            $this->data['parent_menu'] = $this->menu->find($parent_menu_id);
        }
        $this->data['response'] = $this->response;
        
        return $this->view();
    }
    //get all parent menu
    public function getMenu(){
        $this->response = $this->menu->read(array(),"parent_menu_id is NULL","sequence");
        return $this->send_data($this->response,$this->response->status_code);
    }
    //get all child menu
    public function getSubMenu(){
        $param = $this->getParams();
        if(sizeof($param) == 0){
            $this->response->set(array(
                    "msg"=>"Missing parent menu id",
                    "status_code"=>403
                ));
        }
        else{
            $parent_menu_id = $param[0];
            $cond = [
                "parent_menu_id"=>$parent_menu_id
            ];
            $this->response = $this->menu->read([], $cond,"sequence");
        }
        return $this->send_data($this->response,$this->response->status_code);
    }
    
    public function saveMenuSequence(){
        $this->response = new Response();
        $input_data = $this->_cleanInputs(json_decode(file_get_contents("php://input"),true));
        if($input_data == null || sizeof($input_data)==0){
            $this->response->set(['status_code'=>403,'msg'=>"Invalid Request, no input parameters."]);
            return $this->sendResponse($this->response);
        }
        //Validation
        foreach ($input_data as $seq_data){
            if(!isset($seq_data['menu_id']) || !isset($seq_data['sequence']) || $seq_data['menu_id']==="" || $seq_data['sequence']===""){
                $this->response->set(['status_code'=>403,'msg'=>"Invalid Request, wrong parameters."]);
                return $this->sendResponse($this->response);
            }
        }
        $this->menu::$conn->beginTransaction();
        foreach ($input_data as $seq_data){
            $menu_id = $seq_data['menu_id'];
            $sequence = $seq_data['sequence'];
            $this->menu = $this->menu->find($menu_id);
            $this->menu->sequence = $sequence;
            $this->response = $this->menu->save();
            if($this->response->status == false){
                $this->menu::$conn->rollback();
                break;
            }
        }
        if($this->response->status){
            $this->menu::$conn->commit();
        }
        return $this->sendResponse($this->response);
    }
    
    //method to create a menu
    public function createMenu(){
        $this->response = new Response();
        $input_data = $this->_cleanInputs($_POST);
        if(sizeof($input_data)){
            //validate menu data
            $resp = $this->isValidMenuData($input_data);
            if($resp->status == false){
                $this->response = $resp;
            }
            else{
                $this->menu->menu_name = $input_data['menu_name'];
                $this->menu->link = $input_data['link'];
                $this->menu->parent_menu_id = isset($input_data['parent_menu_id']) && trim($input_data['parent_menu_id'])!=""?$input_data['parent_menu_id']:null;
                $this->response = $this->menu->add();
            }
        }
        else{
            $this->response->set(array(
                "msg"=>"Invalid request",
                "status_code"=>403
            ));
            
        }
        return $this->send_data($this->response,$this->response->status_code);
    }
    
    //method for updating menu
    public function updateMenu(){
        $this->response = new Response();
        $input_data = $this->_cleanInputs($_POST);
        if(sizeof($input_data)){
            //validate menu data
            $resp = $this->isValidMenuData($input_data);
            if($resp->status == false){
                $this->response = $resp;
            }
            else if(!isset($input_data['menu_id']) || $input_data['menu_id']===""){
                $this->response->set(array(
                    "msg"=>"Missing menu id",
                    "status_code"=>403
                ));
            }
            else{
                $this->menu = $this->menu->find($input_data['menu_id']);
                $this->menu->menu_name = $input_data['menu_name'];
                $this->menu->link = $input_data['link'];
                $this->menu->parent_menu_id = isset($input_data['parent_menu_id']) && trim($input_data['parent_menu_id'])!=""?$input_data['parent_menu_id']:$this->menu->parent_menu_id;
                $this->response = $this->menu->save();
            }
        }
        else{
            $this->response->set(array(
                "msg"=>"Invalid request",
                "status_code"=>403
            ));
            
        }
        return $this->send_data($this->response,$this->response->status_code);
    }
    
    public function removeMenu(){
        $this->response->set(array(
                "msg"=>"Invalid request",
                "status_code"=>403
            ));
        $param = $this->getParams();
        if(sizeof($param)){
            $menu_id = $param[0];
            $this->menu = $this->menu->find($menu_id);
            if($this->menu == null){
                $this->response->set(array(
                    "msg"=>"Menu not found.",
                    "status_code"=>404
                ));
            }
            else{
                $this->response = $this->menu->remove();
            }
        }
        return $this->send_data($this->response,$this->response->status_code);
    }
    
    //For roles and Menu mapping
    public function AssociateRoles(){
        //if data is posted for menus and roles mapping
        $input_data = $this->_cleanInputs($_POST);
        if(sizeof($input_data)){
            $response = new Response();
            $response = $this->saveMenuRoleMapping($input_data);
            //$response->data = $input_data;
            return $this->send_data($response,$response->status_code);
        }
        
        $param = $this->getParams();
        $this->data['all_roles'] = array();
        $this->data['accociated_roles'] = array();
        $this->data['menu'] = null;
        if(sizeof($param)){
            $this->menu = $this->menu->find($param[0]);
            if($this->menu != null){
                $this->data['menu'] = $this->menu;
                $associated_roles = $this->getAssociatedRoles($this->menu);
                $role = new Role();
                $resp = $role->readAll();
                $roles = $resp->data;
                $temp_roles = array();
                foreach($roles as $role){
                    $role->isRoleAccociatedWithMenu = $this->isRoleAccociatedWithMenu($associated_roles,$role);
                    $temp_roles[]=$role;
                }
                $this->data['all_roles'] = $temp_roles;
                $this->data['associated_roles'] = $associated_roles;
            }
        }
        return $this->view();
    }
    
    private function saveMenuRoleMapping($data){
        
        //validating data
        if(!isset($data['menu_id'])){
            $this->response->set(array(
                "msg"=>"Menu Id is missing",
                "status_code"=>403
            ));
        }
        /*
        else if(!isset($data['associated_roles'])){
            $this->response->set(array(
                "msg"=>"No roles are passed.",
                "status_code"=>403
            ));
        }
        */
        else{
            $menu_id = $data['menu_id'];
            $associated_roles = isset($data['associated_roles'])?$data['associated_roles']:null;//only role id is passed
            
            $conn = $this->menu::$conn;
            $conn->beginTransaction();
            try{
                $qry = "delete from menu_role_mapping where menu_id = ? ";
                $stmt = $conn->prepare($qry);
                $stmt->execute([$menu_id]);
                if($associated_roles !== null && $associated_roles !== ""){                
                    foreach ($associated_roles as $role_id){
                        $ins_qry = "insert into menu_role_mapping(menu_id, role_id)"
                                . " values(?,?)";
                        $stmt=$conn->prepare($ins_qry);
                        if(!$stmt->execute([
                                $menu_id,
                                $role_id
                            ]))
                        {
                            $conn->rollback();
                            $this->response->set(array(
                                "error"=>$stmt->errorInfo()
                            ));
                            break;
                        }
                    }
                }
            } 
            catch (Exception $e){
                $conn->rollback();
                $this->response->set(array(
                    "error"=>$e
                ));
            }
            $conn->commit();
            $this->response->set(array(
                "msg"=>"Saved successfully",
                "status"=>true,
                "status_code"=>200
            ));
        }
        return $this->response;
    }
    
    //function to check if role is associated with menu or not
    private function isRoleAccociatedWithMenu($associated_roles = array(), Role $role){
        foreach ($associated_roles as $associated_role){
            if($associated_role['role_id'] === $role->role_id){
                return true;
            }
        }
        return false;
    }
    
    private function getAssociatedRoles(Menu $menu){
        $qry = "select role_id from menu_role_mapping where menu_id = ? ";
        $stmt = $menu::$conn->prepare($qry);
        $stmt->execute([$menu->menu_id]);
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }
    //check for valid menu data
    private function isValidMenuData($data){
        $response = new Response();
        if(!isset($data['menu_name']) || $data['menu_name']==""){
            return $response->set(array(
                "msg"=>"Missing menu name",
                "status_code"=>403
            ));
        }
        if(!isset($data['link']) || $data['link']==""){
            return $response->set(array(
                "msg"=>"Missing menu link",
                "status_code"=>403
            ));
        }
        if(!filter_var($data['link'], FILTER_VALIDATE_URL)){
            return $response->set(array(
                "msg"=>"Not a valid url",
                "status_code"=>403
            ));
        }
        return $response->set(array(
                "msg"=>"Valid",
                "status_code"=>200,
                "status"=>true
            ));
    }
}
