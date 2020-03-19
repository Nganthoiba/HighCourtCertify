<?php
$report = $data['report'];//payment report
$payment = $report->data;
?>

<div class="container">
    <div class="row">
        <span class="col-sm-3"><h3>Receipt</h3></span>
        <span class="col-sm-3" style="text-align: right">
            <button class="btn btn-primary" onclick="printReceipt();">
                <span class="fa fa-print"></span> Print
            </button>
        </span>
    </div>
    <div class="col-sm-6" id="receipt_contents">        
        <table border="1" class="table table-bordered">
            <tr>
                <td><strong>Transaction ID:</strong></td>
                <td><?= $payment->transaction_id ?></td>
            </tr>
            <tr>
                <td><strong>Amount:</strong></td>
                <td>Rs <?= $payment->amount ?>/-</td>
            </tr>
            <tr>
                <td><strong>Purpose:</strong></td>
                <td><?= $payment->purpose ?></td>
            </tr>
            <tr>
                <td><strong>Application ID:</strong></td>
                <td><?= $payment->application_id ?></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td><?= $payment->status ?></td>
            </tr>
            <tr>
                <td><strong>Date of payment:</strong></td>
                <td>
                    <?php 
                    $create_at_timestamp = strtotime($payment->created_at);
                    echo date('d-M-Y',$create_at_timestamp);
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    function printReceipt() { 
        var divContents = document.getElementById("receipt_contents").innerHTML; 
        var a = window.open('', '', 'height=450, width=550'); 
        a.document.write('<html>'); 
        a.document.write('<body>'); 
        a.document.write('<link href="<?=Config::get('host')?>/root/MDB/css/bootstrap.css" rel="stylesheet">');
        a.document.write('<div class="container-fluid">'); 
        a.document.write('<div style="text-align:center;"><h2>The High Court of Manipur</h2></div>'); 
        a.document.write('<h4>Receipt</h4>'); 
        
        a.document.write(divContents); 
        
        a.document.write("</div>"); 
        
        a.document.write('</body></html>'); 
        a.document.close(); 
        a.print(); 
    } 
</script>