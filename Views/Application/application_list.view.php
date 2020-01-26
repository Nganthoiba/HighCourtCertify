<div class="container">
    <h2><?= $data['tasks_name'] ?></h2>
<?php 
$response = $data['response'];
$tasks_id = $data['tasks_id'];
if($response->status === false){
?>
    <div class="btn-group">
        <a class="btn btn-default" href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['tasks_id'] ?>/in');">Incoming</a> 
        <a class="btn btn-default" href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['tasks_id'] ?>/out/approve');">Approved/Forwarded</a> 
        <a class="btn btn-default" href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['tasks_id'] ?>/out/reject');">Rejected</a>
    </div>
    <div class="alert alert-warning"><?= $response->msg ?></div>
<?php
}
else
{
?>
    <link href="<?= Config::get('host') ?>/root/MDB/css/dataTable.css" rel="stylesheet" type="text/css"/>
<?php

    /*** Tab display ***/
    $active_tab = $data['active_tab'];
    function setClass($active_tab,$param){
        if($param == $active_tab){
            return "btn btn-success";
        }
        return "btn btn-default";
    }
    /************************/
    $applications = json_decode(json_encode($response->data),true);
?>
    <div class="container-fluid">

        <div class="btn-group">
            <a class="<?= setClass($active_tab,'incoming') ?>" href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['tasks_id'] ?>/in');">Incoming</a> 
            <a class="<?= setClass($active_tab,'approve') ?>" href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['tasks_id'] ?>/out/approve');">Approved/Forwarded</a> 
            <a class="<?= setClass($active_tab,'reject') ?>" href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['tasks_id'] ?>/out/reject');">Rejected</a>
        </div>

        <table class="table_style yellow_header" id="application_list" >
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Applicant</th>
                    <th>Application for</th>
                    <th>Applied on</th>
                    <th>Case Type</th>
                    <th>Case No.</th>
                    <th>Case Year</th>
                    <th>Order Date</th>
                    <th>Certificate Type</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $i = 1;
                foreach($applications as $item){
                    echo '<tr>';
                    echo '<td>'.$i++.'</td>';
                    echo '<td>'.$item['applicant_name'].'</td>';
                    echo '<td>'.$item['application_for'].'</td>';
                    echo '<td>'.date('d-m-Y',strtotime($item['create_at'])).'</td>';
                    echo '<td>'.$item['case_type'].'</td>';
                    echo '<td>'.$item['case_no'].'</td>';
                    echo '<td>'.$item['case_year'].'</td>';
                    echo '<td>'.date('d-m-Y',strtotime($item['order_date'])).'</td>';
                    echo '<td>'.$item['copy_name'].'</td>';
                    echo '<td><a href="'.Config::get('host').'/Application/applicationDetails/'.$item['application_id'].'">View</a></td>';
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
    <script src="<?=Config::get('host')?>/root/MDB/js/dataTable.js" type="text/javascript"></script>
    <script src="<?=Config::get('host')?>/root/MDB/js/dataTables.bootstrap4.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#application_list').DataTable({
                "language":{
                    "emptyTable":"No record available."
                },
                "columnDefs": [
                    { "orderable": false, "targets": [9] },
                    { "searchable": false, "targets": [9] },
                    { "className": "align-center", "targets": [9] }
                ]
            });
        } );
    </script>
<?php	        
    }
?>
</div>