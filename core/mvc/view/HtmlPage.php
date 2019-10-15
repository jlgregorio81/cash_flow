<?php
namespace core\mvc\view;

use core\util\Session;

abstract class HtmlPage{
    protected $model;
    protected $htmlFile;
    //------icon-----------------------
    protected $icon;

    //----pagination attributes -------
    protected $sqlData;
    protected $regPerPage;
    protected $currentPage;
    protected $previousPage;
    protected $nextPage;
    protected $lastPage;

    //-- active user
    protected $activeUserName;

    public function __construct($model = null) {
        $this->model = $model;

    }

    public function renderHeader(){
        require_once('core\mvc\view\header.phtml');
    }

    public function renderFooter(){
        require_once('core\mvc\view\footer.phtml');
    }

    public function show(){
        $this->renderHeader();
        require_once($this->htmlFile);
        $this->renderFooter();
    }

    public function setIcon($icon){
        $this->icon = $icon;
    }

    public function getIcon(){
        return $this->icon;
    }

    public function getModel() {
        return $this->model;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function getHtmlFile() {
        return $this->htmlFile;
    }

    public function getSqlData() {
        return $this->sqlData;
    }

    public function getRegPorPag() {
        return $this->regPerPage;
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function getPreviousPage() {
        return $this->previousPage;
    }

    public function getNextPage() {
        return $this->nextPage;
    }

    public function getLastPage() {
        return $this->lastPage;
    }

    public function setHtmlFile($htmlFile) {
        $this->htmlFile = $htmlFile;
    }

    public function setSqlData($dataSql) {
        $this->sqlData = $dataSql;
    }

    public function setRegPerPage($regPerPag) {
        $this->regPerPage = $regPerPag;
    }

    public function setCurrentPage($currPage) {
        $this->currentPage = $currPage;
    }

    public function setPreviousPage($prevPage) {
        $this->previousPage = $prevPage;
    }

    public function setNextPage($nextPage) {
        $this->nextPage = $nextPage;
    }

    public function setLastPage($lastPage) {
        $this->lastPage = $lastPage;
    }

    /**
     * 
     * @param array $header A string array containing the list header names
     * @param array $arrayGetters As string array containing the get methods to show header data 
     * @param array $arrayObj An object array containing the model objects that containing de data
     * @param string $controller the controller name to create a link to open the object aiming edit or delete
     */
    public function createList($arrayObj, $header, $arrayGetters, 
        $controller) {
        //..if there is an object array, then...
        if ($arrayObj) {
            echo "<table border=\"1\">";
            echo "<tr>";
            //..creates the header
            foreach ($header as $field) {
                echo "<th>$field</th>";
            }
            echo "<th>Editar/Excluir</th>";
            echo "</tr>";
            foreach ($arrayObj as $obj) {
                echo "<tr>";
                foreach ($arrayGetters as $getter) {
                    echo "<td>";
                    if (method_exists($obj, $getter)) {
                        echo call_user_func(array($obj, $getter));                       
                    } else {                        
                        echo "<pre style=\"color:red\">Objeto ou método inválido!</pre>";
                    }
                    echo "</td>";
                }
                echo "<td><a href=\"Request.php?class={$controller}&method=showView&id={$obj->getId()}\">OK</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else{
            if (!$this->model && $_POST)
                echo "<h1><small>Não encontrado!</small></h1>";
        }
    }

    public function objectNotFound() {
        if (!$this->model && $_POST) {            
           
        }
    }

    public function createPagination($controller) {
        if ($this->model) {
            echo "<div>";
            echo "<ul>";
            echo "<li><a href=\"Request.php?class=$controller&method=showList&page=1\">Primeiro</a></li>";
            echo "<li><a href=\"Request.php?class=$controller&method=showList&page={$this->previousPage}\">Anterior</a></li>";
            echo "<li><strong>Página {$this->currentPage} de {$this->lastPage}</strong></li>";
            echo "<li><a href=\"Request.php?class=$controller&method=showList&page={$this->nextPage}\">Próximo</a></li>";
            echo "<li><a href=\"Request.php?class=$controller&method=showList&page={$this->lastPage}\">Último</a></li>";
            echo "<ul>";
            echo "<div>";
        }
    }




    /**
     * Get the value of activeUserName
     */ 
    public function getActiveUserName()
    {
        return $this->activeUserName;
    }

    /**
     * Set the value of activeUserName
     *
     * @return  self
     */ 
    public function setActiveUserName($activeUserName)
    {
        $this->activeUserName = $activeUserName;

        return $this;
    }
}