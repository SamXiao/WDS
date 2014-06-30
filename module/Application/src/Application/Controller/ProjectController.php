<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\ProjectForm;
use Application\Model\Project;

class ProjectController extends AbstractActionController
{

    protected $projectTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'projects' => $this->getProjectTable()->fetchAll()
        ));
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
        return array(
            'form' => $form
        );
    }

    public function editAction()
    {}

    public function deleteAction()
    {}

    public function getProjectTable()
    {
        if (! $this->projectTable) {
            $this->projectTable = $this->getServiceLocator()->get('Model\ProjectTable');
        }

        return $this->projectTable;
    }
}
