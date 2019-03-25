<?php
/**
 * 发布投票
 */
global $_GPC, $_W;
load()->func('tpl');
load()->func('logging');

require_once MODULE_ROOT . '/common/config.php';
require_once MODULE_ROOT . '/model/vote.class.php';

$vote = new Vote();

$uniacid = $_W["uniacid"];

if(checksubmit("submit")){
    $data = array(
       'title' => $_GPC['title'],
       'picture' => $_GPC['picture'],
       'introduce' => $_GPC['introduce'],
       'start_time' => $_GPC['votetime']['start'],
       'end_time' => $_GPC['votetime']['end'],
       'max_count' => $_GPC['maxcount'],
       'single_max_count' => $_GPC['singlemaxcount'],
       'ip_max_count' => $_GPC['ipmaxcount'],
       'join_integral' => $_GPC['joinintegral'],
       'vote_integral' => $_GPC['voteintegral'],
       'add_access_count' => $_GPC['addaccesscount'],
       'add_join_count' => $_GPC['addjoincount'],
       'add_vote_count' => $_GPC['addvotecount'],
       'is_check' => $_GPC['ischeck'] == 'on' ? 1:0,
       'access_count' => 0,
       'join_count' => 0,
       'vote_count' => 0,
       'is_delete' => 0,
       'uniacid' => $uniacid,
       'create_time' => date("Y-m-d H:i:s"),
    );

    $result = $vote -> addvote($data);
    logging_run("uniacid:" . $uniacid . ",结果：" . $result . " 发布投票", 'trace', MODULE_ID);

    if ($result == 1) {
        message('发布成功！', $this->createWebUrl('vote',array()),'success');
    }else{
        message('发布失败！','','error');
    }
}

include $this->template('voteadd');  