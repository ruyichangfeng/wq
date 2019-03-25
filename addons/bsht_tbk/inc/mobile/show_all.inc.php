<?php
global $_GPC, $_W;
        $uniacid=$_W['uniacid'];
		$id=$_GPC['id'];
        $res=$this->res;
		$plus=$this->plus;
		load()->func('tpl');


$setting = $this->baseset($uniacid);
$settings = $this->module['config'];



$allcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND status=1 order by displayorder desc");

$indexcateall = pdo_fetchall("SELECT * FROM ".tablename($this->tablecateall)." WHERE uniacid = '{$_W['uniacid']} ' AND isindex=1 order by displayorder desc  LIMIT 8");

$show = pdo_fetch("SELECT * FROM ".tablename($this->tableitemall)." WHERE uniacid = '{$_W['uniacid']}' AND id = '{$id}' AND status=1");



if($show['fm']=='dtk'){

$jiage=$show['itemfee'];
$jiagenew=$show['itemfee2'];
$q_jiage=$jiage-$jiagenew;
$tag=$show['itemyhj_tit'];

if($tag=='无'){$tag='抢购';}else{$tag=str_replace("", "",$tag);}

$toptag = $show['itemyhj_tit'];



}else{

$jiage=$show['itemfee'];
$tag=$show['itemyhj_tit'];

if($tag=='无'){$tag='抢购';}else{$tag=str_replace("", "",$tag);}

$toptag = $show['itemyhj_tit'];

if(strpos($toptag,"减") > 0){
	$pattern='/减(.*)元/isU';
	preg_match($pattern, $toptag, $match);
	$toptag = "领券 ".$match[1]." 元";
	$jiagenew=$jiage-$match[1];
	$q_jiage = $match[1];

	if($jiagenew<=0){$jiagenew=$show['itemfee'];}


	}elseif(strpos($toptag,"条") > 0){
    
       $pattern='/(.*)元/isU';
	   preg_match($pattern, $toptag, $match);
	   $toptag = "领券 ".$match[1]." 元";
	   $tag='卷后价';
	   $jiagenew=$jiage-$match[1];
	   $q_jiage = $match[1];

	   if($jiagenew<=0){$jiagenew=$show['itemfee'];}

	}else{
	
    $toptag='抢购';
	$jiagenew=$jiage;
	}



}


if($setting['diytit'] && $setting['diytit']!=''){
$diytit = $setting['diytit'];
$diytit = str_replace('#券价#',$q_jiage, $diytit);
$diytit = str_replace('#券后价#',$jiagenew, $diytit);
$diytit = str_replace('#售价#',$show['itemfee'], $diytit);
$diytit = str_replace('#商品标题#',$show['title'], $diytit);
$_share['title']=$diytit;

}else{

$_share['title'] = $show['title'];

}


$_share['imgUrl'] =tomedia($show['itempic']);
$_share['desc'] =$show['title'];
$_share['link'] = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&op=yhj&do=show_all&m=bsht_tbk&id=".$show['id'];

$_W['page']['sitename']=$show['title'];

$pagename = '商品详情';



if($_W['container']!='wechat' && $_W['os']=='mobile'){


$show_none = pdo_fetch("SELECT * FROM ".tablename($this->tableitemall)." WHERE uniacid = '{$_W['uniacid']}' AND id = '{$id}'");

if($_GPC['op']=='yhj' || $_GPC['op']=='share' || $_GPC['op']=='view' || empty($_GPC['op'])){
$jumpurl=$show_none['itemyhj_url'];
if(empty($jumpurl)){$jumpurl=$show_none['itemurl'];}
Header("HTTP/1.1 303 See Other"); 
Header("Location: $jumpurl"); 
exit;}else{
$jumpurl=$show_none['itemyhj_url'];
Header("HTTP/1.1 303 See Other"); 
Header("Location: $jumpurl");
}


}


include $this->template('show_all');
