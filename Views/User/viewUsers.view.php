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
    <p>
        <div style="float:left">List of users: </div>
        <div style="float:right">Total Users:
            <span class="background_circle"><?= count($users)-1 ?></span>
        </div>
    </p>
    <input type="hidden" value="<?= $login_id ?>" id="login_id" />
    <table class="table_style yellow_header table-scroll">
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
        <tbody id="users_content" class="tbody_max_height">
            <?php
                $cnt = 0;
                foreach ($users as $user){
            ?>
            <tr>
                <td style="max-width:60px"><?= ++$cnt ?></td>
                <td><?= $user->full_name ?></td>
                <td><?= $user->email ?></td>
                <td style="max-width:100px"><?= $user->phone_no ?></td>
                <td style="max-width:120px"><?= $user->aadhaar ?></td>
                <td><?= $user->role_name ?></td>
                <td style="max-width:70px" align="right">
                    <a href="editUser/<?= $user->user_id ?>">Edit</a>
                </td>
                <td style="max-width:70px" align="right">
                    <a href="javascript:removeUser('<?= $user->user_id ?>');">Remove</a>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <script>
        
        $(document).ready(function () {
            $(".table-scroll thead").mCustomScrollbar({
                theme: "minimal"
            });
//            $(".table-scroll tbody").mCustomScrollbar({
//                theme: "minimal"
//            });
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

        function getUsers(){
            var url = "<?= Config::get('host') ?>/User_api/";
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
            var layout="";
            for(var i=0; i<users.length; i++){
                var aadhaar = users[i].aadhaar==null?"":users[i].aadhaar;
                layout +=   "<tr>"+
                                "<td>"+(i+1)+"</td>"+
                                "<td>"+users[i].full_name+"</td>"+
                                "<td>"+users[i].email+"</td>"+
                                "<td>"+users[i].phone_no+"</td>"+
                                "<td>"+aadhaar+"</td>"+
                                "<td>"+users[i].role_name+"</td>"+
                                "<td align=\"right\"><a href=\"javascript: removeUser('"+users[i].user_id.trim()+"')\">Remove</a></td>"+
                            "</tr>";
            }
            if(layout == ""){
                layout = "<tr><td colspan='7' align='center'>No User Found!</td></tr>";
            }
            $("#"+layout_id).html(layout);
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