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
				$content .= " AND title LIKE '%{$keyword}%' ";
				break;
			case 3 :
				$content .= " AND nickname LIKE '%{$keyword}%' ";
				break;
			default :
				$content .= " AND realname LIKE '%{$keyword}%' ";
		}
	}
	$goods = pdo_fetchall("select * from".tablename("xuan_js_jubao")."where uniacid = {$_W['uniacid']} {$content} order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	/*foreach ($goods as $key => $value) {
		load()->model('mc');
		$user=mc_fetch($value['uid']);

		$goods[$key]['avatar'] = $user['avatar'];
		$goods[$key]['nickname'] = $user['nickname'];
		$imgk=explode('@',$value['img']);
			if (count($imgk)-1>3) {
				$goods[$key]['imgf'] = array_slice($imgk, 0, 3);
			}else{
				$goods[$key]['imgf'] = array_slice($imgk, 0, count($imgk)-1);
			}
		
	}*/
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xuan_js_jubao') . " WHERE uniacid = {$_W['uniacid']} {$content} ");
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/jubao');
}elseif ($op=='chuli') {
	if(pdo_update('xuan_js_jubao', array('status' => 1),array('id'=>$_GPC['id']))){
		message('删除成功',$this->createWebUrl('tousu'),success);
	}
}



