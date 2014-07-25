<?php

namespace Application\Model;

class Project
{

    public $id = '';

    public $name = '';

    public $description = '';

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->description = (!empty($data['description'])) ? $data['description'] : null;
    }

    public function toArray($data)
    {
        $data = array();
        (!empty($this->id)) ? $data['id'] = $this->id : null;
        (!empty($this->name)) ? $data['name'] = $this->name : null;
        (!empty($this->description)) ? $data['description'] = $this->description : null;
        return $data;
    }


}

