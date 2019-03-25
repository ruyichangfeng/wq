<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'daoshow', 'dao', 'setuser', 'send', 'info', 'pai', 'paiok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == "index") {
	$list1 = pdo_fetchall("select id,type_name,mode from ".tablename('xm_gohome_servetype')." where weid = ".$this->weid." and delstate=1 order by id desc");
		
	$id =intval($_GPC['id']);
	if(empty($id)){
		$serve_type = '0';
	}else{
		$serve_type = intval($_GPC['id']);
	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
	if (!empty($_GPC['realname'])) {
		$condition .= " AND fname LIKE :fname";
		$params[':fname'] = "%{$_GPC['realname']}%";
	}
	if (!empty($_GPC['mobile'])) {
		$condition .= " AND fmobile =".$_GPC['mobile'];
	}
	if ($_GPC['mode'] != '') {
		$condition .= " AND mode =".$_GPC['mode'];
	}

	if($serve_type == '0'){
		$sqllist = "SELECT * FROM ".tablename("xm_gohome_order")." WHERE `weid` = ".$this->weid." $condition ORDER BY addtime DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
		$list2 = pdo_fetchall($sqllist, $params);
		$sql='SELECT COUNT(*) FROM ' . tablename("xm_gohome_order") . " WHERE weid = ".$this->weid." $condition ";
	}else{
		$sqllist = "SELECT * FROM ".tablename("xm_gohome_order")." WHERE `weid` = ".$this->weid." and serve_type=".$serve_type." $condition ORDER BY addtime DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
		$list2 = pdo_fetchall($sqllist, $params);
		$sql='SELECT COUNT(*) FROM ' . tablename("xm_gohome_order") . " WHERE weid = ".$this->weid." and serve_type = ".$serve_type." $condition ";
	}		
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
	
	include $this->template('web/order/order-list');	
}

if($foo == "daoshow"){
	$serve_type = $_GPC['serve_type'];

	include $this->template('web/order/order-dao');	
}

//导出数据
if($foo == "dao"){
	//$serve_type = $_GPC['serve_type'];
	$serve_type = 1;

	$condition = '';
	$params = array();
	if (!empty($_GPC['realname'])) {
		$condition .= " AND fname LIKE :fname";
		$params[':fname'] = "%{$_GPC['realname']}%";
	}
	if (!empty($_GPC['mobile'])) {
		$condition .= " AND fmobile =".$_GPC['mobile'];
	}
	
	$data = pdo_fetchall("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and serve_type=".$serve_type." order by addtime desc");
		
	require_once MB_ROOT.'/phpExcel/PHPExcel/Writer/IWriter.php';
		//include_once MB_ROOT.'/phpExcel/PHPExcel/Writer/Excel2007.php';
	include_once MB_ROOT.'/phpExcel/PHPExcel.php';
	include_once MB_ROOT.'/phpExcel/PHPExcel/IOFactory.php';
    $obj_phpexcel = new PHPExcel();
	$obj_phpexcel->getActiveSheet()->setCellValue('a1','订单类型');
	$obj_phpexcel->getActiveSheet()->setCellValue('b1','用户昵称');
	$obj_phpexcel->getActiveSheet()->setCellValue('c1','用户姓名');
	$obj_phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	$obj_phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
	$obj_phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);  
    if($data){
    	for($i=0;$i<count($data);$i++){	
            $obj_phpexcel->getActiveSheet()->setCellValue('a'.($i+2),'aaa');
			$obj_phpexcel->getActiveSheet()->setCellValue('b'.($i+2),'bbbb');
			$obj_phpexcel->getActiveSheet()->setCellValue('c'.($i+2),'ccc');
				//$obj_phpexcel->getActiveSheet()->setCellValue('b'.$i,$value);
				//$obj_phpexcel->getActiveSheet()->setCellValue('c'.$i,$value);
                //$i++;
        }
    }  
    $obj_Writer = PHPExcel_IOFactory::createWriter($obj_phpexcel,'Excel5');
    $filename = "订单统计.xls";

    header("Content-Type: application/force-download"); 
    header("Content-Type: application/octet-stream"); 
    header("Content-Type: application/download"); 
    header('Content-Disposition:inline;filename="'.$filename.'"'); 
    header("Content-Transfer-Encoding: binary"); 
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Pragma: no-cache"); 
    $obj_Writer->save('php://output'); 
}

if($foo == "setuser"){
	$openid = $_GPC['openid'];
	if(empty($openid)){
		message("未获取到下订单的用户openid");
		exit();
	}
	$value = $_GPC['value'];
		
	if($value == 1){
		$item = pdo_fetch("select id from ".tablename('xm_gohome_blacklist')." where openid='".$openid."'");
		if(empty($item)){
			$data['openid'] = $openid;
			$data['state'] = 1;
			$res = pdo_insert('xm_gohome_blacklist',$data);
			if($res){
				message('已加入黑名单！',$this->createWebUrl('order',array('foo'=>'index')), 'success');
			}else{
				message('加入黑名单失败');
			}
		}else{
			$data['state'] = 1;
			$res = pdo_update('xm_gohome_blacklist',$data, array('id'=>$item['id']));
			if($res){
				message('已加入黑名单！',$this->createWebUrl('order',array('foo'=>'index')), 'success');
			}else{
				message('加入黑名单失败');
			}
		}
	}else{
		$item = pdo_fetch("select id from ".tablename('xm_gohome_blacklist')." where openid='".$openid."'");
		$res = pdo_delete('xm_gohome_blacklist', array('id'=>$item['id']));
		if($res){
			message('解除黑名单成功！',$this->createWebUrl('order',array('foo'=>'index')), 'success');
		}else{
			message('解除黑名单失败');
		}
	}
}

