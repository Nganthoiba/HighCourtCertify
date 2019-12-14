<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This is the default controller
 *
 * @author Nganthoiba
 */

class DefaultController extends Controller{
    public function index(){
        Config::set('site_name', 'index');
        $this->data['content'] = 'Hello this is the index action of default controller.';
        return $this->view();
    }
    public function contact(){
        Config::set('site_name', 'contact');
        $this->data['content'] = 'Hello this is the contact action of default controller.';
        return $this->view();
    }
    public function about(){
        Config::set('site_name', 'about');
        //$this->data['content'] = 'Hello this is the about action of default controller.';
        return $this->view();
    }
    /*** just for testing ***/
    public function add(){
        $params = $this->getParams(); 
        $sum = 0;
        foreach ($params as $val){
            if(is_numeric($val)){
                $sum += $val;
            }
        }
        return $this->send_data(array("Sum"=>$sum));
    }
    public function testing(){
        //first check whether a user is already logged in, if no one logged in then redirect the page to the login page
        if(!Logins::isAuthenticated()){
            session_destroy();//destroy the existing session information
            header("Location: ".Config::get('host')."/account/login");            
        }
        return $this->view();
    }
    
    public function captcha(){
        $captcha = new captcha();
        //$captcha->getCaptchaCode();
        $captcha->phpcaptcha('#171a17','#f7e80b',80,30,2,5,'#162453');
    }
}
