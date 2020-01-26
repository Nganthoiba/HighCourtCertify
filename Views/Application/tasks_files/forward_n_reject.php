<div style="text-align: center">
    <button onclick="forward();" id="forwrd_btn" class="btn btn-success">Forward</button>
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
    
    function forward(){
        swal.fire({
            title: 'Forward!',
            text: "Are you sure to forward?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: "No, I am not sure!"
        }).then((result) => {
            if (result.value) {
                var resp = insertIntoApplicationTasksLog(application_id,tasks_id,"forward");
                if(resp.status){
                    swal.fire('Forwarded.',resp.msg,'success');
                    window.history.back();
                }
                else{
                    swal.fire('Forward Failed.',resp.msg,'error');
                }
            }
        });
        
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
</script>
