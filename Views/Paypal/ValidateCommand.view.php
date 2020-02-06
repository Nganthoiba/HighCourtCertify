<?php
//$paypal = new PaypalModel(Config::get('IsSandbox'));
$paypal = $data['paypal'];
?>
<div class="container">
    <p style="text-align: center">
        <center>Redirecting for payment, please wait …</center>
    </p>
    <form id="hiddenPaypalForm" name="paypal_submit_form" action="<?= $paypal->actionURL ?>" method="post">
        <input type='hidden' name='business'
                value='<?= $paypal->business ?>'> 
        <input type='hidden'
            name='item_name' value='<?= $paypal->item_name ?>'> 
        <input type='hidden'
            name='item_number' value='<?= $paypal->item_number ?>'/> 
        <input type='hidden'
            name='amount' value='<?= $paypal->amount ?>'/> 
        <input type='hidden'
            name='no_shipping' value='<?= $paypal->no_shipping ?>'/> 
        <input type='hidden'
            name='currency_code' value='<?= $paypal->currency_code ?>'/> 
        <input type='hidden'
            name='notify_url'
            value='<?= $paypal->notify_url ?>'/>
        <input type='hidden' name='cancel_return'
            value='<?= $paypal->cancel_return ?>'/>
        <input type='hidden' name='return'
            value='<?= $paypal->return_url ?>'/>
        <input type="hidden" name="cmd" value="<?= $paypal->cmd ?>"> 
    </form>
    <script type="text/javascript" language="javascript">
        $(document).ready(function () {
            var form = $("#hiddenPaypalForm");
            form.submit();
        });
    </script>
</div>

