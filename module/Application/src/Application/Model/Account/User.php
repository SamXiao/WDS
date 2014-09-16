<?php
namespace Application\Model\Account;

use SamFramework\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class User extends AbstractModel
{

    public $id = 0;

    public $title = '';

    public $weixin = '';



    public function exchangeArray(array $array)
    {
        $this->id = (isset($array['id'])) ? $array['id'] : $this->id;
        $this->title = (isset($array['title'])) ? $array['title'] : $this->title;
        $this->weixin = (isset($array['weixin'])) ? $array['weixin'] : $this->weixin;
    }

    public function getArrayCopy()
    {
        $data = array(
            'id' => $this->id,
            'title' => $this->title,
            'weixin' => $this->weixin,
        );
        return $data;
    }

    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'weixin',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

