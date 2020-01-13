<script>
    var tasks_id = "<?= $tasks_id ?>";
    var application_id = "<?= $application->application_id ?>";
</script>
<style type="text/css">

#upload-button {
	width: 150px;
	display: block;
	margin: 20px auto;
}

#case_body_file {
    /*display: none;*/
}

#pdf-main-container {
    width: 80%;
    margin: 20px auto;
    overflow: auto;
    /*
    overflow-x: scroll;
    overflow-y: scroll;
    */
}

#pdf-loader {
    display: none;
    text-align: center;
    color: #999999;
    font-size: 13px;
    line-height: 100px;
    height: 100px;
}

#pdf-contents {
    display: none;
}

#pdf-meta {
	overflow: hidden;
	margin: 0 0 20px 0;
}

#pdf-buttons {
	float: left;
}

#page-count-container {
	float: right;
}

#pdf-current-page {
	display: inline;
}

#pdf-total-pages {
	display: inline;
}

#pdf-canvas {
    border: 1px solid rgba(0,0,0,0.2);
    box-sizing: border-box;
}

#page-loader {
    height: 100px;
    line-height: 100px;
    text-align: center;
    display: none;
    color: #999999;
    font-size: 13px;
}

/*
*
* ==========================================
* CUSTOM UTIL CLASSES FOR FILE UPLOAD
* ==========================================
*
*/

.rounded-lg {
  border-radius: 1rem;
}

.custom-file-label.rounded-pill {
  border-radius: 50rem;
  cursor: pointer;
}

.custom-file-label.rounded-pill::after {
  border-radius: 0 50rem 50rem 0;
}

</style>
<script src="<?= Config::get('host') ?>/root/MDB/js/pdf.js" type="text/javascript"></script>
<script src="<?= Config::get('host') ?>/root/MDB/js/pdf.worker.js" type="text/javascript"></script>

<?php
$caseBody = $application->getCaseBody();
if($caseBody === null){
?>
<h3>Add Case Body Form</h3>
<form name="case_body_form" id="case_body_form" action="<?= Config::get('host') ?>/Casebody/uploadCaseBody">
    <?= writeCSRFToken() ?>
    <div class="row">
        <div class="col-sm-3">Case Number:</div>
        <div class="col-sm-4">
            <input type="text" name="case_number" id="case_number" value="<?= $application->case_no ?>" class="form-control" readonly />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">Case Type:</div>
        <div class="col-sm-4">
            <input type="text" name="case_type" id="case_type" value="<?= $application->case_type ?>" class="form-control" readonly />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">Case Year:</div>
        <div class="col-sm-4">
            <input type="text" name="case_year" id="case_year" value="<?= $application->case_year ?>" class="form-control" readonly />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label>Upload Case Body Document:</label>
            <input type="hidden" value="<?= $application->application_id ?>" name="application_id" />
            <input type="hidden" value="<?= $tasks_id ?>" name="tasks_id" />
        </div>
        <div class="col-sm-4">
            <div class="custom-file overflow-hidden rounded-pill">
                <input accept="application/pdf" id="case_body_file" 
                       name="case_body_file" type="file" 
                       class="custom-file-input rounded-pill" required />
                <label for="case_body_file" class="custom-file-label rounded-pill">Choose file</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-primary">Upload &nbsp;<span class="fa fa-upload"></span></button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6" style="margin: auto">
            <div id="progress_div" class="progress" style="height:30px;display:none">
                <div id="upload_progress_bar" class="progress-bar bg-success progress-bar-striped" style="height:30px">
                    <span id="percentage"></span>
                </div>
            </div>
            <div id="output" style="width:100%;text-align: center"></div>
        </div>
    </div>
    
</form>
<script type="text/javascript">
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    
    document.forms['case_body_form'].onsubmit = function(event){
        event.preventDefault();
        swal.fire({
            title: 'Add Case Body',
            text: "Are you sure to add a case body?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: "No, I am not sure!"
        }).then((result) => {
            if (result.value) {
                uploadCaseBody();
            }
        });
    };
    
    function uploadCaseBody(){
        var bar = $('#upload_progress_bar');
        bar.width("0%");
        var percent = $('#percentage');
        percent.html("");
        document.getElementById("output").innerHTML="";
        
        $("#progress_div").show();
        var case_body_form = document.forms['case_body_form'];
        var formData = new FormData(case_body_form);
        $.ajax({
            url:case_body_form.action,
            data: formData,
            type: "POST",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To disable request pages to be cached
            processData:false,
            xhr: function(){
                var xhr = new XMLHttpRequest();
                xhr.upload.onprogress = function(e){
                    var percentComplete = '0';
                    if(e.lengthComputable){
                        percentComplete = Math.round((e.loaded/e.total) * 100) + "%";
                        
                        bar.width(percentComplete);
                        percent.html(percentComplete);
                    }
                };
                return xhr;
            },
            success: function(resp){
                document.getElementById("output").innerHTML = resp.msg;
            },
            error: function(jqXHR, exception, errorThrown){
                result = {};
                if (jqXHR.status === 0) {
                    result['msg'] = 'Not connect.\n Verify Network.';
                    result['status'] = jqXHR.status;
                } 
                else{
                    result = JSON.parse(jqXHR.responseText);
                }
                document.getElementById("output").innerHTML = result.msg;
                bar.width("0%");
                percent.html("");
            }
        });
    }
</script>
<?php 
}
?>
<div>
    <div id="pdf-meta" style="width: 80%;display:none;margin: 20px auto;">
        <div id="pdf-buttons">
            <button class="btn btn-default" type="button" id="pdf-prev">Previous</button>
            <button class="btn btn-default" type="button" id="pdf-next">Next</button>
            <button class="btn btn-default" type="button" id="zoominbutton">Zoom in <span class="fa fa-plus-circle"></span></button>
            <button class="btn btn-default" type="button" id="zoomoutbutton">Zoom out <span class="fa fa-minus-circle"></span></button>
        </div>
        <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div>
    </div>
