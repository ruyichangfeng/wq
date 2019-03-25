<?php
global $_W,$_GPC;
load()->func('tpl');
$rid = $_GPC['rid'];
if (isset($_GPC['item']) && $_GPC['item'] == 'ajax' && $_GPC['key'] == 'setting') {

	$data=array(
		'uniacid'=>$_W['uniacid'],
		'uid'=>99999999,
		'ip'=>$_W['clientip'],
		'is_auth'=>1,
		'nickname'=>$_GPC['nickname'],
		'headimgurl'=>tomedia($_GPC['headimgurl']),
		'rid'=>$rid,
		'isadmin'=>1,
		'content'=>$_GPC['content'],
		'dateline'=>time()
	);
	pdo_insert('wxz_wzb_comment', $data);
	$cid=pdo_insertid();
	$data['id'] = $cid;
	$data['dateline'] = date('Y-m-d H:i:s',$data['dateline']);
	echo json_encode(array('s'=>1,'data'=>$data));
	exit;
}
include $this->template('dummyComment');