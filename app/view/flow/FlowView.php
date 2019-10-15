<?php
namespace app\view\flow;

use core\mvc\view\HtmlPage;
use app\model\FlowModel;

final class FlowView extends HtmlPage{

    protected $categories;
    //..msg in JS
    protected $msg;

    //..flowList to display the current date
    protected $flowList;

    //..the sum of previous flows
    protected $previousValue;

    //..the sum of day values
    protected $dayValue;

    //..the current value of the flow
    protected $currentValue;


    public function __construct(FlowModel $model = null)
    {
        $this->model = is_null($model) ? new FlowModel() : $model;
        $this->htmlFile = 'app/view/flow/flow_view.phtml';        
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @return  self
     */ 
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get the value of msg
     */ 
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * Set the value of msg
     *
     * @return  self
     */ 
    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    /**
     * Get the value of flowList
     */ 
    public function getFlowList()
    {
        return $this->flowList;
    }

    /**
     * Set the value of flowList
     *
     * @return  self
     */ 
    public function setFlowList($flowList)
    {
        $this->flowList = $flowList;

        return $this;
    }

    /**
     * Get the value of previousValue
     */ 
    public function getPreviousValue()
    {
        return $this->previousValue;
    }

    /**
     * Set the value of previousValue
     *
     * @return  self
     */ 
    public function setPreviousValue($previousValue)
    {
        $this->previousValue = $previousValue;

        return $this;
    }

    /**
     * Get the value of dayValue
     */ 
    public function getDayValue()
    {
        return $this->dayValue;
    }

    /**
     * Set the value of dayValue
     *
     * @return  self
     */ 
    public function setDayValue($dayValue)
    {
        $this->dayValue = $dayValue;

        return $this;
    }

    /**
     * Get the value of currentValue
     */ 
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * Set the value of currentValue
     *
     * @return  self
     */ 
    public function setCurrentValue($currentValue)
    {
        $this->currentValue = $currentValue;

        return $this;
    }
}