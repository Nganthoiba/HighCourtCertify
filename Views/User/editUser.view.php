<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$user_info = $_SESSION['user_info'];
$login_id = $user_info['login_id'];
$roles = $data['roles'];
$response =  $data['response'];
if($response->status_code == 200){
    $user = ($response->data);
?>
<div class="container-fluid">
    <form name="editUser" id="editUser" method="POST" class="needs-validation" novalidate action="editUser">

        <div class="row">
            <div class="col-sm-4 mx-auto">
                <h3>Edit user below:</h3>
                <input type="hidden" name="user_id" id="user_id" value="<?= $user->user_id ?>" />
                <input type="hidden" name="login_id" id="login_id" value="<?= $login_id ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="full_name" class="control-label">Full Name:</label>
            </div>
            <div class="col-sm-6">
                <input type="text" value="<?= $user->full_name ?>" name="full_name" id="full_name" class="form-control" required/>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Name can not be left blank.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="email" class="control-label">Email:</label>
            </div>
            <div class="col-sm-6">
                <input type="text" value="<?= $user->email ?>" onblur="checkEmail();" onchange="checkEmail();" onkeyup="checkEmail();" name="email" id="email" class="form-control" required/>
                <div class="valid-feedback"></div>
                <div id="email_invalid_feedback" class="invalid-feedback">Email can not be left blank.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label for="phone_no" class="control-label">Mobile Phone No.:</label>
            </div>
            <div class="col-sm-6">
                <input type="text" value="<?= $user->phone_no ?>" autocomplete="new-password" maxlength="10" onblur="validatePhoneNo();" onchange="validatePhoneNo();" onkeyup="validatePhoneNo();" onkeypress="return isNumber(event);" name="phone_no" id="phone_no" class="form-control" required/>
                <div class="valid-feedback"></div>
                <div id="phone_no_invalid_feedback" class="invalid-feedback">Mobile Phone No can not be left blank.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <label for="role_id" class="control-label">User Role:</label>
            </div>
            <div class="col-sm-6">
                <select class="custom-select small_font" name="role_id" id="role_id" required>
                    <option value="">--- Select Role ---</option>
                    <?php
                    $selected="";
                    foreach ($roles as $role){
                        if($role->role_name == "Applicant"){
                            continue;
                        }
                        $selected = ($user->role_id == $role->role_id)?"selected":"";

                        echo "<option value='".$role->role_id."' $selected>".$role->role_name."</option>";
                    }
                    ?>
                </select>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback">Please select user role.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                &nbsp;
            </div>
            <div class="col-sm-6" style="text-align: center">
                <button type="submit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0">Update</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                &nbsp;
            </div>
            <div class="col-sm-6" style="text-align: center">
                <div id="edit_user_response" style="text-align: center"></div>
            </div>
        </div>
    </form>

</div>

<script type="text/javascript">
    function validatePhoneNo(){
        var phone_no = $("#phone_no").val().trim();
        if(phone_no === ""){
            $("#phone_no_invalid_feedback").show();
            $("#phone_no_invalid_feedback").html("Phone number can not be left blank.");
            $("#phone_no").attr("class","form-control custom_invalid_field");
        }
        else if(phone_no.length!==10 || isNaN(phone_no)){
            $("#phone_no_invalid_feedback").show();
            $("#phone_no_invalid_feedback").html("Invalid phone number");
            $("#phone_no").attr("class","form-control custom_invalid_field");
        }
        else{
            $("#phone_no_invalid_feedback").hide();
            $("#phone_no_invalid_feedback").html("Mobile Phone No can not be left blank.");
            $("#phone_no").removeClass("custom_invalid_field");
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

    document.forms["editUser"].onsubmit = function(event){
        event.preventDefault();
        var valid = isValidated();
        if( valid == true){
            $("#edit_user_response").html("Wait please ...");
            //document.forms["editUser"].submit();
            var url = "<?= Config::get('host') ?>/User_api/updateUser";
            var login_id = $("#login_id").val(); 
            var formData = getFormDataToJson(this);
            //return;
            $.ajax({
                url: url,
                type: "POST",
                ContentType:"application/json",
                data: formData,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer '+login_id);
                },
                success: function(resp){
                    swal.fire({
                        title: 'Success',
                        text: resp.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){
                        if(isConfirm){
                            getUsers();
                        }
                    });
                    $("#edit_user_response").html("");
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
                    $("#edit_user_response").html("");
                }
            });
        }
    };

    function isValidated(){                    
        if(checkEmail()==false){
            return false;
        }
        if(validatePhoneNo()==false){
            return false;
        }
        return true;
    }
    
    function getFormDataToJson(form){
        var obj = {};
        for(var i=0;i<form.elements.length;i++){
            //alert(form.elements[i].name+" = "+form.elements[i].value+" Type = "+form.elements[i].type);
            if((form.elements[i].type).toLowerCase()!="submit"){
                obj[form.elements[i].name] = form.elements[i].value;
            }
        }
        return obj;
    }
</script>
<?php
}
else{
?>
<div class="container">
    <div style="text-align: center" class="alert alert-danger"><?= $response->msg ?></div>
</div>
<?php
}
?>