<?php

if ($_GPC['action'] == 'refund') {
    $uid   = intval($_GPC['uid']);
    $order = pdo_get('tjtjtj_xxzt_orders', array('uid' => $uid));
    !$order && message('订单不存在', 'referer', 'error');

    //print_r(pdo_getall('tjtjtj_xxzt_orders', ['sid' => $_W['uniacid']], ['remoteid', 'uid']));exit;

    $refundO = pdo_get('tjtjtj_xxzt_refunds', array(
        'sid' => $_W['uniacid'],
        'oid' => $order['uid'],
    ));
    if (!$refundO) {
        //创建退款记录
        $dat = array(
            'sid' => $_W['uniacid'],
            'oid' => $uid,
            'orderid' => $order['orderid'],
            'refundid' => genOrderId(),
            'total_fee' => $order['fee'],
            'refund_fee' => $order['fee'],
            'create_at' => time()
        );
        pdo_insert('tjtjtj_xxzt_refunds', $dat);
        //更新订单状态
        pdo_update('tjtjtj_xxzt_orders', array(
            'status' => -2
        ),array(
            'uid' => $order['uid']
        ));
        $refundO = pdo_get('tjtjtj_xxzt_refunds', array(
            'refundid' => $dat['refundid']
        ));
    }
    //生成PEM证书
    $config = $this->module['config'];
    $pemcert = genPem($_W['uniacid'].'cert', $config['weixin_apiclient_cert']);
    $pemkey  = genPem($_W['uniacid'].'key', $config['weixin_apiclient_key']);
    //生成微信配置
    $weixin = array(
        'appid' => $_W['account']['key'],
        'mchid' => $config['weixin_mchid'],
        'pem'   => array(
            $pemcert,$pemkey
        )
    );
    $refund = new \Core\Lib\Weixin\Refund();
    $refund->setKey($config['weixin_secret']);
    $refund->SetTransaction_id($order['remoteid']);
    $refund->SetTotal_fee($order['fee']*100);
    $refund->SetRefund_fee($order['fee']*100);
    $refund->SetOut_refund_no($refundO['refundid']);
    $refund->SetOp_user_id($weixin['mchid']);
    $response = \Core\Lib\Weixin::refund($refund, $weixin);
    if (is_array($response) && $response['status'] == false) {
        message('退款失败，失败原因：'.$response['code'], 'referer', 'error');
    }
    $response = simplexml_load_string($response);
    if ($response->return_code == 'SUCCESS' && $response->return_msg == 'OK' && $response->result_code == 'SUCCESS') {
        pdo_update('tjtjtj_xxzt_orders', array(
            'status' => -3
        ),array(
            'uid' => $order['uid']
        ));
        pdo_update('tjtjtj_xxzt_refunds', array(
            'status' => 1
        ), array(
            'uid'    => $refundO['uid']
        ));
        message('退款申请已提交', $this->createWebUrl('orders'), 'success');
    } else {
        message('退款失败：'.$response->return_msg.'|'.$response->err_code_des, $this->createWebUrl('orders'), 'error');
    }
}

if (isset($_GPC['deliver'])) {
    $express   = $_GPC['express'];
    $expressid = $_GPC['expressid'];
    if ($express == '' || $expressid == '') {
        message('快递与单号都不能为空', 'referer', 'error');
    } else {
        pdo_update('tjtjtj_xxzt_orders', array('deliver_at' => time(), 'express' => $express , 'expressid' => $expressid, 'status' => 2), array('uid' => $_GPC['uid']));

        //微信通知 开始
        $order = \App\Service\Factory::proOrderModel($_GPC['uid'])->get();
        $user  = \App\Service\Factory::proUserModel($order['userid'])->get();
        sendDeliverMessage($user['openid'], $order);
        //微信通知 结束

        message('发货成功', $this->createWebUrl('orders'), 'success');
    }
}

if ($_GPC['action'] == 'view') {
    $uid   = intval($_GPC['uid']);
    $order = pdo_fetch(
        'SELECT
        o.*,
        g.name AS goodsname,g.logo AS goodslogo,g.stock,g.sales,g.gprice,g.mprice,g.sprice,
        a.name AS username,a.mobile,a.province,a.city,a.county,a.address
        FROM '.tablename('tjtjtj_xxzt_orders').' AS o
        LEFT JOIN '.tablename('tjtjtj_xxzt_goods').' AS g ON o.goodsid = g.uid
        LEFT JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON o.aid = a.uid
        WHERE o.sid = :sid AND o.uid = :uid
        LIMIT 1
        ',
        array(
            ':sid' => $_W['uniacid'],
            ':uid' => $uid
        )
    );
    if (!$order) {
        message('订单不存在', 'referer', 'error');
    }
    include $this->template('ordersmanage');exit;
}


$page     = intval($_GPC['page']);
$page     = $page == 0 ? 1 : $page;
$pagesize = 15;

//全局过滤条件
$where      = '';
if (isset($_GPC['section']) && (strtotime($_GPC['section']['start']) != strtotime($_GPC['section']['end']))) {
    $where  = ' AND (o.create_at >= '.strtotime($_GPC['section']['start']).' AND o.create_at < '.strtotime($_GPC['section']['end']).' ) ';
}
if (isset($_GPC['orderstatus']) && $_GPC['orderstatus'] != 'all') {
    $status = $_GPC['orderstatus'] == 10 ? 0 : intval($_GPC['orderstatus']);
    $where .= 'AND o.status = '.$status.' ';
}
if ($_GPC['ordertype'] == 'single' || $_GPC['ordertype'] == 'groups') {
    $where .= 'AND o.buyway = "'.$_GPC['ordertype'].'" ';
}

