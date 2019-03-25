<?php
/**
 * 万能查询系统模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 * 插件所属公众号ID： $_W['uniacid']
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;

//获取网站配置
$ctemp = pdo_fetchAll( 'SELECT * FROM `tjtjtj_dl_webset`' );
$config = array();
foreach ($ctemp as $k => $v) {
	$config[$v['key_name']] = $v['key_value']; 
}

//获取数据结构
$paramArr = pdo_fetchAll( 'SELECT * FROM `tjtjtj_dl_data_param` WHERE `sid` = '.$_W['uniacid'].' ORDER BY sort ASC' );
$rule = array();
foreach ($paramArr as $k => $v) {
	$rule[$v['param_name']] = $v['param_type'];
}

if(isset($_GPC['submit']))
{
	$param_name = $_GPC['param_name'];
	$keys = $_GPC['keys'];
	if($keys == ''){ message('搜索内容不能为空.', '', 'error'); }
	//1.首先判断该字段的属性
	switch ($rule['param_name']) {
		case 'int':
			$sql = 'SELECT * FROM `tjtjtj_dl_data_list` WHERE `sid`= '.$_W['uniacid'].' and `'.$param_name.'` = '.$keys;
			break;
		
		default:
			$sql = 'SELECT * FROM `tjtjtj_dl_data_list` WHERE `sid`= '.$_W['uniacid'].' and `'.$param_name.'` LIKE "%'.$keys.'%"';
			break;
	}

	$data = pdo_fetchAll( $sql );
	
	include $this->template('print');
	exit();
}


//展现模板
include $this->template('home');