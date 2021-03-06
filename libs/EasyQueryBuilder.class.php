<?php
/**
 * Other files used:- 
 * Database.class.php
 * EmptyClass.class.php
 * 
 * Description of EasyQueryBuilder
 *  This class generates SQL (DML). The query is purely based on PDO.
 * #Note: this query builder generates query which can only be executed successfully 
 * on a single table, nested queries are not supported effectively. Sorry for this inconvenience we are still 
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
    public static $conn;//database connection
    
    private $limit_rows; //limit to how many rows will be selected 
    
    //This variable $data_list will be set its value in get() method
    public $data_list;//list of data after select query execution

    private $entiy_class_name;
    
    public function __construct() {
        $this->qry = "";
        $this->values = [];
        $this->db_config = Config::get('DB_CONFIG');
        self::$conn = (self::$conn==null)?Database::connect():self::$conn;//connecting database
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
        if($this->qry === ""){
            return null;
        }
        self::$conn = (self::$conn==null)?Database::connect():self::$conn;//connecting database
        $stmt = self::$conn->prepare($this->qry);
        $res = $stmt->execute($this->values);

        if(!$res){
            //Throw an exception when error occurs while executing query
            $this->errorInfo = $stmt->errorInfo();
            $this->errorCode = $stmt->errorCode();
            throw new Exception("An error occurs while executing the query. ".$this->errorInfo[2]."\n", 
                    $this->errorCode);
        }
        /* Refresing query and values after query execution */
        $this->clear();
        return $stmt;
    }
    /** This will clear existing query statement and parameter values ***/
    public function clear(){
        $this->qry = "";
        $this->values = [];
        return $this;
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
            if(trim($value)==="" || $value===NULL || $value==="NULL"){
                //blank or null values will not be inserted
                continue;
            }
            $columns .= $column.",";
            $param .= "?,";
            $this->values[] = $value;
        }
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
        if($this->entiy_class_name==""){
            $this->entiy_class_name = "EmptyClass";
        }
        try{
            $stmt = $this->execute();
            if($stmt !== null && $stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);//result
                $temp_obj = new $this->entiy_class_name();
                foreach($row as $col_name=>$value){
                    $temp_obj->{$col_name} = $value;
                }
                return $temp_obj;
            }
        }catch(Exception $e){
            //throw $e;
        }
        return null;
    }
    //method to get/read/load last row or data after executing the query.
    //it returns either null or object of the entity if record is found
    public function getLast(){
        if($this->entiy_class_name==""){
            $this->entiy_class_name = "EmptyClass";
        }
        try{
            $stmt = $this->execute();
            if($stmt !== null && $stmt->rowCount()>0){
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);//result
                $row = $rows[$stmt->rowCount()-1];
                $temp_obj = new $this->entiy_class_name();
                foreach($row as $col_name=>$value){
                    $temp_obj->{$col_name} = $value;
                }
                return $temp_obj;
            }
        }catch(Exception $e){
            //throw $e;
        }
        return null;
    }
    
    /** Method to convert to list of objects of the same entity class from a set of rows 
     * which are retrieved from a database table.
     */
    public function toList(){
        //If there is no class name specified or if the class is not defined, 
        //then we give default an empty class
        if($this->entiy_class_name==""){
            $this->entiy_class_name = "EmptyClass";
        }
        
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
        return null;
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
        $this->values = [];//clearing existing values, because new values will be set by where() method
        $this->qry = "delete ";
        return $this;
    }
    
    /** method for update clause **/
    public function update($table_name):EasyQueryBuilder{
        $this->values = [];//reset values, because new values will be set by setValues() method
        $this->qry = "update ".$table_name;
        return $this;
    }
    /*** Set parameter values and get those values ***/
    public function getValues():array{
        return $this->values;
    }
    //this will be called just after update method
    public function set($params = array()):EasyQueryBuilder{
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
    //this will be called just after update method
    public function setValues($params = array()):EasyQueryBuilder{
        //$params (parameters) are set of key-value pairs where key represent the column 
        //and value represent the value to be set to the column while updating the table
        $this->values = $params;
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
        $this->qry .= " from ".$this->getStringifiedTables($table_names); 
        return $this;
    }
    //where clause
    
    /**

     * 
     * @return string     
     * the data structure or data format of the condition should be
     * 
     * [
     *  "column_name" => ["sql_operators","values"]
     * ]
     * supported sql_operators: =,!=, <, >, NOT, IN, IS.
     */
    public function where($cond = array()):EasyQueryBuilder{
        $cond_str = trim($this->getConditionString($cond));
        if($cond_str !== ""){
            $this->qry .= " where ".$cond_str;
            $this->values = array_merge($this->values,
                    $this->getConditionValues($cond));
        }
        return $this;
    }
    
    public function not($cond = array()):EasyQueryBuilder{
        $cond_str = trim($this->getConditionString($cond));
        if($cond_str !== ""){
            $this->qry .= " not (".$cond_str.") ";
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
    
    //Inner join statement
    public function innerJoin(string $table){
        $this->qry .= " inner join ".$table." ";
        return $this;
    }
    //Inner join statement
    public function join(string $table){
        $this->qry .= " join ".$table." ";
        return $this;
    }
    
    //Left join statement
    public function leftJoin(string $table){
        $this->qry .= " left join ".$table." ";
        return $this;
    }
    //Right join statement
    public function rightJoin(string $table){
        $this->qry .= " right join ".$table." ";
        return $this;
    }
    
    public function on(string $cond_str){
        if(!is_string($cond_str)){
            throw new Exception("JION Condition must be string",500);
        }
        if($cond_str !== ""){
            $this->qry .= " on (".$cond_str.") ";
        }
        return $this;
    }
    /***** END OF QUERY BUILDING METHODS *******/
    
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
                    else if(strtolower(trim($values[0])) === "in" || strtolower(trim($values[0])) === "not in"){
                        $range = $values[1];//certain range of values
                        $str_range="";
                        foreach ($range as $val){
                            $str_range .= " ?,";
                        }
                        $cond_string .= $key." ".$values[0]." (".rtrim($str_range,',').")";
                    }
                    else if(strtolower(trim($values[0])) === "is" || strtolower(trim($values[0])) === "is not"){
                        if($values[1]==null){
                            $values[1]="NULL";
                        }
                        $cond_string .= $key." ".$values[0]." ".$values[1];
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
                if(strtolower(trim($val[0])) === "in" || strtolower(trim($val[0])) === "not in"){
                    $values = array_merge($values,$val[1]);
                }
                else if(strtolower(trim($val[0])) === "is" || strtolower(trim($val[0])) === "is not"){
                    //do nothing, not to put any values for IS operator
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
                if(is_array($val) && (strtolower(trim($val[0])) === "in" || strtolower(trim($val[0])) === "not in")){
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
    
    /**** TRANSACTIONS METHODS ****/
    public function beginTransaction(){
        self::$conn->beginTransaction();
    }
    public function rollbackTransaction(){
        self::$conn->rollBack();
    }
    public function commitTransaction(){
        self::$conn->commit();
    }
}