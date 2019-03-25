<?php
/**
 * 模块微站定义
 *
 * @author wujinxin
 * @url http://bbs.we7.cc/
 **/
defined('IN_IA') or exit('Access Denied');

global $_W, $_GPC;

require "public.php";
require "admin_common.php";

load()->func('tpl');
$op = $_GPC['op'];

$uid = $_GPC['uid'];
$idt = $_GPC['idt'];
if (empty($uid)) {
	message('抱歉！UID值为空不能访问！', $this->createMobileUrl('admin_userlist',array('op' => 'view','id' => $idt)), 'error');
}

$urlt = $this->createMobileUrl('admin_userlist_paycost')."&uid=".$_GPC['uid']."&idt=".$idt;

$newtimes =  mktime();

//获取客户信息
$usershow = pdo_get('mc_members', array('uid' => $uid));
$usershow2 = pdo_get('cwgl_user_list', array('uid' => $uid));

require_once ('weixin.class.php');

//添加
if(checksubmit('add_submit')){

	 if(empty($_GPC['titlename'])){
		message('催费名称不能为空！');
	}
	
	$datapp = array(
		'weid' => $_W['uniacid'],
		'uid' => $uid,
		'type' => $_GPC['type'],
		'titlename' => $_GPC['titlename'],
		'message' => $_GPC['message']
	);
	
	if($_GPC['type']){
		$datapp['paymoney'] = $_GPC['paymoney2'];
	}else{
		$datapp['paymoney'] = $_GPC['paymoney'];
	}
	
	if(empty($datapp['paymoney'])){
		message('支付金额不能为空！');
	}
	
	//发送模板消息---------------------
	$uniacid = $_W['uniacid'];
	
	//获取公众号配置信息
	$srdb = pdo_get('account_wechats', array('uniacid' => $uniacid));
	$appid = $srdb['key'];
	$appsecret = $srdb['secret'];
	$access_token_odl = $srdb['access_token'];
	
	//获取模版消息设置
	$mb_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));
	if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret)){
	
		$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
		
		//获取openid
		$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $uid));
		$first = "您好！您有新的欠费信息，请尽快参看并支付！";
		if($_GPC['type']){
			$keyword1 = $datapp['paymoney']."元/月";
		}else{
			$keyword1 = $datapp['paymoney']."元";
		}
		
		$url = $_W['siteroot'] . "app/index.php?i=".$_W['uniacid']."&c=".$_GPC['c']."&m=".$_GPC['m']."&do=user_paycost";
		
		$newstime = date('Y-m-d H:i:s',time());
		$template = array(
			'touser'=> trim($user_openid['openid']),
			'template_id'=> trim($mb_config['mbid1']),    //模板的id
			'url'=> $url,
			'topcolor'=>"#FF0000",
			'data'=>array(
				'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),    
				'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#00008B"),    //缴费金额keyword1     
				'keyword2'=>array('value'=>urlencode($newstime),'color'=>'#00008B'),        //缴费时间keyword2
				'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
			)
		);

		$data = urldecode(json_encode($template));
		$send_result = send_template_message($data,$access_token);
	}
	//---------------------
	
	$datapp['dateline'] =  mktime();
	
	 $result = pdo_insert('cwgl_user_paycost', $datapp);
	
	 if (!empty($result)) {
		$idd = pdo_insertid();
		
		//发布通知-----------
		$datat = array(
			'weid' => $_W['uniacid'],
			'uid' => $uid,
			'type' => 'owe',
			'pid' => $idd,
			'dateline' => mktime()
		);
		
		$datat['message'] = "您有新的欠费消息！需要支付 ".$data['paymoney']." 元。";
		pdo_insert('cwgl_notice', $datat);
		//------------------
		
		message('保存成功', $urlt, 'success');
	 }else{
		message('添加失败', $urlt, 'error');
	 }
	 
}

