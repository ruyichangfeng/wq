<?php 
namespace myclass\dao;

class member extends common{
     public $id             = 'id';
     public $shareid        = 'shareid';
     public $from_user      = 'from_user';
     public $balance        = 'balance';
     public $realname       = 'realname';
     public $uid            = 'uid';
     public $mobile         = 'mobile';
     public $pwd            = 'pwd';
     public $bankcard       = 'bankcard';
     public $banktype       = 'banktype';
     public $alipay         = 'alipay';
     public $wxhao          = 'wxhao';
     public $commission     = 'commission';
     public $zhifu          = 'zhifu';
     public $content        = 'content';
     public $createtime     = 'createtime';
     public $flagtime       = 'flagtime';
     public $status         = 'status';
     public $flag           = 'flag';
     public $clickcount     = 'clickcount';
     public $dzdflag        = 'dzdflag';
     public $dzdtitle       = 'dzdtitle';
     public $msg_id_str     = 'msg_id_str';

    public function __construct(){
        $this->setTable('mihua_mall_member');
        $this->setGlobal();
    }
    public function dataAdd($arr){
        return parent::add($arr);
    }
    public function dataEdit($id,$up=false){
        $where[$this->id] = $id;
        $result               = parent::edit($where,$up);
        return $result;
    }
  
}