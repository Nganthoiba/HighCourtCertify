<?php
/**
 * Description of PaypalController
 *
 * @author Nganthoiba
 */
class PaypalController extends Controller{
    private $request;
    public function __construct() {
        parent::__construct();
        $this->request = new Request();
    }
    public function RedirectFromPaypal(){
        define("DEBUG", 1);
        define("LOG_FILE", "ipn.log");
        $returned_data = $this->request->getData();//data from paypal
        unset($returned_data['uri']);
        $returned_data['cmd'] = '_notify-synch';
        $returned_data['at'] = Config::get('IdentityToken');
        $req_data = "";
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($returned_data as $key=>$value){
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req_data .= "&$key=$value";
        }
        $form_data = ltrim($req_data,'&');
        
        $ipn_response = $this->parseResult($this->getPaypalResponse($form_data));
        if($ipn_response['ipn_status'] === "SUCCESS"){
            $resp = ($ipn_response['ipn_responses']);
            
            $txn_id = $resp['txn_id'];
            $payment = $this->isTransactionExists($txn_id);
            if($payment !== null ){
                $this->data['report'] = $this->response->set([
                    "status"=>true,
                    "msg"=>"Transaction already exists.",
                    "status_code"=>200,
                    "data"=>$payment
                ]);
            }
            else{
                $payment = new Payments();
                $payment->payments_id = $payment->findMaxColumnValue("payments_id")+1;
                $payment->amount = $resp['mc_gross'];
                $payment->purpose = "Certificate Processing fee";
                $payment->application_id = $resp['item_name'];
                $payment->payment_date = $resp['payment_date'];
                $payment->payment_type = "online";
                $payment->status = $resp['payment_status'];
                $payment->transaction_id = $resp['txn_id'];
                $payment->created_at = date('Y-m-d H:i:s');
                $this->data['report'] = $payment->add();
            }
            return $this->view();
        }
        else{
            //echo json_encode($ipn_response);
            $this->data['detail'] = "Invalid transaction";
            return $this->view('error');
        }
        //print_r($returned_data);
    }
    public function CancelFromPaypal(){
        return $this->view();
    }
    public function NotifyFromPaypal(){
        return $this->view();
    }
    public function ValidateCommand(){
        if($this->request->isMethod("POST")){
            $input_data = $this->request->getData();
            if(isset($input_data['amount']) && $input_data['amount']!==""){
                $paypal = new PaypalModel(Config::get('IsSandbox'));
                $paypal->item_name = $input_data['application_id'];//"certificate processing fee";
                $paypal->amount = $input_data['amount'];
                $this->data['paypal'] = $paypal;
                return $this->view();
            }
        }
    }
    
    public function confirmPayment(){
        $params = $this->getParams();
        if(isset($params[0])){
            $this->data['application_id'] = $params[0];
            $this->data['amount'] = 20;
            return $this->view();
        }
    }
    
    public function paymentHistory(){
        
        if(!Logins::isAuthenticated()){
            $this->redirect("Account", "Login");
        }
        $user_id = Logins::getUserId();
        $qryBuilder = new EasyQueryBuilder();
        $list = $qryBuilder->select("P.*")
                ->from("payments P")
                ->join("application A")
                ->on("P.application_id = A.application_id")
                ->and(["A.user_id"=>$user_id])->toList();
        if($list == null){
            $this->response->set([
                "status"=>false,
                "status_code"=>404,
                "data"=>[],
                "msg"=>"No payment history"
            ]);
        }
        else{
            $this->response->set([
                "status"=>true,
                "status_code"=>200,
                "data"=>$list,
                "msg"=>"list of payment history"
            ]);
        }
        $this->data['response'] = $this->response;
        return $this->view();
    }
    
    /*method to check if transaction already exists, it returns an object of Payments if exists
    otherwise null     */
    private function isTransactionExists(string $txn_id): Payments{
        $payment = new Payments();
        $res = $payment->read()->where([
            "transaction_id"=>$txn_id
        ])->getFirst();
        return $res;
    }
    
    private function getPaypalResponse(string $form_data):string{
        // Post IPN data back to PayPal to validate the IPN data is genuine
        // Without this step anyone can fake IPN data
        if(Config::get('IsSandbox') == true) {
            $paypal_url = Config::get('test_url');
        } else {
            $paypal_url = Config::get('prod_url');
        }
        $ch = curl_init($paypal_url);
        if ($ch == FALSE) {
            return FALSE;
        }
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        if(DEBUG == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }
        // CONFIG: Optional proxy configuration
        //curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        // Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        // CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
        // of the certificate as shown below. Ensure the file is readable by the webserver.
        // This is mandatory for some environments.
        //$cert = __DIR__ . "./cacert.pem";
        //curl_setopt($ch, CURLOPT_CAINFO, $cert);
        $res = curl_exec($ch);
        if (curl_errno($ch) != 0) // cURL error
        {
            if(DEBUG == true) {	
                error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
            }
            curl_close($ch);
            exit;
        } else {
            // Log the entire HTTP response if debug is switched on.
            if(DEBUG == true) {
                error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $form_data" . PHP_EOL, 3, LOG_FILE);
                error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
            }
            curl_close($ch);
        }
        // Inspect IPN validation result and act accordingly
        // Split response headers and payload, a better way for strcmp
        
        $tokens = explode("\r\n\r\n", trim($res));
        return (trim(end($tokens)));
    }
    //parsing response from paypal
    private function parseResult($result):array{
        $resp_array = array();//ipn responses
        $responses = preg_split('/\s+/', $result);
        $ipn_status = trim($responses[0]);
        if($ipn_status === "SUCCESS"){
            array_shift($responses);
            foreach ($responses as $resp)
            {
                $res_parts = explode("=",$resp);
                if(sizeof($res_parts)==2){
                    $resp_array[$res_parts[0]] = trim(urldecode($res_parts[1]));
                }
            }
        }
        return [
            "ipn_status"=>$ipn_status,
            "ipn_responses"=>$resp_array
        ];
    }
}
