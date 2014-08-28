<?php
namespace Admin\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ProfileController extends AbstractActionController
{

    protected $productTable;

    protected $productBuyerTable;

    public function getProductTable()
    {
        if (! $this->productTable) {
            $this->productTable = $this->getServiceLocator()->get('Application\Model\Product\ProductTable');
            $this->productTable->currentUserId = $this->identity()->id;
        }
        return $this->productTable;
    }

    public function getProductBuyerTable()
    {
        if (! $this->productBuyerTable) {
            $this->productBuyerTable = $this->getServiceLocator()->get('Application\Model\Product\ProductBuyerTable');
        }

        return $this->productBuyerTable;
    }

    public function indexAction()
    {
        $id = (int) $this->params('id');
        if ($id > 0) {} else {
            throw new \Exception('参数不正确', 500);
        }

        $product = $this->getProductTable()->getProduct($id);
        $buyer = $this->getProductBuyerTable()->fetchAll();

        $viewModel = new ViewModel(array(
            'product' => $product
        ));
        return $viewModel;
    }

    public function getBuyerDataAction()
    {
        $count = $this->getProductBuyerTable()->getFetchAllCounts();
        $buyers = $this->getProductBuyerTable()->fetchAll($_GET['start'], $_GET['length']);
        $listData = array(
            'draw' => $_GET['draw'] ++,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => array()
        );
        foreach ($buyers as $buyer) {
            $listData['data'][] = array(
                'DT_RowId' => $buyer->id,
                'buyer_weixin' => $buyer->$buyer_weixin,
                'quantity' => $buyer->quantity,
            );
        }
        $viewModel = new JsonModel($listData);
        return $viewModel;
    }
}
