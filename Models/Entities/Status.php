<?php
/**
 * Description of Status
 *
 * @author Nganthoiba
 * 
 * status_id       serial NOT NULL,
  description     varchar(255),
  created_at      timestamp with time zone NOT NULL DEFAULT CURRENT_DATE,
  updated_at      timestamp with time zone,
  deleted_at      timestamp with time zone,
  application_id  varchar(50) NOT NULL,
  user_id         varchar(50) NOT NULL,
 */
class Status extends EasyEntity{
    
    public  $status_id,
            $description,
            $created_at,
            $updated_at,
            $deleted_at,
            $application_id,
            $user_id;
    public function __construct() {
        parent::__construct();
        $this->setTable("status")->setKey("status_id");
    }
}
