<?php
//function to add a record in application_tasks_log
function insertApplicationTasksLog(PDO $conn,$application_id,$user_id,$action_name,$tasks_id,$process_id,$remark=""){
    /*
    application_tasks_log_id  varchar(40) NOT NULL PRIMARY KEY,
    application_id            varchar(40),
    user_id                   varchar(64),
    action_date               timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    action_name               varchar(30),
    tasks_id                  integer DEFAULT '-1'::integer,
    remark                    varchar(300) DEFAULT NULL::character varying,
    process_id                integer,
    source_ip                 varchar(30),
    */
    $response = new Response();
    $action_values = ["create","approve","forward","reject"];
    if(!in_array($action_name,$action_values)){
        $response->set([
            "status_code"=>403,
            "msg"=>"Invalid action name"
        ]);
        return $response;
    }
    if(isApplicationRecordAlreadyExist($application_id, $process_id, $tasks_id)){
        $response->set([
            "status_code"=>403,
            "msg"=>"Duplicate entry found."
        ]);
        return $response;
    }
    
    $application_tasks_log_id = UUID::v4();
    $source_ip = get_client_ip();
    $user = new Users();
    $user = $user->find($user_id);
    $role_id = $user->role_id;
    $qry = "INSERT INTO application_tasks_log ("
            . " application_tasks_log_id,   application_id, user_id,    action_date,"
            . " action_name,                tasks_id,       process_id, remark, "
            . " source_ip,                  role_id,        next_tasks_id) "
            . " VALUES(?,?,?,NOW(),  ?,?,?,?,    ?,?,?)";
    
    $next_tasks_id = findNextTaskId($conn, $process_id, $tasks_id);//by default
    $params = [
        $application_tasks_log_id,
        $application_id,
        $user_id,
        $action_name,
        $tasks_id,
        $process_id,
        $remark,
        $source_ip,
        $role_id,
        $next_tasks_id
    ];
    
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute($params);
    if($res){
        $msg="";
        switch($action_name){
            case "create":
                $msg = "Application Tasks Log created.";
                break;
            case "approve":
                $msg = "Application has been approved.";
                break;
            case "reject":
                $msg = "Application has been rejected.";
                break;
            case "forward":
                $msg = "Application has been forwarded.";
                break;
            default:
                $msg = "";
        }
        $response->set([
            "status"=>true,
            "status_code"=>200,
            "msg"=>$msg
        ]);
    }
    else{
        $response->set([
            "msg"=>"Failed to create log.",
            "error"=>$stmt->errorInfo()
        ]);
    }
    return $response;
}

//to get list of applications for pending,approval or forwarding, or deleted
function getApplicationTasksHistory(PDO $conn, $tasks_id,$task_type){
    $response = new Response();
    if($task_type == "in"){
        //means incoming tasks
        $qry = "select * from latest_application_tasks_log_view L "
            . " where L.next_tasks_id = ? and L.action_name!='reject'";
    }
    else{
        //$tasks_type = out; means outging tasks like forwarded, approved and rejected
        $qry = "select * from application_tasks_log_view L "
                . " where L.tasks_id = ? ";
    }
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute([$tasks_id]);
    if(!$res){
        $response->set([
            "error"=>$stmt->errorInfo()
        ]);
        return $response;
    }
    if($stmt->rowCount()==0){
        $response->set([
            "msg"=>"No record found.",
            "status_code"=>404
        ]);
        return $response;
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $objs = array();
    foreach($rows as $row){
        $objs[] = (object)$row;
    }
    $response->set([
        "status"=>true,
        "status_code"=>200,
        "msg"=>"list of applications.",
        "data"=>$objs
    ]);
    return $response;
}

//function to get latest status/details of an application
function getLatestApplicationDetails(PDO $conn, $application_id){
    $response = new Response();
    $qry = "select * from latest_application_tasks_log_view L "
            . " where L.application_id = ? ";
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute([$application_id]);
    if(!$res){
        $response->set([
            "error"=>$stmt->errorInfo()
        ]);
        return $response;
    }
    if($stmt->rowCount()==0){
        $response->set([
            "msg"=>"No record found",
            "status_code"=>404
        ]);
        return $response;
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $app = new Application();
    foreach ($row as $col_name=>$val){
        $app->$col_name = $val;
    }
    //$obj = (object)$row;
    $response->set([
        "status"=>true,
        "status_code"=>200,
        "msg"=>"list of applications.",
        "data"=>$app
    ]);
    return $response;
}
//function to check how manu times an application has been already rejected
function countApplicationReject($application_id){
    //$qry = "SELECT * FROM application_tasks_log L WHERE L.action_name = ? AND application_id = ?";
    $application_tasks_log = new model();
    $application_tasks_log->setTable("application_tasks_log");
    $application_tasks_log->setKey("application_tasks_log_id");
    $cond = [
        "action_name"=>"reject",
        "application_id"=>$application_id
    ];
    $response = $application_tasks_log->read(array(), $cond);
    return $response->status==false?0:sizeof($response->data);    
}
//function to check how manu times an application details has been recorded in application_tasks_log table
function countApplicationEntry($application_id){
    $application_tasks_log = new model();
    $application_tasks_log->setTable("application_tasks_log");
    $application_tasks_log->setKey("application_tasks_log_id");
    $cond = [
        "application_id"=>$application_id
    ];
    $response = $application_tasks_log->read(array(), $cond);
    return $response->status==false?0:sizeof($response->data);    
}

//function to check if same record of an application had already exist in the 
//application_tasks_log table
function isApplicationRecordAlreadyExist($application_id, $process_id,$tasks_id){
    $response = new Response();
    $conn = Database::connect();
    
    $qry = "SELECT * FROM application_tasks_log "
            . " WHERE application_id = ? AND process_id = ? AND tasks_id = ?";
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute([
        $application_id,
        $process_id,
        $tasks_id
    ]);
    if(!$res){
        return 0;
    }
    return $stmt->rowCount();
}

//function to find next task id using current process id and current task id

function findNextTaskId(PDO $conn,int $process_id, int $tasks_id):int{
    
    $qry = "select * from process_tasks_mapping_view "
            . " where process_id = ? and tasks_id = ? ";
    $stmt = $conn->prepare($qry);
    $stmt->execute([$process_id,$tasks_id]);
    if($stmt->rowCount() == 0){
        return null;
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return (int)$row['next_tasks_id'];
}


