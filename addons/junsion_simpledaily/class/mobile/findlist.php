<?php
global $_W,$_GPC;
$cfg = $this->module['config'];
$pindex = max(1,$_GPC['page']);
$psize = 3;
if ($pindex==1){
	$psize = 9;
}
$list = pdo_fetchall("select w.title,w.cover,w.id,m.id as mid,m.avatar,m.nickname from ".tablename($this->modulename.'_works')." w join ".tablename($this->modulename.'_member')." m on m.openid=w.openid and m.status=0 where w.weid='{$_W['uniacid']}' and w.find=1 and w.type=0 and w.status=0 order by w.sort desc,w.createtime desc limit ".($pindex-1)*$psize.",".$psize);
if (!empty($list)){
	foreach ($list as $k =>$value){
		$list[$k]['id'] = base64_encode($value['id']);
	}
}

if ($_W['isajax']){
	if (!empty($list)) die(json_encode(array('status'=>'ok','list'=>$list)));
	else die(json_encode(array('status'=>'err','msg'=>'没有更多数据')));
}
include $this->template('findlist');