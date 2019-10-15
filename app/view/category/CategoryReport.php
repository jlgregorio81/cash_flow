<?php
namespace app\view\category;

use core\rpt\Report;

final class CategoryReport extends Report{

    public function setContent()
    {
        //..break a line
        $this->Write(0,"\n");
        //..configure the font
        $this->SetFont("Helvetica",'B',12);                                    
        //..create the first line
        $this->Cell(20,0,'ID',1,false,'C');
        $this->Cell(170,0,'Nome',1,true,'C');

        //..set the font
        $this->SetFont('Helvetica',null,10);
        
        //..if there are data to show...
        if($this->data){  
            $this->SetCellPadding(1); //..set the padding of the cells
            foreach($this->data as $category){
                $this->Cell(20,0,$category->getId(),1,false,'C');
                $this->Cell(170,0,$category->getName(),1,true);
            }
        } 
    }



}