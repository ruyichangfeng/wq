<?php
global $_GPC,$_W;
load()->model('mc');    //积分相关
load()->func('tpl');
load()->func('logging');

require_once MODULE_ROOT . '/common/config.php';
require_once MODULE_ROOT . '/common/function.php';
require_once MODULE_ROOT . '/model/vote.class.php';
require_once MODULE_ROOT . '/model/join.class.php';
require_once MODULE_ROOT . '/model/voterecord.class.php';

$vote = new Vote();
$join = new Join();
$voterecord = new VoteRecord();

//判断是否手机端操作
if(empty($_W['openid'])){
    response(null,500,"请在微信客户端打开");
}

$voteid = $_GPC['voteid'];
$joinid = $_GPC['joinid'];
$openid = $_W['openid'];
$uid = $_W['member']['uid'];

//获得活动信息
$data = $vote -> getvote($voteid);
//获得参与者信息
$joindata = $join -> getjoin($voteid, $joinid);

//判断是否给自己投票
if($openid == $joindata['open_id']) {
    response(null, 500, "不能给自己点赞");
}

//判断每日可投票总次数
$mymaxcount = $voterecord -> getvoterecordcount($voteid);
if($mymaxcount >= $data['max_count']){
    response(null, 500, "您今日的投票次数已经达到上限");
}

//判断每日对同一个用户可重复投票次数
$mysinglemaxcount = $voterecord -> getvoterecordcount($voteid,array(':joinid' => $joinid));
if($mysinglemaxcount >= $data['single_max_count']){
    response(null, 500, "您今日给TA投票的次数已经达到上限");
}

//每日相同IP可投票次数
$myipmaxcount = $voterecord -> getvoterecordcount($voteid,array(':ip' => CLIENT_IP));
if($myipmaxcount >= $data['ip_max_count']){
    response(null, 500, "您的IP今日投票次数已经过多");
}
//添加投票记录		
$adddata = array(
	'vote_id' => $voteid,
	'join_id' => $joinid,
	'open_id' => $openid,
	'uid' => $uid,
	'nickname' => $_W['fans']['nickname'],
	'ip' => CLIENT_IP,
	'create_time' => date("Y-m-d H:i:s"),
);
$result = $voterecord -> addvoterecord($adddata, $voteid, $joinid, $openid);
logging_run("openid:" . $openid . ",结果：" . $result . " 投票", 'trace', MODULE_ID);

if ($result == 1) {
    $integral = $data['vote_integral'];
    if($integral >= 0){
        //新增会员积分
        updatewe7credit1($uid, $integral, '进行投票 获得积分：'.$integral);
    }
    response(null, 200, "投票成功");
}else{
    response(null, 500, "投票失败");
}
