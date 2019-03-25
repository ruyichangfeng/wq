<?php 
namespace myclass\dao;

class goods extends common{
     public $id                 = 'id';
     public $pcate              = 'pcate';
     public $ccate              = 'ccate';
     public $type               = 'type';
     public $status             = 'status';
     public $displayorder       = 'displayorder';
     public $title              = 'title';
     public $thumb              = 'thumb';
     public $xsthumb            = 'xsthumb';
     public $unit               = 'unit';
     public $description        = 'description';
     public $content            = 'content';
     public $goodssn            = 'goodssn';
     public $productsn          = 'productsn';
     public $marketprice        = 'marketprice';
     public $productprice       = 'productprice';
     public $total              = 'total';
     public $totalcnf           = 'totalcnf';
     public $sales              = 'sales';
     public $zans               = 'zans';
     public $spec               = 'spec';
     public $createtime         = 'createtime';
     public $weight             = 'weight';
     public $credit             = 'credit';
     public $maxbuy             = 'maxbuy';
     public $hasoption          = 'hasoption';
     public $dispatch           = 'dispatch';
     public $thumb_url          = 'thumb_url';
     public $isnew              = 'isnew';
     public $ishot              = 'ishot';
     public $issendfree         = 'issendfree';
     public $isdiscount         = 'isdiscount';
     public $isrecommand        = 'isrecommand';
     public $istime             = 'istime';
     public $timestart          = 'timestart';
     public $timeend            = 'timeend';
     public $viewcount          = 'viewcount';
     public $deleted            = 'deleted';
     public $commission2        = 'commission2';
     public $commission3        = 'commission3';
     public $commission         = 'commission';
     //
    public function __construct(){
        $this->setTable('mihua_mall_goods');
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