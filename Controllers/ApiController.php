<?php
/**
 * Description of ApiController
 * Just to test whether api works or not
 * Testing Rest Api controller
 * @author Nganthoiba
 */

class ApiController extends Api{
    public function __construct() {
        parent::__construct();
    }
    function test(){
        return $this->_response(array("message"=>"Hello World, this is an example of REST"));
    }
    public function index(){
        return $this->_response($this->request,500);
    }
    public function find(){
        $params = $this->getParams();
        $login_id = isset($params[0])?$params[0]:"";
        $login = new Logins();
        $res = $login->find($login_id);
        return $this->_response($res,500);
    }
}
