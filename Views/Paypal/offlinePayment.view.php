<div class="container">
    <h3>Offline Payment Mode</h3>
    <?php
    if($data['status'] == false){
        echo($data['msg']);
    }
    else{
    ?>
    
    
    
    <p>
        Please download this <a href="<?= Config::get('host') ?>/Paypal/generateOfflineReceipt/<?= $data['application_id'] ?>" target="_blank">invoice</a>, 
        then paste stamps and upload a scan copy of the invoice to complete payment process.
    </p>
    <div id="offline_payment_layout">
        <form name="offline_payment_form" method="POST" action="<?= getHtmlLink("Paypal", "uploadInvoice") ?>">
            <?= writeCSRFToken() ?>
            <input type="hidden" name="application_id" id="application_id" value="<?= $data['application_id'] ?>" />
            <div class="row">
                <div class="col-sm-2">
                    <label for="scan_copy"><strong>Scan Copy:</strong></label>
                </div>
                <div class="col-sm-4">
                    <div class="custom-file overflow-hidden">
                        <input accept="application/pdf" id="scan_copy" 
                               name="scan_copy" type="file" 
                               class="custom-file-input " required />
                        <label for="scan_copy" class="custom-file-label">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label><strong>Amount in Rs:</strong></label>
                </div>
                <div class="col-sm-4">
                    <input type="text" id="amount" name="amount" class="form-control"
                           value="<?= $data['amount'] ?>" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4">
                    <div id="progress_div" class="progress" style="height:30px;display:none">
                        <div id="upload_progress_bar" class="progress-bar bg-success progress-bar-striped" style="height:30px">
                            <span id="percentage"></span>
                        </div>
                    </div>
                    <div id="output" style="width:100%;text-align: center"></div>
                </div>
            </div>
        </form>
    </div>
    
</div>

<script type="text/javascript">
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    document.forms['offline_payment_form'].onsubmit = function(event){
        event.preventDefault();
        swal.fire({
            title: 'Upload receipt',
            text: "Are you sure to submit?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: "No, I am not sure!"
        }).then((result) => {
            if (result.value) {
                uploadReceipt();
            }
        });
    };
    function uploadReceipt(){
        var bar = $('#upload_progress_bar');
        bar.width("0%");
        var percent = $('#percentage');
        percent.html("");
        document.getElementById("output").innerHTML="";
        
        $("#progress_div").show();
        
        var offline_payment_form = document.forms['offline_payment_form'];
        var formData = new FormData(offline_payment_form);
        $.ajax({
            url:offline_payment_form.action,
            data: formData,
            type: "POST",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To disable request pages to be cached
            processData:false,
            xhr: function(){
                var xhr = new XMLHttpRequest();
                xhr.upload.onprogress = function(e){
                    var percentComplete = '0';
                    if(e.lengthComputable){
                        percentComplete = Math.round((e.loaded/e.total) * 100) + "%";
                        
                        bar.width(percentComplete);
                        percent.html(percentComplete);
                    }
                };
                return xhr;
            },
            success: function(resp){
                document.getElementById("output").innerHTML = resp.msg;
                var payment = resp.data;
                alert(resp.msg);
                window.location.assign("<?= getHtmlLink("Paypal", "getReceipt") ?>/"+payment.payments_id);
                
            },
            error: function(jqXHR, exception, errorThrown){
                result = {};
                if (jqXHR.status === 0) {
                    result['msg'] = 'Not connect.\n Verify Network.';
                    result['status'] = jqXHR.status;
                } 
                else{
                    result = JSON.parse(jqXHR.responseText);
                }
                document.getElementById("output").innerHTML = result.msg;
                bar.width("0%");
                percent.html("");
            }
        });
    }
    
</script>
    <?php } ?>
