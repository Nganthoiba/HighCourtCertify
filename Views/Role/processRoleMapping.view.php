<style>
    #sortable1, #sortable2 { 
        height:300px;
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
        cursor:pointer
    }
    .highlights{
        background-color: GREEN;
    }
    .dropbox {
        border: 1px solid #4c656f;
        width: 450px;
        height:340px;
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
    
        <form method="POST" name="process_role_mapping">
            <div class="row">
                <div class="col-3">
                    <label class="control-label">Select Process:</label>
                </div>
                <?php
                $processes = $data['processes'];
                ?>
                <div class="col-6">
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
                    <button class="but-custom" onClick="fn_save(); return false;" >SAVE</button>
                </div>
            
            </div>
            <div class="row">
                <div class="col-md-6"  style="margin:auto;margin-bottom: 15px">
                    <span id="msg"></span>  
                </div>
            </div>
        </form>
        <div style="margin:auto;margin-top: 15px;padding: 10px">
            <div class="row" id="mapping_layout" style="display:none">
            
                <div class="card"  style="margin-right:10px">
                    <h5 class="card-header default-color white-text text-center py-3">
                      <strong>USER ROLES</strong>
                    </h5>
                    <!--Card content-->
                    <div id="excluded_roles" class="card-body px-lg-5 pt-0 dropbox" style="padding:0px !important">
                        <ul id="sortable1" class="connectedSortable"></ul>
                    </div>

                </div>
                <div class="card"  style="margin-right:10px;">

                    <h5 class="card-header default-color white-text text-center py-3">
                      <strong>ROLES INCLUDED IN THE SELECTED PROCESS</strong>
                    </h5>
                    <!--Card content-->
                    <div id="included_roles" class="card-body px-lg-5 pt-0 dropbox" style="padding:0px !important">
                        <ul id="sortable2" class="connectedSortable"></ul>
                    </div>
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
              method: "post",
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
          var resp = ajax_send('<?= Config::get('host') ?>/role/processRoleMapping',{action: 'getprocessrolemap', pid: pid});
          console.log(JSON.stringify(resp));
         
          if(resp.status == 1){
                var included = resp.data.included;
                for(var i=0; i< included.length; i++){
                    var item = included[i];
                    var x =  "<li class='ui-state-highlight' data-value='"+item.role_id+"' ><span>"+(i+1)+". </span>"+item.role_name+
                            "<input class='form-control' placeholder='Please specify what this user will do.' type='text' name='descrip_"+item.role_id+"' value='"+item.description+"' ></li>";
                    $(sortableId+'2').append(x);
                }
                var excluded = resp.data.excluded;
                for(var i=0; i< excluded.length; i++){
                    var item = excluded[i];
                    var x =  "<li class='ui-state-default' data-value='"+item.role_id+"' ><span>"+(i+1)+". </span>"+item.role_name+
                            "<input class='form-control'  placeholder='Please provide what task to be performed' type='text' style='display: none' name='descrip_"+item.role_id+"' ></li>";
                    $(sortableId+'1').append(x);
                }
          }

    }//end of display_sortable

    function optionprocessclick(obj){
        if(obj.value == "-1" || obj.value==""){
            $("#mapping_layout").hide();
        }
        else{
            $("#mapping_layout").show();
        }
        
        display_sortable('#sortable',obj.value);

        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable",
            start: function(event, ui) {
            },
            change: function(event, ui) {

            },
            update: function(event, ui) {
                $('#sortable2 input').each(function(i)
                {
                   $(this).show(); // This is your rel value
                });
                $('#sortable1 input').each(function(i)
                {
                   $(this).hide(); // This is your rel value
                });
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
            var role_id = $(this).attr('data-value');	   
            var input = $('input[name=descrip_'+role_id+']');
	    included.push( {roleid: role_id, desp: (input.val()).trim() } );
	   
	});
	
	var data = {included: included, excluded: excluded};
	console.log(JSON.stringify(data)); 
	var resp = ajax_send('<?= Config::get('host') ?>/role/processRoleMapping',{action: 'setprocess', data: data, pid: $('#process').val()});
	
        if(resp.status){
            $('#sortable1 input').each(function(i)
            {
               $(this).val(''); // This is your rel value
            });
            $('#sortable1 li').each(function(i)
            {
               $(this).attr("class","ui-state-default"); // This is your rel value
            });
            $('#sortable2 li').each(function(i)
            {
               $(this).attr("class","ui-state-highlight"); // This is your rel value
            });
        }
        Swal.fire({
            title: resp.msg,
            animation: false,
            customClass: {
                popup: 'animated tada'
            }
        });
        
    }// end of function fn_save()
  
</script>

    <script type="text/javascript">
        $(document).ready(function () {
//            $("#excluded_roles").mCustomScrollbar({
//                theme: "minimal"
//            });
//            $("#included_roles").mCustomScrollbar({
//                theme: "minimal"
//            });
        });
    </script>

