<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
//defined('IN_IA') or exit('Access Denied');
error_reporting(0);
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
load()->func('tpl');
load()->model('mc');
load()->func('file');
$op = !empty($_GPC['op']) ? $_GPC['op'] : '';
if (!in_array($op, array('upload', 'fetch', 'browser', 'delete', 'local'))) {
	exit('Access Denied');
}
$result = array(
	'error' => 1,
	'message' => '',
	'data' => ''
);

$type = $_COOKIE['__fileupload_type'];;
$type = in_array($type, array('image','audio','video')) ? $type : 'image';
$option = array();
$option = array_elements(array('uploadtype', 'global', 'dest_dir'), $_POST);
$option['width'] = intval($option['width']);
$option['global'] = !empty($_COOKIE['__fileupload_global']);
if (!empty($option['global']) && empty($_W['isfounder'])) {
	$result['message'] = '没有向 global 文件夹上传文件的权限.';
	die(json_encode($result));
}

$dest_dir = $_COOKIE['__fileupload_dest_dir'];
if (preg_match('/^[a-zA-Z0-9_\/]{0,50}$/', $dest_dir, $out)) {
	$dest_dir = trim($dest_dir, '/');
	$pieces = explode('/', $dest_dir);
	if(count($pieces) > 3){
		$dest_dir = '';
	}
} else {
	$dest_dir = '';
}

$setting = $_W['setting']['upload'][$type];
$uniacid = intval($_W['uniacid']);

if (!empty($option['global'])) {
	$setting['folder'] = "{$type}s/global/";
	if (!empty($dest_dir)) {
		$setting['folder'] .= '/'.$dest_dir.'/';
	}
} else {
	$setting['folder'] = "{$type}s/{$uniacid}";
	if(empty($dest_dir)){
		$setting['folder'] .= '/'.date('Y/m/');
	} else {
		$setting['folder'] .= '/'.$dest_dir.'/';
	}
}


if ($op == 'fetch') {
	$url = trim($_GPC['url']);
	load()->func('communication');
	$resp = ihttp_get($url);
	if (is_error($resp)) {
		$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
		die(json_encode($result));
	}
	if (intval($resp['code']) != 200) {
		$result['message'] = '提取文件失败: 未找到该资源文件.';
		die(json_encode($result));
	}
	$ext = '';
	if ($type == 'image') {
		switch ($resp['headers']['Content-Type']){
			case 'application/x-jpg':
			case 'image/jpeg':
				$ext = 'jpg';
				break;
			case 'image/png':
				$ext = 'png';
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				$result['message'] = '提取资源失败, 资源文件类型错误.';
				die(json_encode($result));
				break;
		}
	} else {
		$result['message'] = '提取资源失败, 仅支持图片提取.';
		die(json_encode($result));
	}
	
	if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
		$result['message'] = '上传的媒体文件过大('.sizecount($size).' > '.sizecount($setting['limit'] * 1024);
		die(json_encode($result));
	}
	$originname = pathinfo($url, PATHINFO_BASENAME);
	$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
	$pathname = $setting['folder'] . $filename;
	$fullname = ATTACHMENT_ROOT . '/' . $pathname;
	
	$pathinfo = pathinfo($fullname);
	mkdirs($pathinfo['dirname']);
	
	if (file_put_contents($fullname, $resp['content']) == false) {
		$result['message'] = '提取失败.';
		die(json_encode($result));
	}
}


if ($op == 'upload') {
	if (empty($_FILES['file']['name'])) {
		$result['message'] = '上传失败, 请选择要上传的文件！';
		die(json_encode($result));
	}
	if ($_FILES['file']['error'] != 0) {
		$result['message'] = '上传失败, 请重试.';
		die(json_encode($result));
	}
	$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	$size = intval($_FILES['file']['size']);
	$originname = $_FILES['file']['name'];
	$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
	$file = file_upload_two($_FILES['file'], $type, $setting['folder'] . $filename);
	if (is_error($file)) {
		$result['message'] = $file['message'];
		die(json_encode($result));
	}
	$pathname = $file['path'];
	$fullname = ATTACHMENT_ROOT . '/' . $pathname;
}

if ($op == 'fetch' || $op == 'upload') {
		if($type == 'image'){
		$thumb = empty($setting['thumb']) ? 0 : 1; 		$width = intval($setting['width']); 
		if(isset($option['thumb'])){
			$thumb = empty($option['thumb']) ? 0 : 1;
		}
		if (isset($option['width']) && !empty($option['width'])) {
			$width = intval($option['width']);
		}
		if ($thumb == 1 && $width > 0) {
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
	}

	$info = array(
		'name' => $originname,
		'ext' => $ext,
		'filename' => $pathname,
		'attachment' => $pathname,
		'url' => tomedia($pathname),
		'is_image' => $type == 'image' ? 1 : 0,
		'filesize' => filesize($fullname),
	);
	if ($type == 'image') {
		$size = getimagesize($fullname);
		$info['width'] = $size[0];
		$info['height'] = $size[1];
	} else {
		$size = filesize($fullname);
		$info['size'] = sizecount($size);
	}
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
		'filename' => $originname,
		'attachment' => $pathname,
		'type' => $type == 'image' ? 1 : ($type == 'audio' ? 2 : 3),
		'createtime' => TIMESTAMP,
	));
	die(json_encode($info));
}

