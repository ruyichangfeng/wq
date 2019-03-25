<?php 
		$cfg    = $this->module['config'];
		$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($op == 'display') {
		    $pindex    = max(1, intval($_GPC['page']));
		    $psize     = 20;
		    $status    = !isset($_GPC['status']) ? 1 : $_GPC['status'];
		    $sendtype  = !isset($_GPC['sendtype']) ? 0 : $_GPC['sendtype'];
		    $condition = '';
		    $param_ordersn = $_GPC['ordersn'];
		    if (!empty($_GPC['ordersn'])) {
		        $condition .= " AND o.ordersn LIKE '%{$_GPC['ordersn']}%'";
		    }
			if (!empty($_GPC['realname'])) {
		        $condition .= " AND a.realname LIKE '%{$_GPC['realname']}%'";
		    }
			if (!empty($_GPC['mobile'])) {
		        $condition .= " AND a.mobile LIKE '%{$_GPC['mobile']}%'";
		    }
		    if (!empty($_GPC['time'])) {
		        $condition .= " and o.createtime >=" . strtotime($_GPC['time']['start']) . " and o.createtime <=" . strtotime($_GPC['time']['end']) . " ";
		        $starttime = strtotime($_GPC['time']['start']);
		        $endtime   = strtotime($_GPC['time']['end']);
		    } else {
		        $starttime = 0;
		        $endtime   = time()+3600*24;
		    }
		    if ($status != '-1') {
		        if ($status == '1') {
		            $condition .= " and ((o.paytype=3 AND (o.status = 0 or o.status = 1)) or (o.paytype!=3 AND o.status = 1) )";
		        } else {
		            $condition .= " AND o.status = '" . intval($status) . "'";
		        }
		    }
			
		
			
		    if (!empty($_GPC['orderstatisticsEXP01'])) {
		        $report    = "orderstatistics";
		        $condition = '';
		        if (!empty($_GPC['ordersn'])) {
		            $condition .= " AND t1.ordersn LIKE '%{$_GPC['ordersn']}%'";
		        }
				
				if (!empty($_GPC['realname'])) {
					$condition .= " AND t1.tdrealname LIKE '%{$_GPC['realname']}%'";
				}
				if (!empty($_GPC['mobile'])) {
					$condition .= " AND t1.tdmobile LIKE '%{$_GPC['mobile']}%'";
				}

		        if (!empty($_GPC['shareid'])) {
		            $shareid = $_GPC['shareid'];
		            $user    = pdo_fetch("select * from " . tablename('mihua_mall_member') . " where id = " . $shareid . " and uniacid = " . $_W['uniacid']);
		            $condition .= " AND t1.shareid = '" . intval($_GPC['shareid']) . "' AND t1.createtime>=" . $user['flagtime'] . " AND t1.from_user<>'" . $user['from_user'] . "'";
		        }
		        if ($status != '-1') {
		            if ($status == '1') {
		                $condition .= " and ((t1.paytype=3 AND (t1.status = 0 or t1.status = 1)) or (t1.paytype!=3 AND t1.status = 1) )";
		            } else {
		                $condition .= " AND t1.status = '" . intval($status) . "'";
		            }
		        }
		        if (!empty($_GPC['orderstatisticsEXP01'])) {
		            $psize  = 9999;
		            $pindex = 1;
		        }
		        $list = pdo_fetchall("select t1.* from (SELECT orders.remark,orders.from_user,orders.status,orders.sendtype,orders.uniacid,orders.id,orders.createtime,orders.ordersn,orders.price,orders.dispatchprice,orders.paytype,orders.shareid,(select member.realname from " . tablename('mihua_mall_member') . " member where member.from_user=orders.from_user and orders.uniacid=member.uniacid limit 1 ) realnamestr,(select taddress.realname from " . tablename('mihua_mall_address') . " taddress where taddress.id=orders.addressid $c and orders.uniacid=taddress.uniacid limit 1 ) tdrealname,(select concat(taddress.province,taddress.city,taddress.area,taddress.address) from " . tablename('mihua_mall_address') . " taddress where taddress.id=orders.addressid  and orders.uniacid=taddress.uniacid limit 1 ) tdaddress,(select taddress.mobile from " . tablename('mihua_mall_address') . " taddress  where taddress.id=orders.addressid  and orders.uniacid=taddress.uniacid limit 1 ) 
				tdmobile from " . tablename('mihua_mall_order') . " orders where orders.uniacid = :uniacid $conditionOrderStatus order 
				by orders.createtime  desc) t1  where  t1.uniacid = :uniacid   $condition   LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $_W['uniacid']));

				  
				foreach ($list as $id => $displayorder) {
		            $list[$id]['ordergoods'] = pdo_fetchall("SELECT goods.thumb,ordersgoods.price,ordersgoods.total,goods.title,ordersgoods.optionname from " . tablename('mihua_mall_order_goods') . " ordersgoods left join " . tablename('mihua_mall_goods') . " goods on goods.id=ordersgoods.goodsid  where ordersgoods.uniacid = :uniacid and ordersgoods.orderid=:oid order by ordersgoods.createtime  desc ", array(':uniacid' => $_W['uniacid'], ':oid' => $list[$id]['id']));
		        }
		        require 'report.php';
		        exit;
		    }
		    //$list  = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE uniacid = '{$_W['uniacid']}' 
			$list  = pdo_fetchall("select a.*,o.* from " . tablename('mihua_mall_address') . " a left join ".
			 tablename('mihua_mall_order') . " o on o.addressid=a.id WHERE o.uniacid = '{$_W['uniacid']}'
			$condition ORDER BY status ASC, createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mihua_mall_address') . " a left join ".
			 tablename('mihua_mall_order') . " o on o.addressid=a.id WHERE o.uniacid = '{$_W['uniacid']}' $condition");
		    $pager = pagination($total, $pindex, $psize);
		    if (!empty($list)) {
		        foreach ($list as $key => $l) {
		            $commissions = pdo_fetchall("select total,commission as commission, commission2 as commission2, commission3 as commission3 from " . tablename('mihua_mall_order_goods') . " where orderid = " . $l['id']);
		            foreach ($commissions as $commission) {
		                $list[$key]['commission'] = $commission['commission'] * $commission['total'];
		                if ($cfg['globalCommissionLevel'] >= 2) {
		                    $list[$key]['commission2'] = $commission['commission2'] * $commission['total'];
		                } else {
		                    $list[$key]['commission2'] = 0;
		                }
		                if ($cfg['globalCommissionLevel'] >= 3) {
		                    $list[$key]['commission3'] = $commission['commission3'] * $commission['total'];
		                } else {
		                    $list[$key]['commission3'] = 0;
		                }
		            }
		        }
		    }
		    if (!empty($list)) {
		        foreach ($list as &$row) {
		            !empty($row['addressid']) && $addressids[$row['addressid']] = $row['addressid'];
		            $row['dispatch']                                            = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_dispatch') . " WHERE id = :id", array(':id' => $row['dispatch']));
		        }
		        unset($row);
		    }
		    if (!empty($addressids)) {
		        $address = pdo_fetchall("SELECT * FROM " . tablename('mihua_mall_address') . " WHERE id IN ('" . implode("','", $addressids) . "')", array(), 'id');
		    }
		} elseif ($op == 'detail') {
		    $members = pdo_fetchall("select id, realname from " . tablename('mihua_mall_member') . " where uniacid = " . $_W['uniacid'] . " and status = 1");
		    $member  = array();
		    foreach ($members as $m) {
		        $member[$m['id']] = $m['realname'];
		    }
		    $id   = intval($_GPC['id']);
		    $item = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE id = :id", array(':id' => $id));    
		    if($item['shareid']){ $re=pdo_fetch("select balance from ".tablename('mihua_mall_member')." where id={$item['shareid']}"); $item['balance']=$re['balance'];}
		    if($item['shareid2']){ $re=pdo_fetch("select balance from ".tablename('mihua_mall_member')." where id={$item['shareid2']}"); $item['balance2']=$re['balance'];}
		    if($item['shareid3']){ $re=pdo_fetch("select balance from ".tablename('mihua_mall_member')." where id={$item['shareid3']}"); $item['balance3']=$re['balance'];}
			if ($item['deductible']!=0){
						$deductible =  $cfg['deductible'];			 
					if (empty($deductible)) {
						$deductible = 0.1;
						}
					$count_ded=$item['deductible'] * $deductible;
					}

		    if (empty($item)) {
		        message("抱歉，订单不存在!", referer(), "error");
		    }
		    if (checksubmit('confirmsend')) {
		        if (!empty($_GPC['isexpress']) && empty($_GPC['expresssn'])) {
		            message('请输入快递单号！');
		        }
		        $item = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE id = :id", array(':id' => $id));
		        if (!empty($item['transid'])) {
		            $this->changeWechatSend($id, 1);
		        }
		        pdo_update('mihua_mall_order', array('status' => 2, 'remark' => $_GPC['remark'], 'express' => $_GPC['express'], 'expresscom' => $_GPC['expresscom'], 'expresssn' => $_GPC['expresssn']), array('id' => $id));
		        //查找商品信息
				$goods_list = C('order')->orderIdFindGoods($id);
				$goods_name = C('goods')->composeGoodsName($goods_list);
				$arr = array(
					'first'=>'亲，宝贝已经启程了，好想快点来到你身边',
					'delivername'=>$_GPC['express'],
					'ordername'  =>$_GPC['expresssn'],
					'remark'     =>$goods_name
				);
				$url = $_W['siteroot'].'app/'.$this->createMobileUrl('myorder',array('op'=>'detail','orderid'=>$id));
				$class_msg = C('msg');
				$class_msg->openid = $item['from_user'];
				$class_msg->config = $this->module['config'];
				$result = $class_msg->sendHuoTemplate($arr,$url);
				message('发货操作成功！', referer(), 'success');
		    }
		    if (checksubmit('cancelsend')) {
		        $item = pdo_fetch("SELECT transid FROM " . tablename('mihua_mall_order') . " WHERE id = :id", array(':id' => $id));
		        if (!empty($item['transid'])) {
		            $this->changeWechatSend($id, 0, $_GPC['cancelreson']);
		        }
		        pdo_update('mihua_mall_order', array('status' => 1, 'remark' => $_GPC['remark']), array('id' => $id));
		        message('取消发货操作成功！', referer(), 'success');
		    }

		    if (checksubmit('finish')) {
		       // $this->setOrderCredit($id, $_W['uniacid']);
		        pdo_update('mihua_mall_order', array('status' => 3, 'remark' => $_GPC['remark']), array('id' => $id));
		        if (empty($_W['key'])) {
		            load()->model('account');
		            $account       = uni_accounts($_W['uniacid']);
		            $_W['account'] = end($account);
		        }
		        $order     = pdo_fetch('SELECT * FROM ' . tablename('mihua_mall_order') . ' WHERE id=:id', array(':id' => $id));
		        $from_user = $order['from_user'];
		        $profile   = $this->getProfile($from_user);
		        if (empty($profile)) {
		            // pdo_update('mihua_mall_member', array('balance' => 0), array('from_user' => $from_user));
		            // $this->sendcustomMsg($from_user, '您的余额已被清零。');
		        } else {
		            // $order = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_order') . " WHERE id = :id limit 1", array(':id' => $id));
		            $goods = pdo_fetchall('SELECT * FROM ' . tablename('mihua_mall_order_goods') . ' WHERE orderid=' . $id);
		            $t1    = $t2    = $t3    = 0;
		            foreach ($goods as $g) {
		                $t1 += floatval($g['commission']) * floatval($g['total']);
		                $t2 += floatval($g['commission2']) * floatval($g['total']);
		                $t3 += floatval($g['commission3']) * floatval($g['total']);
		            }
		            include_once IA_ROOT . '/addons/mihua_mall/class/redpack.php';
		            if ($t1 > 0 && $order['shareid'] > 0) {
		                $user1 = pdo_fetch('SELECT id,from_user,balance,commission,zhifu,uid FROM ' . tablename('mihua_mall_member') . ' WHERE id=:id', array(':id' => $order['shareid']));
		                $total = $t1 + floatval($user1['balance']);
		                if ($total > 1) {
		                    $params              = array();
		                    $params['mch_id']    = $cfg['mch_id'];
		                    $params['wxappid']   = $_W['account']['key'];
		                    $params['nick_name'] = $_W['uniaccount']['name'];
		                    $params['send_name'] = $_W['uniaccount']['description'];
		                    $params['re_openid'] = $user1['from_user'];
		                    $params['max_value'] = 100;
		                    $params['min_value'] = 20000;
		                    $params['total_num'] = 1;
		                    $params['wishing']   = $cfg['wishing'];
		                    $params['remark']    = $cfg['remark'];
		                    $params['act_name']  = $cfg['act_name'];
		                    $params['key']       = $cfg['key'];
		                    if ($cfg['logo_imgurl']) {
		                        $params['logo_imgurl'] = $_W['siteroot'] . 'attachment/' . $cfg['logo_imgurl'];
		                    }
		                    $cm = 0;
		                    $tm = 0;		                    
		                    if($total>200){
		                    	$tm = 200;
		                    	$total -= 200;
		                    }else{
		                    	$tm    = $total;
		                        $total = 0;	
		                    }
		                        $params['total_amount'] = $tm * 100;
		                        $params['min_value']    = $params['max_value']    = $params['total_amount'];		                    
		                     	$ret = sendRedPack($params,$order['id']);
		                     	if($ret){
 									$cm += $tm;
		                     	}else{
		                     		$total += $tm;
		                     	}

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
		            	$total=0;
		                $user2 = pdo_fetch('SELECT id,from_user,balance,commission,zhifu,uid FROM ' . tablename('mihua_mall_member') . ' WHERE id=:id', array(':id' => $order['shareid2']));
		                $total = $t2 + floatval($user2['balance']);
		                if ($total > 1) {
		                    $params              = array();
		                    $params['mch_id']    = $cfg['mch_id'];
		                    $params['wxappid']   = $_W['account']['key'];
		                    $params['nick_name'] = $_W['uniaccount']['name'];
		                    $params['send_name'] = $_W['uniaccount']['description'];
		                    $params['re_openid'] = $user2['from_user'];
		                    $params['max_value'] = 100;
		                    $params['min_value'] = 20000;
		                    $params['total_num'] = 1;
		                    $params['wishing']   = $cfg['wishing'];
		                    $params['remark']    = $cfg['remark'];
		                    $params['act_name']  = $cfg['act_name'];
		                    $params['key']       = $cfg['key'];
		                    if ($cfg['logo_imgurl']) {
		                        $params['logo_imgurl'] = $_W['siteroot'] . 'attachment/' . $cfg['logo_imgurl'];
		                    }
		                    $cm = 0;
		                    $tm = 0;		                    
		                    if($total>200){
		                    	$tm = 200;
		                    	$total -= 200;
		                    }else{
		                    	$tm    = $total;
		                        $total = 0;	
		                    }
		                        $params['total_amount'] = $tm * 100;
		                        $params['min_value']    = $params['max_value']    = $params['total_amount'];		                    
		                     	$ret = sendRedPack($params,$order['id']);
		                     	if($ret){
 									$cm += $tm;
		                     	}else{
		                     		$total += $tm;
		                     	}

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
		            	$total=0;
		                $user3 = pdo_fetch('SELECT id,from_user,balance,commission,zhifu,uid FROM ' . tablename('mihua_mall_member') . ' WHERE id=:id', array(':id' => $order['shareid3']));
		                $total = $t3 + floatval($user3['balance']);
		                if ($total > 1) {
		                    $params              = array();
		                    $params['mch_id']    = $cfg['mch_id'];
		                    $params['wxappid']   = $_W['account']['key'];
		                    $params['nick_name'] = $_W['uniaccount']['name'];
		                    $params['send_name'] = $_W['uniaccount']['description'];
		                    $params['re_openid'] = $user3['from_user'];
		                    $params['max_value'] = 100;
		                    $params['min_value'] = 20000;
		                    $params['total_num'] = 1;
		                    $params['wishing']   = $cfg['wishing'];
		                    $params['remark']    = $cfg['remark'];
		                    $params['act_name']  = $cfg['act_name'];
		                    $params['key']       = $cfg['key'];
		                    if ($cfg['logo_imgurl']) {
		                        $params['logo_imgurl'] = $_W['siteroot'] . 'attachment/' . $cfg['logo_imgurl'];
		                    }
		                    $cm = 0;
		                    $tm = 0;
		                    if($total>200){
		                    	$tm = 200;
		                    	$total -= 200;
		                    }else{
		                    	$tm    = $total;
		                        $total = 0;	
		                    }
		                        $params['total_amount'] = $tm * 100;
		                        $params['min_value']    = $params['max_value']    = $params['total_amount'];		                    
		                     	$ret = sendRedPack($params,$order['id']);
		                     	if($ret){
 									$cm += $tm;
		                     	}else{
		                     		$total += $tm;
		                     	}
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
		        message('订单操作成功！', referer(), 'success');
		    }
		    if (checksubmit('cancelpay')) {
		        pdo_update('mihua_mall_order', array('status' => 0, 'remark' => $_GPC['remark']), array('id' => $id));
		        $this->setOrderStock($id, false);
		        message('取消订单付款操作成功！', referer(), 'success');
		    }
		    if (checksubmit('confrimpay')) {
		        pdo_update('mihua_mall_order', array('status' => 1, 'paytype' => 2, 'remark' => $_GPC['remark']), array('id' => $id));
		        message('确认订单付款操作成功！', referer(), 'success');
		    }
		    if (checksubmit('close')) {
		        $item = pdo_fetch("SELECT transid FROM " . tablename('mihua_mall_order') . " WHERE id = :id", array(':id' => $id));
		        if (!empty($item['transid'])) {
		            $this->changeWechatSend($id, 0, $_GPC['reson']);
		        }
		        pdo_update('mihua_mall_order', array('status' => -1, 'remark' => $_GPC['remark']), array('id' => $id));
		        message('订单关闭操作成功！', referer(), 'success');
		    }
		    if (checksubmit('open')) {
		        pdo_update('mihua_mall_order', array('status' => 0, 'remark' => $_GPC['remark']), array('id' => $id));
		        message('开启订单操作成功！', referer(), 'success');
		    }
		    $dispatch = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_dispatch') . " WHERE id = :id", array(':id' => $item['dispatch']));
		    if (!empty($dispatch) && !empty($dispatch['express'])) {
		        $express = pdo_fetch("select * from " . tablename('mihua_mall_express') . " WHERE id=:id limit 1", array(":id" => $dispatch['express']));
		    }
		    $item['user']  = pdo_fetch("SELECT * FROM " . tablename('mihua_mall_address') . " WHERE id = {$item['addressid']}");
		    $goods         = pdo_fetchall("SELECT g.id,o.total,o.commission,o.commission2,o.commission3, g.title, g.status,g.thumb, g.unit,g.goodssn,g.productsn,g.marketprice,o.total,g.type,o.optionname,o.optionid,o.price as orderprice FROM " . tablename('mihua_mall_order_goods') . " o left join " . tablename('mihua_mall_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$id}'");
		    $item['goods'] = $goods;
		} elseif ('delete' == $op) {
		    $id = intval($_GPC['id']);
		    pdo_delete('mihua_mall_order_goods', array('orderid' => $id, 'uniacid' => $_W['uniacid']));
		    pdo_delete('mihua_mall_order', array('id' => $id, 'uniacid' => $_W['uniacid']));
		    message('订单删除成功', referer(), 'success');
		}