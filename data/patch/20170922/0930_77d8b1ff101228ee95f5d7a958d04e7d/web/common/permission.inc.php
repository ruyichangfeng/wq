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
			'display',
			'auth',
			'welcome', 'openwechat'
		),
		'vice_founder' => array('account*'),
		'owner' => array('account*'),
		'manager' => array(
			'manage',
			'post-step',
		),
		'operator' => array(
			'manage',
			'post-step',
		),
		'clerk' => array()
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
		'direct' => array(
			'display',
		),
		'vice_founder' => array('module*'),
		'owner' => array(
			'manage-account',
			'manage-system',
			'permission',
		),
		'manager' => array(
			'manage-account',
		),
		'operator' => array(
			'manage-account',
		),
		'clerk' => array()
	),
	'platform' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('platform*'),
		'owner' => array('platform*'),
		'manager' => array(
			'cover',
			'reply',
			'material-post',
		),
		'operator' => array(
			'cover',
			'reply',
			'material-post',
		),
		'clerk' => array(
			'reply',
			'cover',
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
		'clerk' => array(
			'entry',
		)
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
		),
		'owner' => array(
			'updatecache',
		),
		'manager' => array(
			'updatecache',
		),
		'operator' => array(
			'account',
			'updatecache',
		),
		'clerk' => array()
	),
	'user' => array(
		'default' => 'display',
		'direct' => array(
			'login',
			'register',
			'logout',
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
		'clerk' => array()
	),
	'wxapp' => array(
		'default' => '',
		'direct' => array(),
		'vice_founder' => array('wxapp*'),
		'owner' => array('wxapp*'),
		'manager' => array(
			'display',
			'version',
			'post'
		),
		'operator' => array(
			'display',
			'version',
			'post'
		),
		'clerk' => array()
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
			'user'
		),
		'owner' => array(),
		'manager' => array(),
		'operator' => array(),
	),
	'append' => array('append*'),
);

return $we7_file_permission;