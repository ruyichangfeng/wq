<?php 
global $_W,$_GPC;
load()->web('tpl'); 
$lid=$_GPC['lid'];
if ($_GPC['lid']) {
	$yewulist=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_yewu')."WHERE uniacid=:uniacid AND lid=:lid",array(':uniacid'=>$_W['uniacid'],':lid'=>$lid));
	$typelist=pdo_fetchall("SELECT * FROM".tablename('chunyu_banshi_type')."WHERE uniacid=:uniacid ORDER BY tid DESC",array(':uniacid'=>$_W['uniacid']));
}
if($_W['ispost']){
	if (checksubmit('submit')) {
		$newdata = array(
			'uniacid'=>$_W['uniacid'],
			'lname'=>$_GPC['lname'],
			'lpic'=>$_GPC['lpic'],
			'ljieshao'=>$_GPC['ljieshao'],
			'tid'=>$_GPC['tid'],
			'ltiaojian'=>$_GPC['ltiaojian'],
			'lcailiao'=>$_GPC['lcailiao'],
			'lliucheng'=>$_GPC['lliucheng'],
			'lxiazai'=>$_GPC['lxiazai'],
			 );

		$res = pdo_update('chunyu_banshi_yewu', $newdata,array('lid'=>$lid));
		
		if (!empty($res)) {
			message('恭喜，业务流程编辑成功！', $this -> createWebUrl('yewu'), 'success');
		} else {
			message('抱歉，业务流程编辑失败！', $this -> createWebUrl('yewu'), 'error');
		}

	}

}
include $this->template('web/yewu_edit');