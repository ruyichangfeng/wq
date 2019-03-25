<?php
/**
 * 疯狂送菜模块定义
 *
 * @author zhao
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Qw_kuaicaiModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
	}

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {




			$lefttpl = $_GPC['lefttpl'];
			$righttpl = $_GPC['righttpl'];
			array_pop($lefttpl);
			array_pop($righttpl);

			$succlefttpl = $_GPC['succlefttpl'];
			$succrighttpl = $_GPC['succrighttpl'];
			array_pop($succlefttpl);
			array_pop($succrighttpl);

			$dat= array(

				'lefttpl'=>json_encode($lefttpl),
				'righttpl'=>json_encode($righttpl),
				'tplid'=>$_GPC['tplid'],
				'succlefttpl'=>json_encode($succlefttpl),
				'succrighttpl'=>json_encode($succrighttpl),
				'succtplid'=>$_GPC['succtplid'],
				'hour'=>$_GPC['hour']?$_GPC['hour']:17,
				'wangurl'=>$_GPC['wangurl'],



			);


			if ($this->saveSettings($dat)) {


				message('保存成功', 'refresh');

			}
		}

		$lefttpl = json_decode($settings['lefttpl']);
		$righttpl = json_decode($settings['righttpl']);
		$count = count($lefttpl);
		$num = $count-1;

		$succlefttpl = json_decode($settings['succlefttpl']);
		$succrighttpl = json_decode($settings['succrighttpl']);
		$succcount = count($succlefttpl);
		$succnum = $succcount-1;

		//这里来展示设置项表单
		include $this->template('setting');
	}

}