<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title><?=Config::get('site_name')?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        
        <img link rel="shortcut icon" href="<?=Config::get('host')?>/root/MDB/img/court.png" alt=""/>
        <!--<link rel="shortcut icon" href="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/favicon.ico" />-->
        
        <link href="<?=Config::get('host')?>/root/MDB/css/font_awesome_4.7.0/css/all.css" 
              rel="stylesheet" type="text/css"/>
        
        <link href="<?=Config::get('host')?>/root/MDB/css/font_awesome_4.7.0/css/font-awesome.css" 
              rel="stylesheet" type="text/css"/>
        
        <!-- Bootstrap core CSS -->
        <link href="<?=Config::get('host')?>/root/MDB/css/bootstrap.css" rel="stylesheet">
        
        <!-- Material Design Bootstrap -->
        <link href="<?=Config::get('host')?>/root/MDB/css/mdb.css" rel="stylesheet">
        <link href="<?=Config::get('host')?>/root/MDB/css/style.css" rel="stylesheet">
        
        <link href="<?=Config::get('host')?>/root/MDB/css/datepicker.css" rel="stylesheet">
        
        <!-- JQuery -->
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/js/jquery.form.js"></script>
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/js/custom.js"></script>
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
        
        <!-- Tiny MCE -->
        <script src="<?=Config::get('host')?>/root/MDB/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
        <script src="<?=Config::get('host')?>/root/MDB/tinymce/tinymce.min.js" type="text/javascript"></script>
        
        <!-- Sweet Alert -->
        <link href="<?=Config::get('host')?>/root/MDB/sweetalert2/sweetalert2.css" rel="stylesheet" type="text/css"/>
        <script src="<?=Config::get('host')?>/root/MDB/sweetalert2/sweetalert2.js" type="text/javascript"></script>
        
        
        <link href="<?=Config::get('host')?>/root/MDB/malihu_custom_scrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css"/>
        <script src="<?=Config::get('host')?>/root/MDB/malihu_custom_scrollbar/jquery.mCustomScrollbar.js" type="text/javascript"></script>
        
        <!-- Scrollbar Custom CSS 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">-->
        <!-- jQuery Custom Scroller CDN 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>-->
    
    </head>
    <body>
        <?php 
            include_once('navigation_bar.view.php'); 
        ?>
        <div class="wrapper">
            <?php 
            if(Logins::isAuthenticated()){
                include_once ('side_navbar.view.php');
            }
            ?>
            <!-- Page Content  -->
            <div id="content" style="padding: 5px;margin-top: 70px">
                <?= $viewData->content ?>
            </div>
        </div>
        
        <?php //include_once('footer.view.php'); ?>
        <!-- SCRIPTS -->
        <script>
            $(document).ready(function () {
//                $("body").mCustomScrollbar({
//                    theme: "minimal"
//                });
            });

        </script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="<?=Config::get('host')?>/root/MDB/js/mdb.js"></script>
    </body>
</html>
