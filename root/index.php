<?php
//Loading path configuration
require_once '../Config/path_config.php';

/*******************************/
require_once LIBS_PATH.'/init.php';
require_once INCLUDES_PATH.'/include_files.php';
/********************************/

//starting session securely
startSecureSession();
date_default_timezone_set(Config::get('default_time_zone'));

//$uri = trim($_SERVER['REQUEST_URI'], '/');
$uri = filter('uri', "GET");

try{
    App::run($uri);
}catch(Exception $e){
    $error_code = $e->getCode();
    $detail = ($error_code==404)?"The requested resource is not found.":$e->getMessage();
    $error = array("content"=>"Error: ".$error_code,"detail"=>$detail);
    $controller = new Controller($error);
    $controller->setRouter(new Router($uri));
    echo $controller->view('error');
}
 
