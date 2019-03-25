<?php
global $_GPC,$_W;
load()->model('mc');    //积分相关
load()->func('tpl');

require_once MODULE_ROOT . '/common/config.php';
require_once MODULE_ROOT . '/common/function.php';
require_once MODULE_ROOT . '/model/vote.class.php';
require_once MODULE_ROOT . '/model/join.class.php';

$vote = new Vote();
$join = new Join();

//判断是否手机端操作
if(empty($_W['openid'])){
	message('请在微信客户端打开','','error');
	exit;
}

//调用用户微信昵称
if (empty($_W['fans']['nickname'])) {
    mc_oauth_userinfo();
}

$ops = array('index', 'list', 'info', 'join', 'vote', 'search');
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'index';

switch ($op) {
    case 'index': 
        $voteid = $_GPC['voteid'];
        $joinid = $_GPC['joinid'];
        $openid = $_W['openid'];
        $uid = $_W['member']['uid'];
        
        //参数验证
        if(empty($voteid)){
            message('活动不存在','','error');
            exit;
        }
        
        //更新访问次数
        $vote -> addaccesscount($voteid);

        //获得活动信息
        $data = $vote -> getvote($voteid);

        //处理时间
        $datetimestr;

        //距离开始结束时间计算
        $nowdatetime = strtotime(date("Y-m-d H:i:s"));
        $startdatetime = strtotime($data['start_time']);
        $enddatetime = strtotime($data['end_time']);
        if($nowdatetime < $startdatetime) {   //活动还未开始
            $date=floor(($nowdatetime-$startdatetime)/86400);
            $hour=floor(($nowdatetime-$startdatetime)%86400/3600);
            $minute=floor(($nowdatetime-$startdatetime)%86400/60%60);
            $datetimestr="距离活动开始".$date."天".$hour."小时".$minute."分钟";
        }else if($nowdatetime < $enddatetime){  //活动进行中
            $date=floor(($enddatetime-$nowdatetime)/86400);
            $hour=floor(($enddatetime-$nowdatetime)%86400/3600);
            $minute=floor(($enddatetime-$nowdatetime)%86400/60%60);
            $datetimestr="距离活动结束".$date."天".$hour."小时".$minute."分钟";
        }else{  //活动已结束
            $datetimestr="活动已结束";
        }

        //获取操作员参与信息
        $mydata = $join -> getjoinbyopenid($voteid, $openid);

        //获得排行榜信息
        $rankings = $join -> gethotjoins($voteid, 0, 10);

        include $this->template('index');
    break;
    case 'list':
        $voteid = $_GPC['voteid'];
        $start = $_GPC['start'];
        $limit = $_GPC['limit'];
        //最新参与
        $newarr = $join -> getnewjoins($voteid, $start, $limit);

        $news = array();
        foreach($newarr as $item){
            $temparr = array(
                'id' => $item['id'],
                'img' => tomedia($item['image']),
                'username' => mb_strlen($item['username']) > 16 ? mb_strcut($item['username'], 0, 18, 'utf-8') : $item['username'],
                'pollcount' => $item['display_poll_count'],
            );
            array_push($news, $temparr);
        }
        
        //人气选择
        $hotarr = $join -> gethotjoins($voteid, $start, $limit);

        $hots = array();
        foreach($hotarr as $key => $item){
            $temparr = array(
                'id' => $item['id'],
                'img' => tomedia($item['image']),
                'username' => mb_strlen($item['username']) > 16 ? mb_strcut($item['username'], 0, 18, 'utf-8') : $item['username'],
                'pollcount' => $item['display_poll_count'],
            );
            array_push($hots, $temparr);
        }

        $list = array('newlist' => $news, 'hotlist' => $hots);
        response($list, 200, "");
    break;
    case 'info'://获取详情
        $joinid = $_GPC['joinid'];
        $voteid = $_GPC['voteid'];

        $joindata = $join -> getjoin($voteid, $joinid);
        
        //详情信息借口
        $info = array(
            'id' => $joindata['id'],
            'voteid' => $joindata['vote_id'],
            'openid' => $joindata['open_id'],
            'uid' => $joindata['uid'],
            'username' => $joindata['username'],
            'image' => tomedia($joindata['image']),
            'resume' => $joindata['resume'],
            'telephone' => $joindata['telephone'],
            'ip' => $joindata['ip'],
            'pollcount' => ($joindata['poll_count'] + $joindata['add_poll_count']),
            'checkstate' => $joindata['check_state'],
        );

        response($info, 200, "成功");
    break;
    case 'search':
        $voteid = $_GPC['voteid'];
        $joinid = $_GPC['joinid'];

        $joindata = $join -> getjoin($voteid, $joinid);

        if($joindata['check_state'] != 2){
            response(false, 200, "成功");
        }
		
        response($joindata, 200, "成功");
    break;
}

