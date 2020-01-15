class PdfDisplay{
    constructor(PDFJS,canvas_id,pdf_contents,next_button,prev_button){
        this.PDFJS = PDFJS;
        this.pdfScale = -1;
        this.interval = 0.05;
        this.__PDF_DOC = null;
        this.__CURRENT_PAGE=1;
        this.__TOTAL_PAGES=1;
        this.__PAGE_RENDERING_IN_PROGRESS = 0;
        this.pdf_canvas = $("#"+canvas_id);
        this.__CANVAS = this.pdf_canvas.get(0);
        this.__CANVAS_CTX = this.__CANVAS.getContext('2d');
        this.pdf_contents = $("#"+pdf_contents);
        this.next_button = $("#"+next_button);
        this.prev_button = $("#"+prev_button);
    }
}

function showPDFDocument(PdfDisplayObj){
    PdfDisplayObj.PDFJS.getDocument({ url: PdfDisplayObj.pdf_url }).then(function(pdf_doc){
        PdfDisplayObj.__PDF_DOC = pdf_doc;
        PdfDisplayObj.__TOTAL_PAGES = pdf_doc.numPages;
        PdfDisplayObj.pdf_contents.show();
        // Show the first page
        showPDFPage(PdfDisplayObj,1);
    }).catch(function(error) {
        alert("Error: "+error.message);
        return;
    });
}

function showPDFPage(PdfDisplayObj,page_no,scale_required= -1){
    PdfDisplayObj.__PAGE_RENDERING_IN_PROGRESS = 1;
    PdfDisplayObj.__CURRENT_PAGE = page_no;
    // Fetch the page
    PdfDisplayObj.__PDF_DOC.getPage(page_no).then(function(page){
        var viewport = '';
        if(scale_required === -1){       
            scale_required = ( PdfDisplayObj.pdf_contents.width() / page.getViewport(1).width  ) - 0.01;

            PdfDisplayObj.pdfScale = scale_required;
            viewport = page.getViewport(scale_required);                 
            PdfDisplayObj.pdf_contents.height(viewport.height);      

        }
        viewport = page.getViewport(scale_required);
        // Set canvas height
        PdfDisplayObj.__CANVAS.height = viewport.height;
        PdfDisplayObj.__CANVAS.width = viewport.width;
        PdfDisplayObj.pdf_contents.width(viewport.width);
        var renderContext = {
            canvasContext: PdfDisplayObj.__CANVAS_CTX,
            viewport: viewport
        };

        // Render the page contents in the canvas
        page.render(renderContext).then(function() {
            PdfDisplayObj.__PAGE_RENDERING_IN_PROGRESS = 0;

            // Re-enable Prev & Next buttons
            PdfDisplayObj.next_button.removeAttr("disabled");
            PdfDisplayObj.prev_button.removeAttr("disabled");
            // Show the canvas and hide the page loader
            PdfDisplayObj.pdf_canvas.show();
            //$("#page-loader").hide();
        });
    });
}


