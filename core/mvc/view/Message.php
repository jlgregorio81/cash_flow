<?php
namespace core\mvc\view;

class Message extends HtmlPage{

    protected $title;
    protected $msg;

    public function __construct($title = "Mensagem do Sistema", 
        $msg = "Operação realizada com sucesso!", $icon = null)
    {        
        $this->title = $title;
        $this->msg = $msg;
        $this->htmlFile = 'core/mvc/view/message.phtml';
        $this->icon = $icon;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;

    }
  
}