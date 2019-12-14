<?php
/*** Path Configurations ***/
define('DS', '/');
define('ROOT', '../');
define('VIEWS_PATH', ROOT.DS.'Views');

/*******************************/
require_once ROOT.DS.'libs/init.php';
/********************************/
//custom functions for the highcourt project
require_once ROOT.DS.'copying_functions/application_logs.php';
require_once ROOT.DS.'copying_functions/redirection.php';

//starting session securely
startSecureSession();
date_default_timezone_set(Config::get('default_time_zone'));

//$uri = trim($_SERVER['REQUEST_URI'], '/');
$uri = filter('uri', "GET");

try{
    App::run($uri);
}catch(Exception $e){
    //echo $e->getMessage();
    $error = array("content"=>"404 Error: The resource you have requested is not found.","detail"=>$e->getMessage());
    $controller = new Controller($error);
    $controller->setRouter(new Router($uri));
    echo $controller->view('error');
}
 
