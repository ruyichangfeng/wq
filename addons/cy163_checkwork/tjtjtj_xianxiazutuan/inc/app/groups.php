<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 上午 11:35
 */

if ($_GPC['action'] == 'back') {
    $groups = pdo_fetchall(
        'SELECT
            gr.uid AS groupid,gr.needpeople,gr.donepeople,gr.intro,gr.create_at,gr.end_at,gr.status,
            good.*
            FROM '.tablename('tjtjtj_xxzt_groups').' AS gr
            INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS good ON gr.gid = good.uid
            WHERE gr.end_at < :cat',
        array(':cat' => time()));
    include_once $this->template('future');exit;
}
if ($_GPC['action'] == 'future') {
    $groups = pdo_fetchall(
        'SELECT
            gr.uid AS groupid,gr.needpeople,gr.donepeople,gr.intro,gr.create_at,gr.end_at,gr.status,
            good.*
            FROM '.tablename('tjtjtj_xxzt_groups').' AS gr
            INNER JOIN '.tablename('tjtjtj_xxzt_goods').' AS good ON gr.gid = good.uid
            WHERE gr.create_at > :cat',
        array(':cat' => time()));
    include_once $this->template('future');exit;
}

if ($_GPC['action'] == 'likes') {
    $groupid = intval($_GPC['uid']);
    if ($groupid <= 0) {
        echo json_encode(array('status' => 1, 'msg' => '组团不存在.'));exit;
    }
    $res = pdo_get('tjtjtj_xxzt_likes', array('userid' => $_SESSION[C('session_prefix').'user']['uid'], 'groupid' => $groupid));
    if ($res) {
        echo json_encode(array('status' => 1, 'msg' => '您已经收藏过了.'));exit;
    } else {
        $dat = array(
            'sid' => $_W['uniacid'],
            'userid' => $_SESSION[C('session_prefix').'user']['uid'],
            'groupid' => $groupid,
            'create_at' => time()
        );
        pdo_insert('tjtjtj_xxzt_likes', $dat);
        echo json_encode(array('status' => 0, 'msg' => '收藏成功.'));exit;
    }
}

$uid = intval($_GPC['uid']);

$groupsModel = \App\Service\Factory::proGroupsModel();
$groups      = $groupsModel->getGroups($uid);
$groups['atlas'] = explode('$', $groups['atlas']);

include_once $this->template('groups');
