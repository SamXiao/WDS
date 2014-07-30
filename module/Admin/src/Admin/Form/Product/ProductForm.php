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
        parent::__construct('product_form');
    }

    public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'product_images',
            'type' => 'Hidden'
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'test'
            ),
            'options' => array(
                'label' => '商品名称'
            )
        ));
        $this->add(array(
            'name' => 'short_desc',
            'type' => 'Text',
            'options' => array(
                'label' => '商品说明'
            )
        ));
        $this->add(array(
            'name' => 'category_id',
            'type' => 'Select',
            'options' => array(
                'label' => '商品类型',
                'value_options' => $this->getCategories()
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

    protected function getServiceLocator()
    {
        return $this->getFormFactory()->getFormElementManager()->getServiceLocator();
    }

    protected function getCategories()
    {
        $table = $this->getServiceLocator()->get('\Admin\Model\Product\CategoryTable');
        $result = $table->fetchAll();
        $categories = array();
        foreach ($result as $category){
            $categories[$category->id] = $category->name;
        }
        return $categories;
    }
}