<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "staff_common.php";

$urltk = $this->createMobileUrl('staff_ywlist');

$op = $_GPC['op'];

//分类列表-------------
$category = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and type = 'yw' ORDER BY listorder ASC, cid DESC", array(), 'cid');
if (!empty($category)) {
	$children = '';
	foreach ($category as $cid => $cate) {
		if (!empty($cate['pid'])) {
			$children[$cate['pid']][$cate['cid']] = array($cate['cid'], $cate['name']);
		}
	}
}

//修改为已阅读-------
$list_wyd = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_ywlist')." WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' and readt = '0' ORDER BY id DESC");
if (!empty($list_wyd)) {
	foreach ($list_wyd as &$row) {
		pdo_update('cwgl_service_ywlist', array('readt' => 1), array('id' => $row['id'],'weid' => $_W['uniacid']));
	}
}//----------------


//发送模板消息---------------------
require_once ('weixin.class.php');
$uniacid = $_W['uniacid'];

//获取公众号配置信息
$srdb = pdo_get('account_wechats', array('uniacid' => $uniacid));
$appid = $srdb['key'];
$appsecret = $srdb['secret'];
$access_token_odl = $srdb['access_token'];

//获取模版消息设置
$mb_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));
//----------------

if($op == "view"){
	
	//查看订单详情
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_ywlist', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//读取客户信息
	$kehu_show = pdo_fetchall("SELECT b.compname FROM ".tablename('mc_members')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE b.weid = '{$_W['uniacid']}' and b.uid = '{$srdb['uid']}'");
	
	//获取接单信息
	if($srdb['yguid']){
		$profile_t = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'uid' => $srdb['yguid']));
	}
	
	//读取订单进度
	$list_progress = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_ywlist_progress')." WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' and syid = '{$id}' ORDER BY dateline ASC,id ASC ");
	
	include $this->template('staff_ywlist_view');

}elseif($op == "accept"){
	
	//接受任务
	$id = intval($_GPC['id']);
	if (empty($id)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//获取
	$profile_tp = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'uid' => $_W['member']['uid']));
	$data = array(
		'ygid' => $profile_tp['ygid'],
		'yguid' => $profile_tp['uid']
	);
	pdo_update('cwgl_service_ywlist', $data, array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
	
	//发布模板消息--------------
	if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret)){

		$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
		
		//获取openid
		$user_uidt = pdo_get('cwgl_service_ywlist', array('id' => $_GPC['id'], 'weid' => $_W['uniacid']));
		$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $user_uidt['uid']));

		$first = "您好！您有个业务申请订单已被领取，快去查看吧！";

		$url = $_W['siteroot'] . "app/index.php?i=".$_GPC['i']."&c=".$_GPC['c']."&m=".$_GPC['m']."&do=user_ywlist&op=view&id=".$_GPC['id'];
		$keyword2 = date('Y-m-d H:i:s',time());
		$template = array(
			'touser'=> trim($user_openid['openid']),
			'template_id'=> trim($mb_config['mbid5']),    //模板的id
			'url'=> $url,
			'topcolor'=>"#FF0000",
			'data'=>array(
				'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),
				'keyword1'=>array('value'=>urlencode($_GPC['id']),'color'=>"#00008B"),    //订单号keyword1      
				'keyword2'=>array('value'=>urlencode($keyword2),'color'=>"#00008B"),    //接单时间keyword2     
				'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
			)
		);

		$data = urldecode(json_encode($template));
		$send_result = send_template_message($data,$access_token);
		
	}
	//------------------------
	
	message('接受成功！', $this->createMobileUrl('staff_ywlist', array('op' => 'view', 'id' => $id)), 'success');

}elseif($op == "add"){

	//发布进度----------------
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_ywlist', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//读取客户信息
	$usershow = pdo_get('cwgl_user_list', array('uid' => $srdb['uid'],'weid' => $_W['uniacid']));
	
	//获取接单信息
	$profile_t = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'uid' => $srdb['yguid']));
	
	//添加
	if(checksubmit('add_submit')){
		
		$datapp = array(
			'weid' => $_W['uniacid'],
			'ygid' => $profile_t['id'],
			'yguid' => $profile_t['uid'],
			'syid' => $id,
			'content' => $_GPC['content'],
			'dateline' => mktime()
		);
		
		$result = pdo_insert('cwgl_service_ywlist_progress', $datapp);
		
		if (!empty($result)) {
		
			//发布模板消息--------------
			if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret)){
		
				$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
				
				//获取openid
				$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $srdb['uid']));
		
				$first = "您好！您有个业务申请订单有最新进度，快去查看吧！";
		
				$url = $_W['siteroot'] . "app/index.php?i=".$_GPC['i']."&c=".$_GPC['c']."&m=".$_GPC['m']."&do=user_ywlist&op=view&id=".$_GPC['id'];
				$keyword2 = date('Y-m-d H:i:s',time());
				$template = array(
					'touser'=> trim($user_openid['openid']),
					'template_id'=> trim($mb_config['mbid3']),    //模板的id
					'url'=> $url,
					'topcolor'=>"#FF0000",
					'data'=>array(
						'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),
						'keyword1'=>array('value'=>urlencode("业务申请"),'color'=>"#00008B"),    //服务类型keyword1      
						'keyword2'=>array('value'=>urlencode($_GPC['content']),'color'=>"#00008B"),    //服务进度keyword2
						'keyword3'=>array('value'=>urlencode($profile_t['name']),'color'=>"#00008B"),    //服务人员keyword3      
						'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
					)
				);
		
				$data = urldecode(json_encode($template));
				$send_result = send_template_message($data,$access_token);
				
			}
			//------------------------
			message('添加成功！', $this->createMobileUrl('staff_ywlist', array('op' => 'view', 'id' => $id)), 'success');
		}else{
			message('添加失败！', $this->createMobileUrl('staff_ywlist', array('op' => 'add', 'id' => $id)), 'success');
		}
		
	}
	
	include $this->template('staff_ywlist_add');	
	
}elseif($op == "succeed"){
	
	//确认完成
	$id = intval($_GPC['id']);
	if (empty($id)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//存入
	pdo_update('cwgl_service_ywlist', array('succeed' => 1), array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
	
	message('操作成功！', $urltk, 'success');
		
}elseif($op == "progress"){
	
	//业务进度管理
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_ywlist', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//读取客户信息
	$usershow = pdo_get('cwgl_user_list', array('uid' => $srdb['uid'],'weid' => $_W['uniacid']));
	
	//读取订单进度
	$list_progress = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_ywlist_progress')." WHERE weid = '{$_W['uniacid']}' and yguid = '{$_W['member']['uid']}' and syid = '{$id}' ORDER BY dateline ASC,id ASC ");
	
	include $this->template('staff_ywlist_progress');
		
}else{

	//列表-------------------------
	//排序
	$ordersc = array($_GPC['ordersc']=>' selected');
	if($_GPC['ordersc']){
		$ordersql = "ORDER BY a.id ".$_GPC['ordersc'];
	}else{
		$ordersql = "ORDER BY a.id DESC";
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
	if(!in_array($psize, array(20,50,100))) $psize = 20;
	$perpages = array($psize => ' selected');
	
	$where = '';
	
	if ($_GPC['type']==1) {
		$where .= " and a.yguid = '{$_W['member']['uid']}' and a.succeed = '0'";
	}elseif($_GPC['type']==2){
		$where .= " and a.yguid = '{$_W['member']['uid']}' and a.succeed = '1'";
	}else{
		$where .= " and a.yguid = '0'";
	}
	
	if (!empty($_GPC['keyword'])) {
		$where .= " AND ( (b.compname LIKE '%{$_GPC['keyword']}%') OR (a.content LIKE '%{$_GPC['keyword']}%') )";
	}
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_ywlist')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE a.weid = '{$_W['uniacid']}' {$where}");
	if($total){
		$list = pdo_fetchall("SELECT a.*,b.compname FROM ".tablename('cwgl_service_ywlist')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid WHERE a.weid = '{$_W['uniacid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	}
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
		
	include $this->template('staff_ywlist');

}