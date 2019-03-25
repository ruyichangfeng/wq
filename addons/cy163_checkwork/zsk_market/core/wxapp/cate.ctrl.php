<?php
class Cate extends ZskWxapp{
/*	public function CateTwo(){
		global $_W,$_GPC;
		$model=Model("category");
		$uniacid=intval($_W['uniacid']);

		$parents=$model->getall("id,name,parentid as pid","status>0 and parentid=0" ,"sort desc"); 
		$idstr="";
		foreach ($parents as $key => $val) {
			$idstr.=$val['id'].",";
		}

		$idstr=substr($idstr,0,(strlen($idstr)-1)); 
		$children=$model->where("status>0 and parentid in ({$idstr}) ")->order("sort desc")->getall("id,name,parentid as pid");

		echo JSON_OUT(array("parents"=>$parents,"children"=>$children));
	} 
	public function CateTree(){  
		global $_W,$_GPC;
		$model=Model("category");
		$uniacid=intval($_W['uniacid']);

		$list=$model->where("status>0 and uniacid=$uniacid")->order('sort desc')->getall("id,name,parentid as pid,logo");
		foreach ($list as $key => $val) {
			if(strlen($val['logo'])>5){
				$list[$key]['logo']=$_W['attachurl'].$val['logo'];
			}
			
		} 
		$out=childtree($list);
		echo JSON_OUT($out,true); 
	}*/
	public function  getcate0(){
		global $_W,$_GPC;
		$model=Model("category");
		$uniacid=intval($_W['uniacid']);

		$cates=$model->where("uniacid='".$_W['uniacid']."' and parentid=0 and status>0")->order("sort desc")->getall("id,name,logo");
		echo JSON_OUT($cates,true);
	}
	public function getcate1(){
		global $_W,$_GPC;
		$model=Model("category");
		$uniacid=intval($_W['uniacid']);
		$res=array("type"=>0);//0为分类，1位商品
		$res['data']=$model->where("uniacid='".$_W['uniacid']."' and parentid=".intval($_GPC['cateid']))->order("sort desc")->getall("id,name,logo,status");
		if(count($res['data'])<1){
			$m3=Model("goods");
			$goods=$m3->where("cateid=".intval($_GPC['cateid'])." and uniacid=$uniacid and status>0")->limit(50)->order("sort desc")->getall("id,name,picture as logo,price,sellCount,sellCount0");
			$res['data']=getGoodsSimpleInfo($goods);
			$res['type']=1; 
		}
		if(count($res['data'])>=1){
			$m3=Model("goods");
			$goods=$m3->where("cateid=".intval($_GPC['cateid'])." and uniacid=$uniacid and status>0")->limit(50)->order("sort desc")->getall("id,name,picture as logo,price,sellCount,sellCount0");
			$res['datag']=getGoodsSimpleInfo($goods);
		}
		foreach ($res['datag'] as $key => $val) {
			if(strlen($val['logo'])>5){
				$res['datag'][$key]['src']=$_W['attachurl'].$val['logo'];
			}
		}
		foreach ($res['data'] as $key => $val) {
			if(strlen($val['logo'])>5){
				$res['data'][$key]['src']=$_W['attachurl'].$val['logo'];
			}
		}
		echo JSON_OUT($res,true);
	} 
}
	 