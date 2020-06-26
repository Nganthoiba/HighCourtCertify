<?php 
$applications = $viewData->applications;
$selectedApplicationId = $viewData->selectedApplicationId;
if($applications!=null && sizeof($applications)){
?>
<link href="<?= Config::get('host') ?>/root/MDB/css/dataTable.css" rel="stylesheet" type="text/css"/>

<style type="text/css">
    .selected {
        background-color: #FF0065;
        color: #f2f2f2;
    }
    .selected a {
        color: #e8f5e9;
    }
    .selected a:hover {
        text-decoration: underline;
    }
</style>

<div class="container-fluid">
    <table class="table_style yellow_header" id="application_table">
        <caption>#Note: Your application will not be processed until processing fee is not paid,
            so complete payment now if not done.</caption>
        <thead>
            <tr>
                <th>Date</th>
                <th>Application ID</th>
                <th>Application For</th>
                <th>Case Type</th>
                <th>Case No.</th>
                <th>Case Year</th>
                <th>Copy Type</th>
                <th><span class="fa fa-paypal"></span>ayment</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
    <?php
        
        foreach ($applications as $app) {
    ?>
            <tr class="<?= ($selectedApplicationId==$app->application_id)?"selected":"" ?>">
                <?php 
                    $create_at_timestamp = strtotime($app->create_at);
                    $order_date_timestamp = strtotime($app->order_date);
                ?>
                <td><?= date('d/m/Y',$create_at_timestamp) ?></td>
                <td><?= $app->application_id ?></td>
                <td><?= $app->certificate_type_name ?></td>
                <td><?= $app->case_type_name ?> - <?= $app->case_type_full_form ?></td>
                <td><?= $app->case_no ?></td>
                <td><?= $app->case_year ?></td>
                <td><?= $app->copy_name ?></td>
                <td>
                    <?php 
                    if($app->isPaymentCompleted()==true){
                    ?>
                        Completed
                    <?php     
                    }
                    else
                    {
                    ?>
                        <a href="<?= getHtmlLink("Paypal", "confirmPayment",$app->application_id) ?>">Pay Now</a>
                    <?php 
                    } 
                    ?>
                </td>
                <td><a href="javascript:viewApplicationDetails('<?= $app->application_id ?>')">Details</a></td>
            </tr>
    <?php 
        }
    ?>
        </tbody>
    </table>
</div>
<script src="<?=Config::get('host')?>/root/MDB/js/dataTable.js" type="text/javascript"></script>
<script src="<?=Config::get('host')?>/root/MDB/js/dataTables.bootstrap4.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#application_table').DataTable({
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                    { "orderable": false, "targets": [6,7,8] },
                    { "searchable": false, "targets": [6,7,8] },
                    { "className": "align-center", "targets": [6,7,8] }
                ]
        });
    } );
    
    function viewApplicationDetails(application_id){
        var link = "<?= getHtmlLink("Application", "viewDetails") ?>";
        location.assign(link+"/"+application_id);
    }
</script>
<?php
}
else{
    ?>
<div class="card bg-info text-white" style="text-align: center">
        <div class="card-body">No Application found. Apply new.</div>
    </div> 
<?php
}
?>



