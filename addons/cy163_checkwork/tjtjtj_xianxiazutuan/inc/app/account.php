<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:01
 */
$action = $_GPC['action'];
$addressModel = \App\Service\Factory::proAddressModel();
$orderModel   = \App\Service\Factory::proOrderModel();

/*++++++++++++++++++++++++++++++++++++++++ 地址操作 开始 -------------------------------------------------*/
if ($action == 'address' || $action == 'address_select') {
    if (isset($_GPC['prev'])) {
        $_SESSION['prev'] = $_GPC['prev'];
    }
    $addresses = $addressModel->getUserAddress($_SESSION[C('session_prefix').'user']['uid']);
    include_once $this->template('address_list');exit;
}
if ($action == 'address_add') {
    include_once $this->template('address_add');exit;
}
if ($action == 'address_create') {
    $addressModel->setDefault();
    $addressModel->insert();
    message('添加成功', $this->createMobileUrl('account', array('action' => 'address')), 'success');
}
if ($action == 'address_setdefault') {
    $aid = intval($_GPC['uid']);
    $addressModel->setDefault($aid, $_SESSION[C('session_prefix').'user']['uid']);
    message('设置成功', $this->createMobileUrl('account', array('action' => 'address')), 'success');
}
if ($action == 'address_edit') {
    $uid     = intval($_GPC['uid']);
    $address = $addressModel->setUid($uid)->where()->get();
    include_once $this->template('address_edit');exit;
}
if ($action == 'address_update') {
    $uid = intval($_POST['uid']);
    $addressModel->setUid($uid)->where()->update();
    message('编辑成功', $this->createMobileUrl('account', array('action' => 'address')), 'success');
}
if ($action == 'address_delete') {
    $uid = intval($_GPC['uid']);
    pdo_query('DELETE FROM '.tablename('tjtjtj_xxzt_address').' WHERE uid = :uid', array(':uid' => $uid));
    message('删除成功', $this->createMobileUrl('account', array('action' => 'address')), 'success');
}
if ($action == 'address_selected') {
    $address = $addressModel->setUid($_GPC['uid'])->where()->get();
    $_SESSION['order']['address'] = $address;
    header('Location:'. urldecode($_SESSION['prev']));exit;
}
/*++++++++++++++++++++++++++++++++++++++++ 地址操作 结束 -------------------------------------------------*/

