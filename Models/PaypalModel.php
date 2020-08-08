<?php
/**
 * Description of PaypalModel
 *
 * @author Nganthoiba
 */
class PaypalModel {
    public $cmd;
    public $business;
    public $no_shipping;
    public $return_url;
    public $cancel_return;
    public $notify_url;
    public $currency_code;//currency 
    public $item_name;//item name
    public $item_number;//number of items
    public $amount;// total amount
    public $actionURL;

    public function __construct(bool $useSandbox)
    {
        $this->cmd = "_xclick";
        $this->item_number = 1;
        $this->no_shipping = 1;
        $this->business = Config::get('business');
        $this->cancel_return = Request::getHost().'/'.Config::get('cancel_return');
        $this->return_url = Request::getHost().'/'.Config::get('return_url');
        if ($useSandbox)
        {
            $this->actionURL = Config::get('test_url');
        }
        else
        {
            $this->actionURL = Config::get('prod_url');
        }
        // We can add parameters here, for example OrderId, CustomerId, etc….
        $this->notify_url = Config::get('notify_url');
        // We can add parameters here, for example OrderId, CustomerId, etc….
        $this->currency_code = Config::get('currency_code');
    }
}
