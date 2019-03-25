<?php
global $_GPC,$_W;
// 口令校验
// baidu key
if($_GPC['dataType'] == 'baidu_key')
{
	if(!$_GPC['baidu_key'])
	{
		echoJson(array('res'=>'101','msg'=>'param error'));
	}
	$n = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_setting')." where name='baidu_key' and uniacid={$_W['uniacid']}");
	if($n['num'])
	{
		$info = pdo_update("intelligent_kindergarten_setting",array('value'=>$_GPC['baidu_key']),array('name'=>'baidu_key','uniacid'=>$_W['uniacid']));
		if($info !== false)
		{
			echoJson(array('res'=>'100','msg'=>'success'));
		}
		else
		{
			echoJson(array('res'=>'102','msg'=>'update error'));
		}
	}
	else
	{
		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['name'] = 'baidu_key';
		$data['value'] = $_GPC['baidu_key'];
		$data['add_time'] = date("Y-m-d H:i:s");

		$info = pdo_insert("intelligent_kindergarten_setting",$data,array('name'=>'baidu_key'));
		if($info)
		{
			echoJson(array('res'=>'100','msg'=>'success'));
		}
		else
		{
			echoJson(array('res'=>'103','msg'=>'insert error'));
		}
	}
}
// appid 
if($_GPC['dataType'] == 'oauth') 
{
	if(!$_GPC['oauth_appid'] || !$_GPC['oauth_appsecret'])
	{
		echoJson(array('res'=>'102','msg'=>'param error'));
	}


	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'oauth_appid','uniacid'=>$_W['uniacid']));
	$r2 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'oauth_appsecret','uniacid'=>$_W['uniacid']));
	if($r1 === false || $r2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}

	
	$data_appid = array();
	$data_appid['uniacid'] = $_W['uniacid'];
	$data_appid['name'] = 'oauth_appid';
	$data_appid['value'] = $_GPC['oauth_appid'];
	$data_appid['add_time'] = date("Y-m-d H:i:s");
	$info_appid = pdo_insert("intelligent_kindergarten_setting",$data_appid);

	$data_appsecret = array();
	$data_appsecret['uniacid'] = $_W['uniacid'];
	$data_appsecret['name'] = 'oauth_appsecret';
	$data_appsecret['value'] = $_GPC['oauth_appsecret'];
	$data_appsecret['add_time'] = date("Y-m-d H:i:s");
	$info_appsecret = pdo_insert("intelligent_kindergarten_setting",$data_appsecret);

	if($info_appid === false || $info_appsecret === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 借用开关
if($_GPC['dataType'] == 'opengetuserinfo')
{
	if($_GPC['opengetuserinfo'] != 'open' && $_GPC['opengetuserinfo'] != 'close')
	{
		echoJson(array('res'=>'101','msg'=>'error'));
	}


	pdo_begin();

	$r = pdo_delete('intelligent_kindergarten_setting',array('name'=>'opengetuserinfo','uniacid'=>$_W['uniacid']));
	if($r === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}

	
	$data_key = array();
	$data_key['uniacid'] = $_W['uniacid'];
	$data_key['name'] = 'opengetuserinfo';
	$data_key['value'] = $_GPC['opengetuserinfo'];
	$data_key['add_time'] = date("Y-m-d H:i:s");
	$info_key = pdo_insert("intelligent_kindergarten_setting",$data_key);

	if($info_key === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}
}

// 七牛开关
if($_GPC['dataType'] == 'qiniuallow')
{
	if($_GPC['qiniuallow'] != 'open' && $_GPC['qiniuallow'] != 'close')
	{
		echoJson(array('res'=>'101','msg'=>'error'));
	}


	pdo_begin();

	$r = pdo_delete('intelligent_kindergarten_setting',array('name'=>'qiniuallow','uniacid'=>$_W['uniacid']));
	if($r === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}

	
	$data_key = array();
	$data_key['uniacid'] = $_W['uniacid'];
	$data_key['name'] = 'qiniuallow';
	$data_key['value'] = $_GPC['qiniuallow'];
	$data_key['add_time'] = date("Y-m-d H:i:s");
	$info_key = pdo_insert("intelligent_kindergarten_setting",$data_key);

	if($info_key === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}
}
// 七牛aksk
if($_GPC['dataType'] == 'qiniu_info') 
{
	if(!$_GPC['qiniu_ak'] || !$_GPC['qiniu_sk'] || !$_GPC['qiniu_bucket'] || !$_GPC['qiniu_domain'])
	{
		echoJson(array('res'=>'102','msg'=>'请填写完整信息ak,sk,bucket'));
	}


	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'qiniu_ak','uniacid'=>$_W['uniacid']));
	$r2 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'qiniu_sk','uniacid'=>$_W['uniacid']));
	$r3 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'qiniu_bucket','uniacid'=>$_W['uniacid']));
	$r4 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'qiniu_domain','uniacid'=>$_W['uniacid']));
	if($r1 === false || $r2 === false || $r3 ===false || $r4 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}

	$data_ak = array();
	$data_ak['uniacid'] = $_W['uniacid'];
	$data_ak['name'] = 'qiniu_ak';
	$data_ak['value'] = $_GPC['qiniu_ak'];
	$data_ak['add_time'] = date("Y-m-d H:i:s");
	$info_ak = pdo_insert("intelligent_kindergarten_setting",$data_ak);

	$data_sk = array();
	$data_sk['uniacid'] = $_W['uniacid'];
	$data_sk['name'] = 'qiniu_sk';
	$data_sk['value'] = $_GPC['qiniu_sk'];
	$data_sk['add_time'] = date("Y-m-d H:i:s");
	$info_sk = pdo_insert("intelligent_kindergarten_setting",$data_sk);

	$data_bucket = array();
	$data_bucket['uniacid'] = $_W['uniacid'];
	$data_bucket['name'] = 'qiniu_bucket';
	$data_bucket['value'] = $_GPC['qiniu_bucket'];
	$data_bucket['add_time'] = date("Y-m-d H:i:s");
	$info_bucket = pdo_insert("intelligent_kindergarten_setting",$data_bucket);

	$data_domain = array();
	$data_domain['uniacid'] = $_W['uniacid'];
	$data_domain['name'] = 'qiniu_domain';
	$data_domain['value'] = $_GPC['qiniu_domain'];
	$data_domain['add_time'] = date("Y-m-d H:i:s");
	$info_domain = pdo_insert("intelligent_kindergarten_setting",$data_domain);

	if($info_ak === false || $info_sk === false || $info_bucket == false || $info_domain ===false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}
}

