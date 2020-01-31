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
class application_for extends EasyEntity{
    public $application_for_id,$name;
    public function __construct() {
        parent::__construct();
        $this->setTable("application_for");
        $this->setKey("application_for_id");
    }
}
