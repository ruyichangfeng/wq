<?php 
class Pintuan extends ZskWxapp{
 	public function getcate(){
 			global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("discount"); 
 		
 		$cates=Model("pintuancate")->where("uniacid=$uniacid")->getall();
 		$swipers=Model("pintuanswiper")->where("uniacid=$uniacid and status>0")->getall();
 		echo JSON_OUT(array("cate"=>$cates,"swiper"=>$swipers),true);
 	}
  
	public function goodsList(){//获取拼团商品
		global $_W,$_GPC;

		$uniacid=intval($_W['uniacid']);
		$model=Model("discount");
		$tab0=$model->tablename("goods");
		$tab1=$model->tablename("discount");
		$now=date("Y-m-d H:i:s",time());
		$where="$tab1.uniacid=".$uniacid." and $tab1.status>0 and $tab0.status>0  and $tab1.type=4 and $tab1.starttime<'".$now."' and $tab1.stoptime>'".$now."'";
		if(intval($_GPC['cate'])>0){
			$where.=" and $tab1.cateid=".intval($_GPC['cate']);
		}
		$sql="SELECT $tab1.*,$tab1.id as discount_id,$tab0.price0, $tab0.sellCount,$tab0.sellCount0 ,$tab0.name,$tab0.picture,$tab0.price,$tab0.picture_wide,0 as is_stop,0 as stop_day,0 as stop_hour,0 as stop_minute,0 as stop_second  FROM $tab1 LEFT  JOIN $tab0 ON $tab0.id=$tab1.goodsid where $where order by $tab1.stoptime desc";
		$result=$model->pagenation($sql);
		$result['sql']=$sql;
		
		foreach ($result['dataset'] as $key => $val) {
			$result['dataset'][$key]['price0']=floatval($val['price0']);
			$result['dataset'][$key]['notice']=htmlspecialchars_decode($val['notice'],ENT_NOQUOTES);;
//			$result['dataset'][$key]['notice']='';
			$result['dataset'][$key]['price']=floatval($val['price']);
			$result['dataset'][$key]['stopstamp']=strtotime($val['stoptime']); 
			$result['dataset'][$key]['cases']=json_decode($val['casejson'],true);
			$result['dataset'][$key]['pricelow']=getPriceLow(json_decode($val['casejson'],true),$val['price']);

			unset($result['dataset'][$key]['casejson']);
		}
		$result['attachurl']=$_W['attachurl'];

		//$result['dataset']=getGoodsSimpleInfo($result['dataset']);

		$result['timestamp']=time();
		echo JSON_OUT($result);
	}
	function getPintuanQR(){//获取平图二维码
		$setting=getSetting();
		$js=new WeixinJS($setting['appid'],$setting['secret']);
		$token=$js->getToken();
		$url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$token['access_token'];
		 
		$data='{
			"scene":"goodsid='.$gid.'",
			"page":"zsk_market/pages/details/index?goodsid='.$gid.'",
			"width":200
		}';
		$res=CURL_image($url,$data);

