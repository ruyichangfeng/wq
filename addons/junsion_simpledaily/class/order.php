<?php
global $_W,$_GPC;

$op = $_GPC['op'] ? $_GPC['op'] : 'display';

if ('display' == $op){
	$pindex = max(1, intval($_GPC['page']));
	$psize =20;//每页显示
	$condition = '';
	//删除一天前未付款的订单
	pdo_query('delete from '.tablename($this->modulename."_order")." where status=0 and createtime <= ".(time()-24*3600));
	
	$start_time = $_GPC['dateline']?strtotime($_GPC['dateline']['start']):(time()-30*24*3600);
	$end_time = $_GPC['dateline']?strtotime($_GPC['dateline']['end']):time();
	$condition .= " and ( o.createtime > {$start_time} and o.createtime < {$end_time} ) ";
	$list = pdo_fetchall("select o.*,w.nickname,w.avatar,w.psw,w.title,w.openid from ".tablename($this->modulename.'_order')." o join ".tablename($this->modulename.'_works')." w on o.wid=w.id where o.weid='{$_W['uniacid']}' and o.status=1 {$condition} order by createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize);
	$total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->modulename.'_order') . " o WHERE o.weid = '{$_W['uniacid']}' and o.status>0 {$condition}");
	$pager = pagination($total, $pindex, $psize);
	
	$today = pdo_fetchall('select price,rate from '.tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and status=1 and to_days(from_unixtime(createtime)) = to_days(now())");
	$all = pdo_fetchall('select price,rate from '.tablename($this->modulename."_order")." where weid='{$_W['uniacid']}' and status=1 and createtime <= {$end_time} and createtime>={$start_time}");
	$today_all = 0;$today_rate = 0;$all_all = 0;$all_rate = 0;
	foreach ($today as $value) {
		$today_all += $value['price'];
		$today_rate += $value['rate'];
	}
	foreach ($all as $value) {
		$all_all += $value['price'];
		$all_rate += $value['rate'];
	}
}elseif ('packet' == $op){
	$id = $_GPC['id'];
	$order = pdo_fetch('select * from ' . tablename($this->modulename.'_order') . " where id = '{$id}' ");
	if (!$order['status']){
		message('该订单未支付！');
	}elseif ($order['packet_status']){
		message('该订单红包已发放！');
	}
	$res = $this->sendMemberRedPacket($order);
	if ($res['code'] == 1) message('发放成功！',referer(),'success');
	else message('发放失败！原因：'.$res['msg'],referer(),'error');
}elseif ($op == 'del'){
		$id = $_GPC['id'];
		$item = pdo_fetch('select * from ' . tablename($this->modulename.'_order') . " where id = '{$id}' ");
		if(empty($item)){
			message('抱歉！该打赏记录不存在或已经删除',referer(),'error');
		}
		if (pdo_delete($this->modulename."_order",array('id'=>$id)) === false){
			message('删除失败！',referer(),'error');
		}else message('删除成功！',referer(),'success');
}

include $this->template('order');