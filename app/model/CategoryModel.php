<?php
namespace app\model;

use core\mvc\Model;

final class CategoryModel extends Model {

    private $name;

    public function __construct($id=null, $name=null)
    {
        parent::__construct($id);
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}