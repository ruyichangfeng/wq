<?php

defined('IN_IA') or exit('Access Denied');

	
		global $_GPC, $_W;
		$cate_id=$_GPC['cate_id'];
		$op=$_GPC['op'];
        $uniacid=$_W['uniacid'];
		$setting = $this->baseset($_W['uniacid']);
		//列表
if($op=='list' || empty($op)){

//ajax
if($_W['ispost'] && $op=='list')
{
	
		$nowpage=$_GPC['limit'];
	
	


$pindex = max(1, intval($nowpage));
$psize = 4;
$list = pdo_fetchall('SELECT * FROM ' . tablename($this->tableitemall) . ' WHERE uniacid = :uniacid AND cate_id = :cate_id AND status=1 ORDER BY RAND(),`displayorder` DESC,`id` DESC LIMIT '.($pindex-1) * $psize.','.$psize,array(':uniacid' => $uniacid,':cate_id' => $cate_id));


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
	$list[$key]['itemfee2']=$list[$key]['jiage'];
	
	if($list[$key]['jiage']<=0){$list[$key]['jiage']=$list[$key]['itemfee'];}


	}elseif(strpos($toptag,"条") > 0){
    
       $pattern='/(.*)元/isU';
	   preg_match($pattern, $toptag, $match);
	   $list[$key]['toptag'] = "领券 ".$match[1]." 元";
	   $list[$key]['tag']='券后价';
	   $list[$key]['jiage']=$list[$key]['jiage2']-$match[1];
	   $list[$key]['jiage2']=$match[1];
	   $list[$key]['itemfee2']=$list[$key]['jiage'];

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
	

		