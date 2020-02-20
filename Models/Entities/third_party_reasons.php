<?php
/**
 * Description of third_party_reasons
 *
 * @author Nganthoiba
 */
class third_party_reasons extends EasyEntity{
    public $third_party_reasons_id, $reasons;
    public function __construct() {
        parent::__construct();
        $this->setTable("third_party_reasons")->setKey("third_party_reasons_id");
    }
}
