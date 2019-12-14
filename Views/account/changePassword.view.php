<?php
    $user_info = $_SESSION['user_info'];
    $login_id = $user_info['login_id'];
?>
<div class="container-fluid">
    <form name="changePassword" id="changePassword" method="POST" class="needs-validation" novalidate action="resetPassword">

        <div class="row">
            <div class="col-sm-4 mx-auto">
                <h3>Change your password:</h3>
                <input type="hidden" name="login_id" value="<?= $login_id ?>"/>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-4">
                <label for="old_password" class="control-label">Old Password:</label>
            </div>
            <div class="col-sm-4">
                <input type="password" name="old_password" id="old_password" class="form-control" required/>
                <div class="valid-feedback"></div>
                <div id="password_invalid_feedback" class="invalid-feedback">Old Password can not be left blank.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="new_password" class="control-label">New Password:</label>
            </div>
            <div class="col-sm-4">
                <input type="password" name="new_password" id="new_password" class="form-control" required/>
                <div class="valid-feedback"></div>
                <div id="password_invalid_feedback" class="invalid-feedback">New Password can not be left blank.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="conf_new_password" class="control-label">Confirm New Password:</label>
            </div>
            <div class="col-sm-4">
                <input type="password" name="conf_new_password" id="conf_new_password" class="form-control" required/>
                <div class="valid-feedback"></div>
                <div id="password_invalid_feedback" class="invalid-feedback">Confirmation Password can not be left blank.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                &nbsp;
            </div>
            <div class="col-sm-4" style="text-align: center">
                <button type="submit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0">Change</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8" style="text-align: center">
                <span id="change_password_response"></span>
            </div>
        </div>
    </form>
    
    <script type="text/javascript">
        document.forms['changePassword'].onsubmit = function(event){
            event.preventDefault();
            if(!validate()){
                return;
            }
            else{
                //$("#change_password_response").html("Wait please ...");
                $.ajax({
                    url: "<?= Config::get('host') ?>/Account_api/changePassword",
                    type: "POST",
                    data: $("#changePassword").serialize(),
                    success: function(resp){
                        //$("#change_password_response").html(resp.msg);
                        //$("#change_password_response").attr("class","alert alert-success");
                        //alertMessage(resp.msg);
                        alertMessage(resp.msg,"success","Success",'success');
                    },

                    error: function(jqXHR, exception, errorThrown){
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } 
                        else{
                            var resp = JSON.parse(jqXHR.responseText);
                            msg = resp.msg;
                        }
                        alertMessage(msg,"error","Oops!",'error');
                        //$("#change_password_response").html(msg);
                        //$("#change_password_response").attr("class","alert alert-warning");
                    }
                });
            }
        };
        
        function validate(){
            var old_password = $("#old_password").val().trim();
            var new_password = $("#new_password").val().trim();
            var conf_new_password = $("#conf_new_password").val().trim();
            if(old_password === "" || new_password === "" || conf_new_password === ""){
                return false;
            }
            return true;
        }
        
        function alertMessage(msg,icon,title,type){
            swal.fire({
                icon: icon,
                title: title,
                text: msg,
                type: type,
                confirmButtonText: 'OK'
            });
        }
    </script>
</div>