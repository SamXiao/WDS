<?php
namespace Admin\Model\Product;

use SamFramework\Model\AbstractModelMapper;

class ProductTable extends AbstractModelMapper
{

    protected $tableName = 'product';

    protected $modelClassName = 'Admin\\Model\\Product\\Product';

    public function fetchAll()
    {
        $resultSet = $this->getTableGateway()->select();
        return $resultSet;
    }

    public function getProduct()
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

        //Get Product Images
        $productImageTable = $this->getServiceLocator()->get('Admin\Model\Product\ProductImageTable');
        $rowset = $productImageTable->getProductImagesByProductId($id);
        foreach ($rowset as $productImage){
            $row->product_images[] = $productImage->id;
        }
        return $row;
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id
        ));
    }

    public function saveProduct(Product $product)
    {
        $tableGateway = $this->getTableGateway();
        $data = $product->toArray();
        $id = (int) $product->id;
        if ($id == 0) {
            $tableGateway->insert($data);
            $product->id = $this->getTableGateway()->getLastInsertValue();
        } else {
            $product->update_time = time();
            if ($this->getProduct($id)) {
                $tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
        return $product;
    }
}

