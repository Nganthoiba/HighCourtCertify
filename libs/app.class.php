<?php

/**
 * Description of App
 *
 * @author Nganthoiba
 */
class App {
    protected static $router;
    
    public static function getRouter(){
        return self::$router;
    }
    
    public static function run($uri){
        self::$router = new Router($uri);
        /** Controller Class Name **/
        $controller = ucfirst(self::$router->getController()).'Controller';
        
        /** Action/Method Name **/
        $method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());
        
        /*** Controller Object ***/
        $controllerObj = new $controller();
        if(method_exists($controllerObj, $method)){
            $controllerObj->setRouter(self::$router);//very much necessary
            $view = $controllerObj->$method();
            //Controller Action may returns view or json data depending upon whether the controller is api controller or just controller, and it is going to be printed
            echo $view;
        }
        else {
            throw new Exception("Method '".$method."' of controller class '".$controller."' does not exist.");
        }
   
    }
}
