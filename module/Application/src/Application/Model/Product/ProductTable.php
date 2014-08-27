<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModelMapper;
use Application\Model\Product\Product;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class ProductTable extends AbstractModelMapper
{
    public $currentUserId = 0;

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

    public function buildSqlSelect(Select $select){
        $select->join('category', 'category.id=category_id', array(
            'category_name' => 'title'
        ));
        $select->join('product_image', new Expression("product.id=product_id and is_default=1"), array(
            'product_thumbnail' => 'thumbnail_uri'
        ), Select::JOIN_LEFT);
        $select->where('product.id!=0');
        if($this->currentUserId){
            $select->where('product.user_id='.$this->currentUserId);
        }
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
                'title',
                'price',
                'unit',
                'recommend'
            ));
            $table->buildSqlSelect($select);
            $select->offset($offset)
                ->limit($limit);
        });
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
            $arrProductImages[] = $productImage;
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
        $product->user_id = $this->currentUserId;
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

    public function getProductsByCategory(Category $category)
    {
        $resultSet = $this->getTableGateway()->select(array(
            'category_id' => $category->id,
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

    public function getRecommendedProducts()
    {
        $resultSet = $this->getTableGateway()->select(array(
            'recommend' => 1,
            'enable' => 1,
            'user_id' => $this->currentUserId
        ));
        return $resultSet;
    }
}

