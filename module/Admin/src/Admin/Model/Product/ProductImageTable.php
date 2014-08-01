<?php
namespace Admin\Model\Product;

use SamFramework\Model\AbstractModelMapper;

class ProductImageTable extends AbstractModelMapper
{

    protected $tableName = 'product_image';

    protected $modelClassName = 'Admin\\Model\\Product\\ProductImage';

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
        $tableGateway = $this->getTableGateway();
        return $tableGateway->delete(array(
            'id' => (int) $id
        ));
    }

    public function saveProductImage(ProductImage $productImage)
    {
        $tableGateway = $this->getTableGateway();
        $data = $productImage->getArrayCopy();
        $id = (int) $productImage->id;
        if ($id == 0) {
            $tableGateway->insert($data);
            $productImage->id = $this->getTableGateway()->getLastInsertValue();
        } else {
            if ($this->getProductImage($id)) {
                $tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
        return $productImage;
    }

    public function updateProductId($productId, $images)
    {
        $this->getTableGateway()->update(array(
            'product_id' => $productId
        ), array(
            'id' => $images
        ));
    }

    public function getProductImagesByProductId($productId)
    {
        $tableGateway = $this->getTableGateway();
        $productId = (int) $productId;
        $rowset = $tableGateway->select(array(
            'product_id' => $productId
        ));
        return $rowset;
    }
}

