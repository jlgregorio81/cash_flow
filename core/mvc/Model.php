<?php
namespace core\mvc;

abstract class Model{

    protected $id;

    public function __construct($id=null){
        $this->id = $id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

}