<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
//获取分类
$categorychild=m('category')->getChild(array('parentid'=>'>0','enabled'=>1,'order'=>' displayorder asc'));

//获取五个关注头像
$touxiang=m('member')->gettouxiang();
//获取系统配置
$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'xuan_js'));
$settings = iunserializer($settings);
//获取关注总人数
$member=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('mc_mapping_fans'). "where uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid']));
//获取总商品数
$goods=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('xuan_js_fabu'). "where uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid']));
//获取消息

$uidopenid=m('member')->get_uidopenid();
$xiaoxi=m('chat')->allnoread($uidopenid['uid']);


include $this->template('index/index');