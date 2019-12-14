<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author Nganthoiba
 */
class Controller {
    protected $params;
    protected $model;
    protected $data;
    public $response;
    private $router;

    public function setRouter($router){
        $this->router = $router;
    }
    public function getData(){
        return $this->data;
    }
    public function getModel(){
        return $this->model;
    }
    //these are the parameters appended in urls
    public function getParams(){
        return $this->params;
    }
    
    public function __construct($data = array()) {
        $this->data = isset($data['content'])?$data:array("content"=>"");//check for content
        
        $this->params = App::getRouter()->getParams();
        $this->response = new Response();
    }
    
    /** For sending any type of data **/
    public function send_data($data = array(),$response_code=200){
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $response_code . " " . $this->_requestStatus($response_code));
        return json_encode($data);
    }
    
    public function redirect($controller, $action){
        header("Location: ".Config::get('host')."/".$controller."/".$action);
    }
    public function redirectTo() {
        switch (Logins::getRoleName()){
            case "Applicant":
                $this->redirect("Application", "index");
                break;
            case "Admin":
                $this->redirect("User", "viewUsers");
                break;
            default :
                //echo "default ".Logins::getRoleName();
                $this->redirect("default", "testing");
        }
    }
    protected function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(htmlspecialchars(strip_tags($data)));
        }
        return $clean_input;
    }

    protected function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            400 => 'Bad request',
            401 => 'Unauthorized request',
            402 => 'Payment required',
            403 => 'Forbidden',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            409 => 'Conflict',
            500 => 'Internal Server Error'
        );
        return ($status[$code])?$status[$code]:$status[500]; 
    }
    
    
    public function view($view_path=""){
        if($view_path !== ""){
            $controller_name = str_replace("Controller","",get_class($this));
            //all the view pages have file extension ".view.php" for convension of this project
            if(trim($controller_name) == ""){
                $view_path = VIEWS_PATH.DS.$view_path.'.view.php';
            }
            else{
                $view_path = VIEWS_PATH.DS.$controller_name.DS.$view_path.'.view.php';   
            }
        }
        $view_obj = new View($this->getData(),$view_path);
        $content = $view_obj->render();
        $layout = $this->router->getRoute();
        $layout_path = VIEWS_PATH.DS.$layout.'.view.php';
        $layout_view_obj = new View(array("content"=>$content),$layout_path);
        return $layout_view_obj->render();
    }
}