if ($_GPC['goodsname'] != '') {
    $count = pdo_fetchcolumn(
        'select count(*) from ' . tablename('tjtjtj_xxzt_orders') . ' AS o
        INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS g ON o.goodsid = g.uid
        where o.sid = :sid AND g.name LIKE "%'.$_GPC['goodsname'].'%"  ' . $where . ' ',
        array(':sid' => $_W['uniacid']));
    $result = pdo_fetchall(
        'select
        o.*,
        goods.name AS goodsname,goods.logo AS goodslogo,
        a.name AS username,a.mobile,a.province,a.city,a.county,a.address
        from ' . tablename('tjtjtj_xxzt_orders') . ' AS o
        INNER JOIN ' . tablename('tjtjtj_xxzt_goods') . ' AS goods ON o.goodsid = goods.uid
        LEFT JOIN ' . tablename('tjtjtj_xxzt_address') . ' AS a ON o.aid = a.uid
        where o.sid = :sid AND goods.name LIKE "%'.$_GPC['goodsname'].'%" ' . $where . '
        order by o.create_at DESC
        limit ' . (($page - 1) * $pagesize) . ',' . $pagesize,
        array(
            ':sid' => $_W['uniacid']
        ));
} elseif ($_GPC['orderid'] != '') {
    $count = 1;
    $result = pdo_fetchall(
        'select
        o.*,
        goods.name AS goodsname,goods.logo AS goodslogo,
        a.name AS username,a.mobile,a.province,a.city,a.county,a.address
        from ' . tablename('tjtjtj_xxzt_orders') . ' AS o
        LEFT JOIN ' . tablename('tjtjtj_xxzt_goods') . ' AS goods ON o.goodsid = goods.uid
        LEFT JOIN ' . tablename('tjtjtj_xxzt_address') . ' AS a ON o.aid = a.uid
        where o.sid = :sid AND orderid = :orderid LIMIT 1',
        array(
            ':sid' => $_W['uniacid'],
            ':orderid' => $_GPC['orderid']
        ));
} elseif ($_GPC['username'] != '') {
    $count = pdo_fetchcolumn(
        'select count(*) from ' . tablename('tjtjtj_xxzt_orders') . ' AS o
        INNER JOIN ' . tablename('tjtjtj_xxzt_address') . ' AS a ON o.aid = a.uid
        where o.sid = :sid AND a.name LIKE "%' . $_GPC['username'] . '%"  ' . $where . ' ',
        array(':sid' => $_W['uniacid']));
    $result = pdo_fetchall(
        'select
        o.*,
        goods.name AS goodsname,goods.logo AS goodslogo,
        a.name AS username,a.mobile,a.province,a.city,a.county,a.address
        from ' . tablename('tjtjtj_xxzt_orders') . ' AS o
        LEFT JOIN ' . tablename('tjtjtj_xxzt_goods') . ' AS goods ON o.goodsid = goods.uid
        INNER JOIN ' . tablename('tjtjtj_xxzt_address') . ' AS a ON o.aid = a.uid
        where o.sid = :sid AND a.name LIKE "%' . $_GPC['username'] . '%" ' . $where . '
        order by o.create_at DESC
        limit ' . (($page - 1) * $pagesize) . ',' . $pagesize,
        array(
            ':sid' => $_W['uniacid']
        ));
} elseif ($_GPC['groupid'] != '') {
    $count    = pdo_fetchcolumn(
        'select count(*) from '.tablename('tjtjtj_xxzt_orders').' AS o
        where o.sid = :sid AND groupid = :gid '.$where.' ',
        array(':sid' => $_W['uniacid'], ':gid' => $_GPC['groupid']));
    $result   = pdo_fetchall(
        'select
        o.*,
        goods.name AS goodsname,goods.logo AS goodslogo,
        a.name AS username,a.mobile,a.province,a.city,a.county,a.address
        from '.tablename('tjtjtj_xxzt_orders').' AS o
        LEFT JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON o.goodsid = goods.uid
        LEFT JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON o.aid = a.uid
        where o.sid = :sid AND groupid = :gid '.$where.'
        order by o.create_at DESC
        limit '.(($page - 1)*$pagesize).','.$pagesize,
        array(
            ':sid' => $_W['uniacid'],
            ':gid' => $_GPC['groupid']
        ));
} else {
    $count    = pdo_fetchcolumn(
        'select count(*) from '.tablename('tjtjtj_xxzt_orders').' AS o
        where o.sid = :sid '.$where.' ',
        array(':sid' => $_W['uniacid']));
    $result   = pdo_fetchall(
        'select
        o.*,
        goods.name AS goodsname,goods.logo AS goodslogo,
        a.name AS username,a.mobile,a.province,a.city,a.county,a.address
        from '.tablename('tjtjtj_xxzt_orders').' AS o
        LEFT JOIN '.tablename('tjtjtj_xxzt_goods').' AS goods ON o.goodsid = goods.uid
        LEFT JOIN '.tablename('tjtjtj_xxzt_address').' AS a ON o.aid = a.uid
        where o.sid = :sid '.$where.'
        order by o.create_at DESC
        limit '.(($page - 1)*$pagesize).','.$pagesize,
        array(
            ':sid' => $_W['uniacid']
        ));
}
$pager  = pagination($count, $page ,$pagesize);

include $this->template('ordersmanage');