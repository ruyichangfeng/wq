<?php
/**
 * 一键关注|一键拔号|一键生成引导关注H5模块定义
 *
 * @author flyerzsk
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Yc_duoheyiModule extends WeModule {
	public function settingsDisplay($settings) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		global $_W,$_GPC;
		$uniacid = $_W['uniacid']; 
		if(checksubmit()) { 
			$data = $_GPC['data'];  
			empty($data['name']) && message('请填写名称'); 
			empty($data['description']) && message('请填写介绍'); 
			if (!$this->saveSettings($data)) {
				message('保存信息失败','','error');
			} else {
				message('保存信息成功','','success');
			}
		}
		load()->func('tpl');
		include $this->template('setting');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
	 
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号 
	}

}