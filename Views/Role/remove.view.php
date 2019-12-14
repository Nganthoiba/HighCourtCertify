<?php 
    if($data['role'] != null){
        $role = $data['role'];
?>
<div class="col-6" style="margin: auto; text-align: center">
    <h3>Are you sure to remove role <strong><?= $role->role_name ?> </strong>?</h3>
    <form action="<?= Config::get('host') ?>/role/confirmRemove" method="post">
        <input type="hidden" name="role_id" value="<?= $role->role_id ?>" />
        <button type="submit" class="btn btn-danger">Confirm</button>
        <a href="<?= Config::get('host') ?>/role/addRoles" class="btn btn-success">Cancel</a>
    </form>
</div>        
<?php            
    }
?>
<div class="col-6" style="margin: auto;text-align: center">
    <div><?= $data['msg'] ?></div>
    <div><a href="<?= Config::get('host') ?>/role/addRoles">Back to Add Roles</a></div>
</div>

