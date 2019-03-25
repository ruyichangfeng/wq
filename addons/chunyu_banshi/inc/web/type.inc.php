<?php 

global $_W,$_GPC;

load()->web('tpl'); 

if ($_W['ispost']) {
	if (checksubmit('submit')) {

		$newdata = array(
			'uniacid'=>$_W['uniacid'],
			'typename'=>$_GPC['typename'],
			'typepic'=>$_GPC['typepic'],
			 );
		$res = pdo_insert('chunyu_banshi_type', $newdata);
		if (!empty($res)) {
			message('恭喜，添加类别成功！', $this -> createWebUrl('type'), 'success');
		} else {
			message('抱歉，添加类别失败！', $this -> createWebUrl('type'), 'error');
		}

	}

}else{
	
	//获取类型列表
	$typelist=pdo_fetchall("SELECT * FROM".tablename('chunyu_banshi_type')."WHERE uniacid=:uniacid ORDER BY tid DESC",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/type');	
	
}

?>