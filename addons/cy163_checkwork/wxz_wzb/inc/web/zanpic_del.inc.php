<?php
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$id = intval($_GPC['id']);
$category = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_zanpic')." WHERE uniacid=:uniacid AND id=:id",array(':uniacid'=>$uniacid,':id'=>$id));
if(empty($category)){
	message('此项不存在或是已经被删除',referer());
}else{
	pdo_delete('wxz_wzb_zanpic',array('id'=>$id,'uniacid'=>$uniacid));
}
message('删除成功',referer());
