<?php
namespace Admin\Model\Product;

use SamFramework\Model\AbstractModel;

class Category extends AbstractModel
{

    public $id = '';

    public $cid = '';

    public $name = '';

    public $type = '';

    public $parent_id = '';

    public function exchangeArray(array $array)
    {
        $this->id = (! empty($data['id'])) ? $data['id'] : null;
        $this->cid = (! empty($data['cid'])) ? $data['cid'] : null;
        $this->name = (! empty($data['name'])) ? $data['name'] : null;
        $this->type = (! empty($data['type'])) ? $data['type'] : null;
        $this->parent_id = (! empty($data['parent_id'])) ? $data['parent_id'] : null;
    }
}

