<?php
/**
 * 【超人】提现
 *
 * @author 超人
 * @url
 */

define('SUPERMAN_GETCASH_URL', 'http://bbs.we7.cc/thread-9663-1-1.html');

function superman_getcash_get_status_title($status) {
    $title = '';
    switch ($status) {
        case -2:
            $title = '失败';
            break;
        case -1:
            $title = '已取消';
            break;
        case 0:
            $title = '处理中';
            break;
        case 1:
            $title = '已提现';
            break;
    }
    return $title;
}

function superman_getcash_getpath($file) {
    global $_W;
    return IA_ROOT.DIRECTORY_SEPARATOR.$_W['config']['upload']['attachdir'].DIRECTORY_SEPARATOR.$file;
}