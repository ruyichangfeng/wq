<?php
$id = $profile['id'];
$op = $_GPC['op'];
if ($op == 'confirm') {
    $orderid = intval($_GPC['orderid']);
    $order   = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE id = :id AND from_user = :from_user", array(':id' => $orderid, ':from_user' => $from_user));
    if (empty($order)) {
        message('抱歉，您的订单不存在或是已经被取消！', $this->createMobileUrl('myorder'), 'error');
    }
    if (!empty($orderid)) {
        $this->setOrderCredit($orderid, $_W['uniacid']);
    }
    pdo_update('mihua_mall_order', array('status' => 3), array('id' => $orderid, 'from_user' => $from_user));
    $this->checkisAgent($from_user, $profile);
    $tagent = $this->getMember($this->getShareId());
    $this->sendxjdlshtz($order['ordersn'], $order['price'], $profile['realname'], $tagent['from_user']);
    $from_user = $order['from_user'];
    $cfg       = $this->module['config'];
    $profile   = $this->getProfile($from_user);
    if (empty($profile)) {
    } else {
        $goods = pdo_fetchall('SELECT * FROM ' . tablename('mihua_mall_order_goods') . ' WHERE orderid=' . $orderid);
        $t1 = $t2 = $t3 = 0;
        foreach ($goods as $g) {
            $t1 += $g['commission'] * floatval($g['total']);
            $t2 += $g['commission2'] * floatval($g['total']);
            $t3 += $g['commission3'] * floatval($g['total']);
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . '/addons/mihua_mall/class/redpack.php';
        if ($t1 > 0 && $order['shareid'] > 0) {
            $user1 = pdo_fetch('SELECT id,from_user,balance,commission,zhifu,uid FROM ' . tablename('mihua_mall_member') . ' WHERE id=:uid', array(':uid' => $order['shareid']));
            $total = $t1 + floatval($user1['balance']);
            if ($total > 1) {
                $params              = array();
                $params['mch_id']    = $cfg['mch_id'];
                $params['wxappid']   = $_W['account']['key'];
                $params['nick_name'] = $_W['uniaccount']['name'];
                $params['send_name'] = $_W['uniaccount']['description'];
                $params['re_openid'] = $user1['from_user'];
                $params['max_value'] = 100;
                $params['min_value'] = 100;
                $params['total_num'] = 1;
                $params['wishing']   = $cfg['wishing'];
                $params['remark']    = $cfg['remark'];
                $params['act_name']  = $cfg['act_name'];
                $params['key']       = $cfg['key'];
                if ($cfg['logo_imgurl']) {
                    $params['logo_imgurl'] = $_W['siteroot'] . 'attachment/' . $cfg['logo_imgurl'];
                }
                $cm = 0;
                do {
                    $tm = 0;
                    if ($total > 200) {
                        $tm = 200;
                        $total -= 200;
                    } else {
                        $tm    = $total;
                        $total = 0;
                    }
                    $params['total_amount'] = $tm * 100;
                    $params['min_value']    = $params['max_value']    = $params['total_amount'];
                    // echo '<pre>';var_dump($params);exit;
                    $ret = sendRedPack($params);
                    if ($ret !== false) {
                        $cm += $tm;
                    } else {
                        $total += $cm;
                    }
                    // var_dump($cm,$tm,$total);exit;
                } while ($total > 200);
                $data = array(
                    'uniacid'    => $_W['uniacid'],
                    'mid'        => $order['shareid'],
                    'ogid'       => $order['id'],
                    'commission' => $cm,
                    'content'    => '发送红包',
                    'isshare'    => 0,
                    'createtime' => TIMESTAMP,
                );
                pdo_insert('mihua_mall_commission', $data);
                $paylog = array('type' => 'zhifu', 'uniacid' => $_W['uniacid'], 'openid' => $user1['from_user'], 'tid' => date('Y-m-d H:i:s'), 'fee' => $cm, 'module' => 'mihua_mall', 'tag' => ' 支付红包' . $cm . '元【1级会员佣金】');
                pdo_insert('core_paylog', $paylog);
                pdo_update('mihua_mall_order_goods', array('status' => 1, 'checktime' => TIMESTAMP), array('orderid' => $order['id']));
                $credit1 = pdo_fetchcolumn('SELECT credit1 FROM ' . tablename('mc_members') . ' WHERE uid=:uid', array(':uid' => $user1['uid']));
                pdo_update('mc_members', array('credit1' => $credit1 + $cm), array('uid' => $user1['uid']));
            }
            pdo_update('mihua_mall_member', array('balance' => $total, 'commission' => $user1['commission'] + $cm, 'zhifu' => $user1['zhifu'] + $cm), array('from_user' => $user1['from_user']));
        }
        #2
        if ($t2 > 0 && $order['shareid2'] > 0) {
            $user2 = pdo_fetch('SELECT id,from_user,balance,commission,zhifu,uid FROM ' . tablename('mihua_mall_member') . ' WHERE id=:uid', array(':uid' => $order['shareid2']));
            $total = $t2 + floatval($user2['balance']);
            if ($total > 1) {
                $params              = array();
                $params['mch_id']    = $cfg['mch_id'];
                $params['wxappid']   = $_W['account']['key'];
                $params['nick_name'] = $_W['uniaccount']['name'];
                $params['send_name'] = $_W['uniaccount']['description'];
                $params['re_openid'] = $user2['from_user'];
                $params['max_value'] = 100;
                $params['min_value'] = 100;
                $params['total_num'] = 1;
                $params['wishing']   = $cfg['wishing'];
                $params['remark']    = $cfg['remark'];
                $params['act_name']  = $cfg['act_name'];
                $params['key']       = $cfg['key'];
                if ($cfg['logo_imgurl']) {
                    $params['logo_imgurl'] = $_W['siteroot'] . 'attachment/' . $cfg['logo_imgurl'];
                }
                $cm = 0;
                do {
                    $tm = 0;
                    if ($total > 200) {
                        $tm = 200;
                        $total -= 200;
                    } else {
                        $tm    = $total;
                        $total = 0;
                    }
                    $params['total_amount'] = $tm * 100;
                    $params['min_value']    = $params['max_value']    = $params['total_amount'];
                    // echo '<pre>';print_r($params);exit;
                    $ret = sendRedPack($params);
                    if ($ret !== false) {
                        $cm += $tm;
                    } else {
                        $total += $cm;
                    }
                    // var_dump($cm,$tm,$total);exit;
                } while ($total > 200);
                $data = array(
                    'uniacid'    => $_W['uniacid'],
                    'mid'        => $order['shareid2'],
                    'ogid'       => $order['id'],
                    'commission' => $cm,
                    'content'    => '发送红包',
                    'isshare'    => 0,
                    'createtime' => TIMESTAMP,
                );
                pdo_insert('mihua_mall_commission', $data);
                $paylog = array('type' => 'zhifu', 'uniacid' => $_W['uniacid'], 'openid' => $user2['from_user'], 'tid' => date('Y-m-d H:i:s'), 'fee' => $cm, 'module' => 'mihua_mall', 'tag' => ' 支付红包' . $cm . '元【2级会员佣金】');
                pdo_insert('core_paylog', $paylog);
                pdo_update('mihua_mall_order_goods', array('status2' => 1, 'checktime2' => TIMESTAMP), array('orderid' => $order['id']));
                $credit1 = pdo_fetchcolumn('SELECT credit1 FROM ' . tablename('mc_members') . ' WHERE uid=:uid', array(':uid' => $user2['uid']));
                pdo_update('mc_members', array('credit1' => $credit1 + $cm), array('uid' => $user2['uid']));
            }
            pdo_update('mihua_mall_member', array('balance' => $total, 'commission' => $user2['commission'] + $cm, 'zhifu' => $user2['zhifu'] + $cm), array('from_user' => $user2['from_user']));
        }
        #3
        if ($t3 > 0 && $order['shareid3'] > 0) {
            $user3 = pdo_fetch('SELECT id,from_user,balance,commission,zhifu,uid FROM ' . tablename('mihua_mall_member') . ' WHERE id=:uid', array(':uid' => $order['shareid3']));
            $total = $t3 + floatval($user3['balance']);
            if ($total > 1) {
                $params              = array();
                $params['mch_id']    = $cfg['mch_id'];
                $params['wxappid']   = $_W['account']['key'];
                $params['nick_name'] = $_W['uniaccount']['name'];
                $params['send_name'] = $_W['uniaccount']['description'];
                $params['re_openid'] = $user3['from_user'];
                $params['max_value'] = 100;
                $params['min_value'] = 100;
                $params['total_num'] = 1;
                $params['wishing']   = $cfg['wishing'];
                $params['remark']    = $cfg['remark'];
                $params['act_name']  = $cfg['act_name'];
                $params['key']       = $cfg['key'];
                if ($cfg['logo_imgurl']) {
                    $params['logo_imgurl'] = $_W['siteroot'] . 'attachment/' . $cfg['logo_imgurl'];
                }
                $cm = 0;
                do {
                    $tm = 0;
                    if ($total > 200) {
                        $tm = 200;
                        $total -= 200;
                    } else {
                        $tm    = $total;
                        $total = 0;
                    }
                    $params['total_amount'] = $tm * 100;
                    $params['min_value']    = $params['max_value']    = $params['total_amount'];

                    $ret = sendRedPack($params);
                    if ($ret !== false) {
                        $cm += $tm;
                    } else {
                        $total += $cm;
                    }
                } while ($total > 200);
                $data = array(
                    'uniacid'    => $_W['uniacid'],
                    'mid'        => $order['shareid3'],
                    'ogid'       => $order['id'],
                    'commission' => $cm,
                    'content'    => '发送红包',
                    'isshare'    => 0,
                    'createtime' => TIMESTAMP,
                );
                pdo_insert('mihua_mall_commission', $data);
                $paylog = array('type' => 'zhifu', 'uniacid' => $_W['uniacid'], 'openid' => $user3['from_user'], 'tid' => date('Y-m-d H:i:s'), 'fee' => $cm, 'module' => 'mihua_mall', 'tag' => ' 支付红包' . $cm . '元【3级会员佣金】');
                pdo_insert('core_paylog', $paylog);
                pdo_update('mihua_mall_order_goods', array('status3' => 1, 'checktime3' => TIMESTAMP), array('orderid' => $order['id']));
                $credit1 = pdo_fetchcolumn('SELECT credit1 FROM ' . tablename('mc_members') . ' WHERE uid=:uid', array(':uid' => $user3['uid']));
                pdo_update('mc_members', array('credit1' => $credit1 + $cm), array('uid' => $user3['uid']));
            }
            pdo_update('mihua_mall_member', array('balance' => $total, 'commission' => $user3['commission'] + $cm, 'zhifu' => $user3['zhifu'] + $cm), array('from_user' => $user3['from_user']));
        }
        #3end
    }
    #qiisyhx end

    message('确认收货完成！', $this->createMobileUrl('myorder'), 'success');
} else if ($op == 'detail') {
    $orderid = intval($_GPC['orderid']);
    $item    = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE uniacid = '{$_W['uniacid']}' AND from_user = '" . $from_user . "' and id='{$orderid}' limit 1");
    if (empty($item)) {
        message('抱歉，您的订单不存或是已经被取消！', $this->createMobileUrl('myorder'), 'error');
    }
    $goodsid = pdo_fetchall("SELECT goodsid,total FROM " . tablename('mihua_mall_order_goods') . " WHERE orderid = '{$orderid}'", array(), 'goodsid');
    $goods   = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice,o.total,o.optionid FROM " . tablename('mihua_mall_order_goods') . " o left join " . tablename('mihua_mall_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$orderid}'");
    foreach ($goods as &$g) {
        $option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("mihua_mall_goods_option") . " where id=:id limit 1", array(":id" => $g['optionid']));
        if ($option) {
            $g['title']       = "[" . $option['title'] . "]" . $g['title'];
            $g['marketprice'] = $option['marketprice'];
        }
        $comment=pdo_fetch("select * from ims_mihua_mall_comment where ordersn=:ordersn and goods_id=:goods_id and  uid=:uid ",array('ordersn'=>$item['ordersn'],'goods_id'=>$g['id'],'uid'=>$_W['member']['uid']));
        if($comment){
            $have_content[$g['id']]=$comment['comment_content'];
        }
    }
    unset($g);
    $dispatch = pdo_fetch("select id,dispatchname,dispatchtype from " . tablename('mihua_mall_dispatch') . " where id=:id limit 1", array(":id" => $item['dispatch']));
    include $this->template('order_detail');
} else {
    $pindex = max(1, intval($_GPC['page']));
    $psize  = 20;
    $status = intval($_GPC['status']);
    $where  = " uniacid = '{$_W['uniacid']}' AND from_user = '" . $from_user . "'";
    if ($status == 1) {
        $where .= " and ( status=1 or (status=0 and paytype=3) )";
    }elseif($status==6){
        $where .=" and status in(0,1,2,3)";
    } else {
        $where .= " and status=$status";
    }
    $list  = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE $where ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(), 'id');
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mihua_mall_order') . " WHERE uniacid = '{$_W['uniacid']}' AND from_user = '" . $from_user . "'");
    $pager = pagination($total, $pindex, $psize);
    if (!empty($list)) {
        foreach ($list as &$row) {
            $goods = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice,o.total,o.optionid FROM " . tablename('mihua_mall_order_goods') . " o left join " . tablename('mihua_mall_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$row['id']}'");
            foreach ($goods as &$item) {
                $option = pdo_fetch("select title,marketprice,weight,stock from " . tablename("mihua_mall_goods_option") . " where id=:id limit 1", array(":id" => $item['optionid']));
                if ($option) {
                    $item['title']       = "[" . $option['title'] . "]" . $item['title'];
                    $item['marketprice'] = $option['marketprice'];
                }
            }
            unset($item);
            $row['goods']    = $goods;
            $row['total']    = $goodsid;
            $row['dispatch'] = pdo_fetch("select id,dispatchname from " . tablename('mihua_mall_dispatch') . " where id=:id limit 1", array(":id" => $row['dispatch']));
        }
    }
    $carttotal = $this->getCartTotal();
    include $this->template('order');
}