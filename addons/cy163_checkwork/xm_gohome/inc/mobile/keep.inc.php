<?php
global $_W, $_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('list', 'getKeep');
$foo = in_array($foo, $foos) ? $foo : 'list';

if($foo == 'list'){
	
	include $this->template('takeout/keep');	
}

if($foo == 'getKeep'){

	//$forumPage = $_GPC['forumPage'];
	$forumPage = 1;
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;

	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_takekeep')." where weid=".$_W['uniacid']." and openid='".$openid."' order by ctime desc limit ".$startCount.",".$pageSize."");
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id 		 = $value['id'];
			$merchant_id = $value['merchantid'];
			$url = $this->createMobileUrl('takeout',array('foo'=>'page', 'id'=>$merchant_id));
			$merchant_name = $this->getMerchantInfo($merchant_id, 'merchant_name');
			$coverpic = $this->getMerchantInfo($merchant_id, 'coverpic');
			if($coverpic == ''){
				$icon = $_W['MODULE_URL'].'static/takeout/images/nopic.jpg';
			}else{
				if (strstr($coverpic,'images')){
					$icon = $_W['attachurl'].$coverpic;
				}else{
					$icon = $_W['attachurl'].'gohome/coverpic/'.$coverpic;
				}
			}
			$merchant_price = $this->getMerchantInfo($merchant_id, 'merchant_price');
			$merchant_song  = $this->getMerchantInfo($merchant_id, 'merchant_song');
			$a = $this->getMerchantInfo($merchant_id, 'xing');
			$b = $this->getMerchantInfo($merchant_id, 'person');
			$xing = intval($a/$b);
			$idStr .= '{"id":"'.$id.'","url":"'.$url.'","icon":"'.$icon.'","merchant_name":"'.$merchant_name.'","merchant_price":"'.$merchant_price.'","merchant_song":"'.$merchant_song.'","xing":"'.$xing.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

?>