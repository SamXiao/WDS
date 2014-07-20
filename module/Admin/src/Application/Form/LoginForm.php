<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

use SamFramework\src\Core\AutoBuildInterface;

class LoginForm extends Form implements AutoBuildInterface
{

    /**
    protected $_serviceLocator = NULL;


    protected function getServiceLocator()
    {
        if ( !$this->_serviceLocator ) {
        	$this->_serviceLocator = $this->getFormFactory()->getFormElementManager()->getServiceLocator();
        }
        return $this->_serviceLocator;
    }
    **/

    public static function getInstance( ServiceLocatorInterface $sl){

        return $sl->get('FormElementManager')->get('\Application\Form\LoginForm');
    }

    public function __construct( $name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');

        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'UserName'
            )
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Password'
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton'
            )
        ));
    }

    public function init(){
        $this->add(array(
            'name' => 'submit',
            'type' => 'submitButton',
            'options' => array(
                'label' => 'Submit',
            )
        ));
        $this->add(array(
            'name' => 'cancel',
            'type' => 'cancelButton',
            'options' => array(
                'label' => 'Cancel',
            )
        ));
    }


}