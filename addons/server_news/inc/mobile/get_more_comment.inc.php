<?php 
global $_W,$_GPC;
$table_name = 'imeepos_news_comment';
$id = intval($_GPC['id']);
if(!empty($id)){
	$pageindex = $_GPC['page']; // 当前页码
	$count = intval($_GPC['count']);
	$pagesize = 5; // 设置分页大小
	$sql = 'SELECT * FROM '.tablename($table_name).'WHERE comment_news_id = :id AND uniacid = :uniacid ORDER BY comment_id desc LIMIT '.((($pageindex -1) * $pagesize)+$count) .','. $pagesize;
	$params=array(
		':id'=>$id,
		':uniacid'=>$_W['uniacid']
	);
	$result=pdo_fetchall($sql,$params);
	foreach($result as $key=>$val){
		$result[$key]['comment_content'] = html_entity_decode($val['comment_content']);
	}
	die(json_encode($result));
}