// 模板ID配置
if($_GPC['dataType'] == 'notice_id') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'notice_approve_tpl_id','uniacid'=>$_W['uniacid']));

	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}

	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'notice_approve_tpl_id';
	$data_1['value'] = $_GPC['notice_approve_tpl_id'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false )
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 模板格式
if($_GPC['dataType'] == 'notice_tpl') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'notice_first','uniacid'=>$_W['uniacid']));
	$r2 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'notice_remark','uniacid'=>$_W['uniacid']));
	if($r1 === false || $r2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'notice_first';
	$data_1['value'] = $_GPC['notice_first'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	$data_2 = array();
	$data_2['uniacid'] = $_W['uniacid'];
	$data_2['name'] = 'notice_remark';
	$data_2['value'] = $_GPC['notice_remark'];
	$data_2['add_time'] = date("Y-m-d H:i:s");
	$info_2 = pdo_insert("intelligent_kindergarten_setting",$data_2);

	if($info_1 === false || $info_2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}



// 模板开关
if($_GPC['dataType'] == 'notice_key') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'notice_key','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'notice_key';
	$data_1['value'] = $_GPC['setval'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 分享设置
if($_GPC['dataType'] == 'share_info') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'share_title','uniacid'=>$_W['uniacid']));
	$r2 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'share_content','uniacid'=>$_W['uniacid']));
	if($r1 === false || $r2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'share_title';
	$data_1['value'] = $_GPC['share_title'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	$data_2 = array();
	$data_2['uniacid'] = $_W['uniacid'];
	$data_2['name'] = 'share_content';
	$data_2['value'] = $_GPC['share_content'];
	$data_2['add_time'] = date("Y-m-d H:i:s");
	$info_2 = pdo_insert("intelligent_kindergarten_setting",$data_2);

	if($info_1 === false || $info_2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 模块主标题自定义
if($_GPC['dataType'] == 'super_title_set') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'super_title','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'super_title';
	$data_1['value'] = $_GPC['super_title'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}


// 过滤器开关
if($_GPC['dataType'] == 'filter') 
{
	if(!$_W['isfounder'])
	{
		echoJson(array('res'=>'111','msg'=>'无权限！请联系站长管理员'));
	}
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'filter','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'filter';
	$data_1['value'] = $_GPC['setval'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}


// 非法词汇保存
if($_GPC['dataType'] == 'filter_content') 
{
	$words = $_GPC['filter_content'];
	if(!$_GPC['filter_content'])
	{
		echoJson(array('res'=>'101','msg'=>'不能为空'));
	}
	// 过滤空格
	$words_list = explode('，', $words);
	foreach ($words_list as $key => $value) 
	{
		if(!$value)
		{
			unset($words_list[$key]);
		}
	}

	$words = join('，',$words_list);


	$path = dirname(dirname(dirname(__FILE__)))."/core/exception/config/filter.inc";
	clearstatcache();
	if(!is_writable($path))
	{
		echoJson(array('res'=>'101','msg'=>'请确认'.$path.'文件权限为可写入'));
	}
	$h = fopen($path, 'w');
	$r = fwrite($h, $words);
	if($r) 
	{
		echoJson(array('res'=>'100','msg'=>'success'));
	}
	echoJson(array('res'=>'102','msg'=>'写入数据失败'));
}


// 分享积分开关控制
if($_GPC['dataType'] == 'signin_key') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'signin_key','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'signin_key';
	$data_1['value'] = $_GPC['setval'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 签到积分数量控制
if($_GPC['dataType'] == 'signin_credit_save') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'signin_credit','uniacid'=>$_W['uniacid']));
	$r2 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'signin_credit_grow','uniacid'=>$_W['uniacid']));
	if($r1 === false || $r2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'signin_credit';
	$data_1['value'] = $_GPC['signin_credit'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	$data_2 = array();
	$data_2['uniacid'] = $_W['uniacid'];
	$data_2['name'] = 'signin_credit_grow';
	$data_2['value'] = $_GPC['signin_credit_grow'];
	$data_2['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_2);

	if($info_1 === false || $info_2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}
}


// 首页滚动公告设置
if($_GPC['dataType'] == 'public_notice') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'public_notice','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'public_notice';
	$data_1['value'] = $_GPC['public_notice'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}



// 审核模板ID保存
if($_GPC['dataType'] == 'approve_id') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'approve_tpl_id','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'approve_tpl_id';
	$data_1['value'] = $_GPC['approve_tpl_id'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 审核的提醒间隔时间
if($_GPC['dataType'] == 'notice_time') 
{


	$notice_time = $_GPC['notice_time'];
	if(!is_numeric($notice_time))
	{
		echoJson(array('res'=>'102','msg'=>'只能填写数字'));
	}

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'notice_time','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'notice_time';
	$data_1['value'] = $notice_time;
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}


// 会员的开通积分设置
if($_GPC['dataType'] == 'vip_credit') 
{


	$vip_credit_month_1 = abs($_GPC['vip_credit_month_1']);
	if(!is_numeric($vip_credit_month_1))
	{
		echoJson(array('res'=>'102','msg'=>'只能填写数字'));
	}

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'vip_credit_month_1','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'vip_credit_month_1';
	$data_1['value'] = $vip_credit_month_1;
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}


// 首页积分跳转链接自定义
if($_GPC['dataType'] == 'index_credit_jump_url') 
{

	$index_credit_jump_url = $_GPC['index_credit_jump_url'];

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'index_credit_jump_url','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'index_credit_jump_url';
	$data_1['value'] = $index_credit_jump_url;
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 底部菜单返回主页自定义
if($_GPC['dataType'] == 'menu_fhzy_jump_url') 
{

	$menu_fhzy_jump_url = $_GPC['menu_fhzy_jump_url'];

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'menu_fhzy_jump_url','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'menu_fhzy_jump_url';
	$data_1['value'] = $menu_fhzy_jump_url;
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}

// 签到积分数量控制
if($_GPC['dataType'] == 'hall_tag') 
{
	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'hall_tag_1','uniacid'=>$_W['uniacid']));
	$r2 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'hall_tag_2','uniacid'=>$_W['uniacid']));
	if($r1 === false || $r2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'hall_tag_1';
	$data_1['value'] = $_GPC['hall_tag_1'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	$data_2 = array();
	$data_2['uniacid'] = $_W['uniacid'];
	$data_2['name'] = 'hall_tag_2';
	$data_2['value'] = $_GPC['hall_tag_2'];
	$data_2['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_2);

	if($info_1 === false || $info_2 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}
}


// 机器人开关
if($_GPC['dataType'] == 'robot_key') 
{
	$robot_key = $_GPC['robot_key'];

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'robot_key','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'robot_key';
	$data_1['value'] = $_GPC['setval'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}
// 机器人频率
if($_GPC['dataType'] == 'robot_rate') 
{
	$robot_rate = $_GPC['robot_rate'];

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'robot_rate','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'robot_rate';
	$data_1['value'] = $_GPC['robot_rate'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}
// 机器人地址
if($_GPC['dataType'] == 'robot_url') 
{
	$robot_url = $_GPC['robot_url'];

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'robot_url','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'robot_url';
	$data_1['value'] = $_GPC['robot_url'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}
// 超级群发地址自定义
if($_GPC['dataType'] == 'multi_send_url') 
{
	$multi_send_url = $_GPC['multi_send_url'];

	pdo_begin();

	$r1 = pdo_delete('intelligent_kindergarten_setting',array('name'=>'multi_send_url','uniacid'=>$_W['uniacid']));
	if($r1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'初始化数据失败'));
	}
	
	$data_1 = array();
	$data_1['uniacid'] = $_W['uniacid'];
	$data_1['name'] = 'multi_send_url';
	$data_1['value'] = $_GPC['multi_send_url'];
	$data_1['add_time'] = date("Y-m-d H:i:s");
	$info_1 = pdo_insert("intelligent_kindergarten_setting",$data_1);

	if($info_1 === false)
	{
		pdo_rollback();
		echoJson(array('res'=>'102','msg'=>'写入数据失败'));
	}
	else
	{
		pdo_commit();
		echoJson(array('res'=>'100','msg'=>'insert success'));
	}

}
