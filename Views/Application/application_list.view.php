<link href="<?= Config::get('host') ?>/root/MDB/css/dataTable.css" rel="stylesheet" type="text/css"/>
<?php
if(!$data['status']){
	echo $data['msg'];
}
else{
?>
<div class="container-fluid">
    <a href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['process_id'] ?>/in');">Incomming</a> |
    <a href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['process_id'] ?>/out/approve');">Approved</a> |
    <a href="javascript: location.assign('<?= config::get('host') ?>/Application/application_list/<?= $data['process_id'] ?>/out/reject');">Rejected</a> 
    <table class="table_style yellow_header" id="application_list" >
	<thead>
		<tr>
			<th>Sl. No.</th>
			<th>Applicant</th>
			<th>Application For</th>
			<th>Date</th>
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
		foreach($data['data'] as $item){
			echo '<tr>';
			echo '<td>'.$i++.'</td>';
			echo '<td>'.$item['applicant_name'].'</td>';
			echo '<td>'.$item['application_for'].'</td>';
			echo '<td>'.date('d-m-Y',strtotime($item['action_date'])).'</td>';
			echo '<td>'.$item['case_type'].'</td>';
			echo '<td>'.$item['case_no'].'</td>';
			echo '<td>'.$item['case_year'].'</td>';
			echo '<td>'.date('d-m-Y',strtotime($item['order_date'])).'</td>';
			echo '<td>'.$item['copy_name'].'</td>';
			echo '<td><a href="'.Config::get('host').'/Application/viewdetails/'.$item['application_id'].'/'.$data['process_id'].'">View</a></td>';
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
            }
        });
    } );
</script>
<?php	
}
?>

