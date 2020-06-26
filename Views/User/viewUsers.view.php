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
    <!--
    <link href="<?= Config::get('host') ?>/root/MDB/DataTable/css/jquery.dataTables.css" rel="stylesheet" 
          type="text/css"/>-->
    <link href="<?= Config::get('host') ?>/root/MDB/DataTable/css/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-2"><strong>Select user type:</strong></div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="users" id="all_users" value="all_users" onclick="resetDataTable(this.value);" checked />&nbsp;
                <label class="custom-control-label" style="cursor:pointer" for="all_users">All Users</label>&nbsp;
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="users" id="court_users" onclick="resetDataTable(this.value);" value="court_users" />&nbsp;
                <label class="custom-control-label" style="cursor:pointer" for="court_users">Court Users</label>&nbsp;
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="users" id="applicant_users" onclick="resetDataTable(this.value);" value="applicant_users" />&nbsp;
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
                    
                    <th style="max-width:40px">&nbsp;</th>
                    <th style="max-width:70px">&nbsp;</th>
                    
                </tr>
            </thead>
            <tbody id="users_content">
                
            </tbody>
        </table>
    </div>

    <script src="<?=Config::get('host')?>/root/MDB/DataTable/js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?=Config::get('host')?>/root/MDB/js/dataTables.bootstrap4.js" type="text/javascript"></script>
    
    <script type="text/javascript">
        var user_list_table;
        
        function getSelectedRadioButtonValue(radio_btn_name){
            var radio_elements = document.getElementsByName(radio_btn_name);
            for(var i=0; i<radio_elements.length; i++){
                if(radio_elements[i].checked){
                    return radio_elements[i].value;
                }
            }
            return "";
        }
        
        $(document).ready(function () {
//            $(".table-scroll thead").mCustomScrollbar({
//                theme: "minimal"
//            });
//            $(".table-scroll tbody").mCustomScrollbar({
//                theme: "minimal"
//            });

            
            user_list_table = $('#user_list_table').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [0,6,7] },
                    { "searchable": false, "targets": [0,6,7] },
                    { "className": "align-center", "targets": [0,6,7] }
                ]
            });
            resetDataTable("all_users");
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
                            var user_type = getSelectedRadioButtonValue("users");
                            resetDataTable(user_type);
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
        function displayLengthMenu(lengthMenu){
            var layout = "Showing <select class='custom-select custom-select-sm form-control form-control-sm'>";
            for(var i=0; i < lengthMenu.length; i++){
                layout += "<option value='"+lengthMenu[i]+"'>"+lengthMenu[i]+"</option>";
            }
            layout += "<option value='-1'>All</option>";
            layout += "</select> results";
            return layout;
        }
        function resetDataTable(user_type){
            var lengthMenu = [10,25,50,100];
            user_list_table.clear();
            user_list_table.destroy();
            user_list_table = $('#user_list_table').DataTable({
                
                "language":{
                    "emptyTable": "No record available."
                    ,"lengthMenu": displayLengthMenu(lengthMenu)
                },
                "destroy": true,
                "stateSave": false,
                "columnDefs": [
                    { "orderable": false, "targets": [0,6,7] },
                    { "searchable": false, "targets": [0,6,7] },
                    { "className": "align-center", "targets": [0,6,7] }
                ],
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':"<?= Config::get('host') ?>/User_api/getUsers/",
                    'data': {user_type: user_type}
                },
                'columns': [
                    { data: 'sl_no' },
                    { data: 'full_name' },
                    { data: 'email' },
                    { data: 'phone_number' },
                    { data: 'aadhaar' },
                    { data: 'role_name' },
                    { data: 'x' },
                    { data: 'y' }
                ]
            });
        }
    </script>
<?php
}
 else {
     echo $response->msg;
     echo "<br/>".json_encode($response->error);
}
?>