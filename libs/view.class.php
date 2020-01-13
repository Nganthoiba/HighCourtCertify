<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of view
 *
 * @author Nganthoiba
 */
class View {
    protected $data;
    protected $path;
    
    protected static function getDefaultViewPath(){
        $router = App::getRouter();
        if(!$router){
            return false;
        }
        $controller = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction().'.view.php';
        return VIEWS_PATH.DS.$controller.DS.$template_name;
    }

    public function __construct($data=array(),$path = null) {
        
        if(!$path || ($path==null) || trim($path)==""){
            $this->path = self::getDefaultViewPath();  
        }
        else{
            $this->path = $path;
        }
        if(!file_exists($this->path)){
            throw new Exception("View file is not found in the path: ".$path,404);
        }
        $this->data = $data;
    }
    
    public function render(){
        ob_start();
        $data = $this->data;
        if(file_exists($this->path)){
            include_once($this->path);
        }
        //Get current buffer contents and delete current output buffer.Returns the contents of the output buffer and end output buffering. If output buffering isn't active then FALSE is returned. 
        $content = ob_get_clean();
        return $content;
    }
}
