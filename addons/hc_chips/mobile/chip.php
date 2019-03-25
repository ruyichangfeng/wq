<?php
	$member = pdo_fetch("select * from ".tablename('hc_chips_member')." where uniacid = ".$uniacid." and openid = '".$_W['openid']."'");
	if(empty($member)){
		$urlcookie = "hc_chips_url".$_W['uniacid'];
		$url = $this->createMobileUrl('chip', array('op'=>'join', 'id'=>$_GPC['id']));
		setcookie($urlcookie, $url, time()+3600*240);
		$this->CheckCookie(time());
	}

	if($op=='join'){
		$rule = pdo_fetch("select mobile, gzurl from ".tablename('hc_chips_rule')." where uniacid = ".$uniacid);
		$chipid = intval($_GPC['id']);
		if(!empty($chipid)){
			$chip = pdo_fetch("select * from ".tablename('hc_chips_chip')." where id = ".$chipid);
			$takechips = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where status = 1 and uniacid = ".$uniacid." and chipid = ".$chipid." order by joinmoney desc, createtime asc");
			$alljoinmoney = 0;
			foreach($takechips as $t){
				$alljoinmoney = $alljoinmoney + $t['joinmoney'];
			}
			if(time() < $chip['starttime']){
				$flag = 0;
			}
			if(time() >= $chip['starttime'] && time() < $chip['endtime']){
				$flag = 1;
			}
			if(time() >= $chip['endtime'] || $alljoinmoney >= $chip['price']){
				$flag = 2;
			}
			$mychip = pdo_fetch("select * from ".tablename('hc_chips_takechip')." where uniacid = ".$uniacid." and chipid = ".$chipid." and mid = ".$member['id']);
			$isjoin = empty($mychip) ? 0 : 1;
			pdo_update('hc_chips_chip', array('view'=>$chip['view']+1), array('id'=>$chip['id']));
		}
	}
	if($op=='pay'){
		$id = intval($_GPC['id']);
		if($id){
			$takechip = pdo_fetch("select * from ".tablename('hc_chips_takechip')." where id = ".$id);
			$title = pdo_fetchcolumn("select title from ".tablename('hc_chips_chip')." where id = ".$takechip['chipid']);
			$params['tid'] = $id;
			$params['title'] = $title;
			$params['ordersn'] = time();
			$params['isdelivery'] = 2;
			$params['fee'] = $takechip['joinmoney'];
			//$params['fee'] = 0.1;
		}		
		include $this->template('pay');
		exit;
	}
	
	if($op=='chip'){
		$chipid = intval($_GPC['id']);
		$chip = pdo_fetch("select * from ".tablename('hc_chips_chip')." where id = ".$chipid);
		$takechips = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where status = 1 and uniacid = ".$uniacid." and chipid = ".$chipid." order by joinmoney desc, createtime asc");
		$alljoinmoney = 0;
		foreach($takechips as $t){
			$alljoinmoney = $alljoinmoney + $t['joinmoney'];
		}
		if(time() < $chip['starttime']){
			$flag = 0;
		}
		if(time() >= $chip['starttime'] && time() < $chip['endtime']){
			$flag = 1;
		}
		if(time() >= $chip['endtime'] || $alljoinmoney >= $chip['price']){
			$flag = 2;
		}
		$mychip = pdo_fetch("select * from ".tablename('hc_chips_takechip')." where uniacid = ".$uniacid." and chipid = ".$chipid." and mid = ".$member['id']);
		$isjoin = empty($mychip) ? 0 : 1;
		include $this->template('chiping');
		exit;
	}
	
	if($op=='chiping'){
		$chipid = intval($_GPC['id']);
		$joinmoney = $_GPC['joinmoney'];
		if($chipid){
			$chip = pdo_fetch("select starttime, endtime, chipmoney from ".tablename('hc_chips_chip')." where id = ".$chipid);
			if(time() < $chip['starttime']){
				echo -3;
				exit;
			}
			if(time() >= $chip['endtime']){
				echo -4;
				exit;
			}
		}
		if(empty($joinmoney)){
			//message('你还没输入参与金额哦！');
			if($joinmoney == 0){
				echo -1;
				exit;
			} else {
				echo 0;
				exit;
			}
		} else {
			if(is_numeric($joinmoney)){
				if($joinmoney < 1){
					//message('请输入大于0的金额！');
					echo -1;
					exit;
				}
			} else {
				//message('输入不合法哦！');
				echo -2;
				exit;
			}
		}
		$mychip = pdo_fetch("select * from ".tablename('hc_chips_takechip')." where uniacid = ".$uniacid." and chipid = ".$chipid." and mid = ".$member['id']);
		$joinmoney = empty($mychip['chipmoney']) ? $joinmoney : $mychip['chipmoney'];
		$takechip = array(
			'uniacid'=>$uniacid,
			'chipid'=>$chipid,
			'mid'=>$member['id'],
			'joinmoney'=>$joinmoney,
			'mobile'=>$_GPC['mobile'],
			'status'=>0,
			'isaward'=>0,
			'createtime'=>time()
		);
		pdo_update('hc_chips_member', array('mobile'=>$takechip['mobile']), array('id'=>$member['id']));
		if(empty($mychip)){
			pdo_insert('hc_chips_takechip', $takechip);
			echo pdo_insertId();
		} else {
			unset($takechip['status']);
			unset($takechip['isaward']);
			unset($takechip['createtime']);
			pdo_update('hc_chips_takechip', $takechip, array('id'=>$mychip['id']));
			echo $mychip['id'];
		}
		exit;
	}
	include $this->template('chip');
?>