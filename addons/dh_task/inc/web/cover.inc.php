<?php
defined('IN_IA') or exit('Access Denied');
load()->model('reply');
load()->model('module');

global $_GPC, $_W;
$weid = $this->dh_weid;
$GLOBALS['frames'] = $this->getMainMenu();

$do = $_GPC['op'];
$dos = array('task','me');
if (!in_array($do, $dos)) {
    message('参数错误');
}
$entrys = array(
    'task' => array(
        'title' => '首页',
        'do' => 'task',
        'module' => 'dh_task',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'task', 'm' => 'dh_task')),
        'url_show' => murl('entry', array('m' => 'dh_task', 'do' => 'task'), true, true)
    ),
    'me' => array(
        'title' => '个人中心',
        'do' => 'me',
        'module' => 'dh_task',
        'url' => url('entry', array('i' => $_W['uniacid'],'do' => 'me', 'm' => 'dh_task')),
        'url_show' => murl('entry', array('m' => 'dh_task', 'do' => 'me'), true, true)
    )
);
$entry = $entrys[$do];
$sql = "SELECT * FROM " . tablename('cover_reply') . ' WHERE `module` = :module AND `do` = :do AND uniacid = :uniacid AND multiid = :multiid';
$pars = array();
$pars[':module'] = 'dh_task';
$pars[':do'] = $do;
$pars[':uniacid'] = $_W['uniacid'];
$pars[':multiid'] = 0;
$cover = pdo_fetch($sql, $pars);

if(!empty($cover)) {
    $cover['saved'] = true;
    if(!empty($cover['thumb'])) {
        $cover['src'] = tomedia($cover['thumb']);
    }
    $cover['url_show'] = $entry['url_show'];
    $reply = reply_single($cover['rid']);
    $entry['title'] = $cover['title'];
} else {
    $cover['title'] = $entry['title'];
    $cover['url_show'] = $entry['url_show'];
}

if(empty($reply)) {
    $reply = array();
}

if (checksubmit('submit')) {
    
    if(trim($_GPC['keywords']) == '') {
        message('必须输入触发关键字.');
    }
    
    $rule = array(
        'uniacid' => $_W['uniacid'],
        'name' => $entry['title'],
        'module' => 'cover',
        'status' => 1,
    );
    if(!empty($_GPC['istop'])) {
        $rule['displayorder'] = 255;
    } else {
        $rule['displayorder'] = range_limit($_GPC['displayorder'], 0, 254);
    }
    if (!empty($reply)) {
        $rid = $reply['id'];
        $result = pdo_update('rule', $rule, array('id' => $rid));
    } else {
        $result = pdo_insert('rule', $rule);
        $rid = pdo_insertid();
    }

    if (!empty($rid)) {
        $sql = 'DELETE FROM '. tablename('rule_keyword') . ' WHERE `rid`=:rid AND `uniacid`=:uniacid';
        $pars = array();
        $pars[':rid'] = $rid;
        $pars[':uniacid'] = $_W['uniacid'];
        pdo_query($sql, $pars);

        $rowtpl = array(
            'rid' => $rid,
            'uniacid' => $_W['uniacid'],
            'module' => 'cover',
            'status' => 1,
            'displayorder' => $rule['displayorder'],
            'type' => 1,
            'content' => $_GPC['keywords']
        );
        pdo_insert('rule_keyword', $rowtpl);

        $entry = array(
            'uniacid' => $_W['uniacid'],
            'multiid' => 0,
            'rid' => $rid,
            'title' => $_GPC['title'],
            'description' => $_GPC['description'],
            'thumb' => $_GPC['thumb'],
            'url' => $entry['url'],
            'do' => $entry['do'],
            'module' => $entry['module'],
        );
        if (empty($cover['id'])) {
            pdo_insert('cover_reply', $entry);
        } else {
            pdo_update('cover_reply', $entry, array('id' => $cover['id']));
        }
        message('封面保存成功！', 'refresh', 'success');
    } else {
        message('封面保存失败, 请联系网站管理员！');
    }
}
include $this->template('web/cover');