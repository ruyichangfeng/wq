<?php
global $_GPC, $_W;
        $uniacid=$_W['uniacid'];
		$id=$_GPC['id'];
        $res=$this->res;
		$plus=$this->plus;
		load()->func('tpl');

$fanssum_c = cache_load('bsht_tbk_fanssum_i'.$uniacid);
$fanssum=pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('bsht_tbk_user')." WHERE uniacid = :uniacid and follow=1 ", array(':uniacid'=>$uniacid));
if($fanssum>$fanssum_c){
cache_write('bsht_tbk_fanssum_i'.$uniacid, $fanssum);
}

$setting = $this->baseset($uniacid);
$settings = $this->module['config'];
if($setting['qiandaourl']!='内置'){
$setting['qiandaourl']=$_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=qiandao&m=bsht_tbk";
}
if(empty($setting)){message('请先进行参数设置！', referer(), 'error');}


$ads = pdo_fetchall("SELECT * FROM ".tablename($this->tableads)." WHERE uniacid = '{$_W['uniacid']} ' AND status=1 order by displayorder desc,id desc");

$allcateall= pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND status=1 order by displayorder desc");

$indexcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND isindex=1 order by displayorder desc  LIMIT 8");


$_share['title'] = $setting['fxtit'];
$_share['imgUrl'] =tomedia($setting['fxlogo']);
$_share['desc'] =$setting['fxdes'];
$_share['link'] = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=index&m=bsht_tbk";
$_W['page']['sitename']=$setting['sitetitle'];

if(empty($_W['page']['sitename'])){
$pagename = '首页';
}else{$pagename=$_W['page']['sitename'];}

include $this->template('index');
