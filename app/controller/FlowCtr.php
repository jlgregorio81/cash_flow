<?php
namespace app\controller;

use core\mvc\Controller;
use app\dao\FlowDao;
use app\view\flow\FlowView;
use app\model\FlowModel;
use app\model\CategoryModel;
use app\dao\CategoryDao;
use core\Application;

final class FlowCtr extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->dao = new FlowDao(); //..The DAO object
        $this->view = new FlowView(); //..the View Object
        //$this->viewList = new FlowList(); //..the List View Object 
    }

    public function getModelFromView()
    {   
        if (isset($this->post) && !empty($this->post)) {
            $id = (int)$this->post['id'];
            $date = $this->post['date'];
            $description = $this->post['description'];
            $type = $this->post['type'];
            $value = (float) $this->post['value'];
            $category = (int) $this->post['category'];
            return new FlowModel($id, $date,$description,
                $type,$value,new CategoryModel($category, null));            
        }
    }

    public function showView()
    {
        $categories = (new CategoryDao())->select();
        $this->view->setCategories($categories);

        //..load the register of the current date.
        $currentDate = (new \DateTime())->format('Y-m-d');
        $flowDao = new FlowDao();
        $flowList = $flowDao->select("date = '$currentDate'");
        $this->view->setFlowList($flowList);

        //..get the values to show
        $previousValue = $flowDao->selectSum($currentDate);        
        $dayValue =  $flowDao->selectSum($currentDate,false);
        $currentValue = $previousValue + $dayValue;

        //..setting the values to show
        $this->view->setPreviousValue($previousValue);
        $this->view->setDayValue($dayValue);
        $this->view->setCurrentValue($currentValue);

        parent::showView();
    }

    public function insertUpdate()
    {
        try {
            //..if the 'id' post variable is null, then it is an insertion
            if ($this->post['id'] == null)
                $this->dao->insert($this->getModelFromView());
            else //..else, it is an updating
                $this->dao->update($this->getModelFromView()); 
                //..set the variable to show a javascript alert in client.           
                //..in this case, our view will be loaded after the insertion, because a list with current date flow must be show.
                $this->view->setMsg(Application::$MSG_SUCCESS);
                //..show the view
                $this->showView();
        } catch (\Exception $ex) {
            (new Message(null, "Erro: {$ex->getMessage()}."))->show();
        }
    }

    public function delete()
    {
        try {
            //..if the post 'id' variable is not null, then get the variable and invokes the delete method of DAO object.
            if (!is_null($this->post['id'])) {
                $id = (int)$this->post['id'];
                $this->dao->delete($id);
                //..set the variable to show a javascript alert in client.           
                //..in this case, our view will be loaded after the insertion, because a list with current date flow must be show.
                $this->view->setMsg(Application::$MSG_SUCCESS);
                //..show the view
                $this->showView();
            }
        } catch (\Exception $ex) {
            (new Message(null, "Erro: {$ex->getMessage()}."))->show();
        }
    }



}
