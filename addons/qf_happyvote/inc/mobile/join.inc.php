<?php

global $_GPC,$_W;
load()->model('mc');    //积分相关
load()->func('tpl');
load()->func('logging');

require_once MODULE_ROOT . '/common/config.php';
require_once MODULE_ROOT . '/common/function.php';
require_once MODULE_ROOT . '/model/vote.class.php';
require_once MODULE_ROOT . '/model/join.class.php';

$vote = new Vote();
$join = new Join();

//判断是否手机端操作
if(empty($_W['openid'])){
    response(null,500,"请在微信客户端打开");
}

$voteid = $_GPC['voteid'];
$openid = $_W['openid'];
$uid = $_W['member']['uid'];

//判断是否已经参加过活动
$mydata = $join -> getjoinbyopenid($voteid, $openid);
if(!empty($mydata)){
    response(null,500,"您已参加过活动，请勿重复参加");
}

//获得活动信息
$votedata = $vote -> getvote($voteid);

$data = array(
   'vote_id' => $voteid,
   'open_id' => $openid,
   'uid' => $uid,
   'username' => $_GPC['username'],
   'image' => $_GPC['image'],
   'resume' => $_GPC['resume'],
   'telephone' => $_GPC['telephone'],
   'add_poll_count' => $_GPC['addpollcount'],
   'check_state' => $_GPC['ischeck'] == 1 ? 1 : 2,
   'ip' => CLIENT_IP,
   'poll_count' => 0,
   'create_time' => date("Y-m-d H:i:s"),
);

$joinid = $join -> addjoin($data, $voteid);
logging_run("openid:" . $openid . ",结果：" . $joinid . " 活动报名", 'trace', MODULE_ID);

if ($joinid != 0) {
    $integral = $votedata['join_integral'];
    if($integral >= 0){
        //新增会员积分
        updatewe7credit1($uid, $integral, '活动报名 获得积分：'.$integral);
    }
	
    response(array('id'=>$joinid,'checkstate'=>$data['check_state']), 200, "参与成功");
}else{
    response('', 500, "参与失败");
}
