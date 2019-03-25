<?php

global $_W,$_GPC;

load()->web('tpl'); 

//基础设置

if ($_W['ispost']) {

	if (checksubmit('submit')) {

	//获取分享设置详情

	$share=pdo_fetch("SELECT * FROM ".tablename('chunyu_banshi_share')." WHERE uniacid=:uniacid",array(':uniacid'=>$_W['uniacid']));

	if(empty($share)){

		$newdata = array(

			'uniacid'=>$_W['uniacid'],

			'sharetitle'=>$_GPC['sharetitle'],

			'shareimg'=>$_GPC['shareimg'],

			'sharetext'=>$_GPC['sharetext'],

			'gzurl'=>$_GPC['gzurl'],

			'status'=>1,

			'createtime'=>time(),

			 );

		$res = pdo_insert('chunyu_banshi_share', $newdata);

		if (!empty($res)) {

			message('恭喜，分享设置成功！', $this -> createWebUrl('share'), 'success');

		} else {

			message('抱歉，分享设置失败！', $this -> createWebUrl('share'), 'error');

		}

	}else{

		$newdata = array(

			'uniacid'=>$_W['uniacid'],

			'sharetitle'=>$_GPC['sharetitle'],

			'shareimg'=>$_GPC['shareimg'],

			'sharetext'=>$_GPC['sharetext'],

			'gzurl'=>$_GPC['gzurl'],

			 );

		$res = pdo_update('chunyu_banshi_share', $newdata,array('sid'=>$share['sid']));

		if (!empty($res)) {

			message('恭喜，设置成功！', $this -> createWebUrl('share'), 'success');

		} else {

			message('抱歉，设置失败！', $this -> createWebUrl('share'), 'error');

		}

	}

	}

}else{

	//获取分享设置详情

	$share=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_share')."WHERE uniacid=:uniacid",array(':uniacid'=>$_W['uniacid']));

	include $this->template('web/share');	

}
