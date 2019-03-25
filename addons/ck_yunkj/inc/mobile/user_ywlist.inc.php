<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

//判断是否是注册会员
if($user_show['type']!=1){
	message('抱歉！您还未成为正式会员不能享用该功能！如有需要该服务快去购买吧！', $this->createMobileUrl('user_payofficial'), 'error');
}

$urltk = $this->createMobileUrl('user_ywlist');

//附件上传文件地址
$url_attachment = $this->createMobileUrl('attachment');

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

if($op == "add"){
	
	//发布申请-------
	if(checksubmit('add_submit')){
	
		if (empty ($_GPC['endtimes'])) {
			message('请选择要求办结时间！');
		}
		if (empty ($_GPC['content'])) {
			message('业务描述不能为空！');
		}
	
		$data = array(
			'weid' => $_W['uniacid'],
			'uid' => $_W['member']['uid'],
			'type' => $_GPC['type'],
			'endtimes' => $_GPC['endtimes'],
			'urgency' => $_GPC['urgency'],
			'content' => $_GPC['content'],
			'download' => $_GPC['download'],
			'dateline' => mktime()
		);
		
		 $result = pdo_insert('cwgl_service_ywlist', $data);
		
		 if (!empty($result)) {
			$idd = pdo_insertid();
			
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
				
			//发布模板消息-----------
			if(!empty($mb_config['mb_open']) && !empty($appid) && !empty($appsecret) && !empty($user_show['yguid'])){

				$access_token = moban($appid,$appsecret,$access_token_odl,$uniacid);
				
				//获取openid
				$user_openid = pdo_get('mc_mapping_fans', array('uniacid' => $_W['uniacid'],'uid' => $user_show['yguid']));
		
				$first = "您好！有个新申请业务订单，快去查看吧！";

				$url = $_W['siteroot'] . "app/index.php?i=".$_GPC['i']."&c=".$_GPC['c']."&m=".$_GPC['m']."&do=staff_ywlist";
				$tradeDateTime = date('Y-m-d H:i:s',time());
				$template = array(
					'touser'=> trim($user_openid['openid']),
					'template_id'=> trim($mb_config['mbid4']),    //模板的id
					'url'=> $url,
					'topcolor'=>"#FF0000",
					'data'=>array(
						'first'=>array('value'=>urlencode($first),'color'=>"#00008B"),
						'tradeDateTime'=>array('value'=>urlencode($tradeDateTime),'color'=>"#00008B"),    //提交时间tradeDateTime      
						'orderType'=>array('value'=>urlencode("申请业务"),'color'=>"#00008B"),    //订单类型orderType     
						'customerInfo'=>array('value'=>urlencode($user_show['compname']),'color'=>'#00008B'),        //客户信息customerInfo
						'remark'=>array('value'=>urlencode("如有问题请尽快联系管理员！"),'color'=>'#00008B'),
					)
				);
		
				$data = urldecode(json_encode($template));
				$send_result = send_template_message($data,$access_token);

				
			}
			//----------------
			
			message('保存成功', $urltk, 'success');
		 }else{
			message('添加失败', $urltk."&op=add", 'success');
		 }

	}//--------------
	
	include $this->template('user_ywlist_add');
	
}elseif($op == "view"){
	
	//查看订单详情
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_ywlist', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//获取接单信息
	$profile_t = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'uid' => $srdb['yguid']));
	
	//读取订单进度
	$list_progress = pdo_fetchall("SELECT * FROM ".tablename('cwgl_service_ywlist_progress')." WHERE weid = '{$_W['uniacid']}' and syid = '{$id}' ORDER BY dateline ASC,id ASC ");
	
	include $this->template('user_ywlist_view');

}elseif($op == "wypj"){
	
	//评价订单
	$id = intval($_GPC['id']);
	$srdb = pdo_get('cwgl_service_ywlist', array('id' => $id));
	if (empty($srdb)) {
		message('不存在或是已经被删除！', $urltk, 'success');
	}
	
	//获取接单信息
	$profile_t = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'uid' => $srdb['yguid']));
	
	//添加
	if(checksubmit('save_submit')){
		
		$data = array(
			'weid' => $_W['uniacid'],
			'uid' => $_W['member']['uid'],
			'ygid' => $profile_t['id'],
			'yguid' => $profile_t['uid'],
			'pfscore' => intval($_GPC['pfscore']),
			'fwattitude' => intval($_GPC['fwattitude']),
			'fwspeed' => intval($_GPC['fwspeed']),
			'content' => $_GPC['content'],
			'dateline' => mktime()
		);
		
		$result = pdo_insert('cwgl_staff_bpf', $data);
		
		if (!empty($result)) {
			//修改评价状态
	        pdo_update('cwgl_service_ywlist', array('sfpj' => 1), array('id' => $id,'weid' => $_W['uniacid']));
			message('评价成功！', $urltk, 'success');
		}else{
			message('评价失败！', $urltk, 'success');
		}
		
	}
	
	include $this->template('user_ywlist_wypj');
		
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
		$where .= " and a.yguid != '0' and a.succeed = '0'";
	}elseif($_GPC['type']==2){
		$where .= " and a.yguid != '0' and a.succeed = '1'";
	}else{
		$where .= " and a.yguid = '0' ";
	}
	
	if (!empty($_GPC['keyword'])) {
		$where .= " AND ( (b.compname LIKE '%{$_GPC['keyword']}%') OR (a.content LIKE '%{$_GPC['keyword']}%') )";
	}
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_service_ywlist')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid  WHERE a.weid = '{$_W['uniacid']}' and a.uid = '{$_W['member']['uid']}' {$where}");
	if($total){
		$list = pdo_fetchall("SELECT a.*,b.compname FROM ".tablename('cwgl_service_ywlist')." AS a LEFT JOIN ".tablename('cwgl_user_list')." AS b on a.uid=b.uid WHERE a.weid = '{$_W['uniacid']}' and a.uid = '{$_W['member']['uid']}' {$where} {$ordersql} LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	}
	$pager = pagination($total, $pindex, $psize,'', array('before' => 0, 'after' => 0));
		
	include $this->template('user_ywlist');

}