<?php
global $_W, $_GPC;

load()->web('tpl'); 
//基础设置
if ($_W['ispost']) {
	
	if (checksubmit('submit')) {

	//获取基础设置详情
	$base=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_base')."WHERE uniacid=:uniacid",array(':uniacid'=>$_W['uniacid']));
	if(empty($base)){
		$newdata = array(
			'uniacid'=>$_W['uniacid'],
			'title'=>$_GPC['title'],
			'jigou'=>$_GPC['jigou'],
			'didian'=>$_GPC['didian'],
			'phone'=>$_GPC['phone'],
			'lcpic'=>$_GPC['lcpic'],
			'typepic'=>$_GPC['typepic'],
			'ewm'=>$_GPC['ewm'],
			'zhichi'=>$_GPC['zhichi'],
			'shijian'=>$_GPC['shijian'],
			 );
		$res = pdo_insert('chunyu_banshi_base', $newdata);
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('base'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('base'), 'error');
		}
	}else{
		$newdata = array(
			'uniacid'=>$_W['uniacid'],
			'title'=>$_GPC['title'],
			'jigou'=>$_GPC['jigou'],
			'didian'=>$_GPC['didian'],
			'phone'=>$_GPC['phone'],
			'lcpic'=>$_GPC['lcpic'],
			'typepic'=>$_GPC['typepic'],
			'ewm'=>$_GPC['ewm'],
			'zhichi'=>$_GPC['zhichi'],
			'shijian'=>$_GPC['shijian'],
			 );
		$res = pdo_update('chunyu_banshi_base', $newdata,array('id'=>$base['id']));
		if (!empty($res)) {
			message('恭喜，更新成功！', $this -> createWebUrl('base'), 'success');
		} else {
			message('抱歉，更新失败！', $this -> createWebUrl('base'), 'error');
		}
	}

	}

}else{
	
	//获取基础设置详情
	$base=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_base')."WHERE uniacid=:uniacid",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/base');	
	
}


?>