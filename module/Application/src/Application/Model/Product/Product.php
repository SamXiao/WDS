<?php
namespace Application\Model\Product;

use SamFramework\Model\AbstractModel;
use Zend\InputFilter\InputFilter;

class Product extends AbstractModel
{

    public $id = 0;

    public $title = '';

    public $short_desc = '';

    public $cid = 0;

    public $category_id = '';

    public $create_time = '';

    public $update_time = '';

    public $price = '';

    public $unit = '';

    public $product_images = '';

    protected $productThumbnail = '';

    protected $category = NULL;

    protected $exclude = array( 'product_images', 'product_thumbnail' );

    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'title',
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
        $this->title = (isset($array['title'])) ? $array['title'] : $this->title;
        $this->short_desc = (isset($array['short_desc'])) ? $array['short_desc'] : $this->short_desc;
        $this->cid = (isset($array['cid'])) ? $array['cid'] : $this->cid;
        $this->category_id = (isset($array['category_id'])) ? $array['category_id'] : $this->category_id;
        $this->create_time = (isset($array['create_time'])) ? $array['create_time'] : $this->create_time;
        $this->update_time = (isset($array['update_time'])) ? $array['update_time'] : $this->update_time;
        $this->product_images = (isset($array['product_images'])) ? $array['product_images'] : $this->product_images;
        $this->price = (isset($array['price'])) ? $array['price'] : $this->price;
        $this->unit = (isset($array['unit'])) ? $array['unit'] : $this->unit;
    }

    public function getArrayCopy()
    {
        $data = array(
            'id' => $this->id,
            'title' => $this->title,
            'short_desc' => $this->short_desc,
            'cid' => $this->cid,
            'category_id' => $this->category_id,
            'update_time' => $this->update_time,
            'product_images' => $this->product_images,
            'price' => $this->price,
            'unit' => $this->unit,
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

    public function getProductThumbnail()
    {
        if (empty($this->productThumbnail)){
            $productImageTable = new ProductImageTable();
            $this->productThumbnail = $productImageTable->getDefaultImage($this->id)->thumbnail_uri;
        }
        return $this->productThumbnail;
    }

}

