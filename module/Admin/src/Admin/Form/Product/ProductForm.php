<?php
namespace Admin\Form\Product;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProductForm extends Form
{

    public static function getInstance( ServiceLocatorInterface $sl){
        return $sl->get('FormElementManager')->get('\Admin\Form\Product\ProductForm');
    }

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('product');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden'
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'test'
            ),
            'options' => array(
                'label' => 'Title'
            )
        ));
        $this->add(array(
            'name' => 'description',
            'type' => 'Text',
            'options' => array(
                'label' => 'Artist'
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