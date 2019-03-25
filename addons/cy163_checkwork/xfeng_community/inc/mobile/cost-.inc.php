<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 微信端小区活动
 */


global $_GPC, $_W;

$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
//判断是否注册，只有注册后，才能进入
$member = $this->changemember();

$region = $this->mreg();
//$m = mc_fetch($_W['fans']['uid'], array('mobile', 'address', 'realname'));
$user = mc_fetch($_W['fans']['uid'], array('mobile', 'credit1','credit2', 'realname', 'address'));
$id = intval($_GPC['id']);
$credit = $this->credit();
$setdata = $this->syspay(2);
$set = unserialize($setdata['pay']);
if ($op == 'list') {
    if ($_W['isajax']) {
        if(empty($member['address'])){
            $u = $this->createMobileUrl('home');
            message('暂无缴费信息',$u,'success');exit();
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $condition = '';
        $sql= "SELECT l.* FROM" . tablename('xcommunity_cost_list') . "as l left join " . tablename('xcommunity_cost') . "as c on l.cid = c.id WHERE l.weid='{$_W['weid']}' AND l.homenumber ='{$member['address']}' AND l.regionid ='{$member['regionid']}' AND c.enable = 1 order by l.createtime desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
        $list = pdo_fetchall($sql);
        foreach($list as $key=>$value){
            $url = $this->createMobileUrl('cost', array('op' => 'detail', 'id' => $value['id'], 'cid' => $value['cid']));
            $list[$key][url] = $url;
            $list[$key][region_title] = $region['title'];
            $list[$key][address] = $member['address'];
            $list[$key][mobile] = $member['mobile'];
            $list[$key][realname] = $member['realname'];
        }
        $data = array();
        $data['list'] = $list;
        die(json_encode($data));
    }
    include $this->template($this->xqtpl('cost/list'));
}
elseif ($op == 'detail') {
    $cid = intval($_GPC['cid']);
    if (empty($id)) {
        message('缺少参数', referer(), 'error');
    }
    $category = pdo_fetch("SELECT name FROM" . tablename('xcommunity_category') . "WHERE regionid=:regionid", array(':regionid' => $member['regionid']));
    $c = explode('|', $category['name']);
    $item = pdo_fetch("SELECT * FROM" . tablename('xcommunity_cost_list') . "WHERE weid=:weid AND id=:id", array(':weid' => $_W['weid'], ':id' => $id));
    $fee = explode('|', $item['fee']);
    if (empty($item)) {
        message('费用不存在或已被删除', referer(), 'error');
    }
    if (checksubmit('submit')) {
        $data = array(
            'weid'       => $_W['uniacid'],
            'from_user'  => $_W['fans']['from_user'],
            'ordersn'    => date('YmdHi') . random(10, 1),
            'createtime' => TIMESTAMP,
            'price'      => $item['total'],
            'pid'        => $id,
            'type'       => 'pfree',
            'regionid'   => $member['regionid'],
        );

        $order = pdo_fetch("SELECT * FROM" . tablename('xcommunity_order') . "WHERE pid=:pid", array(':pid' => $id));
        if (empty($order)) {
            pdo_insert('xcommunity_order', $data);
            $orderid = pdo_insertid();
        }
        else {
            pdo_update('xcommunity_order', array('createtime' => TIMESTAMP), array('id' => $order['id']));
            $orderid = $order['id'];
        }
        //判断是否开启支付宝独立支付
        $region = pdo_fetch("SELECT * FROM" . tablename('xcommunity_region') . "WHERE id=:id", array(':id' => $item['regionid']));
        if ($region['pid']) {
            $payment = pdo_fetch("SELECT * FROM" . tablename('xcommunity_alipayment') . "WHERE uniacid=:uniacid AND pid=:pid", array(':pid' => $region['pid'], ':uniacid' => $_W['uniacid']));
        }

        if($item['switch']){
            if ($order) {
                $ordersn = $order['ordersn'];
                $price = $order['price'];
                $goodstype = $order['goodstype'];
            }
            else {
                $o = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE id = :id", array(':id' => $orderid));
                $ordersn = $o['ordersn'];
                $price = $o['price'];
                $goodstype = $o['goodstype'];
            }
            $params['tid'] = $ordersn;
            $params['module'] = 'xfeng_community';
            $params['fee'] = $price;
            $params['title'] = '物业费支付';
            $params['ordersn'] = $ordersn;
            $params['pid'] = $region['pid']; //物业id
            $params['cid'] = $cid;//物业费id
            $params['virtual'] = $goodstype == 2 ? true : false;
            $sl = base64_encode(json_encode($params));
            $auth = sha1($sl . $_W['uniacid'] . $_W['config']['setting']['authkey']);
            $payopenid = $_W['fans']['from_user'];
            header("location: " . $this->createMobileUrl('pay', array('type' => 'wechat','auth' => $auth,'ps' => $sl)));exit();
            //header("Location:../payment/wechat/pay.php?i={$_W['uniacid']}&auth={$auth}&ps={$sl}&payopenid={$payopenid}");
        }

        if ($payment['account'] && $payment['partner'] && $payment['secret']) {
            $alipay = array(
                'switch'  => 1,
                'account' => $payment['account'],
                'partner' => $payment['partner'],
                'secret'  => $payment['secret'],
            );
            if ($order) {
                $ordersn = $order['ordersn'];
                $price = $order['price'];
                $goodstype = $order['goodstype'];
            }
            else {
                $o = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE id = :id", array(':id' => $orderid));
                $ordersn = $o['ordersn'];
                $price = $o['price'];
                $goodstype = $o['goodstype'];
            }
            $params['tid'] = $ordersn;
            $params['module'] = 'xfeng_community';
            $params['fee'] = $price;
            $params['title'] = '物业费支付';
            $params['ordersn'] = $ordersn;
            $params['pid'] = $region['pid']; //物业id
            $params['cid'] = $cid;//物业费id
            $params['virtual'] = $goodstype == 2 ? true : false;
            $sl = base64_encode(json_encode($params));
            $ali = base64_encode(json_encode($alipay));
//            header("location: ../payment/wechat/pay.php?i={$_W['uniacid']}&auth={$auth}&ps={$sl}");
            header("location: " . $this->createMobileUrl('pay', array('type' => 'alipay','ps' => $sl,'ali' => $ali)));

        }
        else {
            if ($orderid) {
                header("location: " . $this->createMobileUrl('cost', array('op' => 'pay', 'orderid' => $orderid)));
            }

        }
    }

    include $this->template($this->xqtpl('cost/detail'));
}
elseif ($op == 'pay') {
    //查物业费支持的支付方式

    //查当前订单信息
    $orderid = intval($_GPC['orderid']);
    $order = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE id = :id", array(':id' => $orderid));
    if ($order['status'] != '0') {
        message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', referer(), 'error');
    }
    $params['tid'] = $order['ordersn'];
    $params['user'] = $_W['fans']['from_user'];
    $params['fee'] = $order['price'];
    $params['ordersn'] = $order['ordersn'];
    $params['virtual'] = $order['goodstype'] == 2 ? true : false;
    $params['module'] = 'xfeng_community';
    $params['title'] = '物业费支付';
    $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
    if (empty($log)) {
        $log = array(
            'uniacid'    => $_W['uniacid'],
            'acid'       => $_W['acid'],
            'openid'     => $_W['member']['uid'],
            'module'     => $this->module['name'], //模块名称，请保证$this可用
            'tid'        => $params['tid'],
            'fee'        => $params['fee'],
            'card_fee'   => $params['fee'],
            'status'     => '0',
            'is_usecard' => '0',
        );
        pdo_insert('core_paylog', $log);
    }
    $setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
    $credtis = mc_credit_fetch($_W['member']['uid']);
    include $this->template($this->xqtpl('cost/pay'));
}









