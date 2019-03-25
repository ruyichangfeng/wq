<?php
defined('IN_IA') or exit('Access Denied');
	isetcookie('__uniacid', '', -7 * 86400);
	isetcookie('__uid', '', -7 * 86400);

@header('Location: '.wurl('user/login'));
die;