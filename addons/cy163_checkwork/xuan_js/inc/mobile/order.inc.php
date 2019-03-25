<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
//获取系统配置
$config =m('member')->getconfig();
$uidopenid=m('member')->get_uidopenid();
if ($_GPC['op']=="pay") {
	//发起支付
	$sql = "SELECT * FROM " . tablename('xuan_js_order') . " where tid=:tid and uniacid=:uniacid";
    $order = pdo_fetch($sql, ['tid'=>$_GPC['tid'],'uniacid'=>$_W['uniacid']]);
    if ($order['status']=='COMPLETE') {
    	message('平台外支付请联系卖家！', $this->createMobileUrl('person',['op'=>'buyorder']), 'success');
    }
    $params = array(
        'tid' => $order['tid'],      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
        'ordersn' => $order['tid'],  //收银台中显示的订单号
        'title' => '商品购买',          //收银台中显示的标题
        'fee' => $order['money']      //收银台中显示需要支付的金额,只能大于 0
           
    );
    $this->pay($params);
	//include $this->template('pay');
	die();
}
if ($_GPC['op']=="success") {

	include $this->template('success');
	die();
}
$id=$_GPC['goodsid'];
if ($id) {
	//获取商品
	$goods=m('goods')->getone($id);
	$imgk=explode('@',$goods['img']);
	//获取用户
	$user=m('member')->getinfo($goods['uid'],'nickname');
	
	$uidopenid=m('member')->get_uidopenid();
	$ziliao=m('user')->getziliao($uidopenid['uid']);

}
include $this->template('order');