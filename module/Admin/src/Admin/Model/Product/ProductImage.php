<?php

namespace Admin\Model\Product;

use SamFramework\Model\AbstractModel;

class ProductImage extends AbstractModel
{

    public $id = 0;

    public $name = '';

    public $product_id = 0;

    public $file_path = '';

    public $uri = '';

    public $thumbnail_uri = '';

    public $is_default = 0;


    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->product_id = (isset($data['product_id'])) ? $data['product_id'] : null;
        $this->file_path = (isset($data['file_path'])) ? $data['file_path'] : null;
        $this->uri = (isset($data['uri'])) ? $data['uri'] : null;
        $this->thumbnail_uri = (isset($data['thumbnail_uri'])) ? $data['thumbnail_uri'] : null;
        $this->is_default = (isset($data['is_default'])) ? $data['is_default'] : null;
    }

    public function toArray()
    {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'product_id' => $this->product_id,
            'file_path' => $this->file_path,
            'uri' => $this->uri,
            'thumbnail_uri' => $this->thumbnail_uri,
            'is_default' => $this->is_default,
        );
        return $data;
    }


}

