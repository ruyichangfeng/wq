<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('index', 'getorder', 'delorder', 'delorder1', 'order2', 'getorder2', 'orderinfo', 'oneorder', 'deleteinfo');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$page ='order';

	include $this->template($this->temp.'_order');
}

if($foo == 'getorder'){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and openid = '".$openid."' and state != 2 and flag=1 order by addtime desc limit ".$startCount.",".$pageSize."");
		
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$s_url = $this->createMobileUrl('selected', array('foo'=>'index', 'id'=>$value['id']));
			$i_url = $this->createMobileUrl('order', array('foo'=>'orderinfo', 'id'=>$value['id']));
			$d_url = $this->createMobileUrl('order', array('foo'=>'deleteinfo', 'id'=>$value['id']));
			if($this->getTypeIcon($value['serve_type']) == ''){
				$icon = $_W['siteroot'].'addons/xm_gohome/static/takeout/images/nopic.jpg';
			}else{
				$icon = $_W['attachurl'].$this->getTypeIcon($value['serve_type']);
			}
			$title = $this->getUserInfo($value['openid'], 'title');
			if(empty($title)){
				$title = 1;
			}
			$type_name = $this->getServeType($value['serve_type']);
			$ftime 	   = $this->getOrderInfo($value['table_name'], $value['other_id'], 'ftime');
			$fadr 	   = $this->getOrderInfo($value['table_name'], $value['other_id'], 'fadr');
			$state_text= $this->getOrderState($value['state'], $value['mode']);
			$dealprice = $this->getOrderInfo($value['table_name'], $value['other_id'], 'dealprice');
			$offer     = $this->getGrabInfo($value['id'], 'offer');
			$state 	   = $value['state'];
			$mode 	   = $value['mode'];
			$idStr .= '{"id":"'.$id.'","s_url":"'.$s_url.'","i_url":"'.$i_url.'","d_url":"'.$d_url.'","icon":"'.$icon.'","title":"'.$title.'","type_name":"'.$type_name.'","ftime":"'.$ftime.'","fadr":"'.$fadr.'","state_text":"'.$state_text.'","dealprice":"'.$dealprice.'","offer":"'.$offer.'","state":"'.$state.'","mode":"'.$mode.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'delorder'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		echo 0;
	}

	$item = pdo_fetch("select serve_type,table_name,other_id from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$id);

	$data1['state'] = 4;
	pdo_update("xm_gohome_order", $data1, array('id'=>$id));
	$data2['state'] = 3;
	pdo_update("xm_gohome_msglog", $data2, array('order_id'=>$id));
	$data3['flag'] = 0;
	$res = pdo_update("".$item['table_name']."", $data3, array('id'=>$item['other_id']));
	if($res){
		$front = $this->getServeInfo($item['serve_type'], 'front');
		if($front>0){
			load()->model('mc');
			mc_credit_update($_W['member']['uid'], 'credit1', $front);
		}
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == "delorder1"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		echo 0;
	}

	$data['flag'] = 0;
	$res = pdo_update('xm_gohome_order', $data, array('id'=>$id));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == "order2"){
	$page ='order';
		
	include $this->template($this->temp.'_order2');
}

if($foo == "getorder2"){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and openid = '".$openid."' and state=2 and flag=1 order by addtime desc limit ".$startCount.",".$pageSize."");
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id    = $value['id'];
			$s_url = $this->createMobileUrl('confirmOk',array('id'=>$value['id']));
			$i_url = $this->createMobileUrl('order',array('foo'=>'orderinfo', 'id'=>$value['id']));
			if($this->getTypeIcon($value['serve_type']) == ''){
				$icon = $_W['siteroot'].'addons/xm_gohome/static/takeout/images/nopic.jpg';
			}else{
				$icon = $_W['attachurl'].$this->getTypeIcon($value['serve_type']);
			}
			$title = $this->getUserInfo($value['openid'], 'title');
			if(empty($title)){
				$title = 1;
			}
			$type_name = $this->getServeType($value['serve_type']);
			$ftime 	   = $this->getOrderInfo($value['table_name'],$value['other_id'],'ftime');
			$fadr 	   = $this->getOrderInfo($value['table_name'],$value['other_id'],'fadr');
			$state_text= $this->getOrderState($value['state'],$value['mode']);
			$price     = $this->getPayMoney($value['id']) + $value['front'];
			$offer 	   = $this->getGrabInfo($value['id'],'offer');
			$state 	   = $value['state'];
			$idStr .= '{"id":"'.$id.'","s_url":"'.$s_url.'","i_url":"'.$i_url.'","icon":"'.$icon.'","title":"'.$title.'","type_name":"'.$type_name.'","ftime":"'.$ftime.'","fadr":"'.$fadr.'","state_text":"'.$state_text.'","price":"'.$price.'","offer":"'.$offer.'","state":"'.$state.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == "orderinfo"){
	$id   = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取订单ID！");
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$id);
	if(empty($item)){
		message("未查询到数据：订单不存在或已删除");
		exit();
	}
		
	if($item['openid'] != $openid){
		header("Location:".$this->createMobileUrl('Index',array()));	
	}
		
	$item_g = pdo_fetch("select * from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and selected=1 and order_id=".$id);
	$endmoney  = $item_g['suremoney'];
	$front     = $this->getServeInfo($item['serve_type'], 'front');
	if($endmoney<$front){
		$suremoney = 0;
		$yu_money = $front - $endmoney;
		$yu = 1;
	}else{
		$suremoney = $endmoney-$front;
		$yu = 0;
	}
		
	$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
		
	$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
	if(!empty($random_item['random'])){
		$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
	}
		
	if(!empty($item_g['random'])){
		$listimg = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$item_g['random']);
	}
		
	$check = pdo_fetch("select id from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and order_id =".$id." and openid='".$openid."'");
		
	$cash    = $this->getBase('cash'); 
	$diywait = $this->getBase('diywait');
	$diypay  = $this->getBase('diypay');
		
	include $this->template($this->temp.'_orderinfo');
}

if($foo == "oneorder"){
	$id   = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取订单ID！");
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$id);
	if(empty($item)){
		message("未查询到数据：订单不存在或已删除");
		exit();
	}
		
	if($item['openid'] != $openid){
		header("Location:".$this->createMobileUrl('Index',array()));	
	}
		
	$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
		
	$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
	if(!empty($random_item['random'])){
		$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
	}
		
	include $this->template($this->temp.'_oneorder');
}

if($foo == "deleteinfo"){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$id);
		
	if($item['openid'] != $openid){
		header("Location:".$this->createMobileUrl('Index',array()));	
	}
		
	$list = pdo_fetchall("select input_laber,input_type,input_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id =".$item['temp_id']);
			
	$random_item = pdo_fetch("select random from ".tablename(''.$item['table_name'].'')." where id=".$item['other_id']);
	if(!empty($random_item['random'])){
		$listpic = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random_item['random']);
	}
		
	include $this->template($this->temp.'_deleteinfo');
}


?>