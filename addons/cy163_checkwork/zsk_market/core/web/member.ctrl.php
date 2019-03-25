 <?php
 class Member extends ZskPage
 { 
 	public function index(){ 
 		$this->listview();
 	}
 	//会员分组 
 	public function grouplist(){ 
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$groups=Model("membergroup")->where("uniacid=$uniacid")->order("moneytotal asc")->getall(); 
 		include $this->template("web/member/group-list");
 	} 
 	//编辑分组
 	public function editGroup(){ 
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$gid=intval($_GPC['groupid']);
 		$group=Model("membergroup")->where("uniacid=$uniacid and id=$gid")->get(); 
 		include $this->template("web/member/group-edit");
 		 
 	}  
 	//编辑会员信息
 	public function editview(){ 
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$openid= ($_GPC['openid']);
 		$member=Model("member")->where("uniacid=$uniacid and openid='".$openid."'")->get(); 
 		$t0=tablename("azsk_shop_member");
 		$t1=tablename("azsk_shop_agent"); 
 		if(intval($member['agent_p0'])>0){
 			$sql="SELECT $t0.id,$t0.nickname,$t0.avatar,$t0.openid,$t1.code FROM $t0 LEFT JOIN $t1 ON $t0.openid=$t1.openid WHERE $t1.code ='".$member['agent_p0']."' limit 1";
 			$agent0=pdo_fetch($sql); 
 		}
 		if(intval($member['agent_p1'])>0){
 			$sql="SELECT $t0.id,$t0.nickname,$t0.avatar,$t0.openid,$t1.code FROM $t0 LEFT JOIN $t1 ON $t0.openid=$t1.openid WHERE $t1.code ='".$member['agent_p1']."' limit 1";
 			$agent1=pdo_fetch($sql);
 		}
 		if(intval($member['agent_p2'])>0){
 			$sql="SELECT $t0.id,$t0.nickname,$t0.avatar,$t0.openid,$t1.code FROM $t0 LEFT JOIN $t1 ON $t0.openid=$t1.openid WHERE $t1.code ='".$member['agent_p2']."' limit 1";
 			$agent2=pdo_fetch($sql);
 		} 
 		$group=Model("membergroup")->where("id=".intval($member['groupid']))->get();
 		include $this->template("web/member/member-edit");
 		 
 	} 
 	public function saveMember(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$openid= ($_GPC['openid']);
 		$member=["moneytotal"=>floatval($_GPC['moneytotal']),"openid"=>$openid];
 		$group = Model('membergroup')->where("uniacid=".$uniacid)->order("moneytotal desc")->getall();

 		foreach ($group as $k => $v){
 			if($v['moneytotal'] >= $_GPC['moneytotal'] && empty($group[$k+1]['moneytotal']) ? $group[$k+1]['moneytotal'] : $v['moneytotal'] <= $_GPC['moneytotal']){
				$member['groupid'] = $v['id'];
				break;
			}else{
				$member['groupid'] = null;
			}
		}
		Model("member")->where("uniacid=".$uniacid." and openid='".$openid."'")->save($member);
 		$group_new=Model("membergroup")->where("uniacid=".$uniacid." and moneytotal<".floatval($member['moneytotal']))->order("moneytotal desc")->get("id,name");//获取最近匹配的会员组
		if(!empty($group_new)&& intval($group_new['id'])!=intval($member['groupid'])){
			Model("member")->limit(1)->where("openid='".$member['openid']."' and uniacid=".$uniacid)->save(array("groupid"=>$group_new['id']));
		}
 		message("保存成功",$this->routeUrl("member.editview")."&openid=".$openid);
 	} 
 	public function saveGroup(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']); 
 		$model=Model("membergroup");
 		$groupid=intval($_GPC['groupid']);
 		$group=array(
 			"name"=>$_GPC['name'],
 			"uniacid"=>$uniacid,
 			"moneytotal"=>$_GPC['moneytotal'],
 			"percent"=>floatval($_GPC['percent'])
 		);
 		if($groupid>0){
 			$model->where("uniacid=$uniacid and id=$groupid")->save($group);
 		}else{
 			$model->add($group);
 		}
 		message("保存成功",$this->routeUrl("member.grouplist"));
 	}
 	public function delGroup(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);  
 		$groupid=intval($_GPC['groupid']);
  		Model("membergroup")->where("uniacid=$uniacid and id=".$groupid)->limit(1)->delete();  
 		message("删除成功",$this->routeUrl("member.grouplist"));
 	}
 	public function listview(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("member"); 
 		
 		$name=trim($_GPC['name']);
 		$where="uniacid=$uniacid";
 		if(strlen($name)){
 			$where.=" and nickname like '%".$name."%'";
 			$params['name']=$name;
 		}
 		$page=$model->where($where)->order("lastlogin desc")->page("*");
 		$memberlist=$page['dataset'];
 		$groups=Model("membergroup")->where("uniacid=$uniacid")->order("moneytotal asc")->getall("id,name");
 		$page['url']=$this->routeUrl("member.listview");
 		include $this->template("web/member/member-list");
 	} 
 	public function delMember(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);  
 		$memberid=intval($_GPC['memberid']);
 		$member=Model("member")->where("id='".$_GPC['memberid']."'")->get();
 		if(!empty($member)){
 			Model("member")->where("uniacid=$uniacid and id=".$memberid)->limit(1)->delete(); 
 			Model("agent")->where("uniacid=$uniacid and openid='".$member['openid']."'")->limit(1)->delete(); 
 		}
 		message("删除成功",$this->routeUrl("member.listview"));
 	}
  	 

}
?> 