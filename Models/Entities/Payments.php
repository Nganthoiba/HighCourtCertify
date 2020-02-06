<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payments
 *
 * @author Nganthoiba
 */
class Payments extends EasyEntity{
    public $payments_id,
            $payment_type,
            $amount,
            $purpose,
            $application_id,
            $transaction_id,
            $status,
            $created_at,
            $payment_date;
    public function __construct() {
        parent::__construct();
        $this->setTable("payments")->setKey("payments_id");
    }
}
