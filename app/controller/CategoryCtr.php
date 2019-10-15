<?php
namespace app\controller;

use core\mvc\Controller;
use app\dao\CategoryDao;
use app\model\CategoryModel;
use app\view\category\CategoryView;
use app\view\category\CategoryList;
use app\view\category\CategoryReport;
use app\view\category\CategoryViewRpt;
use core\Application;

final class CategoryCtr extends Controller
{

    public function __construct()
    {
        parent::__construct();        
        $this->dao = new CategoryDao(); //..The DAO object
        $this->view = new CategoryView(); //..the View Object
        $this->viewList = new CategoryList(); //..the List View Object        
    }

    public function getModelFromView()
    {
        if (isset($this->post) && !empty($this->post)) {
            $id = (int)$this->post['id'];
            $name = ltrim($this->post['name']);                       
            return new CategoryModel($id, $name);
        }
    }

    public function showList() {
        if($this->post){
            $this->criteria = "upper(name) like upper('{$this->post['data'][0]}')";
            $this->orderBy = 'name';
        }
        parent::showList();
    } 
    
    public function showReport(){
        $catViewRpt = new CategoryViewRpt();
        if($this->post){ 
            //..get the var of the post
            $name = isset($this->post['name']) ? $this->post['name'] : null;
            //..instantiates a new dao
            $catDao = new CategoryDao();
            $data = null;
            //..perform the query
            if($name)
                $data = $catDao->select("upper(name) like upper('$name%')",'name');
            else
                $data = $catDao->select(null,'name');
            //..creates the report
            $report = new CategoryReport();
            $report->setTitle('Relatório de Categorias');
            //..set the data
            $report->setData($data);
            //..save a temporary file
            $file = Application::getRoot() . 'temp/report.pdf';
            $report->Output($file,'F'); 
            //..set the file on view
            $catViewRpt->setRptFile('temp/report.pdf');
        } 
        //..show view
        $catViewRpt->show();                    
        
    }
 
}




