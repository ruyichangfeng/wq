<?php
global $_W,$_GPC;

checkauth();

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$foo = $_GPC['foo'];
$foos = array('grab', 'grabok', 'grabokinfo');
$foo = in_array($foo, $foos) ? $foo : 'grab';

if($foo == 'grab'){
	$staff_id = intval($_GPC['staff_id']);
	
	$yitem = pdo_fetch("select openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id =".$staff_id);
	if($yitem['company_flag'] == 0){
		$ymoney = $yitem['money'];
	}else{
		$s_yitem = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$yitem['openid']."' and company_mge=1 and delstate=1");
		$ymoney = $s_yitem['money'];
	}
		
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid = ".$this->weid." and id=".$id);
	$serve_type = $item['serve_type'];
		
	$sitem = pdo_fetch("select offer_state,basemoney from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$serve_type);
	$offer_state = $sitem['offer_state'];
	if(empty($sitem['basemoney']))
		$basemoney = 0;
	else
		$basemoney = $sitem['basemoney'];
			
	if($ymoney < $basemoney && $basemoney != 0){
			
		include $this->template('staff/grab/s_nomoney');
	}else{
			
		$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
			
		$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
		if(!empty($random_item['random'])){
			$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
		}
			
		$diygrab = $this->getBase('diygrab');
			
		$random = $this->generate_code(6);
			
		include $this->template('staff/grab/s_grab');
	}
}

if($foo == 'grabok'){
	session_start();
		
	$openid   = $_W['fans']['from_user'];
	$staff_id = $_GPC['staff_id'];
	$order_id = $_GPC['order_id'];
	$serve_type = $_GPC['serve_type'];
	$random = $_GPC['suiji'];
	$remark = $_GPC['remark'];
	
	$map['weid'] 	 = $_W['uniacid'];
	$map['order_id'] = $order_id;
	$map['staff_id'] = $staff_id;
	$item = pdo_get('xm_gohome_grab', $map, array('id'));

	if(!empty($item['id'])){
		echo 2;
	}else{
		$map_o['weid'] = $_W['uniacid'];
		$map_o['id']   = $order_id;
		$fields = array('openid', 'table_name', 'other_id', 'state');
		$item_o = pdo_get('xm_gohome_order', $map_o, $fields);
		
		if($item_o['state'] == 1){
			echo 3;
		}else{
			$data['weid'] 		= $_W['uniacid'];
			$data['openid'] 	= $openid;
			$data['staff_id']   = $staff_id;
			$data['serve_type'] = $serve_type;
			$data['order_id']   = $order_id;
			if($_GPC['offer'] == ''){
				$offer = $this->getOrderInfo($item_o['table_name'],$item_o['other_id'],'dealprice');
			}else{
				$offer = $_GPC['offer'];	
			}
			$data['offer']  = $offer;
			$data['random'] = $random;
			$data['remark'] = $remark;
			$res = pdo_insert('xm_gohome_grab', $data);
			if($res){
				pdo_query("update ".tablename('xm_gohome_staff')." set grab_order=grab_order+1 where id=".$staff_id);
				$first = $this->getServeInfo($serve_type, 'first');
				if($first == 1){
					$item_g = pdo_fetch("select id from ".tablename('xm_gohome_grab')." where weid=".$_W['uniacid']." and serve_type=".$serve_type." and order_id=".$order_id." order by addtime asc limit 0,1");
					$this->selectok($item_g['id'], $staff_id, $order_id);

					$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&id=".$order_id."&foo=orderinfo&do=order&m=xm_gohome";
				}else{
					$data_o['state'] = 3;
					pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));

					$map_l['weid'] 	   = $_W['uniacid'];
					$map_l['order_id'] = $order_id;
					$map_l['staff_id'] = $staff_id;
					$item_l = pdo_get('xm_gohome_msglog', $map_l, array('id'));
					$data_l['state'] = 1;
					pdo_update('xm_gohome_msglog', $data_l, array('id' => $item_l['id']));

					$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Selected&id=".$order_id."&m=xm_gohome";	
				}
				
				$this->send_tmpmsg('qtmpmsg_id',$serve_type,$item_o['openid'],$jump,$item_o['table_name'],$item_o['other_id'],$offer,$staff_id);

				$msgbase = $this->getMessageBase();
				if($msgbase['message2'] == 1){
					$smstype = $msgbase['platform'];
					$q       = $msgbase['qianming'];
					$q       = str_replace("【", '', $q);
					$q       = str_replace("】", '', $q);
					$tempid  = $msgbase['msg2_tempid'];
					$mobile = $this->getMemberInfo($item_o['openid'], 'mobile');
					
					if($smstype == 1){
						$c = $this->getBao($serve_type, $item_o['table_name'], $item_o['other_id'], $staff_id, $offer, $msgbase['message2_content']);
					}else{
						$c = $this->getAlidayu($tempid, $mobile, $serve_type, $item_o['table_name'], $item_o['other_id'], $staff_id, $offer);
					}
					
					$data_modesms['app'] = 'gohome';
					$data_modesms['key'] = $this->getBase('key_info');
					$data_modesms['u'] = $msgbase['plat_name'];
					$data_modesms['p'] = $msgbase['plat_pwd'];
					$data_modesms['smstype'] = $smstype;
					$data_modesms['q'] = $q;
					$data_modesms['m'] = $mobile;
					$data_modesms['c'] = $c;
					
					$res = $this->post(SEND_SMS, $data_modesms, 5);
				}
				echo 1;
			}else{
				echo 0;
			}
		}
	}
}

if($foo == 'grabokinfo'){
	
	include $this->template('staff/grab/s_grabok');
}

?>