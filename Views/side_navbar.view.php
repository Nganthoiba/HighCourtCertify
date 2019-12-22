        <link href="<?= Config::get('host')?>/root/MDB/css/side_navbar.css" rel="stylesheet" type="text/css"/>
            <!-- Sidebar  -->
            <nav id="sidebar" class="sidebar">
                
                <div class="sidebar-header">
                    <p style="color:#000">Welcome</p>
                </div>
                
                <ul class="list-unstyled components">
                    <?= writeSidebarMenus() ?>
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
<?php
function writeSidebarMenus(){
    $user_info = $_SESSION['user_info'];
    $role_id = $user_info['role_id'];
    $menuReader = new MenuReader();
    $menus = $menuReader->readMenu($role_id);
    return getMenuHtml($menus);
}

function getMenuHtml($menus=array()){
    $str="";
    foreach ($menus as $menu){
        if(sizeof($menu['child_menu'])){
            $str .=   "<li>"
                    . "<a href='#Submenu".$menu['menu_id']."' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle'>".$menu['menu_name']."</a>"
                    . "<ul class='collapse list-unstyled' id='Submenu".$menu['menu_id']."'>"
                    . getMenuHtml($menu['child_menu'])
                    . "</ul>"
                    . "</li>";
            
        }
        else{
            $str .= "<li class='".isLinkActive($menu['link'])."'><a href='".$menu['link']."'>".$menu['menu_name']."</a></li>";
        }
    }
    return $str;
}
?>