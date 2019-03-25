 <?php
 class Order extends ZskPage
 { 
 	/*
 	订单状态status
	0未支付[待付款]，1已下单[待发货]，2已发货[待收货]，3已收货[已完成]，4已确认,-1已取消，-2申请退款中,-3同意退款未发货,-4退款完成 ,    5申请换货中，6同意换货待发货，7已换货
 	支付状态pay_status
	0未支付，1已支付,-1已退款
	*/

 	public function listview(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order");
		$ordertable=$model->tablename("order");
 		$shopid=getShopID();
 		$param=array();
		$fields="id,wxpay_no,`order_no` as num,`money`,province as prov,city,`county`,contact as `name`,mobile,remark,date as `time` ,`abstract` as abs,pay_way,pay_status,status,money_pay,comment";
		$where=" uniacid=$uniacid and shopid=$shopid ";
		if(isset($_POST['sts'])){
			$sts=intval($_POST['sts']); 
			if($sts<9&& $sts>0){
				$where.=" and status={$sts}";
				$param['sts']=$sts;
			}else{
//				$where.=" and status =0 ";
			}  
		} 
		if(strlen($_POST["mobile"])>0){
			$where.=" and mobile like '%".($_POST["mobile"])."%' ";
			$param['mobile']=$_POST["mobile"];
		}

		if(strlen($_GPC["type"])>0){
			
			if(intval($_GPC['type'])==1){
//				$where.=" and (discounttype=1 or discounttype=0) ";
			}else{
				$where.=" and discounttype=".intval($_GPC["type"])." ";
			}
			$param['type']=$_POST["type"];
		}
		if(strlen($_POST["num"])>0){
			$where.=" and `order_no` like '%".($_POST["num"])."%' ";
			$param['num']=$_POST["num"];
		}
		if(strlen($_POST["date"])>0){
			$where.=" and date like '%".($_POST["date"])."%' ";
			$param['date']=$_POST["date"]; 
		}
//		$sql = 'select '.$fields.' from  '.$ordertable.' where '.$where.' order by "data" desc';
//		var_dump($sql);die;

		$page=$model->where($where)->order('date desc')->page($fields);
		$orderlist=$page['dataset'];
		foreach ($orderlist as $key => $val) {
			$orderlist[$key]['address']=$val['prov'].$val['city'].$val['county'];
		}
		$page['url']=$this->routeUrl("order.listview");
		$nowe7=true;
		include $this->template("web/order/order-list");
 	} 
  	public function detail(){
  		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order");
  		$oid=($_GPC['order']);
		$shop=getShopInfo();
		$shopid=intval($shop['id']);
		$setting=getSetting("all"); 
		$order=$model->where("order_no='".$oid."' and uniacid=$uniacid and shopid=$shopid")->get("*");

		if(!empty($order)){ 
			
			$tb_det=$model->tablename("orderdetail");
			$tb_goods=$model->tablename("goods");
			$sql="SELECT $tb_det.*,$tb_goods.picture FROM $tb_det LEFT JOIN $tb_goods ON $tb_det.goodsid = $tb_goods.id WHERE $tb_det.orderid='".$order['id']."'";
			$m2=Model("orderdetail"); 
			$detlist=$m2 ->query($sql);  
			$explist=Model("shopexpress")->where("shopid=$shopid and uniacid=$uniacid and status>0")->order("status desc")->getall();
			 $explist0=json_decode(file_get_contents(ZSK_STATIC."datas/express.json"),true); 
			foreach ($explist as $key => $val) {
				foreach ($explist0 as $k=> $v) {
					if($val['code']==$v['code']){
						$explist[$key]['name']=$v['name'];
					}
				}
			}
			
			if(strlen($order['expressno'])>10){
				$express=expressInfo($setting['kdniao_id'],$setting['kdniao_key'],$order['expresstype'],$order['expressno']);
			 
			}  
		 	$member=Model("member")->where("uniacid=$uniacid and openid='".$order['openid']."'")->get();
			include $this->template("web/order/order-detail");
		}else{
			message("订单不存在！");
		} 
  	}

	 public function detail1(){
		 global $_W,$_GPC;
		 $uniacid=intval($_W['uniacid']);
		 $model=Model("order");
		 $oid=($_GPC['order']);
		 $shop=getShopInfo();
		 $shopid=intval($shop['id']);
		 $setting=getSetting("all");
		 $order=$model->where("order_no='".$oid."' and uniacid=$uniacid and shopid=$shopid")->get("*");

		 if(!empty($order)){

			 $tb_det=$model->tablename("orderdetail");
			 $tb_goods=$model->tablename("goods");
			 $sql="SELECT $tb_det.*,$tb_goods.picture FROM $tb_det LEFT JOIN $tb_goods ON $tb_det.goodsid = $tb_goods.id WHERE $tb_det.orderid='".$order['id']."'";
			 $m2=Model("orderdetail");
			 $detlist=$m2 ->query($sql);
			 $explist=Model("shopexpress")->where("shopid=$shopid and uniacid=$uniacid and status>0")->order("status desc")->getall();
			 $explist0=json_decode(file_get_contents(ZSK_STATIC."datas/express.json"),true);
			 foreach ($explist as $key => $val) {
				 foreach ($explist0 as $k=> $v) {
					 if($val['code']==$v['code']){
						 $explist[$key]['name']=$v['name'];
					 }
				 }
			 }

			 if(strlen($order['expressno'])>10){
				 $express=expressInfo($setting['kdniao_id'],$setting['kdniao_key'],$order['expresstype'],$order['expressno']);

			 }
			 $member=Model("member")->where("uniacid=$uniacid and openid='".$order['openid']."'")->get();
			 include $this->template("web/order/order-detail1");
		 }else{
			 message("订单不存在！");
		 }
	 }

 	public function sendExpress(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order"); 

 		
		$express=trim($_POST['express']);
		$expresstype=trim($_POST['expresstype']);
		$oid=$_POST['oid'];
		$noexp=trim($_POST['noexp']);
		$order=$model->where("order_no='".$oid."'")->get();
		if(intval($order['pay_status'])<0){
			if(intval($order['discounttype'])==4||intval($order['discounttype'])==5){
				message("活动未完成不能发货");exit;
			}
			if(intval($order['pay_way'])==1){
				message("微信未支付不能发货");exit;
			}
		}
		
		$url=$this->routeUrl("order.detail")."&order=".$oid;
		if(!empty($_GPC['burl'])){
			$url=$_GPC['burl'];//拼团页面过来的
		}
		if($noexp==1&& strlen($oid)>10){//不需要快递发货
			$res=$model->where("order_no='".$oid."'")->limit(1)->save(array("expresstype"=>$expresstype,"expressno"=>$express,"sendtime"=>date("Y-m-d H:i:s",time()),'status'=>2)); 
			$order['expresscom']="商家配送";
			if($res>0){
				$res=order_send($order['openid'],$order);
				message("操作成功",$url);
			}
		}else{ 
			if($expresstype!='wx'){
				if(strlen($express)>5&& strlen($oid)>10){ 
					$res=$model->where("order_no='".$oid."'")->limit(1)->save(array("expresstype"=>$expresstype,"expressno"=>$express,"sendtime"=>date("Y-m-d H:i:s",time()),'status'=>2)); 
					if($res>0){
						$res=order_send($order['openid'],$order);
						message("操作成功",$url);
					}else{
							message("参数错误1！");
					}
				}
			}
			else{
				$res=$model->where("order_no='".$oid."'")->limit(1)->save(array("expresstype"=>$expresstype,"expressno"=>" ","sendtime"=>date("Y-m-d H:i:s",time()),'status'=>2));
					if($res>0){
						$res=order_send($order['openid'],$order);
						message("操作成功",$url);
					}else{
							message("参数错误2！");
					}
			}
		}
 	}
 	public function chgsts(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order"); 
 		$shopid=getShopID();
 		$no=trim($_GPC['order_no']);
 		$ord=array( 
 			"status"=>intval($_GPC['ordersts']) 
 			
 		);
 		if(isset($_GPC['paysts'])){
 			$ord['pay_status']=intval($_GPC['paysts']);
 		}
 		$model->where("shopid=$shopid and order_no='$no' and uniacid=$uniacid")->limit(1)->save($ord);
 		 
 		message("操作成功",$this->routeUrl("order.detail")."&order=".$_GPC['order_no']);
 	}
 	//订单改价
 	public function changePayMoney(){
  		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order"); 
 		$shopid=getShopID();
 		$no=trim($_GPC['order_no']);
 		$ord=array( 
 			"money_pay"=>floatval($_GPC['money'])
 		);
 		$model->where("shopid=$shopid and order_no='$no' and uniacid=$uniacid")->limit(1)->save($ord);
 		 
 		message("操作成功",$this->routeUrl("order.detail")."&oid=".$_GPC['oid']);
  	}
  	//订单退款
  	function refundOrder(){
  		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order"); 
 		$shopid=getShopID();
 		$no=trim($_GPC['order']);
 		$order0=$model->where("order_no = '$no'")->get();
 		$tabc= $model->tablename("order");
 		$sql="SELECT sum(money_pay) as totalmoney FROM $tabc WHERE wxpay_no=".$order0['wxpay_no']." and pay_way=1";
 		$totalmoney=pdo_fetchall($sql); 
 		$setting=getSetting("pay",true);
		//微信
		$wxpay=new Wxpay($setting,true); 
		if($order0['trade_state']=="REFUND"){
			message("不可重复退款");exit;
		}
 		 
	 	$xml=array( 
	 		"out_trade_no"=>$order0['wxpay_no'],
	 		"out_refund_no"=>$wxpay->orderNumber("TK"),
	 		"notify_url"=>"https://wxpay.wxutil.com/pub_v2/pay/notify.v2.php", 
	 		"refund_fee"=>floatval($order0['money_pay'])*100,
	 		"total_fee"=>floatval($totalmoney[0]['totalmoney'])*100//元换分
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
		 			"trade_state"=>"REFUND"
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

		 		//退款，库存还原回来
				$orderdetailModel = Model('orderdetail');
				$orderdetail=$orderdetailModel->where("order_no = '$no'")->get();
				$goodsModel = Model('goods');
				$goodsedit = $goodsModel->where('id='.$orderdetail['goodsid'])->get();
				$stock = intval($orderdetail['count']) + intval($goodsedit['stock']);
				$goodsModel->where('id='.$orderdetail['goodsid'])->save(['stock'=>$stock]);
				//扣除微信支付用户累计消费金额
			 		$order = $model->where("order_no='".$no."' and openid='".$ord['openid']."'")->get("*");
			 		if($order['pay_way']==1){
			 		$tabm=$model->tablename("member");
					$sql="UPDATE $tabm SET moneytotal=moneytotal-".$order['money_pay']." WHERE uniacid=".$_W['uniacid']." and openid='".$ord['openid']."' LIMIT 1"; 
					$model->query($sql);
					}

	 	 		message("退款成功");
	 		} else{
	 			message("不可重复退款");
	 		}
	 		
	 	}else{ 
	 		
	 		message("退款失败，".$msg['errmsg'].','.$msg['return_msg']);
	 	}
	 	 
  	} 
  	//拼团订单
  	public function pintuan(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("order"); 
 		$shopid=getShopID();
 		$param=array();
 		
 		$tab0=$model->tablename("discountgroup");
	 	$tab1=$model->tablename("goods");
	 	$where="$tab0.uniacid=$uniacid and $tab0.shopid=$shopid and $tab0.type=4";
 		if(isset($_GPC['date'])){
 			$params['date']=$_GPC['date'];
 			$start=strtotime($_GPC['date']." 00:00:00");
 			$stop=strtotime($_GPC['date']." 23:59:59");
 			$where.=" AND ($tab0.createtime<=$stop and $tab0.createtime>=$start) ";
 		}
 		if(isset($_GPC['status'])&&(intval($_GPC['status']))){
 			$params['status']=$_GPC['status'];
 			if(intval($_GPC['status'])==1){
 				$where.=" AND  $tab0.status>0";
 			}else{
 				$where.=" AND  $tab0.status=".intval($_GPC['status']);
 			}
 			
 		} 
 		$tab2=$model->tablename("member");
	 	$sql="SELECT $tab0.*,$tab1.picture,$tab1.name as goodsname FROM $tab0 LEFT JOIN $tab1 ON $tab0.goodsid=$tab1.id WHERE $where ORDER BY $tab0.`createtime` DESC";
	   
	 	$page=$model->pagenation($sql); 
	 	$orders=$page['dataset'];
	 	$openids="";
	 	foreach ($orders as $k => $v) {
	 		$openids.="'".$v['openid']."',";
	 		$orders[$k]['createdate']=date("Y-m-d H:i:s",$v['createtime']);
	 		$orders[$k]['limitdate']=date("Y-m-d H:i:s",$v['limittime']);
	 	}
	 	if(strlen($openids)){
	 		$openids=substr($openids,0,strlen($openids) -1); 
	 		$users=Model("member")->where("uniacid=$uniacid and openid in ($openids)")->getall("openid,nickname,avatar");
	 		 
	 		foreach ($orders as $k => $v) {
		 		foreach ($users as $key => $val) {
		 		 	if($v['openid']==$val['openid']){
		 		 		$orders[$k]['nickname']=$val['nickname'];
		 		 		$orders[$k]['avatar']=$val['avatar'];
		 		 		continue;
		 		 	}
		 		}	 
		 	}
	 	}
	 
		include $this->template("web/order/order-pintuan-list");
 	}
 	//拼团详细
 	public function pintuandet(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$groupid=intval($_GPC['groupid']);
 		$model=Model("order"); 
 		$shopid=getShopID();
 		$param=array();
		$group=Model("discountgroup")->where("uniacid=$uniacid and id=$groupid")->get();
		$goods=Model("goods")->where("uniacid=$uniacid and id=".intval($group['goodsid']))->get();
		$owner=Model("member")->where("uniacid=$uniacid and openid='".($group['openid'])."'")->get();
	 	$tab0=$model->tablename("order");
	 	$tab1=$model->tablename("orderdetail");
	 	$tab2=$model->tablename("member");
	 	$sql="SELECT $tab0.*,$tab1.casename,$tab1.count FROM $tab0 LEFT JOIN $tab1 ON $tab0.order_no=$tab1.order_no WHERE $tab0.uniacid=$uniacid and $tab0.discounttype=4 and $tab0.discountgroup=$groupid and $tab0.pay_status=1 and  $tab0.pay_way=1";
	 
	 	$orders= $model->query($sql);
	 	foreach ($orders as $k => $v) {
	 		$openids.="'".$v['openid']."',"; 
	 	}
	 	if(strlen($openids)){
	 		$openids=substr($openids,0,strlen($openids) -1); 
	 		$users=Model("member")->where("uniacid=$uniacid and openid in ($openids)")->getall("openid,nickname,avatar");
	 		 
	 		foreach ($orders as $k => $v) {
		 		foreach ($users as $key => $val) {
		 		 	if($v['openid']==$val['openid']){
		 		 		$orders[$k]['nickname']=$val['nickname'];
		 		 		$orders[$k]['avatar']=$val['avatar'];
		 		 		continue;
		 		 	}
		 		}	 
		 	}
	 	}
	 	//$sql="SELECT $tab2.nickname,$tab2.avatar,aa.* FROM () as aa LEFT JOIN $tab2 ON aa.openid=$tab2.openid WHERE aa.uniacid=$uniacid ORDER BY aa.`date` asc"; 
	  	$people=pdo_fetchcolumn("SELECT count(*) FROM $tab0 WHERE discountgroup=$groupid and uniacid=$uniacid");
	  	$money_pay=pdo_fetchcolumn("SELECT sum(money_pay) as total  FROM $tab0 WHERE discountgroup=$groupid and uniacid=$uniacid and pay_status=1 and pay_way=1");
	 	$explist=Model("shopexpress")->where("shopid=$shopid and uniacid=$uniacid and status>0")->order("status desc")->getall();
			 $explist0=json_decode(file_get_contents(ZSK_STATIC."datas/express.json"),true); 
			foreach ($explist as $key => $val) {
				foreach ($explist0 as $k=> $v) {
					if($val['code']==$v['code']){
						$explist[$key]['name']=$v['name'];
					}
				}
			}
		$setting=getSetting();
		include $this->template("web/order/order-pintuan-detail");
 	} 
}
?> 