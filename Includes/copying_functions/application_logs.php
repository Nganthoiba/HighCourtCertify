<?php
function insertApplicationLog($conn,$action, $application_id,$process_id,$remark="",$is_order="n"){
    $application_log_id = UUID::v4();
    $user_info = $_SESSION['user_info'];
    $user_id = $user_info['user_id'];
    $role_id = $user_info['role_id'];
    
    switch($action){
        case 'create' :
            if($is_order=="y"){
                $to_role_id = 2;
                $to_process_id = 2;
            }
            else{            
                $to_role_id = 3;//move to Registrar general
                $to_process_id = 1;
            }
            break;
        case 'reject' :
            //Drop the application direct to applicant
            $to_process_id = 8; //applicant process id
            $to_role_id = 14; //applicant role id
            break;
        default : 
            $application = new Application();
            $application = $application->find($application_id);
            if($application == null){
                return array("status"=>false,"msg"=>"Application not found. ".$application_id,"error"=>array(),"status_code"=>404);
            }
            $is_order = $application->is_order;
            $res = getNextPrevRolesAndProcess($conn,$role_id,$process_id,$application_id,$is_order);
            if($res['status']==false){
                return $res;
            }
            $to_process_id = $res['to_process_id'];
            $to_role_id = $res['next_role_id'];
            //if new process started
            if($process_id != $to_process_id){ //process changes
                if($to_process_id == -1){
                    $to_role_id = -1;
                }
                else{
                    $result =  firstRoleIdProcess($conn, $to_process_id);
                    if(!$result['status']){
                        return $result;
                    }
                    $to_role_id = $result['data']['role_id'];
                }

            }
            break;
    }
    $isTaskPending = isTaskPending($conn, $application_id,$process_id,$role_id);
    if(!$isTaskPending['status']){
        return $isTaskPending;
    }
    
        
    $qry = "insert into application_log"
            . "("
            . " application_log_id, application_id, user_id,   action_date,        action_name, "
            . " from_role_id,        to_role_id,     remark,     from_process_id,    to_process_id, "
            . " user_ip"
            . " )"
            . " values(?,?,?,now(),?,    ?,?,?,?,?,  ?)";
    $user_ip = get_client_ip();
    $params = array(
        $application_log_id,
        $application_id,
        $user_id,
        $action,
        $role_id,
        $to_role_id,
        $remark,
        $process_id,
        $to_process_id,
        $user_ip
    );
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute($params);
    if(!$res){
        return array("status"=>false,"msg"=>"Failed to complete task","error"=>$stmt->errorInfo(),"status_code"=>500);
    }
    return array("status"=>true,"msg"=>"Task completed","status_code"=>200,"error"=>array());
}

function getNextPrevRolesAndProcess($conn,$roles_id,$process_id,$application_id,$is_order){
    //check whether application type is order copy or not
    //$is_order = isOrderCopy($conn, $application_id);
    
    switch ($process_id){
        case 1: 
            $to_process_id = 2;
            break;
        case 2: 
            $to_process_id = 3;
            break;
        case 3: 
            $to_process_id = $is_order=="y"?4:5;
            break;
        case 4:
            $to_process_id = 7;
            break;
        case 5:
            $to_process_id = 6;
            break;
        case 6:
            $to_process_id = 7;
            break;
        case 7:
            $to_process_id = -1;//finish process
            break;
    }   
    $qry = "select * from process_role_map_view  
            where  process_id=? and user_role_id=?";
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute(array($process_id,$roles_id));
    if(!$res){
        return array("status"=>false,"msg"=>"Internal Server Error","error"=>$stmt->errorInfo(),"status_code"=>500);
    }
    if($stmt->rowCount()==0){
        return array("status"=>false,"msg"=>"Process and Role Mapping not available","error"=>$stmt->errorInfo(),"status_code"=>404);
    }
    $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
    foreach ($rows as $row){
        $to_process_id = ($row['next_role_id']==-1 || $row['next_role_id']==NULL)?$to_process_id:$process_id;
    }
    return array("status"=>true,"previous_role_id"=>$row['previous_role_id'],
        "next_role_id"=>$row['next_role_id'],
        "to_process_id"=>$to_process_id,"status_code"=>200);
}// end of function getNextPrevRolesAndProcess($conn,$roles_id,$process_id,$application_id,$is_order)

//function to check whether an application is for order copy or not, the function returns binary 
function isOrderCopy($conn, $application_id){
    //$qry = "select * from applications where application_id=? and is_order='y'";
    $qry = "select * from application where application_id=? and certificate_type=1";
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute(array(
        $application_id
    ));
    return ($stmt->rowCount()>0);
}// end of function isOrderCopy($conn, $application_id)

function firstRoleIdProcess($conn, $process_id){
    $qry = "select user_role_id as role_id from process_role_map_view where process_id = ? and user_level = 1";
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute(array($process_id));
    if(!$res){
        return array('status'=>false,'status_code'=>500, 'msg'=> 'Internal Server Problem.','error'=>$stmt->errorInfo());
    }
    if($stmt->rowCount() == 0){
        return array('status'=>false,'status_code'=>404, 'msg'=> 'No role found.');
    }
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    return array('status'=>true,'status_code'=>200, 'data'=>$rows);
}// end of function firstRoleIdProcess($conn, $process_id)

function isTaskPending($conn, $application_id,$process_id,$role_id){
    $qry = "select count(*) as c from application_log_view where application_id=? and from_process_id=? and from_role_id=?";
    $stmt = $conn->prepare($qry);
    $res = $stmt->execute(array($application_id,$process_id,$role_id));
    if(!$res){
        return array('status'=>false,'status_code'=>500, 'msg'=> 'Internal Server Problem.','error'=>$stmt->errorInfo());
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['c'] != 0){
        return array('status'=>false,'status_code'=>403, 'msg'=> 'The task is already performed.'); 
    }
    return  array('status'=>true);
    
}