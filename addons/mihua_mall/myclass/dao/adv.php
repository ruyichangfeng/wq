<?php 
namespace myclass\dao;

class adv extends common{
     public $id             = 'id';
     public $advname        = 'advname';
     public $link           = 'link';
     public $thumb          = 'thumb';
     public $displayorder   = 'displayorder';
     public $enabled        = 'enabled';
     public $type           = 'type';

    public function __construct(){
        $this->setTable('mihua_mall_adv');
        $this->setGlobal();
    }
    public function dataAdd($arr){
        return parent::add($arr);
    }
    public function dataEdit($id,$up=false){
        $where[$this->id]    = $id;
        $result              = parent::edit($where,$up);
        return $result;
    }
 
}