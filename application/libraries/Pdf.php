<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
//require_once APPPATH."/third_party/excel/PHPExcel.php";

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
    		session_start();
        // get the current page break margin
	   //$this->writeHTML($img_file, true, false, true, false, ''); 
	   // if (count($this->pages) === 1) { // Do this only on the first page
	    	 $img_file = K_PATH_IMAGES.'logo_company1.png';
	    	 $this->Image($img_file, 10, 10, 50, 30, '', 10, '', false, false, '', false, false, 0); 
	    	 //$this->writeHTML('hello this is text', true, false, true, false, ''); 
             //$this->GetY(); 
           //$this->Cell(175,45, 'Non-Binding Customer Quote', 0, false, 'C', 0, '', 0, false, 'T', '' );
             $text = "<span style='padding:10px;'>".$_SESSION['empname']."<br>".$_SESSION['assignDate']."</span> <br>";
            $this->writeHTML($text, true, false, true, false, 'R'); 
           
  	   		 //$this->SetY(40);
  	  		 $this->SetMargins(PDF_MARGIN_LEFT, $this->GetY(), PDF_MARGIN_RIGHT);
  	  		 
    	//} 
    }
 
  	  
	
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		$this->setCellHeightRatio(5);

		// Set font
		$this->SetFont('helvetica', 'I', 6);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

?>