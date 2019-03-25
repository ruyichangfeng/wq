<?php
/**
 * 活动报名模块定义
 *
 * @author 奔跑的蜗牛
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Fx_activityModule extends WeModule {
	
	public $table_share_reply = "fx_activity";
	
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		//pdo_delete('fx_activity_rule', array('themename' => $rid));
	}

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$cfg = array(
				'creditstatus'   => $_GPC['creditstatus'],
				'guanzhu_join'   => $_GPC['guanzhu_join'],
				'guanzhu'        => $_GPC['guanzhu'],
				'followed_image' => $_GPC['followed_image'],
				'sname'          => $_GPC['sname'],
				'slogo'          => $_GPC['slogo'],
				'copyright'      => $_GPC['copyright'],
				'reviewstatus'   => $_GPC['reviewstatus']
			);
            if ($this->saveSettings($cfg)) {
                message('保存成功', 'refresh');
            }
		}
		//这里来展示设置项表单
		load()->func('tpl');
        include $this->template('setting');
	}

}