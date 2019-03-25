<?php
global $_W, $_GPC;

$tid=intval($_GPC['tid']);

if(!empty($tid)){
	$result = pdo_delete('chunyu_banshi_type',array('tid' => $tid));
	if (!empty($result)) {
			message('恭喜，业务类别删除成功！', $this -> createWebUrl('type'), 'success');
	} else {
			message('抱歉，业务类别删除失败！', $this -> createWebUrl('type'), 'error');
	}
	
	include $this->template('web/type');	
	
}else{
	
	message('抱歉，业务类别删除失败！', $this -> createWebUrl('type'), 'error');
}

?>