<?php
	if($op=='display'){
		$rule = pdo_fetch("select * from ".tablename('hc_chips_rule')." where uniacid = ".$uniacid);
	}
	if(checksubmit('submit')){
		$id = $_GPC['id'];
		$rule = array(
			'uniacid'=>$uniacid,
			'title'=>trim($_GPC['title']),
			'picture'=>$_GPC['picture'],
			'description'=>trim($_GPC['description']),
			'gzurl'=>$_GPC['gzurl'],
			'mobile'=>$_GPC['mobile'],
			'rule'=>htmlspecialchars_decode(trim($_GPC['rule'])),
			'createtime'=>time()
		);
		if(intval($id)){
			unset($rule['createtime']);
			pdo_update('hc_chips_rule', $rule, array('id'=>$id));
		} else {
			pdo_insert('hc_chips_rule', $rule);
		}
		message('提交成功！', $this->createWebUrl('rule'), 'success');
	}
	include $this->template('web/rule');
?>