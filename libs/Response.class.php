<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of response
 *
 * @author Nganthoiba
 */
class Response {
    //put your code here
    public $data,$error,$status,$status_code,$msg;
    public function __construct() {
        //By default
        $this->data = null;
        $this->error = null;
        $this->status = false;
        $this->status_code = 500;
        $this->msg = "Internal Server Error";
    }
    public function set($data = array()){
        $this->data = isset($data['data'])?$data['data']:$this->data;
        $this->error = isset($data['error'])?$data['error']:$this->error;
        $this->status = isset($data['status'])?$data['status']:$this->status;
        $this->status_code = isset($data['status_code'])?$data['status_code']:$this->status_code;
        $this->msg = isset($data['msg'])?$data['msg']:$this->msg;
        return $this;
    }
}
