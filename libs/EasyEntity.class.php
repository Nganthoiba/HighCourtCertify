<?php
/**
 * Description of EasyEntity
 * 
 * The basic CRUDE operations than can be operated on a database table are defined in this 
 * class as methods as follows:- 
 * 
 *      add     :-  for (C)creating/inserting a new (entity)record into a table, 
 *      read    :-  for (R)reading/retrieving records form table, 
 *      save    :-  for (U)updating an (entity) existing record and 
 *      remove  :-  for (D)deleting a record(entity) from table
 * 
 *      All these methods has return type of Response class, except read method returns an
 *      object of EasyQueryBuilder class.
 * 
 * Other php file used:-
 *      EasyQueryBuilder.class.php
 *      Response.class.php
 * @author Nganthoiba
 */
class EasyEntity {
    private $table_name;
    private $key;
    private $queryBuilder;
    private $response;
    public function __construct() {
        /* Entity name should be same as the table name that exists in database */
        $this->table_name = get_class($this);//by default
        $this->queryBuilder = new EasyQueryBuilder();
        $this->queryBuilder->setEntityClassName($this->table_name);//by default
        $this->response = new Response();
    }
    protected function setTable($table_name){
        $this->table_name = $table_name;
        $this->queryBuilder->setEntityClassName($this->table_name);
        return $this;
    }
    protected function getTable(){
        return $this->table_name;
    }
    //method to set key of the enity
    protected function setKey($key){
        $this->key = $key;
        return $this;
    }
    //method to get key of the enity
    protected function getKey(){
        return $this->key;
    }
    
    //method to get query builder
    public function getQueryBuilder():EasyQueryBuilder{
        return $this->queryBuilder;
    }
    
    /*Convert self object to array*/
    private function toArray(){
        return json_decode(json_encode($this),true);
    }
    
    /*** Check for valid Entity ***/
    private function isValidEntity():bool{
        //If table name and key is not set, then entity is invalid
        if(trim($this->table_name) == "" || trim($this->key) == "" || $this->table_name == "EasyEntity"){
            return false;//entity is invalid
        }
        return true;//entity is valid
    }
    
    /********* START CRUD OPERATIONS ********/
    //Creat or add a new record in the table
    public function add(): Response{   
        if(!$this->isValidEntity()) {
            $this->response->set([
                "msg" => "Invalid entity: either table name or key is not set.",
                "status"=>false,
                "status_code"=>400
            ]);
        }
        else{
            try{
                $data = ($this->toArray());
                $stmt = $this->queryBuilder->insert($this->table_name, $data)->execute();
                $this->response->set([
                    "msg" => "Record saved successfully.",
                    "status"=>true,
                    "status_code"=>200,
                    "data"=>$this
                ]);
            }catch(Exception $e){
                $this->response->set([
                    "msg" => "Sorry, an error occurs while saving the record. ".$e->getMessage(),
                    "status"=>false,
                    "status_code"=>500,
                    "error"=>$this->queryBuilder->getErrorInfo()
                ]);
            }
        }
        return $this->response;
    }
    //to read record
    public function read($columns = array()): EasyQueryBuilder{
        return $this->queryBuilder->select($columns)->from($this->table_name);
    }
    //to update and save record
    public function save(): Response{
        if(!$this->isValidEntity()) {
            $this->response->set([
                "msg" => "Invalid entity: either table name or key is not set.",
                "status"=>false,
                "status_code"=>400
            ]);          
        }
        else{
            try{
                $data = ($this->toArray());
                unset($data[$this->key]);//key will not be updated
                $cond = [
                    //primary key attribute = value
                    $this->key => ['=',$this->{$this->key}]
                ];
                $stmt = $this->queryBuilder
                        ->update($this->table_name)
                        ->setValues($data)
                        ->where($cond)
                        ->execute();
                
                $this->response->set([
                        "msg" => "Record updated successfully.",
                        "status"=>true,
                        "status_code"=>200,
                        "data"=>$data,
                        "error"=>[
                            "qry"=>$this->queryBuilder->getQuery(),
                            "values"=>$this->queryBuilder->getValues()
                        ]
                    ]);
                $this->queryBuilder->clear();
            }catch(Exception $e){
                $this->response->set([
                        "msg" => "Sorry, an error occurs while updating the record. ".$e->getMessage(),
                        "status"=>false,
                        "status_code"=>500,
                        "error"=>$this->queryBuilder->getErrorInfo()
                    ]);
            }
        }
        return $this->response;
    }
    
    //to delete record
    public function remove(): Response{
        if(!$this->isValidEntity()) {
            $this->response->set([
                "msg" => "Invalid entity: either table name or key is not set.",
                "status"=>false,
                "status_code"=>400
            ]);            
        }
        else{
            try{
                $cond = [
                    //primary key attribute = value
                    $this->key => ['=',$this->{$this->key}]
                ];
                $stmt = $this->queryBuilder
                        ->delete()
                        ->from($this->table_name)
                        ->where($cond)
                        ->execute();
                $this->response->set([
                        "msg" => "Record removed successfully.",
                        "status"=>true,
                        "status_code"=>200
                    ]);
            }catch(Exception $e){
                $this->response->set([
                        "msg" => "Sorry, an error occurs while removing the record. ".$e->getMessage(),
                        "status"=>false,
                        "status_code"=>500,
                        "error"=>$this->queryBuilder->getErrorInfo()
                    ]);
            }
        }
        return $this->response;
    }
    
    
    /*** find an Entity ***/
    public function find($id){
        //If Entity is not valid
        if(!$this->isValidEntity()) {
            return null;
        }
        $stmt = $this->queryBuilder->select()->from($this->table_name)->where([
            $this->key => ['=',$id]
        ])->execute();
        if($stmt->rowCount()){
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
    /********** END CRUD OPERATIONS *********/
    
    //find maximum value of a column, the column should be of integer data type preferrably
    public function findMaxColumnValue($column/*Column/Attribute name*/){
        $stmt = $this->read(" max(".$column.") as max_val")->execute();
        if($stmt->rowCount() == 0){
            return 0;
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_val'] == NULL?0:is_numeric($row['max_val'])?(int)$row['max_val']:$row['max_val'];
    }
}
