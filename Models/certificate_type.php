<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of certificate_type
 *
 * @author Nganthoiba
 */
class certificate_type extends model{
    public $certificate_type_id;
    public $copy_name;
    
    public function __construct() {
        parent::__construct();
        $this->setTable("certificate_type");
        $this->setKey($this->getTable()."_id");
    }
    
    public function read($columns = array(), $cond = array(), $order_by = "") {
        $order_by = $order_by == ""? $this->getKey(): $order_by;
        return parent::read($columns, $cond, $order_by);
    }
    
    public function find($id){
        return parent::find($id);
    }
}
