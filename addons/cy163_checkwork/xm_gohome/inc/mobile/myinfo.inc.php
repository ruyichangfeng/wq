<?php
global $_W,$_GPC;

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$this->checkreg();

$foo = $_GPC['foo'];
$foos = array('index', 'uselist', 'getuse', 'uselist1', 'getuse1', 'editmobile', 'editmobileok', 'editinfo', 'editinfook', 'mycomment', 'getmycomment', 'question', 'shuoming');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$headurl  = $_W['fans']['tag']['avatar'];

	$nickname = $_W['fans']['nickname'];
	//订单总数
	$total = pdo_fetchcolumn("select count(*) from ".tablename('xm_gohome_order')." where weid=".$this->weid." and openid='".$openid."' and flag=1");
	//积分余额
	load()->model('mc');
	$item = mc_credit_fetch($_W['member']['uid'], array('credit1','credit2','credit3'));
		
	$banquan = $this->getBase('banquan');
	$page = 'my';
		
	include $this->template($this->temp.'_myinfo');
}

if($foo == "uselist"){
	$page = 'my';
	
	include $this->template($this->temp.'_uselist');
}

if($foo == "getuse"){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and openid='".$openid."' order by addtime desc limit ".$startCount.",".$pageSize."");
		
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$serve_name = $this->getServeName($value['order_id']);
			$front = $this->getOrderFront($value['order_id']);
			$money = $value['money'] + $front;
			$type = $value['type'];
			$addtime = $value['addtime'];
				
			$idStr .= '{"id":"'.$id.'","serve_name":"'.$serve_name.'","front":"'.$front.'","money":"'.$money.'","type":"'.$type.'","addtime":"'.$addtime.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == "uselist1"){
	$page = 'my';
		
	include $this->template($this->temp.'_uselist1');
}

if($foo == "getuse1"){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 10;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_userrechargelog')." where weid=".$this->weid." and openid='".$openid."' order by addtime desc limit ".$startCount.",".$pageSize."");
		
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$money = $value['money'];
			$addtime = $value['addtime'];
			$idStr .= '{"id":"'.$id.'","money":"'.$money.'","addtime":"'.$addtime.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == "editmobile"){
	$timeout = $this->getBase('timeout')*60;
			
	$page = 'my';
		
	include $this->template($this->temp.'_editmobile');
}

if($foo == "editmobileok"){
	$mobile = $_GPC['mobile'];
	$code = $_GPC['code'];
	$nowtime = time();
		
	$check_m = pdo_fetch("select uid from ".tablename('mc_members')." where uniacid=".$this->weid." and mobile='".$mobile."'");
	if(empty($check_m['uid'])){
		$check = pdo_fetch("select id,code from ".tablename('xm_gohome_code')." where weid=".$this->weid." and mobile=".$mobile." and type=1 and isUse=0 and ".$nowtime." between starttime and endtime");
		if(empty($check)){
			echo 0;
		}else{
			if($code == $check['code']){
				$data['mobile'] = $mobile;
				//load()->model('mc');
				//$result = mc_update($_W['member']['uid'], $data);
				$result = pdo_update('mc_members', $data, array('uid'=>$_W['member']['uid']));
				if($result){
					$data_c['isUse'] = 1;
					pdo_update('xm_gohome_code', $data_c, array('id'=>$check['id']));
					echo 1;
				}else{
					echo 2;
				}
			}else{
				echo 3;
			}
		}
	}else{
		echo 4;
	}
}

if($foo == "editinfo"){
	load()->model('mc');
	$item = mc_fetch($_W['member']['uid'], array('nickname','mobile','realname','avatar','resideprovince','residecity','residedist'));
		
	$timeout = $this->getBase('timeout')*60;
			
	$page = 'my';
		
	include $this->template($this->temp.'_edit');
}

if($foo == "editinfook"){
	$data['realname']   = $_GPC['realname'];
	$data['residecity'] = $_GPC['residecity'];
	$data['residedist'] = $_GPC['residedist'];
	load()->model('mc');
	$result = mc_update($_W['member']['uid'], $data);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
}

if($foo == "mycomment"){
	$headurl=$_W['fans']['tag']['avatar'];
	$nickname = $_W['fans']['nickname'];
		
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and openid='".$openid."' order by addtime desc");
	$count = count($list);
		
	$page = 'my';
	include $this->template($this->temp.'_comment');
}

if($foo == "getmycomment"){
	$forumPage = $_GPC['forumPage'];
	$pageSize = 5;
    $startCount=($forumPage-1)*$pageSize;
		
	$arr = pdo_fetchall("select * from ".tablename('xm_gohome_comment')." where weid=".$this->weid." and openid='".$openid."' order by addtime desc limit ".$startCount.",".$pageSize."");
	if(empty($arr)){
		echo 0;
	}else{
		$start = "[";
		$idStr = '';
		foreach($arr as $value){
			$id = $value['id'];
			$url = $this->createMobileUrl('catchstaff',array('id'=>$value['staff_id']));
			if($this->getStaffInfo($value['staff_id'], 'avatar') == ''){
				$avatar = '';
			}else{
				if(substr($this->getStaffInfo($value['staff_id'], 'avatar'),0,6) == 'images'){
					$avatar = $_W['attachurl'].$this->getStaffInfo($value['staff_id'], 'avatar');
				}else{
                    $avatar = $_W['attachurl'].'gohome/avatar/'.$this->getStaffInfo($value['staff_id'], 'avatar');
                }
			}
			$staff_name = $this->getStaffInfo($value['staff_id'], 'staff_name');
			$xing = $value['xing'];
			$comment = $value['comment'];
			$addtime = $value['addtime'];
				
			$idStr .= '{"id":"'.$id.'","url":"'.$url.'","avatar":"'.$avatar.'","staff_name":"'.$staff_name.'","xing":"'.$xing.'","comment":"'.$comment.'","addtime":"'.$addtime.'"},';
		}
		$idStr = rtrim($idStr,',');
		$end = ']';
		$json = $start.$idStr.$end;
		echo $json;
	}
}

if($foo == "question"){
	$headurl=$_W['fans']['tag']['avatar'];
	$nickname = $_W['fans']['nickname'];
		
	$item = pdo_fetch("select * from ".tablename('xm_gohome_question')." where weid=".$this->weid."");
		
	$page = 'my';
	include $this->template($this->temp.'_questiona');
}

if($foo == "shuoming"){
	$item = pdo_fetch("select * from ".tablename('xm_gohome_shuoming')." where weid=".$this->weid."");
		
	$page = 'my';
	include $this->template($this->temp.'_shuoming');
}

if($foo == "tui"){
	session_destroy();
	unset($_COOKIE);
	
	header("Location:".$this->createMobileUrl('index',array()));
}

?>