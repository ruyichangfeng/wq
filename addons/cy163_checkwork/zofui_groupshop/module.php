<?php
/**
 * 众惠团购商城模块定义
 *
 * @author 众惠科技 qq273734268
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('ZOFUI_GROUPSHOP', IA_ROOT . '/addons/zofui_groupshop/');
require ZOFUI_GROUPSHOP . 'class/autoload.php';
class Zofui_groupshopModule extends WeModule {


	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		$_GPC = Util::trimWithArray($_GPC);
		load()->func('tpl');
		load()->model('account');

		if(checksubmit()) {
			load()->func('file');
            $r = mkdirs(ZOFUI_GROUPSHOP . '/cert/'.$_W['uniacid']);
			if(!empty($_GPC['cert'])) {
                $ret = file_put_contents(ZOFUI_GROUPSHOP.'/cert/'.$_W['uniacid'].'/apiclient_cert.pem', trim($_GPC['cert']));
                $r = $r && $ret;
            }
            if(!empty($_GPC['key'])) {
                $ret = file_put_contents(ZOFUI_GROUPSHOP.'/cert/'.$_W['uniacid'].'/apiclient_key.pem', trim($_GPC['key']));
                $r = $r && $ret;
            }
            if(!empty($_GPC['rootca'])) {
                $ret = file_put_contents(ZOFUI_GROUPSHOP.'/cert/'.$_W['uniacid'].'/rootca.pem', trim($_GPC['rootca']));
                $r = $r && $ret;
            }			
			if(!$r) {
                message('证书保存失败, 请保证 /addons/zofui_groupshop/cert/ 目录可写');
            }
			
			
			$dat = array(
				'creditratio'=>$_GPC['creditratio'],//积分抵扣比例
				'adminmobile' => $_GPC['adminmobile'],//联系电话
				'autocancelordertime' => $_GPC['autocancelordertime'],// 自动取消订单
				'autofinishordertime' => $_GPC['autofinishordertime'],//	自动完成订单			
				'kefutype' => $_GPC['kefutype'],//	 客服类型 
				'baidubridge' => $_GPC['baidubridge'],//	 百度商桥
				'qqkefu' => $_GPC['qqkefu'],//	qq客服
				'adminopenid' => $_GPC['adminopenid'],
				'adminnickname' => $_GPC['adminnickname'],
				'adminheadimg' => $_GPC['adminheadimg'],
				'remindmessagetime' => $_GPC['remindmessagetime'],
				
				'commentshow'=>intval($_GPC['commentshow']),//是否显示评价
				'sorttype'=>intval($_GPC['sorttype']),//分类等级
				'iscanrefund'=>intval($_GPC['iscanrefund']),//是否能申请退款
				'isreturncard' => intval($_GPC['isreturncard']),//是否退还卡券
				'isreturncredit' => intval($_GPC['isreturncredit']),//是否退还积分
				'isautorefundgroup' => intval($_GPC['isautorefundgroup']),//是否自动退款失败团订单				
				'ismustfollow' => intval($_GPC['ismustfollow']),//是否必须关注					
				'shoptype' => intval($_GPC['shoptype']),//商城类型	
				
				'shopname' => $_GPC['shopname'],
				'shoptel' => $_GPC['shoptel'],
				'shopaddress' => $_GPC['shopaddress'],
				
				'kdniaoid' => $_GPC['kdniaoid'],
				'kdniaokey' => $_GPC['kdniaokey'],				
				
				'a_id'=>$_GPC['a_id'],//收徒成功模板
				'a_item'=>$_GPC['a_item'],
				'a_remark'=>$_GPC['a_remark'],

				'b_id'=>$_GPC['b_id'],//获得佣金模板参数设置
				'b_item'=>$_GPC['b_item'],
				'b_remark'=>$_GPC['b_remark'],
				
				'c_id'=>$_GPC['c_id'],//提现成功模板参数设置
				'c_item'=>$_GPC['c_item'],
				'c_remark'=>$_GPC['c_remark'],

				'd_id'=>$_GPC['d_id'],//支付成功模板参数设置
				'd_item'=>$_GPC['d_item'],
				'd_remark'=>$_GPC['d_remark'],

				'e_id'=>$_GPC['e_id'],//发货成功模板参数设置
				'e_item'=>$_GPC['e_item'],
				'e_remark'=>$_GPC['e_remark'],

				'f_id'=>$_GPC['f_id'],//订单完成模板参数设置
				'f_item'=>$_GPC['f_item'],
				'f_remark'=>$_GPC['f_remark'],

				'g_id'=>$_GPC['g_id'],//退款成功模板参数设置
				'g_item'=>$_GPC['g_item'],
				'g_remark'=>$_GPC['g_remark'],
				
				'h_id'=>$_GPC['h_id'],//退款成功模板参数设置
				'h_item'=>$_GPC['h_item'],
				'h_remark'=>$_GPC['h_remark'],	
				
				'i_id'=>$_GPC['i_id'],//退款资金变动模板参数设置
				'i_item'=>$_GPC['i_item'],
				'i_remark'=>$_GPC['i_remark'],	
				
				'j_id'=>$_GPC['j_id'],//分销成功模板参数设置
				'j_item'=>$_GPC['j_item'],
				'j_remark'=>$_GPC['j_remark'],				
				
				'k_id'=>$_GPC['k_id'],//自营商品售出提醒
				'k_item'=>$_GPC['k_item'],
				'k_remark'=>$_GPC['k_remark'],	

				'l_id'=>$_GPC['l_id'],//商品被分销提醒
				'l_item'=>$_GPC['l_item'],
				'l_remark'=>$_GPC['l_remark'],				
				
				'adminopenid'=>$_GPC['adminopenid'],//给管理员发的				
				
				'sharetitle'=>$_GPC['sharetitle'],//标题
				'sharedesc'=>$_GPC['sharedesc'],//描述				
				'sharepic'=>$_GPC['sharepic']	//图片	
				
            );
			if ($this->saveSettings($dat)) {
                message('保存成功', 'refresh');
            }
		}


if(!pdo_fieldexists('zofui_groupshop_order', 'sendtype')) {
	pdo_query("ALTER TABLE ".tablename('zofui_groupshop_order')." ADD `sendtype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0物流配送 1上店自提';");
}

if(!pdo_fieldexists('zofui_groupshop_good', 'isselftake')) {
	pdo_query("ALTER TABLE ".tablename('zofui_groupshop_good')." ADD `isselftake` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0关闭上店自提 1开启';");
}

if(!pdo_indexexists('zofui_groupshop_order', 'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('zofui_groupshop_order')." ADD INDEX uniacid(`uniacid`);");
}
if(!pdo_indexexists('zofui_groupshop_order', 'userid')) {
  pdo_query("ALTER TABLE ".tablename('zofui_groupshop_order')." ADD INDEX userid(`userid`);");
}
if(!pdo_indexexists('zofui_groupshop_order', 'openid')) {
  pdo_query("ALTER TABLE ".tablename('zofui_groupshop_order')." ADD INDEX openid(`openid`);");
}
if(!pdo_indexexists('zofui_groupshop_order', 'orderid')) {
  pdo_query("ALTER TABLE ".tablename('zofui_groupshop_order')." ADD INDEX orderid(`orderid`);");
}
if(!pdo_indexexists('zofui_groupshop_order', 'uorderid')) {
  pdo_query("ALTER TABLE ".tablename('zofui_groupshop_order')." ADD INDEX uorderid(`uorderid`);");
}

if(!pdo_indexexists('zofui_groupshop_user', 'openid')) {
  pdo_query("ALTER TABLE ".tablename('zofui_groupshop_user')." ADD INDEX openid(`openid`);");
}
		
if(!pdo_fieldexists('zofui_groupshop_sort', 'pic')) {
  pdo_query("ALTER TABLE ".tablename('zofui_groupshop_sort')." ADD  `pic` varchar(350) DEFAULT NULL;");
}

		
		//这里来展示设置项表单
		include $this->template('web/setting');
	}

}