<?php
namespace Application\Model\Product;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use SamFramework\Model\AbstractModel;

class Product extends AbstractModel implements InputFilterAwareInterface
{

    public $id = '';

    public $name = '';

    public $short_desc = '';

    public $cid = '';

    public $category_id = '';

    public $create_time = '';

    public $update_time = '';

    protected $category = NULL;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        throw new \Exception("Not used");
    }

    public function exchangeArray($data)
    {
        $this->id = (! empty($data['id'])) ? $data['id'] : null;
        $this->name = (! empty($data['name'])) ? $data['name'] : null;
        $this->short_desc = (! empty($data['short_desc'])) ? $data['short_desc'] : null;
        $this->cid = (! empty($data['cid'])) ? $data['cid'] : null;
        $this->category_id = (! empty($data['category_id'])) ? $data['category_id'] : null;
        $this->create_time = (! empty($data['create_time'])) ? $data['create_time'] : null;
        $this->update_time = (! empty($data['update_time'])) ? $data['update_time'] : null;
    }

    public function toArray()
    {
        $data = array();
        (! empty($this->id)) ? $data['id'] = $this->id : null;
        (! empty($this->name)) ? $data['name'] = $this->name : null;
        (! empty($this->short_desc)) ? $data['short_desc'] = $this->short_desc : null;
        (! empty($this->cid)) ? $data['cid'] = $this->cid : null;
        (! empty($this->category_id)) ? $data['category_id'] = $this->category_id : null;
        (! empty($this->create_time)) ? $data['create_time'] = $this->create_time : null;
        (! empty($this->update_time)) ? $data['update_time'] = $this->update_time : null;
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
}

