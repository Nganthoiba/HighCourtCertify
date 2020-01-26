<style>
    #sortable1, #sortable2 { 
        height:100%;
        width: 100%;
        list-style-type: none;
        margin: 0;
        padding: 5px 10px 5px 0;
        float: left;
        margin-right: 10px;
        border-radius: 5px;
    }
    #sortable1 li, #sortable2 li {
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1 rem;
        min-width: 250px;
        min-height: 50px;
        cursor:grab
    }
    .highlights{
        background-color: GREEN;
    }
    .dropbox {
        /*border: 1px solid #4c656f;*/
        width: 460px;
        height:60vh;
        overflow: hidden;
        overflow-y: scroll;
        margin: auto;
    }
    strong{
        font-size: 10pt;
    }
    h5{
        padding: 5px !important;
    }
</style>

<link href="<?=Config::get('host')?>/root/jquery_ui/jquery-ui.css" rel="stylesheet">
<div class="container">
    
        <form method="POST" name="process_task_mapping">
            <div class="row">
                <div class="col-sm-2" style="margin-top:10px">
                    <label class="control-label" for="process"><strong>Select Process:</strong></label>
                </div>
                <?php
                $processes = $data['processes'];
                ?>
                <div class="col-sm-6" style="margin-top:10px">
                    <select name="process" id="process" class="form-control small_font" onchange="optionprocessclick(this); " required>
                        <option value="-1">-- Select --</option>
                        <?php 
                            foreach ($processes as $process){
                                if($process->process_id == 8) 
                                    continue;
                        ?>
                            <option value="<?= $process->process_id ?>"><?= $process->process_name ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button id="process_tasks_map_btn" name="process_tasks_map_btn" class="btn btn-blue" onClick="fn_save(); return false;" disabled>SAVE</button>
                </div>
            
            </div>
            <div class="row">
                <div class="col-md-6"  style="margin:auto;margin-bottom: 15px">
                    <span id="msg"></span>  
                </div>
            </div>
        </form>
        
        <div class="row" id="mapping_layout" style="display:none">
            <div class="card"  style="margin-left:60px; margin-right:10px">
                <h5 class="card-header py-3">
                  <strong>TASKS NOT INCLUDED IN THE SELECTED PROCESS</strong>
                </h5>
                <!--Card content-->
                <div id="excluded_tasks" class="card-body dropbox" style="padding:0px !important">
                    <ul id="sortable1" class="connectedSortable"></ul>
                </div>

            </div>
            <div class="card"  style="margin-left:10px;">
                <h5 class="card-header py-3">
                  <strong>TASKS INCLUDED IN THE SELECTED PROCESS</strong>
                </h5>
                <!--Card content-->
                <div id="included_tasks" class="card-body dropbox" style="padding:0px !important">
                    <ul id="sortable2" class="connectedSortable"></ul>
                </div>
            </div>
        </div>
    
</div>
<script type="text/javascript" src="<?=Config::get('host')?>/root/jquery_ui/jquery-ui.js"></script>
<script type="text/javascript">
    function ajax_send(url,param){
          var result;
          $.ajax({
              async: false,
              url: url,
              type: "post",
              data: param,
              success: function(datalist){
                  result =  datalist;
              },
              error: function(jqXHR,f,g){
                  var msg="";
                  if (jqXHR.status === 0) {
                      msg = 'Not connect.\n Verify Network.';
                  } 
                  else{
                      var resp = JSON.parse(jqXHR.responseText);
                      msg = resp.msg;
                  }
                  result = {"status":false,"msg":msg};
              }
          });
          return result;
    }// end of function ajax_send(url,param)

    function display_sortable(sortableId,pid){
          
        $(sortableId+'1').html('');
        $(sortableId+'2').html('');
        //var resp = ajax_send('<?= Config::get('host') ?>/role/processRoleMapping',{action: 'getprocessrolemap', pid: pid});
        var resp = ajax_request({
            url: '<?= Config::get('host') ?>/Task/readProcessTasksMapping/'+pid
        });
        //console.log(JSON.stringify(resp));
         
        if(resp.status == 1){
            var included = resp.data.included;
            for(var i=0; i< included.length; i++){
                var item = included[i];
                //var x =  "<li class='ui-state-highlight' data-value='"+item.tasks_id+"' ><span>"+(i+1)+". </span>"+item.tasks_id+"-"+item.tasks_name+"</li>";
                var x = "<li class='ui-state-default' data-value='"+item.tasks_id+"' >"+
                        "<span>"+(i+1)+". </span>"+item.tasks_name+" (task_id="+item.tasks_id+")"+
                        "</li>";
                $(sortableId+'2').append(x);
            }
            var excluded = resp.data.excluded;
            for(var i=0; i< excluded.length; i++){
                var item = excluded[i];
                var x = "<li class='ui-state-default' data-value='"+item.tasks_id+"' >"+
                        "<span>"+(i+1)+". </span>"+item.tasks_name+" (task_id="+item.tasks_id+")"+
                        "</li>";
                $(sortableId+'1').append(x);
            }
            
        }
    }//end of display_sortable

    function optionprocessclick(obj){
        if(obj.value == "-1" || obj.value==""){
            $("#mapping_layout").hide();
            document.forms['process_task_mapping'].process_tasks_map_btn.disabled = true;
        }
        else{
            $("#mapping_layout").show();
            document.forms['process_task_mapping'].process_tasks_map_btn.disabled = false;
        }
        
        display_sortable('#sortable',obj.value);

        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable",
            start: function(event, ui) {
            },
            change: function(event, ui) {

            },
            update: function(event, ui) {
                
                $('#sortable1 span').each(function(i)
                {
                   $(this).html((i+1)+'. '); // This is your rel value
                });
                $('#sortable2 span').each(function(i)
                {
                   $(this).html((i+1)+'. '); // This is your rel value
                });
                    //$('#sortable1 li').removeClass('highlights');
            }
        }).disableSelection();

    }// end of optionprocessclick(obj)

    function fn_save(){
	//console.log('---------------- Excluded values ---------------------');
	if($("#process").val() == "" || $("#process").val() == "-1"){
            //swal.fire({title:"Validation", text: "Please select process."});
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a process'
            });
            return;
        }
	var excluded = [];
	var included = [];
	$('#sortable1 li').each(function(i)
	{
            // console.log( $(this).html()+ ' value = ' + $(this).attr('data-value') ); // This is your rel value
            excluded.push($(this).attr('data-value'));
	});
	//console.log('---------------- Included values ---------------------');
	$('#sortable2 li').each(function(i)
	{
            // console.log( $(this).html()+ ' value = ' + $(this).attr('data-value') ); // This is your rel value
            var tasks_id = $(this).attr('data-value');	   
            //var input = $('input[name=descrip_'+role_id+']');
	    included.push(tasks_id);
	   
	}); 
	var resp = ajax_request({
            url: '<?= Config::get('host') ?>/Task/saveProcessTasksMapping',
            param: {included: included, excluded: excluded, pid: $('#process').val()},
            method: "POST"
        });
	
        if(resp.status){
            $('#sortable1 li').each(function(i)
            {
               $(this).attr("class","ui-state-default"); // This is your rel value
            });
            $('#sortable2 li').each(function(i)
            {
               //$(this).attr("class","ui-state-highlight"); // This is your rel value
               $(this).attr("class","ui-state-default"); // This is your rel value
            });
            swal.fire({
                title: 'Success',
                text: resp.msg,
                type: 'success',
                confirmButtonText: 'OK'
            });
        }
        else{
            swal.fire({
                title: 'Failed',
                text: resp.msg,
                type: 'error',
                confirmButtonText: 'OK'
            });
        }
        /*Swal.fire({
            title: resp.msg,
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        });*/
        
    }// end of function fn_save()
  
</script>


