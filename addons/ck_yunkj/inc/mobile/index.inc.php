<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;

require "mn_common.php";

//�����б�
$nav_list = pdo_fetchall("SELECT * FROM " . tablename('cwgl_nav_list') . " WHERE weid = '{$_W['uniacid']}' ORDER BY listorder ASC,id DESC LIMIT 0,5");

//�õ�Ƭ�б�
$flash_list = pdo_fetchall("SELECT * FROM " . tablename('cwgl_ab_list') . " WHERE weid = '{$_W['uniacid']}' and type = 'flash' ORDER BY listorder ASC,id DESC LIMIT 0,4");

//����б�
//С
$ad_list_1 = pdo_fetchall("SELECT * FROM " . tablename('cwgl_ab_list') . " WHERE weid = '{$_W['uniacid']}' and type = 'ad' and kd = '1' ORDER BY listorder ASC,id DESC LIMIT 0,1");
$ad_list_2 = pdo_fetchall("SELECT * FROM " . tablename('cwgl_ab_list') . " WHERE weid = '{$_W['uniacid']}' and type = 'ad' and kd = '1' ORDER BY listorder ASC,id DESC LIMIT 1,1");
$ad_list_3 = pdo_fetchall("SELECT * FROM " . tablename('cwgl_ab_list') . " WHERE weid = '{$_W['uniacid']}' and type = 'ad' and kd = '1' ORDER BY listorder ASC,id DESC LIMIT 2,1");
$ad_list_4 = pdo_fetchall("SELECT * FROM " . tablename('cwgl_ab_list') . " WHERE weid = '{$_W['uniacid']}' and type = 'ad' and kd = '1' ORDER BY listorder ASC,id DESC LIMIT 3,1");


//��
$ad_list_big = pdo_fetchall("SELECT * FROM " . tablename('cwgl_ab_list') . " WHERE weid = '{$_W['uniacid']}' and type = 'ad' and kd = '2' ORDER BY listorder ASC,id DESC LIMIT 0,1");

//�����б�
$notice_list = pdo_fetchall("SELECT * FROM " . tablename('cwgl_notice_list') . " WHERE weid = '{$_W['uniacid']}' ORDER BY listorder ASC,id DESC");

//��ҳ��ʾ���������б�-------------------------
$category_fw = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and type = 'fw' and top = '1' ORDER BY listorder ASC, cid DESC", array(), 'cid');
if (!empty($category_fw)) {
	foreach ($category_fw as &$row) {
		$row['list_fw'] = pdo_fetchall('SELECT * FROM ' . tablename('cwgl_service_list') . " WHERE weid = '{$_W['uniacid']}' and type='{$row[cid]}' and shelves = '1' ORDER BY  id DESC LIMIT 0,3");
	}
}

//ְλ�б�-------------------------
$category_zw = pdo_fetchall("SELECT * FROM " . tablename('cwgl_staff_class') . " WHERE weid = '{$_W['uniacid']}' and type = 'zw' and top = '1' ORDER BY listorder ASC, cid DESC", array(), 'cid');
if (!empty($category_zw)) {
	foreach ($category_zw as &$row) {
		$row['list_zw'] = pdo_fetchall('SELECT a.*,b.avatar,b.nickname FROM ' . tablename('cwgl_staff_list') . " AS a LEFT JOIN ".tablename('mc_members')." AS b on a.uid=b.uid WHERE a.weid = '{$_W['uniacid']}' and a.type='{$row[cid]}'  ORDER BY  a.id DESC LIMIT 0,3");
	}
}
	
include $this->template('index');