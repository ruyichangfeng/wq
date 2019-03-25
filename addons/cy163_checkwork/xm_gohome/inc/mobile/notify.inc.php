<?php
global $_W,$_GPC;

$attach = urldecode($_GPC['attach']);
$str    = explode('#', $attach);

$weid   = $str[1];
$url    = $str[2];
$openid = $str[3];
$money  = $str[4];
$body   = $str[5];
$orderid= $str[6];

$item = pdo_fetch("select id from ".tablename('xm_gohome_wxpaylog')." where weid=".$_W['uniacid']." and transaction_id='".$orderid."'");
if(empty($item)){
	$data_log['weid'] = $_W['uniacid'];
	$data_log['transaction_id'] = $orderid;
	$data_log['attach'] = $attach;
	pdo_insert('xm_gohome_wxpaylog', $data_log);
	
	if($str[0] == 'A'){
		$uid    = $str[7];

		load()->model('mc');
		mc_credit_update($uid, 'credit2', $money);
					
		$data_1['weid']   = $_W['uniacid'];
		$data_1['openid'] = $openid;
		$data_1['type']   = 1;
		$data_1['money']  = $money;
		pdo_insert('xm_gohome_userrechargelog', $data_1);

		include $this->template($this->temp.'_rechargeok');
	}

	if($str[0] == 'B'){
		$uid      = $str[7];
		$order_id = $str[8];
		$bili     = $this->getBase("bili");
		$staff_id = $str[9];
		$endmoney = $str[10];
		$remark   = $str[11];
				
				load()->model('mc');
				//平台分成
				$oitem = pdo_fetch("select openid,serve_type from ".tablename('xm_gohome_order')." where weid=".$weid." and id=".$order_id);
				$openid     = $oitem['openid'];
				$serve_type = $oitem['serve_type'];

				$serve_item = pdo_fetch("select gettype,bili_bai,bili_money,start,end,times from ".tablename('xm_gohome_servetype')." where weid=".$weid." and id=".$serve_type);

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
					//平台流水日志
					$data_get = array(
						'weid'       => $weid,
						'staff_id'   => $staff_id,
						'serve_type' => $serve_type,
						'order_id'   => $order_id,
						'getmoney'   => $smoney,
						'type'       => 2,
						'way'        => 1
					);
					pdo_insert('xm_gohome_companygetmoney', $data_get);

					$item_s = pdo_fetch("select id,openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$weid." and id=".$staff_id);
					if($item_s['company_flag'] == 1){
						$item_c = pdo_fetch("select id,openid from ".tablename('xm_gohome_staff')." where weid=".$weid." and company_mge=1 and openid='".$item_s['openid']."'");
						$new_staff_id = $item_c['id'];
					}else{
						$new_staff_id = $staff_id;
					}
					//pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$weid." and id=".$new_staff_id);

				}else{

					$getMoney1 = $endmoney;
					if($serve_item['times'] == 0){
						$item_s = pdo_fetch("select openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$weid." and id=".$staff_id);
						if($item_s['company_flag']==1){
							$item_c = pdo_fetch("select id,money from ".tablename('xm_gohome_staff')." where weid=".$weid." and openid ='".$item_s['openid']."' and company_mge=1 and delstate=1");
							$data_g['money'] = $item_c['money'] - $serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id' => $item_c['id']));
							$new_staff_id = $item_c['id'];
						}else{
							$data_g['money'] = $item_s['money']-$serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id' => $staff_id));
							$new_staff_id = $staff_id;
						}
						$smoney = $serve_item['bili_money'];

						$data_get = array(
							'weid'       => $weid,
							'staff_id'   => $staff_id,
							'serve_type' => $serve_type,
							'order_id'   => $order_id,
							'getmoney'   => $serve_item['bili_money'],
							'type'       => 2,
							'way'        => 0
						);
						pdo_insert('xm_gohome_companygetmoney', $data_get);

						pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$weid." and id=".$new_staff_id);
					}
				}

				$data_p = array(
					'weid'     => $weid,
					'openid'   => $openid,
					'staff_id' => $staff_id,
					'order_id' => $order_id,
					'money'    => $money,
					'type'     => 2,
					'getmoney' => $getMoney1,
					'remark'   => $remark
				);
				$res = pdo_insert('xm_gohome_paylog', $data_p);
				if($res){
					$data_o['state'] = 2;
					$data_o['overtime'] = date('Y-m-d H:i:s');
					pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));

					$data_s['nowstate'] = 1;
					pdo_update('xm_gohome_staff', $data_s, array('id'=>$new_staff_id));
					
					pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where id=".$new_staff_id." and weid=".$weid);
				
					$credit1 = floor($endmoney/$bili);
					mc_credit_update($uid, 'credit1', $credit1);

					$data_r = array(
						'uid'     	 => $uid,
						'uniacid'    => $weid,
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
				}else{
					message('付款失败!');
				}
	}

	if($str[0] == 'C'){
		$staff_id = $str[7];
				
		$res = pdo_query("update ".tablename('xm_gohome_staff')." set money = money + ".$money." where weid=".$this->weid." and id=".$staff_id);
		if($res){
			$data_log = array(
				'weid'     => $weid,
				'staff_id' => $staff_id,
				'openid'   => $openid,
				'type'     => 2,
				'money'    => $money,
				'remark'   => '微信端余额充值' 
			);
			pdo_insert('xm_gohome_rechargelog', $data_log);
		}
	}
				
	if($str[0] == 'D'){
		$staff_id = $str[7];
		$grade_id = $str[8];
					
		$item = pdo_fetch("select id,grade_money from ".tablename('xm_gohome_staff')." where weid=".$weid." and delstate=1 and id=".$staff_id);
		$n_money = $item['grade_money'] + $money;
		$data['grade_money'] = $n_money;
		$data['grade_id']    = $grade_id;
		$res = pdo_update('xm_gohome_staff', $data, array('id'=>$staff_id));
		if($res){
			$data_log = array(
				'weid'     => $weid,
				'staff_id' => $staff_id,
				'openid'   => $openid,
				'type'     => 3,
				'money'    => $money,
				'remark'   => '微信端保证金充值'
			);
			pdo_insert('xm_gohome_rechargelog', $data_log);
		}
	}

	if($str[0] == 'E'){
		$order_id = $str[7];
		$staff_id = $str[8];
				
		$item = pdo_fetch("select serve_type,other_id from ".tablename('xm_gohome_order')." where weid=".$weid." and id=".$order_id);
		$data['weid']      = $weid;
		$data['openid']    = $openid;
		$data['money']     = $money;
		$data['servetype'] = $item['serve_type'];
		$data['type']      = 'submit';
		$res = pdo_insert('xm_gohome_userfrontlog', $data);
		if($res){
			$url = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=submitpayjump&order_id='.$order_id.'&serve_type='.$item['serve_type'].'&other_id='.$item['other_id'].'&staff_id='.$staff_id.'&m=xm_gohome';
			header("Location:".$url);	
		}
	}

	if($str[0] == 'F'){
		$id       = $str[7];
		$order_id = $str[8];
		$staff_id = $str[9];
				
		$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_order')." where weid=".$weid." and id=".$order_id);
		$data = array(
			'weid'      => $weid,
			'openid'    => $openid,
			'money'     => $money,
			'servetype' => $item['serve_type'],
			'type'      => 'select'
		);
		$res = pdo_insert('xm_gohome_userfrontlog', $data);
		if($res){
			$url = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=selectpayjump&order_id='.$order_id.'&id='.$id.'&staff_id='.$staff_id.'&m=xm_gohome';
			header("Location:".$url);
		}
	}

	if($str[0] == 'G'){
		$order_id = $str[7];
				
		$u_info = array(
			'state'   => 4,
			'paytype' => 1,
			'ptime1'   => time()
		);
		$res = pdo_update('xm_gohome_takeorder', $u_info, array('id'=>$order_id));
		if($res){
			$urls = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=payjump&order_id='.$order_id.'&openid='.$openid.'&money='.$money.'&m=xm_gohome';
			header("Location:".$urls);
		}else{
			message('付款失败');
		}
	}

	if($str[0] == 'H'){
		$order_id = $str[7];
		$merchant_id = $str[8];
				
		$data['state'] = 3;
		$data['paytime'] = date('Y-m-d H:i:s');
		$res = pdo_update('xm_gohome_needorder', $data, array('id'=>$order_id));
		if($res){
			$urls = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=needpayjump&order_id='.$order_id.'&openid='.$openid.'&money='.$money.'&m=xm_gohome';
			header("Location:".$urls);
		}else{
			message('付款失败');
		}
	}
}

?>