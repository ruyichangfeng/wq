<?php 
// header('Content-type: application/json');
// header('Content-type: text/json');

global $_W,$_GPC;
$table_nav="imeepos_news_nav";
$table_news='imeepos_news';
$table_name = 'imeepos_page_setting';
load()->func('db');
load()->func('pdo');
$sql = ' SELECT * FROM '.tablename($table_name).'WHERE page_index = :index AND uniacid = :uniacid ';
$params = array(
	':index' => 1,
	':uniacid'=>$_W['uniacid']
);
$setting_result = pdo_fetch($sql,$params);
$sql = 'SELECT * FROM'.tablename($table_nav)." WHERE nav_status=:status AND uniacid = :uniacid ORDER BY nav_sort desc, nav_id desc";
$sql1 = 'SELECT COUNT(*) FROM '.tablename($table_nav)."WHERE nav_status=:status AND uniacid = :uniacid ";
$params = array(
				':status' => 0,
				':uniacid'=> $_W['uniacid']
			);
$results = pdo_fetchall($sql,$params);
$total = pdo_fetchcolumn($sql1, $params);
$table_slide_images='imeepos_slide_images';
$sql3 = 'SELECT * FROM'.tablename($table_slide_images)." WHERE slide_status=:status AND uniacid = :uniacid ";
// $sql4 = 'SELECT COUNT(*) FROM '.tablename($table_slide_images)."{$where}";
$slide_results = pdo_fetchall($sql3, $params);

$id = intval($_GPC['id']);

if(empty($_GPC['id'])){
	$_GPC['id'] = $results[0]['nav_id'];
	
	 $url = $this->createMobileUrl('index1',array(id=>$_GPC['id']));
	 echo '<script>window.location.href=" '.$url.' "</script>';
}else{
	$sql='SELECT news_title, news_id, news_comment_open, news_wai_link, news_thumbnail, news_date, news_count FROM'.tablename($table_news).'where news_nav_id=:id AND news_status =:status AND uniacid = :uniacid ORDER BY news_sort desc,news_date desc LIMIT 0,10';
	$params = array(
	':id' => $id,
	':status'=>0,
	':uniacid'=>$_W['uniacid']
	);
	$news_results = pdo_fetchall($sql, $params);
}

include $this->template('index1');



