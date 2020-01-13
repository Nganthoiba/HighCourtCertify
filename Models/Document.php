<?php
/**
 * Description of Document
 *
 * @author Nganthoiba
 * CREATE TABLE public.document (
  document_id     serial NOT NULL,
  application_id  varchar(40),
  document_path   varchar(200),
  create_at       timestamp with time zone,
  delete_at       timestamp with time zone,
  created_by      varchar(40) NOT NULL,
  update_at       timestamp with time zone,
  
  CONSTRAINT "Document_pkey"
    PRIMARY KEY (document_id)
)
 */
class Document extends model{
    public  $document_id,
            $application_id,
            $document_path,
            $create_at,
            $delete_at,
            $created_by,
            $update_at;
    public function __construct($doc = array()) {
        parent::__construct();
        $this->setTable('document');
        $this->setKey('document_id');
        
        $this->application_id = isset($doc['application_id'])?$doc['application_id']:"";
        $this->document_path = isset($doc['document_path'])?$doc['document_path']:"";
        $this->create_at = date('Y-m-d H:i:s');
        $this->created_by = isset($doc['created_by'])?$doc['created_by']:"";
    }
    //add a new document for an application
    public function add(){
        
        $this->document_id = $this->findMaxColumnValue("document_id")+1;
        $rec = array(
            "document_id"=>$this->document_id,
            "application_id"=>$this->application_id,
            "document_path"=>$this->document_path,
            "create_at"=>$this->create_at,
            "created_by"=>$this->created_by
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
