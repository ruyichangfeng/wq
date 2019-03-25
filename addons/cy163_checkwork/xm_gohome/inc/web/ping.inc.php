<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'merchant');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_companygetmoney')." WHERE weid =".$this->weid." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_companygetmoney')." WHERE weid = ".$this->weid." ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/fall/ping-list');
}

if($foo == 'merchant') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_companygetmoney_merchant')." WHERE weid =".$this->weid." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_companygetmoney_merchant')." WHERE weid = ".$this->weid." ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/fall/ping-merchant');
}

?>