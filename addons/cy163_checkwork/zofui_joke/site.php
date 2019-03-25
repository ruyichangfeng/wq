<?php
/**
 * 模块微站定义
 *
 * @author 众惠科技
 * @url http://bbs.we7.cc/ 
 */
global $_W;
defined('IN_IA') or exit('Access Denied');
define('MODULE_ROOT',IA_ROOT.'/addons/zofui_joke/');
define('MODULE_URL',$_W['siteroot'].'addons/zofui_joke/');
define('MODULE','zofui_joke');
require_once(MODULE_ROOT.'class/autoload.php');

class zofui_jokeModuleSite extends WeModuleSite {
	
	
	
}