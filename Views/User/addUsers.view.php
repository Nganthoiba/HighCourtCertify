<?php 
$roles = $data['roles'];
?>            
            <div class="container-fluid">
                <form name="addUsers" id="addUsers" method="POST" class="needs-validation" novalidate action="addUsers">
                    
                    <div class="row">
                        <div class="col-sm-4 mx-auto">
                            <h3>Add user below:</h3>
                            <?= writeCSRFToken() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="full_name" class="control-label">Full Name:</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="full_name" id="full_name" class="form-control" required/>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Name can not be left blank.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="email" class="control-label">Email:</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" onblur="checkEmail();" onchange="checkEmail();" onkeyup="checkEmail();" name="email" id="email" class="form-control" required/>
                            <div class="valid-feedback"></div>
                            <div id="email_invalid_feedback" class="invalid-feedback">Email can not be left blank.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label for="phone_number" class="control-label">Mobile Phone No.:</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" autocomplete="new-password" maxlength="10" onblur="validatePhoneNo();" onchange="validatePhoneNo();" onkeyup="validatePhoneNo();" onkeypress="return isNumber(event);" name="phone_number" id="phone_number" class="form-control" required/>
                            <div class="valid-feedback"></div>
                            <div id="phone_number_invalid_feedback" class="invalid-feedback">Mobile Phone No can not be left blank.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label for="role_id" class="control-label">User Role:</label>
                        </div>
                        <div class="col-sm-4">
                            <select class="custom-select small_font" name="role_id" id="role_id" required>
                                <option value="">--- Select Role ---</option>
                                <?php
                                foreach ($roles as $role){
                                    if($role->role_name == "Applicant"){
                                        continue;
                                    }
                                    echo "<option value='".$role->role_id."'>".$role->role_name."</option>";
                                }
                                ?>
                            </select>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Please select user role.</div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-4">
                            <label for="password" class="control-label">Password:</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="password" name="password" id="password" class="form-control" required/>
                            <div class="valid-feedback"></div>
                            <div id="password_invalid_feedback" class="invalid-feedback">Password can not be left blank.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="confirm_password" class="control-label">Confirm Password:</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required/>
                            <div class="valid-feedback"></div>
                            <div id="confirm_password_invalid_feedback" class="invalid-feedback">Confirm Password can not be left blank.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            &nbsp;
                        </div>
                        <div class="col-sm-4" style="text-align: center">
                            <button type="submit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0">Add User</button>
                        </div>
                    </div>
                </form>
                <div id="add_user_response" style="text-align: center"><?= $data['response'] ?></div>
            </div>
            <!--
            <div class="card signup_card">
                <h5 class="card-header default-color white-text py-3">
                    
                </h5>
                <div class="card-body">
                    
                </div> 
            </div>
            -->
            <script type="text/javascript">
                function validatePhoneNo(){
                    var phone_number = $("#phone_number").val().trim();
                    if(phone_number === ""){
                        $("#phone_number_invalid_feedback").show();
                        $("#phone_number_invalid_feedback").html("Phone number can not be left blank.");
                        $("#phone_number").attr("class","form-control custom_invalid_field");
                    }
                    else if(phone_number.length!==10 || isNaN(phone_number)){
                        $("#phone_number_invalid_feedback").show();
                        $("#phone_number_invalid_feedback").html("Invalid phone number");
                        $("#phone_number").attr("class","form-control custom_invalid_field");
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
                        $("#email").attr("class","form-control custom_invalid_field");
                        $("#email_invalid_feedback").show();
                        return false;
                    }
                    if(isValidEmail(email)){
                        $("#email_invalid_feedback").hide();
                        $("#email").removeClass("custom_invalid_field");
                        return true;
                    }
                    else{
                        $("#email").attr("class","form-control custom_invalid_field");
                        $("#email_invalid_feedback").html("Your email is not valid");
                        $("#email_invalid_feedback").show();
                    }
                    return false;
                }
                
                document.forms["addUsers"].onsubmit = function(event){
                    event.preventDefault();
                    var valid = isValidated();
                    if( valid == true){
                        $("#add_user_response").html("Wait please ...");
                        document.forms["addUsers"].submit();
                    }
                    //document.forms['addUsers'].submit();
                };
                
                function isValidated(){                    
                    if(checkEmail()==false){
                        return false;
                    }
                    if(validatePhoneNo()==false){
                        return false;
                    }
                    
                    var password = $("#password").val().trim();
                    var confirm_password = $("#confirm_password").val().trim();
                    if(password !== confirm_password){
                        $("#confirm_password").attr("class","form-control custom_invalid_field");
                        $("#confirm_password_invalid_feedback").html("Please type confirmation password correctly.");
                        $("#confirm_password_invalid_feedback").show();
                        /*
                         * swal.fire({
                            icon:"error",
                            title: 'Error',
                            text: "Please type confirmation password correctly.",
                            type: 'error',
                            confirmButtonText: 'OK'
                        });
                        */
                        return false;
                    }
                    return true;
                }
            </script>
