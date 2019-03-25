<?php
/**
 * 【超人】提现模块定义
 *
 * @author 超人
 * @url
 */
defined('IN_IA') or exit('Access Denied');
class Superman_getcash_doMobileGetcash extends Superman_getcashModuleSite {

    public function __construct() {
        parent::__construct();
    }

    public function exec() {
        global $_W, $_GPC;
        $style = in_array($_GPC['style'], array('default', 'weui'))?$_GPC['style']:'weui';
        checkauth();
        $this->module = Superman_getcashModuleSite::uni_modules_fetch('superman_getcash');
        $conf = $this->module['config'];
        $title = '我要提现';
        if (empty($conf['getcash']['type'])) {
            message('管理员未设置提现参数类型', referer(), 'error');
        }
        $setting = uni_setting($_W['uniacid'], array('creditnames', 'creditbehaviors', 'uc', 'payment', 'passport'));
        $creditnames = $setting['creditnames'];
        $credits = mc_credit_fetch($_W['member']['uid'], '*');
        $credit = array(
            'title' => $creditnames[$conf['getcash']['type']]['title'],
            'value' => str_replace('.00', '', $credits[$conf['getcash']['type']]),
        );
        $radio = $conf['getcash']['ratio'];
        $max_create = $this->float_format($credit['value'] / $radio);
        if (checksubmit('submit')) {
            $this->getcash_submit($credit);
        }
        if ($style == 'default') {
            include $this->template('getcash');
        } else {
            include $this->template($style.'/getcash');
        }
    }
}

$obj = new Superman_getcash_doMobileGetcash;
$obj->exec();
