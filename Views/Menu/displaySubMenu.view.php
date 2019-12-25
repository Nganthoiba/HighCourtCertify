<link href="<?=Config::get('host')?>/root/jquery_ui/jquery-ui.css" rel="stylesheet">
    <link href="<?=Config::get('host')?>/root/jquery_ui/sortable_table/ui_sortable_table.css" rel="stylesheet" type="text/css"/>
<div class="container-fluid">
<?php 
$response = $data['response'];
$parent_menu = $data['parent_menu'];
?>
    <span>
        <?php 
        if($parent_menu!=null)
        { 
        ?>
        <button type="button" onclick="setFormAction('create');" class="btn btn-blue" data-toggle="modal" 
                data-target="#subMenuModal">Add Sub Menu</button>
        <span style='font-style:italics; font-weight: bold; font-size:14pt'>Parent Menu Name: </span> <span><?= $parent_menu->menu_name ?></span>
        
        <?php
        }
        ?>
    </span>
    <div class="alert alert-light">
        You can drag and drop any row of this menu table to rearrange the sequence for 
        displaying menu.Then click <a href="javascript:saveMenuSequence();">Save</a> to save the sequence.
    </div>
    <!-- The Add Sub Menu Modal -->
    <div class="modal fade" id="subMenuModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="sub_menu_form" action="#" class="needs-validation" novalidate>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="model_title">Add Sub Menu</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div style="padding-left:10px;padding-right:10px">
                            <input type="hidden" value="<?= $data['parent_menu_id'] ?>" name="parent_menu_id" id="parent_menu_id" />
                            <input type="hidden" value="" id="menu_id" name="menu_id" />
                            <input type="hidden" value="" id="action_name" name="action_name" />
                            <!-- action_name specifies whether to create new sub menu or update existing sub menu -->
                            <div class="row">
                                <label for="menu_name">Menu Name</label>
                                <input type="text" name="menu_name" id="menu_name" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Menu Name can not be left blank.</div>
                            </div>
                            <div class="row">
                                <label for="link">Link</label>
                                <input type="text" name="link" id="link" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Link can not be left blank.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END OF Add Menu Modal -->
    
    <table class="row_sortable_table table_style yellow_header">
        
        <thead>
            <tr>
                <th>Sl. No.</th>
                <th>Sub Menu Name</th>
                <th>Link</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody id="menu_data" class="connectedSortable">
            <?php 
            if($response->status){
                $sub_menus = $response->data;
                $i=0;
                foreach ($sub_menus as $menu){
                    echo "<tr data-value='".$menu->menu_id."'>"
                    . "<td><span>".(++$i)."</span></td>"
                    . "<td>".$menu->menu_name."</td>"
                    . "<td>".$menu->link."</td>"
                    . "<td><a href='javascript:void(0);' onclick='setMenuData(".json_encode($menu).");' data-toggle='modal' data-target='#subMenuModal' >Edit</a></td>"
                    . "<td><a href='javascript:removeMenu(\"".$menu->menu_id."\")'>Remove</a></td>"
                    . "<td><a href='".Config::get('host')."/Menu/displaySubMenu/".$menu->menu_id."'>Sub Menus</a></td>"
                    . "</tr>";
                }
            }
            else{
                echo "<tr>"
                . "<td colspan='5' align='center'>".$response->msg."</td>"
                . "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="javascript: window.history.back();">Back to parent menu</a>
    <script type="text/javascript" src="<?=Config::get('host')?>/root/jquery_ui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?=Config::get('host')?>/root/jquery_ui/sortable_table/ui_sortable_table.js"></script>
    <script type="text/javascript">
        var sub_menu_form = document.forms['sub_menu_form'];
        
        function setFormAction(actionValue){
            sub_menu_form.action_name.value=actionValue;
        }
        
        function setMenuData(menu){
            setFormAction('update');
            sub_menu_form.menu_id.value = menu.menu_id;
            sub_menu_form.menu_name.value = menu.menu_name;
            sub_menu_form.link.value = menu.link;
        }
        sub_menu_form.onsubmit = function(event){
            event.preventDefault();
            //Validating form
            if(sub_menu_form.menu_name.value.trim() === "" || sub_menu_form.link.value.trim() === "")
            {
                return false;
            }
            var url="";
            var menu = {
                parent_menu_id : sub_menu_form.parent_menu_id.value,
                menu_id : sub_menu_form.menu_id.value,
                menu_name : sub_menu_form.menu_name.value,
                link : sub_menu_form.link.value
            };
            if(sub_menu_form.action_name.value.trim() == "create"){
                url = "<?= Config::get('host') ?>/Menu/createMenu";
            }
            else{
                url = "<?= Config::get('host') ?>/Menu/updateMenu";
            }
            createOrUpdateSubMenu(menu,url);
        };
        function createOrUpdateSubMenu(menu,url){
            $.ajax({
                url: url,
                data: menu,
                type: "POST",
                success: function(resp){
                    swal.fire({
                        title: 'Success',
                        text: resp.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){
                        getSubMenu();
                    });
                },
                error: function (jqXHR, exception, errorThrown) {
                    result = {};
                    if (jqXHR.status === 0) {
                        result['msg'] = 'Not connect.\n Verify Network.';
                        result['status'] = jqXHR.status;
                    } 
                    else{
                        result = JSON.parse(jqXHR.responseText);
                    }
                    swal.fire({
                        title: 'Error',
                        text: result.msg,
                        type: 'error',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){

                    });
                }
            });
        }
        function getSubMenu(){
            var layout = "<tr><td colspan='5' align='center'>Wait please ...</td></tr>";
            $("#menu_data").html(layout);
            var resp = ajax_request({
                url: "<?= Config::get('host') ?>/Menu/getSubMenu/<?= $data['parent_menu_id'] ?>"
            });
            if(resp.status){
                var menu_data = resp.data;
                displayMenu(menu_data);
                setSortable();//set the menu table sortable
            }
            else{
                layout = "<tr><td colspan='5' align='center'>"+resp.msg+"</td></tr>";
                $("#menu_data").html(layout);
            }
        }
        function displayMenu(menus){
            var layout = "";
            for(var i=0;i<menus.length; i++){
                var menu = menus[i];
                layout += "<tr data-value='"+menu.menu_id+"'>"+
                    "<td><span>"+(i+1)+"</span></td>"+    
                    "<td>"+menu.menu_name+"</td>"+    
                    "<td>"+menu.link+"</td>"+    
                    "<td><a href='javascript:void(0)' onclick='setMenuData("+JSON.stringify(menu)+");' data-toggle='modal' data-target='#subMenuModal'>Edit</a></td>"+    
                    "<td><a href='javascript:removeMenu(\""+menu.menu_id+"\");'>Remove</a></td>"+    
                    "<td><a href='<?= Config::get('host') ?>/Menu/displaySubMenu/"+menu.menu_id+"'>Sub Menus</a></td>"+    
                "</tr>";
            }
            if(layout == ""){
                layout = "<tr><td colspan='5' align='center'>No record found</td></tr>";
            }
            $("#menu_data").html(layout);
        }
        function removeMenu(menu_id){ 
            Swal.fire({
                title: 'Are you sure to remove this menu?',
                text: "Once done, you won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    confirmRemoveMenu(menu_id);
                }
            });
        }
        
        function confirmRemoveMenu(menu_id){
            //alert(menu_id);
            var url = "<?= Config::get('host') ?>/Menu/removeMenu/"+menu_id;
            $.ajax({
               url: url,
               success: function(resp){
                    swal.fire({
                        title: 'Success',
                        text: resp.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){
                        getSubMenu();//refreshing menu
                    });
               },
               error: function (jqXHR, exception, errorThrown) {
                    result = {};
                    if (jqXHR.status === 0) {
                        result['msg'] = 'Not connect.\n Verify Network.';
                        result['status'] = jqXHR.status;
                    } 
                    else{
                        result = JSON.parse(jqXHR.responseText);
                    }
                    swal.fire({
                        title: 'Error',
                        text: result.msg,
                        type: 'error',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){

                    });
                }
            });
        }
        //function to save sequence/order of displaying menu
        function saveMenuSequence(){
            var menuSequence = [];//array for storing menu id and its sequence in json format
            $('.row_sortable_table tbody tr').each(function(i)
            {
                var menu_id = $(this).attr('data-value');
                var sequence = (i+1);
                menuSequence.push( {menu_id:menu_id, sequence: sequence } );
            });
            //console.log(JSON.stringify(menuSequence));
            var result = ajax_request({
                url: "<?= Config::get('host') ?>/Menu/saveMenuSequence",
                param: JSON.stringify(menuSequence),
                method: "PUT",
                ContentType: "application/json"
            });
            if(result.status){
                swal.fire({
                    title: 'Success',
                    text: result.msg,
                    type: 'success',
                    confirmButtonText: 'OK'
                }).then(function(isConfirm){
                    getSubMenu();//refreshing sub menu
                });
            }
            else{
                swal.fire({
                    title: 'Error',
                    text: result.msg,
                    type: 'error',
                    confirmButtonText: 'OK'
                }).then(function(isConfirm){

                });
            }
            
        }
    </script>
</div>
