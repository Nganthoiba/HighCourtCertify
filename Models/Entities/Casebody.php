<?php
/**
 * Description of Casebody
 *
 * @author Nganthoiba
 */
class Casebody extends EasyEntity{
       
    public  $casebody_id,
            $case_type_id,
            $case_number,
            $case_year,
            $document_path,
            $created_at,
            $created_by;
    private $response;
    public function __construct() {
        parent::__construct();
        $this->setTable("casebody")->setKey("casebody_id");
        $this->response = new Response();
    }
    
    public function add():Response{
        $this->casebody_id = $this->findMaxColumnValue("casebody_id")+1;
        $this->created_at = date('Y-m-d H:i:s');
        if($this->isCaseBodyExist($this->case_type_id,$this->case_number,$this->case_year)){
            $this->response->set([
                "status"=>false,
                "status_code"=>403,
                "msg" => "Case body already exist"
            ]);
            return $this->response;
        }
        return parent::add();
    }
    
    public function isCaseBodyExist($case_type_id,$case_number,$case_year){
        $cond = [
            "case_type_id" => $case_type_id,
            "case_number" => $case_number,
            "case_year" => $case_year
        ];
        $stmt = $this->read()->where($cond)->execute();
        return ($stmt->rowCount()>0);
    }
    
    //get case body according to case type, case number and case year
    public function getCaseBody($case_type_id,$case_number,$case_year){
        $cond = [
            "case_type_id" => $case_type_id,
            "case_number" => $case_number,
            "case_year" => $case_year
        ];
        $case_body = $this->read()->where($cond)->getFirst();
        return $case_body;
    }
}
