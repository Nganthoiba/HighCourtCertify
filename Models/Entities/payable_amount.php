<?php
/**
 * Description of payable_amount
 *
 * @author Nganthoiba
 */
class payable_amount extends EasyEntity{
    public  $payable_amount_id,
            $purpose,
            $amount;
    public function __construct() {
        parent::__construct();
        $this->setTable("payable_amount")->setKey("payable_amount_id");
    }
}
