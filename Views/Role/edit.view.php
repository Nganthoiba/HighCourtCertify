<?php
if(isset($data['role'])){
    $role = $data['role'];
?>
<form method="POST">
    <div class="col-sm-4">
        <label>Role Name</label>
        <input type="text" name="role_name" class="form-control" value="<?= $role->role_name ?>" />
        <input type="hidden" name="roles_id" value="<?= $role->roles_id ?>" />
        <button class="btn btn-cyan">Update</button>
        <div><?= $data['msg'] ?></div>
    </div>
</form>
<?php
}
else
{
    echo "<div class='alert alert-warning'>".$data['msg']."</div>";
}
?>