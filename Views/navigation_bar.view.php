<!--Navbar-->
<?php 
$isAuthenticated = Logins::isAuthenticated();
if($isAuthenticated){
    $user_info = $_SESSION['user_info'];
}
?>
        <nav class="navbar navbar-expand-lg navbar-dark custom-nav-grey fixed-top">
            
            <div class="container-fluid">
                
                <!-- Navbar brand -->
                <a class="navbar-brand" href="javascript:void(0);">
                    <?php 
                    if($isAuthenticated){
                    ?>
                        <span class="navbar-toggler-icon" id="sidebarCollapse"></span>
                    <?php 
                    } 
                    ?>
                    <?= Config::get('app_name') ?>
                </a>
            
            <?php 
                if($isAuthenticated){
            ?>
                <ul class="navbar-nav"  style="padding:1px">
                    <!-- Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbardrop" data-toggle="dropdown" style="text-align: right">
                            <span class="user_full_name">
                                <?= $user_info['full_name'] ?>
                            </span>
                            <span class="fa fa-angle-down"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?= Config::get('host')?>/account/manageAccount">
                                <span class="fa fa-cog"></span>
                                Manage Profile
                            </a>
                            <a class="dropdown-item" href="<?= Config::get('host')?>/account/changePassword">
                                <span class="fa fa-lock"></span>
                                Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= Config::get('host')?>/account/logout">
                                <span class="fa fa-sign-out"></span>
                                Log out
                            </a>
                        </div>
                    </li>
                </ul>
                <!--
                <a id="navbar-static-logout" class="btn btn-default btn-rounded btn-sm waves-effect waves-light" 
                   href="<?= Config::get('host')?>/account/logout">Log out
                </a>
                -->
            <?php
                }
                else{
            ?>
                <a id="navbar-static-login" class="btn btn-default btn-rounded btn-sm waves-effect waves-light" 
                   href="<?= Config::get('host')?>/account/login">Log In
                </a>
            <?php
                } 
            ?>
            <!-- Links -->
            </div>
        </nav>
        <!--/.Navbar-->


