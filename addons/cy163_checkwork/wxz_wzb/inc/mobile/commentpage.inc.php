<?php
global $_W,$_GPC;

$rid = intval($_GPC['rid']);
$pindex = max(0, intval($_GPC['page']));
$psize = 15;
$start = ($pindex) * $psize;
$sql='SELECT id,uid,nickname,headimgurl,content,ispacket,tonickname,dateline,touid,dsid,giftid,giftnum,giftpic,ispic FROM ' . tablename('wxz_wzb_comment') .' WHERE rid = '.$rid.' and is_auth = 1 order by id desc limit '.$start.','.$psize;
$list = pdo_fetchall($sql);
krsort($list);
$list = array_values($list);
foreach($list as $key => $v){
	if($v['giftid'] > 0){
		$content = $v['nickname'].'送出了<img src="'.$v['giftpic'].'" width="45px" style="position: absolute;top: -15px;"><span style="margin-left:50px">x'.$v['giftnum'].'</span>';

		$list[$key]['content'] = $content;
		$list[$key]['type'] = 'gift';
	}elseif($v['dsid'] > 0){
		if($v['touid']==0){
			$content = $v['nickname'].'给主播打赏了1个<span>红包</span>';
		}else{
			$content = $v['nickname'].'给'.$v['tonickname'].'打赏了1个<span>红包</span>';
		}
		$list[$key]['content'] = $content;
		$list[$key]['type'] = 'reward';
	}elseif($v['ispacket'] == 1){
		$list[$key]['type'] = 'grouppacket';
	}else{
		$list[$key]['type'] = 'comment';
	}
}

$result = array('s'=>'1','content'=>$list);

echo json_encode($result);
exit;

?>