<?php
namespace app\dao;

use app\model\CategoryModel;
use core\dao\Connection;
use core\dao\IDao;

class CategoryDao implements IDao
{
    /**
     * Persists a model in database
     */
    public function insert(CategoryModel $model = null)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "insert into category (name) values (:name)";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":name", $model->getName());           
            return $stmt->execute();
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    public function update(CategoryModel $model = null)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "update category set name = :name where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $model->getId());
            $stmt->bindValue(":name", $model->getName());           
            return $stmt->execute();
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    public function delete($id)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "delete from category where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    /**
     * This method retrieves a model object from data base 
     * using an 'id' as input parameter.
     */
    public function findById($id)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "select * from category where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($result) {
                $result = $result[0];
                return new CategoryModel(
                    $result['id'],
                    $result['name']                    
                );
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    public function select($criteria = null, $orderBy = 'name', 
        $limit = null, $offSet = null)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "select * from category ";
            if($criteria)
                $sql .= " where $criteria ";
            if($limit)
                $sql .= " limit $limit ";
            if($offSet)
                $sql .= " offset $offSet ";
            $stmt = $connection->prepare($sql);                                             
            $result = $stmt->execute();            
            $result = $stmt->fetchAll();
            if ($result) {
                $list = new \ArrayObject();
                foreach ($result as $row) {
                    $list->append(
                        new CategoryModel(
                            $row['id'],
                            $row['name']
                        )
                    );
                }
                return $list;
            } else {
                return null;
            }
        } catch (\Exception $ex) { 
            throw $ex;
        } finally {
            $connection = null;
         }
    }

    public function selectCount($criteria = null)
    {
        try {
            $conn = Connection::getConnection();
            $sql = "select count(*) from category where $criteria";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();            
            $result = $stmt->fetchAll();
            if ($result)
                return $result[0]['count'];
            else 
                return 0;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
