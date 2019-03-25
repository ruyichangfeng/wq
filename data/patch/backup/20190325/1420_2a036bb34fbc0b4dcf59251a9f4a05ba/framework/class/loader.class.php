<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function load() {
	static $loader;
	if(empty($loader)) {
		$loader = new Loader();
	}
	return $loader;
}


function table($name) {
	$table_classname = "\\We7\\Table\\";
	$subsection_name = explode('_', $name);
	if (count($subsection_name) == 1) {
		$table_classname .= ucfirst($subsection_name[0]) . "\\" . ucfirst($subsection_name[0]);
	} else {
		foreach ($subsection_name as $key => $val) {
			if ($key == 0) {
				$table_classname .= ucfirst($val) . '\\';
			} else {
				$table_classname .= ucfirst($val);
			}
		}
	}

	if (in_array($name, array(
		'account_xzapp',
		'account_aliapp',
		'account_baiduapp',
		'account_toutiaoapp',
		'account_wxapp',
		'account_phoneapp',
		'article_category',
		'article_news',
		'article_notice',
		'article_comment',
		'core_profile_fields',
		'core_sendsms_log',
		'core_attachment',
		'core_attachment_group',
		'core_settings',
		'core_cover_reply',
		'core_message_notice_log',
		'core_menu_shortcut',
		'mc_credits_record',
		'mc_mapping_fans',
		'mc_members',
		'mc_member_fields',
		'mc_fans_groups',
		'mc_oauth_fans',
		'modules_rank',
		'modules_bindings',
		'modules_plugin',
		'modules_plugin_rank',
		'modules_cloud',
		'modules_recycle',
		'modules',
		'modules_ignore',
		'phoneapp_versions',
		'qrcode_stat',
		'rule',
		'rule_keyword',
		'site_article_comment',
		'site_templates',
		'site_multi',
		'site_nav',
		'site_styles',
		'site_styles_vars',
		'stat_visit',
		'stat_visit_ip',
		'system_stat_visit',
		'uni_account_modules',
		'uni_account_users',
		'uni_account_modules_shortcut',
		'uni_verifycode',
		'uni_group',
		'uni_modules',
		'userapi_reply',
		'userapi_cache',
		'users',
		'users_group',
		'users_profile',
		'users_bind',
		'users_create_group',
		'users_extra_group',
		'users_extra_limit',
		'users_extra_modules',
		'users_extra_templates',
		'users_lastuse',
		'users_founder_group',
		'users_founder_own_users',
		'users_founder_own_users_groups',
		'users_founder_own_uni_groups',
		'users_founder_own_create_groups',
		'users_permission',
		'wechat_news',
		'wechat_attachment',
		'wxapp_versions',
		'uni_link_uniacid',
	))) {
		return new $table_classname;
	}

	load()->classs('table');
	load()->table($name);
	$service = false;

	$class_name = "{$name}Table";
	if (class_exists($class_name)) {
		$service = new $class_name();
	}
	return $service;
}


class Loader {

	private $cache = array();
	private $singletonObject = array();
	private $libraryMap = array(
		'agent' => 'agent/agent.class',
		'captcha' => 'captcha/captcha.class',
		'pdo' => 'pdo/PDO.class',
		'qrcode' => 'qrcode/phpqrcode',
		'ftp' => 'ftp/ftp',
		'pinyin' => 'pinyin/pinyin',
		'pkcs7' => 'pkcs7/pkcs7Encoder',
		'json' => 'json/JSON',
		'phpmailer' => 'phpmailer/PHPMailerAutoload',
		'oss' => 'alioss/autoload',
		'qiniu' => 'qiniu/autoload',
		'cos' => 'cosv4.2/include',
		'cosv3' => 'cos/include',
		'sentry' => 'sentry/Raven/Autoloader',
	);
	private $loadTypeMap = array(
		'func' => '/framework/function/%s.func.php',
		'model' => '/framework/model/%s.mod.php',
		'classs' => '/framework/class/%s.class.php',
		'library' => '/framework/library/%s.php',
		'table' => '/framework/table/%s.table.php',
		'web' => '/web/common/%s.func.php',
		'app' => '/app/common/%s.func.php',
	);
	private $accountMap = array(
		'account' => 'account/account',
		'weixin.account' => 'account/weixin.account',
		'weixin.platform' => 'account/weixin.platform',
		'aliapp.account' => 'account/aliapp.account',
		'baiduapp.account' => 'account/baiduapp.account',
		'toutiaoapp.account' => 'account/toutiaoapp.account',
		'phoneapp.account' => 'account/phoneapp.account',
		'webapp.account' => 'account/webapp.account',
		'wxapp.account' => 'account/wxapp.account',
		'wxapp.platform' => 'account/wxapp.platform',
		'wxapp.work' => 'account/wxapp.work',
		'xzapp.account' => 'account/xzapp.account',
		'xzapp.platform' => 'account/xzapp.platform',
	);

	public function __construct() {
		$this->registerAutoload();
	}

	public function registerAutoload() {
		spl_autoload_register(array($this, 'autoload'));
			}

	public function autoload($class) {
		$section = array(
			'Table' => '/framework/table/',
		);
				$classmap = array(
			'We7Table' => 'table',
		);
		if (isset($classmap[$class])) {
			load()->classs($classmap[$class]);
		} elseif (preg_match('/^[0-9a-zA-Z\-\\\\_]+$/', $class)
			&& (stripos($class, 'We7') === 0 || stripos($class, '\We7') === 0)
			&& stripos($class, "\\") !== false) {
				$group = explode("\\", $class);
				$path = IA_ROOT . $section[$group[1]];
				unset($group[0]);
				unset($group[1]);
				$file_path = $path . implode('/', $group) . '.php';
				if(is_file($file_path)) {
					include $file_path;
				}
								$file_path = $path . 'Core/' .  implode('', $group) . '.php';
				if(is_file($file_path)) {
					include $file_path;
				}
		}
	}

	public function __call($type, $params) {
		global $_W;
		$name = $cachekey = array_shift($params);
		if (!empty($this->cache[$type]) && isset($this->cache[$type][$cachekey])) {
			return true;
		}
		if (empty($this->loadTypeMap[$type])) {
			return true;
		}
				if ($type == 'library' && !empty($this->libraryMap[$name])) {
			$name = $this->libraryMap[$name];
		}
		if ($type == 'classs' && !empty($this->accountMap[$name])) {
						$filename = sprintf($this->loadTypeMap[$type], $this->accountMap[$name]);
			if (file_exists(IA_ROOT . $filename)) {
				$name = $this->accountMap[$name];
			}
		}
		$file = sprintf($this->loadTypeMap[$type], $name);
		if (file_exists(IA_ROOT . $file)) {
			include IA_ROOT . $file;
			$this->cache[$type][$cachekey] = true;
		}
		return true;
	}

	
	function singleton($name) {
		if (isset($this->singletonObject[$name])) {
			return $this->singletonObject[$name];
		}
		$this->singletonObject[$name] = $this->object($name);
		return $this->singletonObject[$name];
	}

	
	function object($name) {
		$this->classs(strtolower($name));
		if (class_exists($name)) {
			return new $name();
		} else {
			return false;
		}
	}
}
