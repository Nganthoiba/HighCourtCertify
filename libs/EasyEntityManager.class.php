<?php
/**
 * Description of EasyEntityManager
 *
 * @author Nganthoiba
 */
class EasyEntityManager {
    private $queryBuilder;
    private $response;
    public function __construct() {
        $this->queryBuilder = new EasyQueryBuilder();
        $this->response = new Response();
    }
    
    /********* START METHODS FOR CRUD OPERATIONS ********/
    //Read records from a table
    public function read($table_name): EasyQueryBuilder{
        try{
            if(class_exists($table_name)){
                $this->queryBuilder->setEntityClassName($table_name);
            }
        }
        catch(Exception $e){
            $this->queryBuilder->setEntityClassName("");
        }
        return $this->queryBuilder->select()->from($table_name);
    }
    //Create or add a new record in the table
    public function add(EasyEntity $entity): Response{
        $this->queryBuilder->setEntityClassName($entity->getTable());
        if(!$entity->isValidEntity()) {
            $this->response->set([
                "msg" => "Invalid entity: either table name or key is not set.",
                "status"=>false,
                "status_code"=>400
            ]);
        }
        else{
            try{
                $data = ($entity->toArray());
                $stmt = $this->queryBuilder->insert($entity->getTable(), $data)->execute();
                $this->response->set([
                    "msg" => "Record saved successfully.",
                    "status"=>true,
                    "status_code"=>200,
                    "data"=>$entity
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
    
    //to update or save record
    public function update(EasyEntity $entity): Response{
        $this->queryBuilder->setEntityClassName($entity->getTable());
        if(!$entity->isValidEntity()) {
            $this->response->set([
                "msg" => "Invalid entity: either table name or key is not set.",
                "status"=>false,
                "status_code"=>400
            ]);          
        }
        else{
            try{
                $data = ($entity->toArray());
                unset($data[$this->key]);//key will not be updated
                $cond = [
                    //primary key attribute = value
                    $entity->getKey() => ['=',$entity->{$entity->getKey()}]
                ];
                $stmt = $this->queryBuilder
                        ->update($entity->getTable())
                        ->set($data)
                        ->where($cond)
                        ->execute();
                
                $this->response->set([
                        "msg" => "Record updated successfully.",
                        "status"=>true,
                        "status_code"=>200,
                        "data"=>$entity,
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
    public function remove(EasyEntity $entity): Response{
        $this->queryBuilder->setEntityClassName($entity->getTable());
        if(!$entity->isValidEntity()) {
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
                    $entity->getKey() => ['=',$entity->{$entity->getKey()}]
                ];
                $stmt = $this->queryBuilder
                        ->delete()
                        ->from($entity->getTable())
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
    
    /********** END CRUD OPERATIONS *********/
}
