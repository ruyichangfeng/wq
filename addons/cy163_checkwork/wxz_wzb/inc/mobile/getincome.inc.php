<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$pindex = max(0, intval($_GPC['page']));
$psize = 5;
$start = ($pindex) * $psize;

$sql='SELECT * FROM ' . tablename('wxz_wzb_money_log') .' WHERE uid = '.$uid.' and uniacid='.$_W['uniacid'].' order by dateline desc limit '.$start.','.$psize;
$list = pdo_fetchall($sql);
foreach($list as $key => $v){
	$list[$key]['amount'] = $v['amount']/100;
}
$result = array('s'=>'1','msg'=>$list);

echo json_encode($result);
exit;

?>