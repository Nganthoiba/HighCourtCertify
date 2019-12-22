<div class="container-fluid">
    <div>
        <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#addMenuModal">Add Menu</button>
    </div>
    

    <!-- The Add Menu Modal -->
    <div class="modal fade" id="addMenuModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="add_menu_form" action="createMenu" class="needs-validation" novalidate>
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Add Menu</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div style="padding-left:10px;padding-right:10px">
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
    
    <!-- The Edit Menu Modal -->
    <div class="modal fade" id="editMenuModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="edit_menu_form" action="updateMenu" class="needs-validation" novalidate>
                    <!-- Modal Header -->
                    
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Menu</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div style="padding-left:10px;padding-right:10px">
                            <input type="hidden" name="menu_id" id="menu_id" value="" />
                            <div class="row">
                                <label for="new_menu_name">Menu Name</label>
                                <input type="text" name="menu_name" id="new_menu_name" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Menu Name can not be left blank.</div>
                            </div>
                            <div class="row">
                                <label for="new_link">Link</label>
                                <input type="text" name="link" id="new_link" class="form-control" required/>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Link can not be left blank.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END OF EDIT MENU MODAL -->
    
    <!-- MENU DISPLAY TABLE -->
    <table class="table_style yellow_header">
        <thead>
            <tr>
                <th>Menu Name</th>
                <th>Link</th>
                <th colspan="4">Actions</th>
            </tr>
        </thead>
        <tbody id="menu_data">
            
        </tbody>
    </table>
    
    <script type="text/javascript">
        getMenu();
        var add_menu_form = document.forms["add_menu_form"];
        var edit_menu_form = document.forms["edit_menu_form"];
        
        //Add new menu
        add_menu_form.onsubmit = function(event){
            event.preventDefault();
            //validation
            if(add_menu_form.menu_name.value.trim() === "" || add_menu_form.link.value.trim() === ""){
                return false;
            }
            $.ajax({
                url: add_menu_form.action,
                data: getFormDataToJson(add_menu_form),
                type: "POST",
                success: function(resp){
                    swal.fire({
                        title: 'Success',
                        text: resp.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){
                        //window.location.reload();
                        add_menu_form.reset();
                        getMenu();
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
            
        };
        //edit menu
        edit_menu_form.onsubmit = function(event){
            event.preventDefault();
            //validation
            if(edit_menu_form.menu_name.value.trim() === "" || edit_menu_form.link.value.trim() === ""){
                return false;
            }
            $.ajax({
                url: edit_menu_form.action,
                data: getFormDataToJson(edit_menu_form),
                type: "POST",
                success: function(resp){
                    swal.fire({
                        title: 'Success',
                        text: resp.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){
                        //window.location.reload();
                        edit_menu_form.reset();
                        getMenu();
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
            
        };
        
        function getMenu(){
            var layout = "<tr><td colspan='5' align='center'>Wait please ...</td></tr>";
            $("#menu_data").html(layout);
            var resp = ajax_request({
                url: "<?= Config::get('host') ?>/Menu/getMenu"
            });
            if(resp.status){
                var menu_data = resp.data;
                displayMenu(menu_data);
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
                layout += "<tr>"+
                    "<td>"+menu.menu_name+"</td>"+    
                    "<td>"+menu.link+"</td>"+    
                    "<td><a href='<?= Config::get('host') ?>/Menu/AssociateRoles/"+menu.menu_id+"'>Associate User Roles</a></td>"+    
                    "<td><a href='javascript:void(0)' onclick='setMenuData("+JSON.stringify(menu)+");' data-toggle='modal' data-target='#editMenuModal'>Edit</a></td>"+    
                    "<td><a href='javascript:removeMenu(\""+menu.menu_id+"\");'>Remove</a></td>"+    
                    "<td><a href='<?= Config::get('host') ?>/Menu/displaySubMenu/"+menu.menu_id+"'>Sub Menus</a></td>"+    
                "</tr>";
            }
            if(layout == ""){
                layout = "<tr><td colspan='6' align='center'>No record found</td></tr>";
            }
            $("#menu_data").html(layout);
        }
        
        function setMenuData(menu){
            var edit_menu_form = document.forms['edit_menu_form'];
            edit_menu_form.menu_id.value = menu.menu_id;
            edit_menu_form.menu_name.value = menu.menu_name;
            edit_menu_form.link.value = menu.link;
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
                        getMenu();//refreshing menu
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
    </script>
</div>
