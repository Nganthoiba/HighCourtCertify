<?php
/**
 * Description of Document
 *
 * @author Nganthoiba
 */
class Document extends model{
    public  $document_id,
            $application_id,
            $document_path,
            $create_at,
            $delete_at,
            $created_by,
            $document_title,
            $update_at,
            $purpose;
    public function __construct($doc = array()) {
        parent::__construct();
        $this->setTable('document');
        $this->setKey('document_id');
        
        $this->application_id = isset($doc['application_id'])?$doc['application_id']:"";
        $this->document_path = isset($doc['document_path'])?$doc['document_path']:"";
        $this->create_at = date('Y-m-d H:i:s');
        $this->created_by = isset($doc['created_by'])?$doc['created_by']:"";
        $this->document_title = isset($doc['document_title'])?$doc['document_title']:"";
        $this->purpose = isset($doc['purpose'])?$doc['purpose']:"";
    }
    //add a new document for an application
    public function add(){
        /*** getting new document id ***/
        $qry = "select max(document_id)+1 as new_document_id from ".$this->getTable();
        $stmt = self::$conn->prepare($qry);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row['new_document_id'] == NULL){
            $this->document_id = 1;
        }
        else{
            $this->document_id = (int)$row['new_document_id'];
        } 
        /********************************/
        $rec = array(
            "document_id"=>$this->document_id,
            "application_id"=>$this->application_id,
            "document_path"=>$this->document_path,
            "create_at"=>$this->create_at,
            "created_by"=>$this->created_by,
            "document_title"=>$this->document_title,
            "purpose"=>$this->purpose
        );
        $response = parent::create($rec);
        return $response;
    }
    
    public function remove($document_id){
        $params = array("delete_at"=>date('Y-m-d H:i:s'));
        return parent::update($params);
    }
    
    public function save(){
        $param = array(
            "application_id"=>$this->application_id,
            "document_path"=>$this->document_path,
            "document_title"=>$this->document_title,
            "purpose"=>$this->purpose
        );
        return parent::update($params);
    }
    
    public function read($columns = array(), $cond = array(), $order_by = "") {
        return parent::read($columns, $cond, $order_by);
    }
}
