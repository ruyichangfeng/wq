<?php
global $_W,$_GPC;
$this->checkauth();
$act = isset($_GPC['act']) ? $_GPC['act'] : '';
load()->func('tpl');

if ($act == 'getSpec') {
    $cartRow = array();
    $result = array('msg' => '', 'err' => 0);

    $goodsid = intval($_GPC['gid']);
    $goods = pdo_fetch("SELECT goods_name, goods_number, shop_price  FROM " . tablename('wxz_lzl_goods')
            . " WHERE goods_id='{$goodsid}'");
    $propertiesArr = $this->get_goods_properties($goodsid);  // 获得商品的规格和属性
    $specification = $propertiesArr['spe'];
    if (!empty($specification)) {
        $goods_attr = array();
        foreach ($specification as $key => $val) {
            $goods_attr[] = $val['values'][0]['id'];
        }
        sort($goods_attr);
        $goods_attr_id = implode("|", $goods_attr);
        $cartRow = pdo_fetch("SELECT rec_id,goods_name, goods_number, goods_price  FROM " . tablename('wxz_lzl_cart')
                . " WHERE weid='" . $_W['uniacid'] . "' AND from_user='" . $_W['fans']['from_user'] . "' AND goods_id='{$goodsid}' AND goods_attr_id = '$goods_attr_id'");
    }

    $result['goods'] = $goods;
    $result['specification'] = $specification;
    $result['cartRow'] = $cartRow;
    die(json_encode($result));
    //$content = include $this->template('store/cart');
} elseif ($act == 'change_price') {
    $res = array('err_msg' => '', 'totalprice' => '', 'number' => 1, 'product_number' => 0, 'cartRow' => array());
    $attr_id = isset($_GPC['attr']) ? explode(',', $_GPC['attr']) : array();
    $number = isset($_GPC['number']) ? intval($_GPC['number']) : 1;
    $goodsid = intval($_GPC['id']);
    $goods = pdo_fetch("SELECT * FROM " . tablename('wxz_lzl_goods') . " WHERE goods_id = :id", array(':id' => $goodsid));
    
    if (empty($goods)) {
        $res['err_msg'] = '没有找到指定的商品或者没有找到指定的商品属性';
        $res['err_no'] = 1;
    } else {
        if ($number == 0) {
            $res['number'] = $number = 1;
        } else {
            $res['number'] = $number;
        }
        $shop_price = $this->get_final_price($goodsid, $number, true, $attr_id);
        $res['totalprice'] = $this->price_format($shop_price * $number);
        //货品库存
        sort($attr_id);
        $goods_attr = '';
        if (!empty($attr_id)) {
            $goods_attr = implode("|", $attr_id);
            $products = pdo_fetch("SELECT * FROM " . tablename('wxz_lzl_products') . " WHERE goods_id = :id and goods_attr = :goods_attr", array(':id' => $goodsid, ':goods_attr' => $goods_attr));
            if (!empty($products)) {
                $res['product_number'] = $products['product_number'];
            }
        }
        $cartRow = pdo_fetch("SELECT rec_id,goods_name, goods_number, goods_price  FROM " . tablename('wxz_lzl_cart')
                . " WHERE weid='" . $_W['uniacid'] . "' AND from_user='" . $_W['fans']['from_user'] . "' AND goods_id='{$goodsid}' AND goods_attr_id = '$goods_attr'");
        if (!empty($cartRow)) {
            $res['cartRow'] = $cartRow;
        }
        $res['goods'] = $goods;
    }
    die(json_encode($res));
} elseif ($act == 'cart') {
    $op = $_GPC['op'];
    if ($op == 'add') {
            $goodsid = intval($_GPC['gid']);
            $number = empty($_GPC['number']) ? 1 : intval($_GPC['number']);
            $is_spec = intval($_GPC['is_spec']);
            $is_direct = isset($_GPC['is_direct']) ? intval($_GPC['is_direct']) : 0;
            $spec_arr = !empty($_GPC['spec_str']) ? explode(",", trim($_GPC['spec_str'])) : array();
            $goods = pdo_fetch("SELECT * FROM " . tablename('wxz_lzl_goods') . " WHERE goods_id = :id", array(':id' => $goodsid));

            if (empty($goods)) {
                    $result['message'] = '抱歉，该商品不存在或是已经被删除！';
                    message($result, '', 'ajax');
            }
            /* 检查：如果商品有规格，而post的数据没有规格，把商品的规格属性通过JSON传到前台 */
            if (empty($spec_arr) AND empty($is_spec))
            {
                    $sql = "SELECT a.attr_id, a.attr_name, a.attr_type, ".
                            "g.goods_attr_id, g.attr_value, g.attr_price " .
                    'FROM ' . tablename('wxz_lzl_goods_attr') . ' AS g ' .
                    'LEFT JOIN ' . tablename('wxz_lzl_attribute') . ' AS a ON a.attr_id = g.attr_id ' .
                    "WHERE a.attr_type != 0 AND g.goods_id = '" . $goodsid . "' " .
                    'ORDER BY a.sort_order, g.attr_price, g.goods_attr_id';

                    $res = pdo_fetchall($sql);

                    if (!empty($res))
                    {
                            $result['message'] = '请选择商品属性！';
                            message($result, '', 'ajax');
                    }
            }
            // 更新：添加到购物车
            $res = $this->addto_cart($goodsid, $number, $spec_arr, $is_direct);
            if ($res['err'] > 0)
            {
                    $result['message'] = $res['msg'];
                    message($result, '', 'ajax');
            }
            //返回数据
            $list = $this->cart_goods();
            foreach($list as $key=>$val) {
                    $totalmoney  += $val['goods_price'] * $val['goods_number'];
            }
            $totalmoney = $this->price_format($totalmoney);
            $carttotal = $this->getCartTotal();
            $cartgoods_num = $this->getCartTotal($goodsid);
            $result = array(
                    'result' => 1,
                    'num' => $res['num'],
                    'rec_id' => $res['rec_id'],
                    'total' => $carttotal,
                    'totalprice' => $totalmoney,
                    'cartgoods_num' => $cartgoods_num
            );
            die(json_encode($result));
    } else if ($op == 'clear') {
            pdo_delete('shopping_cart', array('from_user' => $_W['fans']['from_user'], 'weid' => $_W['uniacid']));
            die(json_encode(array("result" => 1)));
    } else if ($op == 'remove') {
            $rec_id = intval($_GPC['rec_id']);
            pdo_delete('wxz_lzl_cart', array('from_user' => $_W['fans']['from_user'], 'weid' => $_W['uniacid'], 'rec_id' => $rec_id));
            
            $totalmoney = 0;
            $_SESSION['selcart_goods'] = array();
            $list = $this->cart_goods();
            foreach($list as $key=>$val) {
                $totalmoney  += $val['goods_price'] * $val['goods_number'];
            }
            $totalmoney = $this->price_format($totalmoney);
            $content = include $this->template('store/cart');
            //die(json_encode(array("result" => 1, 'totalprice' => $totalmoney, 'content' => $content)));
    } else if ($op == 'update') {
            $gid = intval($_GPC['gid']);
            $number = intval($_GPC['number']) > 0 ? intval($_GPC['number']) : 1;
            $rec_id = intval($_GPC['rec_id']);
            $is_delete = intval($_GPC['is_delete']);
            //库存判断
            $sql = "SELECT `goods_id`, `goods_attr_id`, `product_id` FROM" .tablename('wxz_lzl_cart').
                   " WHERE rec_id='$rec_id' AND from_user='" . $_W['fans']['from_user'] . "'";
            $cartinfo = pdo_fetch($sql);

            $sql = "SELECT g.goods_name, g.goods_number ".
                    "FROM " .tablename('wxz_lzl_goods'). " AS g, ".
                        tablename('wxz_lzl_cart'). " AS c ".
                    "WHERE g.goods_id = c.goods_id AND c.rec_id = '$rec_id'";
            $row = pdo_fetch($sql);

            //检查输入的商品数量是否有效
            if ($row['goods_number'] < $number)
            {
                $result['message'] = '库存不足！';
                message($result, '', 'ajax');
            }
            /* 是货品 */
            if (!empty($cartinfo['product_id']))
            {
                $sql = "SELECT product_number FROM " .tablename('wxz_lzl_products'). " WHERE goods_id = '" . $cartinfo['goods_id'] . "' AND product_id = '" . $cartinfo['product_id'] . "'";

                $product_number = pdo_fetchcolumn($sql);
                if ($product_number < $number)
                {
                    $result['message'] = '库存不足！';
                    message($result, '', 'ajax');
                }
            }
            if($is_delete == 1) {
                pdo_delete('wxz_lzl_cart', array('from_user' => $_W['fans']['from_user'], 'weid' => $_W['uniacid'], 'rec_id' => $rec_id));
            } else {
                $sql = "UPDATE " . tablename('wxz_lzl_cart') . " SET goods_number = '$number' WHERE rec_id = $rec_id";
                pdo_query($sql);
            }

            $totalmoney = 0;
            $list = $this->cart_goods();
            foreach($list as $key=>$val) {
                $totalmoney  += $val['goods_price'] * $val['goods_number'];
            }
            $totalmoney = $this->price_format($totalmoney);
            $carttotal = $this->getCartTotal();
            $cartgoods_num = $this->getCartTotal($gid);
            $result = array(
                    'result' => 1,
                    'is_delete' => $is_delete,
                    'totalprice' => $totalmoney,
                    'total' => $carttotal,
                    'cartgoods_num' => $cartgoods_num
            );
            die(json_encode($result));
    } elseif($op == 'sel_goods'){
        $_SESSION['selcart_goods'] = $_GPC['rec_id'];
        $totalmoney = 0;
        
        $list = $this->cart_goods();
        foreach($list as $key=>$val) {
            $totalmoney  += $val['goods_price'] * $val['goods_number'];
        }
        $totalmoney = $this->price_format($totalmoney);
        $result = array(
                'result' => 1,
                'totalprice' => $totalmoney
        );
        die(json_encode($result));
    }else {
            $totalmoney = 0;
            $_SESSION['selcart_goods'] = array();
            $list = $this->cart_goods();
            foreach($list as $key=>$val) {
                $totalmoney  += $val['goods_price'] * $val['goods_number'];
            }
            $totalmoney = $this->price_format($totalmoney);

            include $this->template('store/cart');
    }
}
//选择配送
elseif ($act == 'selectShipping') {
    $cart_goods = $this->cart_goods(); 
    if (empty($cart_goods))
    {
            $result['message'] = '抱歉，购物车没有商品！';
            message($result, '', 'ajax');
    } else {
            $order = isset($_SESSION['flow_order']) ? $_SESSION['flow_order'] : array();
            $order['shipping_id'] = intval($_GPC['recid']);
            $shipping_info = $this->shipping_area_info($order['shipping_id']);

            /* 计算订单的费用 */
            $total = $this->order_fee($order, $cart_goods);
            $result = array(
                    'result' => 1,
                    'total' => $total
            );
    }
    die(json_encode($result));
} 
//去结算，订单确认
elseif ($act == 'checkout') {
    $totalprice = 0;
    $allgoods = array();
    $id = intval($_GPC['id']);
    $direct = false; //是否是直接购买
    $returnUrl = ''; //当前连接
    $_SESSION['buy'] = array();
    if (!empty($id)) {
            $number = intval($_GPC['number']);
            if ( (empty($number)) || ($number < 1) ) {
                    $number = 1;
            }
            $spec = !empty($_GPC['spec_str']) ? explode(",", trim($_GPC['spec_str'])) : array();
            sort($spec);
            $sql = 'SELECT * FROM ' .tablename('wxz_lzl_goods') .
                    ' WHERE is_delete = 0 AND is_on_sale = 1 AND `goods_id` = :goods_id';
            $goods = pdo_fetch($sql, array(':goods_id' => $id));
            if (empty($goods)) {
                    message('商品不存在或已经下架', $this->createMobileUrl('goods', array('id' => $id)), 'error');
            }
            /* 检查：如果商品有规格，而post的数据没有规格，把商品的规格属性通过JSON传到前台 */
            if (empty($spec) AND empty($is_spec))
            {
                    $sql = "SELECT a.attr_id, a.attr_name, a.attr_type, ".
                            "g.goods_attr_id, g.attr_value, g.attr_price " .
                    'FROM ' . tablename('wxz_lzl_goods_attr') . ' AS g ' .
                    'LEFT JOIN ' . tablename('wxz_lzl_attribute') . ' AS a ON a.attr_id = g.attr_id ' .
                    "WHERE a.attr_type != 0 AND g.goods_id = '" . $id . "' " .
                    'ORDER BY a.sort_order, g.attr_price, g.goods_attr_id';
                    $res = pdo_fetchall($sql);

                    if (!empty($res))
                    {
                            $result['message'] = '请选择商品属性！';
                            message($result,$this->createMobileUrl('checkout'), 'error');
                    }
            }
            /* 如果商品有规格则取规格商品信息 配件除外 */
            $sql = "SELECT * FROM " .tablename('wxz_lzl_products'). " WHERE goods_id = '$id' LIMIT 0, 1";
            $prod = pdo_fetch($sql);

            if ($this->is_spec($spec) && !empty($prod))
            {
                $product_info = $this->get_products_info($id, $spec);
            }
            if (empty($product_info))
            {
                $product_info = array('product_number' => '', 'product_id' => 0);
            }

            /* 检查：库存 */
             //检查：商品购买数量是否大于总库存
             if ($number > $goods['goods_number'])
             {
                message('该商品库存不足！');
             }
             //商品存在规格 是货品 检查该货品库存
             if ($this->is_spec($spec) && !empty($prod))
             {
                 if (!empty($spec))
                 {
                     /* 取规格的货品库存 */
                     if ($num > $product_info['product_number'])
                     {
                        message('该商品库存不足！');
                     }
                 }
             }
            /* 计算商品的促销价格 */
            $spec_price             = $this->spec_price($spec);
            $goods_price            = $this->get_final_price($id, $number, true, $spec);
            $goods_attr             = $this->get_goods_attr_info($spec);
            $goods_attr_id          = join('|', $spec);

            $param = array(
                'from_user'     => $_W['fans']['from_user'],
                'weid' 		   => $_W['uniacid'],
                'goods_id'      => $id,
                'goods_sn'      => $goods['goods_sn'],
                'goods_number'    => $number,
                'product_id'    => $product_info['product_id'],
                'goods_name'    => $goods['goods_name'],
                'goods_price'  => $goods_price,
                'market_price'  => $goods['market_price'],
                'goods_attr'    => $goods_attr,
                'goods_attr_id' => $goods_attr_id,
                'is_real'       => $goods['is_real'],
                'extension_code'=> $goods['extension_code'],
                'is_shipping'   => $goods['is_shipping'],
                'goods_img'   => $goods['goods_img']
            );
            $cart_list[] = $param;
            //计算订单的费用
            $total['goods_price']  = $goods_price * $number;
            $total['formated_goods_price']  = $this->price_format($total['goods_price'], false);
            $total['real_goods_count']  = $goods['is_real'];
            $total['amount'] = $total['goods_price'];
            $total['amount_formated']  = $this->price_format($total['amount'], false);
            /* 取得配送列表 */
            $shipping_list     = $this->available_shipping_list();

            foreach ($shipping_list AS $key => $val)
            {
                $shipping_fee = ($goods['is_shipping'] == 1) ? 0 : $this->shipping_fee($val,
                $goods['goods_weight']*$number, $number*$goods['shop_price'], $number);

                $shipping_list[$key]['format_shipping_fee'] = $this->price_format($shipping_fee, false);
                $shipping_list[$key]['shipping_fee']        = $shipping_fee;
                $shipping_list[$key]['free_money']          = $this->price_format($val['free_money'], false);
            }

            $direct = true;
            $_SESSION['buy'] = array('gid' => $id, 'number' => $number, 'spec' => $spec, 'is_spec'=>$is_spec);
            $returnUrl = $_W['siteurl'];
    }
    if (!$direct) {
            //如果不是直接购买（从购物车购买）
        $_SESSION['selcart_goods'] = '';
            $recids = $_GPC['recids'];
            if(!empty($recids)){
                $_SESSION['selcart_goods'] = $recids;
            }
            $cart_list = $this->cart_goods();
            if (count($cart_list) <= 0) {
                header("location: " . $this->createMobileUrl('index'));
                exit();
            }
            foreach($cart_list as $key=>$val) {
                $cart_list[$key]['format_goods_price'] = $this->price_format($val['goods_price']);
                $totalmoney  += $val['goods_price'] * $val['goods_number'];
            }
            $totalmoney = $this->price_format($totalmoney);
            //计算订单的费用
            $flow_order = isset($_SESSION['flow_order']) ? $_SESSION['flow_order'] : array();
            $total = $this->order_fee($flow_order, $cart_list);
            
            /* 取得配送列表 */
            $shipping_list     = $this->available_shipping_list();
            $cart_weight_price = $this->cart_weight_price();

            // 查看购物车中是否全为免运费商品，若是则把运费赋为零
            $sql = 'SELECT count(*) FROM ' . tablename('wxz_lzl_cart') . " WHERE `weid` = '" . $_W['uniacid']. "' AND from_user = '". $_W['fans']['from_user'] ."' AND `is_shipping` = 0";
            $shipping_count = pdo_fetchcolumn($sql);

            foreach ($shipping_list AS $key => $val)
            {
                $shipping_fee = ($shipping_count == 0) ? 0 : $this->shipping_fee($val,
                $cart_weight_price['weight'], $cart_weight_price['amount'], $cart_weight_price['number']);

                $shipping_list[$key]['format_shipping_fee'] = $this->price_format($shipping_fee, false);
                $shipping_list[$key]['shipping_fee']        = $shipping_fee;
                $shipping_list[$key]['free_money']          = $this->price_format($val['free_money'], false);
            }
            if(!empty($recids)){
                $returnUrl = $this->createMobileUrl("store", array('act' => 'checkout', 'recids' => $recids));
            } else {
                $returnUrl = $this->createMobileUrl("store", array('act' => 'checkout'));
            }
    }

    $carttotal = $this->getCartTotal();
    $profile = fans_search($_W['fans']['from_user'], array('resideprovince', 'residecity', 'residedist', 'address', 'realname', 'mobile'));
    $address = pdo_fetch("SELECT * FROM " . tablename('mc_member_address') . " WHERE isdefault = 1 and uid = :uid limit 1", array(':uid' => $_W['member']['uid']));
    if(empty($address)) {
        include $this->template('store/address');
        exit();
    }
    $content = include $this->template('store/checkout');
} 
//地址管理
elseif ($act == 'address') {
//    $msg = '测试地址';
//    $redirectUrl = $this->createMobileUrl('store', array('act' => 'address'));
//    $type = 'ajax';
//    include $this->template('store/message');exit;
    $operation = $_GPC['op'];
    $returnUrl = trim($_GPC['returnUrl']);
    if ($operation == 'post') {
            $param = $_GPC['param'];
            $id = intval($param['address_id']);
            $returnUrl = trim($param['returnUrl']);
            $data = array(
                    'uniacid' => $_W['uniacid'],
                    'uid' => $_W['fans']['uid'],
                    'username' => trim($param['consignee']),
                    'mobile' => trim($param['mobile']),
                    'province' => trim($param['province']),
                    'city' => trim($param['city']),
                    'district' => trim($param['area']),
                    'address' => $param['address'],
                    'isdefault' => 1
            );
            if (empty($data['username']) || empty($data['mobile']) || empty($data['address'])) {
                $msg = '请输完善您的资料';
                $redirectUrl = $this->createMobileUrl('store', array('act' => 'address'));
                $type = 'ajax';
                include $this->template('store/message');exit;
            }
            if (!empty($id)) {
                    unset($data['uniacid']);
                    unset($data['uid']);
                    pdo_update('mc_member_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'uid' => $_W['fans']['uid']));
                    pdo_update('mc_member_address', $data, array('uniacid' => $_W['uniacid'], 'uid' => $_W['fans']['uid'], 'id' => $id));

                    if(empty($returnUrl)) {
                        $returnUrl = $this->createMobileUrl('store', array('act' => 'address'));
                        header("location: " . $returnUrl);
                        exit();
                    } else {
                        header("location: " . $returnUrl); exit();
                    }
            } else {

                    pdo_update('mc_member_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'uid' => $_W['fans']['uid']));
                    $data['isdefault'] = 1;
                    pdo_insert('mc_member_address', $data);
                    pdo_update('mc_members', array('address' => $data['province'].$data['city'].$data['district'].$data['address']), array('uniacid' => $_W['uniacid'], 'uid' => $_W['fans']['uid']));
                    $id = pdo_insertid();
                    if(empty($returnUrl)) {
                        $returnUrl = $this->createMobileUrl('store', array('act' => 'address'));
                        header("location: " . $returnUrl);
                        exit();
                    } else {
                        header("location: " . $returnUrl);
                        exit();
                    }
            }
    } elseif ($operation == 'default') {
            $id = intval($_GPC['id']);
            $sql = 'SELECT * FROM ' . tablename('mc_member_address') . ' WHERE `id` = :id AND `uniacid` = :uniacid
                             AND `uid` = :uid';
            $params = array(':id' => $id, ':uniacid' => $_W['uniacid'], ':uid' => $_W['fans']['uid']);
            $address = pdo_fetch($sql, $params);

            if (!empty($address) && empty($address['isdefault'])) {
                    pdo_update('mc_member_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'uid' => $_W['fans']['uid']));
                    pdo_update('mc_member_address', array('isdefault' => 1), array('uniacid' => $_W['uniacid'], 'uid' => $_W['fans']['uid'], 'id' => $id));
                    pdo_update('mc_members', array('address' => $address['province'].$address['city'].$address['district'].$address['address']), array('uniacid' => $_W['uniacid'], 'uid' => $_W['fans']['uid']));
            }
            message(1, '', 'ajax');
    } elseif ($operation == 'remove') {
            $id = intval($_GPC['address_id']);
            if (!empty($id)) {
                    $where = ' AND `uniacid` = :uniacid AND `uid` = :uid';
                    $sql = 'SELECT `isdefault` FROM ' . tablename('mc_member_address') . ' WHERE `id` = :id' . $where;
                    $params = array(':id' => $id, ':uniacid' => $_W['uniacid'], ':uid' => $_W['fans']['uid']);
                    $address = pdo_fetch($sql, $params);

                    if (!empty($address)) {
                            pdo_delete('mc_member_address', array('id' => $id));
                            // 如果删除的是默认地址，则设置是新的为默认地址
                            if ($address['isdefault'] > 0) {
                                    $sql = 'SELECT MAX(id) FROM ' . tablename('mc_member_address') . ' WHERE 1 ' . $where;
                                    unset($params[':id']);
                                    $maxId = pdo_fetchcolumn($sql, $params);
                                    if (!empty($maxId)) {
                                        pdo_update('mc_member_address', array('isdefault' => 1), array('id' => $maxId));
                                        $returnUrl = $this->createMobileUrl('store', array('act' => 'address'));
                                        header("location: " . $returnUrl);
                                        exit();
                                    }
                            }
                    }
            }
            $returnUrl = $this->createMobileUrl('store', array('act' => 'address'));
            header("location: " . $returnUrl);
            exit();
    } else {
            $sql = 'SELECT * FROM ' . tablename('mc_member_address') . ' WHERE `uniacid` = :uniacid AND `uid` = :uid';
            $params = array(':uniacid' => $_W['uniacid']);
            if (empty($_W['member']['uid'])) {
                    $params[':uid'] = $_W['fans']['openid'];
            } else {
                    $params[':uid'] = $_W['member']['uid'];
            }
            $addresses = pdo_fetchall($sql, $params);
            $address_total = count($addresses);
            //$carttotal = $this->getCartTotal();
            include $this->template('store/address');
    }
} elseif ($act == 'orderdone') {
    $cart_list = $this->cart_goods();
    if (count($cart_list) <= 0) {
        header("location: " . $this->createMobileUrl('store',array('act' => 'cart')));
        exit();
    }
    /* 判断是不是实体商品 */
    foreach ($cart_list AS $val)
    {
        /* 统计实体商品的个数 */
        if ($val['is_real'])
        {
            $is_real_good=1;
        }
    }
    
    $address = pdo_fetch("SELECT * FROM " . tablename('mc_member_address') . " WHERE id = :id", array(':id' => intval($_GPC['address'])));
    if (empty($address) && isset($is_real_good)) {
        $msg = '抱歉，请您填写收货地址！';
        $redirectUrl = $this->createMobileUrl('store', array('act' => 'address'));
        $type = 'ajax';
        include $this->template('store/message');exit;
    }
    //配送方式
    if(isset($is_real_good) && empty($_GPC['address'])) {
        $msg = '抱歉，请选择配送方式！';
        $redirectUrl = $this->createMobileUrl('store', array('act' => 'checkout'));
        $type = 'ajax';
        include $this->template('store/message');exit;
    }

    /* 检查商品库存 */
    $stock_info = $this->check_stock($cart_list);
    if(!empty($stock_info['msg'])) {
        $msg = $stock_info['msg'];
        $redirectUrl = $this->createMobileUrl('store', array('act' => 'cart'));
        $type = 'ajax';
        include $this->template('store/message');exit;
    }
    
    $params = $this->done_order($cart_list, $address);

    include $this->template('store/pay');
}
    


        

?>