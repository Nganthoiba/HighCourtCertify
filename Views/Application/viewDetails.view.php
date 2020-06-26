<div class="container">
<?php
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
        <tr>
            <td style="width:20%;"><strong>Application ID:</strong></td>
            <td style="width:80%;"><?= $application->application_id ?></td>
        </tr>
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
            <td style="width:80%;"><?= $application->certificate_type_name ?></td>
        </tr>
        <tr>
            <td><strong>Case Type:</strong></td>
            <td><?= $application->case_type_name ?> - <?= $application->case_type_full_form ?></td>
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
            <td><strong>Reference:</strong></td>
            <td>
                <?php
                if($application->case_type_reference === -1 || $application->case_no_reference === -1 || $application->case_year_reference === -1){
                    echo "No reference.";
                }
                else
                {
                ?>
                <div>Case Type: <?= $application->case_type_reference ?></div>
                <div>Case Number: <?= $application->case_no_reference ?></div>
                <div>Case Year: <?= $application->case_year_reference ?></div>
                <?php 
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>Certificate Copy Type:</strong></td>
            <td><?= $application->copy_name ?></td>
        </tr>
        <tr>
            <td><strong>Third Party:</strong></td>
            <td>
            <?php
            if($application->is_third_party === "y"){
                $reasons = new third_party_applicant_reasons();
                $reasons = $reasons->read()->where([
                    "application_id"=>$application->application_id
                ])->getFirst();
                if($reasons==null){
                    echo "Yes";
                }
                else{
                    echo "Yes, ".$reasons->reason;
                }
            }
            else{
                echo "No";
            }
            ?>
            </td>
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
        <tr>
            <td><strong>Application Mode:</strong></td>
            <td>
            <?php 
            if($application->is_offline == "y"){
                echo "Offline Mode";
            }
            else{
                echo "Online Mode";
            }
            ?>
            </td>
        </tr>
        <?php 
        if($application->is_offline == "y"){
        ?>
        <tr>
            <td><strong>Offline payslip:</strong></td>
            <td>
                <?php
                if($application->isPaymentCompleted()){
                ?>
                <a href="<?= getHtmlLink("Application", "downloadOfflinePayslip",$application->application_id) ?>">Download</a>
                <?php
                }
                else{
                    echo "Complete payment first.";
                }
                ?>
            </td>
        </tr>
        
        <tr>
            <td><strong>Record entered by:</strong></td>
            <td><?= $application->action_user_full_name ?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td><strong>View Application Status:</strong></td>
            <td>
                <?php
                $intemation = $application->getIntimation();
                if(!$application->isPaymentCompleted()){
                ?>
                    First <a href="<?= $application->is_offline == "y"?getHtmlLink("Paypal", "offlinePayment",$application->application_id):getHtmlLink("Paypal", "confirmPayment",$application->application_id) ?>">complete payment Now</a>, then application will be processed.
                    
                <?php
                }
                else if($intemation !== null){
                    echo $intemation->description;
                }
                else{
                    echo "Processing...";
                }
                ?>
                To see more, <a href="<?= getHtmlLink("Status", "viewStatus",$application->application_id) ?>">Click here</a>
            </td>
        </tr>
    </table>
<?php
}
?>
</div>
