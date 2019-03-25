<?php
//员工消息中心处理

global $_GPC,$_W;
//获取状态列表
$ndStatus=$this->getNodeStatus();
$rdStatus=$this->getRdStatus();
$do=$_GPC['do'];
$baseConfig =$this->getLang();
$jd = empty($baseConfig)?"接单":$baseConfig['jd'];
$title=$subTitle=$baseConfig['task_list'];
$hidHd=true;
$catId=isset($_GPC['id'])?$_GPC['id']:0;
$_GPC['id']=$catId;
$show=0;
$adminInfo =$this->isAdmin();
if(empty($adminInfo)){
    message("先绑定员工",$this->createMobileUrl('member'),'info');
}
$searchSql="";
$search=$_GPC['search'];
if($search){
    $searchSql=" and (gd.gd_sn like '%$search%' or gd.mobile like '%{$search}%' or gd.name like '%{$search}%' ) $searchSql ";
}
$groupId=$adminInfo['department'];
if($catId==2){ //待处理
    $where = " gd.mark_admin={$adminInfo['id']} and gd.is_mark=1 and gd.node_status=2 and gd.cancel_time=0 and gd.is_abort=0 $searchSql ";
}else if($catId==3){ //流转中
    $staffStr=$adminInfo['id']."-";
    $where = " gd.staff_list like '%{$staffStr}%' and gd.recorder_status=1 $searchSql ";
}else if($catId==4){ //已完成
    $staffStr=$adminInfo['id']."-";
    $where = " gd.staff_list like '%{$staffStr}%' and gd.recorder_status=2 and gd.cancel_time=0 and gd.is_abort=0 $searchSql";
}else if($catId==1){ //可处理
    $groupId=$groupId.',';
    $staffStr=$adminInfo['id']."-";
    $where = " (gd.who_list like '%{$groupId}%' or gd.adm_list like '%{$staffStr}%' ) and gd.is_mark=0 and gd.is_abort=0 $searchSql ";
}else if($catId==5){ //终止记录
    $staffStr=$adminInfo['id']."-";
    $where = " gd.staff_list like '%{$staffStr}%' and recorder_status!=3 and is_abort=1  $searchSql ";
}else if($catId==6){ //已取消
    $staffStr=$adminInfo['id']."-";
    $where = " gd.staff_list like '%{$staffStr}%' and recorder_status=3 and cancel_time>0 and is_abort=1 $searchSql ";
}else{//全部数据
    $groupId=$groupId.',';
    $staffStr=$adminInfo['id']."-";
    $where = " (staff_list like '%{$staffStr}%' or  gd.who_list like '%{$groupId}%' or gd.adm_list like '%{$staffStr}%' ) $searchSql ";
}
//获取消息列表
$sql=" select gd.*,app.icon from ".tablename("gd_pool")." gd left join  ".tablename('gd_app')." app on  app.id=gd.app_id where $where and gd.uniacid={$_W['uniacid']} order by gd.id desc,gd.sort desc ";
$msgList=pdo_fetchall($sql);
foreach($msgList as $key=>$val){
    if(empty($val['icon'])){
        $msgList[$key]['icon']=MODULE_URL."/static/new/images/smpic2.jpg";
    }else{
        $msgList[$key]['icon']=strstr($val['icon'],"http")?$val['icon']:"/".$val['icon'];
    }
}
$total = count($msgList);
//获取分类列表
$property = $this->getProperty(true);
foreach($msgList as $key=>$val){
    $whoList = explode(",",$val['who_list']);
    if(in_array($adminInfo['department'],$whoList)){
        $msgList[$key]['show']=1;
    }else{
        $adm_list =explode("-",$val['adm_list']);
        $msgList[$key]['show'] = in_array($adminInfo['id'],$adm_list)?1:0;
    }
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
include $this->template("staff_step");