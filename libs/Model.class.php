<?php
/**
 * Description of model:
 * The basic CRUDE operations are defined in this class as methods like create, read, update and delete
 * 
 * @author Nganthoiba
 */
class Model {
    public static $conn;
    private $table_name;//table name
    private $key; //name of the column which is primary key
    protected $response;//output
    
    public function __construct(){
        self::$conn = (self::$conn == null)?Database::connect():self::$conn;
        $this->key = "";
        $this->table_name = "";
        $this->response = new Response();
    }
    
    public function setKey($key){
        $this->key = $key;
        return $this;
    }
    public function getKey(){
        return $this->key;
    }
    public function setTable($table_name){
        $this->table_name = $table_name;
        return $this;
    }
    public function getTable(){
        return $this->table_name;
    }
    
    //function to populate/create a new record in a table
    public function create($rec=array()){
        /* $rec is record data to be inserted, its format is an array of column name and corresponding value pairs */
        if(sizeof($rec)==0){
            $this->response->status = false;
            $this->response->msg = "Invalid data";
            $this->response->status_code = 400;
        }
        else if($this->table_name === ""){
            $this->response->status = false;
            $this->response->msg = "Specify table name.";
            $this->response->status_code = 500;
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
        if($this->table_name === ""){
            $this->response->status = false;
            $this->response->msg = "Specify table name.";
            $this->response->status_code = 500;
            return $this->response;
        }
        //getting columns or fields of a table
        $cols = $this->getColumnStatement($columns);
        
        if(!$this->isValidCondition($cond)){
            $this->response->status = false;
            $this->response->msg = "Invalid condition parameters";
            $this->response->status_code = 500;
            return $this->response;
        }
        
        //getting where condition statement clause
        $where = $this->getWhereStatement($cond);
        
        if($order_by!=""){
            $order_by = " order by ".$order_by;
        }
        $qry = "select ".$cols." from ".$this->table_name." ".$where." ".$order_by;
        $stmt = self::$conn->prepare($qry);
        // binding parameters for where condition
        if(is_array($cond) && sizeof($cond)>0){
            $res = $stmt->execute($this->getConditionValues($cond));
        }
        else{
            $res = $stmt->execute();
        }
        if(!$res){
            $this->response->status = false;
            $this->response->msg = "Failed to read data";
            $this->response->error = [$stmt->errorInfo(),$qry];
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
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data =array();
            foreach ($rows as $row){
                $obj = new $this->table_name();
                foreach ($row as $key=>$val){
                    $obj->{$key} = $val;
                }
                $data[] = $obj;
            }
            $this->response->data = $data;
        }
        return $this->response;
    }
    //Update
    public function update($params = array(),$cond = array()){
        if($this->table_name === ""){
            $this->response->status = false;
            $this->response->msg = "Specify table name.";
            $this->response->status_code = 500;
            return $this->response;
        }
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
            if(is_array($cond) && sizeof($cond)>0){
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
            if(!$this->isValidCondition($cond)){
                $this->response->status = false;
                $this->response->msg = "Invalid condition parameters.";
                $this->response->status_code = 500;
                return $this->response;
            }
            $where = $this->getWhereStatement($cond);
            $qry = "update ".$this->table_name." set ". $updates." ". $where;
            
            $stmt = self::$conn->prepare($qry);
            
            if(is_array($cond)){
                $values = array_merge(array_values($params),$this->getConditionValues($cond));
            }
            else{
                $values = array_values($params);
            }
            if($stmt->execute($values)){
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
    protected function delete($cond = array()){
        $this->response = new Response();
        if($this->table_name === ""){
            $this->response->status = false;
            $this->response->msg = "Specify table name.";
            $this->response->status_code = 500;
            return $this->response;
        }
        if(is_array($cond) && sizeof($cond) === 0){
            $cond = array(
                    "".$this->getKey() => $this->{$this->getKey()}
                );
        }
        if(!$this->isValidCondition($cond)){
            $this->response->status = false;
            $this->response->msg = "Condition parameters are invalid";
            $this->response->status_code = 403;
            return $this->response;
        }
        $where = $this->getWhereStatement($cond);
        $qry = "delete from ".$this->table_name." ".$where;
        $stmt = self::$conn->prepare($qry);
        if(is_array($cond)){
            $values = $this->getConditionValues($cond);
            $res = $stmt->execute($values);
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
        //If key is not set or table name is not set
        if($this->key === "" || $this->table_name === "") {
            return null;
        }
        $qry = "select * from ".$this->table_name. " where $this->key = :val";
        $stmt = self::$conn->prepare($qry);
        $stmt->bindParam(":val",$value);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach ($res as $col_name=>$val){
                $this->{$col_name} = $val;
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
    // #Note: this method only supports =,!=, <, >, NOT, IN, IS operators, but for other operators and some other 
    // complex conditions, you can pass condition as your own sql sub-query string.
    
    /**

     * 
     * @return string     
     * the data structure or data format of the condition should be
     * 
     * [
     *  "column_name" => ["sql_operators","values"]
     * ]
     * supported sql_operators: =,!=, <, >, NOT, IN, IS.
     * #Note: Operators 'OR' is still in development condition
     */
    protected function getWhereStatement($cond = array()):string{
        if(is_string($cond)){
            return " where ".$cond." ";
        }
        $where = "";//where condition
        //If the condition is in the form of array
        if(is_array($cond) && sizeof($cond)>0){
            $where = " where ";
            foreach ($cond as $key => $values){
                if(is_array($values)){
                    //$values[0] is the sql operator
                    if(strtolower(trim($values[0])) === "between"){
                        $where .= $key." ".$values[0]." ? and ?";
                    }
                    else{
                        $where .= $key." ".$values[0]." ?";
                    }
                }
                else{
                    $where .= $key.'= ?';
                }
                $where .= " and ";
            }
        }
        return rtrim($where,"and ");
    }
    
    //getting update sub-clause statement by providing parameters
    protected function getUpdateStatement($params = array()){
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
    
    
    private function getConditionValues($cond = array()){
        $values = array();
        if(is_string($cond)){
            return $values;//return empty array
        }
        
        foreach($cond as $key=>$val){
            if(is_array($val) && sizeof($val)>=2){
                array_push($values,$val[1]);
                if(strtolower(trim($val[0])) === "between"){
                    array_push($values,$val[2]);
                }
            }
            else{
                array_push($values,$val);
            }
        }
        return $values;
    }
    
    private function isValidCondition($cond = array()){
        //if the condition is passed as a string then return true
        if(is_string($cond)){
            return true;
        }
        if(is_array($cond) && sizeof($cond)===0){
            return true;
        }
        if(is_array($cond) && sizeof($cond)>0){
            foreach($cond as $key=>$val){
                if(is_array($val) && sizeof($val)<2){
                    $this->response->error = [
                        "Detail"=>"Error SQL Operator",
                        "SQL Operator"=>$val];
                    return false;
                }
                if(is_array($val) && strtolower(trim($val[0])) === "between" && sizeof($val) < 3){
                    
                    $this->response->error = [
                        "Detail"=>"Error SQL Operator, missing perameters",
                        "SQL Operator"=>$val];
                    return false;
                    
                }
            }
            return true;
        }
        return false;
    }
    
    //find maximum value of a column, the column should be of integer data type preferrably
    protected function findMaxColumnValue($column/*Column name*/){
        $stmt = self::$conn->prepare("select max(".$column.") as max_val from ".$this->getTable());
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return 0;
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_val'] == NULL?0:is_numeric($row['max_val'])?(int)$row['max_val']:$row['max_val'];
    }
    
    /*** closing database connection ***/
    public function close(){
        self::$conn = null;
    }    
}