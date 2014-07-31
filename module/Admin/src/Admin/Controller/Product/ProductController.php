<?php
namespace Admin\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Product\Product;
use Admin\Form\Product\ProductForm;
use Admin\Model\Product\ProductImage;
use Zend\View\Model\JsonModel;

class ProductController extends AbstractActionController
{

    protected $projectTable;

    protected $projectImageTable;

    public function getProductTable()
    {
        if (! $this->projectTable) {
            $this->projectTable = $this->getServiceLocator()->get('Admin\Model\Product\ProductTable');
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

    public function indexAction()
    {
        $viewModel = new ViewModel(array(
            'products' => $this->getProductTable()->fetchAll()
        ));
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

                $productImageTable = $this->getProductImageTable();
                $productImageTable->updateProductId($product->id, $product->product_images);
                // TODO add redirect
                // TODO add flash message

                // // Redirect to list of albums
                // return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'form' => $form
        );
    }

    public function editAction()
    {
        $id = (int) $this->params('id', 0);
        if (!$id) {
            return $this->redirect()->toUrl('/product/product/add');
        }
        try {
            $product = $this->getProductTable()->getProduct($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toUrl('/product/product');
        }

        $form = ProductForm::getInstance($this->getServiceLocator());
        $form->bind($product);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($product->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $product->exchangeArray($form->getData());
                $productTable = $this->getProductTable();
                $product = $productTable->saveProduct($product);


                // TODO add redirect
                // TODO add flash message

                // // Redirect to list of albums
                return $this->redirect()->toUrl('/product/product');
            }
        }

        return array(
            'form' => $form
        );
    }

    public function deleteAction()
    {
    	print_r(realpath('.'));exit();
    }

    public function uploadImageAction()
    {
        $config = $this->getServiceLocator()->get('config');
        $file = $this->getRequest()->getFiles('file');

        print_r($this->url());exit();
        if ($file) {
            $desFileName = $config['system_params']['upload_path'] . DIRECTORY_SEPARATOR . $file["name"];
            if (move_uploaded_file($file["tmp_name"], $desFileName)) {
                $image = new ProductImage();
                $image->file_path = $desFileName;
                $image->uri = $this->url();
                $image->name = $file["name"];
                $image->product_id = 0;
                $table = $this->getProductImageTable();
                $image = $table->saveProductImage($image);
            } else {
                throw new \Exception('Upload Failed');
            }
        }

        return new JsonModel($image->toArray());
    }

    public function removeImageAction()
    {
        return false;
    }
}
