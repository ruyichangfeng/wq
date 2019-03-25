<?php
global $_W,$_GPC;
$type = $_GPC['type'];
$rid = $_GPC['rid'];
$uid=$_GPC['wxz_wzb_user'.$_W['uniacid']];
if($type==1){
	$sql ='SELECT b.nickname,b.headimgurl,b.sex,count(*) as c FROM '.tablename('wxz_wzb_help').' as a inner join '.tablename('wxz_wzb_user').' as b on a.share_uid = b.id  inner join ' . tablename('wxz_wzb_viewer') . ' as c on b.id=c.uid and a.rid=c.rid where a.help_uid!=0 and a.rid='.$rid.' and  a.uniacid = '.$_W['uniacid'].' group by a.share_uid order by c desc';

	$result = pdo_fetchall($sql);
	$num = 0;
	foreach($result as $key => $v){
		$num = $num + $v['c']; 
	}

}elseif($type==2){
	$sql='SELECT b.nickname,b.id,b.headimgurl,b.sex,sum(a.fee) as fee FROM ' . tablename('wxz_wzb_ds') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id WHERE a.rid='.$rid.' and a.fee>0 and a.status=1 group by uid ORDER BY fee DESC';
	$result = pdo_fetchall($sql);
	$num = 0;
	foreach($result as $key => $v){
		$num = $num + $v['fee']; 
	}
	$num = $num/100;
}elseif($type==3){
	$sql='SELECT b.nickname,b.id,b.headimgurl,b.sex,a.amount FROM ' . tablename('wxz_wzb_viewer') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.uid=b.id WHERE a.rid='.$rid.' and a.amount>0 order by a.amount desc';
	$result = pdo_fetchall($sql);
	$num = 0;
	foreach($result as $key => $v){
		$num = $num + $v['amount']; 
	}
	$num = $num/100;
}elseif($type==4){
	$sql='SELECT b.nickname,b.id,b.headimgurl,b.sex,a.amount FROM ' . tablename('wxz_wzb_share') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.help_uid=b.id inner join ' . tablename('wxz_wzb_viewer') . ' as c on b.id=c.uid and a.rid=c.rid WHERE a.uniacid = '.$_W['uniacid'].' and a.share_uid='.$uid.' and c.rid='.$rid.' and a.amount>0 order by a.id desc';
	$result = pdo_fetchall($sql);
	$num = 0;
	foreach($result as $key => $v){
		$num = $num + $v['amount']; 
	}
	$num = $num/100;
}elseif($type==5){
	$sql='SELECT b.nickname,b.id,b.headimgurl,b.sex,a.num FROM ' . tablename('wxz_wzb_zannum') . ' as a inner JOIN ' . tablename('wxz_wzb_user') . ' AS b ON a.user_id=b.id WHERE a.uniacid = '.$_W['uniacid'].' and a.rid='.$rid.' and a.num>0 order by a.num desc';
	$result = pdo_fetchall($sql);
	$num = pdo_fetchcolumn("SELECT sum(num) FROM ".tablename('wxz_wzb_zannum')." where `rid` = :rid and uniacid = :uniacid", array(':rid' => $rid,':uniacid' => $_W['uniacid']) );
}
foreach($result as $key => $v){
	if($result[$key]['amount']>0){
		$result[$key]['amount'] = $v['amount']/100;
	}
	if($result[$key]['fee']>0){
		$result[$key]['fee'] = $v['fee']/100;
	}
}
$result = array('s'=>'1','msg'=>$result,'total'=> $num);

echo json_encode($result);exit;

?>