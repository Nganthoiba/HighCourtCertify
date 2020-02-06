<?php
$response = $data['response'];
$user_info = $_SESSION['user_info'];
$login_id = $user_info['login_id'];
if($response->status_code == 200){
    $users = $response->data;
?>
    <style>
        .background_circle{
            padding: 5px;
            border-radius: 50%;
            background-color: #996000;
            color: #FFFFFF;
            font-size: 8pt;
        }
    </style>
    <link href="<?= Config::get('host') ?>/root/MDB/css/dataTable.css" rel="stylesheet" 
          type="text/css"/>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-2"><strong>Select user type:</strong></div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="users" id="all_users" value="all" checked />&nbsp;
                <label class="custom-control-label" style="cursor:pointer" for="all_users">All Users</label>&nbsp;
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="users" id="court_users" value="court_users" />&nbsp;
                <label class="custom-control-label" style="cursor:pointer" for="court_users">Court Users</label>&nbsp;
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="users" id="applicant_users" value="applicant_users" />&nbsp;
                <label class="custom-control-label" style="cursor:pointer" for="applicant_users">Applicants</label>&nbsp;
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <p>
            <div style="float:left">List of users: </div>
            <div style="float:right">Total Users:
                <span class="background_circle"><?= count($users) ?></span>
            </div>
        </p>
        <input type="hidden" value="<?= $login_id ?>" id="login_id" />
        
        <table id="user_list_table" class="table_style table_style-striped yellow_header">
            <thead>
                <tr>
                    <!--<th>User ID</th>-->
                    <th style="max-width:60px">Sl. No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="max-width:100px">Phone No</th>
                    <th style="max-width:120px">Aadhaar</th>
                    <th>User Role</th>
                    <th style="max-width:40px"></th>
                    <th style="max-width:70px"></th>
                </tr>
            </thead>
            <tbody id="users_content">
                <?php
                    $cnt = 0;
                    foreach ($users as $user){
                ?>
                <tr>
                    <td style="max-width:60px"><?= ++$cnt ?></td>
                    <td><?= $user->full_name ?></td>
                    <td><?= $user->email ?></td>
                    <td style="max-width:100px"><?= $user->phone_number ?></td>
                    <td style="max-width:120px"><?= $user->aadhaar ?></td>
                    <td><?= $user->role_name ?></td>
                    <td style="max-width:70px" align="right">
                        <?php if($user->role_name != "Applicant"){ ?>
                        <a href="editUser/<?= $user->user_id ?>">Edit</a>
                        <?php } ?>
                    </td>
                    <td style="max-width:70px" align="right">
                        <?php if($user->role_name != "Applicant"){ ?>
                        <a href="javascript:removeUser('<?= $user->user_id ?>');">Remove</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script src="<?=Config::get('host')?>/root/MDB/js/dataTable.js" type="text/javascript"></script>
    <script src="<?=Config::get('host')?>/root/MDB/js/dataTables.bootstrap4.js" type="text/javascript"></script>
    <script type="text/javascript">
        var user_list_table;
        
        $(document).ready(function () {
//            $(".table-scroll thead").mCustomScrollbar({
//                theme: "minimal"
//            });
//            $(".table-scroll tbody").mCustomScrollbar({
//                theme: "minimal"
//            });
            user_list_table = $('#user_list_table').DataTable({
                "language":{
                    "emptyTable":"No record available."
                },
                "destroy": true,
                "stateSave": true,
                "columnDefs": [
                    { "orderable": false, "targets": [6,7] },
                    { "searchable": false, "targets": [6,7] },
                    { "className": "align-center", "targets": [6,7] }
                ]
            });
            $("#applicant_users").on("click",function(){
                //user_list_table.search( "Applicant" ).draw();
                getUsers("applicants");
            });
            $("#court_users").on("click",function(){
                getUsers("court_users");
            });
            $("#all_users").on("click",function(){
                getUsers("all");
            });
            
        });

        function removeUser(user_id){ 
            Swal.fire({
                title: 'Are you sure to remove this user?',
                text: "Once done, you won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    confirmRemoveUser(user_id);
                }
            });
        }
        
        function confirmRemoveUser(user_id){
            var url = "<?= Config::get('host') ?>/User_api/removeUser/"+user_id;
            var login_id = $("#login_id").val();
            $.ajax({
                url: url,
                type: "DELETE",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer '+login_id);
                },
                success: function(resp){
                   swal.fire({
                        title: 'Success',
                        text: resp.msg,
                        type: 'success',
                        confirmButtonText: 'OK'
                    }).then(function(isConfirm){
                        if(isConfirm){
                            getUsers();
                        }
                    });
                },
                error: function (jqXHR, exception, errorThrown) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } 
                    else{
                        var resp = JSON.parse(jqXHR.responseText);
                        msg = resp.msg;
                    }
                    swal.fire({
                        title: 'Error',
                        text: msg,
                        type: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        function getUsers(user_type=""){
            var url = "<?= Config::get('host') ?>/User_api/index/"+user_type;
            $.ajax({
                url: url,
                type: "GET",
                success: function(resp){
                    displayUsers(resp.data,"users_content");//mCSB_3_container
                },
                error: function (jqXHR, exception, errorThrown) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } 
                    else{
                        var resp = JSON.parse(jqXHR.responseText);
                        msg = resp.msg;
                    }
                    swal.fire({
                        title: 'Error',
                        text: msg,
                        type: 'error',
                        confirmButtonText: 'OK'
                    });
                } 
            });
        }

        function displayUsers(users,layout_id){
            
            user_list_table.clear();
            user_list_table.destroy();
            
            var layout="";
            for(var i=0; i<users.length; i++){
                var aadhaar = users[i].aadhaar==null?"":users[i].aadhaar;
                layout +=   "<tr>"+
                                "<td>"+(i+1)+"</td>"+
                                "<td>"+users[i].full_name+"</td>"+
                                "<td>"+users[i].email+"</td>"+
                                "<td>"+users[i].phone_number+"</td>"+
                                "<td>"+aadhaar+"</td>"+
                                "<td>"+users[i].role_name+"</td>";
                if(parseInt(users[i].role_id) == 14){
                    //if the user is applicant, then admin will not able to delete or edit user information
                    layout +=   "<td></td><td></td>";
                }
                else{
                    layout +=   "<td align=\"right\"><a href=\"editUser/"+users[i].user_id.trim()+"\">Edit</a></td>"+
                                "<td align=\"right\"><a href=\"javascript: removeUser('"+users[i].user_id.trim()+"')\">Remove</a></td>";
                }       
                layout +=   "</tr>";
            }
            if(layout == ""){
                layout = "<tr><td colspan='7' align='center'>No User Found!</td></tr>";
            }
            $("#"+layout_id).html(layout);
            
            user_list_table = $('#user_list_table').DataTable({
                "language":{
                    "emptyTable":"No record available."
                },
                "destroy": true,
                "stateSave": true,
                "columnDefs": [
                    { "orderable": false, "targets": [6,7] },
                    { "searchable": false, "targets": [6,7] },
                    { "className": "align-center", "targets": [6,7] }
                ]
            });
            
            
//            $(".table-scroll tbody").mCustomScrollbar({
//                theme: "minimal"
//            });
        }
    </script>
<?php
}
 else {
     echo $response->msg;
     echo "<br/>".json_encode($response->error);
}
?>