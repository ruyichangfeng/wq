<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 微信端小区超市
 */
	
	global $_GPC,$_W;
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
	$operation = !empty($_GPC['operation']) ? $_GPC['operation'] : 'list';
    $user = mc_fetch($_W['fans']['uid'], array('mobile', 'credit1','credit2', 'realname', 'address'));
	$region = $this->mreg();
	$tyset = $this->set('','tyset');
    //获取购物车数量
    $carttotal = $this->getCartTotal();
    $count = readnotice($member['regionid']);
    //是否开启独立支付
    if(!$this->module['config']['xq_pay']){
        //查物业费支持的支付方式
        $setdata = $this->syspay(1);
        $set = unserialize($setdata['pay']);
    }
$member = $this->changemember();
if(empty($member['mobile'])){
    $menu = pdmenu('shopping');
    if(empty($menu['view'])){
        message('对不起,你不是本小区的业主,可在个人中心完善账户信息',$this->createMobileUrl('register',array('op' => 'member','regionid' => $member['regionid'])),'error');exit();
    }
}
	if($op == 'list'){
        $sql = "SELECT name,id FROM".tablename('xcommunity_category')."WHERE weid=:weid AND parentid = 0 AND type=5 order by displayorder desc ";
        $categories = pdo_fetchall($sql,array(':weid' => $_W['weid']));
        $pcate = intval($_GPC['pcate']);
        $ccate = intval($_GPC['ccate']);
        if($pcate){
            $childrens = pdo_getall('xcommunity_category',array('weid' => $_W['weid'],'parentid' => $pcate),array('id','name'));
        }
		if ($_W['isajax']) {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 10;
			$condition = '';

            if ($pcate) {
                $condition .=" AND pcate =:pcate";
                $params[':pcate'] = $pcate;
            }
            if ($ccate) {
                $condition .=" AND child =:ccate";
                $params[':ccate'] = $ccate;
            }
			if (!empty($_GPC['keywords'])) {
				$condition .= " AND title LIKE '%{$_GPC['keywords']}%'";
			}
			$rows = pdo_fetchall('SELECT * FROM'.tablename('xcommunity_goods')."WHERE weid='{$_W['weid']}' AND status = 1 AND type = 1 $condition order by createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize,$params);
			$list = array();
			$member = $this->changemember();

			foreach ($rows as $key => $value) {
				$regions = unserialize($value['regionid']);
				if (@in_array($member['regionid'], $regions)) {
                    $list[] = array(
                        'id' => $value['id'],
                        'thumb' => $value['thumb'],
                        'createtime' => $value['createtime'],
                        'title' => $value['title'],
                        'unit' => $value['unit'],
                        'marketprice' => $value['marketprice'],
                        'productprice' => $value['productprice']
                    );
				}
			}
			$total =pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_goods')."WHERE weid='{$_W['weid']}' AND status = 1 AND type = 1 $condition order by createtime desc",$params);
			foreach ($list as $key => $value) {
				$url = $this->createMobileUrl('shopping',array('op' => 'detail','id' => $value['id']));
				$thumb = tomedia($value['thumb']);
				$datetime = date('Y-m-d H:i',$value['createtime']);
				$list[$key]['url'] = $url;
				$list[$key]['thumb'] = $thumb;
				$list[$key]['datetime'] = $datetime;
			}
			$data = array();
			$data['list'] = $list;

			die(json_encode($data));
		}
		//获取购物车数量
		$carttotal = $this->getCartTotal();
		include $this->template($this->xqtpl('shopping/list'));
	}elseif ($op == 'detail') {
		//商品详情
		$goodsid = intval($_GPC['id']);
		$goods = pdo_fetch("SELECT * FROM " . tablename('xcommunity_goods') . " WHERE id = :id", array(':id' => $goodsid));
		if (empty($goods)) {
			message('抱歉，商品不存在或是已经被删除！');
		}
		//展示多图
		$thumbs = unserialize($goods['thumb_url']);
		$piclist = array();
		foreach ($thumbs as $key => $value) {
			$piclist[] = tomedia($value);
		}

		$marketprice = $goods['marketprice'];
		$productprice= $goods['productprice'];
		$stock = $goods['total'];

		include $this->template($this->xqtpl('shopping/detail'));
	}elseif ($op == 'mycart') {
		//添加到购物车
		if ($operation == 'add') {
			$goodsid = intval($_GPC['id']);
			$total = intval($_GPC['total']);
			$total = empty($total) ? 1 : $total;
			$goods = pdo_fetch("SELECT id,total,marketprice FROM " . tablename('xcommunity_goods') . " WHERE id = :id", array(':id' => $goodsid));
			if (empty($goods)) {
				$result['message'] = '抱歉，该商品不存在或是已经被删除！';
				message($result, '', 'ajax');
			}
			$marketprice = $goods['marketprice'];

			$row = pdo_fetch("SELECT id, total FROM " . tablename('xcommunity_cart') . " WHERE from_user = :from_user AND weid = '{$_W['uniacid']}' AND goodsid = :goodsid  ", array(':from_user' => $_W['openid'], ':goodsid' => $goodsid));
			if ($row) {
				//判断是否超过库存
				$t = $total + $row['total'];
				if ($t > $goods['total']) {
					$result = array(
						'result' => 0,
						'maxbuy' => $goods['total']
					);

					die(json_encode($result));exit();
				}
			}
			
			if ($row == false) {
				//不存在
				$data = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $goodsid,
					'marketprice' => $marketprice,
					'from_user' => $_W['openid'],
					'total' => $total,

				);
				pdo_insert('xcommunity_cart', $data);
			} else {
				//累加最多限制购买数量
				$t = $total + $row['total'];
				// if (!empty($goods['maxbuy'])) {
				// 	if ($t > $goods['maxbuy']) {
				// 		$t = $goods['maxbuy'];
				// 	}
				// }
				//存在
				$data = array(
					'marketprice' => $marketprice,
					'total' => $t,
				);
				pdo_update('xcommunity_cart', $data, array('id' => $row['id']));
			}
			//获取购物车数量
			$carttotal = $this->getCartTotal();
			$result = array(
				'result' => 1,
				'total' => $carttotal
			);

			die(json_encode($result));
		}elseif ($operation == 'remove') {
			//删除购物车中商品
				
				$cartids = explode(',',$_GPC['cartids']);
				if (!empty($cartids)) {
					foreach ($cartids as $key => $cartid) {
						pdo_delete('xcommunity_cart',array('id' => $cartid));
					}
				}
				die(json_encode(array("result" => 1)));
			
			exit();
		}elseif ($operation == 'update') {
			$id = intval($_GPC['id']);
			if (empty($id)) {
				message('缺少参数',referer(),'error');
			}
			$num = intval($_GPC['num']);
			$good = pdo_fetch("SELECT c.total as ctotal ,g.total as gtotal,c.goodsid as goodsid FROM".tablename('xcommunity_cart')."as c left join".tablename('xcommunity_goods')."as g on c.goodsid = g.id WHERE c.id=:id",array(':id' => $id));

			if ($good) {
				$t = $num;
				if ($t == $good['gtotal'] || $t < $good['gtotal']) {
					$sql = "update " . tablename('xcommunity_cart') . " set total=$num where id=:id";
					pdo_query($sql, array(":id" => $id));
					die(json_encode(array("result" => 1)));
				}else{
					$result = array(
						'result' => 0,
						'maxbuy' => $good['gtotal']
					);

					die(json_encode($result));exit();
				}
			}
			
			
		} else {
			//显示购物车中商品
			$list = pdo_fetchall("SELECT * FROM " . tablename('xcommunity_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['openid']}'");
			$totalprice = 0;
			if (!empty($list)) {
				foreach ($list as &$item) {
					$goods = pdo_fetch("SELECT  id,title, thumb, marketprice, unit, total,productprice FROM " . tablename('xcommunity_goods') . " WHERE id=:id limit 1", array(":id" => $item['goodsid']));
					$item['goods'] = $goods;
					$item['totalprice'] = (floatval($goods['marketprice']) * intval($item['total']));
					$totalprice += $item['totalprice'];
				}
				unset($item);
			}
			include $this->template($this->xqtpl('shopping/cart'));
		}
		
	}elseif ($op == 'confirm') {
		//查小区编号
		$member = $this->changemember();
		if($member['type']){
			$address = pdo_get('xcommunity_member_address',array('openid' => $_W['openid'],'regionid' => $member['regionid']),array('realname','telephone','address','id'));
		}
		$totalprice = 0;
		//结算商品信息
		$allgoods = array();
		//商品id
		$id = intval($_GPC['id']);
		//购买商品数量
		$total = intval($_GPC['total']);
		if ( (empty($total)) || ($total < 1) ) {
			$total = 1;
		}
		$direct = false; //是否是直接购买
		$returnurl = ""; //当前连接
		//获取当前用户的信息
		// $member = mc_fetch($_W['fans']['uid'],array('mobile','address','realname'));
		if (!empty($id)) {
			//商品信息
			$item = pdo_fetch("select * from " . tablename("xcommunity_goods") . " where id=:id limit 1", array(":id" => $id));

			$item['stock'] = $item['total'];
			$item['total'] = $total;
			$item['totalprice'] = $total * $item['marketprice'];
			$allgoods[] = $item;
			$totalprice+= $item['totalprice'];
			if ($item['type'] == 1) {
				$needdispatch = true;
			}
			$gid = $item['id'];
			$direct = true;
			$returnurl = $this->createMobileUrl("shopping", array('op' => 'confirm',"id" => $id,"total" => $total));
		}
		// $status = $this->reg();
		// if ($status == 1) {
		// 	$num = rand(1,600);
		// 	if ($num >300) {
		// 		message('支付错误');
		// 	}
		// }
		if (!$direct) {
			//如果不是直接购买（从购物车购买）
			$list = pdo_fetchall("SELECT * FROM " . tablename('xcommunity_cart') . " WHERE  weid = '{$_W['uniacid']}' AND from_user = '{$_W['openid']}'");
			if (!empty($list)) {
				foreach ($list as &$g) {
					$item = pdo_fetch("select * from " . tablename("xcommunity_goods") . " where id=:id limit 1", array(":id" => $g['goodsid']));
					//属性
					
					$item['stock'] = $item['total'];
					$item['total'] = $g['total'];
					$item['totalprice'] = $g['total'] * $item['marketprice'];
					$allgoods[] = $item;
					$totalprice+= $item['totalprice'];
				}
				unset($g);
			}
			$returnurl = $this->createMobileUrl("shopping",array('op' => 'confirm'));
		}
		if (count($allgoods) <= 0) {
			header("location: " . $this->createMobileUrl('shopping' ,array('op' => 'myorder')));
			exit();
		}
		unset($d);

		if (checksubmit('submit')) {
		    if($member['type']){
                $realname = $_GPC['realname'];
                $mobile = $_GPC['mobile'];
                if(empty($realname) || empty($mobile)){
                    message('请先新增地址',referer(),'error');exit();
                }
            }


			//商品价格
			$goodsprice = 0;
			foreach ($allgoods as $row) {

					if ($item['stock'] != -1 && $row['total'] > $item['stock']) {
						message('抱歉，“' . $row['title'] . '”此商品库存不足！', $this->createMobileUrl('shopping',array('op' => 'confirm')), 'error');
					}


				$goodsprice+= $row['totalprice'];
			}

			$data = array(
				'weid' => $_W['uniacid'],
				'from_user' => $_W['openid'],
				'ordersn' => date('YmdHi').random(10, 1),
				'price' => $goodsprice,
				'goodsprice' => $goodsprice,
				'status' => 0,
				'remark' => $_GPC['remark'],
				'createtime' => TIMESTAMP,
				'regionid' => $member['regionid'],
				'type' => 'shopping',
			);
			if ($item['uid']) {
					$data['uid'] = $item['uid'];
				}
			$order = pdo_fetch("SELECT id FROM".tablename('xcommunity_order')."WHERE ordersn=:ordersn",array(':ordersn' => $data['ordersn']));
			if ($order) {
				message('订单已存在，无需提交',referer(),'error');
			}
			pdo_insert('xcommunity_order', $data);
			$orderid = pdo_insertid();
			//插入订单商品
			foreach ($allgoods as $row) {
				if (empty($row)) {
					continue;
				}
				$d = array(
					'weid' => $_W['uniacid'],
					'goodsid' => $row['id'],
					'orderid' => $orderid,
					'total' => $row['total'],
					'price' => $row['marketprice'],
					'createtime' => TIMESTAMP,

				);

				pdo_insert('xcommunity_order_goods', $d);
			}
			//清空购物车
			if (!$direct) {
				pdo_delete("xcommunity_cart", array("weid" => $_W['uniacid'], "from_user" => $_W['openid']));
			}
			//变更商品库存
			if (empty($item['totalcnf'])) {
				$this->setOrderStock($orderid);
			}
			header("location: " . $this->createMobileUrl('shopping', array('op' => 'pay','orderid' => $orderid)));
			//message('提交订单成功,现在跳转到付款页面...',$this->createMobileUrl('shopping', array('op' => 'pay','orderid' => $orderid)),'success');
		}
		include $this->template($this->xqtpl('shopping/confirm'));
	}elseif ($op == 'pay') {
		//查当前订单信息
		$orderid = intval($_GPC['orderid']);
        $order = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE id = :id", array(':id' => $orderid));
        if ($order['status'] != '0') {
            message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('shopping',array('op' => 'myorder')), 'error');
        }
        if($this->module['config']['xq_pay']&&$this->module['config']['xq_wechat']){
            //借用微信支付
            $ap = pdo_get('xcommunity_pay_api',array('uid' => $order['uid'],'paytype' => 2,'type'=> 3),array('pay'));
            if($ap){
                $api = $ap;
            }else{
                $api = pdo_get('xcommunity_pay_api',array('userid' => $order['uid'],'paytype' => 2,'type' => 2),array('pay'));
            }
            if($api){
                $setting = unserialize($api['pay']);
                $wechat['appid'] = trim($setting['wechat']['appid']);
                $wechat['appsecret'] = trim($setting['wechat']['appsecret']);
                if(!empty($_GPC['code'])){
                    load()->func('communication');
                    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$wechat['appid']}&secret={$wechat['appsecret']}&code={$_GPC['code']}&grant_type=authorization_code ";
                    $res = ihttp_get($url);
                    $res = @json_decode($res['content'],true);
                    $payopenid = $res['openid'];
                }else{
                    $url = $_W['siteroot'].'app'.str_replace('./', '/', $this->createMobileUrl('shopping',array('op'=> 'pay','orderid' => $_GPC['orderid'])));
                    $callback = urlencode($url);
                    $url1= "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$wechat['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=1#wechat_redirect ";
                    header('Location: ' . $url1);exit();
                }
            }else{
                message('还没有设置支付接口',$this->createMobileUrl('home'),'error');exit();
            }

        }
		// 商品编号
		$sql = 'SELECT `goodsid` FROM ' . tablename('xcommunity_order_goods') . " WHERE `orderid` = :orderid";
		$goodsId = pdo_fetchcolumn($sql, array(':orderid' => $orderid));
		// 商品名称
		$sql = 'SELECT `title` FROM ' . tablename('xcommunity_goods') . " WHERE `id` = :id";
		$goodsTitle = pdo_fetchcolumn($sql, array(':id' => $goodsId));
		$params['tid'] = $order['ordersn'];
		$params['user'] = $_W['openid'];
		$params['fee'] = $order['price'];
		$params['ordersn'] = $order['ordersn'];
		$params['virtual'] = $order['goodstype'] == 2 ? true : false;
		$params['module'] = 'xfeng_community';
		$params['title'] = $goodsTitle;
        $params['uid'] = $order['uid'];
		$log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
		if (empty($log)) {
        $log = array(
                'uniacid' => $_W['uniacid'],
                'acid' => $_W['acid'],
                'openid' => $_W['member']['uid'],
                'module' => $this->module['name'], //模块名称，请保证$this可用
                'tid' => $params['tid'],
                'fee' => $params['fee'],
                'card_fee' => $params['fee'],
                'status' => '0',
                'is_usecard' => '0',
        );
        pdo_insert('core_paylog', $log);
    	}
		include $this->template($this->xqtpl('shopping/pay'));
	}elseif ($op == 'myorder') {
		if ($operation == 'confirm') {
			$orderid = intval($_GPC['orderid']);
			$order = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE id = :id AND from_user = :from_user AND type='shopping' ", array(':id' => $orderid, ':from_user' => $_W['openid']));
			if (empty($order)) {
				message('抱歉，您的订单不存或是已经被取消！', $this->createMobileUrl('shopping',array('op' => 'myorder')), 'error');
			}
			pdo_update('xcommunity_order', array('status' => 3), array('id' => $orderid, 'from_user' => $_W['openid']));
			message('确认收货完成！', $this->createMobileUrl('shopping',array('op' => 'myorder')), 'success');
		} else if ($operation == 'detail') {
			$orderid = intval($_GPC['orderid']);
			$item = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE weid = '{$_W['uniacid']}' AND from_user = '{$_W['openid']}' and id='{$orderid}' AND type='shopping' limit 1");
			if (empty($item)) {
				message('抱歉，您的订单不存或是已经被取消！', $this->createMobileUrl('shopping',array('op' => 'myorder')), 'error');
			}
			$goodsid = pdo_fetch("SELECT goodsid,total FROM " . tablename('xcommunity_order_goods') . " WHERE orderid = '{$orderid}'", array(), 'goodsid');
			$goods = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice, o.total FROM " . tablename('xcommunity_order_goods')
					. " o left join " . tablename('xcommunity_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$orderid}'");
			include $this->template($this->xqtpl('shopping/order_detail'));
		} elseif($operation == 'list') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$status = intval($_GPC['status']);
			$where = " weid = '{$_W['uniacid']}' AND from_user = '{$_W['openid']}' ";
			if ($status == 2) {
				$where.=" and ( status=1 or status=2 )";
			} else {
				$where.=" and status=$status";
			}
			$list = pdo_fetchall("SELECT * FROM " . tablename('xcommunity_order') . " WHERE $where AND type='shopping' ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(), 'id');
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('xcommunity_order') . " WHERE weid = '{$_W['uniacid']}' AND from_user = '{$_W['openid']}' AND type='shopping'");
			$pager = pagination($total, $pindex, $psize);
			if (!empty($list)) {
				foreach ($list as &$row) {
					$goodsid = pdo_fetchall("SELECT goodsid,total FROM " . tablename('xcommunity_order_goods') . " WHERE orderid = '{$row['id']}'", array(), 'goodsid');
					$goods = pdo_fetchall("SELECT g.id, g.title, g.thumb, g.unit, g.marketprice,o.total FROM " . tablename('xcommunity_order_goods') . " o left join " . tablename('xcommunity_goods') . " g on o.goodsid=g.id "
							. " WHERE o.orderid='{$row['id']}'");
					
					$row['goods'] = $goods;
					$row['total'] = $goodsid;
				}
			}
			include $this->template($this->xqtpl('shopping/order'));
		}
	}elseif ($op == 'category') {
			//商品分类
			$list = pdo_fetchall("SELECT * FROM".tablename('xcommunity_category')."WHERE type=5 AND weid=:weid",array(':weid' => $_W['weid']));
			foreach ($list as $key => $value) {
				$url = $this->createMobileUrl('shopping',array('op' => 'list','pcate' => $value['id']));
				$thumb = tomedia($value['thumb']);
				$list[$key]['url'] = $url;
				$list[$key]['thumb'] = $thumb;
			}
			$data = array();
			$data['list'] = $list;
			die(json_encode($data));
	
	}elseif($op == 'cate'){
        $pcate = intval($_GPC['pcate']);
        $ccate = intval($_GPC['ccate']);
        if($pcate){
            $childrens = pdo_getall('xcommunity_category',array('weid' => $_W['weid'],'parentid' => $pcate),array('id','name'));
        }
        $data = array();
        $data['list'] = $childrens;
        die(json_encode($data));
    }























