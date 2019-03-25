<?php

global $_GPC,$_W;
$do=isset($_GPC['do'])?$_GPC['do']:"index";
$submit = $this->getMenus(false);
$adminInfo = $isAdmin=$this->isAdmin();
if(empty($adminInfo)){
    header("location:/app/".$this->createMobileUrl('member'));
    exit;
}
//配置设置
$baseConfig =$this->getLang();
$title=$baseConfig['wx_self'];
$app=isset($_GPC['app_id'])?$_GPC['app_id']:$_SESSION['app_id'];
$memberInfo =$this->initUser();
$fansInfo = mc_fansinfo($_W['openid']);
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
$this->selectApps();
$dpInfo = pdo_get("gd_department",array("id"=>$adminInfo['department']));
if(empty($dpInfo)){
    $dpInfo['name']="未分配";
}
$lang1=$this->getNodeStatus();
$lang =$this->getRdStatus();
$appInfo =$this->getAppInfo($app);
$wqInfo =pdo_get("mc_members",array("uid"=>$_W['member']['uid']));
if(empty($wqInfo)){
    $wqInfo['credit1']=0;
    $wqInfo['credit2']=0;
}

//获取数据
$groupId=$adminInfo['department'];
$groupId=$groupId.',';
$staffStr=$adminInfo['id']."-";
$baseSql=" select count(*) from ".tablename("gd_pool")." gd where ";
 //待处理
$where = " gd.mark_admin={$adminInfo['id']} and gd.is_mark=1 and gd.node_status=2 and gd.cancel_time=0 and gd.is_abort=0";
$total[2]=pdo_fetchcolumn($baseSql.$where);
//流转中
$where = " gd.staff_list like '%{$staffStr}%' and gd.recorder_status=1  ";
$total[3]=pdo_fetchcolumn($baseSql.$where);
//已完成
$where = " gd.staff_list like '%{$staffStr}%' and gd.recorder_status=2 and gd.cancel_time=0 and gd.is_abort=0";
$total[4]=pdo_fetchcolumn($baseSql.$where);
//可处理
$where = " gd.who_list like '%{$groupId}%' and gd.is_mark=0 and gd.is_abort=0  ";
$total[1]=pdo_fetchcolumn($baseSql.$where);
 //终止记录
$where = " gd.staff_list like '%{$staffStr}%' and recorder_status!=3 and is_abort=1   ";
$total[5]=pdo_fetchcolumn($baseSql.$where);
 //已取消
$where = " gd.staff_list like '%{$staffStr}%' and recorder_status=3 and cancel_time>0 and is_abort=1  ";
$total[6]=pdo_fetchcolumn($baseSql.$where);
//全部数据
$where = " staff_list like '%{$staffStr}%' or gd.who_list like '%{$groupId}%' ";
$total[0]=pdo_fetchcolumn($baseSql.$where);
foreach($total as $key=>$val){
    if(empty($val)){
        $total[$key]=0;
    }
}
//获取菜单
$menus = $this->getWxMenu();
include $this->template("staff");