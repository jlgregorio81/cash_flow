<?php
namespace core\rpt;

use core\Application;
use TCPDF;

//..requires the main class
require_once('core/vendor/tcpdf-6.3.2/tcpdf.php');

abstract class Report extends TCPDF{

    protected $title;
    protected $data;
    protected $defaultFont;

    public function __construct($orientation = 'P', $unit = 'mm', 
        $format='A4', $unicode = true, $encoding = 'UTF-8', 
        $diskcache = false, $pdfa = false)
   {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, 
            $diskcache, $pdfa);        
        $this->SetTopMargin(20);
        $this->SetLeftMargin(10);
        $this->SetRightMargin(10);
        $this->setHeaderMargin(5);          
    }

    /**
     * This method belongs to super class. This creates the header of the document
     */
    public function Header(){
        $this->Image(Application::$ICON_REPORT,10,5,10,10,'png');        
        $this->SetFont($this->defaultFont, 'B', 14);
        $this->Cell(0,0,Application::$APP_NAME,null,true,'C');
        $this->SetFont($this->defaultFont,null,12);
        $this->Cell(0,0,$this->title,'B', true, 'C');
        
        //..set the content data 
        $this->setContent();
    }

    public abstract function setContent();

    /**
     * This method belongs to super class. This creates the footer of the document
     */
    public function Footer(){
        // Position at 12 mm from bottom
        $this->SetY(-12);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $pageNumber = 'Página: ' . $this->getAliasNumPage() . ' de ' .
             $this->getAliasNbPages();
        // Date 
        $currentDate = 'Relatório gerado em ' . 
            (new \DateTime())->format('d/m/Y H:i');
        $this->Cell(0, 10, "$currentDate - $pageNumber", 'T', 
            false, 'R', 0, '', 0, false, 'T', 'M');

    }


    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;
    }
}