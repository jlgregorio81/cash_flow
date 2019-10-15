<?php
namespace app\view\category;

use core\mvc\view\HtmlPage;

final class CategoryViewRpt extends HtmlPage{

    protected $rptFile;

    public function __construct($rptFile = null)
    {        
        $this->rptFile = $rptFile;
        $this->htmlFile = 'app/view/category/category_view_rpt.phtml';
    }

    /**
     * Get the value of rptFile
     */ 
    public function getRptFile()
    {
        return $this->rptFile;
    }

    /**
     * Set the value of rptFile
     *
     * @return  self
     */ 
    public function setRptFile($rptFile)
    {
        $this->rptFile = $rptFile;

        return $this;
    }
}