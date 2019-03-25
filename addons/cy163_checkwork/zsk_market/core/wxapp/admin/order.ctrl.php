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
	public function refund(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order"); 
 		$shopid=intval($_GPC['shopid']);
 		$no=trim($_GPC['num']);
 		$order0=$model->where("order_no = '$no' and shopid=".$shopid)->get();
 		$out=array("sts"=>0,"errmsg"=>"退款失败");
 		if(empty($order0)){
 			$out['errmsg']="订单不存在";
 			echo json_encode($out);
 			exit;
 		}
 		if(intval($order0['pay_status'])!=1||intval($order0['pay_way'])!=1){ 
 			echo json_encode($out);
 			exit;
 		}
 		$setting=getSetting("pay",true);
		//微信
		$wxpay=new Wxpay($setting,true); 

 		 
	 	$xml=array( 
	 		"out_trade_no"=>$order0['wxpay_no'],
	 		"out_refund_no"=>$wxpay->orderNumber("TK"),
	 		"notify_url"=>"https://wxpay.wxutil.com/pub_v2/pay/notify.v2.php", 
	 		"refund_fee"=>floatval($order0['money_pay'])*100,
	 		"total_fee"=>floatval($order0['money_pay'])*100//元换分
	 	);   
	 	$msg=$wxpay->refund($xml); 
	 	if($msg['return_code']=="SUCCESS" ){
	 		if(strlen($order0['refund_no'])<10){
	 			$tab=$model->tablename("order");
		 		$data=array(
		 			"refund_money"=>$xml['refund_fee']/100,
		 			"pay_status"=>-1,
		 			"status"=>-4,
		 			"refund_no"=>$xml['out_refund_no'],
		 			"refund_date"=>date("Y-m-d H:i:s",time()),
		 			"agent_p0"=>"","agent_p1"=>"","agent_p2"=>"",
		 		);
		 		if(strlen($order0['refund_reason'])<1)$data['refund_reason']="商家退款";
		 		$model->where("order_no='".$order0['order_no']."'")->limit(1)->save($data); 

	 			$ord=$model->where("order_no='".$order0['order_no']."'")->get();
	 				$tab0=$model->tablename("agent");
	 			
	 			if(intval($ord['agent_p0'])>0){
		 			$sql="UPDATE $tab0 SET balance_freezing=balance_freezing-".floatval($order0['money_agent0'])." WHERE code='".$order0['agent_p0']."' LIMIT 1";
		 			$model->query($sql);
	 			} 
	 			if(intval($ord['agent_p1'])>0){ 
		 			$sql="UPDATE $tab0 SET balance_freezing=balance_freezing-".floatval($order0['money_agent1'])." WHERE code='".$order0['agent_p1']."' LIMIT 1";
		 			$model->query($sql);
	 			}
	 			if(intval($ord['agent_p2'])>0){
	 				$sql="UPDATE $tab0 SET balance_freezing=balance_freezing-".floatval($order0['money_agent2'])." WHERE code='".$order0['agent_p2']."' LIMIT 1";
		 			$model->query($sql);
	 			}
		 		//减少代理冻结余额 
	 
		 		//返回店铺冻结余额
		 		$tab1=$model->tablename("shop");
		 		$shopincome=floatval($order0['money_pay'])-floatval($order0['money_agent0'])-floatval($order0['money_agent1'])-floatval($order0['money_agent2'])-floatval($order0['money_agentbuy'])-floatval($order0['money_platform']);
		 		$sql="UPDATE $tab1 SET balance_freezing=balance_freezing-".$shopincome." WHERE id=".$shopid." LIMIT 1" ;
		 		$model->query($sql); 
		 		$res=order_refund($ord['openid'],$ord);
		 		$out['msg']="退款成功";
	 	 		$out['sts']=1;
	 		} else{
	 			$out['msg']="不可重复退款"; 
	 		}
	 		
	 	}
	 	$out['api']=$msg;
	 	echo json_encode($out);
	}
	function getOrderBySts(){
		global $_W,$_GPC; 
		$model=Model("order");
	 	$uniacid=intval($_W['uniacid']);
	 	
  		$openid=trim($_POST['openid']);
  		$shopid=intval($_GPC['shopid']);

		//判断是不是管理员在查所有订单
  		 
		$tb_detail=$model->tablename('orderdetail'); 
		$tb_order=$model->tablename('order');
		$tb_goods=$model->tablename('goods');
		$tb_case=$model->tablename('goodscase');
		$tb_shop=$model->tablename("shop");
		$sts=intval($_POST['sts']);
		 
		$where="$tb_order.uniacid=$uniacid "; 
		$keyword=trim($_GPC['keyword']);
		$where.=" and $tb_order.shopid=".$shopid;
		$orderby="$tb_order.`date` desc";
		if($sts==98&& strlen($keyword)>=5){//管理员 搜索订单
			$where="$tb_order.uniacid=$uniacid and ($tb_order.mobile like '%$keyword%' or $tb_order.order_no like '%$keyword%')  and $tb_order.shopid=".$shopid;
		}else if($sts==-1){
			$where.=" and ($tb_order.status<-1 or $tb_order.status>4 )";
			$orderby="$tb_order.`refund_date` desc";
		}else{
			if($sts==5){
            $where.=" and $tb_order.status in (1,2,3,4,-1,-2)";
			}
			else{
			$where.=" and $tb_order.status=".$sts;
			}
		}
	  
		$sql="SELECT $tb_order.*,$tb_order.order_no as num,$tb_shop.name as shopname FROM $tb_order LEFT JOIN $tb_shop ON $tb_order.shopid=$tb_shop.id WHERE $where ORDER BY ".$orderby;
		$orders=$model->pagenation($sql);
		$orders['lastSql']=$sql;

		$idstr="";
		foreach ($orders['dataset'] as $key => $val) {
			$idstr.=$val['id'].",";
		} 
		$idstr=substr($idstr,0,strlen($idstr)-1);
		$sql2="SELECT  $tb_case.isopt,$tb_case.thumb ,temptb.* FROM (SELECT {$tb_detail}.id as did,orderid as `oid`, {$tb_detail}.goodscaseid,{$tb_detail}.goodsname  ,{$tb_detail}.casename  ,{$tb_detail}.count  ,{$tb_detail}.goodsid  , {$tb_goods}.picture as pic FROM {$tb_detail} LEFT JOIN {$tb_goods} on {$tb_goods}.id = {$tb_detail}.goodsid WHERE {$tb_detail}.orderid in ($idstr) )  as temptb LEFT JOIN $tb_case ON temptb.goodscaseid=$tb_case.id ";
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