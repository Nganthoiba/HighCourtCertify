<div class="container-fluid">
        <div class="">
            <div class="card signup_card">
                <h5 class="card-header default-color white-text text-center py-3">
                    <strong>Sign in</strong>
                    <span style="padding-left: 10px">Please fill in this form to create your account.</span>
                </h5>
                
                <div class="card-body">
                    <form name="sign_up" method="POST" class="needs-validation" novalidate action="signup">
                        <input type="hidden" name="action" value="sign_up" />
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="full_name" class="control-label">Full Name:</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="full_name" id="full_name" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Name can not be left blank.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="email" class="control-label">Email:</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" onblur="checkEmail();" onchange="checkEmail();" onkeyup="checkEmail();" name="email" id="email" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div id="email_invalid_feedback" class="invalid-feedback">Email can not be left blank.</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="phone_number" class="control-label">Mobile Phone No.:</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" maxlength="10" onblur="validatePhoneNo();" onchange="validatePhoneNo();" onkeyup="validatePhoneNo();" onkeypress="return isNumber(event);" name="phone_number" id="phone_number" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div id="phone_number_invalid_feedback" class="invalid-feedback">Mobile Phone No can not be left blank.</div>
                            </div>
                        </div>
                        <!--
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="user_role" class="control-label">User Role:</label>
                            </div>
                            <div class="col-sm-6">
                                <select class="custom-select small_font" name="user_role" id="user_role" required>
                                
                                </select>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Please select user role.</div>
                            </div>
                        </div>
                        
                        -->
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="password" class="control-label">Password:</label>
                            </div>
                            <div class="col-sm-6">
                                <input autocomplete="new-password" type="password" onkeyup="isConfPasswordMatched();" name="password" id="password" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div id="password_invalid_feedback" class="invalid-feedback">Password can not be left blank.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="conf_password" class="control-label">Confirm Password:</label>
                            </div>
                            <div class="col-sm-6">
                                <input autocomplete="new-password" type="password" onkeyup="isConfPasswordMatched();" name="conf_password" id="conf_password" class="form-control"  required/>
                                <div class="valid-feedback"></div>
                                <div id="conf_password_invalid_feedback" class="invalid-feedback">Please enter your confirmation password.</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label">Enter the text:</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-4">
                                    <input type="text" id="captcha_code" name="captcha_code" class="form-control" required/>
                                    <span class="input-group-append">
                                        <label class="input-group-text" for="captcha_code" style="padding: 0px 0px 0px 0px;">
                                            <img src="<?=Config::get('host')?>/default/captcha?rand=<?php echo rand();?>" name='captchaimg' id='captchaimg'>
                                        </label>
                                    </span> 
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Please fill the text.</div>
                                    <div class="small_font">Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.</div>
                                </div>
                                <div id="signup_response"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                &nbsp;
                            </div>
                            <div class="col-sm-6" style="text-align: center">
                                <button type="submit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0">Sign Up</button>
                            </div>
                        </div>
                    </form>
                
                </div> 
            </div>
        </div>
        <script type="text/javascript">
            /*** Getting user roles module ***/
            /*
            var args = {
                url   :   "qry_register.php",
                param :   "action=get_roles",
                type  :   "JSON",
                method:   "GET"
            };
            var resp = ajax_request(args);
            if(resp.status === true){
                var roles = resp.roles;
                var layout = "<option value=''>Select Role</option>";
                for(var i=0; i<roles.length; i++){
                    layout += "<option value='"+roles[i].role_id+"'>"+roles[i].name+"</option>";
                }
                document.getElementById("user_role").innerHTML = layout;
            }
            */
            function refreshCaptcha(){
                var img = document.images['captchaimg'];
                //img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
                img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000+"&action=captcha";
            }  
            function validatePhoneNo(){
                var phone_number = $("#phone_number").val().trim();
                if(phone_number === ""){
                    $("#phone_number_invalid_feedback").show();
                    $("#phone_number_invalid_feedback").html("Phone number can not be left blank.");
                    $("#phone_number").addClass("custom_invalid_field");
                }
                else if(phone_number.length!==10 || isNaN(phone_number)){
                    $("#phone_number_invalid_feedback").show();
                    $("#phone_number_invalid_feedback").html("Invalid phone number");
                    $("#phone_number").addClass("custom_invalid_field");
                }
                else{
                    $("#phone_number_invalid_feedback").hide();
                    $("#phone_number_invalid_feedback").html("Mobile Phone No can not be left blank.");
                    $("#phone_number").removeClass("custom_invalid_field");
                    return true;
                }
                return false;
            }  
            function checkEmail(){
                email = $("#email").val();
                email = email.trim();
                if( email === ""){
                    $("#email_invalid_feedback").html("Email can not be left blank.");
                    $("#email").addClass("custom_invalid_field");
                    $("#email_invalid_feedback").show();
                    return false;
                }
                if(isValidEmail(email)){
                    $("#email_invalid_feedback").hide();
                    $("#email").removeClass("custom_invalid_field");
                    return true;
                }
                else{
                    $("#email").addClass("custom_invalid_field");
                    $("#email_invalid_feedback").html("Your email is not valid");
                    $("#email_invalid_feedback").show();
                }
                return false;
            }  

            /* function to check whether password matches confirmation password */
            function isConfPasswordMatched(){
                var password = $("#password").val().trim();
                var conf_password = $("#conf_password").val().trim();
                if(password === "" || conf_password === ""){
                    return false;
                }
                else{
                    if(password === conf_password){
                        $("#conf_password_invalid_feedback").hide();
                        $("#conf_password_invalid_feedback").html("Please enter your confirmation password.");
                        //$("#conf_password").attr("class","form-control");
                        $("#conf_password").removeClass("custom_invalid_field");
                        return true;
                    }
                    else{
                        //$("#conf_password").attr("class","form-control custom_invalid_field");
                        $("#conf_password").removeClass("valid");
                        $("#conf_password").addClass("custom_invalid_field");

                        $("#conf_password_invalid_feedback").show();
                        $("#conf_password_invalid_feedback").html("Confirmation password does not match your password");
                        return false;
                    }
                }
            }

            function isValidated(){
                var full_name = $("#full_name").val();
                var captcha_code = $("#captcha_code").val();
                if(full_name.trim() === "" || captcha_code.trim() === "" || !checkEmail() || !validatePhoneNo() || !isConfPasswordMatched()){
                    return false;
                }
                return true;
            }

            document.forms['sign_up'].onsubmit = function(event){
                event.preventDefault();
                if(isValidated()){
                    //this.submit();
                    $("#signup_response").html("Please wait ...");
                    var applnForm = new FormData(document.forms["sign_up"]);
                    $.ajax({
                        url: "signup",
                        data: applnForm,
                        type: "POST",
                        contentType: false,       // The content type used when sending data to the server.
                        cache: false,             // To unable request pages to be cached
                        processData:false,
                        success: function(resp){
                            //customAlert(resp.msg);
                            $("#signup_response").show();
                            $("#signup_response").html(resp.msg);
                            if(resp.status === true){
                                $("#signup_response").attr("class","alert alert-success");
                                //document.forms['sign_up'].reset();
                            }
                            else{
                                $("#signup_response").attr("class","alert alert-warning");
                            }
                            refreshCaptcha();
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
                            /*
                            else if (jqXHR.status === 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status === 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            */
                            $('#signup_response').html(msg);
                            $("#signup_response").attr("class","alert alert-warning");
                            refreshCaptcha();
                        }
                    });
                }
            };
        </script>
            
    </div>