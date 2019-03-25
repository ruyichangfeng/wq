<?php 
global $_W,$_GPC;
$table_news='imeepos_news';
load()->func('db');
load()->func('pdo');
if(!empty($_GPC['id'])){
		$id = intval($_GPC['id']);
		$sql='SELECT news_title, news_id, news_thumbnail, news_date,news_sort, news_count,uniacid FROM'.tablename($table_news).'where news_nav_id=:id AND news_status =:status AND uniacid = :uniacid ORDER BY news_sort desc,news_date desc LIMIT 0,10';
		$params = array(
		':id' => $id,
		':status'=>0,
		':uniacid' =>$_W['uniacid']
		);
		$news_results = pdo_fetchall($sql, $params);
		foreach($news_results as $key=>$val){
			$news_results[$key]['news_thumbnail'] = tomedia($val['news_thumbnail']);

		}
		echo json_encode($news_results);

		
		
	}else{
		echo '没有获取到数据！';
	}
