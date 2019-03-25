<?php 
namespace myclass\dao;

class zt extends common{
     public $zt_id         = 'zt_id';
     public $zt_name       = 'zt_name';
     public $zt_img        = 'zt_img';
     public $zt_head_img   = 'zt_head_img';
     public $zt_content_id = 'zt_content_id';
     public $zt_order      = 'zt_order';
     public $status        = 'status';

    public function __construct(){
        $this->setTable('mihua_zt');
        $this->setGlobal();
    }
    public function dataAdd($arr){
        $in[$this->zt_name]         = $arr[$this->zt_name];
        $in[$this->zt_img]          = $arr[$this->zt_img];
        $in[$this->zt_head_img]     = $arr[$this->zt_head_img];
        $in[$this->zt_content_id]   = $arr[$this->zt_content_id];
        $in[$this->zt_order]        = $arr[$this->zt_order];
        $in[$this->status]          = $arr[$this->status];
        return parent::add($in);
    }
    public function dataEdit($id,$up=false){
        $where[$this->zt_id] = $id;
        $result              = parent::edit($where,$up);
        return $result;
    }
 
}