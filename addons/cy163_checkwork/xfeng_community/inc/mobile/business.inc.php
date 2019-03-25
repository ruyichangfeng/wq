<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 独立商家
 */


	global $_W,$_GPC;
	$region = $this->mreg();
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
	$operation = !empty($_GPC['operation']) ? $_GPC['operation'] : 'list';
    $user = mc_fetch($_W['fans']['uid'], array('mobile', 'credit1','credit2', 'realname', 'address'));
	//微信端商家展示
		//是否开启商家定位
		WeSession::start($_W['uniacid'],$_W['openid'],600);
		if($_GPC['lng']&&$_GPC['lat']){
			$_SESSION['lng'] = $_GPC['lng'];
			$_SESSION['lat'] = $_GPC['lat'];
		}
		$lng = $_SESSION['lng'] ? $_SESSION['lng'] : $_GPC['lng'];
		$lat = $_SESSION['lat'] ? $_SESSION['lat'] : $_GPC['lat'];
		$credit = $this->credit();
    $count = readnotice($member['regionid']);
    //是否开启独立支付
    if(!$this->module['config']['xq_pay']){
        //查物业费支持的支付方式
        $setdata = $this->syspay(3);
        $set = unserialize($setdata['pay']);
    }
//获取购物车数量
$carttotal = $this->getCartTotal();
$member = $this->changemember();
if(empty($member['mobile'])){
    $menu = pdmenu('business');
    if(empty($menu['view'])){
        message('对不起,你不是本小区的业主,可在个人中心完善账户信息',$this->createMobileUrl('register',array('op' => 'member','regionid' => $member['regionid'])),'error');exit();
    }
}
	if($op == 'list'){
		$condition = '';
        $keyword = $_GPC['keyword'];
        if ($keyword) {
        	$condition .= " AND sjname LIKE '%{$_GPC['keyword']}%' or parent LIKE '{$_GPC['keyword']}'";
        }
		$categories = pdo_getall('xcommunity_category',array('weid' => $_W['uniacid'],'type' => 6,'parentid' =>0),array('name','id'));
        $parent = $_GPC['parent'];
        if ($parent) {
        	$condition .= " AND parent = '{$parent}'";
        }
		if ($_W['isajax'] || $_W['ispost']) {
            $set = $this->set('','tyset');
            if ($set['sj']) {
                if ($set['sjrange']) {
                    $range = $set['sjrange'];
                }else {
                    $range = 5;

                }
                $point = $this->squarePoint($lng, $lat, $range);
                $condition .= "AND lat<>0 AND lat >= '{$point['right-bottom']['lat']}' AND lat <= '{$point['left-top']['lat']}' AND lng >= '{$point['left-top']['lng']}' AND lng <= '{$point['right-bottom']['lng']}'";

			}

//			if($_GPC['type'] == 1){
//                $con =' order by price asc';
//            }else{
//                $con ="order by id desc";
//            }
            // print_r($condition);exit();
			// if ($lng && $lat) {
				$pindex = max(1, intval($_GPC['page']));
				$psize  = 10;

		        $sql = "SELECT * FROM".tablename('xcommunity_dp')."WHERE weid='{$_W['weid']}' $condition order by id desc LIMIT ".($pindex - 1) * $psize.','.$psize;
//
				$result = pdo_fetchall($sql);
				// print_r($result);
				$count = count($result);
				$list = array();
				if (!empty($result)) {
			            $min = -1;
			            foreach ($result as &$row) {
			                $row['distance'] = $this->GetDistance($lat, $lng, $row['lat'], $row['lng']);

			                if ($min < 0 || $row['distance'] < $min) {
			                    $min = $row['distance'];
			                }
			            }
			            // echo $row['distance'];
			            unset($row);

			            $temp = array();
			            for ($i = 0; $i < $count; $i++) {
			                foreach ($result as $j => $row) {
			                    if (empty($temp['distance']) || $row['distance'] < $temp['distance']) {
			                        $temp = $row;
			                        $h = $j;
			                    }
			                }
			                if (!empty($temp)) {
			                    $juli = floor($temp['distance'])/1000;
								$url = $this->createMobileUrl('business',array('op' => 'detail','id' => $temp['id']));
                                $total = pdo_fetchcolumn("SELECT count(*) FROM".tablename('xcommunity_rank')."WHERE weid=:weid AND dpid=:dpid ",array(':weid' => $_W['uniacid'],':dpid' => $temp['id']));
			                    $list[] = array(
			                        'sjname' => $temp['sjname'],
			                        'juli'  => sprintf('%.1f', (float)$juli),
			                        'lng'   => $temp['lng'],
			                        'lat'   => $temp['lat'],
			                        'address'=>$temp['address'],
			                        'mobile' => $temp['mobile'],
			                        'picurl' =>  tomedia($temp['picurl']),
			                        'id' => $temp['id'],
                                    'price' => $temp['price'],
                                    'area' => $temp['area'],
			                        'businessurl' => $temp['businessurl'] ? $temp['businessurl'] : $url,
                                    'total' => $total?$total : 0
 			                    );
			                    unset($result[$h]);
			                    $temp = array();
			                }
			            }
			            if($_GPC['type'] == 1){
                            sortArrByField($list,'price');
                        }elseif($_GPC['type' == 2]){
                            sortArrByField($list,'juli');
                        }

			        }
                    $data = array();
                    $data['list'] = $list;
                    die(json_encode($data));
		}
		include $this->template($this->xqtpl('business/list'));
	}elseif ($op == 'detail') {
		//微信端商家内容页
		$id = intval($_GPC['id']);
		if ($id) {
			$item = pdo_fetch("SELECT * FROM".tablename('xcommunity_dp')."WHERE id=:id",array(':id' => $id));
			$thumb = tomedia($item['picurl']);
			if ($item['id']) {
				$list = pdo_fetchall("SELECT * FROM".tablename('xcommunity_goods')."WHERE weid=:weid AND type = 2 AND dpid = :dpid AND isrecommand = 1 ",array(':weid' => $_W['uniacid'],':dpid' => $item['id']));
			}
            $rank = pdo_getall('xcommunity_rank',array('weid' => $_W['uniacid'],'dpid' => $id),array('content'));
			foreach ($rank as $key => $val){
			    $r = unserialize($val['content']);
			    $score += $r['score'];//总评分
            }
            //评分次数
            $count = pdo_fetchcolumn("SELECT count(*) FROM".tablename('xcommunity_rank')."WHERE weid=:weid AND dpid=:dpid ",array(':weid' => $_W['uniacid'],':dpid' => $id));
            $aver = $score / $count;
            $aver = round($aver, 1) * 10;

		}
		include $this->template($this->xqtpl('business/detail'));
	}elseif ($op == 'coupon') {
		//团购券

		if ($operation == 'list') {
			//团购券列表
			$dpid = intval($_GPC['dpid']);

			if ($dpid) {
				$dp = pdo_fetch("SELECT sjname FROM".tablename('xcommunity_dp')."WHERE weid=:weid AND id=:id",array(':weid' => $_W['uniacid'],':id' => $dpid));

			}
			if ($_W['isajax'] || $_W['ispost']) {
		
				$pindex = max(1, intval($_GPC['page']));
				$psize  = 10;
							// echo $dpid;exit();
		        $sql = "SELECT * FROM".tablename('xcommunity_goods')."WHERE weid=:weid AND  type = 2 AND dpid = :dpid order by id desc LIMIT ".($pindex - 1) * $psize.','.$psize;
		        $params[':weid'] = $_W['uniacid'];
		        $params[':dpid'] = $dpid;
				$list = pdo_fetchall($sql,$params);
				foreach ($list as $key => $value) {
					$thumb = tomedia($value['thumb']);
					$url = $this->createMobileUrl('business',array('op' => 'coupon','operation' => 'detail','gid' => $value['id']));
					$price = $value['productprice'] - $value['marketprice'];
					$list[$key]['thumb'] = $thumb;
					$list[$key]['price'] = $price;
					$list[$key]['url'] = $url;
				}
				$data = array();
				$data['list'] = $list;
				die(json_encode($data));

			}
			include $this->template($this->xqtpl('coupon/list'));
		}elseif ($operation == 'detail') {
			//团购券详情
			$gid = intval($_GPC['gid']);
			if ($gid) {
				$item = pdo_fetch("SELECT * FROM".tablename('xcommunity_goods')."WHERE weid=:weid AND id=:gid",array(':weid' => $_W['uniacid'],':gid' => $gid));
				if ($item) {
						$dp = pdo_fetch("SELECT * FROM".tablename('xcommunity_dp')."WHERE weid=:weid AND id=:dpid",array(':weid' => $_W['weid'],':dpid' => $item['dpid']));
					
						$distance= $this->getDistance($lat, $lng, $dp['lat'], $dp['lng']);
						$juli = floor($distance)/1000;
					$dp['distance'] = $juli;
				}
				$list = pdo_fetchall("SELECT * FROM".tablename('xcommunity_goods')."WHERE weid=:weid AND dpid=:dpid ",array(':weid' => $_W['weid'],':dpid' => $item['dpid']));
			}
			include $this->template($this->xqtpl('coupon/detail'));
		}elseif ($operation == 'confirm') {
			//支付
			$gid = intval($_GPC['gid']);
			if ($gid) {
				$item = pdo_fetch("select * from " . tablename("xcommunity_goods") . " where id=:id limit 1", array(":id" => $gid));
			}
			$dpid = intval($_GPC['dpid']);
			if ($dpid) {
				$dp = pdo_fetch("SELECT uid FROM".tablename('xcommunity_dp')."WHERE weid=:weid AND id=:id",array(':weid' => $_W['uniacid'],':id' => $dpid));
			}
			//查小区编号
			$member = $this->changemember();
			if ($_W['ispost']) {
				$data = array(
					'weid' => $_W['uniacid'],
					'from_user' => $_W['openid'],
					'ordersn' => date('YmdHi').random(10, 1),
					'price' => $_GPC['price'],
					'gid' => $gid,
					'status' => 0,
					'createtime' => TIMESTAMP,
					'type' => 'business',
					'num' => intval($_GPC['num']),
					'goodsprice' => $_GPC['price'],
					'enable' => 1,
					'regionid' => $member['regionid'],
				);
				if ($dp['uid']) {
					$data['uid'] = $dp['uid'];
				}
				// print_r($data);exit();
				$order = pdo_fetch("SELECT id FROM".tablename('xcommunity_order')."WHERE ordersn=:ordersn",array(':ordersn' => $data['ordersn']));
				if ($order) {
					message('订单已存在，无需提交',referer(),'error');
				}
				pdo_insert('xcommunity_order', $data);
				$orderid = pdo_insertid();
				header("location: " . $this->createMobileUrl('business', array('op' => 'pay','orderid' => $orderid)));
			}
			include $this->template($this->xqtpl('coupon/confirm'));
		}elseif ($operation == 'my') {
			$status = !empty($_GPC['status']) ? $_GPC['status'] : 0;
				// print_r($status);exit();
			if ($_W['isajax'] || $_W['ispost']) {
				
				$pindex = max(1, intval($_GPC['page']));
				$psize  = 10;
		        $sql = "SELECT o.*,g.title as title ,g.thumb as thumb,g.marketprice as marketprice,g.productprice as productprice,g.sold as sold,g.instruction as instruction FROM".tablename('xcommunity_order')."as o left join".tablename('xcommunity_goods')."as g on o.gid = g.id WHERE o.weid=:weid AND  o.type = 'business' AND o.from_user = :from_user AND o.status = :status order by id desc LIMIT ".($pindex - 1) * $psize.','.$psize;
		        $params[':weid'] = $_W['uniacid'];
		        $params[':from_user'] = $_W['openid'];
		        $params[':status'] = $status;
				$list = pdo_fetchall($sql,$params);
				foreach ($list as $key => $value) {
					$thumb = tomedia($value['thumb']);
					$url = $this->createMobileUrl('business',array('op' => 'coupon','operation' => 'detail','gid' => $value['gid']));
					$link = $this->createMobileUrl('business',array('op' => 'pay','orderid' => $value['id']));
					$list[$key]['thumb'] = $thumb;
					$list[$key]['url'] = $url;
					$list[$key]['link'] = $link;
				}
				$data = array();
				$data['list'] = $list;
				die(json_encode($data));

			}
			include $this->template($this->xqtpl('coupon/my'));
		}elseif ($operation == 'mycoupon') {
                $enable = !empty($_GPC['enable']) ? $_GPC['enable'] : 0 ;
                if(empty($enable) || $enable == 3){
                    //待付款
                    $dsql = "SELECT o.*,g.title as title ,g.thumb as thumb,g.marketprice as marketprice,g.productprice as productprice,g.sold as sold,g.instruction as instruction FROM".tablename('xcommunity_order')."as o left join".tablename('xcommunity_goods')."as g on o.gid = g.id WHERE o.weid=:weid AND  o.type = 'business' AND o.from_user = :from_user AND o.status = 0 order by id desc ";
                    $pars[':weid'] = $_W['uniacid'];
                    $pars[':from_user'] = $_W['openid'];
                    $list = pdo_fetchall($dsql,$pars);
                    foreach ($list as $key => $value) {
                        $thumb = tomedia($value['thumb']);
                        $url = $this->createMobileUrl('business',array('op' => 'coupon','operation' => 'detail','gid' => $value['gid']));
                        $link = $this->createMobileUrl('business',array('op' => 'pay','orderid' => $value['id']));
                        $list[$key]['thumb'] = $thumb;
                        $list[$key]['url'] = $url;
                        $list[$key]['link'] = $link;
                    }
                }else{
                    $pindex = max(1, intval($_GPC['page']));
                    $psize  = 100;
                    $condition = '';
                    if ($enable) {
                        $condition .=" AND o.enable = :enable";
                        $params[':enable'] = $enable;
                    }
                    $sql = "SELECT o.*,g.title as title ,g.thumb as thumb,g.starttime as starttime,g.endtime as endtime FROM".tablename('xcommunity_order')."as o left join".tablename('xcommunity_goods')."as g on o.gid = g.id WHERE o.weid=:weid AND  o.type = 'business' AND o.from_user = :from_user AND o.status = 1 $condition order by id desc LIMIT ".($pindex - 1) * $psize.','.$psize;
                    $params[':weid'] = $_W['uniacid'];
                    $params[':from_user'] = $_W['openid'];
                    $result = pdo_fetchall($sql,$params);
                }

				include $this->template($this->xqtpl('coupon/mycoupon'));
		}elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			if ($_W['isajax']) {
				if (empty($id)) {
					exit('缺少参数');
				}
				$r = pdo_delete('xcommunity_order',array('id' => $id));
				if ($r) {
					$result = array(
							'status' => 1,
						);
					echo json_encode($result);exit();
				}
			}
		}
	}elseif ($op == 'rank') {
		//商家评价
		$dpid = intval($_GPC['dpid']);

		if ($dpid) {
			$dp = pdo_fetch("SELECT * FROM".tablename('xcommunity_dp')."WHERE weid=:weid AND id=:id",array(':weid' => $_W['uniacid'],':id' => $dpid));

		}
		if ($operation == 'add') {
			$rank = pdo_fetch("SELECT * FROM".tablename('xcommunity_rank')."WHERE weid=:weid AND dpid=:dpid AND openid=:openid",array(':weid' =>$_W['uniacid'],':dpid' => $dpid,':openid' => $_W['openid']));

			if ($_W['ispost']) {
				$data = array(
						'weid' => $_W['uniacid'],
						'type' => 1,
						'dpid' => $dpid,
						'openid' => $_W['openid'],
						'content' => serialize($_GPC['data']), 
						'createtime' => TIMESTAMP

					);
				$r = pdo_insert('xcommunity_rank',$data);
				
				if ($r) {
					$url = $this->createMobileUrl('business',array('op' => 'detail','id' => $dpid));
					echo "<script language='javascript'>";
					echo "  alert('评价成功');";
					echo "  window.location='".$url."';";
					echo "</script>";
				}
			}

			if ($rank) {
				include $this->template($this->xqtpl('business/rank'));exit();
			}else{
				include $this->template($this->xqtpl('business/rank_add'));exit();
			}
			
		}elseif ($operation == 'list') {
			if ($_W['isajax'] || $_W['ispost']) {
		
				$pindex = max(1, intval($_GPC['page']));
				$psize  = 10;
							// echo $dpid;exit();
		        $sql = "SELECT * FROM".tablename('xcommunity_rank')."WHERE weid=:weid AND  type = 1 AND dpid = :dpid order by id desc LIMIT ".($pindex - 1) * $psize.','.$psize;
		        $params[':weid'] = $_W['uniacid'];
		        $params[':dpid'] = $dpid;
				$list = pdo_fetchall($sql,$params);
				foreach ($list as $key => $value) {
					$member = $this->member($value['openid']);
					$c = unserialize($value['content']);
					// print_r($c);
					load()->model('mc');
					$m =  mc_fansinfo($value['openid']);
					// print_r(unserialize($value['content']));exit();
					$createtime = date('Y-m-d H:i',$value['createtime']);
					$list[$key]['avatar'] = $m['tag']['avatar'];
					$list[$key]['realname'] = $member['realname'];
					$list[$key]['createtime'] = $createtime;
					$list[$key]['score'] = $c['score'];
					$list[$key]['contents'] = $c['contents'];
				}
				$data = array();
				$data['list'] = $list;
				die(json_encode($data));

			}
			include $this->template($this->xqtpl('business/rank_list'));
		}
	}elseif ($op == 'pay') {
		//查当前订单信息
		$orderid = intval($_GPC['orderid']);
		$order = pdo_fetch("SELECT * FROM " . tablename('xcommunity_order') . " WHERE id = :id", array(':id' => $orderid));
		if ($order['status'] != '0') {
			message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', referer(), 'error');
		}
        if($this->module['config']['xq_pay']&&$this->module['config']['xq_wechat']){
            //借用微信支付
            $ap = pdo_get('xcommunity_pay_api',array('uid' => $order['uid'],'paytype' => 2,'type'=> 3),array('pay'));
            if($ap){
                $api = $ap;
            }else{
                $api = pdo_get('xcommunity_pay_api',array('userid' => $order['uid'],'paytype' => 2,'type' => 2),array('pay'));
            }
            $setting = unserialize($api['pay']);
            $wechat['appid'] = trim($setting['wechat']['appid']);
            $wechat['appsecret'] = trim($setting['wechat']['appsecret']);
            if($api){
                if(!empty($_GPC['code'])){
                    load()->func('communication');
                    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$wechat['appid']}&secret={$wechat['appsecret']}&code={$_GPC['code']}&grant_type=authorization_code ";
                    $res = ihttp_get($url);
                    $res = @json_decode($res['content'],true);
                    $payopenid = $res['openid'];
                }else{
                    $url = $_W['siteroot'].'app'.str_replace('./', '/', $this->createMobileUrl('business',array('op'=> 'pay','orderid' => $_GPC['orderid'])));
                    $callback = urlencode($url);
                    $url1= "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$wechat['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=1#wechat_redirect ";
                    header('Location: ' . $url1);exit();
                }
            }else{
                message('还没有设置支付接口',$this->createMobileUrl('home'),'error');exit();
            }

        }
		// 商品名称
		$sql = 'SELECT `title` FROM ' . tablename('xcommunity_goods') . " WHERE `id` = :id";
		$goodsTitle = pdo_fetchcolumn($sql, array(':id' => $order['gid']));
		$params['tid'] = $order['ordersn'];
		$params['user'] = $_W['openid'];
		$params['fee'] = $order['goodsprice'];
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
		include $this->template($this->xqtpl('business/pay'));
	}elseif ($op == 'search') {
		if ($_W['ispost']) {
		        $keyword = $_GPC['keyword'];
		        $url = $this->createMobileUrl('business',array('op' => 'list','keyword' => $keyword));
		        header("Location:{$url}");
		        exit();

		}
		include $this->template($this->xqtpl('business/search'));
	}
function sortArrByField(&$array, $field, $desc = false){
    $fieldArr = array();
    foreach ($array as $k => $v) {
        $fieldArr[$k] = $v[$field];
    }
    $sort = $desc == false ? SORT_ASC : SORT_DESC;
    array_multisort($fieldArr, $sort, $array);
}













