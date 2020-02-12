<div><br/>
    <p>Submit an status to tell the applicant when to collect the certificate from the court.</p>
    <textarea name="application_status" id="application_status" class="form-control" required></textarea>
</div>
<div style="text-align: center">
    <button onclick="approve();" id="approve_btn" class="btn btn-success">Submit</button>
    <button onclick="reject()" id="reject_btn" class="btn btn-danger">Reject</button>
</div>
<div class="modal fade" id="rejectApplicationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="reject_application_form" action="#" method="POST">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title"><label for="reason">Give reason for rejecting an application</label></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div style="padding-left:10px;padding-right:10px">
                        <div class="row">
                            <textarea name="reason" id="reason" class="form-control" required></textarea>
                            <input type="hidden" name="application_id" value="<?= $application->application_id ?>" />        
                            <input type="hidden" name="tasks_id" value="<?= $tasks_id ?>" />        
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
<script type="text/javascript">
    var tasks_id = "<?= $tasks_id ?>";
    var application_id = "<?= $application->application_id ?>";
    
    function approve(){
        var application_status = document.getElementById("application_status");//$("#application_status").val();
        if(application_status.value.trim() === ""){            
            swal.fire({
                async: false,
                title: 'Say something',
                text: "Please say something in the status box.",
                type: 'error',
                showCancelButton: false,
                confirmButtonText: 'OK',
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                    window.setTimeout(function () { 
                        document.getElementById('application_status').focus(); 
                    }, 300);
                }
            });
            return;
        }
        else{
            swal.fire({
                title: '',
                text: "Are you sure to submit?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'YES',
                cancelButtonText: "No, I am not sure!"
            }).then((result) => {
                if (result.value) {
                    var setAppStatus = setApplicationStatus(application_id,document.getElementById("application_status").value);
                    if(setAppStatus.status==false){
                        swal.fire('Status update failed',setAppStatus.msg,'error');
                        return;
                    }
                    //This function "insertIntoApplicationTasksLog" is defined in applicationDetails.view.php
                    var resp = insertIntoApplicationTasksLog(application_id,tasks_id,"approve");
                    if(resp.status){
                        swal.fire('Success.',resp.msg,'success');
                        window.history.back();
                    }
                    else{
                        swal.fire('Failed.',resp.msg,'error');
                    }
                }
            });
        }
        
    }
    
    function reject(){
        swal.fire({
            title: 'Reject!',
            text: "Are you sure to reject?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: "No, I am not sure!"
        }).then((result) => {
            if (result.value) {
                $("#rejectApplicationModal").modal();
                
            }
        });
        
    }
    document.forms['reject_application_form'].onsubmit = function(event){
        event.preventDefault();
        var data = getFormDataAsJson(this);
        if(data.reason.trim() === ""){
            return;
        }
        var resp = insertIntoApplicationTasksLog(data.application_id,data.tasks_id,"reject",data.reason);
        if(resp.status){
            swal.fire('Rejected.',resp.msg,'success');
            window.history.back();
        }
        else{
            swal.fire('Failed to reject.',resp.msg,'error');
        }
    };
    
    function setApplicationStatus(application_id, status_description){
        var args = {
            url:"<?= Config::get('host') ?>/Status/submitStatus",
            param: JSON.stringify({"application_id": application_id,"description":status_description}),
            ContentType:"application/json",
            method: "POST"
        };
        return ajax_request(args);
    }
</script>
