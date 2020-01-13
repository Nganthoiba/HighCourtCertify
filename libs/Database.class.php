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
            if(!$conn){
                throw new Exception("Database connection failed, make sure that your database server is up.",503);
            }
            return $conn;
        }catch(Exception $e){
            self::$conn_error = $e->getMessage();
            throw $e;
            //return null;
        }
    }
}
