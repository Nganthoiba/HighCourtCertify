<?php
/**
 * Description of offline_application
 *
 * @author Nganthoiba
 */
class offline_application extends EasyEntity{
    public $application_id, $applicant_name,$aadhaar, $offline_application_id;
    public function __construct() {
        parent::__construct();
        $this->setKey("offline_application_id");
    }
}