if($foo == "send"){
	$serve_type = $_GPC['serve_type'];
	$order_id = $_GPC['order_id'];
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$condition = '';
	$params = array();
			
	if (!empty($_GPC['key_word'])) {
		$condition .= " AND staff_name LIKE :staff_name";
		$params[':staff_name'] = "%{$_GPC['key_word']}%";
	}
		
	if (!empty($_GPC['staff_mobile'])) {
		$condition .= " AND staff_mobile LIKE :staff_mobile";
		$params[':staff_mobile'] = "%{$_GPC['staff_mobile']}%";
	}
			
	$sqllist = "SELECT id,openid,staff_name,sex,staff_mobile FROM ".tablename('xm_gohome_staff')." WHERE `weid` = ".$this->weid." and find_in_set(".$serve_type.",serve_type) and delstate=1 and flag=1 $condition ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM " . tablename('xm_gohome_staff') . " WHERE weid = ".$this->weid." and find_in_set(".$serve_type.",serve_type) and delstate=1 and flag=1 $condition ";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
		
	include $this->template('web/order/order-send');	
}

if($foo == "info"){
	$serve_type = $_GPC['serve_type'];
	$order_id = $_GPC['order_id'];
		
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);

	$item_g = pdo_fetch("select suremoney from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and selected=1 and order_id=".$item['id']);
		
	$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
			
	$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
	if(!empty($random_item['random'])){
		$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
	}

	include $this->template('web/order/order-info');
}

if($foo == "pai"){		
	$serve_type = $_GPC['serve_type'];
	$order_id = $_GPC['order_id'];
		
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
		
	$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
			
	$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
	if(!empty($random_item['random'])){
		$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
	}

	include $this->template('web/order/pai-info');
}

if($foo == "paiok"){
	$id = $_GPC['id'];
	$order_id = $_GPC['order_id'];
	$suremoney = $_GPC['suremoney'];
	$check = pdo_fetch("select id from ".tablename('xm_gohome_order')." WHERE id=".$order_id." and state=1");
	/*if(!empty($check)){
		echo 2;
	}else{*/
		$data_o['state'] = 1;
		$data_o['staff_id'] = $id;
		$res = pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));
		if($res){
			$item=pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
			$data_i['weid'] = $this->weid;
			$data_i['openid'] = $this->getStaffInfo($id, 'openid');
			$data_i['staff_id'] = $id;
			$data_i['serve_type'] = $item['serve_type'];
			$data_i['order_id'] = $order_id;
			$data_i['offer'] = $suremoney;
			$data_i['suremoney'] = $suremoney;
			$data_i['selected'] = 1;
			$data_i['addtime'] = date('Y-m-d H:i:s',time());
			$data_i['selectedtime'] = date('Y-m-d H:i:s',time());
			pdo_insert('xm_gohome_grab', $data_i);
			
			//发送模板消息
			$table_name = $item['table_name'];
			$other_id = $item['other_id'];
			$orderItem = pdo_fetch("select * from ".tablename($table_name)." where id=".$other_id);
			//给指定人员发模板消息
			load()->classs('weixin.account');
			$accObj= WeixinAccount::create($acid);
			$access_token = $accObj->fetch_token();
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
				
			$data = array(
					'touser' => $this->getStaffInfo($id, 'openid'),
					'template_id' => $this->getBase('pai_temp'),
					'url' => '',
					'topcolor' => '#FF0000',
					'data' => array(
						'first'	=> array(
							'value' => '您收到一条新的订单指派',
							'color' => '#173177',
						),
						'tradeDateTime' => array(
							'value' => $orderItem['addtime'],
							'color' => '#173177',
						),
						'orderType' => array(
							'value' =>  $this->getServeType($orderItem['serve_type']),
				            'color' => '#173177',
						),
						'customerInfo' => array(
							'value' =>  '联系人：'.$orderItem['fname'].',联系电话'.$orderItem['fmobile'],
							'color' => '#173177',
						),
						'orderItemName' => array(
							'value' =>  '服务地点',
							'color' => '#173177',
						),
						'orderItemData' => array(
							'value' =>  $orderItem['fadr'],
							'color' => '#173177',
						),
						'remark' => array(
							'value' => '请你与'.$orderItem['ftime'].'按时到达服务地点，此订单价格为'.$suremoney.'元,并提前与客户取得联系,做好服务工作',
							'color' => '#173177',
						),
					),
				);
				ihttp_post($url, json_encode($data));
				
			$item_s = pdo_fetch("select send_sms from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$item['serve_type']);
			if($item_s['send_sms'] == 1){
				$msgbase = $this->getMessageBase();     
					$c = urlencode($msgbase['qianming']."有一条新的订单派送，服务项目：".$this->getServeType($orderItem['serve_type']).",用户信息：联系人".$orderItem['fname'].'联系电话'.$orderItem['fmobile'].",服务地点：".$orderItem['fadr'].",服务时间：".$orderItem['ftime'].",请按时到达地点服务，上门前请与客户联系");
						
					$data_modesms['app'] = 'gohome';
					$data_modesms['key'] = $this->getBase('key_info');
					$data_modesms['u'] = $msgbase['plat_name'];
					$data_modesms['p'] = $msgbase['plat_pwd'];
					$data_modesms['m'] = $this->getStaffInfo($id, 'staff_mobile');
					$data_modesms['c'] = $c;
					$this->post($posturl, $data_modesms, 5);
			} 
			echo 1;	
		}else{
			echo 0;
		}	
	//}
}

?>