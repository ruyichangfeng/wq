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

//获取字段
$paramArr = pdo_fetchAll( 'SELECT * FROM `tjtjtj_dl_data_param` WHERE `sid` = '.$_W['uniacid'].' ORDER BY sort ASC' );
$rule = array();
$paramTemp = array();
foreach ($paramArr as $k => $v) {
	$paramTemp[] = $v['param_name'];
	$rule[$v['param_name']] = $v['param_type'];
}


/*----------------- 删除行为 ++++++++++++++++++++++*/
if( isset($_GPC['action']) && $_GPC['action'] == 'del' && $_GPC['uid'] != '' )
{
	pdo_query( 'DELETE FROM `tjtjtj_dl_data_list` WHERE `uid` = '.$_GPC['uid'] );
	message('删除成功', $this->createWebUrl('data',array('action'=>'')), 'success');
}

/*----------------- 编辑行为第二步 ++++++++++++++++++++++*/
if(isset($_GPC['update_post']))
{
	$dataTemp = array();
	foreach ($_GPC as $k => $v) {
		if(in_array($k, $paramTemp))
		{
			$dataTemp[$k] = $v;
		}
	}
	$valueFormat = array();
	foreach ($dataTemp as $k => $v) {
		$valueFormat[] = $k == 'int' ? "{$k} = {$v}" : "{$k} = '{$v}'";
	}

	$update_sql = "UPDATE `tjtjtj_dl_data_list` SET ".implode(',', $valueFormat)." WHERE `uid` = ".$_GPC['update_post_uid'];
	pdo_query( $update_sql );

	message('编辑成功', $this->createWebUrl('data',array('action'=>'')), 'success');
}

/*----------------- 编辑行为第一步 ++++++++++++++++++++++*/
if( isset($_GPC['action']) && $_GPC['action'] == 'update' && $_GPC['uid'] != '' )
{
	$update_data = pdo_fetch( 'SELECT * FROM `tjtjtj_dl_data_list` WHERE `uid` = '.$_GPC['uid'] );
	if($update_data === false) { message('数据不存在', '', 'error'); }
	include $this->template('data_list');
	exit();
}

/*----------------- 添加行为 ++++++++++++++++++++++*/
if(isset($_GPC['submit']))
{
	$dataTemp = array();
	foreach ($_GPC as $k => $v) {
		if(in_array($k, $paramTemp))
		{
			$dataTemp[$k] = $v;
		}
	}
	$valueFormat = array();
	foreach ($dataTemp as $k => $v) {
		$valueFormat[] = $k == 'int' ? $v : "'{$v}'";
	}

	$insert_sql = "INSERT INTO `tjtjtj_dl_data_list` (sid,".implode(',', $paramTemp).") VALUES ({$_W['uniacid']},".implode(',', $valueFormat).")";
	pdo_query( $insert_sql );
	message('添加成功', $this->createWebUrl('data',array('action'=>'')), 'success');
}


//1.获取页码
$p = intval($_GPC['page']);
$p = $p == 0 ? 1 : $p;
//2.计算起始数
$subpages = 20;
$start = ($p - 1)*$subpages;
//3.获取数据
$dataArr = pdo_fetchAll( 'SELECT * FROM `tjtjtj_dl_data_list` WHERE `sid` = '.$_W['uniacid'].' ORDER BY uid DESC LIMIT '.$start.','.$subpages );
//4.创建分页
$total =pdo_fetchcolumn("SELECT COUNT(*) FROM `tjtjtj_dl_data_list` WHERE `sid` = ".$_W['uniacid']);
$pager  = pagination($total, $p, $subpages);


//展现模板
include $this->template('data_list');