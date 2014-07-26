<?php
namespace Admin\Model\Product;

use SamFramework\Model\AbstractModelMapper;

class ProductImageTable extends AbstractModelMapper
{

    protected $tableName = 'product_image';

    protected $modelClassName = 'Admin\\Model\\Product\\Product';

    public function fetchAll()
    {
        $resultSet = $this->getTableGateway()->select();
        return $resultSet;
    }

    public function getProductImage()
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

    public function deleteProductImage($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id
        ));
    }

    public function saveProductImage(Product $product)
    {
        $tableGateway = $this->getTableGateway();
        $data = $product->toArray();
        $id = (int) $product->id;
        if ($id == 0) {
            $tableGateway->insert($data);
        } else {
            if ($this->getProduct($id)) {
                $tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
    }
}

