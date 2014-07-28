<?php

namespace Admin\Model\Product;

use SamFramework\Model\AbstractModel;

class ProductImage extends AbstractModel
{

    public $id = '';

    public $name = '';

    public $product_id = '';

    public $file_path = '';

    public $uri = '';

    public $thumbnail_uri = '';

    public $is_default = '';


    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
        $this->file_path = (!empty($data['file_path'])) ? $data['file_path'] : null;
        $this->uri = (!empty($data['uri'])) ? $data['uri'] : null;
        $this->thumbnail_uri = (!empty($data['thumbnail_uri'])) ? $data['thumbnail_uri'] : null;
        $this->is_default = (!empty($data['is_default'])) ? $data['is_default'] : null;
    }

    public function toArray()
    {
        $data = array();
        (!empty($this->id)) ? $data['id'] = $this->id : null;
        (!empty($this->name)) ? $data['name'] = $this->name : null;
        (!empty($this->product_id)) ? $data['product_id'] = $this->product_id : null;
        (!empty($this->file_path)) ? $data['file_path'] = $this->file_path : null;
        (!empty($this->uri)) ? $data['uri'] = $this->uri : null;
        (!empty($this->thumbnail_uri)) ? $data['thumbnail_uri'] = $this->thumbnail_uri : null;
        (!empty($this->is_default)) ? $data['is_default'] = $this->is_default : null;
        return $data;
    }


}

