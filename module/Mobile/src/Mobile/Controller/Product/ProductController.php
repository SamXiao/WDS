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
        $categoryId = $this->params('categoryId');

        $category = $this->getCategoryTable()->getCategory( $categoryId );

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
        $category = $this->getCategoryTable()->getCategory( $product->category_id );
        return array(
            'product' => $product,
            'category' => $category,
        );
    }
}
