<?php
global $_W,$_GPC;
$op = $_GPC['op'];

if ($op == 'post'){
	$id = $_GPC['id'];
	if (checksubmit('submit')){
		$data = array(
				'weid'=>$_W['uniacid'],
				'title'=>$_GPC['title'],
				'status'=>$_GPC['status'],
				'price'=>$_GPC['price'],
				'sort'=>$_GPC['sort'],
		);
		if (pdo_update($this->modulename."_style",$data,array('id'=>$id)) === false){
			message('保存失败！');
		}else message('保存成功！',$this->createWebUrl('style'));
	}
	$item = pdo_fetch('select * from '.tablename($this->modulename."_style")." where id='{$id}'");
	$itemnames = scandir($item['path'].'/img');
	$isdefault = file_exists($item['path'].'/img/default.png');
}elseif($op == 'check'){
	$mid = $_GPC['id'];
	$item = pdo_fetch("select * from " . tablename($this->modulename."_style") . " where id = '{$mid}'");
	if(empty($item)){
		$datas=0;
		die(json_encode($datas));
	}
	if($item['status'] == 1){
		$data['status'] = 0;
	}else{
		$data['status'] =1;
	}
	pdo_update($this->modulename.'_works',$data,array('styleid'=>$item['id']));
	$ret = pdo_update($this->modulename.'_style',$data,array('id'=>$item['id']));
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
		
}else{
	if (checksubmit('submit')){
		$sorts = $_GPC['sorts'];
		foreach ($sorts as $id=>$sort){
			pdo_update($this->modulename.'_style', array('sort'=>$sort), array('id'=>$id));
		}
		message('批量更改排序成功',referer(),'success');
	}
	$condition = '';
	$title = $_GPC['title'];
	if ($title) $condition .= " and title like '%{$title}%'";
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall('select * from '.tablename($this->modulename.'_style')." where weid='{$_W['uniacid']}' {$condition} order by sort desc, id asc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_style') . " where weid='{$_W['uniacid']}' {$condition}");
	$pager = pagination($total, $pindex, $psize);
}

include $this->template('style');