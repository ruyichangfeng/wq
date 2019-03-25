 <?php
 //类名agent与微擎冲突
 class Agents extends ZskPage
 { 
 	public function agentlist(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$model=Model("agent"); 
 		$tab0=$model->tablename("member");
 		$tab1=$model->tablename("agent");

 		$name=trim($_GPC['name']);
 		$where="";
 		if(strlen($name)){
 			$where.=" and ($tab0.nickname like '%".$name."%' or $tab1.code like  '%".$name."%' )";
 			$params['name']=$name;
 		}
 		$sql="SELECT $tab1.*,$tab0.avatar,$tab0.lastlogin,$tab0.gender,$tab0.nickname,$tab0.city FROM $tab1 LEFT JOIN $tab0 ON $tab1.openid=$tab0.openid WHERE $tab1.uniacid=$uniacid $where GROUP BY $tab1.code ORDER BY $tab0.lastlogin desc";
 		$page=$model->pagenation($sql); 
 		$agents=$page['dataset'];
 		$groups=Model("agentgroup")->where("uniacid=$uniacid")->getall(); 
 		$param['url']=$this->routeUrl("agents.agentlist");
 		include $this->template("web/agent/agent-list");
 	}
 	public function grouplist(){ 
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$groups=Model("agentgroup")->where("uniacid=$uniacid")->order("moneytotal asc,id asc")->getall(); 
 		include $this->template("web/agent/group-list");
 		 
 	} 
 	public function editGroup(){ 
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$gid=intval($_GPC['groupid']);
 		$group=Model("agentgroup")->where("uniacid=$uniacid and id=$gid")->get(); 
 		include $this->template("web/agent/group-edit");
 		 
 	} 
 	public function agentset(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$cates=Model("agentgroup")->where("uniacid=$uniacid")->getall(); 

 		$model=Model("setting");
 	 
 	 	$setting=$model->where("uniacid=".$uniacid)->get("id,uniacid,wxapp_layout,agent");
 	 	 
 	 	$wxa=json_decode($setting['wxapp_layout'],true);
 	 	$set=json_decode($setting['agent'],true);

 	 	$layout=$wxa['agent_haibao']; 
 		include $this->template("web/agent/setting");
 	}
 	public function setSetting(){
 		//代理商认证是否自动通过的设置
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$set=[
 			"auto_sign"=>$_GPC['auto_sign'],
 			"auto_levelup"=>$_GPC['auto_levelup']
 		];
 		Model("setting")->where('uniacid='.$uniacid)->save(['agent'=>json_encode($set)]);
 		message("保存成功",routeUrl("agents.agentset"));
 	}
 	public function saveGroup(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$model=Model("agentgroup");
 		$groupid=intval($_GPC['groupid']);
 		$group=array(
 			"name"=>$_GPC['name'],
 			"uniacid"=>$uniacid,
 			"moneytotal"=>$_GPC['moneytotal'],
 			"percent0"=>floatval($_GPC['percent0']),
 			"percent1"=>floatval($_GPC['percent1']),
 			"percent2"=>floatval($_GPC['percent2'])
 		);
 		if($groupid>0){
 			$model->where("uniacid=$uniacid and id=$groupid")->save($group);
 		}else{
 			$model->add($group);
 		}
 		message("保存成功",$this->routeUrl("agents.grouplist"));
 	}
 	public function delGroup(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$model=Model("agentgroup");
 		$groupid=intval($_GPC['groupid']);
 		$model->limit(1)->delete("uniacid=$uniacid and id=$groupid");
 		 
 		message("保存成功",$this->routeUrl("agents.grouplist"));
 	}
 	public function delAgent(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);  
 		$agentid=intval($_GPC['agentid']);
  		Model("agent")->where("uniacid=$uniacid and id=".$agentid)->limit(1)->delete();  
 		message("删除成功",$this->routeUrl("agents.agentlist"));
 	}
 	public function editAgent(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$model=Model("agent");
 		$agentid=intval($_GPC['agentid']);
 		$groups=Model("agentgroup")->where("uniacid=$uniacid")->getall(); 
 		$tab0=$model->tablename("member");
 		$tab1=$model->tablename("agent");
 		$sql="SELECT $tab1.* ,$tab0.nickname,$tab0.avatar,$tab0.city,$tab0.gender FROM $tab1 LEFT JOIN $tab0 ON $tab0.openid=$tab1.openid WHERE $tab1.id=$agentid";
 		$agent=$model->fetch($sql);
 		include $this->template("web/agent/agent-edit");
 	}
 	public function saveAgent(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$model=Model("agent");
 		$agentid=intval($_GPC['agentid']);
 		$agent=array(
 			"truename"=>$_GPC['truename'],
 			"uniacid"=>$uniacid,
 			"mobile"=>$_GPC['mobile'],
 			"groupid"=>intval($_GPC['groupid']),
 			"balance"=>floatval($_GPC['balance']),
 			"balance_freezing"=>floatval($_GPC['balance_freezing']),
 			"status"=>intval($_GPC['status'])
 		);
 		if($agentid>0){
 			$model->where("uniacid=$uniacid and id=$agentid")->save($agent);
 		}else{
 			$model->add($group);
 		} 
 		message("保存成功",$this->routeUrl("agents.agentlist"));
 	}
 	public function withdrawview(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("agentwithdraw");  
 		$aid=intval($_GPC['aid']);
 		$apply=$model->where("uniacid=$uniacid and id=$aid")->get();
 		$agent=Model("agent")->where("uniacid=$uniacid and openid='".$apply['openid']."'")->get();
 		$member=Model("member")->where("uniacid=$uniacid and openid='".($apply['openid'])."'")->get(); 
 		if(intval($apply['status'])==1){
 			global $_W;
			$setting=getSetting("pay",true);
			$pay=new Wxpay($setting);  
			$data=array(
 				"partner_trade_no"=>$apply['order_no'] 
 			);
			$apires=$pay->queryBank($data); 
			switch ($apires['status']) {
				case 'PROCESSING':
					$apires['message']="提交银行处理中";
					break;
				case 'SUCCESS':
					$apires['message']="付款成功";
					break;
				case 'FAILED':
					$apires['message']="付款失败";
					break;
				case 'BANK_FAIL':
					$apires['message']="银行退票";
					break;
				default:
					# code...
					break;
			}
			if(strlen($apires['message'])>1){
				$model->where("id=".$apply['id'])->limit(1)->save(array("status_api"=>$apires['status']));
			}
			
			if(strlen($apires['reason'])>1){$apires['message'].=$apires['reason'];}

 		}
 		include $this->template("web/agent/withdraw-edit");
 	}
 	public function withdrawlist(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("agentwithdraw");  
 		 
 		$tab0=$model->tablename("member");
 		$tab1=$model->tablename("agentwithdraw");
 		$where.="$tab1.uniacid=$uniacid";
 		if(!empty($_GPC['status'])){
 			$where.=" $tab1.status=".intval($_GPC['status']);
 			$param['status']=intval($_GPC['status']);
 		}
 		$sql="SELECT $tab1.*,$tab0.nickname,$tab0.avatar FROM $tab1 LEFT JOIN $tab0 ON $tab1.openid=$tab0.openid WHERE $where ORDER BY `datetime` desc";
 		$page=$model->pagenation($sql); 
 		$applys=$page['dataset'];
 		include $this->template("web/agent/withdraw-list");
 	}
 	public function refusewithdraw(){//拒绝提现
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("agentwithdraw");  
 		$aid=intval($_GPC['aid']);
 		$apply=$model->where("uniacid=$uniacid and id=$aid")->get();
 		if(!empty($apply)){
 			$ii = $model->where("uniacid=$uniacid and id=$aid")->save(array("reply"=>$_GPC['reply'],'status'=>'-1'));
 			$res=withdraw_fail($apply['openid'],$apply);//通知申请人
			 
 		}else{
 			message("参数错误");		
 		}
 		
		 	    	 
 		message("操作成功",$this->routeUrl("agents.withdrawlist"));
 	}
 	public function payout(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("agentwithdraw");  
 		$aid=intval($_GPC['aid']);
 		$apply=$model->where("uniacid=$uniacid and id=$aid")->get();
 		$agent=Model("agent")->where("uniacid=$uniacid and openid='".$apply['openid']."'")->get();
 		$member=Model("member")->where("uniacid=$uniacid and openid='".($apply['openid'])."'")->get(); 
 		if(floatval($agent['balance'])<floatval($apply['money'])){
 			message("用户可提现余额不足!");
 		} 
 		if(intval($apply['status'])>0){
 			message("请勿重复提现!");
 		}
		$setting=getSetting("pay",true);
		$pay=new Wxpay($setting);

 		switch ($apply['type']) {
 			case 'wxpay': 
 				//微信提现
		 	 	$data=array(
		 	 		"mch_appid"=>$setting['appid'],
		 	 		"mchid"=>$setting['wxpay_mchid'],
		 	 		"partner_trade_no"=>$pay->orderNumber("TX"),
		 	 		"openid"=>$apply['openid'],
		 	 		"re_user_name"=>$apply['truename'],
		 	 		"amount"=>intval(floatval($apply['money'])*100),
		 	    	"desc"=>"提现",
		 	 		"check_name"=>"FORCE_CHECK",
		 	 		"spbill_create_ip"=>$_SERVER['REMOTE_ADDR']
		 	 	);
		 	 	
		 	 	$res=$pay->payYue($data); 
		 	 	if($res['result_code']=="FAIL"){
		 	    	message($res['err_code_des']);
		 	    	exit;
		 	    }else{
		 	    	$model->where("id=".$apply['id'])->limit(1)->save(array("status"=>1,"order_no"=>$data['partner_trade_no']));
		 	    }
 				break;
 			case "bank":
 				//银行卡提现
		 	    $data=array(
		 	    	"mch_id"=>$setting['wxpay_mchid'],
		 	    	"partner_trade_no"=>$pay->orderNumber("TX"),
		 	    	"enc_bank_no"=>$pay->rsa_encrypt($apply['account']),
		 	    	"enc_true_name"=>$pay->rsa_encrypt($apply['truename']),
		 	    	"bank_code"=>$apply['bankcode'],
		 	    	"amount"=>intval(floatval($apply['money'])*100),
		 	    	"desc"=>"提现"
		 	    );
		 	    $res=$pay->payBank($data);  
		 	    if($res['result_code']=="FAIL"){
		 	    	 message($res['err_code_des']);
		 	    	exit;
		 	    }else if($res['result_code']=="SUCCESS"){
		 	    	$model->where("id=".$apply['id'])->limit(1)->save(array("status"=>1,"order_no"=>$data['partner_trade_no']));
		 	    	$res=withdraw_ok($apply['openid'],$apply);

		 	    }
 				break;
 			default:
 				# code...
 				break;
 		}
 		message("操作成功",$this->routeUrl("agents.withdrawlist"));
 	}
	public function saveHaibao(){
		global $_W,$_GPC;
 		$model=Model("setting");
 		$uniacid=intval($_W['uniacid']);
 	 	$setting=$model->where("uniacid=".$uniacid)->get("id,uniacid,wxapp_layout");
 	 	$layout=array(
 	 		"picture"=>$_GPC['picture'],
 	 		"top"=>floatval($_GPC['top']),//上边距百分比
 	 		"left"=>floatval($_GPC['left']),//左边距百分比
 	 		"is_hyaline"=>intval($_GPC['is_hyaline'])
 	 	);
 	 	$setting=json_decode($setting['wxapp_layout'],true);  
 	 	$setting['agent_haibao']=$layout;
 	 	$model->where("uniacid=".$uniacid)->limit(1)->save(array("wxapp_layout"=>json_encode($setting)));

 	 	message("保存成功",$this->routeUrl("agents.agentset"));
	}
 }