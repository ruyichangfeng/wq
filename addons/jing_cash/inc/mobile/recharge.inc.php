<?php
/**
 * 餐饮商城模块微站定义
 *
 * @author 刘靜
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
$config = $this->module['config'];
if ($config['closecz'] == 1) {
	message('充值业务暂时不可使用，请联系管理员');
}
if (!empty($config['rule'])) {
	$rule = iunserializer($config['rule']);
	foreach ($rule as &$value) {
        $value['fh'] = isset($value['fh']) ? $value['fh'] : 1;
    }
}
$payopenid = $_GPC['oauthopenid'];
if (empty($payopenid)) {
	if ($config['oauth'] == 0) { //不借用权限
		if (empty($_W['openid'])) {
			message('无法获取到您的openid，请稍后重试');
		}else{
			$payopenid = $_W['openid'];
		}
	}else{
		$acid = $config['oauth'];
		$oauth = account_fetch($acid);
		$from = 'recharge';
		$url = $_W['siteroot'].'app'.str_replace('./', '/', $this->createMobileUrl('oauth'));
		$callback = urlencode($url);
		$forward = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$oauth['key']."&redirect_uri=".$callback."&response_type=code&scope=snsapi_base&state=".$from."#wechat_redirect";
		header('Location: ' . $forward);
		exit();
	}
}
include $this->template('recharge');
?>