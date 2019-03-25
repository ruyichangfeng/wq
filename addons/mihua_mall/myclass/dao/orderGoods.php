<?php 
namespace myclass\dao;

class orderGoods extends common{
     public $id             = 'id';
     public $orderid        = 'orderid';
     public $goodsid        = 'goodsid';
     public $commission     = 'commission';
     public $commission2    = 'commission2';
     public $commission3    = 'commission3';
     public $applytime      = 'applytime';
     public $checktime      = 'checktime';
     public $applytime2     = 'applytime2';
     public $checktime2     = 'checktime2';
     public $applytime3     = 'applytime3';
     public $checktime3     = 'checktime3';
     public $status         = 'status';
     public $status2        = 'status2';
     public $status3        = 'status3';
     public $content        = 'content';
     public $price          = 'price';
     public $total          = 'total';
     public $optionid       = 'optionid';
     public $createtime     = 'createtime';
     public $optionname     = 'optionname';
     //

    public function __construct(){
        $this->setTable('mihua_mall_order_goods');
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
    //条件查询
    public function paramsList(){
        $where  = $this->params;
        $result = $this->dataList($where);
        return $result;
    }

    
  
}