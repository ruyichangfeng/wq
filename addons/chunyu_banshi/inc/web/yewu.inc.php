<?php 
global $_W,$_GPC;
load()->func('file');
load()->web('tpl'); 
$typeid = empty($_GPC['typeid']) ? "全部" : $_GPC['typeid'];
if(!empty($_GPC['typeid'])){
	$tname=pdo_fetch("SELECT * FROM".tablename('chunyu_banshi_type')."WHERE uniacid=:uniacid AND tid=:tid ORDER BY tid ASC",array(':uniacid'=>$_W['uniacid'],':tid'=>$_GPC['typeid']));
}
//$typeid = empty($_GPC['wangid']) ? "all" : $_GPC['wangid'];
$typelist=pdo_fetchall("SELECT * FROM".tablename('chunyu_banshi_type')."WHERE uniacid=:uniacid ORDER BY tid ASC",array(':uniacid'=>$_W['uniacid']));

$pindex = max(1, intval($_GPC['page']));
$psize = 10;
// $wgzlist=pdo_fetchall("SELECT * FROM".tablename('chunyu_she_renyuan')."WHERE uniacid=:uniacid AND shenfen=:shenfen ORDER BY rid ASC",array(':uniacid'=>$_W['uniacid'],':shenfen'=>1));
// $wgylist=pdo_fetchall("SELECT * FROM".tablename('chunyu_she_renyuan')."WHERE uniacid=:uniacid AND shenfen=:shenfen ORDER BY rid ASC",array(':uniacid'=>$_W['uniacid'],':shenfen'=>2));
// $mjlist=pdo_fetchall("SELECT * FROM".tablename('chunyu_she_renyuan')."WHERE uniacid=:uniacid AND shenfen=:shenfen ORDER BY rid ASC",array(':uniacid'=>$_W['uniacid'],':shenfen'=>3));
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		$newdata = array(
			'uniacid'=>$_W['uniacid'],
			'lname'=>$_GPC['lname'],
			'lpic'=>$_GPC['lpic'],
			'ljieshao'=>$_GPC['ljieshao'],
			'tid'=>$_GPC['tid'],
			'ltiaojian'=>$_GPC['ltiaojian'],
			'lcailiao'=>$_GPC['lcailiao'],
			'lliucheng'=>$_GPC['lliucheng'],
			'lxiazai'=>$_GPC['lxiazai'],
			);
		$res = pdo_insert('chunyu_banshi_yewu', $newdata);
		if (!empty($res)) {
			message('恭喜，业务添加成功！', $this -> createWebUrl('yewu'), 'success');
		} else {
			message('抱歉，业务添加失败！', $this -> createWebUrl('yewu'), 'error');
		}

	}

}else{
	if(empty($_GPC['typeid'])) {
		//$yewulist=pdo_fetchall("SELECT * FROM".tablename('chunyu_banshi_yewu')." WHERE uniacid=:uniacid ORDER BY lid DESC",array(':uniacid'=>$_W['uniacid']));

		$yewulist=pdo_fetchall("SELECT a.*,b.typename FROM ".tablename('chunyu_banshi_yewu')." as a left join ".tablename('chunyu_banshi_type')." as b on a.tid=b.tid WHERE a.uniacid=:uniacid ORDER BY lid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));

		$total = pdo_fetchcolumn("SELECT count(lid) FROM " . tablename('chunyu_banshi_yewu') ." WHERE uniacid=:uniacid ORDER BY lid DESC",array(':uniacid'=>$_W['uniacid']));
		$pager = pagination($total, $pindex, $psize);
		include $this->template('web/yewu');
		exit;	

	}else{
		//$typeid=intval($_GPC['wangid']);
		//获取按类型ID信息列表
		$yewulist=pdo_fetchall("SELECT a.*,b.typename FROM ".tablename('chunyu_banshi_yewu')." as a left join ".tablename('chunyu_banshi_type')." as b on a.tid=b.tid WHERE a.uniacid=:uniacid AND a.tid=:typeid ORDER BY lid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid'],':typeid'=>$_GPC['typeid']));
		// $yewulist=pdo_fetchall("SELECT * FROM".tablename('chunyu_banshi_yewu')."WHERE uniacid=:uniacid AND tid=:typeid ORDER BY lid DESC",array(':uniacid'=>$_W['uniacid'],':typeid'=>$_GPC['typeid']));
		$total = pdo_fetchcolumn("SELECT count(lid) FROM " . tablename('chunyu_banshi_yewu') ." WHERE uniacid=:uniacid AND tid=:typeid ORDER BY lid DESC",array(':uniacid'=>$_W['uniacid'],':typeid'=>$_GPC['typeid']));
		$pager = pagination($total, $pindex, $psize);
		include $this->template('web/yewu');
		exit;		
	}
}