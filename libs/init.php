<?php
require_once ROOT.DS.'Config'.DS.'config.class.php';
require_once ROOT.DS.'Config'.DS.'config.php';
require_once ROOT.DS.'libs'.DS.'special_functions.php';

try{
    spl_autoload_register(function($classname) {
        $lib_path = ROOT.DS.'libs'.DS.strtolower($classname).'.class.php';
        $controller_path = ROOT.DS.'Controllers'.DS. str_replace('controller','',strtolower($classname)).'Controller.php';
        $model_path = ROOT.DS.'Models'.DS.($classname).'.php';
        if(file_exists($lib_path)){
            require_once ($lib_path);
        }
        if(file_exists($controller_path)){
            require_once ($controller_path);
        }
        if(file_exists($model_path)){
            require_once ($model_path);
        }
        if(!file_exists($lib_path) && !file_exists($controller_path) && !file_exists($model_path)){
            throw new Exception("Class : ".$classname." does not exist.",404);
        }
    });
}catch(Exception $e){
    echo $e->getMessage();
}

