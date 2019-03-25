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
				$content .= " AND mobile LIKE '%{$keyword}%' ";
				break;
			case 3 :
				$content .= " AND nickname LIKE '%{$keyword}%' ";
				break;
			default :
				$content .= " AND realname LIKE '%{$keyword}%' ";
		}
	}
	$members = pdo_fetchall("select * from".tablename("mc_members")."where uniacid = {$_W['uniacid']} {$content} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	/*foreach ($members as $key => $value) {
		load()->model('mc');
		$uid = mc_openid2uid($value['openid']);
		$member_info = mc_fetch($uid, array('credit1','credit2'));
		$members[$key]['credit1'] = $member_info['credit1'];
		$members[$key]['credit2'] = $member_info['credit2'];
		$members[$key]['uid'] = $uid;
	}*/
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . " WHERE uniacid = {$_W['uniacid']} {$content} ");
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/member');
}

if($op=="dianyuan"){
	if ($_GPC['id']) {
		$data=array(
				'dianyuan'=>1
				);
		pdo_update('mc_members',$data,array('mid'=>$_GPC['id']));
		message('添加成功',$this->createWebUrl('member',array('op'=>"dianyuan")));
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$content ='';
	$type = intval($_GPC['type']);
	$keyword = trim($_GPC['keyword']);
	if (!empty($keyword)) { 
		switch($type) {
			case 2 :
				$content .= " AND mobile LIKE '%{$keyword}%' ";
				break;
			case 3 :
				$content .= " AND nickname LIKE '%{$keyword}%' ";
				break;
			default :
				$content .= " AND realname LIKE '%{$keyword}%' ";
		}
	}
	$members = pdo_fetchall("select * from".tablename("mc_members")."where dianyuan=1 and uniacid = {$_W['uniacid']} {$content} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	foreach ($members as $key => $value) {
		load()->model('mc');
		$uid = mc_openid2uid($value['openid']);
		$member_info = mc_fetch($uid, array('credit1','credit2'));
		$members[$key]['credit1'] = $member_info['credit1'];
		$members[$key]['credit2'] = $member_info['credit2'];
		$members[$key]['uid'] = $uid;
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_members') . " WHERE dianyuan=1 and uniacid = {$_W['uniacid']} {$content} ");
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/member');
}

