<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
load()->func('tpl');

require "public.php";
require "user_common.php";

$urltk = $this->createMobileUrl('user_accounting');

//判断是否有专属会计
if($user_show['type']!=1){
	message('抱歉！您还未成为正式会员没有专属会计！如有需要该服务快去购买吧！', $this->createMobileUrl('user_payofficial'), 'error');
}

$srdb = pdo_get('cwgl_staff_list', array('weid' => $_W['uniacid'],'id' => $user_show['ygid'],'uid' => $user_show['yguid']));
if (empty($srdb)) {
	message('该会计不存在或是已经被删除！', $this->createMobileUrl('index'), 'success');
}

//评价次数
$total_pj = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_staff_bpf')."  WHERE weid = '{$_W['uniacid']}' and yguid = '{$user_show['yguid']}'");
//好评次数
$total_pj_h = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cwgl_staff_bpf')."  WHERE weid = '{$_W['uniacid']}' and yguid = '{$user_show['yguid']}' and pfscore = '1'");
//好评率
$pbfb_h = floor($total_pj_h/$total_pj*100);
//职位
$staff_zw_show = pdo_get('cwgl_staff_class', array('cid' => $srdb['type'],'weid' => $_W['uniacid']));
	
include $this->template('user_accounting');