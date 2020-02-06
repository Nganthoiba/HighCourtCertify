<?php
/**
 * Description of copy_type
 *
 * @author Nganthoiba
 */
class copy_type extends EasyEntity{
    public $copy_type_id,$copy_name;
    public function __construct() {
        parent::__construct();
        $this->setTable("copy_type")->setKey("copy_type_id");
    }
}
