<?php

defined('IN_IA') or exit('Access Denied');

function phoneapp_support_modules() {
	global $_W;
	load()->model('user');
	$modules = user_modules($_W['uid']);
	$phoneapp_modules = array();
	if (!empty($modules)) {
		foreach ($modules as $module) {
			if ($module['phoneapp_support'] == MODULE_SUPPORT_PHONEAPP) {
				$phoneapp_modules[$module['name']] = $module;
			}
		}
	}
	return $phoneapp_modules;
}



function phoneapp_get_some_lastversions($uniacid) {
	$version_lasts = array();
	$uniacid = safe_gpc_int($uniacid);

	if (empty($uniacid)) {
		return $version_lasts;
	}
	$version_lasts = table('phoneapp')->phoneappLatestVersion($uniacid);
	$last_switch_version = phoneapp_last_switch_version();
	if (!empty($last_switch_version[$uniacid]) && !empty($version_lasts[$last_switch_version[$uniacid]['version_id']])) {
		$version_lasts[$last_switch_version[$uniacid]['version_id']]['current'] = true;
	} else {
		reset($version_lasts);
		$firstkey = key($version_lasts);
		$version_lasts[$firstkey]['current'] = true;
	}

	return $version_lasts;
}



function phoneapp_last_switch_version() {
	global $_GPC;
	static $phoneapp_cookie_uniacids;
	if (empty($phoneapp_cookie_uniacids) && !empty($_GPC['__phoneappversionids'])) {
		$phoneapp_cookie_uniacids = json_decode(htmlspecialchars_decode($_GPC['__phoneappversionids']), true);
	}

	return $phoneapp_cookie_uniacids;
}



function phoneapp_fetch($uniacid, $version_id = '') {
	global $_GPC;
	load()->model('extension');
	$phoneapp_info = array();
	$uniacid = safe_gpc_int($uniacid);
	if (empty($uniacid)) {
		return $phoneapp_info;
	}
	if (!empty($version_id)) {
		$version_id = safe_gpc_int($version_id);
	}

	$phonaeapp_table = table('phoneapp');
	$phoneapp_info = $phonaeapp_table->searchWithUniacid($uniacid)->phoneappAccountInfo();

	if (empty($phoneapp_info)) {
		return $phoneapp_info;
	}

	if (empty($version_id)) {
		$phoneapp_cookie_uniacids = array();
		if (!empty($_GPC['__phoneappversionids'])) {
			$phoneappversionids = json_decode(htmlspecialchars_decode($_GPC['__phoneappversionids']), true);
			foreach ($phoneappversionids as $version_val) {
				$phoneapp_cookie_uniacids[] = $version_val['uniacid'];
			}
		}
		if (in_array($uniacid, $phoneapp_cookie_uniacids)) {
			$phoneapp_version_info = phoneapp_version($phoneappversionids[$uniacid]['version_id']);
		}

		if (empty($phoneapp_version_info)) {
			$phoneapp_version_info = $phonaeapp_table->searchWithUniacid($uniacid)->phoneappVersionInfo();
		}
	} else {
		$phoneapp_version_info = $phonaeapp_table->searchWithId($version_id)->phoneappVersionInfo();
	}
	if (!empty($phoneapp_version_info) && !empty($phoneapp_version_info['modules'])) {
		$phoneapp_version_info['modules'] = iunserializer($phoneapp_version_info['modules']);
	}
	$phoneapp_info['version'] = $phoneapp_version_info;
	$phoneapp_info['version_num'] = explode('.', $phoneapp_version_info['version']);

	return  $phoneapp_info;
}


function phoneapp_version($version_id) {
	$version_info = array();
	$version_id = safe_gpc_int($version_id);

	if (empty($version_id)) {
		return $version_info;
	}
	$version_table = table('phoneapp');
	$version_info = $version_table->searchWithId($version_id)->phoneappVersionInfo();
	$version_info['modules'] = iunserializer($version_info['modules']);
	return $version_info;
}


function phoneapp_switch($uniacid, $redirect = '') {
	global $_W;
	phoneapp_save_switch($uniacid);
	isetcookie('__uid', $_W['uid'], 7 * 86400);
	if (!empty($redirect)) {
		header('Location: ' . $redirect);
		exit;
	}

	return true;
}



function phoneapp_save_switch($uniacid) {
	global $_GPC;
	if (empty($_GPC['__switch'])) {
		$_GPC['__switch'] = random(5);
	}

	$cache_key = cache_system_key(CACHE_KEY_ACCOUNT_SWITCH, $_GPC['__switch']);
	$cache_lastaccount = (array) cache_load($cache_key);
	if (empty($cache_lastaccount)) {
		$cache_lastaccount = array(
			'phoneapp' => $uniacid,
		);
	} else {
		$cache_lastaccount['phoneapp'] = $uniacid;
	}
	cache_write($cache_key, $cache_lastaccount);
	isetcookie('__uniacid', $uniacid, 7 * 86400);
	isetcookie('__switch', $_GPC['__switch'], 7 * 86400);

	return true;
}


function phoneapp_update_last_use_version($uniacid, $version_id) {
	global $_GPC;
	$uniacid = safe_gpc_int($uniacid);
	$version_id = safe_gpc_int($version_id);
	if (empty($uniacid) || empty($version_id)) {
		return false;
	}
	if (!empty($_GPC['__phoneappversionids'])) {
		$phoneapp_uniacids = array();
		$cookie_val = json_decode(htmlspecialchars_decode($_GPC['__phoneappversionids']), true);
		if (!empty($cookie_val)) {
			foreach ($cookie_val as &$version) {
				$phoneapp_uniacids[] = $version['uniacid'];
				if ($version['uniacid'] == $uniacid) {
					$version['version_id'] = $version_id;
					$phoneapp_uniacids = array();
					break;
				}
			}
			unset($version);
		}
		if (!empty($phoneapp_uniacids) && !in_array($uniacid, $phoneapp_uniacids)) {
			$cookie_val[$uniacid] = array('uniacid' => $uniacid, 'version_id' => $version_id);
		}
	} else {
		$cookie_val = array(
			$uniacid => array('uniacid' => $uniacid, 'version_id' => $version_id),
		);
	}
	isetcookie('__uniacid', $uniacid, 7 * 86400);
	isetcookie('__phoneappversionids', json_encode($cookie_val), 7 * 86400);

	return true;
}



function phoneapp_version_all($uniacid) {
	load()->model('module');
	$phoneapp_versions = array();
	$uniacid = safe_gpc_int($uniacid);

	if (empty($uniacid)) {
		return $phoneapp_versions;
	}

	$phoneapp_versions = table('phoneapp')->phoneappAllVersion($uniacid);
	if (!empty($phoneapp_versions)) {
		foreach ($phoneapp_versions as &$version) {
			$version = phoneapp_version($version['id']);
		}
	}

	return $phoneapp_versions;
}