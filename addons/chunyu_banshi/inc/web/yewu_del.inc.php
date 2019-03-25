<?php

global $_W, $_GPC;

$lid=intval($_GPC['lid']);

if(!empty($lid)){
	$result = pdo_delete('chunyu_banshi_yewu',array('lid' => $lid));
	if (!empty($result)) {
			message('恭喜，业务流程删除成功！', $this -> createWebUrl('yewu'), 'success');
	} else {
			message('抱歉，业务流程删除失败！', $this -> createWebUrl('yewu'), 'error');
	}
	
	include $this->template('web/yewu');	
	
}else{
	
	message('抱歉，业务流程删除失败！', $this -> createWebUrl('yewu'), 'error');
}

?>