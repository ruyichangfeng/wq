<?php
global $_W,$_GPC;
$table_name = 'imeepos_news_comment';
$id = intval($_GPC['id']);
$ajax_return =array();
if (empty($_W['fans']['nickname'])) {
	mc_oauth_userinfo();
}
if(!empty($id)){
	$data['comment_news_id'] = $_GPC['id'];
	$data['comment_username'] = $_GPC['username'];
	$data['comment_thumbnail'] = $_GPC['thumbnail'];
	$data['comment_date'] = date('Y-m-j');
	$data['comment_content'] = $_GPC['content'];
	$data['uniacid']=$_W['uniacid'];

	$row = pdo_insert($table_name,$data);
	if($row){
		$ajax_return['erro'] = 0;
		$ajax_return['message'] = '评论成功！';
	}else{
		$ajax_return['erro'] = 1;
		$ajax_return['message'] = '评论失败！';
	}

}
die(json_encode($ajax_return));
