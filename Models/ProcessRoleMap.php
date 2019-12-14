<?php
/**
 * Description of ProcessRoleMap
 *
 * @author Nganthoiba
 */
class ProcessRoleMap {
    public $db1;
    public function __construct($db1){
        $this->db1 = $db1;
    }
    public function get_process(){
        $response = new Response();
        $db = $this->db1;
        $response->status = 0;	

        $qry = "select * from process where process_id!=0";
        $stmt=$db->prepare($qry);
        $stmt->execute();
        $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
        if(count($rows)==0)
        {
            $response->msg = "No data";
            return $response;
        }
        $data = array();
        foreach($rows as $item){ //hiding database nomencluture from end user
            $row['id'] = $item['process_id'];
            $row['name'] = $item['process_name'];
            $row['description'] = $item['process_description'];
            $data[] = $row;
        }
        $response->data = $data;
        $response->status_code = 200 ;
        return $response;
    }
	
    public function get_Process_Role_Map($process_id){
	$response = new Response();	
        $db = $this->db1;
        $response->status = 0;	
        if($process_id == ''){
            $response->msg = 'Select a valid Process!!!';	
            return $response;
        }
        $qry = "select  R.role_name,
                R.role_id,
                I.process_id,
                I.description,
                I.role_level,
                I.process_role_map_id
                from role as R left join
                ( select * from process_role_map as P where P.process_id=? and P.is_disabled = 'n' ) as I
                on R.role_id = I.role_id order by I.role_level" ;
        $stmt=$db->prepare($qry);
        $stmt->execute(array($process_id));
        $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
        if(count($rows)==0)
        {
            $response->msg = "No data! Please select another process.";
            return $response;
        }
        $role_excluded = array();
        $role_included = array();
        foreach($rows as $row){
            if($row['process_id'] == NULL || trim($row['process_id']) == "" ){
                $role_excluded[] = $row;				
            }
            else if((int)$row['process_id'] == 0){
                $role_included[] = $row;
                die (json_encode($row));
            }
            else{
                $role_included[] = $row;		
            }
        }
        $response->status = true;
        $response->status_code = 200 ;
        $response->msg = "";
        $response->data = array('included'=>$role_included, 'excluded'=>$role_excluded);
        return $response;
    }
	
    public function set_Process_Role_Map($process_id,$data){
        $response = new Response();   
        $db = $this->db1;
        $response->status = 0;
        if($process_id == ''){
            $response->msg = 'Select a valid Process!!!';	
            return $response;
        }		
        //first disabled all rows of process_role_map  with process_id to be alter
        $qry = "update process_role_map set is_disabled='y' where process_id=?";
        $stmt=$db->prepare($qry);
        $check_flag = $stmt->execute(array($process_id));
        if(!$check_flag){
            $response->msg = "Error: internal server problem." ;
            return $response;	
        }
        
        $qry = "select process_role_map_id, role_id from process_role_map
                                where process_id=?";
        $stmt=$db->prepare($qry);
        $check_flag = $stmt->execute(array($process_id));	
        if(!$check_flag){
            $response->msg = "Error: internal server problem." ;
            $response->error = $stmt->errorInfo() ;
            return $response;	
        }
		
        $rows = $stmt->fetchall(PDO::FETCH_ASSOC);
        $old_role_id = array();
        foreach($rows as $x){
            $old_role_id[$x['process_role_map_id']] = $x['role_id'];
        }

        if(isset($data['included'])){
            $number_of_role = count($data['included']);
            $qry = "UPDATE  process
                    set number_of_role=?
                    where process_id=? ; ";
            $stmt=$db->prepare($qry);
            $resp = $stmt->execute(array($number_of_role, $process_id));

            if( !$resp  || $stmt->rowCount()==0 ){
                    $response->msg = "Error: internal server problem.";
                    $response->error = $stmt->errorInfo();
                    return $response;		
            }
            $role_level = 1;
            foreach($data['included'] as $item ){
                
                //check in old_role_id using in_array here for insert or update
                $role_id = $item['roleid'];
                $role_description = $item['desp'];
                $old_process_role_map_id = array_search($role_id, $old_role_id );  //get ids using role_id
                if(!$old_process_role_map_id){
                    $qry = "INSERT into process_role_map 
                    (process_id, role_id, role_level, description, is_disabled)
                    VALUES (?,?,?,?,'n'); ";
                }else{
                    $qry = "UPDATE  process_role_map
                    set process_id=?, role_id=?, role_level=?, description=?, is_disabled='n' 
                    where process_role_map_id=$old_process_role_map_id ; ";
                }
                $stmt=$db->prepare($qry);
                $resp = $stmt->execute(array($process_id, $role_id, $role_level++, $role_description ));

                if( !$resp  || $stmt->rowCount()==0 ){
                    $response->msg = "Error: internal server problem.";
                    //.json_encode($stmt->errorInfo()) ;
                    return $response;		
                }
            }
        }
        $response->status = true ;
        $response->status_code = 200 ;
        $response->msg = "Successfully Saved." ;
        return $response;
    }
}
