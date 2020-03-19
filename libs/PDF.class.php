<?php
/**
 * Description of PDF
 *
 * @author Nganthoiba
 * parent class FPDF is defined in Includes/fpdf18/fpdf.php file and 
 * it is already included in Includes/include_files.php
 * 
 */
class PDF extends FPDF{
    var $angle=0;
    
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);
    }
        
    public function Rotate($angle,$x=-1,$y=-1)
    {
	if($x==-1)
            $x=$this->x;
	if($y==-1)
            $y=$this->y;
	if($this->angle!=0){
            $this->_out('Q');
        }
	$this->angle=$angle;
	if($angle!=0)
	{
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	}
    }

    public function _endpage()
    {
	if($this->angle!=0)
	{
		$this->angle=0;
		$this->_out('Q');
	}
	parent::_endpage();
    }

    private function AddWatermark(){
        /* Put the watermark */
        $file = "MDB/img/watermark1.png";
        
        $img_width = $this->GetPageWidth();
        $img_height = $this->GetPageHeight();
        //$this->centreImage($file,30,30,true,false);
        $this->centreImage($file,$img_width,$img_height,true,true);
        
        //add highcourt logo
        $logo_file = "MDB/img/high_court_logo.jpg";
        $this->centreImage($logo_file,30,30,true,false);
        
        
        $this->SetFont('times','B',24);
        $this->SetTextColor(96,96,96);
        
        $this->SetY(35);
        $this->MultiCell(0, 6, "The High Court of Manipur, Imphal",0,"C");
        $this->Line(10, $this->GetY()+2, $this->GetPageWidth()-10, $this->GetY()+2);     
        
        /*
        $this->SetFont('Times','',8);
        $this->SetTextColor(255,192,203);
        $txt = 'The High Court Of Manipur, Imphal';
        $h_intv = 5;
        $w_intv = $this->GetStringWidth($txt)+1;
        
        //until it reach page height
        for($y = 0; $y < $this->GetPageHeight(); $y += $h_intv ){
            for($x = 0; $x < $this->GetPageWidth(); $x += $w_intv){
                //$this->RotatedText($x,$y,$txt,0);
                $this->Text($x, $y, $txt);
            }
        }
        */
        
        /**** End of Watermark ***/
        //$this->RotatedText($this->GetPageWidth()-130,$this->GetPageHeight()-45,$txt,45);
        
        //$this->RotateAndCenter('THE HIGH  COURT OF MANIPUR, IMPHAL',45,false);
    }
    
    public function VCell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false)
    {
        //Output a cell
        $k=$this->k;
        if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
        {
            //Automatic page break
            $x=$this->x;
            $ws=$this->ws;
            if($ws>0)
            {
                $this->ws=0;
                $this->_out('0 Tw');
            }
            $this->x=$x;
            if($ws>0)
            {
                $this->ws=$ws;
                $this->_out(sprintf('%.3F Tw',$ws*$k));
            }
        }
        if($w==0){
            $w=$this->w-$this->rMargin-$this->x;
        }
        $s='';
        // begin change Cell function 
        if($fill || $border>0)
        {
            if($fill){
                $op=($border>0) ? 'B' : 'f';
            }
            else{
                $op='S';
            }
            if ($border>1) {
                $s=sprintf('q %.2F w %.2F %.2F %.2F %.2F re %s Q ',$border,
                                            $this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
            }
            else{
                $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);


            }
        }
        if(is_string($border))
        {
            $x=$this->x;
            $y=$this->y;
            if(is_int(strpos($border,'L')))
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'l')))
                $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);

            if(is_int(strpos($border,'T')))
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
            else if(is_int(strpos($border,'t')))
                $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);

            if(is_int(strpos($border,'R')))
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'r')))
                $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);

            if(is_int(strpos($border,'B')))
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'b')))
                $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        }
            if(trim($txt)!='')
            {
                $cr=substr_count($txt,"\n");
                if ($cr>0) { // Multi line
                        $txts = explode("\n", $txt);
                        $lines = count($txts);
                        for($l=0;$l<$lines;$l++) {
                                $txt=$txts[$l];
                                $w_txt=$this->GetStringWidth($txt);
                                if ($align=='U')
                                        $dy=$this->cMargin+$w_txt;
                                elseif($align=='D')
                                        $dy=$h-$this->cMargin;
                                else
                                        $dy=($h+$w_txt)/2;
                                $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
                                if($this->ColorFlag)
                                        $s.='q '.$this->TextColor.' ';
                                $s.=sprintf('BT 0 1 -1 0 %.2F %.2F Tm (%s) Tj ET ',
                                        ($this->x+.5*$w+(.7+$l-$lines/2)*$this->FontSize)*$k,
                                        ($this->h-($this->y+$dy))*$k,$txt);
                                if($this->ColorFlag)
                                        $s.=' Q ';
                        }
                }
                else { // Single line
                    $w_txt=$this->GetStringWidth($txt);
                    $Tz=100;
                    if ($w_txt>$h-2*$this->cMargin) {
                        $Tz=($h-2*$this->cMargin)/$w_txt*100;
                        $w_txt=$h-2*$this->cMargin;
                    }
                    if ($align=='U')
                        $dy=$this->cMargin+$w_txt;
                    elseif($align=='D')
                        $dy=$h-$this->cMargin;
                    else
                        $dy=($h+$w_txt)/2;
                    $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
                    if($this->ColorFlag)
                            $s.='q '.$this->TextColor.' ';
                    $s.=sprintf('q BT 0 1 -1 0 %.2F %.2F Tm %.2F Tz (%s) Tj ET Q ',
                                            ($this->x+.5*$w+.3*$this->FontSize)*$k,
                                            ($this->h-($this->y+$dy))*$k,$Tz,$txt);
                    if($this->ColorFlag)
                        $s.=' Q ';
                }
            }
        // end change Cell function 
        if($s){
            $this->_out($s);
        }
        $this->lasth=$h;
        if($ln>0)
        {
            //Go to next line
            $this->y+=$h;
            if($ln==1){
                $this->x=$this->lMargin;
            }
        }
        else{
            $this->x+=$w;
        }
    }

    public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Output a cell
        $k=$this->k;

        if($w==0)
                $w=$this->w-$this->rMargin-$this->x;
        $s='';
        // begin change Cell function
        if($fill || $border>0)
        {
                if($fill)
                        $op=($border>0) ? 'B' : 'f';
                else
                        $op='S';
                if ($border>1) {
                        $s=sprintf('q %.2F w %.2F %.2F %.2F %.2F re %s Q ',$border,
                                $this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
                }
                else
                        $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
        }
        if(is_string($border))
        {
            $x=$this->x;
            $y=$this->y;
            if(is_int(strpos($border,'L')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'l')))
                    $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);

            if(is_int(strpos($border,'T')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
            else if(is_int(strpos($border,'t')))
                    $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);

            if(is_int(strpos($border,'R')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'r')))
                    $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);

            if(is_int(strpos($border,'B')))
                    $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            else if(is_int(strpos($border,'b')))
                    $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        }
        if (trim($txt)!='') {
            $cr=substr_count($txt,"\n");
            if ($cr>0) { // Multi line
                $txts = explode("\n", $txt);
                $lines = count($txts);
                for($l=0;$l<$lines;$l++) {
                    $txt=$txts[$l];
                    $w_txt=$this->GetStringWidth($txt);
                    if($align=='R')
                        $dx=$w-$w_txt-$this->cMargin;
                    elseif($align=='C')
                        $dx=($w-$w_txt)/2;
                    else
                        $dx=$this->cMargin;

                    $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
                    if($this->ColorFlag)
                            $s.='q '.$this->TextColor.' ';
                    $s.=sprintf('BT %.2F %.2F Td (%s) Tj ET ',
                            ($this->x+$dx)*$k,
                            ($this->h-($this->y+.5*$h+(.7+$l-$lines/2)*$this->FontSize))*$k,
                            $txt);
                    if($this->underline)
                            $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
                    if($this->ColorFlag)
                            $s.=' Q ';
                    if($link)
                        $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$w_txt,$this->FontSize,$link);
                }
            }
            else { // Single line
                $w_txt=$this->GetStringWidth($txt);
                $Tz=100;
                if ($w_txt>$w-2*$this->cMargin) { // Need compression
                    $Tz=($w-2*$this->cMargin)/$w_txt*100;
                    $w_txt=$w-2*$this->cMargin;
                }
                if($align=='R'){
                    $dx=$w-$w_txt-$this->cMargin;
                }
                elseif($align=='C'){
                    $dx=($w-$w_txt)/2;
                }
                else{
                    $dx=$this->cMargin;
                }
                $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
                if($this->ColorFlag)
                        $s.='q '.$this->TextColor.' ';
                $s.=sprintf('q BT %.2F %.2F Td %.2F Tz (%s) Tj ET Q ',
                                        ($this->x+$dx)*$k,
                                        ($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,
                                        $Tz,$txt);
                if($this->underline)
                        $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
                if($this->ColorFlag)
                        $s.=' Q ';
                if($link)
                        $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$w_txt,$this->FontSize,$link);
            }
        }
        // end change Cell function
        if($s){
            $this->_out($s);
        }
        $this->lasth=$h;
        if($ln>0)
        {
            //Go to next line
            $this->y+=$h;
            if($ln==1){
                $this->x=$this->lMargin;
            }
        }
        else{
            $this->x+=$w;
        }
    }
    
    
    
    public function Header()
    {
        $this->AddWatermark();   
    }
    // Page footer
    public function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'R');
    }
    
    public function RotatedText($x, $y, $txt, $angle)
    {
        /* Text rotated around its origin */
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }
    
    
    // For printing table of data

    // Colored table
    function ShowInTable($header, $data,$w/*Widths*/,$border=0)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        //$this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.2);
        $this->SetFont('','B');//table headers are printed in bold letters
        // Printing Header
        for($i=0;$i<count($header);$i++){
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        $row_cnt = 0;
        foreach($data as $row)
        {
            $col_cnt = 0;//column count
            foreach ($row as $col){
                $cell_border = ($row_cnt ==0)?"LTRB":"LRB"; //L=left, T=top, R=right, B=bottom
                $align = is_numeric($col)?"R":"L";
                if($border==0){
                    $this->Cell($w[$col_cnt],6,$col,0,0,$align,$fill);
                }
                else{
                    $this->Cell($w[$col_cnt],6,$col,$cell_border,0,$align,$fill);
                }
                $col_cnt++;
            }
            $this->Ln();
            //$fill = !$fill;
            $row_cnt++;
        }
    }
    
    //for printing Image at center of the page whether horizontally or vertically
    function centreImage($img,$width, $height,$h_center=false,$v_center=false) {
        /*
         * $width   :   width of the image
         * $height  :   height of the image
         * $h_center:   Horizontal center
         * $v_center:   Vertical center
         */
        
        $x = ($h_center==true)?($this->GetPageWidth()/2) - ($width/2):0;//X co ordinate
        $y = ($v_center==true)?($this->GetPageHeight()/2) - ($height/2):5;//Y co ordinate     
                $this->SetY(0);
        $this->Image(
            $img, $x,$y,
            $width,
            $height
        );
    }
    
    /*** Method to return the dimensions(height and width) of a string in text area */
    private function getTextAreaDimension(string $str,float $angle=0): array{
        /*
            $str     :  String of text
         *  $angle   :  Text orientation angle, by default 0 
         *              which means text is horizontally oriented.         
         */
        $h = $this->GetStringWidth($str)+3; // Hypotenous
        
        $p = round(sin($angle)*$h); //perpendicular, which is the height of the text area
        $b = round(cos($angle)*$h); //base, which is the width of the text area
        return [$b,$p];
    }
    
    public function RotateAndCenter(string $str, float $angle, bool $v_center=true, bool $h_center=true){
        //Getting text area dimensions
        list($width, $height) = $this->getTextAreaDimension($str, $angle);
        
        $x = ($h_center==true)?($this->GetPageWidth()/2) - ($width/2):0;//X co ordinate
        $y = ($v_center==true)?($this->GetPageHeight()/2) - ($height/2):0;//Y co ordinate
        
        /* Text rotated around its origin */
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$str);
        $this->Rotate(0);//reset to original orientation
    }
}

