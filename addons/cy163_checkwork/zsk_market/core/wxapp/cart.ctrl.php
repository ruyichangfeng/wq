<?php 
class Cart extends ZskWxapp{
	//我的购物车
 	public function mycart(){
 		global $_W,$_GPC;
		$model=Model("membercart");
		$uniacid=intval($_W['uniacid']);

		$openid=trim($_POST['openid']);
		$act2=$_POST['act2']; 

		$tab0=$model->tablename("membercart");
		$tab1=$model->tablename("goodscase");
		$tab2=$model->tablename("goods"); 
		$tab3=$model->tablename("shop");
		$out=array(
			"shops"=>array(),
			"cases"=>array()
		);
		$shop=array(); 
		
		if(strlen($openid)>20){
			//查询我的购物车里面的商品属于哪些店铺
			$today=date("Y-m-d",time());
			$sql="SELECT $tab3.name,$tab0.shopid,$tab3.logo,$tab3.id FROM $tab3 LEFT JOIN $tab0 ON $tab3.id=$tab0.shopid WHERE ($tab3.limitdate>='$today' or $tab3.limitdate is null) and $tab0.uniacid=$uniacid  group by $tab0.shopid order by $tab0.`date` desc";
			$shops=$model->query($sql);

	 		$sids=",";
			foreach ($shops as $key => $val) {
				$sids.=$val['id'].",";
			}
			//三表链接查询，sql0为cart和case链接获取商品价格，库存，数量等,sql1获取商品名,图片 
			$sql0="SELECT {$tab1}.opt1,{$tab1}.opt2,{$tab1}.option1,{$tab1}.option2,{$tab1}.id,{$tab1}.isopt,$tab0.`date` as `date`,{$tab1}.id as caseid,{$tab0}.uniacid as unaicid,$tab1.thumb, {$tab1}.price as price,{$tab1}.stock as stock,{$tab1}.name as casename, {$tab0}.id as cartid,{$tab0}.count as goodscount,{$tab0}.goodsid as goodsid,{$tab0}.shopid as shopid,{$tab0}.goodscateid as cateid FROM {$tab0} LEFT JOIN  {$tab1} on {$tab0}.goodscaseid={$tab1}.id  WHERE ($tab1.isopt=0 or ($tab1.isopt=1 and $tab1.status>0)) and  {$tab0}.openid='".$openid."' and {$tab0}.status=1 order by {$tab0}.date asc ";
			$sql1="SELECT  0 as checked, {$tab2}.name as goodsname,{$tab2}.picture as pic ,{$tab2}.price as goodsprice ,`tb_temp`.* FROM ($sql0) as tb_temp LEFT JOIN {$tab2} on {$tab2}.id=`tb_temp`.goodsid where $tab2.id>0";
		 	
			$cases=$model->query($sql1);  
			//弄成前端要的格式   
			$cids=",";  
			foreach ($cases as $k => $v) {  
				$cids.=$v['shopid'].",";
				if(stripos($sids, ','.$v['shopid'].',')===false){
					 
					continue;
				} 
				if(strlen($v['thumb'])>5){
					//替换自定义规格图片
					$cases[$k]['src']=$_W['attachurl'].$v['thumb'];
				}else if(strlen($v['pic'])>5){
					$cases[$k]['src']=$_W['attachurl'].$v['pic'];
				}else{
					$cases[$k]['src']="";
				}
				if(!floatval($v['price'])>0){
					//替换显示的最低价
					$cases[$k]['price']=floatval($v['goodsprice']);
				} 
				array_push($out['cases'], $v);
			}	   
			foreach ($shops as $key => $val) {
				if(stripos($cids, ','.$val['id'].',')===false){
					unset($shops[$key]);
					continue;
				}
			}
			
			$out['shops']=$shops;
		}  
		echo JSON_OUT($out,true);
 	}
 	public function delcart(){
 		global $_W,$_GPC;
 		$model=Model("membercart");
 		$uniacid=intval($_W['uniacid']);
 		$cid=intval($_GPC['cid']);
 		$openid=trim($_GPC['openid']);
 		$res=$model->limit(1)->delete("id=$cid and openid='$openid'");
 		echo json_encode(array("status"=>$res));
 	}

 	//商品加入购物车
	public function addcart(){ 
		global $_W,$_GPC;
		$model=Model("membercart");
		$uniacid=intval($_W['uniacid']);
		
		$shopid=intval($_GPC['shopid']);
		$gid=intval($_POST['gid']);
		$count=intval($_POST['count']);
		$openid=$_POST['openid']; 
		$caseid=intval($_POST['caseid']);
		$out=array("sts"=>0);
		//验证商品id,数量，openid
		if(($gid>0&&$count>0)&&strlen($openid)>20){ 
			$car0=$model->where("openid='".$openid."' and goodsid=".$gid." and goodscaseid=".$caseid)->get("id"); 
			if(intval($car0['id'])>0){//购物车已经有了，叠加数量
				$sql="UPDATE :table SET count=count+{$count},`date`=".time()." WHERE id=".$car0['id']." limit 1";
				$res=$model->query($sql);
				$out['sts']=1;
			}else{
				$cart=array(
					"goodsid"=>$gid,
					'date'=>time(),
					"count"=>$count,
					"goodscaseid"=>intval($_POST['caseid']),
					"goodscateid"=>intval($_POST['cateid']),
					"openid"=>$openid,
					"status"=>1,
					"uniacid"=>intval($_W['uniacid']),
					"shopid"=>intval($_GPC['shopid'])
				);
				$res=$model->add($cart); 
				if($res>0){
					$out['sts']=1;
				}
			} 
		}else{
			$out['sts']=-1;
		}
		echo json_encode($out);
	}
}
	 