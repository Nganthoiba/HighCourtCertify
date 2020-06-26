<h3>Certificate Preparation</h3>
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

#file-to-upload {
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
<form name="cert_preparation_form" id="cert_preparation_form" action="<?= Config::get('host') ?>/Application/uploadDocument">
    
    
    <div class="row">
        <div class="col-sm-3">
            <label>Upload Certificate:</label>
            <input type="hidden" value="<?= $application->application_id ?>" name="application_id" />
            <input type="hidden" value="<?= $tasks_id ?>" name="tasks_id" />
        </div>
        <div class="col-sm-4">
            <div class="custom-file overflow-hidden rounded-pill">
                <input accept="application/pdf" id="file-to-upload" 
                       name="file-to-upload" type="file" 
                       class="custom-file-input rounded-pill" />
                <label for="file-to-upload" class="custom-file-label rounded-pill">Choose file</label>
            </div>
        </div>
        <div class="col-sm-4" style="margin-top:-10px;">
            <button type="submit" class="btn btn-primary">Upload and forward <span class="fa fa-upload"></span></button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 alert alert-warning">
            #Note: The certificate must be the scanned copy of certificate signed by concerned authorities.
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
</form>
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
    };

    var zoomoutbutton = document.getElementById("zoomoutbutton");
    zoomoutbutton.onclick = function() {
       if (pdfScale <= 0.25) {
          return;
       }
       pdfScale = pdfScale - interval;
       //displayPage(shownPdf, pageNum);
       showPage(__CURRENT_PAGE, pdfScale);
    };
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
    $("#file-to-upload").on('change', function(event) {
            // Validate whether PDF
        if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) === -1) {
            alert('Error : Not a PDF');
            return;
        }
        var file_src = document.getElementById("file-to-upload");
        // Send the object url of the pdf
        //showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));
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
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    
    document.forms['cert_preparation_form'].onsubmit = function(event){
        event.preventDefault();
        swal.fire({
            title: 'Forward!',
            text: "Are you sure to upload and forward?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: "No, I am not sure!"
        }).then((result) => {
            if (result.value) {
                uploadDocument();
            }
        });
    }
    
    function uploadDocument(){
        var bar = $('#upload_progress_bar');
        bar.width("0%");
        var percent = $('#percentage');
        percent.html("");
        document.getElementById("output").innerHTML="";
        
        $("#progress_div").show();
        var cert_preparation_form = document.forms['cert_preparation_form'];
        var formData = new FormData(cert_preparation_form);
        $.ajax({
            url:cert_preparation_form.action,
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
