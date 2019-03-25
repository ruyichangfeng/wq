<?php 
namespace myclass\dao;

class goodsOption extends common{
     public $id               = 'id';
     public $goodsid          = 'goodsid';
     public $title            = 'title';
     public $thumb            = 'thumb';
     public $productprice     = 'productprice';
     public $marketprice      = 'marketprice';
     public $costprice        = 'costprice';
     public $stock            = 'stock';
     public $weight           = 'weight';
     public $displayorder     = 'displayorder';
     public $description      = 'description';
     public $specs            = 'specs';

    public function __construct(){
        $this->setTable('mihua_mall_goods_option');
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
    public function paramsFind(){
        $where  = $this->params;
        $result = $this->dataList($where);
        return $result;
    }

    
  
}