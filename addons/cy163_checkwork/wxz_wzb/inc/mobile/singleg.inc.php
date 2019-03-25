<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$id = intval($_GPC['id']);

$comment = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uid` = :uid and giftid=:giftid and rid=:rid', array(':uid' => $uid,':giftid' => $id,':rid' => $rid));

$content = $comment['nickname'].'送出了<img src="'.$comment['giftpic'].'" width="45px" style="position: absolute;top: -15px;"><span style="margin-left:50px">x'.$comment['giftnum'].'</span>';

if($comment){
	$result = array('s'=>'1','msg'=>'成功','id'=>$comment['id'],'content'=>$content);
}else{
	$result = array('s'=>'0','msg'=>'数据不存在');
}
echo json_encode($result);exit;
?>