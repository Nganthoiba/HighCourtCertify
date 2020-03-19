<?php
/**
 * Description of offline_payment_receipt
 *
 * @author Nganthoiba
 */
class offline_payment_receipt extends EasyEntity{
    public  $offline_payment_receipt_id,
            $receipt_path,
            $application_id,
            $created_at;
    public function __construct() {
        parent::__construct();
        $this->setTable("offline_payment_receipt")->setKey("offline_payment_receipt_id");
    }
}
