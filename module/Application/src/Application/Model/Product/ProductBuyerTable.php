<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModelMapper;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class ProductBuyerTable extends AbstractModelMapper
{

    public $productId = 0;

    protected $tableName = 'product_buyer';

    protected $modelClassName = 'Application\\Model\\Product\\ProductBuyer';

    public function buildSqlSelect(Select $select){
        $select->join('buyer', 'buyer.id=buyer_id', array(
            'buyer_weixin' => 'weixin'
        ));
        $select->where(array('product_id'=>$this->productId));
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

    public function fetchAll($offset = 0, $limit = 1000)
    {
        $offset = (int)$offset;
        $limit = (int)$limit;

        $table = $this;
        $resultSet = $this->getTableGateway()->select(function (Select $select) use($offset, $limit, $table)
        {
            $table->buildSqlSelect($select);
            $select->offset($offset)
                ->limit($limit);
        });
        return $resultSet;
    }


    public function getProductBuyer($id)
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

    public function deleteProductBuyer($id)
    {
        $this->tableGateway->delete(array(
            'id' => (int) $id
        ));
    }

    public function saveProductBuyer(ProductBuyer $category)
    {
        $tableGateway = $this->getTableGateway();
        $category->user_id = $this->currentUserId;
        $data = $category->getArrayCopyForSave();
        $id = (int) $category->id;
        if ($id == 0) {
            $tableGateway->insert($data);
            $category->id = $this->getTableGateway()->getLastInsertValue();
        } else {
            if ($this->getCategory($id)) {
                $tableGateway->update($data, array(
                    'id' => $id
                ));
            }
        }
        return $category;
    }
}

