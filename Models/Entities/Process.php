<?php
class Process extends EasyEntity{
    public $process_id;
    public $process_name;
    public $process_description;
    
    public function __construct() {
        parent::__construct();
        $this->setTable("process");
        $this->setKey("process_id");
    }
}
