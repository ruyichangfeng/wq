<?php
global $_W, $_GPC;

checkauth();
$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$foo = $_GPC['foo'];
$foos = array('index', 'getIndex');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){

	include $this->template($this->temp1.'_merchantmoney');
}

if($foo == 'getIndex'){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;

	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." order by ctime desc limit ".$startCount.",".$pageSize."");
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$url = $this->createMobileUrl('takeout',array('foo'=>'page', 'id'=>$value['id']));
			if($value['coverpic'] == ''){
				$icon = $_W['siteroot'].'addons/xm_gohome/static/images/nopic.png';
			}else{
				$icon = $_W['attachurl'].$value['coverpic'];
			}
			$merchant_name 	   = $value['merchant_name'];
			$juli 		   	   = $this->getDistance($value['lat'],$value['lng'],$lat,$lng);
			$xing          	   = intval($value['xing']/$value['person']);
			$merchant_address  = $value['merchant_address'];
			$ordersum      	   = $value['ordersum'];
			$merchant_price    = $value['merchant_price'];
			$merchant_song     = $value['merchant_song'];
			$merchant_timelong = $value['merchant_timelong'];
			
			$idStr .= '{"id":"'.$id.'","url":"'.$url.'","icon":"'.$icon.'","merchant_name":"'.$merchant_name.'","juli":"'.$juli.'","xing":"'.$xing.'","merchant_address":"'.$merchant_address.'","ordersum":"'.$ordersum.'","merchant_price":"'.$merchant_price.'","merchant_song":"'.$merchant_song.'","merchant_timelong":"'.$merchant_timelong.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

?>