        <link href="<?= Config::get('host')?>/root/MDB/css/side_navbar.css" rel="stylesheet" type="text/css"/>
            <!-- Sidebar  -->
            <nav id="sidebar" class="sidebar">
                <div class="sidebar-header">
                    <h2>Sidebar</h2>
                </div>
                <ul class="list-unstyled">
                    <li>
                        <div class="text-center">
                            <img class="rounded-circle" 
                                 src="<?= Config::get('host')?>/root/MDB/img/avatars/9.jpg" alt=""/>                            
                        </div>
                        <div style="color:#000000;padding: 5px;">
                            Welcome, <br/>
                            <span style="color: #49a75f; font-weight: bold"><?= $user_info['full_name'] ?></span><br/>
                            <span style="color: #491217; font-weight: bold; font-size: 10pt">
                                (<?= Logins::getRoleName() ?>)
                            </span>
                            <hr/>
                        </div>
                        
                    </li>
                </ul>
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
    $str = "";
    foreach ($menus as $menu){
        if(sizeof($menu['child_menu'])){
            $str .=   "<li class='".isChildMenuActive($menu['child_menu'])."'>"
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

//This function checks whether any of the link of the child menus is active or not, if found active
//then it returns string 'active' otherwise empty string
function isChildMenuActive($childMenus = array()){
    $status = "";
    foreach ($childMenus as $menu){
        if(sizeof($menu['child_menu'])){
            $status = isMenuActive($menu['child_menu']);
        }
        else if(isLinkActive($menu['link']) === "active"){
            return "active";
            
        }
    }
    return $status;
}

?>