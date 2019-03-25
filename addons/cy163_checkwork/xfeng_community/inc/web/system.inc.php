<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 后台系统更新
 */
require XQ_PATH .'version.php';
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$do = $_GPC['do'].$op;
$method = $_GPC['method'] ? $_GPC['method']: 'system';
$GLOBALS['frames'] = $this->NavMenu($do,$method);
$xqmenu = $this->xqmenu();
load()->func('communication');
if($op == 'display'){
    $domain = $_SERVER['SERVER_NAME'];
    $siteid = $_W['setting']['site']['key'];
    $ip = $_W['clientip'];
    $result = ihttp_request('http://cloud.we7xq.com/addons/bull_manage/api.php', array('type' => 'checkauth','module' => 'xfeng_community'),null,5);
    $result = @json_decode($result['content'], true);
    $result = $result['data'];
    if (checksubmit()) {
        $resp = ihttp_request('http://cloud.we7xq.com/addons/bull_manage/api.php', array('type' => 'grant','module' => 'xfeng_community','code' => trim($_GPC['code']),'domain' => $domain,'siteid' => $siteid,'ip'=>$ip),null,1);
        $resp = @json_decode($resp['content'], true);
        if($resp['err_code'] == 1){
            message($resp['err_msg']);
        }else{
            message($resp['err_msg']);
        }
    }
    include $this->template('web/system/auth');
}
