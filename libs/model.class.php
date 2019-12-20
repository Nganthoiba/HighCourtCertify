<?php
/**
 * Description of model:
 * This based class has been designed so that developer does not have to write the underlying database queries 
 * The basic CRUDE operations are defined in this class as methods as create, read, update and delete
 * This model class acts as an entity in this framework
 * 
 * @author Nganthoiba
 */
class model {
    public static $conn;
    private $table_name;//table name
    private $key; //name of the column which is primary key
    protected $response;//output
    
    public function __construct(){
        self::$conn = Database::connect();
        $this->key = "";
        $this->response = new Response();
    }
    
    public function setKey($key){
        $this->key = $key;
    }
    public function getKey(){
        return $this->key;
    }
    public function setTable($table_name){
        $this->table_name = $table_name;
    }
    public function getTable(){
        return $this->table_name;
    }
    
    //function to populate a new record in a table
    public function create($rec=array()){
        /* $rec is record data to be inserted, its format is an array of column name and corresponding value pairs */
        if(sizeof($rec)==0){
            $this->response->status = false;
            $this->response->msg = "Invalid data";
            $this->response->status_code = 400;
        }
        else{
            $columns = "";//strings of names of the columns
            $param = "";//parameters
            foreach($rec as $column => $value){
                $columns .= $column.",";
                $param .= "?,";
            }
            $qry = "insert into ".$this->table_name."(".rtrim($columns,',').") values(".rtrim($param,',').")";
            
            $stmt = self::$conn->prepare($qry);
            if($stmt->execute(array_values($rec))){
                $this->response->status = true;
                $this->response->status_code = 200;
                $this->response->msg = "Record inserted";
                $this->response->data = $rec;
            }
            else{
                $this->response->status = false;
                $this->response->msg = "Failed to insert record";
                $this->response->error = $stmt->errorInfo();
                $this->response->status_code = 500;
            }
        }
        return $this->response;
    }
    
    //function to read data from a particular table
    public function read($columns=array(),$cond = array(),$order_by=""){
        
        //getting columns or fields of a table
        $cols = $this->getColumnStatement($columns);
        
        //getting where condition statement clause
        $where = $this->getWhereStatement($cond);
        
        if($order_by!=""){
            $order_by = " order by ".$order_by;
        }
        $qry = "select ".$cols." from ".$this->table_name." ".$where." ".$order_by;
        $stmt = self::$conn->prepare($qry);
        // binding parameters for where condition
        if(is_array($cond) && sizeof($cond)>0){
            $res = $stmt->execute(array_values($cond));
        }
        else{
            $res = $stmt->execute();
        }
        if(!$res){
            $this->response->status = false;
            $this->response->msg = "Failed to read data";
            $this->response->error = $stmt->errorInfo();
            $this->response->status_code = 500;
        }
        else if($stmt->rowCount()==0){
            $this->response->status = false;
            $this->response->msg = "No record found";
            $this->response->status_code = 404;
        }
        else{
            $this->response->status = true;
            $this->response->status_code = 200;
            $this->response->msg = "Record found";
            $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
            $data =array();
            foreach ($rows as $row){
                $obj = new $this->table_name();
                foreach ($row as $key=>$val){
                    $obj->$key = $val;
                }
                $data[] = $obj;
            }
            $this->response->data = $data;
        }
        return $this->response;
    }
    //Update
    public function update($params = array(),$cond = array()){
        if($params==null ||(!is_array($params) || sizeof($params)==0)){
            //update perameters must not be empty and must be array of key value pairs which means column name and its corresponding value
            $this->response->status = false;
            $this->response->msg = "Invalid input parameters.";
            $this->response->status_code = 400;
        }
        else{
            //update sub query
            $updates = $this->getUpdateStatement($params);    
            //getting where condition clause
            if(is_array($cond) && sizeof($cond) == 0){
                if($this->getKey()==="" || $this->{$this->getKey()}===""){
                    $this->response->status = false;
                    $this->response->msg = "Failed to update record, object key is not set.";
                    $this->response->status_code = 500;
                    return $this->response;
                }
                $cond = array(
                    "".$this->getKey() => $this->{$this->getKey()}
                );
            }
            $where = $this->getWhereStatement($cond);
            $qry = "update ".$this->table_name." set ". $updates." ". $where;
            //return $qry;
            $stmt = self::$conn->prepare($qry);
            //binding parameters
            $bindParams = is_array($cond)?array_merge($params,$cond):$params;
            
            if($stmt->execute(array_values($bindParams))){
                $this->response->status = true;
                $this->response->msg = "Successfully updated";
                $this->response->status_code = 200;
            }
            else{
                $this->response->status = false;
                $this->response->msg = "Failed to update record";
                $this->response->error = $stmt->errorInfo();
                $this->response->status_code = 500;
            }
        }
        return $this->response;
    }
    //Delete record from table
    public function delete($cond = array()){
        $this->response = new Response();
        if(is_array($cond) && sizeof($cond)==0){
            $this->response->status = false;
            $this->response->msg = "Condition parameters are not set";
            $this->response->status_code = 403;
            return $this->response;
        }
        $where = $this->getWhereStatement($cond);
        $qry = "delete from ".$this->table_name." ".$where;
        $stmt = self::$conn->prepare($qry);
        if(is_array($cond)){
            $res = $stmt->execute(array_values($cond));
        }
        else{
            $res = $stmt->execute();
        }
        if($res){
            $this->response->status = true;
            $this->response->msg = "Successfully deleted";
            $this->response->status_code = 200;
        }
        else{
            $this->response->status = false;
            $this->response->msg = "Failed to delete record";
            $this->response->error = $stmt->errorInfo();
            $this->response->status_code = 500;
        }
        return $this->response;
    }
    
