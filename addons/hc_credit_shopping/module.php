<?php

/**
 * 微商城模块定义
 *
 * @author WeEngine Team
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Hc_credit_shoppingModule extends WeModule {

    public function fieldsFormDisplay($rid = 0) {
        global $_W;
        $setting = $_W['account']['modules'][$this->_saveing_params['mid']]['config'];
        include $this->template('rule');
    }

    public function fieldsFormSubmit($rid = 0) {
        global $_GPC, $_W;
        if (!empty($_GPC['title'])) {
            $data = array(
                'title' => $_GPC['title'],
                'description' => $_GPC['description'],
                'picurl' => $_GPC['thumb-old'],
                'url' => create_url('mobile/module/list', array('name' => 'hc_credit_shopping', 'weid' => $_W['weid'])),
            );
            if (!empty($_GPC['thumb'])) {
                $data['picurl'] = $_GPC['thumb'];
                file_delete($_GPC['thumb-old']);
            }
            $this->saveSettings($data);
        }
        return true;
    }

    public function settingsDisplay($settings) {
        global $_GPC, $_W;
        
        if (checksubmit()) {
			$bi_rate = $_GPC['bi_rate'];
			$credit_rate = $_GPC['credit_rate'];
			if(!is_numeric($bi_rate)){
				message('人民币和积分兑换积分比率必须为数字！');
			}
            $cfg = array(
                'bi_img' => $_GPC['bi_img'],
                'credit_img' => $_GPC['credit_img'],
                'bi_rate' => $_GPC['bi_rate'],
                'credit_rate' => $_GPC['credit_rate'],
                'zhuanfa_img' => $_GPC['zhuanfa_img'],
                'template_id' => $_GPC['template_id'],
                'zhuanfa_content' => $_GPC['zhuanfa_content'],
                'zhuanfa_title' => $_GPC['zhuanfa_title'],
                'guanzhu_url' => $_GPC['guanzhu_url'],
                'countdown' => $_GPC['countdown'],

            );
            if (!empty($_GPC['logo'])) {
                $cfg['logo'] = $_GPC['logo'];
            }
            if ($this->saveSettings($cfg)) {
                message('保存成功', 'refresh');
            }
        }
		load()->func('tpl');
		include $this->template('setting');
    }

}
