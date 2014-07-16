<?php
namespace Application\Controller\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\ProjectForm;
use Application\Model\Project;

class ProductController extends AbstractActionController
{

    protected $projectTable;

    public function indexAction()
    {

        $viewModel = new ViewModel(array(
            'products' => $this->getProductTable()->fetchAll()
        ));
        $viewModel->setTemplate( 'Application/Product/product/index');
        return $viewModel;
    }

    public function addAction()
    {
        $form = ProjectForm::getInstance( $this->getServiceLocator() );
//         $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Project();
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
        $viewModel->setTemplate( 'Application/Product/product/index');
        return $viewModel;
    }

    public function editAction()
    {}

    public function deleteAction()
    {}

    public function getProductTable()
    {
        if (! $this->projectTable) {
            $this->projectTable = $this->getServiceLocator()->get('\Application\Model\Product\ProductTable');
        }

        return $this->projectTable;
    }
}
