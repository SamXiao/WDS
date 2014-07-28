<?php
namespace Admin\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Product\Product;
use Admin\Form\Product\ProductForm;
use Admin\Model\Product\ProductImage;

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
                $this->getProductTable()->saveProduct($product);

                // TODO add redirect
                // TODO add flash message

                // // Redirect to list of albums
                // return $this->redirect()->toRoute('album');
            }
        }

        $viewModel = new ViewModel(array(
            'form' => $form
        ));
        return $viewModel;
    }

    public function editAction()
    {}

    public function deleteAction()
    {}

    public function uploadImageAction()
    {
        $config = $this->getServiceLocator()->get('config');
        print_r($_FILES);exit();
        $file = $_FILES['file'];

        $desFileName = $config->params->uploadPath . $file["name"];
        if (move_uploaded_file($file["tmp_name"], $desFileName)) {
            $image = new ProductImage();
            $image->file_path = $desFileName;
            $image->name = $file["name"];
            $image->product_id = 0;
            $table = $this->getProductImageTable();
            $table->saveProductImage($image);
        } else {
            throw new \Exception('Upload Failed');
        }

        exit();
    }

    public function removeImageAction()
    {
        return false;
    }
}
