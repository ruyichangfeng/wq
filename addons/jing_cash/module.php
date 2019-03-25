<?php
/**
 * 余额充值提现模块定义
 *
 * @author 刘靜
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Jing_cashModule extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		$params = array();
		if(empty($_W['isfounder'])) {
			$where = " WHERE `uniacid` IN (SELECT `uniacid` FROM " . tablename('uni_account_users') . " WHERE `uid`=:uid)";
			$params[':uid'] = $_W['uid'];
		}
		$sql = "SELECT * FROM " . tablename('uni_account') . $where;
		$uniaccounts = pdo_fetchall($sql, $params);
		$accounts = array();
		if(!empty($uniaccounts)) {
			foreach($uniaccounts as $uniaccount) {
				$accountlist = uni_accounts($uniaccount['uniacid']);
				if(!empty($accountlist)) {
					foreach($accountlist as $account) {
						if(!empty($account['key'])
						&& !empty($account['secret'])
						&& in_array($account['level'], array(4))) {
							$accounts[$account['acid']] = $account['name'];
						}
					}
				}
			}
		}
		if(checksubmit()) {
            $i = 0;
            foreach ($_GPC['cz'] as $key => $value) {
                if (!empty($value)) {
                    $rule[$i]['cz'] = $value;
                    $rule[$i]['zs'] = $_GPC['zs'][$key];
                    $rule[$i]['fh'] = $_GPC['fh'][$key];
                    $i ++;
                }
            }
            $j = 0;

			load()->func('file');
            mkdirs(ATTACHMENT_ROOT . '/cert');
            $r = true;
            $pemname = $settings['pemname'];
            $pemname = isset($pemname) ? $pemname : md5(time());
            if(!empty($_GPC['cert'])) {
                $ret = file_put_contents(ATTACHMENT_ROOT . '/cert/apiclient_cert.pem.' . $pemname, trim($_GPC['cert']));
                $r = $r && $ret;
            }
            if(!empty($_GPC['key'])) {
                $ret = file_put_contents(ATTACHMENT_ROOT . '/cert/apiclient_key.pem.' . $pemname, trim($_GPC['key']));
                $r = $r && $ret;
            }
            if(!empty($_GPC['ca'])) {
                $ret = file_put_contents(ATTACHMENT_ROOT . '/cert/rootca.pem.' . $pemname, trim($_GPC['ca']));
                $r = $r && $ret;
            }
            if(!$r) {
                message('证书保存失败, 请保证 /attachment/cert/ 目录可写');
            }
            $cfg = array(
            	'minnum' => $_GPC['minnum'],
            	'days' => intval($_GPC['days']),
            	'ischeck' => intval($_GPC['ischeck']),
                'oauth' => $_GPC['oauth'],
                'fee' => trim($_GPC['fee']),
                'minfee' => trim($_GPC['minfee']),
                'maxfee' => trim($_GPC['maxfee']),
                'tpl1' => $_GPC['tpl1'],
                'tpl2' => $_GPC['tpl2'],
                'tpl3' => $_GPC['tpl3'],
                'ip' => $_GPC['ip'],
                'pemname' => $pemname,
                'rule' => iserializer($rule),
                'closetx' => intval($_GPC['closetx']),
                'closecz' => intval($_GPC['closecz']),
                'sendtype' => $_GPC['sendtype'],
                'paydesc' => $_GPC['paydesc'],
                'send_name' => $_GPC['send_name'],
                'act_name' => $_GPC['act_name'],
                'wishing' => $_GPC['wishing']
            );
            if ($this->saveSettings($cfg)) {
                message('保存成功', 'refresh');
            }
		}
        if (!empty($settings['rule'])) {
            $rule = iunserializer($settings['rule']);
            foreach ($rule as &$value) {
                $value['fh'] = isset($value['fh']) ? $value['fh'] : 1;
            }
        }
		include $this->template('setting');
	}

}