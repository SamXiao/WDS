<?php
namespace Admin\Model\Product;

use SamFramework\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class Product extends AbstractModel
{

    public $id = 0;

    public $name = '';

    public $short_desc = '';

    public $cid = 0;

    public $category_id = '';

    public $create_time = '';

    public $update_time = '';

    public $product_images = array();

    protected $category = NULL;

    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'name',
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

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : $this->id;
        $this->name = (isset($data['name'])) ? $data['name'] : $this->name;
        $this->short_desc = (isset($data['short_desc'])) ? $data['short_desc'] : $this->short_desc;
        $this->cid = (isset($data['cid'])) ? $data['cid'] : $this->cid;
        $this->category_id = (isset($data['category_id'])) ? $data['category_id'] : $this->category_id;
        $this->create_time = (isset($data['create_time'])) ? $data['create_time'] : $this->create_time;
        $this->update_time = (isset($data['update_time'])) ? $data['update_time'] : $this->update_time;
        $this->product_images = (isset($data['product_images'])) ? $data['product_images'] : $this->product_images;
    }

    public function toArray()
    {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'short_desc' => $this->short_desc,
            'cid' => $this->cid,
            'category_id' => $this->category_id,
        );
        return $data;
    }

    public function getCategory()
    {
        if (! $this->category) {
            $categoryTable = new CategoryTable();
            $this->category = $categoryTable->getCategory($this->category_id);
        }
        return $this->category;
    }

    public function getDefaultImage()
    {}
}

