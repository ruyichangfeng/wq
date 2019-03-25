<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
//获取用户信息 
$config=$this->config();
$uidopenid=m('member')->get_uidopenid();
$op=!empty($_GPC['op'])?$_GPC['op']:'index';
if ($op=='chathistory') {
		$chat_openid = $_GPC['chat_openid']; 
        $chat_logid = $_GPC['prev_logid'];
        $sign =  talkSign($uidopenid['uid'], $chat_openid);

        $list = m('chat')->historyList($sign, $chat_logid);
        foreach ($list as $key => & $value){
            if($value['from_user_id'] == $uidopenid['uid']){
                $value['send_type'] = 'self';
            }else{
                $value['send_type'] = 'others';
            }
        }
        echo json_encode($list);die;
}elseif ($op=='chatget') {
	$chat_openid = $_GPC['chat_openid']; 
	$talk_sign = talkSign($uidopenid['uid'], $chat_openid);
    $chat_list = m('chat')->getChatList($talk_sign, $chat_openid);

    echo json_encode($chat_list);die;

}elseif($op=='xiaoxi'){
	$list=pdo_fetchall('select max(created_at) as time,sum(readed) as readed,count(readed) as allread,from_user_id,to_user_id,circle_id,data from '.tablename('xuan_js_chat').'where to_user_id=:uid or from_user_id=:uid group by circle_id order by time desc',array(':uid'=>$uidopenid['uid']));

	foreach ($list as $key => & $value){
            if($value['from_user_id'] == $uidopenid['uid']){
                $value['user'] = $value['to_user_id'];
            }else{
                $value['user'] = $value['from_user_id'];
            }

            $value['read']=m('chat')->noread_to_sb($value['circle_id'],$uidopenid['uid']);
            $one=pdo_fetch('select * from '.tablename('xuan_js_chat').' where  circle_id=:circle_id order by created_at desc',array(':circle_id'=>$value['circle_id']));
			$value['type']=$one['type'];
			$value['data']=$one['data'];
            $value['time']=friendlyDate($value['time']);
            $value['user']=m('member')->getinfo($value['user'],'avatar,gender,nickname,uid');
        }

	include $this->template('xiaoxi');
}elseif ($op=='index') {
	$goodsid=$_GPC['goodsid'];

	//chat对象
	$uid=$_GPC['uid']; 
	$chat= m('member')->getinfo($uid,'avatar,gender,nickname');
	$chatself= m('member')->getinfo($uidopenid['uid'],'avatar,gender,nickname');
	if ($goodsid) {
		//获取商品信息
		$goods=m('goods')->getone($goodsid);
		$imgk=explode('@',$goods['img']);
	}


	include $this->template('chat');
}
function talkSign($openid_a,$openid_b)
	{
		if(strcmp($openid_a,$openid_b) >= 0)
		{
			return $openid_a.":".$openid_b;
		}
		else
		{
			return $openid_b.":".$openid_a;
		}
}