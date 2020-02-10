<?php
/**
 * Description of Document
 *
 * @author Nganthoiba
 */
class Document extends EasyEntity{
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
    public function add(): Response{
        $this->document_id = $this->findMaxColumnValue("document_id")+1;
        return parent::add();
    }
    
    public function remove(): Response{
        $this->delete_at = date('Y-m-d H:i:s');
        return parent::save();
    }
    
    public function save():Response{
        $this->update_at = date('Y-m-d H:i:s');
        return parent::save();
    }
}
