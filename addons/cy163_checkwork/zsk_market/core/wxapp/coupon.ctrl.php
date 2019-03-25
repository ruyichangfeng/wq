<?php 
class Coupon extends ZskWxapp{
	//获取可用的免费优惠券
	public function getFreeCoupons(){
		global $_W,$_GPC;
		$model=Model("member");
		$uniacid=intval($_W['uniacid']);

		$openid=$_GPC['openid'];
		$tab0=$model->tablename("coupon");
		$sql="SELECT *,'0' as isgot FROM $tab0 WHERE ( `private`=0 or `private` is null) AND status=1 AND uniacid=$uniacid and (limit_stop>'".date("Y-m-d",time()-86400)."' or limit_stop='0000-00-00') order by limit_money asc ";
		$coupons=pdo_fetchall($sql);
		$m2=Model("membercoupon");
		$mycoupons=$m2->where("uniacid=$uniacid and openid='".$openid."'  ")->getall("*");
		 
		$freecoupons=array();
		//为小程序前端加上isgot字段判断是否已经领取
		foreach ($coupons as $key => $val) {
			foreach ($mycoupons as $k => $v) {
				if($val['id']==$v['couponid']){
					$coupons[$key]['isgot']=1;
				}
			}
			if(intval($coupons[$key]['isgot'])<1){
				array_push($freecoupons,$coupons[$key]);
			}
		}
		foreach ($coupons as $key => $val) { 
			if(intval($coupons[$key]['isgot'])==1){
				array_push($freecoupons,$coupons[$key]);
			}
		}
		echo JSON_OUT($freecoupons);
		
	}
 	public function pickCoupon(){
 		global $_W,$_GPC;
		$model=Model("coupon");
		$uniacid=intval($_W['uniacid']);

		$openid=trim($_POST['openid']);
		$cid=intval($_GPC['cid']);
		$coupon=$model->where("uniacid=$uniacid and id=$cid")->get();
		if(strlen($openid)<20) exit("0");
		$out=array("sts"=>0);
		if($coupon){
			$m2=Model("membercoupon");
			$rec0=$m2->where("uniacid=$uniacid and couponid=$cid and openid='".$openid."'")->get();
		 	
			if(empty($rec0)){
				$rec=array(
					"uniacid"=>$uniacid,
					"openid"=>$openid,
					"couponid"=>$cid,
					"status"=>1,
					"date"=>time()
				);
				$out['sts']=$m2->add($rec);
				if(intval($out['sts'])<1){
					$out['msg']="领取失败";
				}else{
					$out['msg']="领取成功";
				}
			}else{
				$out['msg']="您已经领取过了";
			}
		}else{
			$out['msg']="无效优惠券";
		}
		echo JSON_OUT($out);
 	} 
 	public function mycoupons(){
 		global $_W,$_GPC;
		$model=Model("coupon");
		$uniacid=intval($_W['uniacid']);
 		$m2=Model("membercoupon");
 		$openid=trim($_GPC['openid']);
 		$tab1=$model->tablename("membercoupon");
 		$tab0=$model->tablename("coupon");
 		$now=date("Y-m-d",time());
 		$where="$tab1.status>-1 AND $tab1.openid='".$openid."' and $tab0.uniacid=$uniacid and ($tab0.limit_stop='0000-00-00' or $tab0.limit_stop>='".$now."')";
 		if(floatval($_GPC['limitmoney'])>0){
 			$where.=" AND $tab0.limit_money<=".floatval($_GPC['limitmoney']);
 		}
 		if(is_numeric ($_GPC['status']) ){
 			$where.=" AND $tab1.status>=".intval($_GPC['status']);
 		}else{
 			$where.=" AND $tab1.status=1 ";
 		}
 		$sql="SELECT $tab0.* FROM $tab0 LEFT JOIN $tab1 ON $tab0.id=$tab1.couponid WHERE $where ";   
 	 
		$res=$model->query($sql);
		$sid="";
		$nowtime=time();
		foreach ($res as $key => $val) {
			$sid.=$val['shopid'].",";
			if(strtotime($val['limit_start'])<=$nowtime&&strtotime($val['limit_stop'])>=$nowtime){
				$res[$key]['sts']=1;
			}
			else{
				$res[$key]['sts']=0;
			}

		}
		
		if(strlen($sid)>1){
			$sid=substr($sid, 0,strlen($sid)-1);
			$shops=Model("shop")->where("id in ($sid)")->getall("id,name");
			foreach ($res as $key => $val) {
				$res[$key]['start']=strtotime($val['limit_start'])*1000;
				foreach ($shops as $k => $v) {
					if($val['shopid']==$v['id']){
						$res[$key]['limit_shop']=$v['name'];
						continue;
					}
				}
			}
		}
		echo JSON_OUT($res);
 	}
 	public function couponcenter(){
 		global $_W,$_GPC;
		$model=Model("coupon");
		$uniacid=intval($_W['uniacid']);
 		$m2=Model("membercoupon");
 		$openid=trim($_GPC['openid']);
 		$mycoupons=$m2->where("openid='".$openid."' and uniacid=".$uniacid." ")->getall("couponid"); 
 		 
 		 
 		$tab0=$model->tablename("shop");
 		$tab1=$model->tablename("coupon");
 		$where="$tab1.uniacid=".$uniacid." and $tab1.status>0 and  ($tab1.limit_stop>'".date("Y-m-d",time()-86400)."' or $tab1.limit_stop='0000-00-00') ";
 		 
 		$sql="SELECT $tab0.name as shopname,0 as isgot,$tab1.* FROM $tab0 LEFT JOIN $tab1 ON $tab0.id=$tab1.shopid WHERE $where order by $tab1.id desc"; 
 	  
		$res=$model->query($sql);
		foreach ($res as $key => $val) {
			foreach ($mycoupons as $k => $v ) {
				if($val['id']==$v['couponid']){
					if(intval($v['status'])==0){
						unset($res[$key]);//已使用的删掉
					}else{
						$res[$key]['isgot']=1; //已领取标记
					} 
					continue;
				} 
			}
		}
		$res=array_values($res);
		echo JSON_OUT($res,true);
 	}

 	public function popup(){
        global $_W,$_GPC;
        $uniacid=intval($_W['uniacid']);
        $modelAdvertisement=Model("advertisement");
        $where=" uniacid=$uniacid and advert_type=1 ";
        $advertisement = $modelAdvertisement->where($where)->getall();
        $count = count($advertisement);
        $i = rand(0,$count-1);
        if($advertisement[$i]['up_images']){
            $advertisement[$i]['up_images'] = $_W['attachurl'].$advertisement[$i]['up_images'];
            $arr = array(
                'to_show'=>$advertisement[$i]['to_show']+1,
            );
            $modelAdvertisement->where('id='.$advertisement[$i]['id'])->save($arr);
            $advertisement[$i]['stats'] = true;
            echo JSON_OUT($advertisement[$i]);
        }else{
            $advertisement[$i]['stats'] = false;
            echo JSON_OUT(false);
        }

    }

    public function gotl(){
        global $_W,$_GPC;
        $modelAdvertisement=Model("advertisement");
        $event = $_GPC['event'];
        $compile = $_GPC['compile'];
        $advertisement = $modelAdvertisement->where('id='.$compile)->get();
        $ad = array(
            'click_number'=> $advertisement['click_number']+1,
        );
        $modelAdvertisement->where('id='.$compile)->save($ad);
    }

}
	 