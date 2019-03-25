<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);

if(!$uid){
	message('你不是管理员，无权操作', $this->createMobileUrl('index2',array('rid'=>$rid)), 'error');
}

$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$viewer = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid AND `rid` = :rid', array(':uid' => $uid,':rid' => $rid) );

if($viewer['role']==0){
	
	message('你不是管理员，无权操作', $this->createMobileUrl('index2',array('rid'=>$rid)), 'error');

}

if(!$user){
	message('你不是管理员，无权操作', $this->createMobileUrl('index2',array('rid'=>$rid)), 'error');
}
if(!pdo_fieldexists('wxz_wzb_live_pic', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wxz_wzb_live_pic')." ADD `uid` int(10) DEFAULT '0';");
}
$data=array(
	'uniacid'=>$_W['uniacid'],
	'content'=>$_GPC['content'],
	'title'=>$_GPC['title'],
	'rid'=>$_GPC['rid'],
	'publisher'=>$user['nickname'],
	'images'=>$user['headimgurl'],
	'uid'=>$user['id'],
	'pic'=>json_encode($_GPC['pic']),
	'dateline'=>time()
);
pdo_insert('wxz_wzb_live_pic', $data);

$id=pdo_insertid();

if($id){
	$pollingData = array(
		'rid'=>$rid,
		'type'=>8,
		'pic_id'=>$id,
	);
	pdo_insert('wxz_wzb_polling', $pollingData);
	$pid=pdo_insertid();
	message('发布成功', $this->createMobileUrl('index2',array('rid'=>$rid)), 'success');
	
}else{
	message('发布失败', referer(), 'error');
}
echo json_encode($result);
exit;

?>