<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModel;

class Category extends AbstractModel
{

    public $id = '';

    public $user_id = '';

    public $title = '';

    public $type = '';

    public $parent_id = '';

    public function exchangeArray(array $array)
    {
        $this->id = (! empty($array['id'])) ? $array['id'] : null;
        $this->user_id = (! empty($array['user_id'])) ? $array['user_id'] : null;
        $this->title = (! empty($array['title'])) ? $array['title'] : null;
        $this->type = (! empty($array['type'])) ? $array['type'] : null;
        $this->parent_id = (! empty($array['parent_id'])) ? $array['parent_id'] : null;
    }

}

