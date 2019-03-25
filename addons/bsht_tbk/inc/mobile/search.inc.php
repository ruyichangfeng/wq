<?php
global $_GPC, $_W;
        $uniacid=$_W['uniacid'];
		$id=$_GPC['id'];
		$cate_id=$_GPC['cate_id'];
        $res=$this->res;
		$plus=$this->plus;
		load()->func('tpl');


$setting = $this->baseset($uniacid);
$settings = $this->module['config'];



$allcateall= pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND status=1 order by displayorder desc");

$allcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND status=1 order by displayorder desc");

$indexcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND isindex=1 order by displayorder desc  LIMIT 8");



if(!$_GPC['keywords']){
$_share['link'] = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=index&m=bsht_tbk";
$_share['title'] = $setting['fxtit'];
$_share['imgUrl'] =tomedia($setting['fxlogo']);
$_share['desc'] =$setting['fxdes'];
$pagename = '商品搜索';
}else{
$_share['link'] = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=search&m=bsht_tbk&keywords=".$_GPC['keywords'];
$_share['title'] = "【".$_GPC['keywords']."精选】".$setting['fxtit'];
$_share['imgUrl'] =tomedia($setting['fxlogo']);
$_share['desc'] =$setting['fxdes'];
$pagename = $_GPC['keywords'];
}
$_W['page']['sitename']=$setting['sitetitle'];



include $this->template('search');
