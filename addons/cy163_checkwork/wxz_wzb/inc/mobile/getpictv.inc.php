<?php
global $_W,$_GPC;
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
$rid = intval($_GPC['rid']);
$id = intval($_GPC['id']);
$poll = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_polling') . ' WHERE `id` > '.$id.' and rid='.$rid.' and type=8 order by id asc limit 1');

if(!empty($poll)){
	$Livepic = pdo_fetch('SELECT * FROM ' . tablename('wxz_wzb_live_pic') .' where id='.$poll['pic_id'] .' and rid ='.$rid.' order by id desc');
	$Livepic['dateline'] = date('Y-m-d H:i:s',$Livepic['dateline']);

	if($Livepic['pic']){
		foreach(json_decode($Livepic['pic']) as $key => $v){
			$Livepic['pics'][] = tomedia($v);
		}
	}
	$result = array('s'=>'1','content'=>$Livepic,'pid'=>$poll['id'],'type'=>'pictv');
	echo json_encode($result);
	exit;
}
?>