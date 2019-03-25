<?php
/**
 * 试模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Ck_yunkjModuleSite extends WeModuleSite {
	
	public function payResult($params) {
		global $_W;
		
		//success_processing函数内用的地址
		$url_arr['staff_paycost'] = $this->createMobileUrl('staff_paycost');
		$url_arr['staff_order'] = $this->createMobileUrl('staff_order');
		$url_arr['admin_payofficial'] = $this->createMobileUrl('admin_payofficial');
		
		//成功处理（价格0元的时候函数内不想处理的内容请自行加判断） start------------
		function success_processing($order_inom,$params,$url_arr){
			global $_W;
			
			//发送模板消息---------------------
			require_once ('weixin.class.php');
			$uniacid = $_W['uniacid'];
			
			//获取公众号配置信息
			$srdb = pdo_get('account_wechats', array('uniacid' => $uniacid));
			$appid = $srdb['key'];
			$appsecret = $srdb['secret'];
			$access_token_odl = $srdb['access_token'];
			
			//获取模版消息设置
			$mb_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));
			//----------------
			
			//现在时间
			$newtimes =  time();
			
			$fee = intval($params['fee']);
			$data = array('paystatus' => $params['result'] == 'success' ? 1 : 0);
			
			
			if($order_inom['type'] == 'fw'){
				//服务订单
				pdo_update('cwgl_service_order', $data, array('id' => $order_inom['did'], 'weid' => $_W['uniacid']));
				//获取购买服务姓名
				$user_uidt = pdo_get('cwgl_service_order', array('id' => $order_inom['did'], 'weid' => $_W['uniacid']));
				$user_name = pdo_get('cwgl_user_list', array('uid' => $user_uidt['uid'], 'weid' => $_W['uniacid']));
				
				//发布模板消息-----------
				if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret)){
	
					$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
					
					$staff_list = pdo_fetchall("SELECT uid FROM ".tablename('cwgl_staff_list')."  WHERE weid = '{$_W['uniacid']}' ORDER BY id DESC");
					if (!empty($staff_list)) {
						foreach ($staff_list as &$rowpy) {
							//获取openid
							$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $rowpy['uid']));
							$first = "您好！有个新服务订单，快去查看吧！";
							
							$ppurt = $url_arr['staff_order'];
							if (preg_match('/(http:\/\/)|(https:\/\/)/i', $ppurt)) {
								$url = $ppurt;
							}else{
								$url = $_W['siteroot']."app/".$ppurt;
							}
							
							$tradeDateTime = date('Y-m-d H:i:s',time());
							$template = array(
								'touser'=> trim($user_openid['openid']),
								'template_id'=> trim($mb_config['mbid4']),    //模板的id
								'url'=> $url,
								'topcolor'=>"#FF0000",
								'data'=>array(
									'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),
									'tradeDateTime'=>array('value'=>urlencode($tradeDateTime),'color'=>"#00008B"),    //提交时间tradeDateTime      
									'orderType'=>array('value'=>urlencode("购买服务"),'color'=>"#00008B"),    //订单类型orderType     
									'customerInfo'=>array('value'=>urlencode($user_name['compname']),'color'=>'#00008B'),        //客户信息customerInfo
									'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
								)
							);
					
							$data = urldecode(json_encode($template));
							$send_result = send_template_message($data,$access_token);
							
						}
					}
					
				}
				//----------
				
			}elseif($order_inom['type'] == 'owe'){
			
				//获取支付者信息
				$user_uidt = pdo_get('cwgl_user_paycost', array('id' => $order_inom['did'], 'weid' => $_W['uniacid']));
				$staff_uidt = pdo_get('cwgl_user_list', array('weid' => $_W['uniacid'],'uid' => $user_uidt['uid']));
				if($staff_uidt['deadline']>$newtimes){
					$xintime = $staff_uidt['deadline'];
				}else{
					$xintime = $newtimes;
				}
						
				//欠费清单
				if($order_inom['youhui'] == 1){
					//一个月	
					$deadline = 2592000 + $xintime;
				}elseif($order_inom['youhui'] == 2){
					//三个月	
					$deadline = 2592000*3 + $xintime;	
				}elseif($order_inom['youhui'] == 3){
					//半年
					$deadline = 2592000*6 + $xintime;	
				}elseif($order_inom['youhui'] == 4){
					//一年
					$deadline = 2592000*12 + $xintime;	
				}
				
				if($order_inom['youhui']>0){
					pdo_update('cwgl_user_list', array('deadline' => $deadline), array('uid' => $user_uidt['uid'], 'weid' => $_W['uniacid']));
				}
				pdo_update('cwgl_user_paycost', array('status' => 1), array('id' => $order_inom['did'], 'weid' => $_W['uniacid']));
				
				//发布模板消息-----------
				if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret)){
	
					$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
					
					//获取openid
					$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $staff_uidt['yguid']));
					
					$first = "您好！您有客户支付了欠费，快去查看吧！";
					$keyword1 = $order_inom['paymoney'];
					
					$ppurt = $url_arr[staff_paycost].'&uid='.$user_uidt['uid'];
					if (preg_match('/(http:\/\/)|(https:\/\/)/i', $ppurt)) {
						$url = $ppurt;
					}else{
						$url = $_W['siteroot']."app/".$ppurt;
					}
					
					$template = array(
						'touser'=> trim($user_openid['openid']),
						'template_id'=> trim($mb_config['mbid2']),    //模板的id
						'url'=> $url,
						'topcolor'=>"#FF0000",
						'data'=>array(
							'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),    
							'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#00008B"),    //付款金额keyword1     
							'keyword2'=>array('value'=>urlencode($order_inom['did']),'color'=>'#00008B'),        //交易单号keyword2
							'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
						)
					);
			
					$data = urldecode(json_encode($template));
					$send_result = send_template_message($data,$access_token);
				}
				//----------
				
			}elseif($order_inom['type'] == 'gm'){
				
				//购买成为正式会员支付
				pdo_update('cwgl_user_payofficial', array('status' => 1), array('id' => $order_inom['did'], 'weid' => $_W['uniacid']));
				$user_uidt = pdo_get('cwgl_user_payofficial', array('id' => $order_inom['did'], 'weid' => $_W['uniacid']));
				$user_name = pdo_get('cwgl_user_list', array('uid' => $user_uidt['uid'], 'weid' => $_W['uniacid']));
				$deadline =  2592000 + $newtimes;
				pdo_update('cwgl_user_list', array('type' => 1,'deadline' => $deadline), array('uid' => $user_uidt['uid'], 'weid' => $_W['uniacid']));
				
				//存入催费数据表-----
				$datapp = array(
					'weid' => $_W['uniacid'],
					'uid' => $user_uidt['uid'],
					'type' => 1,
					'status' => 1,
					'titlename' => "购买正式会员",
					'message' => "支付一个月的会员服务费用",
					'paymoney' => $user_uidt['paymoney'],
					'dateline' => mktime()
				);
				pdo_insert('cwgl_user_paycost', $datapp);
				//-----------------
				
				//发布模板消息-----------
				if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret)){
	
					$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
					
					//获取管理员列表
					$admin_list = pdo_fetchall("SELECT uid FROM ".tablename('cwgl_admin')."  WHERE weid = '{$_W['uniacid']}' ORDER BY id DESC");
					if (!empty($admin_list)) {
						foreach ($admin_list as &$rowpy) {
							//获取openid
							$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $rowpy['uid']));
					
							$first = "管理员您好！有个客户购买成为正式会员并支付了，快去查看并分配会计吧！";
							
							$ppurt = $url_arr['admin_payofficial'];
							if (preg_match('/(http:\/\/)|(https:\/\/)/i', $ppurt)) {
								$url = $ppurt;
							}else{
								$url = $_W['siteroot']."app/".$ppurt;
							}
					
							$tradeDateTime = date('Y-m-d H:i:s',time());
							$template = array(
								'touser'=> trim($user_openid['openid']),
								'template_id'=> trim($mb_config['mbid4']),    //模板的id
								'url'=> $url,
								'topcolor'=>"#FF0000",
								'data'=>array(
									'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),
									'tradeDateTime'=>array('value'=>urlencode($tradeDateTime),'color'=>"#00008B"),    //提交时间tradeDateTime      
									'orderType'=>array('value'=>urlencode("购买正式会员"),'color'=>"#00008B"),    	  //订单类型orderType     
									'customerInfo'=>array('value'=>urlencode($user_name['compname']),'color'=>'#00008B'),  //客户信息customerInfo
									'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
								)
							);
					
							$data = urldecode(json_encode($template));
							$send_result = send_template_message($data,$access_token);
						}
					}
					
				}
				//----------
				
			}
			pdo_update('cwgl_order_inom', array('status' => 1), array('weid' => $_W['uniacid'],'id' => $params['tid']));
			
		}
		//成功处理 end------------
		
		//根据参数params中的result来判断支付是否成功
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
			//此处会处理一些支付成功的业务代码
			$order_inom = pdo_get('cwgl_order_inom', array('weid' => $_W['uniacid'],'id' => $params['tid']));
			//成功处理
			success_processing($order_inom,$params,$url_arr);
		}
		
		if ($params['from'] == 'return') {
		
			$order_inom = pdo_get('cwgl_order_inom', array('weid' => $_W['uniacid'],'id' => $params['tid']));
			if($order_inom['type'] == 'fw'){
			
				//服务订单
				if ($params['result'] == 'success') {
					if($order_inom['paymoney'] == "0.00"){
						success_processing($order_inom,$params,$url_arr);
					}
					message('支付成功！', $this->createMobileUrl('user_order'), 'success');
				} else {
					message('支付失败！', $this->createMobileUrl('user_order'), 'error');
				}
				
			}elseif($order_inom['type'] == 'owe'){
				//欠费清单
				if ($params['result'] == 'success') {
					if($order_inom['paymoney'] == "0.00"){
						success_processing($order_inom,$params,$url_arr);
					}
					message('支付成功！', $this->createMobileUrl('user_paycost'), 'success');
				} else {
					message('支付失败！', $this->createMobileUrl('user_paycost'), 'error');
				}
				
			}elseif($order_inom['type'] == 'gm'){
			
				//购买成为正式会员
				if ($params['result'] == 'success') {
				
					if($order_inom['paymoney'] == "0.00"){
						success_processing($order_inom,$params,$url_arr);
					}
					message('支付成功！', $this->createMobileUrl('user_index'), 'success');
				} else {
					message('支付失败！', $this->createMobileUrl('user_payofficial'), 'error');
				}
				
			}
			
		}
	}

}