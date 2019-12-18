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
        try{
            $conn = new PDO(Config::get('DB_DRIVER').':host='.Config::get('DB_HOST').';dbname='.Config::get('DBNAME'), Config::get('DB_USERNAME'), Config::get('DB_PASSWORD'));
            return $conn;
        }catch(Exception $e){
            self::$conn_error = $e->getMessage();
            return null;
        }
    }
}
