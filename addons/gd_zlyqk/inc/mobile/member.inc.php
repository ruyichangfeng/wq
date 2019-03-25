<?php

global $_GPC,$_W;
$do=isset($_GPC['do'])?$_GPC['do']:"index";
$submit = $this->getMenus(false);
//配置设置
$baseConfig =$this->getLang();
$title=$baseConfig['wx_self'];
$app=isset($_GPC['app_id'])?$_GPC['app_id']:$_SESSION['app_id'];
$memberInfo =$this->initUser();
$memberLabel = pdo_get("gd_member_label",array("id"=>$memberInfo['label']));
$fansInfo = mc_fansinfo($_W['openid']);
if(empty($memberLabel)){
    $memberLabel['label_name']="未分组";
}
if($this->isAjax){
    $userInfo = array();
    parse_str($_GPC['post'],$userInfo);
    $appId=isset($userInfo['app_id'])?$userInfo['app_id']:0;
    $config=$this->beforeSettingList(array("group"=>8));
    //如果需要短息验证
    if(!empty($config['member_code'])){
        $smCode=$userInfo['sms_code'];
        $info = pdo_get("gd_sms",array("code"=>$smCode));
        if(empty($info) || $info['end_time']<time()){
            $this->msg['msg']="验证码错误";
            $this->echoAjax();
        }
    }
    if(empty($userInfo['name'])){
        $this->msg['msg']="姓名不能为空";
        $this->echoAjax();
    }
    if(empty($userInfo['mobile'])){
        $this->msg['msg']="电话不能为空";
        $this->echoAjax();
    }
    //更新用户信息
    $update['name']=$userInfo['name'];
    $update['mobile']=$userInfo['mobile'];
    $update['is_register']=1;
    if($appId>0){
        $update['app_id']=$appId;
    }
    if(!empty($userInfo['label'])){
        $update['label']=$userInfo['label'];
    }
    $result =pdo_update("gd_member",$update,array("uid"=>$_W['member']['uid']));
    $update=array();
    if($result && !empty($config['member_syn'])){
        $update['mobile']=$userInfo['mobile'];
        $update['nickname']=$userInfo['name'];
        if($appId>0){
            $appInfo = $this->getAppInfo($appId);
            if(!empty($appInfo['group_id'])){
                $update['group']=$appInfo['group_id'];
            }
        }
        pdo_update("mc_members",$update,array("uid"=>$_W['member']['uid']));
    }
    //通过电话号码同步数据单
    $pUpdate['uid']=$_W['member']['uid'];
    pdo_update("gd_pool",$pUpdate,array("mobile"=>$userInfo['mobile']));

    $this->saveExtInfo($userInfo,$memberInfo,$config);
    $this->msg['code']=1;
    $this->msg['msg']="更新成功";
    if(isset($config['ext_member']) && $config['ext_member']==1) {
        if(isset($config['member_step']) && $config['member_step'] ==1) {
            $this->msg['data']=$this->createMobileUrl("SaveStep");
        }
    }else{
        $this->msg['data']=$this->createMobileUrl("member");
    }
    $this->echoAjax();
}
$adminInfo = $isAdmin=$this->isAdmin();
if(!empty($adminInfo)){
    header("location:/app/".$this->createMobileUrl('staff'));
    exit;
}
$wqInfo =pdo_get("mc_members",array("uid"=>$_W['member']['uid']));
if(empty($wqInfo)){
    $wqInfo['credit1']=0;
    $wqInfo['credit2']=0;
}
//获取菜单
$menus = $this->getWxMenu();
$this->selectApps();
$lang1=$this->getNodeStatus();
$lang =$this->getRdStatus();
$appInfo =$this->getAppInfo($app);
$msg = $this->sumMsg();
include $this->template("member");