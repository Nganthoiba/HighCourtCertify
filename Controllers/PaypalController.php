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
                
                //check if input amount is correct or not
                $payable_amount = new payable_amount();
                $payable_amount = $payable_amount->read()->where([
                    "purpose"=>"certificate processing fee"
                ])->getFirst();
                if($input_data['amount'] !== $payable_amount->amount){
                    return "Invalid amount";
                }
                
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
            $this->viewData->application_id = $params[0];
            //check if application is already paid
            $application = new Application();
            $application = $application->find($params[0]);
            if($application == null){
                $this->viewData->status = false;
                $this->viewData->msg = "Application not found.";
            }
            else if($application->isPaymentCompleted()){
                $this->viewData->status = false;
                $this->viewData->msg = "Payment already completed.";
            }
            else{
                //payable amount
                $payable_amount = new payable_amount();
                $payable_amount = $payable_amount->read()->where([
                    "purpose"=>"certificate processing fee"])->getFirst();
                $this->viewData->amount = $payable_amount->amount;
                $this->viewData->status = true;
            }
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
    
    public function paymentDataTable(){
        
        $data = $this->request->getData();
        $user_id = $data['user_id'];
        
        $table = "(SELECT P.transaction_id,P.application_id,TO_CHAR(P.created_at,'DD Mon YYYY, HH12:MI:SS am') as created_at,P.purpose,P.amount,P.status,P.payments_id"
                . " FROM payments P JOIN application A ON "
                . " P.application_id = A.application_id AND A.user_id='$user_id') "
                . "as DATA_TABLE";
        
        $dataTable = new DataTable();
        $records = $dataTable->select([])->from($table)->processData();
        $data = $records['data'];
        for($i=0; $i<sizeof($data); $i++){
            //$data[$i]['created_at'] = date('d M Y, h:i:s a',strtotime($data[$i]['created_at']));
            $data[$i]['application_id'] = ($data[$i]['application_id']);
            $data[$i]['receipt_link'] = "<a href='". getHtmlLink("Paypal", "getReceipt", $data[$i]['payments_id'])."'>Receipt</a>";
        }
        $records['data'] = $data;
        return $this->send_data($records);
    }
    
    public function offlinePayment(){
        $params = $this->getParams();
        
        if(!isset($params[0])){
            $this->data['status'] = false;
            $this->data['msg'] = "Invalid request";
            return $this->view();
        }
        $application = new Application();
        $application = $application->find($params[0]);
        if($application == null){
            $this->data['status'] = false;
            $this->data['msg'] = "Application not found.";
            return $this->view();
        }
        
        if($application->isPaymentCompleted()){
            $this->data['status'] = false;
            $this->data['msg'] = "Payment already completed.";
            return $this->view();
        }
        
        $this->data['status'] = true;
        $this->data['application_id'] = $params[0];
        $this->data['amount'] = 20;
            
        return $this->view();
    }
    
    public function generateOfflineReceipt(){
        $params = $this->getParams();
        if(!isset($params[0])){
            $this->data['msg'] = "Invalid request";
            return $this->view();
        }
        
        $application_id = $params[0];
        $application = new Application();
        $application = $application->find($application_id);
        if($application === null){
            $this->data['msg'] = "Application not found.";
            return $this->view();
        }
        $create_at_timestamp = strtotime($application->create_at);
        $order_date_timestamp = strtotime($application->order_date);
        
        //******************* INITIATING THE REQUIRMENT FOR PDF ****************************
        global $pdf;
        $pdf=new PDF('P','mm','A4');
        // $pdf->fontpath='fpdf17/font/';
        $pdf->AliasNbPages();
        $pdf->SetFont('times','',14);
        $pdf->SetMargins(15, 20, 15); //left top right
        $pdf->AddPage();  //startng a new page

        //******************* Global variables to be used by maximum functions *************************
        global $x,$yr,$y,$xg,$x_posi,$y_place;
        $page_width = $pdf->GetPageWidth() - 30 ; //10 is for left and right margin
        $page_height = $pdf->GetPageHeight() - 20 ; //10 is for top and bottom margin
        $x = $page_width/20;  //manually devided page width into 10
        $y = 8; 

        //**************** NOTE: size of A4 210mm X 297.01 **************************
        //****************  starting to print data  ********************

        //Cell(float w , float h , string txt , mixed border , int ln , string align , boolean fill , mixed link)
        $pdf->SetFont('times','B',24);
        $pdf->ln();
        $pdf->Cell($x*8,10,"",0,0);
        $pdf->Cell($x*4,10,"INVOICE",'B',1,'C');
        $pdf->ln();

        $pdf->Cell($x*20,$x*0.5,"",'LRT',1);
        print_line("Application ID", $application->application_id);
        print_line("Application For", $application->certificate_type_name);
        print_line("Applicant Name", $application->applicant_name);
        print_line("Case Type", $application->case_type_name."-".$application->case_type_full_form);
        print_line("Case Number", $application->case_no);
        print_line("Case Year", $application->case_year);
        print_line("Certificate Copy Type", $application->copy_name);
        print_line("Petitioner", $application->petitioner);
        print_line("Respondent", $application->respondent);
        print_line("Order Date", date('d-m-Y',$order_date_timestamp));
        print_line("Application Submitted On", date('D, d M, Y',$create_at_timestamp));
        print_line("Amount", "Rs. 20");
        $pdf->Cell($x*20,$x*0.5,"",'LRB',1);

        $pdf->ln();
        print_stamp('Stamp Area 1','');
        print_stamp('Stamp Area 2','');
        $pdf->Output();
        die();
        //************************************* END OF PDF DOCUMENT ***********************************************
    }
    
    public function uploadInvoice(){
        if(!Logins::isAuthenticated()){
            $this->response->set([
                "msg"=>"Please login and try again.",
                "status_code"=>400
            ]);
            return $this->sendResponse($this->response);
        }
        if(!$this->request->isMethod("POST")){
            $this->response->set([
                "msg"=>"Invalid request.",
                "status_code"=>400
            ]);
            return $this->sendResponse($this->response);
        }
        $input_data = $this->_cleanInputs($this->request->getData());
        
        if(sizeof($input_data) === 0){
            $this->response->set([
                "msg"=>"No input data",
                "status_code"=>400
            ]);
            return $this->sendResponse($this->response);
        }
        
        $this->response = verifyCSRFToken();
        if(!$this->response->status){
            return $this->sendResponse($this->response);
        }
        
        /*** check if application exsts ***/
        $app = new Application();
        $app = $app->find($input_data['application_id']);
        if($app === null){
            $this->response->set([
                "msg"=>"Application not found",
                "status_code"=>404
            ]);
            return $this->sendResponse($this->response);
        }
        /*** check if already paid ***/
        if($app->isPaymentCompleted()){
            $this->response->set([
                "msg"=>"Payment already completed.",
                "status_code"=>403
            ]);
            return $this->sendResponse($this->response);
        }
        
        $upload_directory = UPLOAD_PATH."/documents/receipt/".$input_data['application_id']."/";
        $file_upload = new Upload();
        $file_upload->setFileUploadKeyName("scan_copy");
        $upload_response = $file_upload->uploadSingleFile($upload_directory);
        
        
        if(!$upload_response->status){
            return $this->sendResponse($upload_response);
        }
        
        $offline_payment_receipt = new offline_payment_receipt();
        $offline_payment_receipt->application_id = $input_data['application_id'];
        $offline_payment_receipt->receipt_path = $upload_response->data['file_paths'][0];
        $offline_payment_receipt->created_at = date('Y-m-d H:i:s');
        $offline_payment_receipt->offline_payment_receipt_id = $offline_payment_receipt->findMaxColumnValue("offline_payment_receipt_id")+1;
        
        $offline_payment_receipt->getQueryBuilder()->beginTransaction();
        $this->response = $offline_payment_receipt->add();
        if($this->response->status == false){
            return $this->sendResponse($this->response);
        }
        /** payment info **/
        $payment = new Payments();
        $payment->amount = $input_data['amount'];
        $payment->application_id = $input_data['application_id'];
        $payment->payment_date = date('Y-m-d H:i:s');
        $payment->created_at = date('Y-m-d H:i:s');
        $payment->payment_type = "offline";
        $payment->payments_id = $payment->findMaxColumnValue("payments_id")+1;
        $payment->purpose = "Certificate processing fee";
        $payment->status = "Completed";
        $payment->transaction_id = "OFF-".date('m-Y'). randId(6);
        $paymentResp = $payment->add();
        if($paymentResp->status == false){
            $offline_payment_receipt->getQueryBuilder()->rollbackTransaction();
            return $this->sendResponse($paymentResp);
        }
        $offline_payment_receipt->getQueryBuilder()->commitTransaction();
        //$this->response->msg = "Payment completed";       
        $paymentResp->msg = "Payment completed";       
        return $this->sendResponse($paymentResp);
    }
    
    public function getReceipt(){
        $param = $this->getParams();
        if(isset($param[0])){
            $payment = new Payments();
            $payment = $payment->find($param[0]);
            if($payment!==null){
                $this->data['report'] = $this->response->set([
                    "status"=>true,
                    "status_code"=>200,
                    "data"=>$payment
                ]);
                return $this->view();
            }
        }
    }
    
    /*method to check if transaction already exists, it returns an object of Payments if exists
    otherwise null     */
    private function isTransactionExists(string $txn_id){
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
