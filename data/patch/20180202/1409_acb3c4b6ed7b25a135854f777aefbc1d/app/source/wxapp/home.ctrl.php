<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('wxapp');
$dos = array('nav', 'slide', 'commend', 'wxapp_web');
$do = in_array($_GPC['do'], $dos) ? $_GPC['do'] : 'nav';

$multiid = intval($_GPC['t']);

if ($do == 'nav') {
	$navs = pdo_getall('site_nav', array(
		'uniacid' => $_W['uniacid'],
		'multiid' => $multiid,
		'status' => 1,
		'icon !=' => '',
	), array('url', 'name', 'icon'), '', 'displayorder DESC');

	if (!empty($navs)) {
		foreach ($navs as $i => &$row) {
			$row['icon'] = tomedia($row['icon']);
		}
	}
	message(error(0, $navs), '', 'ajax');
} elseif ($do == 'slide') {
	$slide = pdo_getall('site_slide', array(
		'uniacid' => $_W['uniacid'],
		'multiid' => $multiid,
	), array('url', 'title', 'thumb'), '', 'displayorder DESC');
	if (!empty($slide)) {
		foreach ($slide as $i => &$row) {
			$row['thumb'] = tomedia($row['thumb']);
		}
	}
	message(error(0, $slide), '', 'ajax');
} elseif ($do == 'commend') {
		$category = pdo_getall('site_category', array(
		'uniacid' => $_W['uniacid'],
		'multiid' => $multiid,
	), array('id', 'name', 'parentid'), '', 'displayorder DESC');
		if (!empty($category)) {
		foreach ($category as $id => &$category_row) {
			if (empty($category_row['parentid'])) {
				$condition['pcate'] = $category_row['id'];
			} else {
				$condition['ccate'] = $category_row['id'];
			}
			$category_row['article'] = pdo_getall('site_article', $condition, array('id', 'title', 'thumb'), '', 'displayorder DESC', array(8));
			if (!empty($category_row['article'])) {
				foreach ($category_row['article'] as &$row) {
					$row['thumb'] = tomedia($row['thumb']);
				}
			} else {
				unset($category[$id]);
			}
		}
	}
	message(error(0, $category), '', 'ajax');
}

if ($do == 'wxapp_web') {
	$version = trim($_GPC['v']);
	$version_info = wxapp_version_by_version($version);
	$url = safe_gpc_url($_GPC['url']);
	if (empty($url)) {
				$url = murl('entry', array('eid'=>$version_info['entry_id']), true, true);
	}
	if ($url) {
		setcookie(session_name(), $_W['session_id']);
		header('Location:' . $url);
		exit;
	}
		message('找不到模块入口', 'refresh', 'error');
}
