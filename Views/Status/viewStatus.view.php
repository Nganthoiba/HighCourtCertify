<?php
$response = $data['response'];
if($response->status==false){
    echo $response->msg;
}
else{
    $stepsOfProcess = $response->data['stepsOfProcess'];
    $application_id = $response->data['application_id'];
    $log_hist = $response->data['application_log_hist'];
?>
<style type="text/css">
    .vcircle {
        border-radius: 50%;
        height: 40px;
        width:40px;
        float:left;
        border: 1px solid #f7f7f7;
        padding-top:8px;
        text-align:center; color: #FFFFFF;
        background-color:#BFCAC0;
    }
    .active{
        background-color:#66C670  !important;
    }
    .rejected{
        background-color:#D81F6F !important;
    }

    .line-active {
        background-color:#66C670 !important;
    }

    .vl {
        min-width:2px;
        min-height:40px;
        max-width:3px;
        max-height:40px;
        background-color:#BFCAC0; 
        float: left;
        margin: 0px 20px !important;
        padding: 0px !important;
    }

</style>

<div class="container">
    <h5>Current status for application ID <strong><?= $application_id ?></strong></h5>
    <div id="step_tracker"></div>
</div>
<script type="text/javascript">    
    function draw_vertical_steps(total_steps, active_step, layout_id,steps_description){
        layout="";
        if(total_steps!==0)
        {
            layout="<table cellspacing='0' cellpadding='0' border='0' style='margin-top:20px'>"; 

            var i;
            for(i=1; i<=total_steps; i++){
                if(i<=active_step)
                {
                    layout+=" <tr><td ><span class='vcircle active'>"+i+"</span></td><td style='font-size:9pt;padding-left:10px'>"+
                    steps_description[i-1]+"</td></tr>";
                }
                else{
                    layout+="<tr><td ><span class='vcircle '>"+i+"</span></td><td style='font-size:9pt;padding-left:10px'>"+
                    steps_description[i-1]+" (<i>Pending...</i>)</td></tr>";
                }
                if(i<active_step){
                    layout += "<tr><td><span class='vl line-active'></span></td><td></td></tr>";
                }
                else if(i<total_steps){
                    layout += "<tr><td><span class='vl '></span></td><td></td></tr>";
                }
            }
            layout +="</table>";

        }
        document.getElementById(layout_id).innerHTML = layout;
    }

    function view_status(){
        var stepsOfProcess = <?= json_encode($stepsOfProcess) ?>;
        var log_hist = <?= json_encode($log_hist) ?>;
        var total_steps = 0;
        var completed_steps = 0;
        var steps_desc = [];
        if(stepsOfProcess.length!==0 && log_hist.length!==0){
            total_steps = stepsOfProcess.length;
            completed_steps = log_hist.length;
        }
        var i=0;
        for(;i<completed_steps; i++){
            var action_date = new Date(log_hist[i].action_date);
            steps_desc[i] = "<strong>"+stepsOfProcess[i].tasks_description+"</strong>"+
            "<br/>by <b>"+log_hist[i].action_user_full_name+"</b> on "+action_date.toDateString();
        }
        for(;i<total_steps;i++){
            steps_desc[i] = stepsOfProcess[i].tasks_description;
        }
        draw_vertical_steps(total_steps,completed_steps,"step_tracker",steps_desc);
    }
    
    view_status();
</script>
<?php 
}
?>