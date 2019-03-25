<?php 
global $_W,$_GPC;
$table_name = 'imeepos_news';
$table_zan = 'imeepos_zan_collect';
$id = intval($_GPC['id']);
$sql = ' SELECT news_zan FROM '.tablename($table_name).' WHERE news_id =:id AND uniacid = :uniacid ';
$params=array(
	':id'=>$id,
	':uniacid' =>$_W['uniacid']
	);
$result = pdo_fetch($sql,$params);
$ajax_return =array();
if(!empty($id)){
	$sql = 'SELECT zc_z_status FROM '.tablename($table_zan).'WHERE zc_news_id = :id AND zc_openid = :openid AND uniacid = :uniacid ';
	$params =array(
		':id' => $id,
		':openid' =>$_W['fans']['openid'],
		':uniacid' =>$_W['uniacid']
	);
	$zan_result = pdo_fetch($sql,$params);

	if ($zan_result['zc_z_status'] === null) {
		$data['zc_news_id'] = $id;
		$data['zc_z_status'] = 1;
		$data['zc_openid'] = $_W['fans']['openid'];
		$data['uniacid'] = $_W['uniacid'];
		$row = pdo_insert($table_zan, $data);
		$ret = pdo_update($table_name, array('news_zan'=> $result['news_zan'] + 1), array('news_id'=>$id,'uniacid' =>$_W['uniacid']));
		if($row){
			$ajax_return['erro'] = 0;
			$ajax_return['message'] = '赞成功！';
			$ajax_return['status'] = 1;
		};
		die(json_encode($ajax_return));
	} elseif ($zan_result['zc_z_status'] === 0){
		$ret = pdo_update($table_name, array('news_zan'=> $result['news_zan'] + 1), array('news_id'=>$id,'uniacid' =>$_W['uniacid']));
		pdo_update($table_zan, array('zc_z_status'=>1), array('zc_news_id'=> $id,'zc_openid'=>$_W['fans']['openid'],'uniacid' =>$_W['uniacid']));
		if($ret){
			$ajax_return['erro'] = 0;
			$ajax_return['message'] = '赞成功！';
		};
		die(json_encode($row));
	} elseif ($zan_result['zc_z_status'] == 1){

		 $ajax_return['erro'] = 0;
		 $ajax_return['status'] = 2;
		 $ajax_return['message'] = '你已经赞过了！';
		 die(json_encode($ajax_return)); 
	};
		
};

