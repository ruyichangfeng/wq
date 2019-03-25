<?php
global $_W,$_GPC;
$lists = array();
$uniacid = $_W['uniacid'];
$list = pdo_fetchall("SELECT * FROM ".tablename('wxz_wzb_category')." WHERE uniacid=:uniacid ORDER BY sort ASC,dateline DESC",array(':uniacid'=>$_W['uniacid']));
if(!empty($list) && is_array($list)){
	foreach($list as $key=>$row){
			$row['list'] = pdo_fetchall("SELECT * FROM ".tablename('wxz_wzb_live_setting')." WHERE uniacid=:uniacid AND cid=:cid",array(":uniacid"=>$_W['uniacid'],':cid'=>$row['id']));
			$lists[] = $row;
	}
}


if (checksubmit('submit')) {
	$isgun = $_GPC['isgun'];

	if($isgun==1){
		foreach($_GPC['rid'] as $key => $v){
			$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_roll_adv')." WHERE uniacid=:uniacid AND rid=:rid",array(':uniacid'=>$uniacid,':rid'=>$v));

			$data = array();
			$data['content'] = $_GPC['gcontent'];
			$data['uniacid'] = $uniacid;
			$data['rid'] = $v;
			$data['type'] = $_GPC['gtype'];

			if(!empty($list)){
				pdo_update('wxz_wzb_roll_adv',$data,array('rid'=>$v,'uniacid'=>$uniacid));
			}else{
				$data['dateline'] = time();
				pdo_insert('wxz_wzb_roll_adv',$data);
			}
		}
	}
	$iskai = $_GPC['iskai'];
	if($iskai==1){
		foreach($_GPC['rid'] as $key => $v){
			$list = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_spread_adv')." WHERE uniacid=:uniacid AND rid=:rid",array(':uniacid'=>$uniacid,':rid'=>$v));
			$data = array();
			$data['images'] = $_GPC['kimages'];
			$data['uniacid'] = $uniacid;
			$data['rid'] = $v;
			$data['type'] = $_GPC['ktype'];
			$data['url'] =$_GPC['kurl'];
			$data['bgcolor'] =$_GPC['kbgcolor'];
			$data['color'] =$_GPC['kcolor'];
			$data['timecolor'] =$_GPC['ktimecolor'];
			$data['count_time'] = intval($_GPC['kcount_time']);

			if(!empty($list)){
				pdo_update('wxz_wzb_spread_adv',$data,array('rid'=>$v,'uniacid'=>$uniacid));
			}else{
				$data['dateline'] = time();
				pdo_insert('wxz_wzb_spread_adv',$data);
			}
		}
	}
	message('批量提交成功',$this->createWebUrl('batchadv'),'success');
}
include $this->template('batchadv');