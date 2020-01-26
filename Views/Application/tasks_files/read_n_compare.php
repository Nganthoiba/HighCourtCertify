<style type="text/css">
    .button {
        background-color: #C6CCC6; 
        border: none;
        text-align: center;
        display: inline-block;
        font-size: 10pt;
        padding: 3px 6px;
    }
    .button:hover{
        text-decoration: underline;
        cursor: pointer;
        background-color: #E1E6E1; 
    }
    .pdf-main-container {
        margin: 10px;
        overflow: auto;
        /*
        overflow-x: scroll;
        overflow-y: scroll;
        */
    }

    .pdf-loader {
        display: none;
        text-align: center;
        color: #999999;
        font-size: 13px;
        line-height: 100px;
        height: 100px;
    }

    .pdf-contents {
        display: none;
    }

    .pdf-meta {
        overflow: hidden;
        margin: 0 0 20px 0;
        display: none;
    }

    .pdf-buttons {
        float: left;
    }

    .page-count-container {
        float: right;
        font-size: 10pt;
    }

    .pdf-current-page {
        display: inline;
    }

    .pdf-total-pages {
        display: inline;
    }

    .pdf-canvas {
        border: 1px solid rgba(0,0,0,0.2);
        box-sizing: border-box;
    }

    .page-loader {
        height: 100px;
        line-height: 100px;
        text-align: center;
        display: none;
        color: #999999;
        font-size: 13px;
    }
</style>
<script src="<?= Config::get('host') ?>/root/MDB/js/pdf.js" type="text/javascript"></script>
<script src="<?= Config::get('host') ?>/root/MDB/js/pdf.worker.js" type="text/javascript"></script>
<script src="<?= Config::get('host') ?>/root/MDB/js/pdf_display.js" type="text/javascript"></script>

<p>#Note: You need to read & compare the case body with the prepared certificate, and then forward the application.</p>
<div class="row">
    <div class="col-sm-12">
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" class="custom-control-input" name="show_certificate" id="show_certificate" onclick="showCertificate(this);" />
            <label style="cursor:pointer;font-weight: bold;" class="custom-control-label" for="show_certificate">Show Certificate</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" class="custom-control-input" name="show_casebody" id="show_casebody" onclick="showCaseBody(this);" />
            <label style="cursor:pointer;font-weight: bold;" class="custom-control-label" for="show_casebody">Show Case Body</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="pdf-meta" id="cert-pdf-meta" style="margin: 10px;">
            <div>Certificate:</div>
            <div class="pdf-buttons">
                <button class="button" type="button" id="cert-pdf-prev">
                    <span class="fa fa-backward"></span>
                </button>
                <button class="button" type="button" id="cert-pdf-next">
                    <span class="fa fa-forward"></span>
                </button>
                <button class="button" type="button" id="cert_zoominbutton">
                    <span class="fa fa-plus-circle"></span>
                </button>
                <button class="button" type="button" id="cert_zoomoutbutton">
                    <span class="fa fa-minus-circle"></span>
                </button>
            </div>
            <div class="page-count-container">
                Page <div id="cert_current_page" class="pdf-current-page"></div> of 
                <div id="cert_total_pages" class="pdf-total-pages"></div>                
            </div>
        </div>

        <div class="pdf-main-container">
            <div class="pdf-loader">
                <span class="spinner-border text-primary"></span> Loading document ...
            </div>
            <div id="cert-pdf-contents" class="pdf-contents">
                <canvas id="cert-pdf-canvas" class="pdf-canvas"></canvas>
                <div id="cert-page-loader" class="page-loader">
                    <span class="spinner-border text-primary"></span> Loading page ...
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="pdf-meta" id="pdf-meta" style="margin: 10px;">
            <div>Case Body:</div>
            <div class="pdf-buttons">
                <button class="button" type="button" id="pdf-prev">
                    <span class="fa fa-backward"></span>
                </button>
                <button class="button" type="button" id="pdf-next">
                    <span class="fa fa-forward"></span>
                </button>
                <button class="button" type="button" id="zoominbutton">
                    <span class="fa fa-plus-circle"></span>
                </button>
                <button class="button" type="button" id="zoomoutbutton">
                    <span class="fa fa-minus-circle"></span>
                </button>
            </div>
            <div id="page-count-container" class="page-count-container">
                Page <div id="current_page" class="pdf-current-page"></div> of 
                <div id="total_pages" class="pdf-total-pages"></div>                
            </div>
        </div>

        <div id="pdf-main-container" class="pdf-main-container">
            <div id="pdf-loader" class="pdf-loader">
                <span class="spinner-border text-primary"></span> Loading document ...
            </div>
            <div id="pdf-contents" class="pdf-contents">
                <canvas id="pdf-canvas" class="pdf-canvas"></canvas>
                <div id="page-loader" class="page-loader">
                    <span class="spinner-border text-primary"></span> Loading page ...
                </div>
            </div>
        </div>
    </div>
</div>

<div id='approve_n_reject_layout' style="display: none">
<?php include_once ("forward_n_reject.php"); ?>
</div>

