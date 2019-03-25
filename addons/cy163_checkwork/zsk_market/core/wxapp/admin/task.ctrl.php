<?php 
//店铺后台
class Order extends ZskWxapp{
	public function checkShopAdmin(){
		global $_W,$_GPC;

 		$model=Model("member");
 		$uniacid=intval($_W['uniacid']);
 		$openid=$_GPC['openid'];
 		$shopid=$_GPC['shopid'];
 		$mem=$model->exist("openid='".$openid."' and adminshopid=$shopid ");

		if(!$mem){
			echo json_encode(array("status"=>-1,"msg"=>"权限不足"));
			exit;
		} 
	}
	function getOrderBySts(){
		global $_W,$_GPC; 
		$model=Model("order");
	 	$uniacid=intval($_W['uniacid']);
	 	
  		$openid=trim($_POST['openid']);
  		

		//判断是不是管理员在查所有订单
  		$isAdmin=false; 
		$mem=Model("member")->where("openid='$openid' and uniacid=$uniacid")->get("adminshopid,admin,id,openid,nickname");
		$tb_detail=$model->tablename('orderdetail'); 
		$tb_order=$model->tablename('order');
		$tb_goods=$model->tablename('goods');
		$tb_case=$model->tablename('goodscase');
		$tb_shop=$model->tablename("shop");
		if(is_numeric($_POST['sts'])){
			$sts=intval($_POST['sts']);
		};
		$where="$tb_order.uniacid=$uniacid and $tb_order.status={$sts}"; 
		$keyword=trim($_GPC['keyword']);
		$where.=" and $tb_order.shopid=".$mem['adminshopid'];

		if($sts==98&&strlen($keyword)>=5){//管理员 搜索订单
			$where="$tb_order.uniacid=$uniacid and ($tb_order.mobile like '%$keyword%' or $tb_order.order_no like '%$keyword%')  and $tb_order.shopid=".$mem['adminshopid'];
		}
		 
	 
	/*	$orders=$model->where($where)->order(" `date` desc")->page("*,order_no as `num`"); 
		$orders['sql']=$model->lastSql(); */
		$sql="SELECT $tb_order.*,$tb_order.order_no as num,$tb_shop.name as shopname FROM $tb_order LEFT JOIN $tb_shop ON $tb_order.shopid=$tb_shop.id WHERE $where ORDER BY $tb_order.`date` desc";
		$orders=$model->pagenation($sql);
		$orders['lastSql']=$sql;

		$idstr="";
		foreach ($orders['dataset'] as $key => $val) {
			$idstr.=$val['id'].",";
		} 
		$idstr=substr($idstr,0,strlen($idstr)-1);
		$sql2="SELECT $tb_case.isopt,$tb_case.thumb ,temptb.* FROM (SELECT {$tb_detail}.id as did,orderid as `oid`, {$tb_detail}.goodscaseid,{$tb_detail}.goodsname  ,{$tb_detail}.count  ,{$tb_detail}.goodsid  , {$tb_goods}.picture as pic FROM {$tb_detail} LEFT JOIN {$tb_goods} on {$tb_goods}.id = {$tb_detail}.goodsid WHERE {$tb_detail}.orderid in ($idstr) )  as temptb LEFT JOIN $tb_case ON temptb.goodscaseid=$tb_case.id ";
		$orders['action']=$isAdmin;  
		 $det=pdo_fetchall($sql2);   
		//弄成前端要的格式  
		foreach ($orders["dataset"] as $key => $val) { 
			$orders["dataset"][$key]['cases']=array();  
			foreach ($det as $k => $v) {
				if($val['id']==$v['oid']){
					$v['picture']=$_W['attachurl'].$v['pic']; 
					array_push($orders["dataset"][$key]['cases'], $v);
				}
			} 
		}  
		echo JSON_OUT($orders,true);
	}
}