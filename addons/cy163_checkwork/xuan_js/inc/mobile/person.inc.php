<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$op=!empty($_GPC['op'])?$_GPC['op']:'index';
$uidopenid=m('member')->get_uidopenid();
$config=$this->config();
if ($op=="index") {
	$xiaoxi=m('chat')->allnoread($uidopenid['uid']);
	//个人中心首页
	$huiyuan=mc_fetch($uidopenid['uid']); 
	//总收入
	$inmoney=pdo_fetchall('select sum(money) as money from '.tablename('xuan_js_order').' where buid='.$uidopenid['uid'].' and status="COMPLETE"');
	$inmoney[0]['money']=$inmoney[0]['money']?$inmoney[0]['money']:0;
	
	/******正在发布*******/
	//发布总数
	$zong = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xuan_js_fabu'). "where uid=:uid and uniacid=:uniacid", array(':uid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid']));
	//正在出售
	$chushou = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xuan_js_fabu'). "where uid=:uid and uniacid=:uniacid and shengyu != 0 and status !=0", array(':uid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid']));
	//已购买
	$yigou=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xuan_js_order'). "where uid=:uid and uniacid=:uniacid and status!=-1", array(':uid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid']));
	//已出售
	$yimai=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xuan_js_order'). "where buid=:buid and uniacid=:uniacid and status!=-1", array(':buid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid']));
	$zong=!empty($zong)?$zong:0;
	$chushou=!empty($chushou)?$chushou:0;
	$yigou=!empty($yigou)?$yigou:0;
	$yimai=!empty($yimai)?$yimai:0;
	
	$user=m('member')->getinfo($uidopenid['uid'],'avatar,gender,nickname,residecity,uid,createtime');

	include $this->template('person');
}elseif ($op=="ziliao") {
	$ziliao=m('user')->getziliao($uidopenid['uid']);

	//资料修改页面
	if ($_POST) {
		m('user')->updateziliao($_POST['weixin'],$_POST['phone']);
		exit;
	}
	include $this->template('ziliao');
}elseif ($op=="wallet") {
	$huiyuan=mc_fetch($uidopenid['uid']);
	//提现处理中
	$money=pdo_fetchall('select sum(money) as money from '.tablename('xuan_js_tixian').' where uid='.$uidopenid['uid'].' and status=0');
	$money[0]['money']=$money[0]['money']?$money[0]['money']:0;
	//总收入
	$inmoney=pdo_fetchall('select sum(money) as money from '.tablename('xuan_js_order').' where buid='.$uidopenid['uid'].' and status="COMPLETE"');
	$inmoney[0]['money']=$inmoney[0]['money']?$inmoney[0]['money']:0;
	include $this->template('wallet');
}elseif ($op=="myfabu") { 
	$list=m('fabu')->getalluid($uidopenid['uid']);
	
	include $this->template('myfabu');
}elseif ($op=="buyorder") {
	$buyorder=pdo_fetchall("SELECT * FROM ".tablename('xuan_js_order')." where uid=:uid and uniacid=:uniacid order by id desc", array(':uid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid']));

	foreach ($buyorder as $k => &$v) {
		$v['goods']=m('goods')->getone($v['fid']);
		$v['guishu']=m('member')->getinfo($v['buid'],'avatar,nickname,uid');
	}
	include $this->template('buyorder');
}elseif ($op=="outorder") {
	$buyorder=pdo_fetchall("SELECT * FROM ".tablename('xuan_js_order')." where buid=:buid and uniacid=:uniacid order by id desc", array(':buid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid']));

	foreach ($buyorder as $k => &$v) {
		$v['goods']=$goods=m('goods')->getone($v['fid']);
		$v['guishu']=m('member')->getinfo($v['buid'],'avatar,nickname,uid');
	}
	include $this->template('outorder');
}elseif ($op=="orderdetail1") { 

	$orderdetail=pdo_fetch("SELECT * FROM ".tablename('xuan_js_order')." where uid=:uid  and id=:id and uniacid=:uniacid", array(':uid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));

    	$orderdetail['goods']=m('goods')->getone($orderdetail['fid']);
    	$orderdetail['chushouren']=m('member')->getinfo($orderdetail['buid'],'avatar,nickname,uid');
    	$orderdetail['goumairen']=m('member')->getinfo($orderdetail['uid'],'avatar,nickname,uid');
    //卖家电话
    $ziliao1=m('user')->getziliao($orderdetail['buid']);
    //买家电话
    $ziliao2=m('user')->getziliao($orderdetail['uid']);

	include $this->template('orderdetail');
}elseif ($op=="orderdetail2") {

	$orderdetail=pdo_fetch("SELECT * FROM ".tablename('xuan_js_order')." where buid=:buid  and id=:id and uniacid=:uniacid", array(':buid'=>$uidopenid['uid'],':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));

    	$orderdetail['goods']=m('goods')->getone($orderdetail['fid']);
    	$orderdetail['chushouren']=m('member')->getinfo($orderdetail['buid'],'avatar,nickname,uid');
    	$orderdetail['goumairen']=m('member')->getinfo($orderdetail['uid'],'avatar,nickname,uid');
    //卖家电话
    $ziliao1=m('user')->getziliao($orderdetail['buid']);
    //买家电话
    $ziliao2=m('user')->getziliao($orderdetail['uid']);

	include $this->template('orderdetail');
}elseif ($op=="shoucang") {


	$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
	$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'xuan_js'));
	$settings = iunserializer($settings);

	$shoucang=pdo_fetchall("SELECT * FROM ".tablename('xuan_js_shoucang')." where uid=:uid  order by id desc", array(':uid'=>$uidopenid['uid']));
	foreach ($shoucang as $k => &$v) {
		$v['goods']=m('goods')->getone($v['fid']);
		if (empty($v['goods']['title'])) {
			unset($shoucang[$k]);
		}
		
	}

	include $this->template('shoucang');
}


