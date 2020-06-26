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
        $this->viewData->total_request = Application::count("all");
        $this->viewData->completed_request = Application::count("completed");
        $this->viewData->pending_request = Application::count("pending");
        $this->viewData->totalApplicants = Users::count();
        return $this->view();
    }
    
    public function captcha(){
        $captcha = new captcha();
        //$captcha->getCaptchaCode();
        $captcha->phpcaptcha('#171a17','#f7e80b',80,30,2,5,'#162453');
    }
}