/**************** START OF PDF FUNCTIONS *************************/


function print_line($title, $text='', $border=0, $style = '', $size = 14){
	global $pdf, $x, $y;
	$pdf->SetFont('times',$style,$size);
	$pdf->Cell($x*1, $y,"",$border.'L',0);
	$pdf->Cell($x*6, $y,trim($title),$border,0,'L');
	$pdf->Cell($x*1, $y,": ",$border,0,'C');
	$pdf->Cell($x*12, $y,trim($text),$border.'R',1,'L');
}

function print_stamp($title, $text='', $style = '', $size = 14){
	global $pdf, $x, $y;
	$pdf->SetFont('times',$style,$size);
	$pdf->VCell($x*2, $y*5,trim($title),1,0);
	$pdf->Cell($x*18, $y*5,trim($text),1,1,'L');
}


function key_exist($x,$arr)//finding a key and gives its value
{
    if(is_array($arr))
    {
        if(array_key_exists($x,$arr))
        {
            return true;
        }

        foreach($arr as $a1)
        {
            if(key_exist($x,$a1))
            {
                return true;
            }
        }

    }
    return false;
}

//finding a value exist in multidimensional array and return the array where the value exist
function val_exist($x, $arr) 
{
	$value=NULL;
	if(is_array($arr))
	{
		$xkey = array_keys($arr);
		foreach($xkey as $xk)
		{
			 if($x==$arr[$xk])
			 {
				return $arr;
			 }
		}
		foreach($arr as $a1)
		{
			$value = val_exist($x, $a1);
			if(!empty($value))
				{	
					return $value;
				}
		}
	}
return $value;
}

//taking an array of string and giving the logest width of the string
function logest_width($arr,$pdf)  
{
	 
	 $b = 0;
	 foreach($arr as $k => $v)
			{
			if(is_string($v)){
			$a = $pdf->GetStringWidth(trim($v)); 
			if($a>$b){$b = $a;}
				}
			}
	return $b;
}



//function to be the heading of the table 	
function Top(PDF $pdf)
{
    global $x,$y;

    //creating new page
    $pdf->AddPage();

    $pdf->SetFont('times','',8);

    $pdf->VCell($x*0.2,$y*0.5+$max_ad,"Sl. No.",1,0,'C');


    return $pdf;
}


//*********************** END OF PDF FUNCTIONS *******************************/