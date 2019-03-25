<?php 
namespace myclass\dao;

class order extends common{
     public $id             = 'id';
     public $from_user      = 'from_user';
     public $shareid        = 'shareid';
     public $ordersn        = 'ordersn';
     public $price          = 'price';
     public $status         = 'status';
     public $sendtype       = 'sendtype';
     public $paytype        = 'paytype';
     public $transid        = 'transid';
     public $goodstype      = 'goodstype';
     public $remark         = 'remark';
     public $addressid      = 'addressid';
     public $expresscom     = 'expresscom';
     public $expresssn      = 'expresssn';
     public $express        = 'express';
     public $goodsprice     = 'goodsprice';
     public $dispatchprice  = 'dispatchprice';
     public $dispatch       = 'dispatch';
     public $createtime     = 'createtime';
     public $updatetime     = 'updatetime';
     public $shareid2       = 'shareid2';
     public $shareid3       = 'shareid3';

    public function __construct(){
        $this->setTable('mihua_mall_order');
        $this->setGlobal();
    }
    public function dataAdd($arr){
        return parent::add($in);
    }
    public function dataEdit($id,$up=false){
        $where[$this->id]     = $id;
        $result               = parent::edit($where,$up);
        return $result;
    }
    
  
}