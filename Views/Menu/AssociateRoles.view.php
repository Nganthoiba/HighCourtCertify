<div class="container">
    <?php 
    $all_roles = $data['all_roles'];
    //$associated_roles = $data['associated_roles'];
    $menu = $data['menu'];
    if($menu!=null)
    {
        if(sizeof($all_roles))
        {
            
    ?>
    <div class="col-sm-10" style="margin:auto">
        <h2>Associate Roles with Menu</h2>
        <form name="associate_role_with_menu" id="associate_role_with_menu" action="<?=Config::get('host') ?>/Menu/AssociateRoles">
            <div class="row">
                <h5>Check the roles which you want to associate with the Menu '<b><?= $menu->menu_name ?></b>'</h5>
                <input type="hidden" name="menu_id" value="<?= $menu->menu_id ?>" />
            </div>
            <?php
            foreach($all_roles as $role){
            ?>
            <div class="row">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" 
                           class="custom-control-input" 
                           name="associated_roles[]" 
                           id="role_<?= $role->role_id ?>" 
                           value="<?= $role->role_id ?>" 
                           <?php 
                           if($role->isRoleAccociatedWithMenu == true){
                               echo "checked";
                           }
                           ?>
                           />
                    <label class="custom-control-label" for="role_<?= $role->role_id ?>" 
                                   style="font-size: 10pt;font-style:oblique;color: #005cbf;cursor: pointer ">
                        <?= $role->role_name ?>
                    </label>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="row">
                <div style="text-align:center">
                    <button type="submit" class="btn btn-blue">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <?php 
        }
    }else
    { 
        echo "<div class='alert alert-warning' style='text-align:center'>Menu not found!</div>";
    }
    ?>
</div>
<script type="text/javascript">
    var associate_role_with_menu = document.forms['associate_role_with_menu'];
    associate_role_with_menu.onsubmit = function(event){
        event.preventDefault();
        //var json_data = getFormDataToJson(associate_role_with_menu);
        //if(json_data.associated_roles.length == 0){
            //json_data.associated_roles = null;
        //}
        
        var resp = ajax_request({
            url: associate_role_with_menu.action,
            method: "POST",
            param: $("#associate_role_with_menu").serialize()
        });
        
        if(resp.status){
            swal.fire({
                title: 'Success',
                text: resp.msg,
                type: 'success',
                confirmButtonText: 'OK'
            }).then(function(isConfirm){
                document.reload();
            });
        }
        else{
            swal.fire({
                title: 'Error',
                text: resp.msg,
                type: 'error',
                confirmButtonText: 'OK'
            }).then(function(isConfirm){

            });
        }
    }
</script>
