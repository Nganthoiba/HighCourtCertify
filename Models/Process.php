<?php
class Process extends model{
    public $process_id;
    public $process_name;
    public $process_description;
    
    public function __construct() {
        parent::__construct();
        $this->setTable("process");
        $this->setKey("process_id");
    }
    
    public function read($columns = array(), $cond = array(), $order_by = "process_id") {
        return parent::read($columns, $cond, $order_by);
    }
}
