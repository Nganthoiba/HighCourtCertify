<style type="text/css">
    .login_layout {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    /*
    body{
        background-image: url('<?=Config::get('host')?>/root/MDB/img/highcourt_bg.jpg');
        background-size: cover;
    }
    */
</style>
<div class="vertical-center">
    
    <div class="col-md-4 mb-4 login_layout">
        <!-- Material form login -->
        <div class="card">
            <h5 class="card-header default-color white-text text-center py-4">Welcome, <strong>Sign in</strong></h5>
            <!--
            <div style="text-align: center">
                <img class="rounded-circle"
                         src="<?= Config::get('host') ?>/root/MDB/img/high_court_logo.jpg" alt="not found"/>
            </div>
            -->
            <!--Card content-->
            <div class="card-body px-lg-5 pt-0">
                
                <!-- Form -->
                <form style="color: #757575;" method="POST" autocomplete="off">
                    <!-- CSRF token -->
                    <?= writeCSRFToken() ?>
                    <!-- Email -->
                    <div class="md-form">
                        <i class="fa fa-envelope prefix"></i>
                        <input type="text" id="email" autocomplete="false" name="email" value="<?= $data['email'] ?>" class="form-control">
                        <label for="email">Your email</label>
                    </div>

                    <!-- Password -->
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" id="password" autocomplete="new-password" name="password" value="<?= $data['password'] ?>" class="form-control">
                        <label for="password">Password</label>
                    </div>

                    <div class="d-flex justify-content-around">
                        <div>
                            <!-- Remember me -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="materialLoginFormRemember">
                                <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
                            </div>
                        </div>
                        
                        <div>
                            <!-- Forgot password -->
                            <a href="forgotPassword">Forgot password?</a>
                        </div>
                    </div>
                    <!-- Sign in button -->
                    <button class="btn btn-outline-primary btn-rounded btn-block my-4 waves-effect rounded-pill" type="submit">Sign in</button>
                    <div class="text-center">
                        <!-- Register -->
                        <p>Not a member?
                            <a href="<?=Config::get('host')?>/account/signup">Sign Up</a>
                        </p>
                        <p style="color: red"><?= $data['login_response'] ?></p>
                        <!-- Social login 
                        <p>or sign in with:</p>

                        <a type="button" class="btn-floating btn-fb btn-sm">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                        <a type="button" class="btn-floating btn-tw btn-sm">
                          <i class="fab fa-twitter"></i>
                        </a>
                        <a type="button" class="btn-floating btn-li btn-sm">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a type="button" class="btn-floating btn-git btn-sm">
                          <i class="fab fa-github"></i>
                        </a>-->
                    </div>
                </form>
                <!-- Form -->

          </div>

        </div>
        <!-- Material form login -->
    </div>
</div>