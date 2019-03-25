<?php

defined('IN_IA') or exit('Access Denied');

	
		global $_GPC, $_W;
		$id=$this->strsafe($_GPC['id']);
		$op=$_GPC['op'];
		$cate_id=$this->strsafe($_GPC['cate_id']);
        $uniacid=$_W['uniacid'];
		$setting = $this->baseset($_W['uniacid']);
		//列表


//ajax
if($_W['ispost'])
{
	    $typename=$this->strsafe($_GPC['typename']);
		$minfee=$this->strsafe($_GPC['minfee']);
		$maxfee=$this->strsafe($_GPC['maxfee']);
		$indexorder="";
		$condition1="";
		$condition2="";
	$condition="";
    $condition.=" AND status=1 ";
	$keywords=$_GPC['keywords'];
	$keywords2=$_GPC['keywords2'];

if(!empty($minfee) && empty($maxfee)){$condition1 .= " AND CONCAT(`itemfee2`) >= cast('{$minfee}' as decimal)";$suiji=0;}
if(!empty($maxfee) && empty($minfee)){$condition1 .= " AND CONCAT(`itemfee2`) <= cast('{$maxfee}' as decimal)";$suiji=0;}
if(!empty($maxfee) && !empty($minfee)){$condition1 .= " AND CONCAT(`itemfee2`) > cast('{$minfee}' as decimal) AND CONCAT(`itemfee`) < cast('{$maxfee}' as decimal)";$suiji=0;}

		if($typename!='moren' && !empty($typename)){

if($typename=='ishot'){
$indexorder = " ORDER BY `displayorder` DESC, `itemmsell` DESC LIMIT ";//销量排序
$suiji=0;
}

if($typename=='ishit'){
$indexorder = " ORDER BY `displayorder` DESC, `hit` DESC LIMIT ";//点击排序
$suiji=0;
}

if($typename=='isfee'){
$indexorder = " ORDER BY `displayorder` DESC, `itemfee2` asc LIMIT ";//售价排序
$suiji=0;
}

}else{

$indexorder=' ORDER BY `displayorder` DESC,`id` DESC LIMIT ';

}
		
		



if (strrpos($keywords," ")) {
 $keywords = explode(" ", $keywords);
 $result_num = count ($keywords);
 if($result_num==1){
 $condition .= " AND CONCAT(`title`) LIKE '%{$keywords[0]}%'";
 }
 if($result_num==2){
 $condition .= " AND CONCAT(`title`) LIKE '%{$keywords[0]}%' AND CONCAT(`title`) LIKE '%{$keywords[1]}%'";
 }
 if($result_num==3){
 $condition .= " AND CONCAT(`title`) LIKE '%{$keywords[0]}%' AND CONCAT(`title`) LIKE '%{$keywords[1]}%' AND CONCAT(`title`) LIKE '%{$keywords[2]}%'";
 }
 if($result_num==4){
 $condition .= " AND CONCAT(`title`) LIKE '%{$keywords[0]}%' AND CONCAT(`title`) LIKE '%{$keywords[1]}%' AND CONCAT(`title`) LIKE '%{$keywords[2]}%' AND CONCAT(`title`) LIKE '%{$keywords[3]}%'";
 }
 if($result_num==5){
 $condition .= " AND CONCAT(`title`) LIKE '%{$keywords[0]}%' AND CONCAT(`title`) LIKE '%{$keywords[1]}%' AND CONCAT(`title`) LIKE '%{$keywords[2]}%' AND CONCAT(`title`) LIKE '%{$keywords[3]}%' AND CONCAT(`title`) LIKE '%{$keywords[4]}%'";
 }
 if($result_num==6){
 $condition .= " AND CONCAT(`title`) LIKE '%{$keywords[0]}%' AND CONCAT(`title`) LIKE '%{$keywords[1]}%' AND CONCAT(`title`) LIKE '%{$keywords[2]}%' AND CONCAT(`title`) LIKE '%{$keywords[3]}%' AND CONCAT(`title`) LIKE '%{$keywords[4]}%' AND CONCAT(`title`) LIKE '%{$keywords[5]}%'";
 }
 if($result_num==7){
 $condition .= " AND CONCAT(`title`) LIKE '%{$keywords[0]}%' AND CONCAT(`title`) LIKE '%{$keywords[1]}%' AND CONCAT(`title`) LIKE '%{$keywords[2]}%' AND CONCAT(`title`) LIKE '%{$keywords[3]}%' AND CONCAT(`title`) LIKE '%{$keywords[4]}%' AND CONCAT(`title`) LIKE '%{$keywords[5]}%' AND CONCAT(`title`) LIKE '%{$keywords[6]}%'";
 }
}else{

$condition .= " AND CONCAT(`title`) LIKE '%{$keywords}%'";
}


			
	$nowpage=$this->strsafe($_GPC['limit']);

	//$indexorder .= " ORDER BY `displayorder` DESC,`id` DESC LIMIT ";//最新倒叙

$pindex = max(1, intval($nowpage));
$psize = 16;


$list = pdo_fetchall('SELECT * FROM ' . tablename($this->tableitemall) . ' WHERE uniacid = :uniacid AND status=1' .$condition.$condition1.$indexorder.($pindex-1) * $psize.','.$psize,array(':uniacid' => $uniacid));




if(!empty($keywords) && empty($list)){
	   exit(json_encode(array('status' => 301, 'content' => $list)));
	}
if (!empty($list))
{




foreach ($list as $key => $value) 
{   

	
if($list[$key]['fm']=='dtk'){
	$list[$key]['jiage']=$list[$key]['itemfee2'];
	$list[$key]['jiage2']=$list[$key]['itemfee']-$list[$key]['itemfee2'];
	$list[$key]['tag']=$list[$key]['itemyhj_tit'];
	
	$list[$key]['itemyhj_tit']=explode('，',$list[$key]['itemyhj_tit']);
	
    $list[$key]['toptag']=$list[$key]['itemyhj_tit'][0];



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
}

if($list[$key]['fm']=='tblm' || $list[$key]['fm']=='mrjx'){
{

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



	$list[$key]['pic']=tomedia($list[$key]['itempic']);
	$list[$key]['url']=$this->createMobileUrl('show_all', array('id' => $list[$key]['id'],'op' => 'share'));
	$list[$key]['yhjurl']=$this->createMobileUrl('show_all', array('id' => $list[$key]['id'],'op' => 'yhj'));
	$list[$key]['yhjurl2']=$this->createMobileUrl('show_mini', array('id' => $list[$key]['id'],'op' => 'yhj'));

	if(time()-$list[$key]['atime']<=86400){
	$list[$key]['isnew'] = '<span class="wapnewicon">新品</span>';
	}else{
	$list[$key]['isnew']='';
	}


}
}

}






$sta =200;
	}else{
		$sta =-103;
	}
	exit(json_encode(array('status' => $sta, 'content' => $list)));
}
//ajax

	

		