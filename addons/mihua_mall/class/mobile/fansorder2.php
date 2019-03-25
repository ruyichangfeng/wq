<?php
global $_W,$_GPC;
$pindex = max(1, intval($_GPC['page']));
$psize = 30;
$today_begin_time_str=strtotime(date("Y-m-d",TIMESTAMP));
$yestday_begin_time_str=strtotime(date("Y-m",TIMESTAMP).'-'.(date("d",TIMESTAMP)-1));

$openid=$_W['openid'];
$uid=$_W['member']['uid'];
if (empty($uid)) {
	message('请先注册', $this->createMobileUrl('register'), 'error');
	exit;
}
$user_info=pdo_fetch("select * from ims_mihua_mall_member where from_user='{$openid}'");
$where="   o.createtime>={$user_info['flagtime']} and o.from_user != '{$openid}'  and  (o.shareid={$user_info['id']}";
$cfg = $this->module['config'];
if($cfg['globalCommissionLevel']<2){
	$where .=")";
}
if ( $cfg['globalCommissionLevel'] < 3 && $cfg['globalCommissionLevel'] > 1 ) {
	$where .=" or o.shareid2={$user_info['id']} )";
}
if ($cfg['globalCommissionLevel'] >2) {
	$where .=" or o.shareid2={$user_info['id']}  or o.shareid3={$user_info['id']} )";
}
#完成条件

$allcount=pdo_fetchcolumn("select count(*) as num from ims_mihua_mall_order o where {$where} ");
$todaycount=pdo_fetchcolumn("select count(*) as num from ims_mihua_mall_order o where {$where} and  o.createtime>={$today_begin_time_str} ");
$yestdaycount=pdo_fetchcolumn("select count(*) as num from ims_mihua_mall_order o where {$where} and  o.createtime<{$today_begin_time_str} and o.createtime>={$yestday_begin_time_str} ");
#list
$list=pdo_fetchall("select o.*,user.realname from ims_mihua_mall_order o left join ims_mihua_mall_member user on 
					user.from_user=o.from_user where {$where}   ORDER BY  o.createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
foreach ($list as $key => $value) {
	$result=pdo_fetchall("select detail.*,goods.title,goods.thumb from ims_mihua_mall_order_goods detail left join ims_mihua_mall_goods goods on goods.id=detail.goodsid  where orderid={$value['id']}");
	if($value['shareid']==$user_info['id']){
		$list[$key]['jibie']="一级";
		$jibie='';
	}
	if($value['shareid2']==$user_info['id']){
		$list[$key]['jibie']="二级";
		$jibie=1;
	}
	if($value['shareid3']==$user_info['id']){
		$list[$key]['jibie']="三级";
		$jibie=2;
	}		
	foreach ($result as $k => $v) {
		$commission+=$v['commission'.$jibie.''];
		$allmoney +=$v['price'];
		$allnum  +=$v['total'];
	}
	$list[$key]['detail']=$result;
	$list[$key]['money']=$commission;
	$list[$key]['allmoney']=$allmoney;
	$list[$key]['allnum']=$allnum;
}
$pager = pagination($total, $pindex, $psize);
include $this->template('fansorder2');