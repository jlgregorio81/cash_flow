<?php
namespace app\dao;

use app\model\CategoryModel;
use core\dao\Connection;
use core\dao\IDao;
use app\model\FlowModel;

class FlowDao implements IDao
{
    /**
     * Persists a model in database
     */
    public function insert(FlowModel $model = null)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "insert into flow (date, description, type, value, id_category) 
                values (:date, :description, :type, :value, :id_category)";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":date", $model->getdate());
            $stmt->bindValue(":description", $model->getDescription());
            $stmt->bindValue("type", $model->getType());
            $stmt->bindValue(":value", $model->getValue());
            //..Attention! get the id of category!
            $stmt->bindValue(":id_category", $model->getCategory()->getId());
            return $stmt->execute();
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $connection = null;
        }
    }

    public function update(FlowModel $model = null)
    {
        try {
            $connection = Connection::getConnection();
            $sql = "update flow set date = :date, description = :description, type = :type,
                value = :value, id_category = :id_category where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":date", $model->getdate());
            $stmt->bindValue(":description", $model->getDescription());
            $stmt->bindValue("type", $model->getType());
            $stmt->bindValue(":value", $model->getValue());
            $stmt->bindValue(':id',$model->getId());
            //..Attention! get the id of category!
            $stmt->bindValue(":id_category", $model->getCategory()->getId());
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
            $sql = "delete from flow where id = :id";
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
            $sql = "select * from flow where id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($result) {
                $result = $result[0];
                return new FlowModel(
                    $result['id'],
                    $result['date'],
                    $result['description'],
                    $result['type'],
                    $result['value'],
                    //..Attention! Retrive the Category model and associate it!
                    (new CategoryDao())->findById($result['id_category'])
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

    public function select(
        $criteria = null,
        $orderBy = null,
        $limit = null,
        $offSet = null
    ) {
        try {
            $connection = Connection::getConnection();
            $sql = "select * from flow ";
            if ($criteria)
                $sql .= " where $criteria ";
            if ($limit)
                $sql .= " limit $limit ";
            if ($offSet)
                $sql .= " offset $offSet ";
            $stmt = $connection->prepare($sql);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($result) {
                $list = new \ArrayObject();
                foreach ($result as $row) {
                    $list->append(
                        new FlowModel(
                            $row['id'],
                            $row['date'],
                            $row['description'],
                            $row['type'],
                            $row['value'],
                            //..Attention! Retrive the Category model and associate it!
                            (new CategoryDao())->findById($row['id_category'])
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
            $sql = "select count(*) from flow where $criteria";
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

    /**
     * This method is used for return the sum of flows considering the date.
     * @param string $date the reference date
     * @param boolean $previousValue if true, the sum considers the previous flows, else, just the sum of current date flows.
     */
    public function selectSum($date, $previousValue = true)
    {
        try {
            $conn = Connection::getConnection();
            if ($previousValue)
                $sql = "select sum(case when type = 'E' then value * -1 
                    else value end) from flow where date < :date ";
            else
                $sql = "select sum(case when type = 'E' then value * -1 
                    else value end) from flow where date = :date ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':date', $date);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($result)
                return $result[0]['sum'];
            else
                return 0;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Get the sum of flows per month and per type
     * @param integer $currentMonth o mês corrente
     * @param string $type 'E' for 'Expenses', and 'R' to 'Receipts'
     * @return array | null A list of flows or null.
     */
    public function getFlowPerCategory($currentMonth, $type)
    {
        try {
            $conn = Connection::getConnection();
            $sql = "select c.name, sum(f.value) as value from flow f, category c where 
                    c.id = f.id_category and extract(month from date) = :currentMonth
                    and f.type = :type
                    group by 1 order by 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':currentMonth', $currentMonth);
            $stmt->bindValue(':type', strtoupper($type));
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($result)
                return $result;
            else
                return null;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Get the sum of flows
     * @param string $type A = All types; E = sum of expenses; R = sum of receipts
     * @param string $date1 First date of the period
     * @param string $date2 Second date of the period
     * @return float The sum of flows
     */
    public function getFlows($type = 'A', $date1, $date2)
    {
        try {
            $conn = Connection::getConnection();
            $sql = '';
            $stmt = null;
            if ($type == 'A')
                $sql = "select sum(case when type = 'E' then value * -1 
                    else value end) from flow where 1 = 1 ";
            else
                $sql = "select sum(value) from flow where type = '$type' ";
            $sql .= " and date between :date1 and :date2 ";
            $stmt = $conn->prepare($sql);
            if ($type == 'A')
                $stmt->bindValue(':type', $type);
            $stmt->bindValue(':date1', $date1);
            $stmt->bindValue(':date2', $date2);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
            if ($result)
                return $result[0]['sum'];
            else
                return 0;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
