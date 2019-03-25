<?php
// header("content-type:text/html;charset=gb2312");
global $_W, $_GPC;
include MODULE_ROOT.'/inc/web/phpQuery.php';
include MODULE_ROOT.'/inc/web/QueryList.php';
use QL\QueryList;
$ops = array('display', 'update', 'delete','add','addwai','manage_comment','dele_comment'); // 只支持此 3 种操作.
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'display';
$nav_table='imeepos_news_nav';
$news_table='imeepos_news';
$table_comment='imeepos_news_comment';
load()->func('db');
load()->func('pdo');
load()->func('tpl');

$sql = 'SELECT * FROM'.tablename($nav_table).'WHERE uniacid = :uniacid ';
$params =array(':uniacid'=>$_W['uniacid']);
$nav_list = pdo_fetchall($sql,$params);

if($op=='display'){
	$pageindex = max(intval($_GPC['page']), 1); // 当前页码
	$pagesize = 10; // 设置分页大小
	$sql = 'SELECT * FROM'.tablename($news_table);
	$news_lists = pdo_fetchall($sql);
 	foreach($news_lists as $key => $val){
 		if($val['uniacid']==0){
 			$data['uniacid'] = $_W['uniacid'];
 			$row = pdo_update($news_table,$data,array('news_id'=>$val['news_id']));
 		}	
 	}
	// $sql = 'SELECT * FROM'.tablename($news_table)."ORDER BY news_id desc LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;
	$sql='SELECT o.news_id,o.news_title,o.news_comment_open,o.news_content,o.news_sort,o.news_wai_link,o.news_nav_id,o.news_status,o.news_thumbnail,o.uniacid,o.news_author,o.news_date,a.nav_title FROM'.tablename($news_table)."as o".','.tablename($nav_table)." as a WHERE o.news_nav_id = a.nav_id AND o.uniacid = :uniacid ORDER BY o.news_id DESC LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;
	$sql1 = 'SELECT COUNT(*) FROM '.tablename($news_table).'WHERE uniacid = :uniacid ';
	$params =array(':uniacid'=>$_W['uniacid']);
 	$news_list = pdo_fetchall($sql,$params);
 	
 	$total = pdo_fetchcolumn($sql1,$params);
 	
 	$pager = pagination($total, $pageindex, $pagesize);
}

