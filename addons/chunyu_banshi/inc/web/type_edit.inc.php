<?php
global $_W, $_GPC;

if($_GPC['tid']){
	$res=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_type')."WHERE tid=:tid",array(':tid'=>$_GPC['tid']));
}

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'typename'=>$_GPC['typename'],				
			'typepic'=>$_GPC['typepic'],
			 );
		$res = pdo_update('chunyu_banshi_type', $newdata,array('tid'=>$_GPC['tid']));
		if (!empty($res)) {
			message('恭喜，类别编辑成功！', $this -> createWebUrl('type'), 'success');
		} else {
			message('抱歉，类别编辑失败！', $this -> createWebUrl('type'), 'error');
		}

	}
}

include $this->template('web/type_edit');

?>