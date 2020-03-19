<?php
/**
 * Description of third_party_application_reasons
 *
 * @author Nganthoiba
 */
class third_party_applicant_reasons extends EasyEntity{
    public  $third_party_application_reasons_id,
            $application_id,
            $reason;
    public function __construct() {
        parent::__construct();
        $this->setTable("third_party_applicant_reasons")
                ->setKey("third_party_application_reasons_id");
    }
}