<?php
if($document!== null){
?>
<script type="text/javascript">
    /******** CERTIFICATE (DOCUMENT) DISPLAY SET UP *********/
    var certDisplay = new PdfDisplay("cert-pdf-canvas","cert-pdf-contents","cert-pdf-next","cert-pdf-prev");
    document.getElementById("cert_total_pages").innerHTML = certDisplay.__TOTAL_PAGES;
    var cert_zoominbutton = document.getElementById("cert_zoominbutton");
    cert_zoominbutton.onclick = function() {
       certDisplay.pdfScale = certDisplay.pdfScale + certDisplay.interval;
       showPDFPage(certDisplay,certDisplay.__CURRENT_PAGE, certDisplay.pdfScale);
       document.getElementById("cert_current_page").innerHTML = certDisplay.__CURRENT_PAGE;
    };

    var cert_zoomoutbutton = document.getElementById("cert_zoomoutbutton");
    cert_zoomoutbutton.onclick = function() {
       if (certDisplay.pdfScale <= 0.25) {
          return;
       }
       certDisplay.pdfScale = certDisplay.pdfScale - certDisplay.interval;
       //displayPage(shownPdf, pageNum);
       showPDFPage(certDisplay,certDisplay.__CURRENT_PAGE, certDisplay.pdfScale);
    };

    // Previous page of the PDF
    $("#cert-pdf-prev").on('click', function() {
        if(certDisplay.__CURRENT_PAGE > 1){
            showPDFPage(certDisplay,--certDisplay.__CURRENT_PAGE);
            $("#cert_current_page").text(certDisplay.__CURRENT_PAGE);
        }
    });

    // Next page of the PDF
    $("#cert-pdf-next").on('click', function() {
        if(certDisplay.__CURRENT_PAGE < certDisplay.__TOTAL_PAGES){
            showPDFPage(certDisplay,++certDisplay.__CURRENT_PAGE);
            $("#cert_current_page").text(certDisplay.__CURRENT_PAGE);
        }
    });
    certDisplay.pdf_url = "<?= Config::get('host') ?>/Application/previewDocument/<?= $document->document_id ?>";
    /******* END CERTIFICATE DISPLAY ********/
</script>

<?php
}
?>

<?php
if($caseBody!== null){
    
?>
<script type="text/javascript">
    /******** CASE BODY DISPLAY SET UP *********/
    var pdfDisplay = new PdfDisplay("pdf-canvas","pdf-contents","pdf-next","pdf-prev");
    document.getElementById("total_pages").innerHTML = pdfDisplay.__TOTAL_PAGES;
    var zoominbutton = document.getElementById("zoominbutton");
    zoominbutton.onclick = function() {
       pdfDisplay.pdfScale = pdfDisplay.pdfScale + pdfDisplay.interval;
       showPDFPage(pdfDisplay,pdfDisplay.__CURRENT_PAGE, pdfDisplay.pdfScale);
    };

    var zoomoutbutton = document.getElementById("zoomoutbutton");
    zoomoutbutton.onclick = function() {
       if (pdfDisplay.pdfScale <= 0.25) {
          return;
       }
       pdfDisplay.pdfScale = pdfDisplay.pdfScale - pdfDisplay.interval;
       //displayPage(shownPdf, pageNum);
       showPDFPage(pdfDisplay,pdfDisplay.__CURRENT_PAGE, pdfDisplay.pdfScale);
       document.getElementById("current_page").innerHTML = pdfDisplay.__CURRENT_PAGE;
    };

    // Previous page of the PDF
    $("#pdf-prev").on('click', function() {
        if(pdfDisplay.__CURRENT_PAGE > 1){
            showPDFPage(pdfDisplay,--pdfDisplay.__CURRENT_PAGE);
            document.getElementById("current_page").innerHTML = pdfDisplay.__CURRENT_PAGE;
        }
    });

    // Next page of the PDF
    $("#pdf-next").on('click', function() {
        if(pdfDisplay.__CURRENT_PAGE < pdfDisplay.__TOTAL_PAGES){
            showPDFPage(pdfDisplay,++pdfDisplay.__CURRENT_PAGE);
            document.getElementById("current_page").innerHTML = pdfDisplay.__CURRENT_PAGE;
        }
    });
    
    pdfDisplay.pdf_url = "<?= Config::get('host') ?>/Casebody/displayFile/<?= $caseBody->casebody_id ?>";
    
    /******* END CASE BODY DISPLAY ********/
</script>

<?php
}
?>
<script type="text/javascript">
    
    function showCaseBody(obj){
        if(obj.checked === true){
            showPDFDocument(pdfDisplay,"total_pages");
            $("#pdf-meta").show();
            document.getElementById("current_page").innerHTML = pdfDisplay.__CURRENT_PAGE;
            //document.getElementById("total_pages").innerHTML = pdfDisplay.__TOTAL_PAGES;
            //console.log("Casebody total pages: "+pdfDisplay.__TOTAL_PAGES);
            $("#approve_n_reject_layout").show();
        }
        else{
            $("#pdf-meta").hide();
            pdfDisplay.pdf_canvas.hide();
            $("#approve_n_reject_layout").hide();
        }
    }
    
    function showCertificate(obj){
        if(obj.checked === true){
            showPDFDocument(certDisplay,"cert_total_pages");
            $("#cert-pdf-meta").show();
            document.getElementById("cert_current_page").innerHTML = certDisplay.__CURRENT_PAGE;
            //document.getElementById("cert_total_pages").innerHTML = certDisplay.__TOTAL_PAGES;
            //console.log("Certificate total pages: "+certDisplay.__TOTAL_PAGES);
            $("#approve_n_reject_layout").show();
        }
        else{
            $("#cert-pdf-meta").hide();
            certDisplay.pdf_canvas.hide();
            $("#approve_n_reject_layout").hide();
        }
    }
    
</script>