if ($op == 'delete') {
	$id = intval($_GPC['id']);
	$media = pdo_get('core_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(empty($media)) {
		exit('文件不存在或已经删除');
	}
	if(empty($_W['isfounder']) && $_W['role'] != 'manager') {
		exit('您没有权限删除该文件');
	}
	load()->func('file');
	if (!empty($_W['setting']['remote']['type'])) {
		$status = file_remote_delete($media['attachment']);
	} else {
		$status = file_delete($media['attachment']);
	}
	if(is_error($status)) {
		exit($status['message']);
	}
	pdo_delete('core_attachment', array('uniacid' => $uniacid, 'id' => $id));
	exit('success');
}

if ($op == 'local') {
	$types = array('image', 'audio', 'video');
	$type = in_array($_GPC['type'], $types) ? $_GPC['type'] : 'image';
	$typeindex = array('image' => 1, 'audio' => 2, 'video' => 3);
	$condition = ' WHERE uniacid = :uniacid AND type = :type';
	$params = array(':uniacid' => $_W['uniacid'], ':type' => $typeindex[$type]);
	if($dest_dir){
		$condition .= " AND `attachment` LIKE :attachment";	
		$params[':attachment'] = "%{$dest_dir}%";
	}
	$year = intval($_GPC['year']);
	$month = intval($_GPC['month']);
	if($year > 0 || $month > 0) {
		if($month > 0 && !$year) {
			$year = date('Y');
			$starttime = strtotime("{$year}-{$month}-01");
			$endtime = strtotime("+1 month", $starttime);
		} elseif($year > 0 && !$month) {
			$starttime = strtotime("{$year}-01-01");
			$endtime = strtotime("+1 year", $starttime);
		} elseif($year > 0 && $month > 0) {
			$year = date('Y');
			$starttime = strtotime("{$year}-{$month}-01");
			$endtime = strtotime("+1 month", $starttime);
		}
		$condition .= ' AND createtime >= :starttime AND createtime <= :endtime';
		$params[':starttime'] = $starttime;
		$params[':endtime'] = $endtime;
	}

	$page = intval($_GPC['page']);
	$page = max(1, $page);
	$size = $_GPC['pagesize'] ? intval($_GPC['pagesize']) : 32;

	$remote = $_W['setting']['remote'];

	$sql = 'SELECT * FROM '.tablename('core_attachment')." {$condition} ORDER BY id DESC LIMIT ".(($page-1)*$size).','.$size;
	$list = pdo_fetchall($sql, $params, 'id');

	foreach ($list as &$item) {
		$item['url'] = tomedia($item['attachment']);
		$item['createtime'] = date('Y-m-d', $item['createtime']);
		unset($item['uid']);
	}
	$total = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('core_attachment') ." {$condition}", $params);
	message(array('page'=> pagination($total, $page, $size, '', array('before' => '2', 'after' => '2', 'ajaxcallback'=>'null')), 'items' => $list), '', 'ajax');
}


function file_upload_two($file, $type = 'image', $name = '') {
	$harmtype = array('asp', 'php', 'jsp', 'js', 'css', 'php3', 'php4', 'php5', 'ashx', 'aspx', 'exe', 'cgi');
	if (empty($file)) {
		return error(-1, '没有上传内容');
	}
	if (!in_array($type, array('image', 'thumb', 'voice', 'video', 'audio'))) {
		return error(-2, '未知的上传类型');
	}

	global $_W;
	$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
	$ext = strtolower($ext);
	switch($type){
		case 'image':
		case 'thumb':
			$allowExt = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'ico');
			$limit = 4 * 1024;
			break;
		case 'voice':
		case 'audio':
			$allowExt = array('mp3', 'wma', 'wav', 'amr');
			$limit = 6 * 1024;
			break;
		case 'video':
			$allowExt = array('rm', 'rmvb', 'wmv', 'avi', 'mpg', 'mpeg', 'mp4');
			$limit = 100 * 1024;
			break;
	}
	$setting = $_W['setting']['upload'][$type];
	if(!empty($setting)){
		$allowExt = array_merge($setting['extentions'], $allowExt);
	}
	if (!in_array(strtolower($ext), $allowExt) || in_array(strtolower($ext), $harmtype)) {
		return error(-3, '不允许上传此类文件');
	}
	if (!empty($limit) && $limit * 1024 < filesize($file['tmp_name'])) {
		return error(-4, "上传的文件超过大小限制，请上传小于 {$limit}k 的文件555666");
	}
	$result = array();
	if (empty($name) || $name == 'auto') {
		$uniacid = intval($_W['uniacid']);
		$path = "{$type}s/{$uniacid}/" . date('Y/m/');
		mkdirs(ATTACHMENT_ROOT . '/' . $path);
		$filename = file_random_name(ATTACHMENT_ROOT . '/' . $path, $ext);

		$result['path'] = $path . $filename;
	} else {
		mkdirs(dirname(ATTACHMENT_ROOT . '/' . $name));
		if (!strexists($name, $ext)) {
			$name .= '.' . $ext;
		}
		$result['path'] = $name;
	}

	if (!file_move($file['tmp_name'], ATTACHMENT_ROOT . '/' . $result['path'])) {
		return error(-1, '保存上传文件失败');
	}
	$result['success'] = true;
	return $result;
}