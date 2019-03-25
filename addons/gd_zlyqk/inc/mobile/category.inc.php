<?php
global $_GPC,$_W;
$type="category";
if(!isset($_GPC['id'])){
    $_GPC['id']=-1;
}
$catId=$_GPC['id'];
$where = " 1=1 ";
$this->selectApps();
$search ="";
$appId =empty($_GPC['app_id'])?$_SESSION['app_id']:$_GPC['app_id'];
$appInfo =$this->getAppInfo($appId);
$do=isset($_GPC['do'])?$_GPC['do']:"index";
if($catId>-1){
    $where .= " and gd.recorder_status=$catId ";
}
if(!empty($_GPC['search'])){
    $where .=" and gd.gd_sn like '%{$_GPC['search']}%' ";
    $search = $_GPC['search'];
}
$ndStatus=$this->getNodeStatus();
$rdStatus=$this->getRdStatus();
$baseConfig =$this->getLang();
$title=$baseConfig['msg_my'];
$uid =$_W['member']['uid'];
//获取消息列表
$sql=" select gd.*, app.icon from ".tablename("gd_pool")." gd left join ".tablename("gd_app")." app on app.id=gd.app_id where $where and gd.uid=$uid and gd.uniacid={$_W['uniacid']} order by gd.id desc,gd.sort desc ";
$msgList=pdo_fetchall($sql);
foreach($msgList as $key=>$val){
    if(empty($val['icon'])){
        $msgList[$key]['icon']=MODULE_URL."/static/new/images/smpic2.jpg";
    }else{
        $msgList[$key]['icon']=strstr($val['icon'],"http")?$val['icon']:"/".$val['icon'];;
    }
}
$total = count($msgList);
$property=$this->getProperty(true);
foreach($msgList as $key=>$val){
    if(!empty($val['end_time'])){
        $msgList[$key]['use_time']=$this->format_date($val['end_time']-$val['create_time']);
    } else if(!empty($val['cancel_time'])){
        $msgList[$key]['use_time']=$this->format_date($val['cancel_time']-$val['create_time']);
    }else{
        $msgList[$key]['use_time']=$this->format_date(time()-$val['create_time']);
    }
    $msgList[$key]['property']=isset($property[$val['property']])?"(".$property[$val['property']].")":"";
}
//获取菜单
$menus = $this->getWxMenu();
include $this->template("member_msg");