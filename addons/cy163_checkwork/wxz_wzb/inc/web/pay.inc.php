<?php

global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
$rid = intval($_GPC['rid']);
$type = ($_GPC['type']);
if(empty($rid)){
	message('直播id不存在',$this->createWebUrl('list_list'),'error');
}
$zhibo_list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_live_setting')." WHERE uniacid=:uniacid AND rid=:rid",array(':uniacid'=>$uniacid,':rid'=>$rid));
if(empty($zhibo_list)){
	message('此直播不存在',$this->createWebUrl('live_manage'),'error');
}

$sum = pdo_fetchcolumn('SELECT sum(a.amount) as amount FROM ' . tablename('wxz_wzb_paylog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id WHERE a.rid='.$rid.' and a.status=1 and a.type=1');

$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$condition = ' where 1=1';
if($_GPC['nickname']){
	$condition .= "  and b.nickname like '%".$_GPC['nickname']."%'";
}
if($_GPC['openid']){
	$condition .= "  and b.openid like '%".$_GPC['openid']."%'";
}

if($type == 'all'){
	$psize = 10000000;
	$start = ($pindex - 1) * $psize;

	$sql='SELECT b.nickname,b.id,b.headimgurl,a.amount as amount,a.dateline as dateline FROM ' . tablename('wxz_wzb_paylog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id '.$condition.' and  a.rid='.$rid.' and a.status=1 and a.type=1 ORDER BY a.dateline DESC';

	$ds = pdo_fetchall($sql);
	$pager = pagination($total, $pindex, $psize);
}else{
	$total = pdo_fetchcolumn('SELECT count(*) as c FROM ' . tablename('wxz_wzb_paylog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id '.$condition.' and a.rid='.$rid.' and a.status=1 and a.type=1');
	$start = ($pindex - 1) * $psize;

	$sql='SELECT b.nickname,b.id,b.headimgurl,a.amount as amount,a.dateline as dateline FROM ' . tablename('wxz_wzb_paylog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id '.$condition.' and  a.rid='.$rid.' and a.status=1 and a.type=1 ORDER BY a.dateline DESC limit '.$start.','.$psize;

	$ds = pdo_fetchall($sql);
	$pager = pagination($total, $pindex, $psize);
}


include $this->template('pay');