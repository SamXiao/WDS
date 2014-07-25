<?php

namespace Application\Model\Product;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Category implements InputFilterAwareInterface
{

    public $id = '';

    public $cid = '';

    public $name = '';

    public $type = '';

    public $parent_id = '';

    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        throw new \Exception("Not used");
    }

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->cid = (!empty($data['cid'])) ? $data['cid'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
        $this->parent_id = (!empty($data['parent_id'])) ? $data['parent_id'] : null;
    }

    public function toArray()
    {
        $data = array();
        (!empty($this->id)) ? $data['id'] = $this->id : null;
        (!empty($this->cid)) ? $data['cid'] = $this->cid : null;
        (!empty($this->name)) ? $data['name'] = $this->name : null;
        (!empty($this->type)) ? $data['type'] = $this->type : null;
        (!empty($this->parent_id)) ? $data['parent_id'] = $this->parent_id : null;
        return $data;
    }


}

