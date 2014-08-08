<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModelMapper;
use Application\Model\Product\Product;

class ProductTable extends AbstractModelMapper
{

    protected $tableName = 'product';

    protected $projectImageTable;

    protected $modelClassName = 'Application\\Model\\Product\\Product';

    public function getProductImageTable()
    {
        if (! $this->projectImageTable) {
            $this->projectImageTable = $this->getServiceLocator()->get('Application\Model\Product\ProductImageTable');
        }

        return $this->projectImageTable;
    }

    public function fetchAll()
    {
        $resultSet = $this->getTableGateway()->select();
        return $resultSet;
    }

    public function getProduct($id)
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

        // Get Product Images
        $productImageTable = $this->getProductImageTable();
        $rowset = $productImageTable->getProductImagesByProductId($id);
        $arrProductImages = array();
        foreach ($rowset as $productImage) {
            $arrProductImages[] = $productImage->getArrayCopy();
        }
        $row->product_images = $arrProductImages;
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
        $product->update_time = date('YmdHis');
        $data = $product->getArrayCopyForSave();
        $id = (int) $product->id;
        if ($id == 0) {
            $tableGateway->insert($data);
            $product->id = $this->getTableGateway()->getLastInsertValue();

            $productImageTable = $this->getProductImageTable();
            $productImageTable->updateProductId($product->id, $product->product_images);
        } else {
            if ($this->getProduct($id)) {
                $tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }


        return $product;
    }

    public function getProductsByCategory($categoryId)
    {
        $resultSet = $this->getTableGateway()->select(array(
            'category_id' => $categoryId,
            'enable' => 1
        ));
        return $resultSet;
    }

    public function getDefaultImageForProduct(Product $product)
    {
        $productImageTable = $this->getProductImageTable();
        $defaultImage = $productImageTable->getDefaultImage($product->id);
        $product->product_thumbnail = $defaultImage->thumbnail_uri;
    }
}

