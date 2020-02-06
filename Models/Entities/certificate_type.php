<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of application_for
 *
 * @author Nganthoiba
 */
class certificate_type extends EasyEntity{
    public $certificate_type_id,$name;
    public function __construct() {
        parent::__construct();
        $this->setTable("certificate_type");
        $this->setKey("certificate_type_id");
    }
}
