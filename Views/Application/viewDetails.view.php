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
        if($user_info['role_id']!=14){
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
    if($data['process_id'] !=8 && $data['process_id'] !="" && $application->isTaskPending){
?>
    <div style="text-align: center">
        <button onclick="approve();" class="btn btn-success">Approve</button>
        <button data-toggle="modal" data-target="#rejectApplicationModal" class="btn btn-danger">Reject</button>
    </div>
    <!-- The Reject Application Modal -->
    <div class="modal fade" id="rejectApplicationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="reject_application_form" id="reject_application_form" action="#" class="needs-validation" novalidate>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="model_title">Give reason why you reject this application</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div >
                            <input class="form-control" type="text" name="remark" id="remark" required/>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Please say something.</div>
                        </div>
                        <div>
                            <input class="form-control" type="hidden" name="application_id" id="application_id" value="<?= $application->application_id ?>"/>
                            <input class="form-control" type="hidden" name="process_id" id="process_id" value="<?= $data['process_id']  ?>"/>
                        </div>
                        
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END OF The Reject Application Modal -->
    <script type="text/javascript">
        var reject_application_form = document.forms['reject_application_form'];
        reject_application_form.onsubmit = function(event){
            event.preventDefault();
            var data = getFormDataToJson(reject_application_form);
            if(data.remark.trim() == ""){
                return false;
            }
            reject(data);
        }
        function approve(){
            var url = "<?= Config::get('host') ?>/Application/approve/<?= $application->application_id ?>/<?= $data['process_id']  ?>";
            var resp = ajax_request({
                url:url
            });

            if(resp.status){
                swal.fire({
                    title: 'Approved',
                    text: resp.msg,
                    type: 'success',
                    confirmButtonText: 'OK'
                }).then(function(isConfirm){
                    window.history.back();
                });
            }
            else{
                swal.fire({
                    title: 'Error',
                    text: resp.msg,
                    type: 'error',
                    confirmButtonText: 'OK'
                }).then(function(isConfirm){
                    window.history.back();
                });
            }
            //resp = JSON.stringify(resp);
            //alert(resp);
            //console.log(resp);
            window.history.back();
        }
        function reject(data){
            var url = "<?= Config::get('host') ?>/Application/reject";
            
            var resp = ajax_request({
                url:url,
                param: data,
                method: "POST"
            });
            if(resp.status){
                swal.fire({
                    title: 'Rejected',
                    text: resp.msg,
                    type: 'success',
                    confirmButtonText: 'OK'
                }).then(function(isConfirm){
                    window.history.back();
                });
            }
            else{
                swal.fire({
                    title: 'Error',
                    text: resp.msg,
                    type: 'error',
                    confirmButtonText: 'OK'
                }).then(function(isConfirm){
                    window.history.back();
                });
            }
        }

        
    </script>
        
    
<?php
    }
}
?>
</div>
