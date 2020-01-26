<?php
/**
 * Description of EasyQueryBuilder
 *  This class generates SQL (DML). The query is purely based on PDO.
 * #Note: this query builder generates query which can only be executed successfully 
 * on a single table, nested queries are not supported. Sorry for this inconvenience we are still 
 * working on it to solve SQL complex queries.
 * So, for now you can set your own query using setQuery() method and execute using execute() method
 * @author Nganthoiba
 */
class EasyQueryBuilder {
    /** SQL Query String**/
    private $qry;
    /** Array of values for parameterized query execution */
    private $values;
    /** Error data in query execution **/
    private $errorInfo;
    private $errorCode;
    
    private $db_config;//db configuration
    private $conn;//database connection
    
    private $limit_rows; //limit to how many rows will be selected 
    
    //This variable $data_list will be set its value in get() method
    public $data_list;//list of data after select query execution

    private $entiy_class_name;
    
    public function __construct() {
        $this->qry = "";
        $this->values = [];
        $this->db_config = Config::get('DB_CONFIG');
        $this->conn = Database::connect();
        $this->limit_rows = -1;
        $this->data_list = [];
        $this->entiy_class_name = "";
    }
    
    public function setEntityClassName($class_name):void{
        $this->entiy_class_name = $class_name;
    }
    
    public function getErrorInfo(){
        return $this->errorInfo;
    }
    public function getErrorCode(){
        return $this->errorcode;
    }
    
    /*Method to execute query statement*/
    public function execute(): PDOStatement{
        if($this->conn === null){
            return null;
        }
        if($this->qry === ""){
            return null;
        }
        $stmt = $this->conn->prepare($this->qry);
        $res = $stmt->execute($this->values);
        
        if(!$res){
            //Throw an exception when error occurs while executing query
            $this->errorInfo = $stmt->errorInfo();
            $this->errorCode = $stmt->errorCode();
            throw new Exception("An error occurs while executing the query. ".$this->errorInfo[2], 
                    $this->errorCode);
        }
        //otherwise return query execution statement
        return $stmt;
    }
    /*** Set query and get query ***/
    public function getQuery():string{
        return $this->qry;
    }
    /** A method to set programmer's own complex query when 
     * the query building methods defined below cannot fulfill the required output.**/
    public function setQuery($query):EasyQueryBuilder{
        $this->qry = $query;
        return $this;
    }
    
    /***** QUERY BUILDING METHODS ******/
    //method to create insert sub query
    public function insert($table_name, array $data=array()):EasyQueryBuilder{
        
        //$data are set of key-value pairs where key represents column 
        //whereas value represent the particular value to be inserted to the column
        $columns = "";//strings of names of the columns
        $param = "";//parameters
        foreach($data as $column => $value){
            $columns .= $column.",";
            $param .= "?,";
        }
        $this->values = array_values($data);
        $this->qry = "insert into ".$table_name."(".rtrim($columns,',').") values(".rtrim($param,',').")";
        return $this;
    }
    
