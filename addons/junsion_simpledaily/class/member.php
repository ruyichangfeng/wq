<?php
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op == 'display'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$nickname = $_GPC['nickname'];
	if ($nickname) $condition .= " and nickname like '%{$nickname}%'";
	$list = pdo_fetchall('select * from '.tablename($this->modulename.'_member')." where weid='{$_W['uniacid']}' {$condition}  LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
	foreach ($list as $k => $value) {
		$num = pdo_fetchall('select id from '.tablename($this->modulename."_works")." where openid='{$value['openid']}'");
		$list[$k]['num'] = count($num);
	}
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_member') . " where weid='{$_W['uniacid']}' {$condition}");
	$pager = pagination($total, $pindex, $psize);
}elseif($op == 'del'){
	$id = $_GPC['id'];
	$mem = pdo_fetch("select * from " . tablename($this->modulename.'_member') . " where id = '{$id}'");
	if(empty($mem)){
		message('抱歉！该用户不存在或已删除',referer(),'error');
	}
	pdo_delete($this->modulename.'_works',array('openid'=>$mem['openid']));
	if(pdo_delete($this->modulename.'_member',array('id'=>$id))){
		message('删除成功',referer(),'success');
	}else{
		message('删除失败',referer(),'error');
	}
}elseif($op == 'checkmem'){
	$mid = $_GPC['id'];
	$item = pdo_fetch("select * from " . tablename($this->modulename.'_member') . " where id = '{$mid}'");
	if($item['status'] == 1){
		$data['status'] = 0;
	}else{
		$data['status'] =1;
	}
	$ret = pdo_update($this->modulename.'_member',$data,array('id'=>$item['id']));
	if(!empty($ret)){
		if($item['status'] == 1){
			$datas = 2;//隐藏
			print_r(json_encode($datas));
			die('1');
		}else{
			$datas = 1;//显示
			print_r(json_encode($datas));
			die('1');
		}
	}else{
		$datas=0;
		die(json_encode($datas));
	}
}

include $this->template('member');