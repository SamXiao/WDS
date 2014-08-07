<?php
namespace Application\Model\Product;

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

    public $product_images = '';

    protected $category = NULL;

    protected $exclude = array( 'product_images' );

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

    public function exchangeArray(array $array)
    {
        $this->id = (isset($array['id'])) ? $array['id'] : $this->id;
        $this->name = (isset($array['name'])) ? $array['name'] : $this->name;
        $this->short_desc = (isset($array['short_desc'])) ? $array['short_desc'] : $this->short_desc;
        $this->cid = (isset($array['cid'])) ? $array['cid'] : $this->cid;
        $this->category_id = (isset($array['category_id'])) ? $array['category_id'] : $this->category_id;
        $this->create_time = (isset($array['create_time'])) ? $array['create_time'] : $this->create_time;
        $this->update_time = (isset($array['update_time'])) ? $array['update_time'] : $this->update_time;
        $this->product_images = (isset($array['product_images'])) ? $array['product_images'] : $this->product_images;
    }

    public function getArrayCopy()
    {
        $data = array(
            'id' => $this->id,
            'name' => $this->name,
            'short_desc' => $this->short_desc,
            'cid' => $this->cid,
            'category_id' => $this->category_id,
            'update_time' => $this->update_time,
            'product_images' => $this->product_images
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

