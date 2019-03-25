<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$id = intval($_GPC['id']);

$comment = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uid` = :uid and gid=:gid and rid=:rid', array(':uid' => $uid,':gid' => $id,':rid' => $rid));

if($comment){
	$result = array('s'=>'1','msg'=>'成功','id'=>$comment['id'],'content'=>$comment['content']);
}else{
	$result = array('s'=>'0','msg'=>'数据不存在');
}
echo json_encode($result);exit;
?>