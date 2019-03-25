<?php 
global $_W,$_GPC;

$table_news='imeepos_news';
$table_comment='imeepos_news_comment';
$table_name = 'imeepos_page_setting';
load()->func('db');
load()->func('pdo');
$sql = ' SELECT * FROM '.tablename($table_name).'WHERE page_index = :index AND uniacid = :uniacid ';
$params = array(
	':index' => 2,
	':uniacid' =>$_W['uniacid']
);
$setting_result = pdo_fetch($sql,$params);
$id = intval($_GPC['id']);
if (empty($_W['fans']['nickname'])) {
	mc_oauth_userinfo();
}
if(!empty($id)){
		
		$sql='SELECT news_title, news_author,share_title,share_desc,share_thumbnail,news_comment_open, news_zan, news_thumbnail, news_id, news_content, news_date, news_count,uniacid FROM'.tablename($table_news).'where news_id=:id AND uniacid = :uniacid ';
		$params = array(
		':id' => $id,
		':uniacid' =>$_W['uniacid']
		);
	$news_results = pdo_fetch($sql, $params);
	// print_r($news_results);
	// exit();
	// // $news_results['news_count']=$news_results['news_count'] + 1;
	
	pdo_update($table_news,array('news_count'=>$news_results['news_count'] + 1), array('news_id'=>$id,'uniacid' =>$_W['uniacid']));
	$news_results['news_content']=html_entity_decode($news_results['news_content']);
	$news_results['news_count']=$news_results['news_count']+1;
};

$sql = 'SELECT * FROM'.tablename($table_comment).'WHERE comment_news_id =:id AND uniacid = :uniacid ORDER BY comment_id desc LIMIT 0,5';

$params = array(
	':id'=> $id,
	':uniacid' =>$_W['uniacid']
);

$comment_results = pdo_fetchall($sql, $params);
$sql = 'SELECT count(*) FROM '.tablename($table_comment).'WHERE comment_news_id = :id AND uniacid = :uniacid ';
$comment_total = pdo_fetchcolumn($sql,$params);

include $this->template('news_detail');
