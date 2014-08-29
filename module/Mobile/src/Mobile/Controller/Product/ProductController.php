<?php
namespace Mobile\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Mobile\Form\BuyerForm;
use Application\Model\Buyer;
use Application\Model\Product\ProductBuyer;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class ProductController extends AbstractActionController
{

    protected $projectTable;

    protected $categoryTable;

    protected $buyerTable;

    protected $productBuyerTable;

    public function getProductTable()
    {
        if (! $this->projectTable) {
            $this->projectTable = $this->getServiceLocator()->get('Application\Model\Product\ProductTable');
        }

        return $this->projectTable;
    }

    public function getCategoryTable()
    {
        if (! $this->categoryTable) {
            $this->categoryTable = $this->getServiceLocator()->get('Application\Model\Product\CategoryTable');
        }

        return $this->categoryTable;
    }

    public function getProductBuyerTable()
    {
        if (! $this->productBuyerTable) {
            $this->productBuyerTable = $this->getServiceLocator()->get('Application\Model\Product\ProductBuyerTable');
        }

        return $this->productBuyerTable;
    }

    public function getBuyerTable()
    {
        if (! $this->buyerTable) {
            $this->buyerTable = $this->getServiceLocator()->get('Application\Model\BuyerTable');
        }

        return $this->buyerTable;
    }

    public function listAction()
    {
        $categoryId = $this->params('categoryId');

        $category = $this->getCategoryTable()->getCategory($categoryId);

        return array(
            'category' => $category,
            'products' => $this->getProductTable()->getProductsByCategory($category)
        );
    }

    public function singleAction()
    {
        $productId = $this->params('productId');
        $productTable = $this->getProductTable();

        $product = $productTable->getProduct($productId);
        $category = $this->getCategoryTable()->getCategory($product->category_id);
        $flashMessage = $this->flashMessenger()->getMessagesFromNamespace(FlashMessenger::NAMESPACE_INFO);
        return array(
            'product' => $product,
            'category' => $category,
            'flashMessage' => $flashMessage
        );
    }

    public function buyAction()
    {
        $productId = $this->params('productId');
        $productTable = $this->getProductTable();

        $form = BuyerForm::getInstance($this->getServiceLocator());
        $request = $this->getRequest();
        if ($request->isPost()) {
            $buyer = new Buyer();
            $form->setInputFilter($buyer->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $buyer->exchangeArray($form->getData());
                $buyerTable = $this->getBuyerTable();
                try {
                    $buyer = $buyerTable->getBuyerByWeixin($buyer->weixin);
                } catch (\Exception $e) {
                    $buyer = $buyerTable->saveBuyer($buyer);
                }

                $productBuyerTable = $this->getProductBuyerTable();
                $order = new ProductBuyer();
                $order->buyer_id = $buyer->id;
                $order->product_id = $productId;
                $order = $productBuyerTable->saveOrder($order);
                $this->flashMessenger()->addInfoMessage('您已成功订购商品，我们将在商品到货后及时与您联系');
                return $this->redirect()->toUrl('/p/' . $productId);
            }
        }

        $product = $productTable->getProduct($productId);
        $category = $this->getCategoryTable()->getCategory($product->category_id);
        return array(
            'product' => $product,
            'category' => $category
        );
    }
}
