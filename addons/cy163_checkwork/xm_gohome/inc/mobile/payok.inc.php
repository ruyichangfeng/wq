<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo  = $_GPC['foo'];
$foos = array('index', 'show', 'getprintinfo', 'commentok');
$foo  = in_array($foo, $foos) ? $foo : 'index';


if($foo == "index"){
	$type       = intval($_GPC['zf_type']);
	$order_id   = intval($_GPC['order_id']);
	$staff_id   = intval($_GPC['staff_id']);
	$serve_type = intval($_GPC['serve_type']);
	$money      = $_GPC['money'];
	$endmoney   = $_GPC['endmoney'];
	$remark     = $_GPC['remark'];
		
	$data['weid']     = $this->weid;
	$data['openid']   = $openid;
	$data['staff_id'] = $staff_id;
	$data['order_id'] = $order_id;
	$data['money']    = $money;
	$data['remark']   = $remark;
		
	$check = pdo_fetch("select id from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and order_id=".$order_id." and openid='".$openid."'");
	if(!empty($check)){
		message('该订单已付款成功了！');
		exit();
	}

	load()->model('mc');
	$serve_item = pdo_fetch("select gettype,bili_bai,bili_money,start,end,times,front from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$serve_type);

	$front = $serve_item['front'];
	if($endmoney < $front){
		$yu_money = $front-$endmoney;
		if($serve_item['gettype'] == 1){
			$getMoney = ($front*$serve_item['bili_bai'])/100;
				
			$smoney =$getMoney;
			if($getMoney<=$serve_item['start']){
				$smoney = $serve_item['start'];
			}
			if($getMoney>=$serve_item['end'] && $serve_item['end']!=0){
				$smoney = $serve_item['end'];
			}
			$getMoney1 = $front-$smoney;

			$data_get = array(
				'weid'      => $this->weid,
				'staff_id'  => $staff_id,
				'serve_type'=> $serve_type,
				'order_id'  => $order_id,
				'getmoney'  => $smoney,
				'type'      => 3,
				'way'       => 1
			);
			pdo_insert('xm_gohome_companygetmoney', $data_get);

			$item_s = pdo_fetch("select id,openid,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id);
			if($item_s['company_flag'] == 1){
				$item_c = pdo_fetch("select id,openid from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=1 and openid='".$item_s['openid']."'");
				$new_staff_id = $item_c['id'];
			}else{
				$new_staff_id = $staff_id;
			}
					
		}else{
			$getMoney1 = $front;
			if($serve_item['times'] == 0){
				$item_s = pdo_fetch("select openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id);
				if($item_s['company_flag'] == 1){
					$item_c = pdo_fetch("select id,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid ='".$item_s['openid']."' and company_mge=1 and delstate=1");
					$data_g['money'] = $item_c['money']-$serve_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id'=>$item_c['id']));
					$new_staff_id = $item_c['id'];
				}else{
					$data_g['money'] = $item_s['money']-$serve_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id'=>$staff_id));
					$new_staff_id = $staff_id;
				}

				$data_get = array(
					'weid'      => $this->weid,
					'staff_id'  => $staff_id,
					'serve_type'=> $serve_type,
					'order_id'  => $order_id,
					'getmoney'  => $serve_item['bili_money'],
					'type'      => 3,
					'way'       => 0
				);
				pdo_insert('xm_gohome_companygetmoney', $data_get);

				pdo_query("update ".tablename('xm_gohome_staff')." set money=money-".$smoney." where id=".$new_staff_id);
			}
		}
		$data['type'] = 4;
		$data['getMoney'] = $getMoney1;
		$res = pdo_insert('xm_gohome_paylog', $data);
		if($res){
			$data_o['state'] = 2;
			$data_o['overtime'] = date('Y-m-d H:i:s');
			pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));
					
			$data_s['nowstate'] = 1;
			pdo_update('xm_gohome_staff', $data_s, array('id'=>$new_staff_id));

			pdo_query("update ".tablename('xm_gohome_staff')." set money=money+".$getMoney1." where id=".$new_staff_id);

			load()->model('mc');
			mc_credit_update($_W['member']['uid'], 'credit2', $yu_money);
					
			$bili    = $this->getBase("bili");
			$credit1 = floor($endmoney/$bili);
			mc_credit_update($_W['member']['uid'], 'credit1', $credit1);
					
			$data_r = array(
				'uid'     	 => $_W['members']['uid'],
				'uniacid'    => $this->weid,
				'credittype' => 'credit1',
				'num'		 => $credit1,
				'operator'   => '1',
				'module'     => 'xm_gohome',
				'clerk_id'   => '0',
				'store_id'   => '0',
				'createtime' => $_W['timestamp'],
				'remark'     => '订单付款得到积分'.$credit1
			);
			pdo_insert('mc_credits_record', $data_r);

			include $this->template($this->temp.'_orderpayok');
		}else{
			message('付款失败!');
		}
	}else{

		if($type == 1){
			$front = $endmoney-$money;
			if($serve_item['gettype'] == 1){//按百分比
				$getMoney = ($money*$serve_item['bili_bai'])/100;
					
				$smoney = $getMoney;
				if($getMoney<=$serve_item['start']){
					$smoney = $serve_item['start'];
				}
				if($getMoney>=$serve_item['end'] && $serve_item['end']!=0){
					$smoney = $serve_item['end'];
				}
				$getMoney1_1 = number_format($money-$smoney, 2);
				if($front>0){
					$getMoney_1 = ($front*$serve_item['bili_bai'])/100;
					
					$smoney_1 = $getMoney_1;
					if($getMoney_1<=$serve_item['start']){
						$smoney_1 = $serve_item['start'];
					}
					if($getMoney_1>=$serve_item['end'] && $serve_item['end']!=0){
						$smoney_1 = $serve_item['end'];
					}
					$getMoney1_2 = number_format($front-$smoney, 2);
				}else{
					$getMoney1   = 0;
					$smoney_1 	 = 0;
					$getMoney1_2 = 0;
				}
				$getMoney1  = $getMoney1_1 + $getMoney1_2;
				$ping_money = $smoney+$smoney_1;

				$data_get = array(
					'weid'       => $this->weid,
					'staff_id'   => $staff_id,
					'serve_type' => $serve_type,
					'order_id'   => $order_id,
					'getmoney'   => $ping_money,
					'type'       => $type,
					'way'		 => 1
				);
				pdo_insert('xm_gohome_companygetmoney', $data_get);

				$item_s = pdo_fetch("select id,openid,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id);
				if($item_s['company_flag'] == 1){
					$item_c = pdo_fetch("select id,openid from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=1 and openid='".$item_s['openid']."'");
					$new_staff_id = $item_c['id'];
				}else{
					$new_staff_id = $staff_id;
				}
				pdo_query("update ".tablename('xm_gohome_staff')." set money=money-".$smoney." where id=".$new_staff_id);
					
			}else{
				$getMoney1 = $front;
				if($serve_item['times'] == 0){
					$s_item = pdo_fetch("select openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$staff_id);
					if($s_item['company_flag']==1){
						$c_item = pdo_fetch("select id,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid ='".$s_item['openid']."' and company_mge=1 and delstate=1");
						$data_g['money'] = $c_item['money']-$serve_item['bili_money'];
						pdo_update('xm_gohome_staff', $data_g, array('id' => $c_item['id']));
						$new_staff_id = $c_item['id'];
					}else{
						$data_g['money'] = $s_item['money']-$serve_item['bili_money'];
						pdo_update('xm_gohome_staff', $data_g, array('id' => $staff_id));
						$new_staff_id = $staff_id;
					}
					$ping_money = $serve_item['bili_money'];
					$smoney = $serve_item['bili_money'];
					
					$data_get = array(
						'weid'      => $this->weid,
						'staff_id'  => $staff_id,
						'serve_type'=> $serve_type,
						'order_id'  => $order_id,
						'getmoney'  => $ping_money,
						'type'      => $type,
						'way'       => 0
					);
					pdo_insert('xm_gohome_companygetmoney', $data_get);
				}
			}

			$data['type'] = $type;
			//$data['getMoney'] = $endmoney;
			$data['getMoney'] = $money;
			$res = pdo_insert('xm_gohome_paylog', $data);
			if($res){
				$data_o = array(
					'state' => 2,
					'overtime' => date("Y-m-d H:i:s")
				);
				pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));
				
				$data_s['nowstate'] = 1;
				pdo_update('xm_gohome_staff', $data_s, array('id'=>$new_staff_id));
				
				//得到金额
				if($front>0){
					pdo_query("update ".tablename('xm_gohome_staff')." set money=money+".$getMoney1." where id=".$new_staff_id);
				}

				$bili = $this->getBase("bili");	
				$credit1 = floor($endmoney/$bili);
				mc_credit_update($_W['member']['uid'], 'credit1', $credit1);
				mc_credit_update($_W['member']['uid'], 'credit3', $credit1);
				
				$data_r = array(
					'uid'     	 => $_W['members']['uid'],
					'uniacid'    => $this->weid,
					'credittype' => 'credit1',
					'num'		 => $credit1,
					'operator'   => '1',
					'module'     => 'xm_gohome',
					'clerk_id'   => '0',
					'store_id'   => '0',
					'createtime' => $_W['timestamp'],
					'remark'     => '订单付款得到积分'.$credit1
				);
				pdo_insert('mc_credits_record', $data_r);

				//$url_index = $this->createMobileUrl('Index',array('foo'=>'index'));
				//$url_order = $this->createMobileUrl('order',array('foo'=>'orderinfo', 'id'=>$order_id));
				include $this->template($this->temp.'_orderpayok');
			}else{
				message('付款失败!');
			}
		}
		
		if($type == 2){
			if($money == 0){
				if($serve_item['gettype'] == 1){//按百分比支付
					$getMoney = ($endmoney*$serve_item['bili_bai'])/100;
					$smoney =$getMoney;
					if($getMoney<=$serve_item['start']){
						$smoney = $serve_item['start'];
					}
					if($getMoney>=$serve_item['end'] && $serve_item['end']!=0){
						$smoney = $serve_item['end'];
					}
					$getMoney1 = $endmoney-$smoney;
					
					$data_get = array(
						'weid'       => $this->weid,
						'staff_id'   => $staff_id,
						'serve_type' => $serve_type,
						'order_id'   => $order_id,
						'getmoney'   => $smoney,
						'type'       => 2,
						'way'        => 2
					);
					pdo_insert('xm_gohome_companygetmoney', $data_get);

					$item_s = pdo_fetch("select id,openid,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id);
					if($item_s['company_flag'] == 1){
						$item_c = pdo_fetch("select id,openid from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=1 and openid='".$item_s['openid']."'");
						$new_staff_id = $item_c['id'];
					}else{
						$new_staff_id = $staff_id;
					}
					
				}else{
					$getMoney1 = $endmoney;
					if($serve_item['times'] == 0){
						$s_item = pdo_fetch("select openid,company_flag,money from ".tablename('xm_gohome_staff')." where id=".$staff_id);
						if($s_item['company_flag']==1){
							$c_item = pdo_fetch("select id,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid ='".$s_item['openid']."' and company_mge=1 and delstate=1");
							$data_g['money'] = $c_item['money']-$serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id'=>$c_item['id']));
							$new_staff_id = $c_item['id'];
						}else{
							$data_g['money'] = $s_item['money']-$serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id'=>$staff_id));
							$new_staff_id = $staff_id;
						}
						$ping_money = $serve_item['bili_money'];
						$smoney = $serve_item['bili_money'];

						$data_get = array(
							'weid'      => $this->weid,
							'staff_id'  => $staff_id,
							'serve_type'=> $serve_type,
							'order_id'  => $order_id,
							'getmoney'  => $ping_money,
							'type'      => 2,
							'way'       => 0
						);
						pdo_insert('xm_gohome_companygetmoney', $data_get);

						pdo_query("update ".tablename('xm_gohome_staff')." set money=money-".$smoney." where id=".$new_staff_id);
					}
				}
				
				$data['type'] = 2;
				$data['getMoney'] = $getMoney1;
				$res = pdo_insert('xm_gohome_paylog', $data);
				if($res){
					$data_o['state'] = 2;
					$data_o['overtime'] = date('Y-m-d H:i:s');
					pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));

					$data_s['nowstate'] = 1;
					pdo_update('xm_gohome_staff', $data_s, array('id'=>$new_staff_id));
					
					//得到金额	
					pdo_query("update ".tablename('xm_gohome_staff')." set money=money+".$getMoney1." where delstate=1 and id=".$new_staff_id);
					
					$bili = $this->getBase("bili");	
					$credit1 = floor($endmoney/$bili);
					mc_credit_update($_W['member']['uid'], 'credit1', $credit1);
					mc_credit_update($_W['member']['uid'], 'credit3', $credit1);
					
					$data_r = array(
						'uid'     	 => $_W['members']['uid'],
						'uniacid'    => $this->weid,
						'credittype' => 'credit1',
						'num'		 => $credit1,
						'operator'   => '1',
						'module'     => 'xm_gohome',
						'clerk_id'   => '0',
						'store_id'   => '0',
						'createtime' => $_W['timestamp'],
						'remark'     => '订单付款得到积分'.$credit1
					);
					pdo_insert('mc_credits_record', $data_r);	
					//$url_index = $this->createMobileUrl('Index',array());
					//$url_order = $this->createMobileUrl('Orderinfo',array('id'=>$order_id));
						
					include $this->template($this->temp.'_orderpayok');
				}else{
					message('付款失败!');
				}
			}else{
				$fee = floatval($money);
				if($fee <= 0) {
					message('支付错误, 金额小于0');
				}

				$pay = $this->getBase('pay');
				if($pay){
					$body = '订单付款';
					$attach = urlencode("B#".$_W['uniacid']."#".$_W['siteroot']."#".$openid."#".$fee."#".$body."#".$this->generate_code(8)."#".$_W['member']['uid']."#".$order_id."#".$staff_id."#".$endmoney."#".$remark);
					$jump   = urlencode($_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&do=payok&foo=show&order_id='.$order_id.'&staff_id='.$staff_id.'&m=xm_gohome');
					$url    = MODULE_URL.'pay/jsapi.php?attach='.$attach.'&jump='.$jump.'&appid='.$this->getBase("appid").'&mch_id='.$this->getBase("mch_id").'&apikey='.$this->getBase("apikey").'&appsecret='.$this->getBase("appsecret");
					header("Location:".$url);
				}else{
					$params = array(
						'tid' => 'B#'.$_W['member']['uid'].'#'.$fee.'#'.$order_id.'#'.$staff_id.'#'.$endmoney.'#'.$remark.'#'.$this->generate_code(4),
						'ordersn' => $this->generate_code(8),
						'title' => '订单付款',
						'fee' => $fee,
						'user' => $_W['member']['uid'],
					);
					$this->pay($params);	
				}
			}
		}
			
		if($type == 3){
			$item = mc_credit_fetch($_W['member']['uid'],array('credit2'));
			if($item['credit2'] < $money){
				message('您的余额不足！');
			}else{
				if($serve_item['gettype'] == 1){
					$getMoney = ($endmoney*$serve_item['bili_bai'])/100;
					
					$smoney =$getMoney;
					if($getMoney<=$serve_item['start']){
						$smoney = $serve_item['start'];
					}
					if($getMoney>=$serve_item['end'] && $serve_item['end']!=0){
						$smoney = $serve_item['end'];
					}
					$getMoney1 = $endmoney-$smoney;

					$data_get = array(
						'weid'      => $this->weid,
						'staff_id'  => $staff_id,
						'serve_type'=> $serve_type,
						'order_id'  => $order_id,
						'getmoney'  => $smoney,
						'type'      => 3,
						'way'       => 1
					);
					pdo_insert('xm_gohome_companygetmoney', $data_get);

					$item_s = pdo_fetch("select id,openid,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id);
					if($item_s['company_flag'] == 1){
						$item_c = pdo_fetch("select id,openid from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=1 and openid='".$item_s['openid']."'");
						$new_staff_id = $item_c['id'];
					}else{
						$new_staff_id = $staff_id;
					}
						
				}else{
					$getMoney1 = $money;
					if($serve_item['times'] == 0){
						$item_s = pdo_fetch("select openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id);
						if($item_s['company_flag'] == 1){
							$item_c = pdo_fetch("select id,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid ='".$item_s['openid']."' and company_mge=1 and delstate=1");
							$data_g['money'] = $item_c['money']-$serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id'=>$item_c['id']));
							$new_staff_id = $item_c['id'];
						}else{
							$data_g['money'] = $item_s['money']-$serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id'=>$staff_id));
							$new_staff_id = $staff_id;
						}
						$smoney = $serve_item['bili_money'];

						$data_get = array(
							'weid'      => $this->weid,
							'staff_id'  => $staff_id,
							'serve_type'=> $serve_type,
							'order_id'  => $order_id,
							'getmoney'  => $serve_item['bili_money'],
							'type'      => 3,
							'way'       => 0
						);
						pdo_insert('xm_gohome_companygetmoney', $data_get);

						pdo_query("update ".tablename('xm_gohome_staff')." set money=money-".$smoney." where id=".$new_staff_id);
					}
				}
				$data['type'] = 3;
				$data['getMoney'] = $getMoney1;
				$res = pdo_insert('xm_gohome_paylog', $data);
				if($res){
					$data_o['state'] = 2;
					$data_o['overtime'] = date('Y-m-d H:i:s');
					pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));
						
					$data_s['nowstate'] = 1;
					pdo_update('xm_gohome_staff', $data_s, array('id'=>$new_staff_id));

					pdo_query("update ".tablename('xm_gohome_staff')." set money=money+".$getMoney1." where id=".$new_staff_id);
						
					$bili    = $this->getBase("bili");
					$credit1 = floor($endmoney/$bili);
					$credit2 = number_format($item['credit2'] - $endmoney,2);
						
					mc_credit_update($_W['member']['uid'], 'credit1', $credit1);
					$data_f['credit2'] = $credit2;
					pdo_update('mc_members', $data_f, array('uid' => $_W['member']['uid']));
						
					$data_r = array(
						'uid'     	 => $_W['members']['uid'],
						'uniacid'    => $this->weid,
						'credittype' => 'credit1',
						'num'		 => $credit1,
						'operator'   => '1',
						'module'     => 'xm_gohome',
						'clerk_id'   => '0',
						'store_id'   => '0',
						'createtime' => $_W['timestamp'],
						'remark'     => '订单付款得到积分'.$credit1
					);
					pdo_insert('mc_credits_record', $data_r);

					include $this->template($this->temp.'_orderpayok');
				}else{
					message('付款失败!');
				}
			}
		}
	}
}

if($foo == "show"){
	$order_id = intval($_GPC['order_id']);
	$staff_id = intval($_GPC['staff_id']);

	include $this->template($this->temp.'_orderpayok');
}

if($foo == "getprintinfo"){
	$order_id = intval($_GPC['order_id']);
	$staff_id = intval($_GPC['staff_id']);

	$item_p = pdo_fetch("select * from ".tablename('xm_gohome_print')." where weid=".$this->weid." and staff_id=".$staff_id);
	if(empty($item_p['id'])){
		return 0;
	}else{
		$piao = $this->getReplace($order_id,$item_p['xiaopiao']);
		$data = array(
			'posturl' 	 => POSTURL.'PrinterAPI.php',
			'app' 		 => 'gohome',
			'printer_sn' => $item_p['printer_sn'],
			'key_print'  => $item_p['key_info'],
			'key_info'   => $this->getBase('key_info'),
			'pages' 	 => $item_p['number'],
			'xiaopiao'   => $piao
		);
		echo json_encode($data);
	}
}

if($foo == "commentok"){
	$xing     = intval($_GPC['xing']);
	$staff_id = intval($_GPC['cstaff_id']);
	if(empty($xing)){
		$xing = 4;
	}
	$data['weid']     = $this->weid;
	$data['openid']   = $openid;
	$data['staff_id'] = $staff_id;
	$data['order_id'] = intval($_GPC['corder_id']);
	$data['xing']     = $xing;
	$data['comment']  = $_GPC['comment'];
	$data['type']     = 'servetype';
		
	$item = pdo_fetch("select id from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and order_id =".$_GPC['corder_id']." and openid='".$openid."' and type='servetype'");
	if(empty($item['id'])){
		$res = pdo_insert('xm_gohome_comment',$data);
		if($res){
			if($xing == 1){
				pdo_query("update ".tablename('xm_gohome_staff')." set xing=xing+".$xing.",cperson=cperson+1,bad=bad+1 where id=".$staff_id." and delstate=1");
			}elseif($xing == 5){
				pdo_query("update ".tablename('xm_gohome_staff')." set xing=xing+".$xing.",cperson=cperson+1,good=good+1 where id=".$staff_id." and delstate=1");
			}else{
				pdo_query("update ".tablename('xm_gohome_staff')." set xing=xing+".$xing.",cperson=cperson+1,center=center+1 where id=".$staff_id." and delstate=1");
			}
			header("Location:".$this->createMobileUrl('Index', array()));
			//message('点评成功！页面跳转中...', $this->createMobileUrl('Index', array()), 'success');
		}else{
			message('点评失败!请稍后再试！');
		}
	}else{
		message('你已点评！页面跳转中...', $this->createMobileUrl('Index', array()), 'success');
	}
}

?>