<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 12:41
 */

if ($_W['ispost']) {
    $orderController = \App\Service\Factory::proOrderController();
    $order = $orderController->create();
    $params = array(
        'tid' => $order['orderid'],
        'ordersn' => $order['orderid'],
        'title' => '组团订单',
        'fee'   => floatval($order['fee']),
        'user'  => $_W['member']['uid']
    );
    $this->pay($params);
    exit;
}

$groupid = intval($_GPC['groupid']);
$groups  = \App\Service\Factory::proGroupsModel()->getGroups($groupid);

//获取地址
if (!isset($_SESSION['order']['address'])) {
    $addressModel = \App\Service\Factory::proAddressModel();
    $address      = $addressModel->getUserDefault($_SESSION[C('session_prefix').'user']['uid']);
    $_SESSION['order']['address'] = $address;
} else {
    $address = $_SESSION['order']['address'];
}

//物流费用
$usd = \App\Service\Logic\Usd::usd($_SESSION['order']['address']['uid'], $groups['lid']);

include_once $this->template('order_details');