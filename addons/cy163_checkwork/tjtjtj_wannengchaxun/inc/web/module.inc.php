<?php
/**
 * 万能查询系统模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;

// 插件所属公众号ID： $_W['uniacid']

if(isset($_GPC['submit']))
{
	$sort = intval($_GPC['sort']);
	$param_name = strtolower($_GPC['param_name']);
	$param_type = $_GPC['param_type'];
	$param_default = $_GPC['param_default'];
	$param_intro = $_GPC['param_intro'];

	if($param_name == '')
	{
		message('字段名不能为空', '', 'error');
	}

	//保存字段信息
	if ( pdo_query( 'INSERT INTO `tjtjtj_dl_data_param` (`sid`,`sort`,`param_name`, `param_type`, `param_default`, `param_intro`) VALUES ('.$_W['uniacid'].', '.$sort.', "'.$param_name.'", "'.$param_type.'", "'.$param_default.'", "'.$param_intro.'")' ) ) {
		switch ($param_type) {
			case 'text':
				$definition = 'text';
				$definition .= $param_default == '' ? ' default ""' : ' default "'.$param_default.'"';
				break;
			case 'int':
				$definition = 'int(10)';
				$definition .= $param_default == '' ? ' default 0' : ' default '.$param_default;
				break;
			default:
				$definition = 'varchar(240)';
				$definition .= $param_default == '' ? ' default NULL' : ' default "'.$param_default.'"';
				break;
		}

		pdo_query( 'ALTER TABLE tjtjtj_dl_data_list ADD COLUMN '.$param_name.' '.$definition );

		message('成功', $this->createWebUrl('module',array('action'=>'')), 'success');
	}else{
		message('系统出错', '', 'error');
	}
}

if(isset($_GPC['action']) && $_GPC['action'] == 'del' && isset($_GPC['uid']))
{
	pdo_query( 'DELETE FROM `tjtjtj_dl_data_param` WHERE `uid` = '.$_GPC['uid'] );
	pdo_query( 'ALTER TABLE tjtjtj_dl_data_list DROP COLUMN '.$_GPC['param'] );
	message('成功', $this->createWebUrl('module', array('action'=>'')), 'success');
}

//获取模型字段
$paramArr = pdo_fetchAll( 'SELECT * FROM `tjtjtj_dl_data_param` WHERE `sid` = '.$_W['uniacid'].' ORDER BY sort ASC' );



//导入模版 template目录下
include $this->template('module_param');