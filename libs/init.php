<?php
require_once CONFIG_PATH.DS.'config.class.php';
require_once CONFIG_PATH.DS.'config.php';
require_once LIBS_PATH.DS.'special_functions.php';

try{
    spl_autoload_register(function($classname) {
        $lib_path = ROOT.DS.'libs'.DS.strtolower($classname).'.class.php';
        $controller_path = CONTROLLERS_PATH.DS. str_replace('controller','',strtolower($classname)).'Controller.php';
        $model_path = MODELS_PATH.DS.($classname).'.php';
        $entity_path = ENTITY_PATH.DS.($classname).'.php';
        
        if(file_exists($lib_path)){
            require_once ($lib_path);
        }
        if(file_exists($controller_path)){
            require_once ($controller_path);
        }
        if(file_exists($model_path)){
            require_once ($model_path);
        }
        if(file_exists($entity_path)){
            require_once ($entity_path);
        }
        
        if(!file_exists($lib_path) && !file_exists($controller_path) && !file_exists($model_path) && !file_exists($entity_path)){
            throw new Exception("Class : ".$classname." does not exist.",404);
        }
        
    });
}catch(Exception $e){
    throw $e;
}

