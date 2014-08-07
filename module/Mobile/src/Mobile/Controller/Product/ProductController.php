<?php
namespace Mobile\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;

class ProductController extends AbstractActionController
{

    protected $projectTable;

    protected $projectImageTable;

    public function getProductTable()
    {
        if (! $this->projectTable) {
            $this->projectTable = $this->getServiceLocator()->get('Application\Model\Product\ProductTable');
        }

        return $this->projectTable;
    }

    public function getProductImageTable()
    {
        if (! $this->projectImageTable) {
            $this->projectImageTable = $this->getServiceLocator()->get('Admin\Model\Product\ProductImageTable');
        }

        return $this->projectImageTable;
    }

    public function listAction()
    {
        $category_id = $this->params('identity');
        return array(
            'products' => $this->getProductTable()->getProductsByCategory($category_id)
        );
    }

    public function singleAction()
    {
        $identity = $this->params('identity');
    }
}
