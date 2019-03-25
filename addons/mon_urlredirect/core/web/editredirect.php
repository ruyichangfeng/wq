<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanglu
 * Date: 2017/7/24
 * Time: 12:28
 */
/**
 * Created by wanglu on 2017/7/24.
 */

defined('IN_IA') or exit('Access Denied');

$op = $_GPC['op'];
 $redid = $_GPC['redid'];
    if (checksubmit()) {

        $data = array(
            'weid' => $this->weid,
            'rname' => $_GPC['rname'],
            'rtype' => 2,
            'news_icon' => $_GPC['new_icon'],
            'news_content' => $_GPC['new_content'],
            'news_title' => $_GPC['new_title'],
            'enable_userinfo' => $_GPC['enable_userinfo']
        );
        if (empty($redid)) {
            $data['createtime'] = TIMESTAMP;
            DBUtil::create(DBUtil::$TABLE_URLREDIRECT, $data);

            message('新增转发配置成功！', $this->createWebUrl('redirectSetting', array(
                'op' => 'display',
            )), 'success');

        } else {
            DBUtil::updateById(DBUtil::$TABLE_URLREDIRECT, $data, $redid);
            message('修改转发配置成功！', $this->createWebUrl('redirectSetting', array(
                'op' => 'display',
            )), 'success');
        }
    } else {
        if (!empty($redid)) {
            $redirect = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT, $redid);
        }
        include $this->template("web/edit_redirect");
    }