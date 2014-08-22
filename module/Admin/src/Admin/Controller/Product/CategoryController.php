<?php
namespace Admin\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Product\Product;
use Admin\Form\Product\ProductForm;
use Application\Model\Product\ProductImage;
use Zend\View\Model\JsonModel;
use Zend\Filter\File\RenameUpload;
use PHPThumb\GD;
use Components\Layout\View\Model\FlashMessagerModel;
use Zend\Barcode\Barcode;

class CategoryController extends AbstractActionController
{

    protected $categoryTable;


    public function getCategoryTable()
    {
        if (! $this->categoryTable) {
            $this->categoryTable = $this->getServiceLocator()->get('Application\Model\Product\CategoryTable');
        }

        return $this->categoryTable;
    }


    public function indexAction()
    {
        $viewModel = new ViewModel(array(
            'products' => $this->getCategoryTable()->fetchAll()
        ));
        return $viewModel;
    }

    public function getCategoriesListDataAction()
    {
        $count = $this->getCategoryTable()->getFetchAllCounts();
        $categories = $this->getCategoryTable()->fetchAll($_GET['start'], $_GET['length']);
        $listData = array(
            'draw' => $_GET['draw'] ++,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => array()
        );
        foreach ($categories as $category) {
            $listData['data'][] = array(
                'DT_RowId' => $category->id,
                'title' => $category->title,
            );
        }
        $viewModel = new JsonModel($listData);
        return $viewModel;
    }

    public function addAction()
    {
        $form = ProductForm::getInstance($this->getServiceLocator());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $product = new Product();
            $form->setInputFilter($product->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $product->exchangeArray($form->getData());
                $productTable = $this->getProductTable();
                $product = $productTable->saveProduct($product);
                $this->flashMessenger()->addSuccessMessage($product->title . ' 已添加');
                return $this->redirect()->toUrl('/product/product');
            }
        }

        return array(
            'form' => $form
        );
    }

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        if (! $id) {
            return $this->redirect()->toUrl('/product/product/add');
        }
        try {
            $product = $this->getProductTable()->getProduct($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toUrl('/product/product');
        }

        $form = ProductForm::getInstance($this->getServiceLocator());
        $form->bind($product);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($product->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $productTable = $this->getProductTable();
                $product = $productTable->saveProduct($product);
                $this->flashMessenger()->addSuccessMessage($product->title . ' 已编辑');
                return $this->redirect()->toUrl('/product/product');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function deleteAction()
    {
        print_r(realpath('.'));
        exit();
    }






}
