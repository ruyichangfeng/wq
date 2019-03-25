<?php
//会员信息编辑

global $_GPC,$_W;

$config=$this->beforeSettingList(array("group"=>8));

//如果需要短息验证
if(!empty($config['member_code'])){
    $smCode=$_GPC['sms_code'];
    $info = pdo_get("gd_sms",array("code"=>$smCode));
    if(empty($info) || $info['end_time']<time()){
        $this->msg['msg']="验证码错误";
        $this->echoAjax();
    }
}

$appId=isset($_GPC['app_id'])?$_GPC['app_id']:0;
$update['name']=$_GPC['name'];
$update['mobile']=$_GPC['mobile'];
$update['app_id']=$appId;
$update['is_register']=1;
$result =pdo_update("gd_member",$update,array("uid"=>$_W['member']['uid']));

//需要同步微擎用户信息
$update=array();
if($result && !empty($config['member_syn'])){
    $update['mobile']=$_GPC['mobile'];
    $update['nickname']=$_GPC['name'];
    if($appId>0){
        $appInfo = $this->getAppInfo($appId);
        if(!empty($appInfo['group_id'])){
            $update['group']=$appInfo['group_id'];
        }
    }
    pdo_update("mc_members",$update,array("uid"=>$_W['member']['uid']));
}

$this->msg['code']=1;
$this->msg['msg']="修改成功";
$this->echoAjax();