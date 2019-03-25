<?php 

global $_W,$_GPC;

load()->web('tpl'); 

$mid=intval($_GPC['mid']);

if(!empty($mid)){

	$result = pdo_delete('chunyu_banshi_member',array('mid' => $mid));

	if (!empty($result)) {

			message('恭喜，用户删除成功！', $this -> createWebUrl('member'), 'success');

	} else {

			message('抱歉，用户删除失败！', $this -> createWebUrl('member'), 'error');

	}
	
	include $this->template('web/member');	
	
}else{
	
	message('抱歉，用户删除失败！', $this -> createWebUrl('member'), 'error');

}

?>