<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$page = intval($_GPC['page']);
$pindex = max(0, intval($_GPC['page']));
$psize = 10;
$start = ($pindex) * $psize;
$type = $_GPC['type'];
switch($type){
	case 'manage':
		$result = pdo_fetchAll('SELECT b.* FROM ' . tablename('wxz_wzb_viewer') . ' as a inner join ' . tablename('wxz_wzb_live_setting') . ' as b on a.rid = b.rid WHERE a.`uid` = :uid and role !=0 ORDER BY a.dateline DESC limit '.$start.','.$psize, array(':uid' => $uid) );
		break;
	case 'browse':
		$result = pdo_fetchAll('SELECT b.* FROM ' . tablename('wxz_wzb_viewer') . ' as a inner join ' . tablename('wxz_wzb_live_setting') . ' as b on a.rid = b.rid WHERE a.`uid` = :uid ORDER BY a.dateline DESC limit '.$start.','.$psize, array(':uid' => $uid) );
		break;
}
foreach($result as $key=>$v){
	$result[$key]['img'] = tomedia($v['img']);
}
$result = array('s'=>1,'msg'=>$result);
echo json_encode($result);
?>