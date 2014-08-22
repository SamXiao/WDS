<?php
namespace Admin\Form\Product;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class CategoryForm extends Form
{

    public static function getInstance( ServiceLocatorInterface $sl){
        return $sl->get('FormElementManager')->get('\Admin\Form\Product\CategoryForm');
    }

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('category_form');
    }

    public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'test'
            ),
            'options' => array(
                'label' => '商品类别名称'
            )
        ));
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