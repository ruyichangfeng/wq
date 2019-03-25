<?php

/**
 * AutoCheckRefundStatus
 * Maybe occupy resource
 * So get one record per view
 * and del resource
 * @author qsnh
*/

namespace App\Middleware;

use \Core\Middleware\Middleware;

class CheckRefundStatus implements Middleware
{
	public function next($data = null)
	{
		global $_W;
		//Get SubmitRefund
		$tmp = pdo_fetch('select * from '.tablename('tjtjtj_xxzt_refunds').' where sid = :sid and status = 0 limit 1', array(':sid' => $_W['uniacid']));
		if ($tmp) {
			$refund = new \Core\Lib\Weixin\Refund();
			$refund->setKey($_SESSION['xxzt_config']['weixin_secret']);
			$refund->SetOut_refund_no($tmp['refundid']);
			//Config
			$weixin = array(
			        'appid' => $_W['uniaccount']['key'],
			        'mchid' => $_SESSION['xxzt_config']['weixin_mchid'],
			 );
			$res = \Core\Lib\Weixin::refundQuery($refund, $weixin);
			$arr = simplest_xml_to_array($res);
			if ($arr['return_code'] == 'SUCCESS' && $arr['return_msg'] == 'OK' && $arr['result_code'] == 'SUCCESS') {
				//Change Status
				pdo_update('tjtjtj_xxzt_refunds', array('status' => 1), array('uid' => $tmp['uid']));
				pdo_update('tjtjtj_xxzt_orders', array('status' => -3), array('uid' => $tmp['oid']));
			}
		}
	}
}