		$result['base64']="data:image/png;base64,".base64_encode($res);
	}
	 
	public function getGroup3(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']); 
		$model=Model("discountgroup"); 
		$discid=intval($_GPC['discountid']);
		$discount=Model("discount")->where("id=".$discid." and uniacid=".$uniacid." and type=4 and status>0")->get();
		$tab0=$model->tablename("discountgroup");
		$tab1=$model->tablename("member"); 
		$sql="SELECT $tab0.* ,LEFT($tab1.nickname,2) as nickname,$tab1.avatar FROM $tab0 LEFT JOIN $tab1 ON $tab0.openid=$tab1.openid WHERE $tab0.uniacid=$uniacid and $tab0.createtime>".(time()-86400)." and discount_id=".$discid."  and $tab0.status=1 and $tab0.limittime>".time()." and $tab0.now_people<".intval($discount['group_limit'])." group by $tab0.id order by $tab0.createtime desc limit 3 ";
		$result=$model->query($sql);  
	 	echo JSON_OUT(array("groups"=>$result));
	}


	public function getPintuanInfo(){
		//获取砍价商品的商品
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);  
		$model=Model("discount");
		$m2=Model("discountgroup");
		$openid=$_GPC['openid'];
		$groupid=intval($_GPC['groupid']);  
		$discountid=intval($_GPC['discountid']);
		$tab0=$model->tablename("goods");
		$tab1=$model->tablename("discount");
		$sql="SELECT $tab1.*,$tab0.name as goodsname,$tab0.picture,$tab0.price,$tab0.price0,$tab0.sellCount,$tab0.sellCount0 FROM $tab1 LEFT JOIN $tab0 ON $tab1.goodsid=$tab0.id WHERE $tab1.id=$discountid LIMIT 1";
		$discount=pdo_fetch($sql);
		$tab0=$model->tablename("order");
		$tab1=$model->tablename("member");
		$tab2=$model->tablename("orderdetail");
		$discount['casejson']=json_decode($discount['casejson'],true);
		 
		$group=Model("discountgroup")->where('id='.$groupid)->get(); 

		$sql="SELECT $tab0.discountid,$tab0.discountgroup,$tab0.discountstatus,$tab0.`date`,$tab0.abstract ,$tab0.openid,$tab0.order_no,$tab0.status,$tab0.pay_status,$tab0.id, $tab1.avatar,$tab1.nickname  FROM $tab0 LEFT JOIN $tab1 ON $tab0.openid=$tab1.openid WHERE $tab0.discountgroup=".$groupid." GROUP BY $tab1.openid ORDER BY $tab0.`date` desc";
		$members=$model->query($sql); 
		foreach ($members as $key => $val) {
			if($val['openid']==$openid){
				$myorder=$val; 
			}
			if($val['openid']==$group['openid']){ 
				$leader=$val; 
				unset($members[$key]);
			}
		}
		 
		$goodses=getDiscountGoodsInfo(array($discount),"goodsid");

		$result=array( 
			"discount"=>$discount, 
			"members"=>$members,
			"group"=>$group,  
			"goods"=>$goodses[0],
			"leader"=>$leader,
			"myorder"=>$myorder, 
		); 

	 	echo JSON_OUT($result,true);
	} 
	public function getOrderBySts(){//获取拼团订单
  		global $_W,$_GPC;
		$model=Model("order");
	 	$uniacid=intval($_W['uniacid']);
	 	
  		$openid=trim($_POST['openid']);
		$tb_detail=$model->tablename('orderdetail'); 
		$tb_order=$model->tablename('order');
		$tb_goods=$model->tablename('goods');
		$tb_case=$model->tablename('goodscase');
		$tb_shop=$model->tablename("shop");
		
		$where="$tb_order.uniacid=$uniacid and discounttype=4 and openid='".$openid."'"; 
		if(intval($_GPC['sts'])!=99){
			if(intval($_GPC['sts'])>1){
			$where.=" and $tb_order.discountstatus>1";
			} else{ 
			$where.=" and $tb_order.discountstatus=".intval($_GPC['sts']);
			}
		};

	 
	/*	$orders=$model->where($where)->order(" `date` desc")->page("*,order_no as `num`"); 
		$orders['sql']=$model->lastSql(); */
		$sql="SELECT $tb_order.*,$tb_order.order_no as num,$tb_shop.name as shopname FROM $tb_order LEFT JOIN $tb_shop ON $tb_order.shopid=$tb_shop.id WHERE $where ORDER BY $tb_order.`date` desc";
		$orders=$model->pagenation($sql);
	 

		$idstr="";
		$gids="";
		foreach ($orders['dataset'] as $key => $val) {
			$idstr.=intval($val['id']).",";
			$gids.=intval($val['discountgroup']).",";
		} 
		$gids=substr($gids,0,strlen($gids)-1);
		$idstr=substr($idstr,0,strlen($idstr)-1);
		$groups=Model("discountgroup")->where("id in ($gids)")->getall();
		$tab4=$model->tablename("discount");
		$tab5=$model->tablename("discountgroup");
		$sql="SELECT 0 as is_stop,0 as stop_minute,0 as stop_hour, $tab4.*,$tab5.goodsid,$tab5.id as groupid,$tab5.now_people,owner_nick,limittime FROM $tab5 LEFT JOIN $tab4 ON $tab4.id=$tab5.discount_id WHERE $tab5.id in ($gids) and $tab5.uniacid=$uniacid ";
		$groups=$model->query($sql);
		$sql2="SELECT  $tb_case.isopt,$tb_case.thumb ,temptb.* FROM (SELECT {$tb_detail}.id as did,orderid as `oid`, {$tb_detail}.goodscaseid,{$tb_detail}.goodsname ,{$tb_detail}.casename ,{$tb_detail}.count  ,{$tb_detail}.goodsid  , {$tb_goods}.picture as pic FROM {$tb_detail} LEFT JOIN {$tb_goods} on {$tb_goods}.id = {$tb_detail}.goodsid WHERE {$tb_detail}.orderid in ($idstr) )  as temptb LEFT JOIN $tb_case ON temptb.goodscaseid=$tb_case.id ";
		$orders['action']=$sql2;  
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
			foreach ($groups as $k2 => $v2) {
				if($val['discountgroup']==$v2['groupid']){ 
					unset($v2['casejson']);
					$orders["dataset"][$key]['group']=$v2;
				}
			}
		}

		//$orders['groups']=$sql;
		echo JSON_OUT($orders,true);
  	}
}
