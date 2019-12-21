<div class="container-fluid">
    
    <div class="row">
        <div class="col-sm-4">
            <fieldset>
                <legend>Add new user role:</legend>
                <form name="add_role" method="POST">
                    <div>
                        <label>Enter Role Name</label>
                        <?= writeCSRFToken() ?>
                        <input type="text" class="form-control" name="role_name" required />
                    </div>
                    <div style="text-align: center">
                        <button class="btn btn-info" type="submit">Submit</button>
                    </div>
                    <div style="text-align: center">
                        <?= $data['addRoleResponse'] ?>
                    </div>
                </form>
            </fieldset>
        </div>
        <div class="col-sm-8">
            <label>List of roles:</label>
            <table border="0" class="table_style yellow_header table-scroll">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Role Name</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="tbody_max_height">
                    <?php
                    $roles = $data['roles'];
                    $i=1;
                    foreach ($roles as $role){
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $role->role_name ?></td>
                            <!--<td><a href="edit/<?= $role->role_id ?>">Edit</a></td>-->
                            <td align="right"><a href="remove/<?= $role->role_id ?>">Remove</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".table-scroll thead").mCustomScrollbar({
            theme: "minimal"
        });
        /*
        $(".table-scroll tbody").mCustomScrollbar({
            theme: "minimal"
        });
        */
    });
    
</script>
