<?php
if($viewData->status){
$amount = $viewData->amount;
$application_id = $viewData->application_id;
///Paypal/ValidateCommand
?>
<div class="container">
    <form name="paymentConfirmForm" method="POST" action="<?= getHtmlLink("Paypal", "ValidateCommand") ?>">
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
<?php
}
else{
?>
<div class="container"><div class="alert alert-warning"><?= $viewData->msg ?></div></div>
<?php
}

