<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
} 

!defined('FX_PATH') &&define('FX_PATH', IA_ROOT . '/addons/' . MODULE_NAME . '/');
!defined('FX_CORE') &&define('FX_CORE', FX_PATH . 'core/');
!defined('FX_APP') &&define('FX_APP', FX_PATH . 'app/');
!defined('FX_WEB') &&define('FX_WEB', FX_PATH . 'web/');

!defined('FX_URL')  &&define('FX_URL', $_W['siteroot'] . 'addons/'. MODULE_NAME . '/');
