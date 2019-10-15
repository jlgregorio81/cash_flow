<?php
namespace core\dao;

use core\mvc\Model;

interface IDao
{    
    public function insert();
    public function update();
    public function delete($id);
    public function findById($id);
    public function select();
    public function selectCount($criteria = null);    
}
