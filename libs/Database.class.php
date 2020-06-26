<?php
/**
 * Description of Database
 *  This Database class is to connect database
 * @author Nganthoiba
 */
/*
 * Syntax for using Database class
 * $conn = Database::connect([
        "DB_HOST" => "localhost",
        "DB_PORT" => 5432,
        "DB_DRIVER"=>"pgsql", //Database driver
        "DB_NAME" => "Database name",
        "DB_USERNAME" => "username",
        "DB_PASSWORD" => "password",
        "PERSISTENT" => false
    ]);
    For setting database driver DB_DRIVER. Use the followings:
 * 1. mysql     :-  for MySql Database Server
 * 2. pgsql     :-  for Postgres Database Server
 * 3. sqlsrv    :-  for Microsoft SQL Database Server
 */

class Database {
    public static $conn_error;//Database connection error
    public static $db_server; //Database server name
    public static function connect($db_config = null){
        self::$conn_error = "";
        /***** Retrieving Database Configurations *****/
        if($db_config == null){
            $db_config = Config::get("DB_CONFIG");
        }
        self::$db_server = $db_driver = $db_config["DB_DRIVER"];
        $db_host = $db_config["DB_HOST"];
        $db_port = $db_config["DB_PORT"];
        $db_name = $db_config["DB_NAME"];
        $db_username = $db_config["DB_USERNAME"];
        $db_password = $db_config["DB_PASSWORD"];
        $persistent = isset($db_config["PERSISTENT"])?$db_config["PERSISTENT"]:false;
        
        /*Data Source Name, database connection string*/
        
        switch(self::$db_server ){
            //For Microsoft SQL Database Server
            case 'sqlsrv':
                $DSN = $db_driver.':Server='.$db_host.',$db_port;Database='.$db_name.';';
                break;
            //Other SQL Database Server
            default:
                $DSN = $db_driver.':host='.$db_host.';dbname='.$db_name.';port='.$db_port;
        }
                
        try{
            $conn = new PDO(
                    $DSN, 
                    $db_username, 
                    $db_password,
                    [PDO::ATTR_PERSISTENT => $persistent]
                    );
            if(!$conn){
                self::$conn_error = "Database connection failed.";
                throw new Exception("Database connection failed.",503);
            }
            return $conn;
        }catch(Exception $e){
            self::$conn_error = $e->getMessage();
            throw $e;
        }
        return null;
    }
    //closing connection
    public static function close(){
        self::$conn = null;
    }
}