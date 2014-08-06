<?php
namespace Components\Form\Element;

use Zend\Form\Element\Text as ZFEText;

class Text extends ZFEText
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'type' => 'text',
        'class' => 'col-xs-10 col-sm-5'
    );
}

