 <?php
 class Sms extends ZskPage
 {
 	public function smsconfig(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$res=Model("smsconfig")->where("uniacid=$uniacid")->get(); 
		include $this->template("web/setting/smsconfig");
 	}
 	public function saveconfig(){
 		global $_W,$_GPC;
 		// $data['tpl_id'] = 2711790;
 		// $data['name'] = "付洲";
 		// $data['goodsname'] = "我们的是一家商店呢收到撒旦撒收到收到阿斯顿撒阿斯顿 ;";
 		// $data['phone'] = "手机号";
 		// $data['address'] = "四川省成都市金牛区赛云台西一路金都苑";
 		// $res = sendsms("7b522b2844aaac259fb382826db1e9f2","掌上客","","18708323516",true,false,$data);
 		// var_dump($res);die();
 		// die();
 		$id= $_GPC['id'];
 		$data['apikey'] = trim($_GPC['apikey']);
 		$data['signature'] = trim($_GPC['signature']);
 		$data['ckneworder'] = $_GPC['ckneworder']=='on'?1:2;
 		$data['ckneworderid'] =  trim($_GPC['ckneworderid']);
 		$data['deliveryid'] =  trim($_GPC['deliveryid']);
 		$data['goodsid'] = trim($_GPC['goodsid']);
 		$data['afterid'] = trim($_GPC['afterid']);
 		$data['neworder'] = trim($_GPC['neworder']);
 		$data['ckdelivery'] = $_GPC['ckdelivery']=='on'?1:2;
 		$data['delivery'] = trim($_GPC['delivery']);
 		$data['ckgoods'] = $_GPC['ckgoods']=='on'?1:2;
 		$data['goods'] = trim($_GPC['goods']);
 		$data['ckafter']= $_GPC['ckafter']=='on'?1:2;
 		$data['after'] = trim($_GPC['after']);
 		$data['uniacid'] = $_W['uniacid'];
 		if($_GPC['neworder']||$_GPC['delivery']||$_GPC['goods']||$_GPC['after']){
 			if(!$data['apikey']||!$data['signature']){
 				message("请查看签名或秘钥是否填写");
 				die();
 			}
 		}
 		$model=Model("smsconfig");
 		if($id>0){
 			$res = $model->where("uniacid=".$_W['uniacid']." and id=".$id)->save($data);
 		}else{
 			$res = $model->add($data);
 		}
 		message("保存成功",$this->routeUrl("sms.smsconfig"));
 	}
 	//加载审核页面
 	public function audit(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("smsaudit"); 
 		$a = $model->tablename("smsaudit");
 		$b = $model->tablename("shop");
 		$sql = 'SELECT '.$a.'.*,'.$b.'.name FROM '.$a.'INNER JOIN'.$b.' ON '.$a.'.shopid='.$b.'.id where '.$a.'.uniacid='.$_W['uniacid'];
 		$name = $_GPC['name'];
 		if($name){
 			$sql .=" and ".$b.".name like '%".$name."%'";
 		}
 		$page=$model->pagenation($sql); 
 		// $page=Model("smsaudit")->where("uniacid=$uniacid")->page("*"); 
 		$memberlist=$page['dataset'];
 		$page['url']=$this->routeUrl("sms.audit");
 		$res=Model("smsconfig")->where("uniacid=".$_W['uniacid'])->get();
 		$usercode = getuser($res['apikey']);

 		include $this->template("web/shop/shop-saudit");
 	}
 	//同意发送
 	public function agreed(){
 		global $_W,$_GPC;
 		$id = $_GPC['id'];
 		$data=Model("smsaudit")->where("id=$id")->get(); 
 		$judgeshop = Model("shop")->where("id=".$data['shopid'])->get();
 		if($judgeshop['smsnum']<=0&&$data['sendnum']>$judgeshop['smsnum']){
 			die();
 		}
		$res=Model("smsconfig")->where("uniacid=".$_W['uniacid'])->get();
		$usercode = getuser($res['apikey']);
		if($res){
			if($data['sendnum']>1){
				$type=false;
			}else{
				$type=true;
			}
		$res = sendsms($res['apikey'],$res['signature'],$data['text'],$data['sendmobile'],$type);
		if($res['code']!=null){
				if($res['code']!=0){
					$req = Model("shop")->where("id=".$data['shopid'])->get();
		 			Model("shop")->where("id=".$data['shopid'])->save(['smsnum'=>$req['smsnum']+$data['sendnum']]);
		 			$data['status'] = 2;
		 			$data['statussting'] = $res['msg'];
		 			Model("smsaudit")->where("id=".$id)->save($data);
				}
			}else{
				$count = count($res);
				if($res['data'][$count]['code']!=0){
					$req = Model("shop")->where("id=".$data['shopid'])->get();
		 			Model("shop")->where("id=".$data['shopid'])->save(['smsnum'=>$req['smsnum']+$data['sendnum']]);
		 			$data['status'] = 2;
		 			$data['statussting'] =$res['data'][$count]['msg'];
		 			Model("smsaudit")->where("id=".$id)->save($data);
				}
			}
		}
		echo json_encode($res);
 	}
 	//拒绝发送
 	public function refused(){
 		global $_W,$_GPC;
 		$id = $_GPC['id'];
 		$data['status'] = 2;
 		$data['statussting'] = $_GPC['statussting'];
 		$find = Model("smsaudit")->where('id='.$id)->get();
 		$res = Model("smsaudit")->where("id=".$id)->save($data);
 		$req = Model("shop")->where("id=".$find['shopid'])->get();
 		Model("shop")->where("id=".$find['shopid'])->save(['smsnum'=>$req['smsnum']+$find['sendnum']]);
 		echo json_encode($res);
 	}
}