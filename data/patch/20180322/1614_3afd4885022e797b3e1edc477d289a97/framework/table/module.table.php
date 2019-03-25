<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class ModuleTable extends We7Table {

	protected $tableName = 'modules';
	protected $primaryKey = 'mid';

	public function bindings() {
		return $this->hasMany('modulebinding', 'module', 'name');
	}


	public function moduleBindingsInfo($module, $do = '', $entry = '') {
		$condition = array(
			'module' => $module,
			'do' => $do,
		);
		if (!empty($do)) {
			$condition['do'] = $do;
		}
		if (!empty($entry)) {
			$condition['entry'] = $entry;
		}
		return $this->query->from('modules_bindings')->where($condition)->get();
	}

	public function moduleLists($package_group_module) {
		return $this->query->from('modules')->where('issystem', 1)->whereor('name', $package_group_module)->orderby('mid', 'desc')->getall('name');
	}

	public function moduleRank($module_name = '') {
		global $_W;
		$this->query->from('modules_rank')->where('uid', $_W['uid']);
		if (!empty($module_name)) {
			$this->query->where('module_name', $module_name);
		}
		return $this->query->getall('module_name');
	}

	public function moduleMaxRank() {
		global $_W;
		$rank_info = $this->query->from('modules_rank')->select('max(rank)')->where('uid', $_W['uid'])->get();
		return $rank_info['0'];
	}

	public function moduleSetRankTop($module_name) {
		global $_W;
		if (empty($module_name)) {
			return false;
		}
		$max_rank = $this->moduleMaxRank();
		$exist = $this->moduleRank($module_name);
		if (!empty($exist)) {
			pdo_update('modules_rank', array('rank' => ($max_rank + 1)), array('module_name' => $module_name));
		} else {
			pdo_insert('modules_rank', array('uid' => $_W['uid'], 'module_name' => $module_name, 'rank' => ($max_rank + 1)));
		}
		return true;
	}

	public function modulesWxappList() {
		return $this->query->from('modules')->where('wxapp_support', MODULE_SUPPORT_WXAPP)->getall('mid');
	}

	public function moduleLinkUniacidInfo($module_name) {
		if (empty($module_name)) {
			return array();
		}
		$result = $this->query->from('uni_account_modules')->where('module', $module_name)->getall();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$result[$key]['settings'] = iunserializer($value['settings']);
				if (empty($result[$key]['settings']) || empty($result[$key]['settings']['link_uniacid'])) {
					unset($result[$key]);
				}
			}
			return $result;
		}
		return array();
	}

	public function uniAccountModuleInfo($module_name) {
		global $_W;
		if (empty($module_name)) {
			return array();
		}
		$result = $this->query->from('uni_account_modules')->where('module', $module_name)->where('uniacid', $_W['uniacid'])->get();
		if (!empty($result)) {
			$result['settings'] = iunserializer($result['settings']);
			return $result;
		}
		return array();
	}
}