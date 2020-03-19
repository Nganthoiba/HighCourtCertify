<?php
$certificate_list = $data['certificate_list'];
$case_type_list = $data['case_type_list'];
$copy_type_list = $data['copy_type_list'];
$third_party_reasons = $data['third_party_reasons'];
?>
<div class="container">            
    <div id="application_form_layout" >
        <form name="application_form" id="application_form" class="needs-validation" novalidate method="POST" action="#">
            
            <div><?= writeCSRFToken() ?></div>
            <div class="row" style="width: 100%; text-align: center">
                <div class="col-sm-12">
                    <h4>FORM NO. 13</h4>
                    <p><i>(Civil) <br/> (Rule 18, Chapter XII)</i></p>
                    <h3>Form of Application for Copy</h3>
                    <h5>Offline Entry</h5>
                    <p style="color: #d50000; font-size: 10pt;">#Note: The fields labeled with * symbols are mandatory.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="applicant_name" class="control-label">Name of the applicant (*):</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="applicant_name" id="applicant_name" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill out name of the applicant.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="aadhaar" class="control-label">Aadhaar Number (*):</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="aadhaar" id="aadhaar" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill out aadhaar of the applicant.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="certificate_type_id" class="control-label">Applications for (*):</label>
                </div>
                <div class="col-sm-6">
                    <select name="certificate_type_id" id="certificate_type_id" class="custom-select  small_font" required>
                        <option value="">-- Select --</option>
                        <?php
                        foreach($certificate_list as $certificate_type ){
                        ?>
                            <option value="<?= $certificate_type->certificate_type_id ?>">
                                <?= $certificate_type->name ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please select whether urgent or ordinary.</div>
                </div>
            </div>

            <div class="row"  >
                <div class="col-sm-4">
                    <label for="certificate_type_id" class="control-label">Case type (*):</label>
                </div>
                <div class="col-sm-6">
                    <select name="case_type" id="case_type" class="custom-select small_font" required>
                        <option value="">Select Case Type</option>
                        <?php 
                        foreach ($case_type_list as $case_type){
                        ?>
                        <option value="<?= $case_type->case_type_id ?>">
                            <?= $case_type->type_name ?> - <?= $case_type->full_form ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please select case type.</div>
                </div>
            </div>

            <div class="row"  >
                <div class="col-sm-4">
                    <label class="control-label" for="case_no">Case No. (*):</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" onkeypress="return isNumber(event);" name="case_no" id="case_no" class="form-control" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill case no.</div>
                </div>
            </div>
            <div class="row"  >
                <div class="col-sm-4">
                    <label for="case_year" class="control-label">Case Year (*):</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" onkeypress="return isNumber(event);" name="case_year" id="case_year" class="form-control" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill case year.</div>
                </div>
            </div>
            <div class="row"  >
                <div class="col-sm-4">
                    <label for="reference" class="control-label">Reference (if any):</label>
                </div>
                <div class="col-sm-6">
                    <div style="margin-bottom: 10px;">
                        <select name="case_type_reference" id="case_type_reference" class="custom-select small_font">
                            <option value="">Select Case Type for reference</option>
                            <?php 
                            foreach ($case_type_list as $case_type){
                            ?>
                            <option value="<?= $case_type->case_type_id ?>">
                                    <?= $case_type->type_name ?> - <?= $case_type->full_form ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <input type="text" name="case_no_reference" placeholder="Refer to which case number" id="case_no_reference" class="form-control"/>
                    </div>
                    <div style="margin-bottom: 1px;">
                        <input type="text" name="case_year_reference" placeholder="Refer to which case year" id="case_year_reference" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="row"  >
                <div class="col-sm-4">
                    <label class="control-label">Are you third party? (*):</label>
                </div>
                <div class="col-sm-1" style="margin-top: 5px">
                    <div class="custom-control custom-radio">
                        <input type="radio" onclick="display_reason(false);" class="custom-control-input" name="third_party" id="third_party_no" value="n" checked/>&nbsp;
                        <label class="custom-control-label" style="cursor:pointer" for="third_party_no">No</label>&nbsp;
                    </div>
                </div>
                <div class="col-sm-1" style="margin-top: 5px">
                    <div class="custom-control custom-radio">
                        <input type="radio" onclick="display_reason(true);" class="custom-control-input" name="third_party" id="third_party_yes" value="y" />&nbsp;
                        <label class="custom-control-label" style="cursor:pointer" for="third_party_yes">Yes</label>&nbsp;
                    </div>
                </div>
            </div>
            
            <div class="row"  id="third_party_reason_options" style="display:none;margin-top:-10px;">
                <div class="col-sm-4"></div>
                <div class="col-sm-6">
                    <select id="reasons" class="form-control" onchange="selectReasons(this);">
                        <option value="">Select a reason</option>
                        <?php
                        foreach ($third_party_reasons as $reason){
                        ?>
                        <option value="<?= $reason->third_party_reasons_id ?>">
                            <?= $reason->reasons ?>
                        </option>
                        <?php
                        }
                        ?>
                        <option value="<?= count($third_party_reasons)+1 ?>">Others</option>
                    </select>
                </div>
            </div>
            <div class="row"  id="third_party_reason_input_layout" style="display:none;">
                <div class="col-sm-4"></div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="third_party_reason" 
                           placeholder="Give reason for requesting certificate copy." id="third_party_reason" />
                </div>
            </div>
            
            <div class="row"  >
                <div class="col-sm-4">
                    <label for="appel_petitioner" class="control-label">Appellant/Petitioner (*):</label>
                </div>
                <div class="col-sm-6">
                     <input type="text" name="appel_petitioner" id="appel_petitioner" 
                            class="form-control" required/>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill out name of the Appellant/Petitioner.</div>
                </div>
            </div>

            <div class="row"  >
                <div class="col-sm-4">
                    <label for="respondant_opp" class="control-label">Respondent/Opposite Party (*):</label>
                </div>
                <div class="col-sm-6">
                     <input type="text" name="respondant_opp" id="respondant_opp" class="form-control" required/>
                     <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please fill out name of the Respondent/Opposite Party.</div>
                </div>
            </div>
            
            <div class="row" id="order_date_layout">
                <div class="col-sm-4">
                    <label for="order_date" class="control-label">Date of Order/Disposal (*):</label>
                </div>
                <div class="col-md-6" >
                    <div class="input-group mb-3">
                        <input type="text" name="order_date" id="order_date" class="form-control date_picker" required/>
                        <span class="input-group-append" >
                            <label class="input-group-text" for="order_date"><i class="fa fa-calendar"></i></label>
                        </span> 
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Please fill your Date of Order or Disposal.</div>
                    </div>
                </div>
            </div>
            
            <div class="row" >
                <div class="col-sm-4">
                    <label for="certificate_type_id" class="control-label">Certificate Copy type  (*):</label>
                </div>
                <div class="col-sm-6">
                    <select class="custom-select small_font" name="copy_type_id" id="copy_type_id" required>
                        <option value="">-- Select --</option>
                        <?php
                        foreach($copy_type_list as $copy_type){
                        ?>
                        <option value="<?= $copy_type->copy_type_id ?>"><?= $copy_type->copy_name ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Please select certificate copy type.</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4" style="text-align: right"></div>
                <div class="col-sm-6">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" onclick="enableSubmitButton(this);"
                               name="agree" id="agree" required/>
                        <label class="custom-control-label" for="agree" 
                               style="font-size: 10pt;font-style:oblique;color: #005cbf;cursor: pointer ">
                        I have confirmed that the information I am submitting is true and correct up to my knowledge. And I 
                        bear the responsibility of the correctness of the above information. 
                        </label>
                    </div>
                    <div class="alert alert-danger" style="font-size: 10pt;font-style:oblique;text-align: center">
                        #Note: Application once submitted cannot be changed
                    </div>
                </div>
            </div>
            <div class="row" id="order_date_layout">
                <div class="col-sm-4">
                    
                </div>
                <div class="col-md-6" >
                    <center>
                        <button id="submit_application" type="submit" class="btn btn-secondary" disabled>Submit</button>
                    </center>
                </div>
            </div>
        </form>
    </div>
    
    <div id="submission_result" class="alert alert-success" 
         style="margin-bottom: 50px; text-align: center; display:none"></div>
</div>
<script type="text/javascript">
    function selectReasons(obj){
        //alert(obj.options[obj.value].innerHTML);
        if(obj.options[obj.value].innerHTML === "Others"){
            $("#third_party_reason_input_layout").show();
            $("#third_party_reason").val("");
        }
        else{
            $("#third_party_reason_input_layout").hide();
            $("#third_party_reason").val(obj.options[obj.value].innerHTML.trim());
        }
    }
    function display_reason(flag){
        var reasons = document.getElementById("reasons");
        if(flag){
            $("#third_party_reason_options").show();
            if(reasons.options[reasons.value].innerHTML === "Others"){
                $("#third_party_reason_input_layout").show();
            }
            if(document.getElementById("third_party_reason").value.trim() === "dummy"){
                document.getElementById("third_party_reason").value = "";
            }
        }
        else{
            $("#third_party_reason_options").hide();
            $("#third_party_reason_input_layout").hide();
            if(document.getElementById("third_party_reason").value.trim() === ""){
                document.getElementById("third_party_reason").value = "dummy";
            }
        }
    }
    function enableSubmitButton(obj){
        //alert(obj.checked);
        if(obj.checked == true){
            document.getElementById("submit_application").disabled = false;
        }
        else{
            document.getElementById("submit_application").disabled = true;
        }
    }
    
    document.forms["application_form"].onsubmit = function(event){
        event.preventDefault();
        if(!validateForm()){
            return false;
        }
        submitApplication();
    };

    $(document).ready(function(){
        $("#aadhaar").inputmask({"mask": "9999 9999 9999"});
        $("#aadhaar_otp").inputmask({"mask": "999999"});
        $("#order_date").inputmask({"mask": "99/99/9999"});
        
        $('.date_picker').datepicker({
            format: 'dd/mm/yyyy',
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });
        
    });
    embed_text_editor();
    function embed_text_editor(){
        tinymce.init({ 
            selector:'textarea.tinymce',
            height:450,
            plugins: ["textcolor","link"],
            toolbar: 'insertfile undo redo | styleselect | bold italic | '+
                            'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | '+
                            'link | fontsizeselect | forecolor backcolor',
            default_link_target: "_blank",
            link_title: false,
            branding: false,
            link_assume_external_targets: true,
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,'+
                                    'monospace;AkrutiKndPadmini=Akpdmi-n'	
        });
    }

    function changeType(val){
        //$("#order_date").attr("required","");
        if(val == "1"){
            $("#write_application_area").hide();
            //$("#order_date_layout").show();

        }
        else{
            $("#write_application_area").show();
            //$("#order_date_layout").hide();
        }
    }
    function customAlert(message){
        
        Swal.fire({
            title: message,
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        });
    }
    /* Form validation part*/
    function validateForm(){
        var applicant_name = $("#applicant_name").val().trim();
        var aadhaar = $("#aadhaar").val().trim();
        var case_type = $("#case_type").val().trim();
        var case_no = $("#case_no").val().trim();
        var case_year = $("#case_year").val().trim();
        var appel_petitioner = $("#appel_petitioner").val().trim();
        var respondant_opp = $("#respondant_opp").val().trim();
        var certificate_type_id = $("#certificate_type_id").val().trim();
        var copy_type_id = $("#copy_type_id").val().trim();

        var order_date = $("#order_date").val().trim();
        var third_party = getSelectedRadioButtonValue("third_party");
        
        aadhaar = aadhaar.split(" ").join("");
        if(certificate_type_id === ""){
            //customAlert("Please select Certificate type");
            //$("#certificate_type_id").attr("class","form-control invalid");
            document.getElementById("certificate_type_id").focus();
            return false;
        }
        if(copy_type_id === "" || copy_type_id === undefined){
            //customAlert("Please select Certificate type");
            //$("#certificate_type_id").attr("class","form-control invalid");
            document.getElementById("copy_type_id").focus();
            return false;
        }
        
        if(third_party.trim() === "Yes"){
            var third_party_reason = $("#third_party_reason").val().trim();
            if(third_party_reason === ""){
                alert("Please mention why you need this certificate.");
                return false;
            }
        }
        
        if(aadhaar === "" || applicant_name === "" || case_type === "" || case_no === "" || case_year === "" || appel_petitioner === "" || respondant_opp === "" || order_date === ""){
            return false;
        }
        return true;
    }
    function getSelectedRadioButtonValue(radio_btn_name){
        var radio_elements = document.getElementsByName(radio_btn_name);
        for(var i=0; i<radio_elements.length; i++){
            if(radio_elements[i].checked){
                return radio_elements[i].value;
            }
        }
        return "";
    }
    function submitApplication(){
        //var applnForm = new FormData(document.forms["application_form"]);
        var applicant_name = $("#applicant_name").val().trim();
        var aadhaar = $("#aadhaar").val().trim();
        var case_type = $("#case_type").val().trim();
        var case_no = $("#case_no").val().trim();
        var case_year = $("#case_year").val().trim();
        var case_type_reference = $("#case_type_reference").val().trim();
        var case_no_reference = $("#case_no_reference").val().trim();
        var case_year_reference = $("#case_year_reference").val().trim();
        var appel_petitioner = $("#appel_petitioner").val().trim();
        var respondant_opp = $("#respondant_opp").val().trim();
        var certificate_type_id = $("#certificate_type_id").val().trim();
        var copy_type_id = $("#copy_type_id").val().trim();
        var order_date = $("#order_date").val().trim();
        var csrf_token = $("#csrf_token").val().trim();
        var third_party_reason = $("#third_party_reason").val().trim();
        
        aadhaar = aadhaar.split(" ").join("");
        var data = {
            copy_type_id: copy_type_id,
            case_type: case_type,
            case_no: case_no,
            case_year: case_year,
            case_type_reference: case_type_reference,
            case_no_reference: case_no_reference,
            case_year_reference: case_year_reference,
            appel_petitioner: appel_petitioner,
            respondant_opp: respondant_opp,
            certificate_type_id: certificate_type_id,
            order_date: order_date,
            csrf_token: csrf_token,
            is_third_party: getSelectedRadioButtonValue("third_party"),
            third_party_reason: third_party_reason,
            is_offline: "y",
            applicant_name: applicant_name,
            aadhaar: aadhaar
        };
        //$("#application_form").serialize();
        $.ajax({ 
            url: "apply",
            data: data,
            type: "POST",
            /*
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            */
            success: function(resp){
                //customAlert(resp.msg);
                $("#submission_result").show();
                $("#submission_result").html(resp.msg);
                $("#otp_verify_layout").hide();
                if(resp.status === true){
                    swal.fire({
                        title: 'Success',
                        text: resp.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            //window.location.assign("viewApplications");
                            var application = resp.data;
                            window.location.assign("<?= getHtmlLink("Paypal", "offlinePayment") ?>/"+application.application_id);
                        }
                    });
                }
                else{
                    $("#submission_result").attr("class","alert alert-warning");
                }
            },
            error: function (jqXHR, exception, errorThrown) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } 
                else{
                    var resp = JSON.parse(jqXHR.responseText);
                    msg = resp.msg;
                }
                swal.fire({
                    title: 'Error',
                    text: msg,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
    
</script>


