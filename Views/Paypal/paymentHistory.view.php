<?php
$response = $data['response'];
$list_of_payments = $response->data;
?>
<div class="container">
    <h3>Payment History</h3>
    <table class="table table-light">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Application ID</th>
                <th>Purpose</th>
                <th align="right">Amount (Rs)</th>
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
                <td><?= date('d-M-Y',$create_at_timestamp) ?></td>
                <td><?= $payment->application_id ?></td>
                <td><?= $payment->purpose ?></td>
                <td align="right"><?= $payment->amount ?></td>
            </tr>
            <?php
                $cnt++;
            }
            if($cnt == 0){
            ?>
            <tr>
                <td colspan="5" align="center">No payment yet.</td>
            </tr>
            <?php
            }
            ?>
            
        </tbody>
    </table>
</div>


