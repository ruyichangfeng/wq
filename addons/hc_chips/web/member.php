<?php
	if($op=='display'){
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$members = pdo_fetchall("select * from ".tablename('hc_chips_member')." where uniacid = ".$uniacid." order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
		$total = pdo_fetchcolumn("select count(id) from ".tablename('hc_chips_member')." where uniacid = ".$uniacid);
		$pager = pagination($total, $pindex, $psize);
	}
	
	if($op=='sort'){
		$sort = array(
			'realname'=>base64_encode($_GPC['realname']),
			'mobile'=>$_GPC['mobile']
		);
		$members = pdo_fetchall("select * from ".tablename('hc_chips_member')." where realname like '%".$sort['realname']."%' and mobile like '%".$sort['mobile']."%' and uniacid = ".$uniacid." order by id desc");
	}
	
	if($op=='post'){
		$id = $_GPC['id'];
		if(checksubmit('submit')){
			$member = array(
				'uniacid'=>$uniacid,
				'openid'=>trim($_GPC['openid']),
				'realname'=>base64_encode(trim($_GPC['realname'])),
				'mobile'=>$_GPC['mobile'],
				'headimgurl'=>$_GPC['headimgurl'],
				'status'=>$_GPC['status'],
				'createtime'=>time()
			);
			if(intval($id)){
				unset($chip['createtime']);
				pdo_update('hc_chips_member', $member, array('id'=>$id));
			} else {
				pdo_insert('hc_chips_member', $member);
			}
			message('添加成功！', $this->createWebUrl('member'), 'success');
		}
		if(intval($id)){
			$member = pdo_fetch("select * from ".tablename('hc_chips_member')." where id = ".$id);
		} else {
			$member = array(
				'createtime'=>time(),
				'status'=>1
			);
		}
		include $this->template('web/member_post');
		exit;
	}
	
	if($op=='delete'){
		$id = $_GPC['id'];
		pdo_delete('hc_chips_member', array('id'=>$id));
		message('删除成功！', $this->createWebUrl('member'), 'success');
	}
	
	include $this->template('web/member_list');
?>