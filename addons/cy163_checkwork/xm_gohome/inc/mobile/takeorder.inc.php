<?php
global $_W, $_GPC;

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('myorder', 'getOrder', 'delete', 'statelist', 'stateinfo', 'rate', 'rateok', 'delOrder');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'myorder'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}
	
	if(empty($openid)){
		message('参数错误001');
	}
	
	include $this->template('takeout/myorder');	
}

if($foo == 'getOrder'){
	$openid = $_W['fans']['from_user'];
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_takeorder')." where weid=".$_W['uniacid']." and openid='".$openid."' order by ctime desc limit ".$startCount.",".$pageSize."");

	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$i_url = $this->createMobileUrl('takeorder', array('foo'=>'statelist', 'id'=>$id));
			$j_url = $this->createMobileUrl('takeout', array('foo'=>'page', 'id'=>$value['merchantid']));
			$c_url = $this->createMobileUrl('takeorder', array('foo'=>'rate', 'id'=>$value['id']));
			$s_url = $this->createMobileUrl('takeout', array('foo'=>'setaddress', 'orderid'=>$value['orderid']));
			$p_url = $this->createMobileUrl('takeout', array('foo'=>'ordercar', 'orderid'=>$value['orderid']));
			$merchantname = $this->getMerchantInfo($value['merchantid'],'merchant_name');
			$coverpic = $this->getMerchantInfo($value['merchantid'],'coverpic');
			if($coverpic == ''){
				$icon = $_W['MODULE_URL'].'static/takeout/images/nopic.jpg ';
			}else{
				if (strstr($coverpic,'images')){
					$icon = $_W['attachurl'].$coverpic;
				}else{
					$icon = $_W['attachurl'].'gohome/coverpic/'.$coverpic;
				}
			}
			$ctime = date('Y-m-d H:i:s',$value['ctime']);
			$amount = $value['amount'];
			$state = $value['state'];
			if($value['state'] == 1 || $value['state'] == 2){
				$text = '待付款';
			}elseif($value['state'] == 3){
				$text = '货到付款';
			}elseif($value['state'] == 4){
				$text = '已付款';
			}elseif($value['state'] == 5){
				$text = '已接单';
			}elseif($value['state'] == 6){
				$text = '已确认';
			}elseif($value['state'] == 7){
				$text = '已评论';
			}else{
				$text = '已取消';
			}

			$idStr .= '{"id":"'.$id.'","i_url":"'.$i_url.'","j_url":"'.$j_url.'","c_url":"'.$c_url.'","s_url":"'.$s_url.'","p_url":"'.$p_url.'","merchantname":"'.$merchantname.'","icon":"'.$icon.'","ctime":"'.$ctime.'","amount":"'.$amount.'","text":"'.$text.'","state":"'.$state.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == 'delete'){
	$id = intval($_GPC['id']);
	$u_info = array(
		'state' => 0,
		'dtime' => time()
	);
	$res = pdo_update('xm_gohome_takeorder', $u_info, array('id'=>$id));
	if($res){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == 'statelist'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}
	
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误:未获取到订单ID');
		exit();
	}

	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);

	include $this->template('takeout/statelist');
}

if($foo == 'stateinfo'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}
	
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误:未获取到订单ID');
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and state>0 and id=".$id);
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");

	include $this->template('takeout/stateinfo');
}

if($foo == 'rate'){
	$openid = $_W['fans']['from_user'];
	if (empty($_W['fans']['follow'])){
		header('Location:'.$this->getBase('lead'));
		exit();
	}
	
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误:未获取到订单ID');
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$id);
	if(empty($item)){
		message('未获取到订单信息');
		exit();	
	}
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");

	include $this->template('takeout/rate_add');
}

if($foo == 'rateok'){
	$openid = $_W['fans']['from_user'];

	$id         = intval($_GPC['id']);
	$orderid    = intval($_GPC['orderid']); //订单编号
	$merchantid = intval($_GPC['merchantid']);
	$grade      = intval($_GPC['grade']);

	$check = pdo_fetch("select id from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and type='takeout' and order_id=".$id." and openid='".$openid."'");
	if(empty($check)){
		$xing = intval($_GPC['xing']);
		if(empty($xing)){
			$xing = 4;
		}
		$fxing = intval($_GPC['fxing']);
		if(empty($fxing)){
			$fxing = 4;
		}
		$comment = $_GPC['comment'];
		if(empty($comment)){
			$comment = '味道好极了';
		}
		if(empty($_GPC['niming'])){
			$niming = 0;
		}
		$staff_id = $this->getMerchantInfo($merchantid, 'staff_id');
		$rate = array(
			'weid'       => $this->weid,
			'openid'     => $openid,
			'staff_id'   => $staff_id,
			'order_id'   => $id,
			'ordernumber'=> $orderid,
			'merchantid' => $merchantid,
			'comment'    => $comment,
			'grade'      => $grade,
			'xing'       => $xing,
			'fxing'      => $fxing,
			'type'       => 'takeout'
		);
		$res = pdo_insert('xm_gohome_comment', $rate);
		if($res){
			pdo_query("update ".tablename('xm_gohome_takeorder')." set state = 7,htime=".time()." where id=".$id);
			pdo_query("update ".tablename('xm_gohome_merchant')." set xing=xing+".$xing.",fxing=fxing+".$fxing.",person=person+1 where id=".$merchantid);
			if($xing == 1){
				pdo_query("update ".tablename('xm_gohome_staff')." set xing=xing+".$xing.",cperson=cperson+1,bad=bad+1 where id=".$staff_id." and delstate=1");
			}elseif($xing == 5){
				pdo_query("update ".tablename('xm_gohome_staff')." set xing=xing+".$xing.",cperson=cperson+1,good=good+1 where id=".$staff_id." and delstate=1");
			}else{
				pdo_query("update ".tablename('xm_gohome_staff')." set xing=xing+".$xing.",cperson=cperson+1,center=center+1 where id=".$staff_id." and delstate=1");
			}
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 2;
	}
}

if($foo == 'delOrder'){
	$openid = $_W['fans']['from_user'];
	$id = intval($_GPC['id']);
	if(empty($id)){
		echo 0;
	}else{
		$data = array(
			'state' => 5,
			'dtime' => time()
		);
		$res = pdo_update('xm_gohome_takeorder', $data, array('id'=>$id));
		if($res){
			$log = array(
				'weid'   => $this->weid,
				'openid' => $openid,
				'delid'  => $id,
				'type'   => 'takeout',
				'dtime'  => time()
			);
			pdo_insert('xm_gohome_dellog', $log);
			echo 1;
		}else{
			echo 0;
		}
	}
}
?>