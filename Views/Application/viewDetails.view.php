<div class="container">
<?php

/* This page is only for applicant role_id = 14
 
 */
if($data['status']==false){
    echo $data['msg'];
}
else{
    //echo json_encode($data['application']);
    $application = $data['application'];
    $create_at_timestamp = strtotime($application->create_at);
    $order_date_timestamp = strtotime($application->order_date);
        
    $user_info = $_SESSION['user_info'];
    //print_r($user_info);
?>
    <style type="text/css">
        strong {
            font-weight: bold;
        }
    </style>
    <h3>Application Details:</h3>
    <table class="table_style">
        <?php
        if($user_info['role_id']!=14){//if not applicant
        ?>
        <tr>
            <td style="width:20%;"><strong>Applicant Name:</strong></td>
            <td style="width:80%;"><?= $application->applicant_name ?></td>
        </tr>
        <?php
        }
        ?>
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
                <div class="alert alert-light">
                    <?= str_replace("&nbsp;"," ",htmlspecialchars_decode($application->body)) ?>
                </div>
            </td>
        </tr>
        <?php
        } 
        ?>
    </table>
<?php
//if($data['process_id'] !=8 && $data['process_id'] !="" && $application->isTaskPending){
/*
if($user_info['role_id'] !== 14 && $application->isTaskPending){
    //If role is Computer Operator
    if($user_info['role_id']===12){
?>
        <form name="upload_prepared_documents">
            <div class="col-sm-4" style="margin: auto">
                <div class="row">
                    <label>Upload your relevant documents for certificate preparation:</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" accept="application/pdf" class="custom-file-input" name="prepared_docs" id="prepared_docs" required/>
                            <label class="custom-file-label" for="prepared_docs">Choose file</label>
                        </div>
                        <script>
                        // Add the following code if you want the name of the file appear on select
                        $(".custom-file-input").on("change", function() {
                          var fileName = $(this).val().split("\\").pop();
                          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                        </script>

                    </div> 
                </div>
                <div class="row" style="text-align: center">
                    <button type="button" onclick="confirmApprove();" class="btn btn-success">Approve</button>
                    <button type="button" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
<?php
    }
    else{
?>      <div style="text-align: center">
            <button onclick="approve();" class="btn btn-success">Approve</button>
            <button onclick="reject();" class="btn btn-danger">Reject</button>
        </div>
<?php
    } 
?>
        <script type="text/javascript">
            //function to approve an application
            function approve(){
                swal.fire({
                    title: 'Approve!',
                    text: "Are you sure to approve?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'YES',
                    cancelButtonText: "No, I am not sure!"
                }).then((result) => {
                    if (result.value) {
                        var resp = ajax_request({
                            url:"<?= Config::get('host') ?>/Application/approve/<?= $application->application_id ?>/<?= $data['process_id']  ?>"
                        });
                        if(resp.status){
                            swal.fire({'Approved.',resp.msg,'success'});
                            window.history.back();
                        }
                        else{
                            swal.fire({'Approve Failed.',resp.msg,'error'});
                        }
                    }
                });
            }
            //function to reject an application
            function reject(){
                swal.fire({
                    title: 'Reject!!',
                    text: "Are you sure to reject?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'YES',
                    cancelButtonText: "No, I am not sure!"
                }).then((result) => {
                    if (result.value) {
                        var resp = ajax_request({
                            url:"<?= Config::get('host') ?>/Application/reject/<?= $application->application_id ?>/<?= $data['process_id']  ?>"
                        });
                        if(resp.status){
                            swal.fire({'Rejected.',resp.msg,'success'});
                            window.history.back();
                        }
                        else{
                            swal.fire({'Reject Failed.',resp.msg,'error'});
                        }
                    }
                });
            }
        </script>
<?php
    }
    */
}

?>
</div>
