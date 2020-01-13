<div class="container">
    <?php 
    $response_tasks = $data['response_tasks'];
    $response_roles = $data['response_roles'];
    ?>
    <link href="<?= Config::get('host') ?>/root/MDB/css/dataTable.css" rel="stylesheet" 
          type="text/css"/>
    <div>List of tasks created:</div>
    <table class="table_style yellow_header" id="task_list_table">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <!--<th>Created At</th>-->
                <th>Action</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tasks_list">
        <?php 
        if($response_tasks->status){
            $tasks = $response_tasks->data;
            foreach ($tasks as $task){
                $create_at_timestamp = strtotime($task->create_at);
                echo "<tr>"
                    . "<td>".$task->tasks_name."</td>"
                    . "<td>".$task->tasks_description."</td>"
                    //. "<td>".date('d/m/Y, h:i:s a',$create_at_timestamp)."</td>"
                    . "<td><a href='javascript:void(0);' onclick='editTask(".json_encode($task).");' data-toggle='modal' data-target='#editTaskModal'>View & Edit</a></td>"
                    . "<td><a href='javascript:void(0);' onclick='removeTask(\"".$task->tasks_id."\")'>Remove</a></td>"
                    . "</tr>";
            }
        }
        else
        {
        ?>
            <tr>
                <td colspan="5"><?= $response_tasks->msg ?></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>   
</div>
<script src="<?=Config::get('host')?>/root/MDB/js/dataTable.js" type="text/javascript"></script>
<script src="<?=Config::get('host')?>/root/MDB/js/dataTables.bootstrap4.js" type="text/javascript"></script>
<div class="modal fade" id="editTaskModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form name="edit_task_form" action="#" method="POST">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Edit Task</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div style="padding-left:10px;padding-right:10px">
                        <div class="row">
                            <?= writeCSRFToken() ?>
                            <label for="tasks_name">Task Name</label>
                            <input type="text" name="tasks_name" id="tasks_name" 
                                   class="form-control" required/>
                            <input type="hidden" name="tasks_id" id="tasks_id" 
                                   class="form-control" required/>
                        </div>
                        <div class="row">
                            <label for="tasks_description">Task Description:</label>
                            <textarea type="text" name="tasks_description" id="tasks_description" 
                                      class="form-control"></textarea>
                        </div>
                        <div>
                            <div class="row">
                                <label>You can grant access or remove access by checking or unchecking those options given below:</label>
                            </div>
                            <div class="row">
                            <?php 
                            if($response_roles->status){
                                $roles = $response_roles->data;
                                foreach ($roles as $role){
                            ?>
                                <div class="col-sm-4">
                                    <div class="custom-control custom-checkbox custom-control-inline" >
                                        <input class="custom-control-input" type="checkbox" name="roles[]" value="<?= $role->role_id ?>" id="role_<?= $role->role_id ?>"/>
                                        <label class="custom-control-label" for="role_<?= $role->role_id ?>" style="cursor:pointer">
                                            <strong><?= $role->role_name ?></strong>
                                        </label>
                                    </div>
                                </div>
                            <?php
                                }
                            }
                            else{
                                echo $response_roles->msg;
                            }
                            ?>
                            </div>
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
 <script type="text/javascript">
    $(document).ready(function(){
        $('#task_list_table').DataTable({
            "language":{
                "emptyTable":"No record available."
            },
            "columnDefs": [
                { "orderable": false, "targets": [2,3] },
                { "searchable": false, "targets": [2,3] },
                { "className": "align-center", "targets": [2,3] }
            ]
        });
    });
    
    var edit_task_form = document.forms['edit_task_form'];
    function editTask(task){
        edit_task_form.tasks_name.value = task.tasks_name;
        edit_task_form.tasks_id.value = task.tasks_id;
        edit_task_form.tasks_description.value = task.tasks_description;
        var mapped_roles = task.mapped_roles;  
        var form_elements = edit_task_form.elements;
        var curr_element;
        var curr_key = "";
        var curr_value = "";
        for(var i=0; i<form_elements.length; i++){
            curr_element = form_elements[i];
            curr_key = curr_element.name;
            curr_value = parseInt(curr_element.value);
            if(curr_key === "roles[]"){
                //curr_element.checked = true;
                if(mapped_roles.includes(curr_value)){
                    curr_element.checked = true;
                }
                else{
                    curr_element.checked = false;
                }
            }
        }
        
    }
    
    edit_task_form.onsubmit = function(event){
        event.preventDefault();
        var data = getFormDataAsJson(edit_task_form);
        
        var resp = ajax_request({
            url: "<?= Config::get('host') ?>/Task/updateTask",
            method: edit_task_form.method,
            param: (data)
        });
        if(resp.status){
            swal.fire({
                title: 'Success',
                text: resp.msg,
                type: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    //window.document.location.reload(true);
                    $('#editTaskModal').modal('hide');
                    getTasks();
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
        }
        
    };
    
    function getTasks(){
        var result = ajax_request({
            url: "<?= Config::get('host') ?>/Task/getTasks"
        });
        //displaying
        var layout = "";
        if(result.status){
            var tasks = result.data;
            for(var i=0;i<tasks.length;i++){
                //var readable_date = displayDate(tasks[i].create_at);
                layout +="<tr>"+
                            "<td>"+tasks[i].tasks_name+"</td>"+
                            "<td>"+tasks[i].tasks_description+"</td>"+
                            //"<td>"+readable_date+"</td>"+
                            "<td><a href='javascript:void(0);' onclick='editTask("+JSON.stringify(tasks[i])+")' data-toggle='modal' data-target='#editTaskModal'>View & Edit</a></td>"+
                            "<td><a href='javascript:void(0);' onclick='removeTask(\""+tasks[i].tasks_id+"\")'>Remove</a></td>"+
                        "</tr>";
            }
        }
        else{
            layout = "<tr><td colspan='5'>"+result.msg+"</td></tr>";
        }
        $("#tasks_list").html(layout);
    }
    
    function displayDate(dateTime){
        var d = new Date(dateTime);
        var date = d.getDate();
        var month = d.getMonth();
        var year = d.getFullYear();
        
        var hours = d.getHours();
        var mins = d.getMinutes();
        var secs = d.getSeconds();
        
        var a = hours<=12?"am":"pm";
        var display_hr = (hours>12)?hours-12:hours;
        display_hr = (display_hr<10)?"0"+display_hr:display_hr;
        mins = (mins<10)?"0"+mins:mins;
        secs = (secs<10)?"0"+secs:secs;
        return date+"/"+month+"/"+year+", "+display_hr+":"+mins+":"+secs+" "+a;
    }
    
    function removeTask(tasks_id){ 
        Swal.fire({
            title: 'Are you sure to remove this task?',
            text: "Once done, you won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                //confirmRemoveTask(task_id);
                var result = ajax_request({
                    url: "<?= Config::get('host') ?>/Task/removeTask/"+tasks_id,
                    param: "csrf_token=<?= getCSRFToken() ?>"
                });
                if(result.status){
                    swal.fire({
                        title: 'Success',
                        text: result.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            //window.document.location.reload(true);
                            getTasks();
                        }
                    });
                }
                else{
                    swal.fire({
                        title: 'Failed',
                        text: result.msg,
                        type: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            }
        });
    }
</script>