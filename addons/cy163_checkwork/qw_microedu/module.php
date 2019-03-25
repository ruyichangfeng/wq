<?php
/**
 * 微早教模块定义
 *
 * @author 泉微
 * @url http://www.leshuju.cn
 */
defined('IN_IA') or exit('Access Denied');

class Qw_microeduModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
            $dat = array(
                "smsid"=>trim($_GPC['smsid']),
                "smspd"=>trim($_GPC['smspd']),
                "shiting_tplid"=>trim($_GPC['shiting_tplid']),
                "purch_tplid"=>trim($_GPC['purch_tplid']),
                "sign_tplid"=>trim($_GPC['sign_tplid']),
                "comment_tplid"=>trim($_GPC['comment_tplid']),
                "product_tplid"=>trim($_GPC['product_tplid']),
            );
            if($this->saveSettings($dat)){
                message('保存成功', 'refresh');
            }
		}   
		//这里来展示设置项表单
        //print_r($settings);
		include $this->template('setting');

		//
	}

}