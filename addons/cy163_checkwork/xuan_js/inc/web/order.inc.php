<?php
global $_W,$_GPC;
$op = !empty($_GPC['op'])?$_GPC['op']:'display';

if($op=='display'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$content ='';
	$type = intval($_GPC['type']);
	$keyword = trim($_GPC['keyword']); 
	if (!empty($keyword)) {
		switch($type) {
			case 2 :
				$content .= " AND phone LIKE '%{$keyword}%' ";
				break;
			case 3 :
				$content .= " AND tid LIKE '%{$keyword}%' ";
				break;
			case 4 :
				$content .= " AND name LIKE '%{$keyword}%' ";
		}
	}
	$order = pdo_fetchall("select * from".tablename("xuan_js_order")."where uniacid = {$_W['uniacid']} {$content} order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	foreach ($order as $key => $value) {
		load()->model('mc');
		 
		$order[$key]['myjia'] = mc_fetch($value['uid']);
		$order[$key]['maijia'] = mc_fetch($value['buid']);
		
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xuan_js_order') . " WHERE uniacid = {$_W['uniacid']} {$content} ");
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/order');
}



