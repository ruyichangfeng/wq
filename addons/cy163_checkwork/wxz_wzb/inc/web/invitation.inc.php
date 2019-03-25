<?php

global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$rid = $_GPC['rid'];

load()->func('tpl');

$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_invitation')." WHERE uniacid=:uniacid AND rid=:rid",array(':uniacid'=>$uniacid,':rid'=>$rid));

if ($_POST) {
	$file = files($_FILES);
    $data = array();
    $data['rid'] = $rid;
    $data['uniacid'] = $uniacid;
    $data['bg'] = $file['path'] ? $file['path'] : $list['bg'];
    $data['desc1'] = $_GPC['desc1'];
    $data['desc2'] = $_GPC['desc2'];
    $data['desc3'] = $_GPC['desc3'];
    $data['desc4'] = $_GPC['desc4'];

    if(!empty($list)){
        pdo_update('wxz_wzb_invitation',$data,array('rid'=>$rid,'uniacid'=>$uniacid));
        message('编辑成功',referer(),'success');
    }else{
        pdo_insert('wxz_wzb_invitation',$data);
        message('新增成功',$this->createWebUrl('invitation',array('rid'=>$rid)),'success');
    }

}

include $this->template('invitation');

function files($files){
	load()->func('file');
	$file = file_upload($files['bg']);
	$fullname = ATTACHMENT_ROOT .  $file['path'];
	if ((($files["bg"]["type"] == "image/gif") || ($files["bg"]["type"] == "image/jpeg") || ($files["bg"]["type"] == "image/png"))){
		if ($files["bg"]["error"] > 0){
			message('图片太大',$this->createWebUrl('invitation',array('rid'=>$rid)),'error');
		} else {
			move_uploaded_file($files["bg"]["tmp_name"], $fullname);
		}
	}
	return $file;
}
?>