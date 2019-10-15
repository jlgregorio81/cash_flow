<?php
namespace core\mvc;
use core\mvc\view\Message;
use core\util\Session;
use core\Application;

abstract class Controller
{

    protected $view;
    protected $viewList;
    protected $dao;
    protected $get;
    protected $post;
    //---------------------------
    protected $criteria;
    protected $orderBy;

    public function __construct()
    {
        /**
         * Get the send data and store it in local variables.
         * $_POST and $_GET are server variables used to store
         * temporarily client data.  
         */
        $this->post = $_POST;
        $this->get = $_GET;
    }

    public function run()
    {
        //..gets the value of command variable of post
        $command = strtolower($this->post['command']);
        //..verify the value and invoke the correct method
        switch ($command) {
            case 'salvar':
                $this->insertUpdate();
                break;
            case 'excluir':
                $this->delete();
                break;
            case 'novo':
                $this->showView();
                break;
            default:
                break;
        }
    }

    /**
     * This method must be implement in inherited classes.
     * Its function is return a model object from data view.
     */
    public abstract function getModelFromView();

    /**
     * This method gets the data from view, instantiates a model
     * object and persists it in database.  
     */
    public function insertUpdate()
    {
        try {
            //..if the 'id' post variable is null, then it is an insertion
            if ($this->post['id'] == null)
                $this->dao->insert($this->getModelFromView());
            else //..else, it is an updating
                $this->dao->update($this->getModelFromView());
            //(new Message())->show(); //..show a message to user
            (new Message(null,Application::$MSG_SUCCESS,
                Application::$ICON_SUCCESS))->show();
        } catch (\Exception $ex) {
            (new Message(null, "Erro: {$ex->getMessage()}."))->show();
        }
    }

    /**
     * This method gets the 'id' post variable and invokes the
     * delete method from DAO object. 
     */
    public function delete()
    {
        try {
            //..if the post 'id' variable is not null, then get the variable and invokes the delete method of DAO object.
            if (!is_null($this->post['id'])) {
                $id = (int)$this->post['id'];
                $this->dao->delete($id);
                (new Message())->show(); //..show a message to user
            }
        } catch (\Exception $ex) {
            (new Message(null, "Erro: {$ex->getMessage()}."))->show();
        }
    }

    /**
     * There are two situations to show a view:
     * a) An 'empty' view to user input data to store or update an object
     * b) A 'full' view that shows stored data retrieved from database.
     */
    public function showView()
    {
        if(Session::getSession('active_user')){
            $activeUserName = Session::getSession('active_user')->getName();
            $this->view->setActiveUserName($activeUserName);
        }

        //..if the id 'get' variable is not set, then show an empty view.
        if (!isset($this->get['id']))
            $this->view->show();
        else //..else, try to retrieve a stored object, set the model and show the view with data.
            try {
                $id = (int)$this->get['id'];
                $model = $this->dao->findById($id);
                if ($model) {
                    $this->view->setModel($model);
                    $this->view->show();
                } else (new Message(null, "Objeto não encontrado!"))->show();
            } catch (\Exception $ex) {
                (new Message(null, "Erro: {$ex->getMessage()}."))->show();
            }        
    }

    /**
     * Exibe a view de listagem (ou pesquisa)
     */
    public function showList()
    {
        if (isset($this->post['page']) || isset($this->get['page'])) {
            if ($this->post) {
                $this->doListing($this->criteria, $this->orderBy);
            }
            if ($this->get) {
                $this->doPagination();
            }
        } else {
            //..destrói todas as sessões gravadas e cria uma view limpa.
            Session::destroySession('sqlData');
            Session::destroySession('criteria');
            Session::destroySession('orderBy');
            Session::destroySession('limit');
            Session::destroySession('lastPage');
            $this->viewList->show();
        }
    }

    private function doListing($criteria, $orderBy)
    {
        //..get the search data came from the form
        $sqlData = null;
        foreach ($this->post['data'] as $datum) {
            $sqlData[] = $datum;
        }        
        //..set sessions containing query data to preserve the data form and navigates in pagination
        Session::createSession('sqlData', $sqlData); //..os dados da pesquisa
        //..limiting the registers per page
        $limit = $this->post['limit'];

        //..set a session with the query criteria
        Session::createSession('criteria', $criteria);
        //..verify how many registers the query returns
        //..the 'count' variable store the counting of the registers returned by the query.
        $count = $this->dao->selectCount($criteria);
        
        //..set a session with the order by 
        Session::createSession('orderBy', $orderBy);

        //..set a session with the registers per page
        Session::createSession('limit', $limit);
        //..set a session with the last page
        //..divide the register quantity by the limit and round to up - it mains the quantity of pages
        Session::createSession('lastPage', ceil($count / $limit));
    }

    private function doPagination()
    {
        //..the query navigation request get variables
        //..get the visited page number and set it in a session               
        $currentPage = $this->get['page'];
        //..get the limit per page          
        $limit = Session::getSession('limit');
        //..calculate the register index to show
        $offSet = $currentPage == 1 ? 0 : ($currentPage - 1) * Session::getSession('limit');
        //..calculates the next page
        $lastPage = Session::getSession('lastPage');
        $nextPage = $currentPage + 1 < $lastPage ? $currentPage + 1 : $lastPage;
        //..calculates the previous page
        $previousPage = $currentPage <= 1 ? 1 : $currentPage - 1;
        //..execute the query using the criteria, the order by, the limit and the offset
        $data = $this->dao->select(
            Session::getSession('criteria'),
            Session::getSession('orderBy'),
            $limit,
            $offSet
        );
        //..creates the view with navigation parameters
        $this->viewList->setModel($data);
        $this->viewList->setSqlData(Session::getSession('sqlData'));
        $this->viewList->setRegPerPage($limit);
        $this->viewList->setCurrentPage($currentPage);
        $this->viewList->setPreviousPage($previousPage);
        $this->viewList->setNextPage($nextPage);
        $this->viewList->setLastPage($lastPage);
        $this->viewList->show();
    }


}
