<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModelMapper;

class CategoryTable extends AbstractModelMapper
{

    protected $tableName = 'category';

    protected $modelClassName = 'Application\\Model\\Product\\Category';

    public function fetchAll()
    {
        $resultSet = $this->getTableGateway()->select();
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

