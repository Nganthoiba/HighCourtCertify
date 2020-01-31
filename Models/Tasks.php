<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tasks
 *
 * @author Nganthoiba
 */
class Tasks extends model{
    /*
     * Database Table Structure
    tasks_id           integer NOT NULL,
    tasks_name         varchar(30),
    tasks_description  varchar(100),
    create_at          timestamp with time zone,
    update_at          timestamp with time zone,
    delete_at          timestamp with time zone,
    user_id            varchar(40)
    */
    
    public $tasks_id,
            $tasks_name,
            $tasks_description,
            $create_at,
            $update_at,
            $delete_at,
            $user_id;
    
    public function __construct() {
        parent::__construct();
        $this->setTable("tasks");
        $this->setKey("tasks_id");
    }
    //adding a new task record
    public function add(){
        $this->tasks_id = $this->findMaxColumnValue($this->getKey())+1;
        $this->create_at = date('Y-m-d H:i:s');
        //specifying key columns and corresponding values in an array
        $rec = [
            "tasks_id"=>$this->tasks_id,
            "tasks_name"=>$this->tasks_name,
            "tasks_description"=>$this->tasks_description,
            "create_at"=>$this->create_at,
            "user_id"=>$this->user_id
        ];
        return parent::create($rec);
    }
    //save an updated task
    public function save(){
        $this->update_at = date('Y-m-d H:i:s');
        $params = [
            "tasks_name"=>$this->tasks_name,
            "tasks_description"=>$this->tasks_description,
            "update_at"=>$this->update_at,
            "user_id"=>$this->user_id
        ];
        $cond = [
            $this->getKey() => $this->tasks_id
        ];
        return parent::update($params, $cond);
    }
    
    //Read task
    public function read($columns = array (), $cond = array (), $order_by = "") {
        $cond = "delete_at is NULL";
        $order_by = "create_at desc";
        return parent::read($columns, $cond, $order_by);
    }
    //For removing a task
    public function remove(){
        $this->update_at = date('Y-m-d H:i:s');
        $this->delete_at = date('Y-m-d H:i:s');
        $params = [
            "tasks_name"=>$this->tasks_name,
            "tasks_description"=>$this->tasks_description,
            "update_at"=>$this->update_at,
            "delete_at"=>$this->delete_at,
            "user_id"=>$this->user_id
        ];
        $cond = [
            $this->getKey() => $this->tasks_id
        ];
        $response = parent::update($params, $cond);
        $response->msg = ($response->status === true)?"Successfully removed.":"Failed to remove.";
        return $response;
    }
    
    /**** Map task with user roles ****/
    public function mapTaskWithRoles($conn,$tasks_id, $roles){
        $model = new model();
        
        $model->setTable("tasks_role_mapping");
        $model->setKey("tasks_role_mapping_id");
        
        //Delete all the task role mapping rows having the tasks_id equals to the passed perameter $tasks_id
        $qry = "delete from ".$model->getTable()." where tasks_id = ?";
        $stmt = $conn->prepare($qry);
        $res = $stmt->execute([$tasks_id]);
        if(sizeof($roles)){
            foreach ($roles as $role_id){
                $tasks_role_mapping_id = $model->findMaxColumnValue("tasks_role_mapping_id")+1;
                $qry = "insert into ".$model->getTable()."(tasks_role_mapping_id,tasks_id,role_id) values(?,?,?)";
                $stmt = $conn->prepare($qry);
                $res = $stmt->execute([
                    $tasks_role_mapping_id,
                    $tasks_id,
                    $role_id
                ]);
                if(!$res){
                    $model->response->set([
                        "error" => $stmt->errorInfo(),
                        "msg"=>"Failed to mapped with tasks_id ".$tasks_id
                    ]);
                    return $model->response;
                }
            }
        }
        $model->response->set([
            "status"=>true,
            "msg"=>"specified roles have been mapped.",
            "status_code"=>200
        ]);
        
        return $model->response;
    }
    
    //This function will return all the user role ids which have been mapped to this particular tasks id
    public function getMappedRoles($tasks_id){
        $qry = "select role_id from tasks_role_mapping where tasks_id = ?";
        $stmt = self::$conn->prepare($qry);
        $stmt->execute([$tasks_id]);
        /*return array_values($stmt->fetchall(PDO::FETCH_NUM));*/
        
        $role_ids = array();
        $res = $stmt->fetchall(PDO::FETCH_ASSOC);
        foreach ($res as $row){
            $role_ids[] = $row['role_id'];
        }
        return array_values($role_ids);
        
    }
    
    public function isRoleAllowed($role_id){
        $allowed_roles = $this->getMappedRoles($this->tasks_id);
        return in_array($role_id,$allowed_roles);
    }
}
