<?php
 class Expressinfo extends ZskPage
 { 
 	public function index(){ 
 		$this->listview();
 	}
 	public function priceview(){
 		//邮费设置
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("expressprice"); 
 		//从文件中加载城市代码
 		$provinces=json_decode(file_get_contents(ZSK_PATH."/static/datas/province.json"),true);
 		$provinces0=$provinces;  
 		$shopid=getShopID();
 		$shop=Model('shop')->where("uniacid=$uniacid and id=".$shopid)->get();
 	 	$res=$model->order("cid asc")->where("uniacid=$uniacid and type=1 and shopid=$shopid")->getall("id as rowid,cid as id,parentid as pid,parentid,cid,province,city,price,price2,status");
 		 

 		foreach ($res as $key => $val) { 
 			if(intval($val['status'])==1){
 				$res[$key]['sts']='<span style="color:#22B14C;">启用</span>';
 			}else if(intval($val['status'])==-1){
 				$res[$key]['sts']='';
 			}else{
 				$res[$key]['sts']='<span style="color:#999;">禁用</span>';
 			} 
 		} 
 		$baoyous=($res);   
 		include $this->template("web/shop/express-price");
 	} 
  
 	public function express(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$shopid=getShopID(); 
		$model=Model("express");   
	 	$sql="SELECT * FROM ".$model->tablename("shopexpress")." WHERE uniacid=$uniacid AND shopid=$shopid AND status>0 limit 6"; 
	 	$mylist=pdo_fetchall($sql); 
		//从文件中加载快递、省市数据
		$explist=json_decode(file_get_contents(ZSK_PATH."/static/datas/express.json"),true);
		$provinces=json_decode(file_get_contents(ZSK_STATIC."datas/province.json"),true);
		$citys=json_decode(file_get_contents(ZSK_STATIC."datas/city.json"),true);
		$shop=getShopInfo();
		include $this->template("web/shop/shop-express");
	}
	public function saveSender(){
		//保存电子面单发货人信息
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$data=array(
			"contact"=>$_GPC['content'],
			"mobile"=>$_GPC['mobile'],
			"city"=>$_GPC['city'],
			"province"=>$_GPC['province'],
			"address"=>$_GPC['address']
		);
		$shopid=getShopID();
		Model("shop")->where("id=".$shopid)->save(array("express"=>json_encode($data,JSON_UNESCAPED_UNICODE)));
		message("保存成功",$this->routeUrl("expressinfo.express"));

	}
	public function getCityByPid(){
		$pid=intval($_GET['pid']);
		$citys=json_decode(file_get_contents(ZSK_PATH."/static/datas/city.json"),true);
		 
		foreach ($citys as $key => $val) {
			if(intval($val['parentid'])!=$pid){
				unset($citys[$key]);
			}
		}
		echo JSON_OUT($citys);
	}
	public function setExpress(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$shopid=getShopID();
	 
		 
		$m=Model("shopexpress");
		$code=trim($_GPC['code']);
		$sts=intval($_GPC['sts']); 
		if(strlen($code)>0){

			if($sts==2){
				$default=$m ->where("status='2' and shopid=$shopid and uniacid=$uniacid")->get("*");
				$set=$m ->where("code='".$code."' and shopid=$shopid and uniacid=$uniacid")->get("*");
				if(intval($default['id'])<1){ 
					$sss=array(
						"shopid"=>$shopid,
						"uniacid"=>$_W['uniacid'],
						"code"=>$code,
						"status"=>2
					); 
					if(intval($set['id'])<1){
						$m2=Model('shopexpress');
						$m2->add($sss);
					}else{
						$m->where("id=".$set['id'])->save($sss);
					} 
					 message("操作成功",$this->routeUrl("expressinfo.express"));
				}else{
					message("操作失败，默认快递只能设置一个");
				}
			}else if($sts==1){  
				$default=$m ->where("status='1' and uniacid=$uniacid and shopid=$shopid")->getall("*");
				
				$set=$m->where("code='".$code."' and uniacid=$uniacid and shopid=$shopid")->get("*"); 
				if(count($default)<5){ 
					$sss=array(
						"shopid"=>$shopid,
						"uniacid"=>$_W['uniacid'],
						"code"=>$code,
						"status"=>1
					); 
					if(intval($set['id'])<1){
						Model('shopexpress')->add($sss);
					}else{
						$m->where("id=".$set['id'])->save($sss);
					}
 					message("操作成功",$this->routeUrl("expressinfo.express"));
				}else{
					message("操作失败，常用快递最多设置五个");
				}
			}else{
				$set=$m ->where("code='".$code."' and uniacid=$uniacid and shopid=$shopid")->get("*"); 
				$sss=array(
					"shopid"=>$shopid,
					"uniacid"=>$_W['uniacid'],
					"code"=>$code,
					"status"=>0
				);
				if(intval($set['id'])<0){
					$m->add($sss);
				}else{
					$m->where("id=".$set['id'])->save($sss);
				} 
				message("操作成功",$this->routeUrl("expressinfo.express"));
				 
			}
		}else{
			message("操作失败，快递编号有误");
		} 
		message("保存成功",$this->routeUrl("expressinfo.express"));
	}
	public function saveExpressPrice(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("shop");
		$shopid=getShopID(); 
	    $shop=array();
	  
	    if(is_numeric($_GPC['express_limit'])){ 
	    	$set="express_limit = ".$_GPC['express_limit']; 
	    }else{
	    	$set="express_limit = null"; 
	    }
	     if(is_numeric($_GPC['express_default'])){ 
	    	$set.=", express_default = ".$_GPC['express_default']; 
	    }else{
	    	$set.=", express_default = null"; 
	    }
	    if(is_numeric($_GPC['express_defaultn'])){ 
	    	$set.=", express_defaultn = ".$_GPC['express_defaultn']; 
	    }else{
	    	$set.=", express_defaultn = null"; 
	    } 
	    $tab=$model->tablename("shop");
	    $sql="UPDATE $tab set $set  WHERE uniacid=$uniacid and id=$shopid limit 1"; 

	    $model->query($sql); 
	    message("保存成功",$this->routeUrl("expressinfo.priceview"));
	}
	public function ruleBaoyou(){
		//设置包邮区域
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$shopid=getShopID();
		$model=Model("expressprice");
		$tab0=$model->tablename("expressprice");
		
		//查出已有的地区，避免重复插入。
		$area=$model->where("uniacid=$uniacid and shopid=$shopid")->getall();

		if(count($_GPC['citys'])){//勾选了城市则只保存城市信息
			$citys=json_decode(file_get_contents(ZSK_PATH."/static/datas/city.json"),true);
			$valstr="";
			foreach ($area as $k => $v) {
				foreach ($_GPC['citys'] as $key => $cid) {
					if(intval($v['cid'])==intval($cid)){
						unset($_GPC['citys'][$key]);
					}
				}
			}
			foreach ($citys as $k => $v) {
				foreach ($_GPC['citys'] as $key => $cid) {
					if(intval($v['id'])==intval($cid)){
						$valstr.="($shopid,1,".$v['id'].",".$v['parentid'].",$uniacid,'".$v['name']."',0,0,1),";
					}
				}
			}
			if(strlen($valstr)>5){
				$valstr=substr($valstr, 0,strlen($valstr)-1);
				$sql="INSERT INTO $tab0 (shopid,type,cid,parentid,uniacid,city,price,price2,status) VALUES $valstr ;";
			  	$model->query($sql);
			}
			
		}else if(count($_GPC['provinces'])){//只勾选了省
			$provinces=json_decode(file_get_contents(ZSK_PATH."/static/datas/province.json"),true);
			$valstr=""; 
			foreach ($area as $k => $v) {
				foreach ($_GPC['provinces'] as $key => $cid) {
					if(intval($v['cid'])==intval($cid)){
						unset($_GPC['provinces'][$key]);
					}
				}
			} 
			foreach ($provinces as $k => $v) {
				foreach ($_GPC['provinces'] as $key => $cid) {
					if(intval($v['id'])==intval($cid)){
						$valstr.="($shopid,1,".$v['id'].",".$v['parentid'].",$uniacid,'".$v['name']."',0,0,1),";
					}
				}
			}
			if(strlen($valstr)>5){
				$valstr=substr($valstr, 0,strlen($valstr)-1);
				$sql="INSERT INTO $tab0 (shopid,type,cid,parentid,uniacid,province,price,price2,status) VALUES $valstr ;";

		    	$model->query($sql);  
			}
			
		}
		  message("保存成功",$this->routeUrl("expressinfo.priceview"));

	}
	//删除包邮地区
	public function removeBaoyou(){
			global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$shopid=getShopID();
		$model=Model("expressprice");
		$model->limit(1)->delete("uniacid=$uniacid and shopid=$shopid and id=".intval($_GPC['cid']));
		 message("删除成功",$this->routeUrl("expressinfo.priceview"));
	}
	public function getCityByPro(){
		$pro=trim($_GPC['province']);
		$city=json_decode(file_get_contents(ZSK_STATIC."datas/city.json"),true);
		$citys=array();
		 
	}
	//群发短信列表
	public function smslist(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$shopid=getShopID();
 		$res = Model("shop")->where("id=".$shopid)->get();
 		$page=Model("smsaudit")->where("uniacid=".$uniacid.' and shopid='.$shopid)->page("*");
 		$memberlist=$page['dataset'];
 		$page['url']=$this->routeUrl("expressinfo.smslist"); 
 		include $this->template("web/shop/express-smslist");
	}
	//删除短信
	public function delMember(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);  
 		$memberid=intval($_GPC['memberid']);
 		Model("smsaudit")->where("id=".$memberid)->limit(1)->delete(); 
 		message("删除成功",$this->routeUrl("expressinfo.smslist"));
 	}
	//短信设置
	public function batchsms(){
		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("member"); 
 		$a = tablename("azsk_shop_member");
 		$b = tablename("azsk_shop_memberaddress");
 		$sql = "SELECT ".$a.".*,".$b.".mobile FROM ".$a." INNER JOIN ".$b." ON ".$a.".openid=".$b.".openid and ".$a.".uniacid=$uniacid group by ".$b.".mobile";
 		// $page=$model->where($where)->order("lastlogin desc")->page("*");
 		$page = $_GPC['page'];
 		if(!$page){
 			$page = 1;
 		}
 		$size = 5;
 		$page=$model->pagenation($sql,$page,$size); 
 		$memberlist=$page['dataset'];
 		if(!$_GPC['page']){
 			include $this->template("web/shop/express-sms");
 		}else{
 			$res = array(
 				"pagecount"=>$page['pagecount'],
 				"page"=>$page['page'],
 				"memberlist"=>$page['dataset'],
 			);
 			echo json_encode($res);
 		}
	}
	public function addsms(){
		global $_W,$_GPC;
		$uniacid = intval($_W['uniacid']);
		$model=Model("smsaudit");
		$shopid=getShopID();
		$data['sendmobile'] = $_GPC['mobile'];
		$data["text"] = $_GPC['smscontent'];
		$data['sendnum'] = 0;
		if (count($_GPC['mobile'])>0) {
			$data['sendnum'] = substr_count($_GPC['mobile'],",")+1;
		}
		$data['mass']=1;
		if($data['sendnum']>1) {
			$data['mass'] = 2;
		}
		$data['shopid'] = $shopid;
		$data['uniacid'] = $_W['uniacid'];
		$data['sendtime'] = time();
 		$res = $model->add($data);
 		$res = Model("shop")->where("id=".$shopid)->get();
 		Model("shop")->where('id='.$shopid)->save(['smsnum'=>$res['smsnum']-$data['sendnum']]);
 		message("保存成功",$this->routeUrl("expressinfo.smslist"));
		
		// var_dump($res);die();
	}
}
?> 