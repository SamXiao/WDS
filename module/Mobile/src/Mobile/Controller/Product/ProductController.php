<?php
namespace Mobile\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;

class ProductController extends AbstractActionController
{

    protected $projectTable;

    protected $categoryTable;

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

    public function listAction()
    {
        $category_id = $this->params('identity');

        $category = $this->getCategoryTable()->getCategory( $category_id );

        return array(
            'category' => $category,
            'products' => $this->getProductTable()->getProductsByCategory($category)
        );
    }

    public function singleAction()
    {
        $identity = $this->params('identity');
        $productTable = $this->getProductTable();

        $product = $productTable->getProduct($identity);
        $category = $this->getCategoryTable()->getCategory( $product->category_id );
        return array(
            'product' => $product,
            'category' => $category,
        );
    }
}
