<?php
namespace Application\Model;

use SamFramework\Model\AbstractModel;

class Buyer extends AbstractModel
{

    public $id = 0;

    public $quantity = 1;

    public $status = '';

    public $product_id = 'custome';

    public $buyer_id = 0;

    public $create_time = 0;

    public $buyer_weixin = '';


    public function exchangeArray(array $array)
    {
        $this->id = (isset($array['id'])) ? $array['id'] : $this->id;
        $this->quantity = (isset($array['quantity'])) ? $array['quantity'] : $this->quantity;
        $this->status = (isset($array['status'])) ? $array['status'] : $this->status;
        $this->product_id = (isset($array['product_id'])) ? $array['product_id'] : $this->product_id;
        $this->buyer_id = (isset($array['buyer_id'])) ? $array['buyer_id'] : $this->buyer_id;
        $this->create_time = (isset($array['create_time'])) ? $array['create_time'] : $this->create_time;
        $this->buyer_weixin = (isset($array['buyer_weixin'])) ? $array['buyer_weixin'] : $this->buyer_weixin;
    }

    public function getArrayCopy()
    {
        $data = array(
            'id' => $this->id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'product_id' => $this->product_id,
            'buyer_id' => $this->buyer_id,
        );
        return $data;
    }
}