</div>
<div>
    <div id="pdf-main-container">
        <div id="pdf-loader">
            <span class="spinner-border text-primary"></span> Loading document ...
        </div>
        <div id="pdf-contents">
            <canvas id="pdf-canvas"></canvas>
            <div id="page-loader">
                <span class="spinner-border text-primary"></span> Loading page ...
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var pdfScale = -1;
    var interval = 0.20;
    var __PDF_DOC,
            __CURRENT_PAGE,
            __TOTAL_PAGES,
            __PAGE_RENDERING_IN_PROGRESS = 0,
            __CANVAS = $('#pdf-canvas').get(0),
            __CANVAS_CTX = __CANVAS.getContext('2d');
    var zoominbutton = document.getElementById("zoominbutton");
    zoominbutton.onclick = function() {
       pdfScale = pdfScale + interval;
       showPage(__CURRENT_PAGE, pdfScale);
    }

    var zoomoutbutton = document.getElementById("zoomoutbutton");
    zoomoutbutton.onclick = function() {
       if (pdfScale <= 0.25) {
          return;
       }
       pdfScale = pdfScale - interval;
       //displayPage(shownPdf, pageNum);
       showPage(__CURRENT_PAGE, pdfScale);
    }
    function showPDF(pdf_url) {
        $("#pdf-loader").show();
        PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
            __PDF_DOC = pdf_doc;
            __TOTAL_PAGES = __PDF_DOC.numPages;

            // Hide the pdf loader and show pdf container in HTML
            $("#pdf-loader").hide();
            $("#pdf-contents").show();
            $("#pdf-meta").show();
            $("#pdf-total-pages").text(__TOTAL_PAGES);

            // Show the first page
            showPage(1);
        }).catch(function(error) {
            // If error re-show the upload button
            $("#pdf-loader").hide();
            alert(error.message);
        });
    }

    function showPage(page_no,scale_required= -1) {
        __PAGE_RENDERING_IN_PROGRESS = 1;
        __CURRENT_PAGE = page_no;

        // Disable Prev & Next buttons while page is being loaded
        $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

        // While page is being rendered hide the canvas and show a loading message
        //$("#pdf-canvas").hide();
        $("#page-loader").show();

        // Update current page in HTML
        $("#pdf-current-page").text(page_no);

        // Fetch the page
        __PDF_DOC.getPage(page_no).then(function(page) {
            // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
           var viewport = '';
            if(scale_required === -1){       
                scale_required = ( $('#pdf-contents').width() / page.getViewport(1).width  ) - 0.01;

                pdfScale = scale_required;
                viewport = page.getViewport(scale_required);                 
                $('#pdf-contents').height(viewport.height);      

            }
            viewport = page.getViewport(scale_required);
            // Set canvas height
            __CANVAS.height = viewport.height;
            __CANVAS.width = viewport.width;
            //$('#pdf-contents').height(viewport.height);
            $('#pdf-contents').width(viewport.width);
            var renderContext = {
                canvasContext: __CANVAS_CTX,
                viewport: viewport
            };

            // Render the page contents in the canvas
            page.render(renderContext).then(function() {
                __PAGE_RENDERING_IN_PROGRESS = 0;

                // Re-enable Prev & Next buttons
                $("#pdf-next, #pdf-prev").removeAttr('disabled');

                // Show the canvas and hide the page loader
                $("#pdf-canvas").show();
                $("#page-loader").hide();
            });

        });
        
    }

    // When user chooses a PDF file
    $("#case_body_file").on('change', function(event) {
            // Validate whether PDF
        if(['application/pdf'].indexOf($("#case_body_file").get(0).files[0].type) === -1) {
            alert('Error : Not a PDF');
            return;
        }
        var file_src = document.getElementById("case_body_file");
        // Send the object url of the pdf
        //showPDF(URL.createObjectURL($("#case_body_file").get(0).files[0]));
        showPDF(URL.createObjectURL(file_src.files[0]));
        //refreshing upload progress bar
        var bar = $('#upload_progress_bar');
        bar.width("0%");
        var percent = $('#percentage');
        percent.html("");
        document.getElementById("output").innerHTML="";
    });

    // Previous page of the PDF
    $("#pdf-prev").on('click', function() {
        if(__CURRENT_PAGE > 1){
            showPage(--__CURRENT_PAGE);
        }
    });

    // Next page of the PDF
    $("#pdf-next").on('click', function() {
        if(__CURRENT_PAGE < __TOTAL_PAGES){
            showPage(++__CURRENT_PAGE);
        }
    });
    
    
</script>
<?php
if($caseBody!== null){
    
?>
<div style="width: 80%;margin: 20px auto;">
    <a href="<?= Config::get('host') ?>/Casebody/downloadFile/<?= $caseBody->casebody_id ?>" 
       target="_blank"
       class="btn btn-blue">
        Download Case Body <span class="fa fa-download"></span></a>
</div>
<script type="text/javascript">
    showPDF("<?= Config::get('host') ?>/Casebody/displayFile/<?= $caseBody->casebody_id ?>");
</script>
<?php
    include_once ("approve_n_reject.php");
}
?>