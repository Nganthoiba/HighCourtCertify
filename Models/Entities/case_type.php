<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of case_type
 *
 * @author Nganthoiba
 */
class case_type extends EasyEntity{
    public $case_type_id,
        $type_name,
        $ltype_name,
        $full_form,
        $lfull_form,
        $type_flag,
        $filing_no,
        $filing_year,
        $reg_no,
        $reg_year,
        $display,
        $petitioner,
        $respondent,
        $lpetitioner,
        $lrespondent,
        $res_disp,
        $case_priority,
        $national_code,
        $macp,
        $stage_id,
        $matter_type,
        $cavreg_no,
        $cavreg_year,
        $direct_reg,
        $cavfil_no,
        $cavfil_year,
        $ia_filing_no,
        $ia_filing_year,
        $ia_reg_no,
        $ia_reg_year,
        $tag_courts,
        $amd,
        $create_modify,
        $est_code_src,
        $reasonable_dispose; 
    public function __construct() {
        parent::__construct();
        $this->setTable("case_type")->setKey("case_type_id");
    }
}
