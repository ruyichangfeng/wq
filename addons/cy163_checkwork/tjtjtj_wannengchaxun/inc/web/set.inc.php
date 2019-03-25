<?php
/**
 * 万能查询系统模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;

if(isset($_GPC['submit']))
{
	$web_name = $_GPC['web_name'];
	$bg_image = $_GPC['bg_image'];
	$share_intro = $_GPC['share_intro'];
	$copyright = $_GPC['copyright'];

	if($web_name == '' || $bg_image == '' || $share_intro == '' || $copyright == '')
	{
		message('数据不能为空', '', 'error');
	}

	pdo_query( 'UPDATE `tjtjtj_dl_webset` SET `key_value` = "'.$web_name.'" WHERE `key_name` = "web_name"' );
	pdo_query( 'UPDATE `tjtjtj_dl_webset` SET `key_value` = "'.$bg_image.'" WHERE `key_name` = "bg_image"' );
	pdo_query( 'UPDATE `tjtjtj_dl_webset` SET `key_value` = "'.$share_intro.'" WHERE `key_name` = "share_intro"' );
	pdo_query( 'UPDATE `tjtjtj_dl_webset` SET `key_value` = "'.$copyright.'" WHERE `key_name` = "copyright"' );

	message('保存成功', $this->createWebUrl('set',array('action'=>'')), 'success');
}

// 插件所属公众号ID： $_W['uniacid'];

/*----------------- 首先先检测是否设置了配置 ++++++++++++++++++++*/
$records = pdo_fetchAll('SELECT * FROM `tjtjtj_dl_webset` WHERE `sid` = '.$_W['uniacid']);

if(empty($records))
{
	//第一次使用 - 设置配置项目
	$install_sql = "INSERT INTO `tjtjtj_dl_webset` (`sid`, `key_name`, `key_value`) VALUES ({$_W['uniacid']}, 'web_name', ''),";
	$install_sql .= "({$_W['uniacid']}, 'bg_image', ''),";
	$install_sql .= "({$_W['uniacid']}, 'copyright', ''),";
	$install_sql .= "({$_W['uniacid']}, 'share_intro', '');";
	pdo_query( $install_sql );
	$records = pdo_fetchAll('SELECT * FROM `tjtjtj_dl_webset` WHERE `sid` = '.$_W['uniacid']);
}

$config = array();
foreach ($records as $k => $v) {
	$config[$v['key_name']] = $v['key_value'];
}

//导入模版 template目录下
include $this->template('web_config');