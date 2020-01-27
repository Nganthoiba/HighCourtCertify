<?php
/**
 * Description of Casebody
 *
 * @author Nganthoiba
 */
class Casebody extends Model{
    /*
    casebody_id   serial NOT NULL,
    case_type      integer,
    case_number    integer,
    case_year      integer,
    document_path  varchar(255) NOT NULL,
    create_at      timestamp with time zone,
    created_by     varchar(40),
    */   
    public  $casebody_id,
            $case_type,
            $case_number,
            $case_year,
            $document_path,
            $create_at,
            $created_by;
    public function __construct() {
        parent::__construct();
        $this->setTable("casebody");
        $this->setKey("casebody_id");
        $this->response = new Response();
    }
    
    public function add(){
        $this->casebody_id = $this->findMaxColumnValue("casebody_id")+1;
        $this->create_at = date('Y-m-d H:i:s');
        if($this->isCaseBodyExist($this->case_type,$this->case_number,$this->case_year)){
            $this->response->set([
                "status"=>false,
                "status_code"=>403,
                "msg" => "Case body already exist"
            ]);
            return $this->response;
        }
        $rec = [
            "casebody_id"=>$this->casebody_id,
            "case_type" => $this->case_type,
            "case_number" => $this->case_number,
            "case_year" => $this->case_year,
            "document_path" => $this->document_path,
            "create_at" => $this->create_at,
            "created_by" => $this->created_by
        ];
        return parent::create($rec);
    }
    
    public function isCaseBodyExist($case_type,$case_number,$case_year){
        $cond = [
            "case_type" => $case_type,
            "case_number" => $case_number,
            "case_year" => $case_year
        ];
        $res = $this->read([], $cond);
        return $res->status;
    }
    
    //get case body according to case type, case number and case year
    public function getCaseBody($case_type,$case_number,$case_year){
        $cond = [
            "case_type" => $case_type,
            "case_number" => $case_number,
            "case_year" => $case_year
        ];
        $this->response = $this->read([], $cond);
        if($this->response->status){
            return $this->response->data[0];
        }
        return null;
    }
}