/*++++++++++++++++++++++++++++++++++++++++ 订单操作 开始 -------------------------------------------------*/
//订单列表
if ($action == 'order_list') {
    $where = $_GPC['whe'] == '' ? 'default' : $_GPC['whe'];
    switch ($where) {
        case 'default':
            $orders = pdo_fetchall(
                'SELECT o.*,g.name AS goodsname,g.logo,g.gprice,g.sprice,a.name AS username,a.mobile FROM '.tablename('tjtjtj_xxzt_orders').' AS o
                LEFT JOIN '.tablename('tjtjtj_xxzt_goods').' AS g ON o.goodsid = g.uid
                LEFT JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON o.aid = a.uid
                WHERE o.userid = :userid AND o.sid = :sid
                ORDER BY o.create_at DESC',
                array(
                    ':userid' => $_SESSION[C('session_prefix').'user']['uid'],
                    ':sid'    => $_W['uniacid']
                )
            );
            break;
        case 'status':
            $status = (intval($_GPC['status']) >= -3 && intval($_GPC['status']) <= 3) ? intval($_GPC['status']) : 0;
            $orders = pdo_fetchall(
                'SELECT o.*,g.name AS goodsname,g.logo,g.gprice,g.sprice,a.name AS username,a.mobile FROM '.tablename('tjtjtj_xxzt_orders').' AS o
                LEFT JOIN '.tablename('tjtjtj_xxzt_goods').' AS g ON o.goodsid = g.uid
                LEFT JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON o.aid = a.uid
                WHERE o.userid = :userid AND o.sid = :sid AND o.status = :status
                ORDER BY o.create_at DESC',
                array(
                    ':userid' => $_SESSION[C('session_prefix').'user']['uid'],
                    ':sid'    => $_W['uniacid'],
                    ':status' => $status
                )
            );
            break;
        case 'groups':
            $status = (intval($_GPC['status']) >= -1 && intval($_GPC['status']) <= 1) ? intval($_GPC['status']) : 0;
            $orders = pdo_fetchall(
                'SELECT o.*,g.name AS goodsname,g.logo,g.gprice,g.sprice,a.name AS username,a.mobile FROM '.tablename('tjtjtj_xxzt_orders').' AS o
                LEFT JOIN '.tablename('tjtjtj_xxzt_goods').' AS g ON o.goodsid = g.uid
                LEFT JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON o.aid = a.uid
                INNER JOIN '.tablename('tjtjtj_xxzt_groups_records').' AS gr ON o.uid = gr.orderid AND o.groupid = gr.groupid
                INNER JOIN '.tablename('tjtjtj_xxzt_groups').' AS groups ON o.groupid = groups.uid
                WHERE o.userid = :userid AND o.sid = :sid AND o.buyway = "groups" AND groups.status = :status AND gr.status = 1
                ORDER BY o.create_at DESC',
                array(
                    ':userid' => $_SESSION[C('session_prefix').'user']['uid'],
                    ':sid'    => $_W['uniacid'],
                    ':status' => $status
                )
            );
            break;
    }
    include_once $this->template('order_list');exit;
}
//订单详情
if ($action == 'order_info') {
    $uid = intval($_GPC['uid']);
    $order = pdo_fetch(
        'SELECT o.*,g.name AS goodsname,g.logo,g.gprice,g.sprice,a.name AS username,a.mobile,a.province,a.city,a.address FROM '.tablename('tjtjtj_xxzt_orders').' AS o
        LEFT JOIN '.tablename('tjtjtj_xxzt_goods').' AS g ON o.goodsid = g.uid
        LEFT JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON o.aid = a.uid
        WHERE o.uid = :uid
        ',
        array(
            ':uid' => $uid,
        )
    );
    if (!$order) {
        alert('订单不存在', referer(), 'error');
    }
    include_once $this->template('order_info');exit;
}
if ($action == 'order_cancel') {
    $uid   = intval($_GPC['uid']);
    $order = pdo_get('tjtjtj_xxzt_orders', array('uid' => $uid));
    !$order && message('订单不存在', 'referer', 'error');
    if ($order['userid'] == $_SESSION[C('session_prefix').'user']['uid']) {
        $order['status'] != 0 && message('无法取消订单', 'referer', 'error');
        pdo_update('tjtjtj_xxzt_orders', array('status' => -1), array('uid' => $uid));

        //微信通知 开始
        $user    = \App\Service\Factory::proUserModel($order['userid'])->get();
        $address = \App\Service\Factory::proAddressModel($order['aid'])->get();
        sendOrderCancelMessage($user['openid'], array_merge($address, $order));
        //微信通知 结束

        message('取消订单成功', referer(), 'success');
    } else {
        message('无权限操作', 'referer', 'error');
    }
}
//1.已退款订单
$donerefund  = count($orderModel->queryOrderByStatus(-3));
//2.退款中订单
$doingfefund = count($orderModel->queryOrderByStatus(-2));
//3.已取消订单
$cancelorder = count($orderModel->queryOrderByStatus(-1));
//4.未支付订单
$nopayorder  = count($orderModel->queryOrderByStatus(0));
//5.已支付订单
$dopayorder  = count($orderModel->queryOrderByStatus(1));
//6.已发货订单
$sendedorder = count($orderModel->queryOrderByStatus(2));
//7.已收货订单
$receorder   = count($orderModel->queryOrderByStatus(3));
/*++++++++++++++++++++++++++++++++++++++++ 订单操作 结束 -------------------------------------------------*/

/*++++++++++++++++++++++++++++++++++++++++ 我的收藏 开始 -------------------------------------------------*/
if ($action == 'mylikes') {
    $groups = pdo_fetchall(
        'SELECT
            gr.uid AS groupid,gr.needpeople,gr.donepeople,gr.intro,gr.create_at,gr.end_at,gr.status,
            good.*
            FROM '.tablename('tjtjtj_xxzt_likes').' AS l
            INNER JOIN '.tablename('tjtjtj_xxzt_groups').' AS gr ON l.groupid = gr.uid
            INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS good ON gr.gid = good.uid
            WHERE l.userid = :userid AND l.sid = :sid',
        array(':userid' => $_SESSION[C('session_prefix').'user']['uid'], ':sid' => $_W['uniacid']));
    include_once $this->template('future');exit;
}
/*++++++++++++++++++++++++++++++++++++++++ 我的收藏 结束 -------------------------------------------------*/

$menus = pdo_fetchall(
        'select * from '.tablename('tjtjtj_xxzt_account_menu').' where sid = :sid order by sort ASC',
        array(':sid' => $_W['uniacid'])
    );


include_once $this->template('account');