<?php
/**
 * 甜橙表单模块定义
 *
 * @author 甜橙网络
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Cx_tcbdModule extends WeModule {
	public $tablename = 'cx_tcbd_form';
	
	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		load()->func('tpl');
		if (!empty($rid)) {
			$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		}		
		if (!$reply) {
			$now = time();
			$reply = array(
				"valid_time_start" => $now,
				"valid_time_end" => strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600)),
				"submit_times" => 1,
			);
		}
		$manageurl = $this->createWebUrl('index');
		include $this->template('form');
	}
	
	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		global $_GPC, $_W;
		$id = intval($_GPC['reply_id']);	
		$insert = array(
			'rid' => $rid,
			'uniacid' => $_W['uniacid'],
			'form_theme' => $_GPC['form_theme'],
			'keyword' => $_GPC['keywordinput'],
			'form_pic' => $_GPC['form_pic'],
			'details' => htmlspecialchars_decode($_GPC['details']),
			'valid_time_start' => strtotime($_GPC['datelimit']['start']),
			'valid_time_end' => strtotime($_GPC['datelimit']['end']),
			'phone' => $_GPC['phone'],
			'error_prompt' => $_GPC['error_prompt'],
			'success_prompt' => $_GPC['success_prompt'],
			'submit_times' => intval($_GPC['submit_times']),
			'fields' => $_GPC['forms']
		);
		if (empty($id)) {
			$id = pdo_insert($this->tablename, $insert);
		} else {
			pdo_update($this->tablename, $insert, array('id' => $id));
		}
		return true;		
	}

	public function ruleDeleted($rid) {
		global $_W;
		pdo_delete('cx_tcbd_form', array('rid' => $rid,'uniacid'=>$_W['uniacid']));
		pdo_delete('cx_tcbd_fans', array('rid' => $rid,'uniacid'=>$_W['uniacid']));
		pdo_delete('cx_tcbd_order', array('rid' => $rid,'uniacid'=>$_W['uniacid']));
	}	

}