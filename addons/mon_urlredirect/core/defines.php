<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
!defined('MON_URLREDIRECT') && define("MON_URLREDIRECT", "mon_urlredirect");
!defined('MON_URLREDIRECT_RES') && define("MON_COUPON_RES", "../addons/" . MON_URLREDIRECT . "/static/");
!defined('MON_URLREDIRECT_PATH') && define("MON_URLREDIRECT_PATH", IA_ROOT."/addons/" . MON_URLREDIRECT . "/");
!defined('MON_URLREDIRECT_CORE') && define('MON_URLREDIRECT_CORE', IA_ROOT . "/addons/".MON_URLREDIRECT."/core/");