    //method to get/read/load all data after executing the query
    //returns either null or set of data
    public function get(){
        try{
            $stmt = $this->execute();
            if($stmt !== null){
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);//result
                $this->data_list = $this->getRowsUptoLimit($rows);
                return $this->data_list;
            }
        }catch(Exception $e){
            throw $e;
        }
        return null;
    }
    //method to get/read/load first row or data after executing the query.
    //it returns either null or object of the entity if record is found
    public function getFirst(){
        $this->entiy_class_name = $this->entiy_class_name==""?"EmptyClass":$this->entiy_class_name;
        try{
            $stmt = $this->execute();
            if($stmt !== null){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);//result
                $temp_obj = new $this->entiy_class_name();
                foreach($row as $col_name=>$value){
                    $temp_obj->{$col_name} = $value;
                }
                return $temp_obj;
            }
        }catch(Exception $e){
            throw $e;
        }
        return null;
    }
    
    /** Method to convert to list of objects of the same entity class from a set of rows 
     * which are retrieved from a database table.
     */
    public function toList(){
        $this->entiy_class_name = $this->entiy_class_name==""?"EmptyClass":$this->entiy_class_name;
        try{
            $stmt = $this->execute();
            if($stmt !== null){
                $rows = $this->getRowsUptoLimit($stmt->fetchAll(PDO::FETCH_ASSOC));
                if(sizeof($rows) == 0){
                    return null;
                }
                $entity_array = [];
                foreach ($rows as $row){
                    $temp_obj = new $this->entiy_class_name();
                    foreach($row as $col_name=>$value){
                        $temp_obj->{$col_name} = $value;
                    }
                    array_push($entity_array,$temp_obj);
                }
                return $entity_array;
            }
        }catch(Exception $e){
            throw $e;
        }
    }
    
    //limit function
    private function getRowsUptoLimit($rows = array()):array{
        $temp_rows = array();
        if($this->limit_rows === -1 || $this->limit_rows === 0){
            return $rows;
        }
        $cnt = 1;
        foreach ($rows as $row){
            if($cnt > $this->limit_rows){
                break;
            }
            array_push($temp_rows,$row);
            $cnt++;
        }
        return $temp_rows;
    }
    
    //method for delete clause
    public function delete():EasyQueryBuilder{
        $this->qry = "delete ";
        return $this;
    }
    
    /** method for update clause **/
    public function update($table_name):EasyQueryBuilder{
        $this->qry = "update ".$table_name;
        return $this;
    }
    //this will be called just after update method
    public function setValues($params = array()):EasyQueryBuilder{
        //$params (parameters) are set of key-value pairs where key represent the column 
        //and value represent the value to be set to the column while updating the table
        $this->qry .= " set ";
        foreach ($params as $key => $value) {
            $this->qry .= $key." = ? ,";
            array_push($this->values,$value);
        }
        $this->qry = rtrim($this->qry,',');
        return $this;
    }
    
    /***** End of update clause *****/
    
    /***** select clause methods *****/
    //JOIN is not supported so far, it is still under development.
    public function select($columns = array()/* Array of columns of  table */):EasyQueryBuilder{
        //if columns are passed as array, then we stringify the columns separated by commas
        $column_string = $this->getStringifiedColumns($columns);
        if(trim($column_string)=== ""){
            $this->qry .= " select * ";
        }else{
            $this->qry .= " select ".$column_string." ".$this->qry;
        }
        return $this;
    }
    
    //method for from clause
    public function from($table_names = array()/*array of table names*/):EasyQueryBuilder{
        $this->qry .= " from ".$this->getStringifiedTables($tables); 
        return $this;
    }
    //where clause
    public function where($cond = array()):EasyQueryBuilder{
        $cond_str = trim($this->getConditionString($cond));
        if($cond_str !== ""){
            $this->qry .= " where ".$cond_str;
            $this->values = array_merge($this->values,
                    $this->getConditionValues($cond));
        }
        return $this;
    }
    
    public function or($cond = array()):EasyQueryBuilder{
        $cond_str = trim($this->getConditionString($cond));
        if($cond_str !== ""){
            $this->qry .= " or (".$cond_str.") ";
            $this->values = array_merge($this->values,
                    $this->getConditionValues($cond));
        }
        return $this;
    }
    public function and($cond = array()):EasyQueryBuilder{
        $cond_str = trim($this->getConditionString($cond));
        if($cond_str !== ""){
            $this->qry .= " and (".$cond_str.") ";
            $this->values = array_merge($this->values,
                    $this->getConditionValues($cond));
        }
        return $this;
    }
    
    public function having($cond = array()):EasyQueryBuilder{
        $cond_str = trim($this->getConditionString($cond));
        if($cond_str !== ""){
            $this->qry .= " having ".$cond_str;
            $this->values = array_merge($this->values,
                    $this->getConditionValues($cond));
        }
        return $this;
    }
    //By default order by is ascending
    public function orderBy($columns=array()):EasyQueryBuilder{
        $order_by = $this->getStringifiedColumns($columns);
        $this->qry .= trim($order_by)===""?"":" order by ".$order_by;
        return $this;
    }
    //Order by is descending
    public function orderByDesc($columns=array()):EasyQueryBuilder{
        $order_by = $this->getStringifiedColumns($columns);
        $this->qry .= trim($order_by)===""?"":" order by ".$order_by." desc";
        return $this;
    }
    
    public function groupBy(array $columns=array()):EasyQueryBuilder{
        $group_by = $this->getStringifiedColumns($columns);
        $this->qry .= trim($group_by)===""?"":" group by ".$group_by;
        return $this;
    }
    
    //To limit upto some number of rows while getting data from table
    public function take($no_of_rows):EasyQueryBuilder{
        $db_driver = $this->db_config['DB_DRIVER'];
        switch($db_driver){
            case 'pgsql':
            case 'mysql':
                $this->qry .= " limit ".$no_of_rows; 
                break;
            case 'sqlsrv':
                $this->qry .= " top ".$no_of_rows; 
        }
        return $this;
    }
    
    public function limit($no_of_rows):EasyQueryBuilder{
        $this->limit_rows = $no_of_rows;
        return $this;
    }
    
    /** Method to convert array of conditions into string ****/
    private function getConditionString($cond = array()):string{
        if(is_string($cond)){
            return " ".$cond." ";
        }
        /**** Validating the condition parameters ****/
        if(!$this->isValidCondition($cond)){
            $message = $this->errorInfo['Detail'];
            throw new Exception($message, 500);
        }
        $cond_string = "";//stringified condition
        //If the condition is in the form of array
        if(is_array($cond) && sizeof($cond)>0){
            foreach ($cond as $key => $values){
                if(is_array($values)){
                    //$values[0] is the sql operator
                    if(strtolower(trim($values[0])) === "between"){
                        $cond_string .= $key." ".$values[0]." ? and ?";
                    }
                    else if(strtolower(trim($values[0])) === "in"){
                        $range = $values[1];//certain range of values
                        $str_range="";
                        foreach ($range as $val){
                            $str_range .= " ?,";
                        }
                        $cond_string .= $key." ".$values[0]." (".rtrim($str_range,',').")";
                    }
                    else{
                        $cond_string .= $key." ".$values[0]." ?";
                    }
                }
                else{
                    $cond_string .= $key.'= ?';
                }
                $cond_string .= " and ";
            }
        }
        return rtrim($cond_string,"and ");
    }
    
    //method to get values for parameterised query
    private function getConditionValues($cond = array()):array{
        $values = array();
        if(is_string($cond)){
            return $values;//return empty array
        }
        
        foreach($cond as $key=>$val){
            if(is_array($val) && sizeof($val)>=2){
                if(strtolower(trim($val[0])) === "in"){
                    $values = array_merge($values,$val[1]);
                }
                else{
                    array_push($values,$val[1]);
                }
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
    
    //Method to check whether condition is valid or not
    private function isValidCondition($cond = array()):bool{
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
                    $this->errorInfo = [
                                "Detail"=>"Error in SQL Operator ".$val[0].", missing parameters or value(s) ",
                                "SQL Operator"=>$val
                            ];
                    
                    return false;
                }
                if(is_array($val) && strtolower(trim($val[0])) === "between" && sizeof($val) < 3){
                    
                    $this->errorInfo = [
                        "Detail"=>"Error in SQL Operator  $val[0], missing perameters \n"
                        . "e.g. condition should be set as [column => 'between',10,20]",
                        "SQL Operator"=>$val];
                    return false;
                    
                }
                if(is_array($val) && (strtolower(trim($val[0])) === "in" || strtolower(trim($val[0])) === "any" || strtolower(trim($val[0])) === "all")){
                    if(!isset($val[1]) || !is_array($val[1]) || (is_array($val[1]) && sizeof($val[1])===0)){
                        $this->errorInfo = [
                            "Detail"=>"Error SQL Operator $val[0], missing perameters, \n"
                                . "the parameters must be an array of values \n"
                            . "e.g. condition should be set as [column => '".$val[0]."',[10,20,30]]",
                            "SQL Operator"=>$val];
                        return false;
                    }                    
                }
            }
            return true;
        }
        return false;
    }
    
    private function getStringifiedColumns($columns = array()):string{
        //if columns are passed as array, then we stringify the columns separated by commas
        if(is_string($columns)){
            return $columns;
        }
        //otherwise columns are in the form of array
        $column_string = "";
        foreach ($columns as $col){
            $column_string .= $col.", ";
        }
        return rtrim($column_string,', ');
    }
    private function getStringifiedTables($tables = array()):string{
        //if tables are passed as array, then we stringify the tables separated by commas
        if(is_string($tables)){
            return $tables;
        }
        //otherwise tables are in the form of array
        $tables_string = "";
        foreach ($tables as $table){
            $tables_string .= $table.", ";
        }
        return rtrim($tables_string,', ');
    }
    /**************** END OF QUERY BUILDING METHODS *****************/    
    /**** Destructor****/
    public function __destruct() {
        $this->conn = null;
    }
}