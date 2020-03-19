<?php
/**
 * Description of PdfController
 *
 * @author Nganthoiba
 */
class PdfController extends Controller {
    private $request;
    public function __construct($data = array ()) {
        parent::__construct($data);
        $this->request = new Request();
    }
    
    public function index(){
        return $this->view();
    }
    
    public function testWatermark(){
        $pdf=new PDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        /*
        $txt="FPDF is a PHP class which allows to generate PDF files with pure PHP, that is to say ".
            "without using the PDFlib library. F from FPDF stands for Free: you may use it for any ".
            "kind of usage and modify it to suit your needs.\n\n";
        for($i=0;$i<25;$i++){
            $pdf->MultiCell(0,5,$txt,0,'J');
        }
        */
        //$txt = "The High Court of Manipur";
        //$pdf->Cell($pdf->GetStringWidth($txt)+2, 6, $txt, 1);
        $pdf->Output();
    }
    
    
    
    public function saveReceiptAsPDF(){
        $params = $this->getParams();
        if(!isset($params[0])){
            $this->data['msg'] = "Invalid request";
            return $this->view();
        }
        
        $payments_id = $params[0];
        $payment = new Payments();
        $payment = $payment->find($payments_id);
        if($payment === null){
            $this->data['msg'] = "Application not found.";
            return $this->view();
        }
        
        
        $pdf=new PDF('L','mm','A5');
        $pdf->AddPage();
        
        $pdf->Ln();
        $pdf->SetFont('Arial','',14);
        $pdf->Cell(0, 5, "Receipt Details",0,"L");
        $pdf->Ln();
        
        $pdf->SetFont('Arial','',12); 
        
        $w = [40,10,80]; 
        $table_data = [
            ["Transaction ID",":",$payment->transaction_id],
            ["Amount",":","Rs ".$payment->amount." /-"],
            ["Purpose",":",$payment->purpose],
            ["Application ID",":",$payment->application_id],
            ["Payment Status",":",$payment->status=="Completed"?"Success":"Failed"],
            ["Date of payment",":",date('d-M-Y',strtotime($payment->created_at))],
        ];
        $pdf->ShowInTable([], $table_data,$w,0);
        
        $pdf->Ln();
        // Position at 1.5 cm from bottom
        $pdf->SetY(-30);
        // Arial italic 8
        $pdf->SetFont('Arial','',8);
        // Page number
        $pdf->Cell(0,6,"#Note: This receipt is generated from ".Config::get('host')." on ".date("d/m/Y"),0,0,'L');
        
        $pdf->Output();
    }
    
}
