        <link href="<?= Config::get('host')?>/root/MDB/css/side_navbar.css" rel="stylesheet" type="text/css"/>
            <!-- Sidebar  -->
            <nav id="sidebar" class="sidebar">
                
                <div class="sidebar-header">
                    <p style="color:#000">Welcome</p>
                </div>

                <ul class="list-unstyled components">
                    <?php 
                    //Applicant Menu
                    if(strtolower(Logins::getRoleName()) == "applicant"){
                    ?>
                    <li class="<?= isLinkActive('application/index') ?><?= isLinkActive('application') ?><?= isLinkActive('') ?>">
                        <a href="<?=Config::get('host')?>/application/index">
                            <i class="fa fa-home"></i>
                            Home
                        </a>
                    </li>
                    <li class="<?= isLinkActive('application/apply') ?>">
                        <a href="<?=Config::get('host')?>/application/apply"><i class="fa fa-edit"></i> Apply for copy</a>
                    </li>
                    <!--
                    <li class="<?= isLinkActive('application/status') ?>">
                        <a href="<?=Config::get('host')?>/application/status"><i class="fa fa-clone"></i> Check Status</a>
                    </li>
                    -->
                    <li class="<?= isLinkActive('application/viewApplications') ?>">
                        <a href="<?=Config::get('host')?>/application/viewApplications"><i class="fa fa-desktop"></i> View Applications</a>
                    </li>
                    <?php 
                    }
                    //Admin Menu
                    else if(strtolower(Logins::getRoleName()) == "admin"){
                    ?>
                    <li class="<?= isLinkActive('user/viewUsers') ?>">
                        <a href="<?=Config::get('host')?>/user/viewUsers"><i class="fa fa-edit"></i> 
                            View Users</a>
                    </li>
                    <li class="<?= isLinkActive('user/addUsers') ?>">
                        <a href="<?=Config::get('host')?>/user/addUsers"><i class="fa fa-plus-circle"></i> Add User</a>
                    </li>
                    <li class="<?= isLinkActive('role/addRoles') ?>">
                        <a href="<?=Config::get('host')?>/role/addRoles"><i class="fa fa-plus-circle"></i> Add Roles</a>
                    </li>
                    <li class="<?= isLinkActive('role/processRoleMapping') ?>">
                        <a href="<?=Config::get('host')?>/role/processRoleMapping"><i class="fa fa-bullhorn"></i> Process Roles Mapping</a>
                    </li>
                    <?php
                    }
                    else if((Logins::getRoleName()) == "Copying Section"){
                    ?>
                    <li class="<?= isLinkActive('application/application_list/in') ?>">
                        <a href="<?=Config::get('host')?>/application/application_list/2/in"><i class="fa fa-desktop"></i> Receive Application</a>
                    </li>
                    <?php    
                    }
                    else if(Logins::getRoleName() == "Registrar General (RG)"){
                    ?>
                    <li class="<?= isLinkActive('application/application_list/1/in') ?>">
                        <a href="<?=Config::get('host')?>/application/application_list/1/in"><i class="fa fa-desktop"></i> Receive Application </a>
                    </li>
                    <?php
                    }
                    else if(Logins::getRoleName() == "Judicial 1" || Logins::getRoleName() == "Judicial 2" || Logins::getRoleName() == "Judicial 3"){
                    ?>
                    <li class="<?= isLinkActive('application/application_list/3/in') ?>">
                        <a href="<?=Config::get('host')?>/application/application_list/3/in"><i class="fa fa-desktop"></i> Receive Application </a>
                    </li>
                    <?php
                    }
                    ?>
                    
                    <!-- 
                    <li class="<?= isLinkActive('default/index') ?><?= isLinkActive('default') ?><?= isLinkActive('') ?>" >
                        <a href="<?=Config::get('host')?>/default/index">Home</a>
                    </li>
                    <li class="<?= isLinkActive('default/contact')?>" >
                        <a href="<?=Config::get('host')?>/default/contact">Contact</a>
                    </li>
                    <li class="<?= isLinkActive('default/about') ?>" >
                        <a href="<?=Config::get('host')?>/default/about">About</a>
                    </li>
                    -->
                </ul>
            </nav>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#sidebar").mCustomScrollbar({
                        theme: "minimal"
                    });
                    $('#sidebarCollapse').on('click', function () {
                        $('.sidebar').toggleClass('active');
                        $('#content').toggleClass('active');
                        
                        $('.collapse.in').toggleClass('in');
                        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                    });
                });
            </script>