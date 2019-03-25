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


$allcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND status=1 order by displayorder desc");

$indexcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND isindex=1 order by displayorder desc  LIMIT 8");

$thiscate = pdo_fetch("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']}' AND status=1 AND id = '{$cate_id} '");



if($thiscate['pic']){
$_share['imgUrl'] =tomedia($thiscate['pic']);
}else{
$_share['imgUrl'] =tomedia($setting['fxlogo']);
}
$_share['desc'] =$setting['fxdes'];
$_share['link'] = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=list_all&m=bsht_tbk&cate_id=".$thiscate['id'];


if($thiscate){

$pagename = $thiscate['name'];
$_share['title'] =   "【".$thiscate['name']."精选】 - ".$setting['fxtit'];
$_W['page']['sitename']=$setting['sitetitle'] ." - ". $thiscate['name'];
}else{
$_share['title'] =   "【领券直播精选】 - ".$setting['fxtit'];
$pagename = '领券直播';
$_W['page']['sitename']=$setting['sitetitle'] ." - 领券直播";
}

include $this->template('list_all');
