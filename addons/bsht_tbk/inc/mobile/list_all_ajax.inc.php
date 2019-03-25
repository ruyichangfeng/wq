<?php

defined('IN_IA') or exit('Access Denied');

	
		global $_GPC, $_W;
		$id=$this->strsafe($_GPC['id']);
		$op=$_GPC['op'];
		$uniacid=$_W['uniacid'];
		$cate_id=$this->strsafe($_GPC['cate_id']);
		$setting = $this->baseset($_W['uniacid']);
        $condition = '';

if($cate_id){


$condition .= " AND CONCAT(`cate_id`) = '{$cate_id}' AND status=1";
}else{
$condition .=" AND status=1";
}


		//列表
if($op=='list' || empty($op)){

//ajax
if($_W['ispost'] && $op=='list')
{
	
		$nowpage=$this->strsafe($_GPC['limit']);
	    $toptag=$this->strsafe($_GPC['toptag']);
		$typename=$this->strsafe($_GPC['typename']);
		$minfee=$this->strsafe($_GPC['minfee']);
		$maxfee=$this->strsafe($_GPC['maxfee']);
		$condition1="";
		$condition2="";

if(!empty($toptag)){$condition2 .= " AND CONCAT(`title`) LIKE '%{$toptag}%'";}else{$condition2 .='';}

if(!empty($minfee) && empty($maxfee)){$condition1 .= " AND CONCAT(`itemfee2`) >= cast('{$minfee}' as decimal)";}
if(!empty($maxfee) && empty($minfee)){$condition1 .= " AND CONCAT(`itemfee2`) <= cast('{$maxfee}' as decimal)";}
if(!empty($maxfee) && !empty($minfee)){$condition1 .= " AND CONCAT(`itemfee2`) > cast('{$minfee}' as decimal) AND CONCAT(`itemfee`) < cast('{$maxfee}' as decimal)";}
		
		
		$indexorder=' ORDER BY `displayorder` DESC,`id` DESC LIMIT ';

	
if($typename!='moren' && !empty($typename)){

if($typename=='ishot'){
$indexorder = " ORDER BY `displayorder` DESC, `itemmsell` DESC LIMIT ";//销量排序
}

if($typename=='ishit'){
$indexorder = " ORDER BY `displayorder` DESC, `hit` DESC LIMIT ";//点击排序
}

if($typename=='isfee'){
$indexorder = " ORDER BY `displayorder` DESC, `itemfee2` asc LIMIT ";//售价排序
}

}else{
	

if($setting['isindex']!=2){

	if($setting['isindex']==1 || empty($setting['isindex'])){
	
	$indexorder = " ORDER BY `displayorder` DESC,`id` DESC LIMIT ";//最新倒叙
	
	}//elseif($setting['isindex']==2){

	//$indexorder = " ORDER BY `displayorder` DESC, RAND() LIMIT ";//随机排序

	//}
	elseif($setting['isindex']==3){
	
	$indexorder = " ORDER BY `displayorder` DESC, `itemmsell` DESC LIMIT ";//销量排序

	}elseif($setting['isindex']==4){
	
	$indexorder = " ORDER BY `displayorder` DESC, `itemfee` DESC LIMIT ";//售价排序

	}elseif($setting['isindex']==5){
	
	$indexorder = " ORDER BY `displayorder` DESC, `hit` DESC LIMIT ";//点击排序

	}elseif($setting['isindex']==6){
	
	$indexorder = " ORDER BY `displayorder` DESC, `share` DESC LIMIT ";//分享排序

	}
}else{
$suiji=1;
}
    }
$pindex = max(1, intval($nowpage));
$psize = 16;

$list = pdo_fetchall("SELECT * FROM ".tablename($this->tableitemall)." WHERE uniacid = '{$_W['uniacid']}' $condition $condition1 $indexorder".($pindex - 1) * $psize.','.$psize);



$list = pdo_fetchall('SELECT * FROM ' . tablename($this->tableitemall) . ' WHERE uniacid = :uniacid AND status=1 ' .$condition.$condition1.$condition2 .$indexorder.($pindex-1) * $psize.','.$psize,array(':uniacid' => $uniacid));




if(!empty($keyword) && empty($list))
{
exit(json_encode(array('status' => 301, 'content' => $list)));
}
if (!empty($list))
{
foreach ($list as $key => $value) 
{   
	
	////fmtb	
if($list[$key]['fm']=='dtk'){
	$list[$key]['jiage']=$list[$key]['itemfee2'];
	$list[$key]['jiage2']=$list[$key]['itemfee']-$list[$key]['itemfee2'];
	$list[$key]['tag']=$list[$key]['itemyhj_tit'];
	
	$list[$key]['itemyhj_tit']=explode('，',$list[$key]['itemyhj_tit']);
	
    $list[$key]['toptag']=$list[$key]['itemyhj_tit'][0];

//判断优惠卷到期
if (time()-strtotime($list[$key]['itemyhj_etime'])>=86400){
$list[$key]['toptag']='抢购';
$list[$key]['tag']='抢购';
$list[$key]['jiage']=$list[$key]['itemfee2'];
}
//判断优惠卷到期
	

    if($list[$key]['istmall']==1){
	$list[$key]['icon']=tomedia("../addons/bsht_tbk/res/images/tmall.png");
	}else{
	$list[$key]['icon']=tomedia("../addons/bsht_tbk/res/images/taobao.png");
	}

	$list[$key]['pic']=tomedia($list[$key]['itempic']);
	$list[$key]['url']=$this->createMobileUrl('show_all', array('id' => $list[$key]['id'],'op' => 'share'));
	$list[$key]['yhjurl']=$this->createMobileUrl('show_all', array('id' => $list[$key]['id'],'op' => 'yhj'));
	$list[$key]['yhjurl2']=$this->createMobileUrl('show_mini', array('id' => $list[$key]['id'],'op' => 'yhj'));

	if(time()-$list[$key]['atime']<=86400){
	$list[$key]['isnew'] = '<span class="wapnewicon">新品</span>';
	}else{
	$list[$key]['isnew']='';
	}
	//
   }//fmdtk


if($list[$key]['fm']=='tblm' || $list[$key]['fm']=='mrjx'){
    $list[$key]['jiage']=$list[$key]['itemfee'];
	$list[$key]['tag']=$list[$key]['itemyhj_tit'];


	
	if($list[$key]['tag']=='无'){$list[$key]['tag']='抢购';}else{$list[$key]['tag']=str_replace("", "",$list[$key]['tag']);}
	
    $toptag = $list[$key]['itemyhj_tit'];
	
	
	if(strpos($toptag,"减") > 0){
	$pattern='/减(.*)元/isU';
	preg_match($pattern, $toptag, $match);
	$list[$key]['toptag'] = "领券 ".$match[1]." 元";
	$list[$key]['jiage']=$list[$key]['jiage']-$match[1];
	$list[$key]['jiage2']=$match[1];
	
	if($list[$key]['jiage']<=0){$list[$key]['jiage']=$list[$key]['itemfee'];}


	}elseif(strpos($toptag,"条") > 0){
    
       $pattern='/(.*)元/isU';
	   preg_match($pattern, $toptag, $match);
	   $list[$key]['toptag'] = "领券 ".$match[1]." 元";
	   $list[$key]['tag']='券后价';
	   $list[$key]['jiage']=$list[$key]['jiage2']-$match[1];
	   $list[$key]['jiage2']=$match[1];

	   if($list[$key]['jiage']<=0){$list[$key]['jiage']=$list[$key]['itemfee'];}

	}else{
	
    $list[$key]['toptag']='抢购';
	}

//判断优惠卷到期
if (time()-strtotime($list[$key]['itemyhj_etime'])>=86400){
$list[$key]['toptag']='抢购';
$list[$key]['tag']='抢购';
$list[$key]['jiage']=$list[$key]['itemfee'];
}
//判断优惠卷到期

	$list[$key]['pic']=tomedia($list[$key]['itempic']);
	$list[$key]['url']=$this->createMobileUrl('show_all', array('id' => $list[$key]['id'],'op' => 'share'));
	$list[$key]['yhjurl']=$this->createMobileUrl('show_all', array('id' => $list[$key]['id'],'op' => 'yhj'));
	$list[$key]['yhjurl2']=$this->createMobileUrl('show_mini', array('id' => $list[$key]['id'],'op' => 'yhj'));

	if(time()-$list[$key]['atime']<=86400){
	$list[$key]['isnew'] = '<span class="wapnewicon">新品</span>';
	}else{
	$list[$key]['isnew']='';
	}

}//fmtb
}
$sta =200;
}
else
{
$sta =-103;
}
exit(json_encode(array('status' => $sta, 'content' => $list)));
}
//ajax

}
//列表
	

		