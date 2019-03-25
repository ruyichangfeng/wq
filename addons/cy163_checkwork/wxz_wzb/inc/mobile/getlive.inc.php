<?php
global $_W,$_GPC;
$page = intval($_GPC['page']);
$cid = intval($_GPC['cid']);

$isweixin = 1;
$pindex = max(0, intval($_GPC['page']));
$psize = 5;
$start = ($pindex) * $psize;
if($cid ==0){
	$list = pdo_fetchall('SELECT * FROM '.tablename("wxz_wzb_live_setting").' WHERE isshow=:isshow and uniacid=:uniacid ORDER BY sort ASC,dateline DESC limit '.$start.','.$psize,array(':isshow'=>'1',':uniacid'=>$_W['uniacid']));
}else{
	$list = pdo_fetchall('SELECT * FROM '.tablename("wxz_wzb_live_setting").' WHERE cid=:cid AND isshow=:isshow and uniacid=:uniacid ORDER BY sort ASC,dateline DESC limit '.$start.','.$psize,array(':cid'=>$cid,':isshow'=>'1',':uniacid'=>$_W['uniacid']));
}
foreach($list as $key => $v){
	$list[$key]['img'] = tomedia($v['img']);
}
$result = array('s'=>'1','msg'=>$list,'isweixin'=>$isweixin);

echo json_encode($result);exit;

?>