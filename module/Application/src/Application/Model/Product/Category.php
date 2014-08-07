<?php
namespace Application\Model\Product;

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
        $this->id = (! empty($array['id'])) ? $array['id'] : null;
        $this->cid = (! empty($array['cid'])) ? $array['cid'] : null;
        $this->name = (! empty($array['name'])) ? $array['name'] : null;
        $this->type = (! empty($array['type'])) ? $array['type'] : null;
        $this->parent_id = (! empty($array['parent_id'])) ? $array['parent_id'] : null;
    }

}

