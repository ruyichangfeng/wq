<?php
global $_W,$_GPC;
$op = $_GPC['op'];
$cid = $_GPC['cate'];
if ($op == 'post'){
	$cates = pdo_fetchall('select * from '.tablename($this->modulename."_cate")." where weid='{$_W['uniacid']}' and status = 1");
	if (empty($cates)) message('请先添加音乐分类!',$this->createWebUrl('mcate',array('type'=>1)));
	$id = $_GPC['id'];
	if (checksubmit('submit')){
		$data = array(
				'weid'=>$_W['uniacid'],
				'title'=>$_GPC['title'],
				'cate'=>$cid,
				'url'=>$_GPC['url'],
				'status'=>$_GPC['status'],
				'sort'=>$_GPC['sort'],
		);
		if (empty($id)){
			if (pdo_insert($this->modulename."_music",$data) === false){
				message('保存失败！');
			}else message('保存成功！',$this->createWebUrl('music'));
		}else{
			if (pdo_update($this->modulename."_music",$data,array('id'=>$id)) === false){
				message('保存失败！');
			}else message('保存成功！',$this->createWebUrl('music'));
		}
	}
	$item = pdo_fetch('select * from '.tablename($this->modulename."_music")." where id='{$id}'");
}elseif ($op == 'delete'){
	$id = $_GPC['id'];
	if (pdo_delete($this->modulename."_music",array('id'=>$id)) === false){
		message('删除失败！');
	}else message('删除成功！',$this->createWebUrl('music'));
}elseif($op == 'check'){
	$mid = $_GPC['id'];
	$item = pdo_fetch("select * from " . tablename($this->modulename."_music") . " where id = '{$mid}'");
	if(empty($item)){
		$datas=0;
		die(json_encode($datas));
	}
	if($item['status'] == 1){
		$data['status'] = 0;
	}else{
		$data['status'] =1;
	}
	$ret = pdo_update($this->modulename.'_music',$data,array('id'=>$item['id']));
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
} else{
	if (checksubmit('submit')){
		$sorts = $_GPC['sorts'];
		foreach ($sorts as $id=>$sort){
			pdo_update($this->modulename.'_music', array('sort'=>$sort), array('id'=>$id));
		}
		message('批量更改排序成功',referer(),'success');
	}
	$cates = pdo_fetchall('select * from '.tablename($this->modulename."_cate")." where weid='{$_W['uniacid']}'");
	$condition = '';
	if (!empty($cid)){
		$condition .= " and m.cate={$cid}";
	}
	$title = $_GPC['title'];
	$status = $_GPC['status'];
	if (!empty($title)){
		$condition .= " and m.title like '%{$title}%'";
	}
	if ($status==1){
		$condition .= " and m.status=1";
	}elseif ($status==2){
		$condition .= " and m.status=0";
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall('select m.*,c.title as ctitle from '.tablename($this->modulename.'_music')." m left join ".tablename($this->modulename.'_cate')." c on m.cate=c.id where m.weid='{$_W['uniacid']}' {$condition} order by sort desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
	$total = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->modulename.'_music') . " m where weid='{$_W['uniacid']}' {$condition}");
	$pager = pagination($total, $pindex, $psize);
}
include $this->template('music');