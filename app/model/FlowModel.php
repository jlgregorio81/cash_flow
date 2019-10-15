<?php
namespace app\model;

use core\mvc\Model;

final class FlowModel extends Model {

    private $date;
    private $description;
    private $type;
    private $value;
    private $category;

    public function __construct($id = null, $date = null, 
        $description = null, $type = null, $value = null,
        CategoryModel $category = null)
    {
        parent::__construct($id);
        $this->date = $date;
        $this->description = $description;
        $this->type = $type;
        $this->value = $value;
        $this->category = is_null($category) ? new CategoryModel() : $category;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory(CategoryModel $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getCategoryAsString(){
        return $this->category->getName();
    }
}