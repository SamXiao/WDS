<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class Category extends AbstractModel
{

    public $id = 0;

    public $user_id = 1;

    public $title = '';

    public $type = 'custome';

    public $parent_id = 0;

    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function exchangeArray(array $array)
    {
        $this->id = (isset($array['id'])) ? $array['id'] : $this->id;
        $this->user_id = (isset($array['user_id'])) ? $array['user_id'] : $this->user_id;
        $this->title = (isset($array['title'])) ? $array['title'] : $this->title;
        $this->type = (isset($array['type'])) ? $array['type'] : $this->type;
        $this->parent_id = (isset($array['parent_id'])) ? $array['parent_id'] : $this->parent_id;
    }

    public function getArrayCopy()
    {
        $data = array(
            'id' => $this->id,
            'title' => $this->title,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'parent_id' => $this->parent_id
        );
        return $data;
    }
}

