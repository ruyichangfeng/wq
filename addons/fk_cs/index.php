<?php
/**
 * [Fmoons System] Copyright (c) 2015 fmoons.com
 * Fmoons is NOT a free software, it under the license terms, visited http://www.fmoons.com/ for more details.
 */
define('IN_API', true);
require_once '../framework/bootstrap.inc.php';
require IA_ROOT. '/addons/fk_cs/inc/version.php';
load()->model('reply');
load()->app('common');
load()->classs('wesession');
load()->func('file');

$oauthurl = $_GPC['oauthurl'];
$visitorsip = $_GPC['visitorsip'];
$fmauthtoken = $_GPC['fmauthtoken'];


if (empty($oauthurl)) {
	echo 'error';
	exit;
}

	$log = file_get_contents(IA_ROOT . "/addons/fk_cs_oauth/update.php");
	$upgradeall = file_get_contents(IA_ROOT . "/addons/fk_cs_oauth/upgrade.php");

	if (FM_JIAOYU_VERSION == $_GPC['version']) {
		$upgrade = false;
	}else {
		$upgrade = base64_encode($upgradeall);
	}
	$fmpath = IA_ROOT . '/addons/fk_cs';
	if ($_GPC['type'] == 'check') {
			
			$paths = file_tree($fmpath);
			$files = array();
			foreach ($paths as $key => $file) {
				$path = str_replace($fmpath."/","",$file);
				$files[] = array('path' => $path, 'hash' => md5_file($file));
			}
			$fmdata = array(
				"result" => 1,
				"s" => 1,
				"version" => FM_JIAOYU_VERSION,
				"uptime" => FM_JIAOYU_TIME,
				"upgrade" => $upgrade,
				"oauthurl" => $_GPC['oauthurl'],
				"log" =>  base64_encode($log),
				"fmauthtoken" => $_GPC['fmauthtoken'],
				"files" => $files,
				"m" => '已授权成功！',		
			);
			echo json_encode($fmdata);
			exit();	
	}else{
		$content = file_get_contents($fmpath.'/'.$_GPC['path']);
		
		$fmdata = array(
			"result" => 1,
			"s" => 1,
			"version" => FM_JIAOYU_VERSION,
			"uptime" => FM_JIAOYU_TIME,
			"upgrade" => $upgrade,
			"oauthurl" => $_GPC['oauthurl'],
			"log" =>  base64_encode($log),
			"fmauthtoken" => $_GPC['fmauthtoken'],
			"path" => $_GPC['path'],
			"content" => base64_encode($content),
			//"path1" => $_GPC['path'],
			//"content1" => base64_encode($content),
			"m" => '已授权成功！',		
		);
		echo json_encode($fmdata);
		exit();	
	}