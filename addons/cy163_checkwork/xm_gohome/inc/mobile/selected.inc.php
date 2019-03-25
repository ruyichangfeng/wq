<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('index', 'getselected', 'selectedsure', 'selectok', 'info');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误:未获取到订单ID');
	}
	$item = pdo_fetch("select state from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$id);
	if($item['state'] == 4){
		header("Location:".$this->createMobileUrl('selected', array('foo'=>'info')));
		exit();
	}
	
	$list = pdo_fetchall("select selected from ".tablename('xm_gohome_grab')." where weid = ".$this->weid." and order_id=".$id);
		
	$idStr = '';
	foreach($list as $value){
		$idStr .= $value['selected'].',';
	}
	$idStr = rtrim($idStr,',');
	$idStr = explode(",", $idStr); 
	if(empty($idStr)){
		$idStr = '';
	}
		
	$page = 'order';
	include $this->template($this->temp.'_selected');
}

if($foo == 'getselected'){
	$id = $_GPC['id'];
	$forumPage = $_GPC['forumPage'];
	$pageSize = 100;
    $startCount=($forumPage-1)*$pageSize;
	
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id = '".$id."' and selected !=3 order by addtime desc limit ".$startCount.",".$pageSize."");
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id       = $value['id'];
			$url      = $this->createMobileUrl('catch',array('foo'=>'staffinfo', 'id'=>$value['staff_id']));
			$staff_id = $value['staff_id'];

			$item = pdo_fetch("select * from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id." and delstate=1");

			$avatar   = $item['avatar'];
			if(empty($avatar)){
				$face = MODULE_URL.'static/takeout/images/nopic.jpg ';
			}else{
				if(substr($avatar,0,6) == 'images'){
					$face = $_W['attachurl'].$avatar;
				}else{
	                $face = $_W['attachurl'].'gohome/avatar/'.$avatar;
	            }	
			}
			$staff_name = $item['staff_name'];
			$fen 		= $this->getStaffFen($staff_id);
			$offer 		= $value['offer'];
			$year 		= $item['year'];
			$age 		= $item['age'];
			$get_order  = $item['get_order'];
			$good 		= $item['good'];
			$center 	= $item['center'];
			$bad 		= $item['bad'];
			$company_name = $item['company_name'];
			$card_all   = $item['card_all'];
			if(strpos($card_all, '身份证') !== false){
				$geren = 1;
			}else{
				$geren = 0;
			}

			$fuwu = 0;
			$company_flag = $item['company_flag'];
			if($company_flag == 1){
				$c_item = pdo_fetch("select id,license,license_pic from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$item['openid']."' and company_flag=1 and company_mge=1");
				if(!empty($c_item['license']) && !empty($c_item['license_pic'])){
					$fuwu = 1;
				}
			}
			
			$piclist = pdo_fetchall("select pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random='".$value['random']."'");
			$piccount = count($piclist);
			$pic = '';
			foreach ($piclist as $val) {
				$pic .= $val['pic'].',';
			}
			$pic = rtrim($pic,',');

			$remark = $value['remark'];
			if(empty($remark)){
				$remark = '';
			}

			$idStr .= '{"id":"'.$id.'","url":"'.$url.'","staff_id":"'.$staff_id.'","face":"'.$face.'","staff_name":"'.$staff_name.'","fen":"'.$fen.'","offer":"'.$offer.'","year":"'.$year.'","age":"'.$age.'","get_order":"'.$get_order.'","good":"'.$good.'","center":"'.$center.'","bad":"'.$bad.'","company_name":"'.$company_name.'", "pic":"'.$pic.'", "piccount":"'.$piccount.'","geren":"'.$geren.'","fuwu":"'.$fuwu.'","remark":"'.$remark.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'selectedsure'){
	$order_id = intval($_GPC['order_id']);
	$radio_v  = $_GPC['radio_v'];
	$arr      = explode('|',$radio_v);
		
	$id       = $arr[0];
	$staff_id = $arr[1];

	$item   = pdo_fetch("select serve_type,state from ".tablename('xm_gohome_order')." where id=".$order_id);
	if($item['state'] == 4){
		header("Location:".$this->createMobileUrl('selected', array('foo'=>'info')));
		exit();
	}

	$f_item = pdo_fetch("select front,payway from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$item['serve_type']." and delstate=1");
	if($f_item['front']>0 && $f_item['payway']==1){
		$fee = floatval($f_item['front']);
		if($fee <= 0) {
			message('支付错误, 金额小于0');
		}

		$pay = $this->getBase('pay');
		if($pay){
			$body = '服务项目预付款';
			$attach = urlencode("F#".$_W['uniacid']."#".$_W['siteroot']."#".$openid."#".$fee."#".$body."#".$this->generate_code(8)."#".$id."#".$order_id."#".$staff_id);
			$jump   = urlencode($_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&do=selected&foo=selectok&m=xm_gohome');
			$url    = MODULE_URL.'pay/jsapi.php?attach='.$attach.'&jump='.$jump.'&appid='.$this->getBase("appid").'&mch_id='.$this->getBase("mch_id").'&apikey='.$this->getBase("apikey").'&appsecret='.$this->getBase("appsecret");
			header("Location:".$url);
		}else{
			$params = array(
				'tid' => 'F#'.$openid.'#'.$fee.'#'.$id.'#'.$order_id.'#'.$staff_id.'#'.$this->generate_code(5),
				'ordersn' => $this->generate_code(8), 
				'title' => '服务项目预付款',
				'fee' => $fee,     
				'user' => $_W['member']['uid'],  
			);
			$this->pay($params);	
		}
	}else{
		$res = $this->selectok($id, $staff_id, $order_id);
		header("Location:".$this->createMobileUrl('selected',array('foo'=>'selectok')));	
	}
}

if($foo == "selectok"){
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and stop=1 and delstate=1 order by RAND() LIMIT 5");
	$page = 'order';
				
	include $this->template($this->temp.'_selectok');
}

if($foo == "info"){
	
	$page = 'order';
				
	include $this->template($this->temp.'_error');
}
?>