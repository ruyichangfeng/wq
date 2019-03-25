<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
//获取系统配置
$sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
$settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'xuan_js'));
$settings = iunserializer($settings);
$op = !empty($_GPC['op'])?$_GPC['op']:'display';
if ($op=='display') {
	//普通搜索
	if ($_GPC['key']) {

		$page=isset($_GPC['page'])?intval($_GPC['page']):1; ;
		$num="10";
		$start=($page-1)*$num;
		$list=m('fabu')->getlist(array('like'=>$_GPC['key'],'order'=>'id','orderby'=>'desc','limit'=>$limit));
	}
	include $this->template('so');
}