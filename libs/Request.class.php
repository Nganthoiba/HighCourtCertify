<?php
/**
 * Description of Request
 * Basic structure of a request data
 * @author Nganthoiba
 * files used: 
 * 1.   libs/special_functions.php, 
 *      used function:  get_data_from_array()
 *                      get_client_ip()
 */
class Request {
    //put your code here
    private $method; //HTTP methods (verbs): GET, POST, PUT, DELETE
    private $header; //HTTP request header
    private $content_type; //Content type
    private $source; //source of the request(client IP)
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];//getting HTTP Verb
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
        $this->header = apache_request_headers();
        $this->content_type = get_data_from_array("Content-Type",$this->header);
        $this->source = get_client_ip();
    }
    //method to get data sent from client
    public function getData(){
        $data = array();
        switch ($this->method){
            case "POST":
                if($this->content_type === "application/json"){
                    $data = json_decode(file_get_contents("php://input"),true);
                }
                else{
                    $data = $_POST;
                }
                break;
            case "GET":
            case "DELETE":
                $data = $_GET;
                break;
            case "PUT":
                $data = json_decode(file_get_contents("php://input"),true);
                break;
            
        }
        return $data;
    }
    
    //method to check if request method is allowed
    public function isMethod($verbs = array()){
        if(is_string($verbs)){
            return (trim($verbs) === strtoupper($this->method));
        }
        if(is_array($verbs)){
            return (in_array(strtoupper($this->method), $verbs));
        }
        return false;
    }
    
    public function getSourceIP(){
        return $this->source;
    }
    /*
    public function getRequestHeaders(){
        return apache_request_headers();
    }
    */
    function getRequestHeaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
        //return apache_request_headers();
    }
    //returns domain
    public static function getHost(){
        $isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);
        $protocol = ($isHttps)?"https://":"http://";
        $headers = $this->getRequestHeaders();
        return isset($headers['Host'])?$protocol.$headers['Host']:null;
    }
    public static function getURI(){
        return filter_input(INPUT_GET, "uri", FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
