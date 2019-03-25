<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];

load()->func('tpl');
$rid = intval($_GPC['rid']);
$uid = intval($_GPC['uid']);
$categorys = pdo_fetchall("SELECT * FROM ".tablename('wxz_wzb_category')." WHERE uniacid=:uniacid",array(':uniacid'=>$uniacid));
$viewer = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_viewer')." WHERE uniacid=:uniacid and uid =:uid and rid=:rid",array(':uniacid'=>$uniacid,':uid'=>$uid,':rid'=>$rid));

$user = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_user')." WHERE uniacid=:uniacid and id =:uid",array(':uniacid'=>$uniacid,':uid'=>$uid,':rid'=>$rid));

$cid = explode(',',$user['cid']);

$data = array();
$data['cid'] = implode(',',$_GPC['cid']);
if($data['cid']==''){
	message('请选择直播分类');
}

$data['start_at'] = strtotime($_GPC['activity']['start']);
$data['end_at'] = strtotime($_GPC['activity']['end']);
;
foreach($_GPC['users'] as $k=>$v){

	pdo_update('wxz_wzb_user',$data,array('id'=>$v));
}
message('分配成功',$this->createWebUrl('users',array('rid'=>$rid)),'success');
?>