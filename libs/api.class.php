<?php
/**
 * Description of api
 *
 * @author Nganthoiba
 */
abstract class Api
{
    public $request;
        /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    
    /**
     * Property: file
     * Stores the input of the PUT request
     */
     protected $file = Null;

    /**
     * Property: params
     * These are any additional URI components after the controller and method have been removed.
     * eg: http://something.com/<controller>/<method>/<arg0>/<arg1>
     * <arg0> and <arg1> are params (parameters)
     */
    protected $params;
    protected $data;
    public $response;
    private $router;

    public function setRouter($router){
        $this->router = $router;
    }
    public function getData(){
        return $this->data;
    }
    
    //these are the parameters appended in urls
    public function getParams(){
        return $this->params;
    }
    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct() {
        //parent::__construct();
        $this->params = App::getRouter()->getParams();
        $this->response = new Response();
        App::getRouter()->getRoute();
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
        
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
        $headers = apache_request_headers();
        $content_type = get_data_from_array("Content-Type",$headers);
        switch($this->method) {
            case 'DELETE':
            case 'POST':
                if($content_type === "application/json"){
                    $this->request = $this->_cleanInputs(json_decode(file_get_contents("php://input"),true));
                }
                else{
                    $this->request = $this->_cleanInputs($_POST);
                }
                break;
                
            case 'GET':
                $this->request = $this->_cleanInputs($_GET);
                break;
            case 'PUT':
                $this->request = $this->_cleanInputs(json_decode(file_get_contents("php://input"),true));
                $this->file = file_get_contents("php://input");
                break;
            default:
                $this->_response(['msg'=>'Invalid Method'], 405);
                break;
        }
    }
    
    public function _response($data = array(), int $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }
    
    /** For sending response to client **/
    public function sendResponse(Response $resp){
        return $this->_response($resp,$resp->status_code);
    }
    
    //the following functions is also defined in Controller class
    
    protected function _cleanInputs($data) {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(htmlspecialchars(strip_tags($data)));
        }
        return $clean_input;
    }
    protected function _requestStatus($code) {
        $status = array(  
            200 => 'OK',
            400 => 'Bad request',
            401 => 'Unauthorized request',
            402 => 'Payment required',
            403 => 'Forbidden',
            404 => 'Not Found',   
            405 => 'Method Not Allowed',
            409 => 'Conflict',
            500 => 'Internal Server Error'
        ); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }    
}