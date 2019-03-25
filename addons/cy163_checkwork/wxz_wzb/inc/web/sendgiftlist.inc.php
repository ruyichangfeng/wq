<?php

global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
$rid = intval($_GPC['rid']);
$type = ($_GPC['type']);
if(empty($rid)){
    message('直播id不存在',$this->createWebUrl('list_list'),'error');
}

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

	$sql='SELECT b.nickname,a.id,b.headimgurl,a.num as num,c.name as name,c.pic as pic,c.amount as amount,a.dateline as dateline FROM ' . tablename('wxz_wzb_giftlog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id  inner join ' . tablename('wxz_wzb_gift') . ' as c on a.giftid = c.id '.$condition.' and a.rid='.$rid.' and a.status=1 ORDER BY a.dateline DESC limit '.$start.','.$psize;

	$ds = pdo_fetchall($sql);
	$pager = pagination($total, $pindex, $psize);
}else{
	$total = pdo_fetchcolumn('SELECT count(*) as c FROM ' . tablename('wxz_wzb_giftlog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id '.$condition.' and a.rid='.$rid.' and a.status=1');
	$start = ($pindex - 1) * $psize;

	$sql='SELECT b.nickname,a.id,b.headimgurl,a.num as num,c.name as name,c.pic as pic,c.amount as amount,a.dateline as dateline FROM ' . tablename('wxz_wzb_giftlog') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id  inner join ' . tablename('wxz_wzb_gift') . ' as c on a.giftid = c.id '.$condition.' and a.rid='.$rid.' and a.status=1 ORDER BY a.dateline DESC limit '.$start.','.$psize;

	$ds = pdo_fetchall($sql);
	$pager = pagination($total, $pindex, $psize);
}



include $this->template('sendgiftlist');