//修改
if(checksubmit('edit_submit')){
	
	if(empty($_GPC['titlename'])){
		message('催费名称不能为空！');
	}
	
	$datapp = array(
		'weid' => $_W['uniacid'],
		'uid' => $uid,
		'type' => $_GPC['type'],
		'titlename' => $_GPC['titlename'],
		'message' => $_GPC['message']
	);
	
	if($_GPC['type']){
		$datapp['paymoney'] = $_GPC['paymoney2'];
	}else{
		$datapp['paymoney'] = $_GPC['paymoney'];
	}
	
	if(empty($datapp['paymoney'])){
		message('支付金额不能为空！');
	}
	
	//发送模板消息---------------------
	$uniacid = $_W['uniacid'];
	
	//获取公众号配置信息
	$srdb = pdo_get('account_wechats', array('uniacid' => $uniacid));
	$appid = $srdb['key'];
	$appsecret = $srdb['secret'];
	$access_token_odl = $srdb['access_token'];
	
	//获取模版消息设置
	$mb_config = pdo_get('cwgl_config', array('weid' => $_W['uniacid']));
	if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret)){
	
		$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
		
		//获取openid
		$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $uid));
		$first = "您好！您有新的欠费信息，请尽快参看并支付！";
		if($_GPC['type']){
			$keyword1 = $datapp['paymoney']."元/月";
		}else{
			$keyword1 = $datapp['paymoney']."元";
		}
		
		$url = $_W['siteroot'] . "app/index.php?i=".$_W['uniacid']."&c=".$_GPC['c']."&m=".$_GPC['m']."&do=user_paycost";
		
		$newstime = date('Y-m-d H:i:s',time());
		$template = array(
			'touser'=> trim($user_openid['openid']),
			'template_id'=> trim($mb_config['mbid1']),    //模板的id
			'url'=> $url,
			'topcolor'=>"#FF0000",
			'data'=>array(
				'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),    
				'keyword1'=>array('value'=>urlencode($keyword1),'color'=>"#00008B"),    //缴费金额keyword1     
				'keyword2'=>array('value'=>urlencode($newstime),'color'=>'#00008B'),        //缴费时间keyword2
				'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
			)
		);

		$data = urldecode(json_encode($template));
		$send_result = send_template_message($data,$access_token);
	}
	//---------------------
	
	$datapp['dateline'] =  mktime();
	
	if(!empty($_GPC['id'])){
		
		//发布通知-----------
		$datat = array(
			'weid' => $_W['uniacid'],
			'uid' => $uid,
			'type' => 'owe',
			'pid' => $_GPC['id'],
			'dateline' => mktime()
		);
		
		$datat['message'] = "您有新的欠费消息！需要支付 ".$datapp['paymoney']." 元。";
		pdo_insert('cwgl_notice', $datat);
		//------------------
		
		pdo_update('cwgl_user_paycost', $datapp, array('id' => $_GPC['id'],'weid' => $_W['uniacid']));
		message('修改成功！', $urlt, 'success');
		
	}else{
		message('修改失败！', $urlt, 'error');
	}
	
}

if($op == 'add'){
	include $this->template('admin_userlist_paycost_add');
}elseif($op == 'edit'){
	
	//读取
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_user_paycost', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urlt, 'success');
	}
	
	include $this->template('admin_userlist_paycost_add');
		
}elseif($op == 'delete'){
	//删除---------------
	$id = intval($_GPC['id']);
	if($id){
		pdo_delete('cwgl_user_paycost', array('id' => $id));
		message('删除成功', $urlt, 'success');
	}else{
		message('删除失败', $urlt, 'error');
	}
	
}else{
	
	//列表-------------------------
	//排序
	$ordersc = array($_GPC['ordersc']=>' selected');
	if($_GPC['ordersc']){
		$ordersql = "ORDER BY id ".$_GPC['ordersc'];
	}else{
		$ordersql = "ORDER BY id DESC";
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = empty($_GPC['psize'])?0:intval($_GPC['psize']);
	if(!in_array($psize, array(20,50,100))) $psize = 20;
	$perpages = array($psize => ' selected');
	
	$where = '';
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_user_paycost')." WHERE weid = '{$_W['uniacid']}' and uid = '{$uid}' {$where}");
	if($total){
		$list = pdo_fetchall("SELECT * FROM ".tablename('cwgl_user_paycost')." WHERE weid = '{$_W['uniacid']}' and uid = '{$uid}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	}
	
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
	
	include $this->template('admin_userlist_paycost');

}
?>