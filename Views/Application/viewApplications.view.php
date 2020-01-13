<?php 
$applications = $data['applications'];
if($applications!=null && sizeof($applications)){
?>
<link href="<?= Config::get('host') ?>/root/MDB/css/dataTable.css" rel="stylesheet" type="text/css"/>

<div class="container-fluid">
    <table class="table_style yellow_header" id="application_table">

        <thead>
            <tr>
                <th>Application Date</th>
                <th>Application For</th>
                <th>Case Type</th>
                <th>Case No.</th>
                <th>Case Year</th>
                <th>Order Date</th>
                <th>Certificate Type</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
    <?php
        
        foreach ($applications as $app) {
    ?>
            <tr>
                <?php 
                    $create_at_timestamp = strtotime($app->create_at);
                    $order_date_timestamp = strtotime($app->order_date);
                ?>
                <td><?= date('d-m-Y',$create_at_timestamp) ?></td>
                <td><?= $app->application_for ?></td>
                <td><?= $app->case_type ?></td>
                <td><?= $app->case_no ?></td>
                <td><?= $app->case_year ?></td>
                <td><?= date('d-m-Y',$order_date_timestamp) ?></td>
                <td><?= $app->copy_name ?></td>
                <td><a href="javascript:viewApplicationDetails('<?= $app->application_id ?>')">View Details</a></td>
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
            "columnDefs": [
                    { "orderable": false, "targets": [7] },
                    { "searchable": false, "targets": [7] },
                    { "className": "align-center", "targets": [7] }
                ]
        });
    } );
    
    function viewApplicationDetails(application_id){
        location.assign("viewDetails/"+application_id);
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



