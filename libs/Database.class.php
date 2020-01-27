<?php
/**
 * Description of Database
 *  This Database class is to connect database
 * @author Nganthoiba
 */
class Database {
    public static $conn_error;//Database connection error
    public static function connect(){
        self::$conn_error = "";
        /***** Retrieving Database Configurations *****/
        $db_config = Config::get("DB_CONFIG");
        $db_driver = $db_config["DB_DRIVER"];
        $db_host = $db_config["DB_HOST"];
        $db_port = $db_config["DB_PORT"];
        $db_name = $db_config["DB_NAME"];
        $db_username = $db_config["DB_USERNAME"];
        $db_password = $db_config["DB_PASSWORD"];
        $persistent = $db_config["PERSISTENT"]??false;
        
        /*Data Source Name, database connection string*/
        $DSN = $db_driver.':host='.$db_host.';dbname='.$db_name;
        
        try{
            $conn = new PDO(
                    $DSN, 
                    $db_username, 
                    $db_password,
                    array(PDO::ATTR_PERSISTENT => $persistent)
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
}
