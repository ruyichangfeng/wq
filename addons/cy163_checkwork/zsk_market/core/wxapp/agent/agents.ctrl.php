<?php 
//分销代理
class Agents extends ZskWxapp{
	public function autoSign(){
		global $_W,$_GPC; 
 		$model=Model("agent");

 		$uniacid=intval($_W['uniacid']);
 		$openid=$_GPC['openid'];
 		$ismember=Model("member")->where("uniacid=$uniacid and openid='$openid'")->get("*");
 		if(!empty($ismember)){
 			$ismember = true;
 		}else{
 			$ismember = false;
 		}
 		$agent= $model->where("uniacid=$uniacid and openid='$openid'")->get();
 		$res=array("status"=>0,"msg"=>"参数错误");

		if($ismember&& empty($agent)){  
			$agent=array(
				"openid"=>$openid,"groupid"=>0,"uniacid"=>$uniacid,"balance"=>0,"balance_freezing"=>0,"status"=>0,"signtime"=>time()
			);
			$set=getSetting();
			if($set['agent']['auto_sign']=="on"){
				$agent['status']=1;
			}
			$aid=$model->add($agent);  
			$model->where("id=$aid")->limit(1)->save(array('code'=>8000+$aid));
		}else if($isagent){
			$agent['msg']="已经是代理了！";
		}
		if(intval($agent['status'])=="0"){
			$agent['status_msg']="等待审核中";
		}
		if(intval($agent['status'])=="-1"){
			$agent['status_msg']="账号已冻结";
		}
		echo json_encode($agent);
	} 
	public function myInfo(){
		global $_W,$_GPC;
 		$model=Model("agent");
 		$uniacid=intval($_W['uniacid']);
 		$code=intval($_GPC['code']);
 		$tab0=$model->tablename("member");
 		$tab1=$model->tablename("agent");
 		$tab2=$model->tablename("order");
 		$openid=trim($_GPC['openid']);
 		$agent=$model->where("openid='$openid' and uniacid=$uniacid")->get();
 		$sql="SELECT $tab1.*,$tab0.agent_p0,$tab0.agent_p1,$tab0.agent_p2 FROM $tab1 LEFT JOIN $tab0 ON $tab1.openid=$tab0.openid WHERE $tab1.openid='$openid'  and $tab1.uniacid=$uniacid LIMIT 1";
 		 
 		$agent=$model->fetch($sql);
 		if(intval($agent['agent_p0'])){ 
	 		$sql="SELECT $tab0.nickname,$tab0.avatar FROM $tab1 LEFT JOIN $tab0 ON $tab1.openid=$tab0.openid WHERE $tab1.code=".$agent['agent_p0']." and $tab1.uniacid=$uniacid LIMIT 1";
	 		$agent_p0=$model->fetch($sql);
	 		if(!empty($agent_p0)){
	 			$agent['agent_0']=$agent_p0['nickname'];
	 		}else{
	 			$agent['agent_0']="";
	 		}
	 		
 		}
 		$group=Model("agentgroup")->where("id=".intval($agent['groupid']))->get();
 		$sql="SELECT count(*) FROM $tab0 WHERE uniacid=$uniacid and ( agent_p0='".$agent['code']."' or agent_p1='".$agent['code']."' or agent_p2='".$agent['code']."' ) ";
 		$agent['groupsize']=pdo_fetchcolumn($sql);
 		$sql="SELECT count(*) FROM $tab2 WHERE uniacid=$uniacid and pay_way=1 and ( agent_p0='".$agent['code']."' or agent_p1='".$agent['code']."' or agent_p2='".$agent['code']."' ) ";
 		$agent['ordercount']=pdo_fetchcolumn($sql);
 		$res=array(
 			"group"=>$group,"agent"=>$agent 
 		);
 		echo json_encode($res);
	}
	//我的团队
 	public function getTeam(){
 		global $_W,$_GPC;
 		$model=Model("agent");
 		$uniacid=intval($_W['uniacid']);
 		$code=intval($_GPC['code']);
 		$tab0=$model->tablename("member");
 		$tab1=$model->tablename("agent");
 		$where="$tab0.uniacid=$uniacid ";
 		if(intval($_GPC['level'])==1){
 			$where.=" and $tab0.agent_p1=".$code;
 		}else if(intval($_GPC['level'])==2){
			$where.=" and $tab0.agent_p2=".$code;
 		}else{
 			$where.=" and $tab0.agent_p0=".$code;
 		}
 		$sql="SELECT $tab0.openid,$tab0.id,$tab0.avatar,$tab0.lastlogin,$tab0.gender,$tab0.nickname,$tab0.city FROM  $tab0  WHERE $where ORDER BY $tab0.lastlogin desc";
 		$team=$model->query($sql);
 		 
 		echo JSON_OUT($team,true);
 	}
 	//提现申请
 	public function withdrawapply(){
 		global $_W,$_GPC;
		$model=Model("agentwithdraw");
		$uniacid=intval($_W['uniacid']);
		$openid=trim($_GPC['openid']);
		$apply=array( 
			"uniacid"=>$uniacid, 
			"openid"=>$openid,
			"money"=>floatval($_GPC['money']),
			"type"=>$_GPC['type'],
			"status"=>0,
			"datetime"=>date("Y-m-d H:i:s",time()),
			"truename"=>trim($_GPC['truename']),
			"mobile"=>trim($_GPC['mobile']),
			"account"=>trim($_GPC['account']), 
			"bankcode"=>intval($_GPC['bankid']),
			"remark"=>trim($_GPC['remark']),
			 
		);
		$out['aid']=$model->add($apply); 
		if($out['aid']){
			$apply['money']=$apply['money']."元";
			$user=Model("member")->where("openid='".$openid."' and uniacid=".$uniacid)->get();
			$apply['nickname']=$user['nickname'];
			$type="微信零钱";
			if($_GPC['type']=="alipay")$type="支付宝";
			if($_GPC['type']=="bank")$type="银行卡";
			$apply['type']=$type;
			$apply['remark']="提现来源：分销提现";
			$out['api']=sendWithdrawApply($apply);
		}	 
		//返回结果status大于0表示成功
		echo json_encode($out);
 	}
 	//提现详情
 	public function withdrawdet(){
 		global $_W,$_GPC;
		$model=Model("agentwithdraw");
		$uniacid=intval($_W['uniacid']);
		$openid=trim($_GPC['openid']);
		$aid=intval($_GPC['aid']);
		$apply=$model->where("uniacid=$uniacid and openid='$openid' and id=$aid")->get();

		//顺便把商户分类返回去，减少请求次数 
		echo JSON_OUT(array("apply"=>$apply ),true);
 	}
  	public function getOrderBySts(){
  		global $_W,$_GPC; 
		$model=Model("order");
	 	$uniacid=intval($_W['uniacid']); 
  		$code=intval($_GPC['code']);
		$tb_detail=$model->tablename('orderdetail'); 
		$tb_order=$model->tablename('order');
		$tb_goods=$model->tablename('goods');
		$tb_case=$model->tablename('goodscase');
		$tb_shop=$model->tablename("shop");
		$sts=intval($_POST['sts']);
		
		$where="$tb_order.uniacid=$uniacid   and  (agent_p0=$code or agent_p1=$code or agent_p2=$code ) "; 
		if($sts!=99){
			$where.= " AND $tb_order.agent_status=$sts ";
		} 
		$sql="SELECT $tb_order.*,$tb_order.order_no as num,$tb_shop.name as shopname FROM $tb_order LEFT JOIN $tb_shop ON $tb_order.shopid=$tb_shop.id WHERE $where ORDER BY $tb_order.`date` desc";
		$orders=$model->pagenation($sql);
		foreach ($orders['dataset'] as $key => $val) {
			if(intval($val['agent_p0'])==$code){
				$orders['dataset'][$key]['income']=$val['money_agent0'];
				$orders['dataset'][$key]['agent_level']=0;
			}
			if(intval($val['agent_p1'])==$code){
				$orders['dataset'][$key]['income']=$val['money_agent1'];
				$orders['dataset'][$key]['agent_level']=1;
			}
			if(intval($val['agent_p2'])==$code){
				$orders['dataset'][$key]['income']=$val['money_agent2'];
				$orders['dataset'][$key]['agent_level']=2;
			}
			$orders['dataset'][$key]['contact']=mb_substr($val['contact'],0,1,"utf-8")."**";
			$orders['dataset'][$key]['mobile']=substr($val['mobile'],0,3)."****".substr($val['mobile'],strlen($val['mobile'])-4,4);
		}
		echo JSON_OUT($orders,true);
  	}
  	 public function withdrawRecord(){
  		global $_W,$_GPC;
 		$model=Model("agentwithdraw");
 		$uniacid=intval($_W['uniacid']);
 		$openid=$_GPC['openid']; 
 		$where="uniacid=$uniacid  and openid='".$openid."'";
 		if(intval($_GPC['status'])!=99){
 			$where.=" and status=".intval($_GPC['status']);
 		}
 		$records=$model->order("`datetime` desc")->where($where)->page();
 		echo JSON_OUT($records,true);
  	}
  	public function getGroups(){
  		global $_W,$_GPC;
 		$model=Model("agentgroup");
 		$uniacid=intval($_W['uniacid']);  
 
 		$groups=$model->order("`id` asc")->where("uniacid=".$uniacid)->getall();
 		echo JSON_OUT($groups,true);
  	}
  	public function changeRecord(){
  		global $_W,$_GPC;
 		$model=Model("agentbalance");
 		$uniacid=intval($_W['uniacid']);
 		$openid=$_GPC['openid']; 
 		$where="uniacid=$uniacid  and openid='".$openid."'";
 		 
 		$records=$model->order("`createtime` desc")->where($where)->page();
 		foreach ($records['dataset'] as $key => $val) {
 			$records['dataset'][$key]['date']=date("Y-m-d H:i",$val['createtime']);
 		}
 		echo JSON_OUT($records); 
  	}
}
	 