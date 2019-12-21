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
            $this->response = $this->menu->read([], $cond);
            $this->data['parent_menu_id'] = $parent_menu_id;
            $this->data['parent_menu'] = $this->menu->find($parent_menu_id);
        }
        $this->data['response'] = $this->response;
        
        return $this->view();
    }
    //get all parent menu
    public function getMenu(){
        $this->response = $this->menu->read(array(),"parent_menu_id is NULL");
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
            $this->response = $this->menu->read([], $cond);
        }
        return $this->send_data($this->response,$this->response->status_code);
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
        return $response->set(array(
                "msg"=>"Valid",
                "status_code"=>200,
                "status"=>true
            ));
    }
}
