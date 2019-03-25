<?php
	$chips = pdo_fetchall("select id, title from ".tablename('hc_chips_chip')." where uniacid = ".$uniacid);
	$chip = array();
	foreach($chips as $c){
		$chip[$c['id']] = $c['title'];
	}
	$members = pdo_fetchall("select id, realname from ".tablename('hc_chips_member')." where uniacid = ".$uniacid);
	$member = array();
	foreach($members as $m){
		$member[$m['id']] = base64_decode($m['realname']);
	}
	if($op=='display'){
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$chipmanagers = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where uniacid = ".$uniacid." order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		$total = pdo_fetchcolumn("select count(id) from ".tablename('hc_chips_takechip')." where uniacid = ".$uniacid);
		$pager = pagination($total, $pindex, $psize);
	}
	
	if($op=='visit'){
		$chipid = intval($_GPC['id']);
		if($chipid){
			$chipmanagers = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where chipid = ".$chipid." and uniacid = ".$uniacid." order by id desc");
		}
	}
	
	if($op=='sort'){
		$sort = array(
			'chipid'=>$_GPC['chipid']
		);
		if($sort['chipid']==0){
			$chipmanagers = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where uniacid = ".$uniacid." order by id desc");
		} else {
			$chipmanagers = pdo_fetchall("select * from ".tablename('hc_chips_takechip')." where chipid = ".$sort['chipid']." and uniacid = ".$uniacid." order by id desc");
		}
	}
	if($op=='post'){
		$id = $_GPC['id'];
		if(empty($chips)){
			message('请先添加卡券！', $this->createWebUrl('chip', array('op'=>'post')), 'error');
		}
		if(checksubmit('submit')){
			if(empty($_GPC['joinmoney'])){
				$joinmoney = 1;
			} else {
				$joinmoney = is_numeric($_GPC['joinmoney']) ? $_GPC['joinmoney'] : message('请输入合法众筹金额！');
			}
			$takechip = array(
				'uniacid'=>$uniacid,
				'chipid'=>$_GPC['chipid'],
				'mid'=>$_GPC['mid'],
				'mobile'=>$_GPC['mobile'],
				'joinmoney'=>$joinmoney,
				'status'=>$_GPC['status'],
				'isaward'=>$_GPC['isaward'],
				'createtime'=>strtotime($_GPC['createtime'])
			);
			if(intval($id)){
				unset($chip['createtime']);
				pdo_update('hc_chips_takechip', $takechip, array('id'=>$id));
			} else {
				pdo_insert('hc_chips_takechip', $takechip);
			}
			message('添加成功！', $this->createWebUrl('chipmanager'), 'success');
		} else {
			if(empty($members)){
				message('请先添加粉丝！', $this->createWebUrl('member', array('op'=>'post')), 'error');
			}
		}
		if(intval($id)){
			$takechip = pdo_fetch("select * from ".tablename('hc_chips_takechip')." where id = ".$id);
		} else {
			$takechip = array(
				'createtime'=>time(),
				'status'=>1,
				'isaward'=>1
			);
		}
		include $this->template('web/chipmanager_post');
		exit;
	}
	
	if($op=='delete'){
		$id = $_GPC['id'];
		pdo_delete('hc_chips_takechip', array('id'=>$id));
		message('删除成功！', $this->createWebUrl('chipmanager'), 'success');
	}
	
	include $this->template('web/chipmanager_list');
?>