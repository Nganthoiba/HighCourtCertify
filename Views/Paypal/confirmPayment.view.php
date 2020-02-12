<?php
$amount = $data['amount'];
$application_id = $data['application_id'];
?>
<div class="container">
    <form name="paymentConfirmForm" method="POST" action="/Paypal/ValidateCommand">
        <h3>Payment for processing fee of application.</h3>
        <div class="row">
            <div class="col-sm-2"><label>Application ID:</label></div>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="application_id" value="<?= $application_id ?>"  readonly />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"><label>Amount in Rs:</label></div>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="amount" value="<?= $amount ?>"  readonly />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-default">Confirm
                </button>
            </div>
        </div>
    </form>
</div>

