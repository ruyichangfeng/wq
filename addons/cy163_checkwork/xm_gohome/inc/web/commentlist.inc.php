<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'delete');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = '';
	$params = array();
		
	$gettime = $_GPC['time'];
	if(!empty($gettime['start'])){
		$starttime = $gettime['start'].' 00:00:00';
		$endtime = $gettime['end'].' 23:59:59';
		$condition .= " AND addtime between '".$starttime."' and '".$endtime."'";
	}
		
	$sqllist = "SELECT * FROM ".tablename('xm_gohome_comment')." WHERE weid=".$this->weid." $condition ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
	$list = pdo_fetchall($sqllist, $params);
	$sql = "SELECT COUNT(*) FROM " . tablename('xm_gohome_comment') . " WHERE weid=".$this->weid." $condition";
	$total = pdo_fetchcolumn($sql,$params);
	$pager = pagination($total, $pindex, $psize);
		
	include $this->template('comment-list');
}

if($foo == 'delete'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误！');
	}
	$res = pdo_delete('xm_gohome_comment', array('id'=>$id));
	if($res){
		message('删除评论成功！',$this->createWebUrl('commentlist',array('foo'=>'index')), 'success');
	}else{
		message('删除评论失败！');
	}
}

?>