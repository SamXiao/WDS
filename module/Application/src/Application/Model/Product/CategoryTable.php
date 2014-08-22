<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModelMapper;
use Zend\Db\Sql\Select;

class CategoryTable extends AbstractModelMapper
{

    protected $tableName = 'category';

    protected $modelClassName = 'Application\\Model\\Product\\Category';

    public function buildSqlSelect(Select $select){
    }

    public function getFetchAllCounts()
    {
        $select = $this->getTableGateway()->getSql()->select();
        $this->buildSqlSelect($select);
        $select->columns(array('id'));
        $statement = $this->getTableGateway()->getSql()->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results->count();
    }

    public function fetchAll($offset = 0, $limit = 10)
    {
        $offset = (int)$offset;
        $limit = (int)$limit;

        $table = $this;
        $resultSet = $this->getTableGateway()->select(function (Select $select) use($offset, $limit, $table)
        {
            $select->columns(array(
                'id',
                'title'
            ));
            $table->buildSqlSelect($select);
            $select->offset($offset)
                ->limit($limit);
        });
        return $resultSet;
    }


    public function getCategory($id)
    {
        $tableGateway = $this->getTableGateway();
        $id = (int) $id;
        $rowset = $tableGateway->select(array(
            'id' => $id
        ));
        $row = $rowset->current();
        if (! $row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function deleteCategory($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id
        ));
    }

    public function saveCategory(Category $category)
    {
        $tableGateway = $this->getTableGateway();
        $data = $category->toArray();
        $id = (int) $category->id;
        if ($id == 0) {
            $tableGateway->insert($data);
        } else {
            if ($this->getCategory($id)) {
                $tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
    }
}