if($op=='add'){
	if(checksubmit('celect')){
		$url = $_GPC['url'];
		$news = file_get_contents($url);
		$news1 = mb_convert_encoding($news,'utf-8','gb2312'); 
		
		$regex3='/<h1>(.*?)<\/h1>/si';
		preg_match_all($regex3, $news1, $match);
		$news_title = $match[0][0];
		$news_title = substr($news_title,4,$news_title.length-5);
		$rules = array(
			//采集id为one这个元素里面的纯文本内容
			'content' => array('#C-Main-Article-QQ .bd','html'),
			'iframe' => array('iframe:eq(0)','src'),
			'img'    => array('#C-Main-Article-QQ .bd img:eq(0)','src'),
			'img2'    => array('#C-Main-Article-QQ .bd img:eq(1)','src'),
			'author' => array('.color-a-1','text'),
			// 'article-time' =>array('.article-time','text')
		);
		$news_allcontent= QueryList::Query($news1,$rules)->data;

		$news_content = $news_allcontent[0]['content'];
		$news_src = $news_allcontent[0]['iframe'];
		$news_image = $news_allcontent[0]['img'];
		$news_image2 = $news_allcontent[0]['img2'];
		$news_author = $news_allcontent[0]['author'];
		
		if(strpos($news_image,'data:') == 0 ){
			$news_image = $news_image2;
		}
		// $article_time = $news_allcontent[0]['article-time'];
	}
	if(checksubmit('submit')){
		$news['news_title']=$_GPC['title'];
		$news['news_content']=$_GPC['content'];
		$news['news_nav_id']=$_GPC['nav_id'];
		$news['news_status']=$_GPC['status'];
		$news['news_thumbnail']=$_GPC['thumbnail'];
		$news['news_author']=$_GPC['author'];
		$news['news_date']=$_GPC['date'];
		$news['news_comment_open']=$_GPC['comment_open'];
		$news['share_title']=$_GPC['share_title'];
		$news['share_desc']=$_GPC['share_desc'];
		$news['share_thumbnail']=$_GPC['share_thumbnail'];
		$news['news_sort']=$_GPC['news_sort'];
		$news['news_count']=$_GPC['screen_times'];
		$news['news_zan']=$_GPC['zan_count'];
		$news['uniacid']=$_W['uniacid'];
		$row = pdo_insert($news_table, $news);
		if($row){
			message('添加新闻成功',$this->createWebUrl('news'),array('op'=>'add'),'success');
		}else{
			message('添加新闻失败',$this->createWebUrl('news'),array('op'=>'add'),'error');
			}
	}
}
if($op == 'addwai'){
	// if(checksubmit('celect')){
	// 	$url = $_GPC['url'];
	// 	$news = file_get_contents($url);
	// 	$rules = array(
	// 		//采集id为one这个元素里面的纯文本内容
	// 		'img'    => array('.rich_media_area_primary img:eq(0)','src'),
	// 		'title' => array('h2','text'),
	// 		// 'article-time' =>array('.article-time','text')
	// 	);
	// 	$news_allcontent= QueryList::Query($news,$rules)->data;
	// 	$news_image = $news_allcontent[0]['img'];
	// 	$news_title = $news_allcontent[0]['title'];
		
	// }
	if(checksubmit('submit')){
		$news['news_title']=$_GPC['title'];
		$news['news_nav_id']=$_GPC['nav_id'];
		$news['news_status']=$_GPC['status'];
		$news['news_thumbnail']=$_GPC['thumbnail'];
		$news['news_date']=$_GPC['date'];
		$news['news_wai_link']=$_GPC['wai_link'];
		$news['news_sort']=$_GPC['news_sort'];
		$news['uniacid']=$_W['uniacid'];
		$row = pdo_insert($news_table, $news);
		if($row){
			message('添加新闻成功',$this->createWebUrl('news'),array('op'=>'display'),'success');
		}else{
			message('添加新闻失败',$this->createWebUrl('news'),array('op'=>'addwai'),'error');
		}
	}
	
}
if($op=='update'){
	$id = intval($_GPC['id']);
	if(!empty($id)){
		$sql = 'SELECT * FROM'.tablename($news_table).' WHERE news_id=:id AND uniacid = :uniacid ';
		$params = array(':id'=>$id,':uniacid'=>$_W['uniacid']);
		$results = pdo_fetch($sql, $params);	
	}
	if(checksubmit('submit')){
		$data['news_title'] = ihtmlspecialchars($_GPC['title']);
		$data['news_content'] =$_GPC['content'];
		$data['news_author'] = $_GPC['author'];
		$data['news_nav_id'] = $_GPC['nav_id'];
		$data['news_thumbnail'] =$_GPC['thumbnail'];
		$data['news_status'] =$_GPC['status'];
		$data['news_date']=$_GPC['date'];
		$data['news_wai_link']=$_GPC['wai_link'];
		$data['news_comment_open']=$_GPC['comment_open'];
		$data['share_title']=$_GPC['share_title'];
		$data['share_desc']=$_GPC['share_desc'];
		$data['share_thumbnail']=$_GPC['share_thumbnail'];
		$data['news_sort']=$_GPC['news_sort'];
		$data['news_count']=$_GPC['screen_times'];
		$data['news_zan']=$_GPC['zan_count'];
		$data['uniacid']=$_W['uniacid'];
		$resut = pdo_update($news_table, $data, array('news_id'=>$id,'uniacid'=>$_W['uniacid']));
		if (!empty($resut)) {
				message('新闻修改成功！', $this->createWebUrl('news', array('op'=>'display')), 'success');
			} else {
				message('新闻修改失败！');
			}
	}

}
if($op=='delete'){
	$id = intval($_GPC['id']);
			if(empty($id)){
				message('未找到指定新闻！');
			}
			$result = pdo_delete($news_table, array('news_id'=>$id,'uniacid'=>$_W['uniacid']));
			if(intval($result) == 1){
				message('新闻删除成功！', $this->createWebUrl('news'), 'success');
			} else {
				message('新闻删除失败！');
			}
}
if($op == 'manage_comment'){
	$sql = 'SELECT o.comment_id,o.comment_username,o.comment_thumbnail,o.comment_content,a.news_title,a.uniacid FROM'.tablename($table_comment).'as o'.','.tablename($news_table).'as a WHERE a.news_id = o.comment_news_id AND a.uniacid = :uniacid ORDER BY o.comment_id desc';
	$params =array(':uniacid'=>$_W['uniacid']);
	$comment_results = pdo_fetchall($sql,$params);
}
if($op == 'dele_comment'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('未找到指定评论！');
	}
	$result = pdo_delete($table_comment, array('comment_id'=>$id,'uniacid'=>$_W['uniacid']));
	if($result){
		message('评论删除成功！', $this->createWebUrl('news',array('op'=>'manage_comment')), 'success');
	} else {
		message('评论删除失败！');
	}
}
include $this->template('web/news');