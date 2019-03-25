<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


$we7_file_permission = array();
$we7_file_permission = array(
	'account' => array(
		'default' => '',
		'direct' => array(
			'auth',
			'welcome',
		),
		'vice_founder' => array('account*'),
		'owner' => array('account*'),
		'manager' => array(
			'display',
			'manage',
			'post-step',
			'post-user',
		),
		'operator' => array(
			'display',
			'manage',
			'post-step',
		),
		'clerk' => array(
			'display',
		),
	),
	'advertisement' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array(),
		'owner' => array(),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array()
	),
	'article' => array(
		'default' => '',
		'direct' => array(
			'notice-show',
			'news-show',
		),
		'vice_founder' => array(),
		'owner' => array(),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array()
	),
	'message' => array(
		'default' => '',
		'direct' => array(
			'notice',
		),
		'vice_founder' => array(),
		'owner' => array(),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array()
	),
	'cloud' => array(
		'default' => 'touch',
		'direct' => array(
			'touch',
			'dock',
		),
		'vice_founder' => array(),
		'owner' => array(),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array()
	),
	'cron' => array(
		'default' => '',
		'direct' => array(
			'entry',
		),
		'vice_founder' => array(),
		'owner' => array(),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array()
	),
	'founder' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array(),
		'owner' => array(),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array()
	),
	'help' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('help*'),
		'owner' => array('help*'),
		'manager' => array('help*'),
		'operator' => array('help*'),
		'clerk' => array()
	),
	'home' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('home*'),
		'owner' => array('home*'),
		'manager' => array('home*'),
		'operator' => array('home*'),
		'clerk' => array('welcome'),
	),
	'mc' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('mc*'),
		'owner' => array('mc*'),
		'manager' => array(
			'chats',
			'fields',
			'group',
			'trade',
		),
		'operator' => array(
			'chats',
			'fields',
			'group',
			'trade',
		),
		'clerk' => array()
	),
	'module' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('module*'),
		'owner' => array(
			'manage-account',
			'manage-system',
			'permission',
			'display',
		),
		'manager' => array(
			'manage-account',
			'display',
		),
		'operator' => array(
			'manage-account',
			'display',
		),
		'clerk' => array(
			'display',
		)
	),
	'platform' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('platform*'),
		'owner' => array('platform*'),
		'manager' => array(
			'cover',
			'reply',
			'material'
		),
		'operator' => array(
			'cover',
			'reply',
			'material'
		),
		'clerk' => array(
			'reply',
			'cover',
			'material'
		)
	),
	'profile' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('profile*'),
		'owner' => array('profile*'),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array()
	),
	'site' => array(
		'default' => '',
		'direct' => array(
			'entry',
		),
		'vice_founder' => array('site*'),
		'owner' => array('site*'),
		'manager' => array(
			'editor',
			'article',
			'category',
			'style',
			'nav',
			'slide',
		),
		'operator' => array(
			'editor',
			'article',
			'category',
			'style',
			'nav',
			'slide',
		),
		'clerk' => array()
	),
	'statistics' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('statistics*'),
		'owner' => array('statistics*'),
		'manager' => array(),
		'operator' => array(),
		'clerk' => array(),
	),
	'store' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array(
			'goods-buyer',
			'orders',
		),
		'owner' => array(
			'goods-buyer',
			'orders',
		),
		'manager' => array(
			'goods-buyer',
			'orders',
		),
		'operator' => array(
			'goods-buyer',
			'orders',
		),
		'clerk' => array(),
	),
	'system' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array(
			'template',
			'updatecache',
			'workorder',
		),
		'owner' => array(
			'updatecache',
			'workorder',
		),
		'manager' => array(
			'updatecache',
			'workorder',
		),
		'operator' => array(
			'account',
			'updatecache',
			'workorder',
		),
		'clerk' => array(
			'workorder',
		)
	),
	'user' => array(
		'default' => 'display',
		'direct' => array(
			'login',
			'register',
			'logout',
			'find-password'
		),
		'vice_founder' => array('user*'),
		'owner' => array(
			'profile',
		),
		'manager' => array(
			'profile',
		),
		'operator' => array(
			'profile',
		),
		'clerk' => array(
			'profile',
		)
	),
	'wxapp' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('wxapp*'),
		'owner' => array('wxapp*'),
		'manager' => array(
			'display',
			'version',
			'post',
		),
		'operator' => array(
			'display',
			'version',
			'post',
		),
		'clerk' => array(
			'display',
		)
	),
	'utility' => array(
		'default' => '',
		'direct' => array(
			'verifycode',
			'code',
			'file',
			'bindcall',
			'subscribe',
			'wxcode',
			'modules',
			'link',
		),
		'vice_founder' => array(
			'user',
			'emulator',
		),
		'owner' => array(
			'emulator',
		),
		'manager' => array(
			'emulator',
		),
		'operator' => array(
			'emulator',
		)
	),
	'append' => array('append*'),
	'see_more_info' => array(
		'founder' => array(
			'see_module_manage_system_except_installed',
			'see_module_manage_system_ugrade',
			'see_module_manage_system_stop',
			'see_module_manage_system_install',
			'see_module_manage_system_shopinfo',
			'see_module_manage_system_info_edit',
			'see_module_manage_system_detailinfo',
			'see_module_manage_system_group_add',
			'see_account_manage_module_tpl_all_permission',
			'see_account_manage_sms_blance',
			'see_account_manage_users_edit',
			'see_account_manage_users_adduser',
			'see_account_manage_users_add_viceuser',
			'see_system_upgrade',
			'see_system_manage_clerk',
			'see_system_manage_user_setting',
			'see_system_manage_vice_founder',
			'see_system_add_vice_founder',
			'see_notice_post',
			'see_module_manage_system_newversion',
			'see_user_edit_base_founder_name'
		),
		'vice_founder' => array(
			'see_account_manage_users_adduser',
			'see_module_manage_system_group_add',
		),
		'owner' => array(

		),
		'manager' => array(

		),
		'operator' => array(

		),
	),
);

return $we7_file_permission;