    public function find($value){
        if($this->key === "") return null;
        //$m = new $this->table_name();//dynamic model
        $qry = "select * from ".$this->table_name. " where $this->key = :val";
        $stmt = self::$conn->prepare($qry);
        $stmt->bindParam(":val",$value);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach ($res as $col_name=>$val){
                $this->$col_name = $val;
            }
        }
        else{
            return null;
        }
        return $this;
    }
    
    //get columns statement
    protected function getColumnStatement($columns = array()){
        if(is_string($columns)){
            return " ".$columns." ";
        }
        
        $cols = "";
        if(sizeof($columns)>0){
            foreach($columns as $key=>$col){
                $cols .= $col;
                if($key < (count($columns)-1) && trim($col) !=="")
                {
                    $cols .= ",";
                }
            }
        }
        else{
            $cols = " * ";//select all columns
        }
        return $cols;
    }
    
    //getting where sub-clause statement
    protected function getWhereStatement($cond = array()){
        if(is_string($cond)){
            return " where ".$cond." ";
        }
        $where = "";//where condition
        if(sizeof($cond)>0){
            $where = " where ";
            $cnt = 0;//count conditions
            $arrayKeys = array_keys($cond);
            foreach ($arrayKeys as $key){
                $where .= $key.'= ?';
                if($cnt < (sizeof($cond)-1)){
                    $where .= " and ";
                }
                $cnt++;
            }
        }
        return $where;
    }
    
    //getting update sub-clause statement by providing parameters
    private function getUpdateStatement($params = array()){
        $updates = "";//update sub query
        $cnt = 0;//count update parameters
        $arrayKeys = array_keys($params);
        foreach ($arrayKeys as $col_name){
            $updates .= $col_name." = ?";
            if($cnt < (sizeof($params)-1)){
                $updates .= ",";
            }
            $cnt++;
        }
        return $updates;
    }


    /*** closing database connection ***/
    public function close(){
        self::$conn = null;
    }
}
