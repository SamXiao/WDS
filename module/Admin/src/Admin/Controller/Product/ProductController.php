<?php
namespace Admin\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Product\Product;
use Admin\Form\Product\ProductForm;
use Admin\Model\Product\ProductImage;
use Zend\View\Model\JsonModel;
use Zend\Filter\File\RenameUpload;
use PHPThumb\GD;

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
        print_r(realpath('.'));
        exit();
    }

    public function uploadImageAction()
    {
        $config = $this->getServiceLocator()->get('config');
        $file = $this->getRequest()->getFiles('file');
        $product_id = (int) $this->params()->fromPost('product_id', 0);

        if ($file) {
            $desFileName = './public' . $config['system_params']['upload']['upload_file_path'] . '/product.jpg';
            $filter = new RenameUpload(array(
                'target' => $desFileName,
                'randomize' => true,
                'use_upload_extension' => true
            ));
            $result = $filter->filter($file);

            $uploadedImageInfo = pathinfo($result['tmp_name']);
            $imageUri = $config['system_params']['upload']['hostname'] . $config['system_params']['upload']['upload_file_path'] . '/' . $uploadedImageInfo['basename'];
            $thumbImageFileName = $uploadedImageInfo['filename'] . '_thumb.' . $uploadedImageInfo['extension'];
            $thumbImagePath = $uploadedImageInfo['dirname'] . '/' . $thumbImageFileName;
            $thumbImageUri = $config['system_params']['upload']['hostname'] . $config['system_params']['upload']['upload_file_path'] . '/' . $thumbImageFileName;

            $phpThumb = new GD($result['tmp_name']);
            $phpThumb->adaptiveResize(100, 100);
            $phpThumb->save($thumbImagePath);

            $productImage = new ProductImage();
            $productImage->file_path = $result['tmp_name'];
            $productImage->uri = $imageUri;
            $productImage->thumbnail_uri = $thumbImageUri;
            $productImage->name = $file["name"];
            $productImage->product_id = $product_id;
            $table = $this->getProductImageTable();
            $productImage = $table->saveProductImage($productImage);
        }

        return new JsonModel($productImage->getArrayCopy());
    }

    public function removeImageAction()
    {
        $id = (int) $this->params()->fromPost('id', 0);
        $table = $this->getProductImageTable();
        $result = $table->deleteProductImage($id);
        return new JsonModel(array(
            $result
        ));
    }
}
