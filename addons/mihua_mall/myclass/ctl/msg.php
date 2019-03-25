<?php 
namespace myclass\ctl;
class msg{
    public $config;
    public $openid;
    

    public function __construct(){
       load()->classs('weixin.account');
    }
    //发货模板
    public function sendHuoTemplate($arr,$url){
       global $_W;
	   $mu_id  = $this->config['sendMsgTemplateid']; 
       $accObj = \WeixinAccount::create($_W['acid']);
       $data=array(
            'first'   =>array('value'=>$arr['first'] ,'color'=>'#ff9900'),
            'delivername'=>array('value'=>$arr['delivername'],'color'=>'#173177'),
            'ordername'=>array('value'=>$arr['ordername'],'color'=>'#173177'),
            'remark'  =>array('value'=>$arr['remark'] ,'color'=>'#ff9900'),
       );
      return  $accObj->sendTplNotice($this->openid,$mu_id,$data,$url);
    }

}