<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$id = intval($_GPC['id']);
$poll = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_polling') . ' WHERE `id` > '.$id.' and rid='.$rid.' order by id asc limit 1');

if(!empty($poll)){
	if($poll['type']==1){

		$Comment = pdo_fetch('SELECT id,uid,nickname,headimgurl,content,ispic FROM ' . tablename('wxz_wzb_comment') .' where id='.$poll['comment_id'] .' and is_auth = 1 and rid ='.$rid.' order by id desc');
		$result = array('s'=>'1','content'=>$Comment,'pid'=>$poll['id'],'type'=>'comment');
		echo json_encode($result);
		exit;
	}elseif($poll['type']==5){
		$Comment = pdo_fetch('SELECT id,uid,nickname,headimgurl,giftpic,giftnum FROM ' . tablename('wxz_wzb_comment') .' where id='.$poll['comment_id'] .' and is_auth = 1 and rid ='.$rid.' order by id desc');
		$content = $Comment['nickname'].'送出了<img src="'.$Comment['giftpic'].'" width="45px" style="position: absolute;top: -15px;"><span style="margin-left:50px">x'.$Comment['giftnum'].'</span>';
		$Comment['content'] = $content;
		$result = array('s'=>'1','content'=>$Comment,'pid'=>$poll['id'],'type'=>'gift');
		echo json_encode($result);
		exit;
	}elseif($poll['type']==6){
		$Comment = pdo_fetch('SELECT id,uid,nickname,tonickname FROM ' . tablename('wxz_wzb_comment') .' where id='.$poll['comment_id'] .' and is_auth = 1 and rid ='.$rid.' order by id desc');
		$content = $Comment['nickname'].'给'.$Comment['tonickname'].'打赏了1个<span>红包</span>';
		$Comment['content'] = $content;
		$result = array('s'=>'1','content'=>$Comment,'pid'=>$poll['id'],'type'=>'reward');
		echo json_encode($result);
		exit;
	}elseif($poll['type']==7){
		$Comment = pdo_fetch('SELECT id,uid,nickname,headimgurl FROM ' . tablename('wxz_wzb_comment') .' where id='.$poll['comment_id'] .' and is_auth = 1 and rid ='.$rid.' order by id desc');
		$content = $Comment['nickname'].'给主播打赏了1个<span>红包</span>';
		$Comment['content'] = $content;
		$result = array('s'=>'1','content'=>$Comment,'pid'=>$poll['id'],'type'=>'reward');
		echo json_encode($result);
		exit;
	}elseif($poll['type']==4){
		$Comment = pdo_fetch('SELECT id,uid,nickname,headimgurl,content FROM ' . tablename('wxz_wzb_comment') .' where id='.$poll['comment_id'] .' and is_auth = 1 and rid ='.$rid.' order by id desc');
		$result = array('s'=>'1','content'=>$Comment,'pid'=>$poll['id'],'type'=>'grouppacket');
		echo json_encode($result);
		exit;
	}elseif($poll['type']==2){
		$blacklist = pdo_fetch('SELECT id,rid,uid,type,touid,nickname FROM ' . tablename('wxz_wzb_blacklist') .' where id='.$poll['black_id']);
		$type = $blacklist['type']==1 ? 'shutup' : 'cancelshutup';
		$result = array('s'=>'1','content'=>$blacklist,'pid'=>$poll['id'],'type'=>$type);
		echo json_encode($result);
		exit;
	}elseif($poll['type']==3){
		$live = pdo_fetch('SELECT isallshutup FROM ' . tablename('wxz_wzb_live_setting') .' where rid='.$poll['live_id']);
		$type = $live['isallshutup']==1 ? 'allshutup' : 'cancelallshutup';

		$result = array('s'=>'1','content'=>$live,'pid'=>$poll['id'],'type'=>$type);
		echo json_encode($result);
		exit;
	}
}
?>