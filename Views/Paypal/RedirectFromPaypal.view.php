<?php
$report = $data['report'];//payment report
$payment = $report->data;
?>

<div class="container">
    <div class="col-sm-6">
        <h3>Receipt</h3>
        <table class="table table-bordered">
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
