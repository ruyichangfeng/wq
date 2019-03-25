<?php
/**
 * 线下组团模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Tjtjtj_xianxiazutuanModuleSite extends WeModuleSite {

	//前台程序 inc/app
	public function __app($action){
		global $_W,$_GPC;
		include_once 'autoload.php';
		include_once 'App/Common/Function.php';
		$app = include_once 'App/config.php';
		$_SESSION['xxzt_config'] = array_merge($app, $this->module['config']);
		/* 执行中间件 */
		foreach ($app['middleware'] as $middleware) {
			$middleware->next();
		}
		define('APP_TEMP_PATH', MODULE_URL.'template/mobile/');
		include_once  'inc/app/'.strtolower(substr($action,8)).'.php';
	}
	public function doMobileIndex() {
		//首页
		$this->__app(__FUNCTION__);
	}
	public function doMobileGroups() {
		//首页
		$this->__app(__FUNCTION__);
	}
	public function doMobileAccount() {
		//用户中心界面
		$this->__app(__FUNCTION__);
	}
	public function doMobileOrder() {
		//用户中心界面
		$this->__app(__FUNCTION__);
	}
	//WEB应用
	//后台程序 inc/web文件夹下
	public function __web($f_name){
		global $_W , $_GPC;
		include_once 'autoload.php';
		include_once 'App/Common/Function.php';
		include_once  'inc/web/'.strtolower(substr($f_name,5)).'.inc.php';
	}
	public function doWebGoods() {
		//这个操作被定义用来呈现 管理中心导航菜单  商品管理
		$this->__web(__FUNCTION__);
	}
	public function doWebUsers() {
		//这个操作被定义用来呈现 管理中心导航菜单  商品管理
		$this->__web(__FUNCTION__);
	}
	public function doWebLogistics() {
		//这个操作被定义用来呈现 管理中心导航菜单   物流表管理
		$this->__web(__FUNCTION__);
	}
	public function doWebGoodscategory() {
		//这个操作被定义用来呈现 管理中心导航菜单  商品分类管理
		$this->__web(__FUNCTION__);
	}
	public function doWebSliders() {
		//这个操作被定义用来呈现 管理中心导航菜单  幻灯片管理
		$this->__web(__FUNCTION__);
	}
	public function doWebOrders() {
		//这个操作被定义用来呈现 管理中心导航菜单  订单管理
		$this->__web(__FUNCTION__);
	}
	public function doWebCharts() {
		//这个操作被定义用来呈现 管理中心导航菜单
		$this->__web(__FUNCTION__);
	}
	public function doWebGroups() {
		//组团管理
		$this->__web(__FUNCTION__);
	}

	/**
	 * 支付回调
	 */
	public function payResult($params)
	{
		include_once 'autoload.php';
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
			pdo_update('tjtjtj_xxzt_orders', array('remoteid' => $params['tag']['transaction_id'], 'status' => 1), array('orderid' => $params['tid']));
			$orderModel = \App\Service\Factory::proOrderModel();
			$order = $orderModel->where(array('orderid' => $params['tid']))->get();
			\App\Service\Factory::proOrderController()->runObserver($order);
		}
		if ($params['from'] == 'return') {
			if ($params['result'] == 'success') {
				message('支付成功！', $this->createMobileUrl('account'), 'success');
			} else {
				message('支付失败！', $this->createMobileUrl('account'), 'error');
			}
		}
	}

}