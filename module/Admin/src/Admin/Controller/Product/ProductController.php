<?php
namespace Admin\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Product\Product;
use Admin\Form\Product\ProductForm;

class ProductController extends AbstractActionController
{

    protected $projectTable;

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
            $album = new Product();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->getProjectTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
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

    public function getProductTable()
    {
        if (! $this->projectTable) {
            $this->projectTable = $this->getServiceLocator()->get('\Admin\Model\Product\ProductTable');
        }

        return $this->projectTable;
    }
}
