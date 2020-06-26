<?php
$response = $data['response'];
$list_of_payments = $response->data;
$user_id = Logins::getUserId();
?>
<link href="<?= Config::get('host') ?>/root/MDB/DataTable/css/dataTables.bootstrap4.css" 
      rel="stylesheet" type="text/css"/>

<div class="container">
    <h3>Payment History</h3>
    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>" />
    <table class="table_style blue_header" id="payment_hist_table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date & Time</th>
                <th>Application ID</th>
                <th>Purpose</th>
                <th>Status</th>
                <th align="right">Amount (Rs)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $cnt = 0;
            foreach ($list_of_payments as $payment){
                $create_at_timestamp = strtotime($payment->created_at);
            ?>
            <tr>
                <td><?= $payment->transaction_id ?></td>
                <td><?= date('d M Y, h:i:s a',$create_at_timestamp) ?></td>
                <td><?= $payment->application_id ?></td>
                <td><?= $payment->purpose ?></td>
                <td><?= $payment->status ?></td>
                <td align="right">
                    <span style="padding-right: 15px "><?= $payment->amount ?></span>
                </td>
                <td><a href="<?= getHtmlLink("Paypal", "getReceipt", $payment->payments_id) ?>">Receipt</a></td>
            </tr>
            <?php
                $cnt++;
            }
            if($cnt == 0){
            ?>
            <tr>
                <td colspan="6" align="center">No payment yet.</td>
            </tr>
            <?php
            }
            ?>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Transaction ID</th>
                <th>Date & Time</th>
                <th>Application ID</th>
                <th>Purpose</th>
                <th>Status</th>
                <th align="right">Amount (Rs)</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- Javascript for DataTable -->
<script src="<?=Config::get('host')?>/root/MDB/DataTable/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?=Config::get('host')?>/root/MDB/js/dataTables.bootstrap4.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var columns = [
                { title:'Transaction ID',name: 'transaction_id',data: 'transaction_id',type:"string" },
                { title:'Date & Time',name: 'created_at' ,data: 'created_at' ,type:"datetime"},
                { title:'Application ID',name: 'application_id',data: 'application_id', type:"string"},
                { title:'Purpose',name: 'purpose',data: 'purpose', type:"string"},
                { title:'Status',name: 'status',data: 'status', type:"string"},
                { title:'Amount',name: 'amount',data: 'amount', type:"number"},
                { title:'',name: 'receipt_link',data: 'receipt_link',type:"string" }
            ];
        // Setup - add a text input to each footer cell
        $('#payment_hist_table tfoot th').each( function () {
            var title = $(this).text();
            if(title.trim()!==""){
                $(this).html( '<input type="text" style="font-size:9pt;padding:2px" class="form-control" placeholder="Search '+title+'" />' );
            }
        } );
        var dataTable = $("#payment_hist_table").DataTable({
            buttons: [
                {
                    extend: 'pdf',
                    text: 'Save current page',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                }
            ],
            "language":{
                "emptyTable": "No record available."
            },
            "destroy": true,
            "stateSave": false,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "scrollX": true,
            "columnDefs": [
                { "orderable": false, "targets": [6] },
                { "searchable": false, "targets": [6] },
                { "className": "align-center", "targets": [6] }
                
            ],
            'ajax': {
                'url':"<?= Config::get('host') ?>/Paypal/paymentDataTable/",
                'data': {
                    user_id: $("#user_id").val()
                }
            },
            'columns': columns
            
        });
        // Apply the search
        dataTable.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    });
</script>