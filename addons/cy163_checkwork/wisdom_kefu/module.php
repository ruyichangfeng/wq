<?php
/**
 * @author    QQ：1006822260
 */
defined('IN_IA') or exit('Access Denied');

class Wisdom_kefuModule extends WeModule {
		public $tablename = 'n1ce_settings';

		public function settingsDisplay($settings) {
		global $_W, $_GPC;
		if(checksubmit()) {
			$cfg = array(
                'wait' => $_GPC['wait'],
				'start1' => $_GPC['start1'],
				'end1' => $_GPC['end1'],
				'start2' => $_GPC['start2'],
				'end2' => $_GPC['end2'],
				'busy' => $_GPC['busy'],
            );
			if ($this->saveSettings($cfg)) {
                message('保存成功', 'refresh');
            }
			/*$sql = 'DELETE FROM '. tablename($this->tablename) . ' WHERE `rid`=:rid';
			$pars = array();
			$pars[':rid'] = $rid;
			pdo_query($sql, $pars);
			pdo_insert($this->tablename, array('rid' => $rid, 'wait' => $_GPC['wait'],'start1' => $_GPC['start1'], 'end1' => $_GPC['end1'], 'start2' => $_GPC['start2'], 'end2' => $_GPC['end2']));
			return true;*/


		}
		
		include $this->template('setting');
	}
	public function ruleDeleted($rid = 0) {
		pdo_delete($this->tablename, array('rid' => $rid));
	}

}