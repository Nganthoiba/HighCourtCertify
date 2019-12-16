<div class="container">
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($data['status']==false){
    echo $data['msg'];
}
else{
    //echo json_encode($data['application']);
    $application = $data['application'];
    /*
    {"application_id":"e1cb4a3c-77ec-4e6b-9e00-1d4072c78073",
     * "application_for":"Ordinary Copy","case_type":86,"case_no":2,
     * "case_year":2013,"petitioner":"fgaga","respondent":"fafa",
     * "certificate_type_id":1,"order_date":"2019-12-14",
     * "create_at":"2019-12-05 00:22:21",
     * "user_id":"bd20f847-8de4-4068-95de-4b0ccd04ba59",
     * "is_order":"n","case_no_reference":12,
     * "case_type_reference":23,"case_year_reference":2014,
     * "copy_name":"Order Copy","application_log_id":"4269f447-93a2-49cc-be37-78516394faf4",
     * "action_user_id":"bd20f847-8de4-4068-95de-4b0ccd04ba59",
     * "action_date":"2019-12-05 00:22:21.998+05:30",
     * "action_name":"create","from_role_id":14,
     * "to_role_id":3,
     * "remark":"Application is submitted",
     * "from_process_id":8,"to_process_id":1,
     * "action_user_full_name":"Khangembam Alica",
     * "written_application_id":null,
     * "body":null} 
     *      */
  
    $create_at_timestamp = strtotime($application->create_at);
    $order_date_timestamp = strtotime($application->order_date);
                
?>
    <style type="text/css">
        strong {
            font-weight: bold;
        }
    </style>
    <h3>Application Details:</h3>
    <table class="table_style">
        <tr>
            <td style="width:20%;"><strong>Application For:</strong></td>
            <td style="width:80%;"><?= $application->application_for ?></td>
        </tr>
        <tr>
            <td><strong>Case Type:</strong></td>
            <td><?= $application->case_type ?></td>
        </tr>
        <tr>
            <td><strong>Case Number:</strong></td>
            <td><?= $application->case_no ?></td>
        </tr>
        <tr>
            <td><strong>Case Year:</strong></td>
            <td><?= $application->case_year ?></td>
        </tr>
        <tr>
            <td><strong>Certificate Type:</strong></td>
            <td><?= $application->copy_name ?></td>
        </tr>
        <tr>
            <td><strong>Petitioner:</strong></td>
            <td><?= $application->petitioner ?></td>
        </tr>
        <tr>
            <td><strong>Respondent:</strong></td>
            <td><?= $application->respondent ?></td>
        </tr>
        <tr>
            <td><strong>Order Date:</strong></td>
            <td><?= date('d-m-Y',$order_date_timestamp) ?></td>
        </tr>
        <tr>
            <td><strong>Application Submitted on:</strong></td>
            <td><?= date('D, d M, Y',$create_at_timestamp) ?></td>
        </tr>
        <?php 
        if($application->certificate_type_id !="1"){
           //if the application is not for order copy
        ?>
        <tr>
            <td colspan="2">
                <strong>Application body:</strong>
                <div><?= str_replace("&nbsp;"," ",htmlspecialchars_decode($application->body)) ?></div>
            </td>
        </tr>
        <?php
        } 
        ?>
    </table>
<?php
    if($data['process_id'] !=8 && $data['process_id'] !=""){
?>
        <button onclick="approve();">Approve</button>
        <button onclick="reject();">Reject</button>
        <script type="text/javascript">
            function approve(){
                var url = "<?= Config::get('host') ?>/Application/approve/<?= $application->application_id ?>/<?= $data['process_id']  ?>";
                var resp = ajax_request({
                    url:url
                });
                resp = JSON.stringify(resp);
                //alert(resp);
                console.log(resp);
            }
            function reject(){
                var url = "<?= Config::get('host') ?>/Application/reject/<?= $application->application_id ?>/<?= $data['process_id']  ?>";
                var resp = ajax_request({
                    url:url
                });
                resp = JSON.stringify(resp);
                //alert(resp);
                console.log(resp);
            }
        </script>
<?php
    }
}
?>
</div>
