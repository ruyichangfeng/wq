<?php
defined('IN_IA') or exit('Access Denied');

class dh_taskModuleProcessor extends WeModuleProcessor {
	
	public $name = 'dh_taskModuleProcessor';

	public function isNeedInitContext() {
		return 0;
	}
	public function isNeedSaveContext() {
		return false;
	}
}