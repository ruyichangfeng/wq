<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_live_setting') . ' WHERE `uniacid` = :uniacid and `rid` = :rid', array(':uniacid' => $_W['uniacid'],':rid' => $rid));
if(!$uid){
	$result = array('s'=>'-1','msg'=>'请关注公众号！');
	echo json_encode($result);
	exit;
}

$user = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_user') . ' WHERE `uniacid` = :uniacid AND `id` = :uid', array(':uniacid' => $_W['uniacid'],':uid' => $uid) );

$viewer = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_viewer') . ' WHERE `uid` = :uid AND `rid` = :rid', array(':uid' => $uid,':rid' => $rid) );

if($viewer['isshutup']==1){
	$pollingData = array(
		'rid'=>$rid,
		'type'=>2
	);
	pdo_insert('wxz_wzb_polling', $pollingData);
	$pid=pdo_insertid();
	$result = array('s'=>'-2','msg'=>'您已被禁言！','pid'=>$pid);
	
	echo json_encode($result);
	exit;
	
}



if(!$user){
	$result = array('s'=>'-1','msg'=>'请关注公众号！');
	echo json_encode($result);
	exit;
}

$touser = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_comment') . ' WHERE `uniacid` = :uniacid AND `id` = :id and `rid` = :rid', array(':uniacid' => $_W['uniacid'],':id' => $_GPC['toid'],':rid' => $rid) );

$setting = $_W['setting']['upload'][$type];
$result = array(
	'jsonrpc' => '2.0',
	'id' => 'id',
	'error' => array('code' => 1, 'message'=>''),
);
load()->func('file');

if (empty($_FILES['upload']['tmp_name'])) {
	$binaryfile = file_get_contents('php://input', 'r');
	if (!empty($binaryfile)) {
		mkdirs(ATTACHMENT_ROOT . '/temp');
		$tempfilename = random(5);
		$tempfile = ATTACHMENT_ROOT . '/temp/' . $tempfilename;
		if (file_put_contents($tempfile, $binaryfile)) {
			$imagesize = @getimagesize($tempfile);
			$imagesize = explode('/', $imagesize['mime']);
			$_FILES['upload'] = array(
				'name' => $tempfilename . '.' . $imagesize[1],
				'tmp_name' => $tempfile,
				'error' => 0,
			);
		}
	}
}
if (!empty($_FILES['upload']['name'])) {
	if ($_FILES['upload']['error'] != 0) {
		$result['error']['message'] = '上传失败，请重试！';
		die(json_encode($result));
	}
	// if (!file_is_image($_FILES['upload']['name'])) {
	// 	$result['message'] = '上传失败, 请重试.';
	// 	die(json_encode($result));
	// }
	$ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);

	$file = file_upload($_FILES['upload']);
	if (is_error($file)) {
		$result['error']['message'] = $file['message'];
		die(json_encode($result));
	}

	$pathname = $file['path'];
	$fullname = ATTACHMENT_ROOT . '/' . $pathname;

	$thumb = empty($setting['thumb']) ? 0 : 1; 			$width = intval($setting['width']); 			if ($thumb == 1 && $width > 0 && (!isset($_GPC['thumb']) || (isset($_GPC['thumb']) && !empty($_GPC['thumb'])))) {
		$thumbnail = file_image_thumb($fullname, '', $width);
		@unlink($fullname);
		if (is_error($thumbnail)) {
			$result['message'] = $thumbnail['message'];
			die(json_encode($result));
		} else {
			$filename = pathinfo($thumbnail, PATHINFO_BASENAME);
			$pathname = $thumbnail;
			$fullname = ATTACHMENT_ROOT .'/'.$pathname;
		}
	}
	$info = array(
		'name' => $_FILES['upload']['name'],
		'ext' => $ext,
		'filename' => $pathname,
		'attachment' => $pathname,
		'url' => tomedia($pathname),
		'is_image' => 1,
		'filesize' => filesize($fullname),
	);
	$size = getimagesize($fullname);
	$info['width'] = $size[0];
	$info['height'] = $size[1];
	
	setting_load('remote');
	if (!empty($_W['setting']['remote']['type'])) {
		$remotestatus = file_remote_upload($pathname);
		if (is_error($remotestatus)) {
			$result['message'] = '远程附件上传失败，请检查配置并重新上传';
			file_delete($pathname);
			die(json_encode($result));
		} else {
			file_delete($pathname);
			$info['url'] = tomedia($pathname);
		}
	}
	
	pdo_insert('core_attachment', array(
		'uniacid' => $uniacid,
		'uid' => $_W['uid'],
		'filename' => $_FILES['upload']['name'],
		'attachment' => $pathname,
		'type' => $type == 'image' ? 1 : 2,
		'createtime' => TIMESTAMP,
	));
	$info['id'] = pdo_insertid();

	if(!pdo_fieldexists('wxz_wzb_comment', 'ispic')) {
		pdo_query("ALTER TABLE ".tablename('wxz_wzb_comment')." ADD `ispic` tinyint(1) DEFAULT '0';");
	}
	$data=array(
		'uniacid'=>$_W['uniacid'],
		'uid'=>$uid,
		'ip'=>$_W['clientip'],
		'is_auth'=>$item['is_auth']==1 ? 2 : 1,
		'nickname'=>$user['nickname'],
		'headimgurl'=>$user['headimgurl'],
		'rid'=>$rid,
		'content'=>$info['url'],
		'toid'=>$_GPC['toid'],
		'touid'=>$touser['uid'],
		'tonickname'=>$touser['nickname'],
		'toheadimgurl'=>$touser['headimgurl'],
		'ispic'=>1,
		'dateline'=>time()
	);

	pdo_insert('wxz_wzb_comment', $data);
	$id=pdo_insertid();
	$item = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_live_setting') . ' WHERE `uniacid` = :uniacid and `rid` = :rid', array(':uniacid' => $_W['uniacid'],':rid' => $rid));


	if($id){
		if($item['is_auth'] == '1'){
			$result = array('s'=>'1','msg'=>'提交成功，审核成功后显示');
		}else{
			
			$pollingData = array(
				'rid'=>$rid,
				'type'=>1,
				'comment_id'=>$id,
			);
			pdo_insert('wxz_wzb_polling', $pollingData);
			$pid=pdo_insertid();

			$result = array('s'=>'1','msg'=>'提交成功','pid'=>$pid,'content'=>$info['url']);
		}
		
	}else{
		$result = array('s'=>'-2','msg'=>'提交失败，请联系管理员');
	}

	die(json_encode($info));
} else {
	$result['error']['message'] = '请选择要上传的图片！';
	die(json_encode($result));
}
?>