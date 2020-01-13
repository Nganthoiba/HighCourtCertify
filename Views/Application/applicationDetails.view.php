<div class="container">
<?php
$response = $data['response'];
if($response->status === false){
    echo $response->msg;
}
else{
    
    $application = $response->data;
    $create_at_timestamp = strtotime($application->create_at);
    $order_date_timestamp = strtotime($application->order_date);
        
    $user_info = $_SESSION['user_info'];
    $app = new Application();
    $app->find($application->application_id);
    //print_r($user_info);
?>
    <style type="text/css">
        strong {
            font-weight: bold;
        }
    </style>
    <h3>Application Details:</h3>
    <?= writeCSRFToken() ?>
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
    <script type="text/javascript">
        function insertIntoApplicationTasksLog(application_id,tasks_id,action_name,remark=""){
            var data = {
                application_id: application_id,
                tasks_id: tasks_id,
                action_name: action_name,
                remark: remark,
                csrf_token: $("#csrf_token").val()
            };
            var result = ajax_request({
                url: "<?= Config::get('host') ?>/Application/applicationTasksLog",
                param: data,
                method: "POST"
            });
            return result;
        }
    </script>
<?php
    $tasks_id = (int)$data['tasks_id'];
    $process_id = (int)$data['process_id'];
    $application_id = $data['application_id'];
    
    //if user has already commited the task then dont load any further approval or rejected layout
    if(!isApplicationRecordAlreadyExist($application_id, $process_id, $tasks_id)){
        switch($tasks_id){
            case 5:
                include_once 'tasks_files/certificate_preparation.php';
                break;
            case 8:
                include_once ("tasks_files/submit_case_body.php");
                break;
            case 10:
            case 11:
            case 12:
                include_once ("tasks_files/approve_n_reject.php");
                break;
            default:
                //Nothing to do
        }
    }
 
}

?>
</div>

