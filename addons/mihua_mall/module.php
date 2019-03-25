<?php
/**
 * 米花商城模块定义
 *
 * @author 米花
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
require("myclass/autoLoad.php");
require("myclass/func.php");

class mihua_mallModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		global $_W;
		$setting = $_W['account']['modules'][$this->_saveing_params['mid']]['config'];
		load()->func('tpl');
		include $this->template('rule');
	}
	public function fieldsFormSubmit($rid = 0) {
		global $_GPC, $_W;
		load()->func('tpl');
		if (!empty($_GPC['title'])) {
			$data = array(
				'title'       => $_GPC['title'],
				'description' => $_GPC['description'],
				'picurl'      => $_GPC['thumb-old'],
				'url'         => $this->createMobileUrl('list'),
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
		load()->func('tpl');
		$uniacid_list = C('platform')->getAllPlatform();
		if (checksubmit()) {
			$cfg = array(
				'agentRegister'         => $_GPC['agentRegister'],
				'noticeid'           => $_GPC['noticeid'],
				'mu_str'          		=> $_GPC['mu_str'],
				'shopname'              => $_GPC['shopname'],
				'zhifuCommission'       => $_GPC['zhifuCommission'],
				'globalCommissionLevel' => $_GPC['globalCommissionLevel'],
				'globalCommission'      => $_GPC['globalCommission'],
				'globalCommission2'     => $_GPC['globalCommission2'],
				'globalCommission3'     => $_GPC['globalCommission3'],
				'commissionbutton'     => $_GPC['commissionbutton'],
				'indexss'               => intval($_GPC['indexss']),
				'ydyy'                  => $_GPC['ydyy'],
				'logo'                  => $_GPC['logo'],
				'paymsgTemplateid'      => $_GPC['paymsgTemplateid'],
				'sendMsgorder'     		=> $_GPC['sendMsgorder'],
				'commissionType'        => $_GPC['commissionType'],
				'address'               => $_GPC['address'],
				'phone'                 => $_GPC['phone'],
				//  'appid' => $_GPC['appid'],
				//   'secret' => $_GPC['secret'],
				'officialweb'           => $_GPC['officialweb'],
				'description'           => htmlspecialchars_decode($_GPC['description']),
				'footer'                => $_GPC['footer'],
				'footerurl'             => $_GPC['footerurl'],
				'mch_id'                => trim($_GPC['mch_id']),
				'wishing'               => trim($_GPC['wishing']),
				'act_name'              => trim($_GPC['act_name']),
				'remark'                => trim($_GPC['remark']),
				'logo_imgurl'           => trim($_GPC['logo_imgurl']),
				'key'                   => trim($_GPC['key']),
				'qi_ye_aid'             => trim($_GPC['qi_ye_aid']),
				'qi_ye_asecret'         => trim($_GPC['qi_ye_asecret']),
				'qi_ye_agent_id'         => trim($_GPC['qi_ye_agent_id']),
				'qiandao_jifen'         => trim($_GPC['qiandao_jifen']),
				'comment_jifen'         => trim($_GPC['comment_jifen']),
				'member_center_msg' 	=> $_GPC['member_center_msg'],
				'sendMsgTemplateid' 	=> $_GPC['sendMsgTemplateid'],
				'pay_uniacid' 			=> $_GPC['pay_uniacid'],
				'take_notice' 			=> $_GPC['take_notice'],
				'scan_code_word' 			=> $_GPC['scan_code_word'],
				'deductible' 			=> $_GPC['deductible'],
			);
			if (!empty($_GPC['logo'])) {
				$cfg['logo'] = $_GPC['logo'];
			}
			if ($this->saveSettings($cfg)) {
				message('保存成功', 'refresh');
			}
			message('保存成功', 'refresh');
		}
		if (empty($settings['footer'])) {

			$settings['footer'] = $_W['account']['name'];
		}
		include $this->template('setting');
	}

}