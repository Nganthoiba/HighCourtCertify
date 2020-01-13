<div class="container">
    <style>
        .roles_class{
            float: left;
            margin: 10px;
            width: 200px;
            height:20px;
            font-size: 10pt;
        }
    </style>
    <h4>Create Task
        <span class="alert alert-light" style="font-size:10pt;">
            A task is a specific activity that must be carried out in a process. So a task is a unit of a process. 
            A series or sequence of task makes a process. 
        </span>
    </h4>
    <div>
        <form name="create_task_form" method="POST">
            <?= writeCSRFToken() ?>
            <div class="row">
                <div class="col-sm-12">
                    <label for="tasks_name">Task Name:</label>
                    <input type="text" name="tasks_name" id="tasks_name" value="" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="tasks_description">Task Description:</label>
                    <textarea name="tasks_description" id="tasks_description" class="form-control"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label>Select which user roles will be granted access for this task:</label>
                </div>    
            </div>    
            <div class="row">
                <?php 
                //echo json_encode($data['roles']); 
                $response = $data['response'];
                if($response->status && sizeof($response->data)){
                    $roles = $response->data;
                    foreach ($roles as $role){
                ?>
                <div class="col-sm-4">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input class="custom-control-input" type="checkbox" id="role_<?= $role->role_id ?>" name="roles[]" value="<?= $role->role_id ?>" />
                        <label class="custom-control-label" style="cursor: pointer" for="role_<?= $role->role_id ?>">
                            <strong><?= $role->role_name ?></strong>
                        </label>
                    </div>
                </div>
                <?php

                    }
                }
                ?>
            </div>
            
            <div class="row">
                <div style="text-align: center;width: 100%">
                    <button class="btn btn-blue">Create</button>
                </div>
            </div>
            <div class="row">
                <div id="resp" style="text-align: center;width: 100%;display: none;">
                    <div class="spinner-border text-success"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var create_task_form = document.forms['create_task_form'];
    create_task_form.onsubmit = function(event){
        event.preventDefault();
        var data = getFormDataAsJson(create_task_form);
        //$("#resp").html(JSON.stringify(data));
        $("#resp").show();
        var resp = ajax_request({
            url: "<?= Config::get('host') ?>/Task/createTask",
            param: data,
            method:create_task_form.method
        });
        if(resp.status){
            swal.fire({
                title: 'Success',
                text: resp.msg,
                type: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    $("#resp").hide();
                    window.document.location.reload(true);
                }
            });
        }
        else{
            swal.fire({
                title: 'Error',
                text: resp.msg,
                type: 'error',
                confirmButtonText: 'OK'
            });
            $("#resp").hide();
        }
    };
</script>