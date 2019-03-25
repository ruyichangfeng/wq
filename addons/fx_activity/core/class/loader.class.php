<?php
defined('IN_IA') or exit('Access Denied');


function fx_load() {
	static $loader;
	if(empty($loader)) {
		$fx_loader = new fx_loader();
	}
	return $fx_loader;
}


class fx_loader {
	
	private $cache = array();
	
	function func($name) {
		global $_W;
		if (isset($this->cache['wnfunc'][$name])) {
			return true;
		}
		$file = FX_CORE . 'function/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wnfunc'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Helper Function '.FX_CORE.'function/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
	function model($name) {
		global $_W;
		if (isset($this->cache['wnmodel'][$name])) {
			return true;
		}
		$file = FX_CORE . 'model/' . $name . '.mod.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wnmodel'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Model '.FX_CORE.'model/' . $name . '.mod.php', E_USER_ERROR);
			return false;
		}
	}
	
	function classs($name) {
		global $_W;
		if (isset($this->cache['wnclass'][$name])) {
			return true;
		}
		$file = FX_CORE . 'class/' . $name . '.class.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wnclass'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Class '.FX_CORE.'class/' . $name . '.class.php', E_USER_ERROR);
			return false;
		}
	}
	
	function web($name) {
		global $_W;
		if (isset($this->cache['wnweb'][$name])) {
			return true;
		}
		$file = FX_PATH . '/web/common/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wnweb'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid Web Helper '.FX_PATH.'/web/common/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
	function app($name) {
		global $_W;
		if (isset($this->cache['wnapp'][$name])) {
			return true;
		}
		$file = FX_PATH . '/app/common/' . $name . '.func.php';
		if (file_exists($file)) {
			include_once $file;
			$this->cache['wnapp'][$name] = true;
			return true;
		} else {
			trigger_error('Invalid App Function '.FX_PATH.'/app/common/' . $name . '.func.php', E_USER_ERROR);
			return false;
		}
	}
	
}
