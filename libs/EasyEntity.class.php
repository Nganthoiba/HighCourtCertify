<?php
/**
 * Description of EasyEntity
 * 
 * @author Nganthoiba
 */
class EasyEntity {
    private $table_name;
    private $key;
    private $queryBuilder;
    private $error_msg;
    public function __construct($table/*Database Table*/,$key/*Primary key of the table*/) {
        $this->table_name = $table;
        $this->key = $key;
        $this->queryBuilder = new EasyQueryBuilder();
        $this->queryBuilder->setEntityClassName($table);
        $this->error_msg = "";
    }
    
    public function getErrorInfo(){
        return $this->error_msg;
    }
    
    //Adding a new record in the table
    public function add(): bool{   
        if(!$this->isValidEntity()) {
            $this->error_msg = "Invalid entity: either table name or key is not set.";
            return false;            
        }
        try{
            $data = ($this->toArray());
            $stmt = $this->queryBuilder->insert($this->table_name, $data)->execute();
            return true;
        }catch(Exception $e){
            $this->error_msg = $e->getMessage();
            throw $e;
        }
        return false;
    }
    
    //to update record
    public function save(): bool{
        if(!$this->isValidEntity()) {
            $this->error_msg = "Invalid entity: either table name or key is not set.";
            return false;            
        }
        try{
            $data = ($this->toArray());
            $cond = [
                //primary key attribute = value
                $this->key => ['=',$this->{$this->key}]
            ];
            $stmt = $this->queryBuilder
                    ->update($this->table_name)
                    ->setValues($data)
                    ->where($cond)
                    ->execute();
            return true;
        }catch(Exception $e){
            $this->error_msg = $e->getMessage();
            throw $e;
        }
        return false;
    }
    
    //to delete record
    public function remove(): bool{
        if(!$this->isValidEntity()) {
            $this->error_msg = "Invalid entity: either table name or key is not set.";
            return false;            
        }
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
            return true;
        }catch(Exception $e){
            $this->error_msg = $e->getMessage();
            throw $e;
        }
        return false;
    }
    
    //to read record
    public function read($columns = array()): EasyQueryBuilder{
        if(!$this->isValidEntity()) {
            $this->error_msg = "Invalid entity: either table name or key is not set.";
            return null;            
        }
        return $this->queryBuilder->select($columns)->from($this->table_name);
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

    /*Convert self object to array*/
    private function toArray(){
        return json_decode(json_encode($this),true);
    }
    
    /*** Check for valid Entity ***/
    private function isValidEntity():bool{
        //If table name and key is not set, then entity is invalid
        if(trim($this->table_name) == "" || trim($this->key) == ""){
            return false;//entity is invalid
        }
        return true;//entity is valid
    }
    
}
