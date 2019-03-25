<?php
/*
注   需导入  ims_uni_account_users 表
	需导入 ims_users表
	表: ims_users_permission 
*/
// 权限
 class Account extends ZskPage
 {
 	// 我的店铺账号管理
 	public function management(){
 		global $_W,$_GPC;
 		$shopid=getShopID();
 		$uniacid = $_W['uniacid'];
 		$where = "";
 		$model = Model("acount");
 		$a = "ims_users";
 		$b = "ims_uni_account_users";
 		$c = $model->tablename("acount");
 		$d = "ims_users_permission";
 		if($_GPC['name']){
 			$where = " and $a.username like '%".$_GPC['name']."%'";
 		}
 		$sql = "SELECT $a.*,$c.name as acountname,$c.mobile as acountmobile,$c.createtime as acountcreatetime FROM $a INNER JOIN $b ON $a.uid = $b.uid LEFT JOIN $c ON $a.uid=$c.uid LEFT JOIN $d ON $d.uid = $a.uid  WHERE $b.uniacid={$_W['uniacid']} and $d.type='zsk_market' and $c.judge=1 and $c.shopid =$shopid and $b.role='operator'".$where;
 		$page=$model->pagenation($sql); 
 		$memberlist=$page['dataset'];
 		$page['url']=$this->routeUrl("account.management");
 		include $this->template("web/account/acount-list");
 	}
 	//删除管理员
 	public function deleteman(){
 		global $_W,$_GPC;
 		$uniacid = $_W['uniacid'];
 		$id = $_GPC['id'];
 		$model = Model("acount");
 		$a = "ims_users";
 		$b = "ims_uni_account_users";
 		$c = $model->tablename("acount");
 		$d = "ims_users_permission";
 		$sql = "DELETE FROM $a WHERE uid=".$id;
 		$res =$model->query($sql);
 		$sql = "DELETE FROM $b WHERE uid=".$id;
 		$res =$model->query($sql);
 		$sql = "DELETE FROM $c WHERE uid=".$id;
 		$res =$model->query($sql);
 		$sql = "DELETE FROM $d WHERE uid=".$id;
 		$res =$model->query($sql);
 		message("删除成功",$this->routeUrl("account.management"));
 		// echo json_encode($res);
 	}
 	//查询单个管理员
 	public function findman(){
 		global $_W,$_GPC;
 		$id = $_GPC['id'];
 		$model = Model("acount");
 		$a = "ims_users";
 		$b = "ims_uni_account_users";
 		$c = $model->tablename("acount");
 		$sql = "SELECT $a.*,$c.name,$c.mobile,$c.createtime FROM $a INNER JOIN $b ON $a.uid = $b.uid LEFT JOIN $c ON $a.uid=$c.uid WHERE $b.uniacid={$_W['uniacid']} and $b.role='operator' and $a.uid=$id LIMIT 1";
 		$res = $model->query($sql);
 		if($res){
 			$res = $res[0];
 		}
 		echo json_encode($res);
 	}
 	//我的店铺添加账号
 	public function addmanagement(){
 		global $_W,$_GPC;
 		$shopid=getShopID();
 		$model = Model("acount");
 		$data['name'] = $_GPC['name'];
 		$data['mobile'] = $_GPC['mobile'];
 		$data['uniacid'] = $_W['uniacid'];
 		$data['createtime'] = time();
 		$data['shopid'] = $shopid;
 		$data['judge'] = 1;
 		$data['uniacid']= $_W['uniacid'];
 		$username = $_GPC['username'];
 		if($_GPC['password']){
 			$salt=random(8);
 			$password = user_hash($_GPC['password'],"$salt");
 			// var_dump($password);die();
 		}
 		if($_GPC['id']>0){
 			$sql = "SELECT * FROM  ims_users where uid=".$_GPC['id']." and username='".$_GPC['username']."'";
 			$res = $model->query($sql);
 			if(!$res){
 				$sql  = "SELECT * FROM ims_users where username='".$_GPC['username']."'";
		 		$res = $model->query($sql);
		 		if($res){
		 			message("用户名重复");
		 			die();
		 		}
		 		$updata="";
		 		if($password){
		 			$updata = " password=$password,salt=$salt";
		 		}
		 		$sql ="UPDATE ims_users SET username='".$_GPC['username']."'".$update." where uid=".$_GPC['id'];
		 		$model->query($sql);
 			}
 			Model("acount")->where('uid',$_GPC['id'])->save($data);
 		}else{
 			$sql  = "SELECT * FROM ims_users where username='".$_GPC['username']."'";
	 		$res = $model->query($sql);
	 		if($res){
	 			message("用户名重复");
	 			die();
	 		}
 			$time = time();
 			$sql = "INSERT INTO ims_users (username,type,status,password,salt,joindate) VALUES('$username',1,2,'$password','$salt',$time)";
 			$model->query($sql);
 			$sql = "SELECT uid FROM ims_users WHERE username='$username'";
 			$us = $model->query($sql);
 			$uid = $us[0]['uid'];
 			$data['uid'] = $us[0]['uid'];
 			$uniacid = intval($_W['uniacid']);
 			$sql = "INSERT INTO ims_uni_account_users (uniacid,uid,role) VALUES($uniacid,$uid,'operator')";
 			$model->query($sql);
 			$sql = "INSERT INTO ims_users_permission (uniacid,uid,type,permission) VALUES($uniacid,$uid,'zsk_market','all')";
 			$model->query($sql);
 			$res = Model("acount")->add($data);
 		}
 		message("添加成功",$this->routeUrl("account.management"));
 	}


 	// 商城账号管理
 	public function shopmanagement(){
		global $_W,$_GPC;
 		$shopid=getShopID();
 		$uniacid = $_W['uniacid'];
 		$where = "";
 		$model = Model("acount");
 		$a = "ims_users";
 		$b = "ims_uni_account_users";
 		$c = $model->tablename("acount");
 		$d = "ims_users_permission";
 		if($_GPC['name']){
 			$where = " and $a.username like '%".$_GPC['name']."%'";
 		}
 		$sql = "SELECT $a.*,$c.name,$c.mobile,$c.createtime FROM $a INNER JOIN $b ON $a.uid = $b.uid LEFT JOIN $c ON $a.uid=$c.uid LEFT JOIN $d ON $d.uid = $a.uid WHERE $b.uniacid={$_W['uniacid']} and $d.type='zsk_market' and $c.judge=1 and $b.role='owner'".$where;
 		$page=$model->pagenation($sql); 
 		$memberlist=$page['dataset'];
 		$page['url']=$this->routeUrl("account.shopmanagement");
 		include $this->template("web/account/shopacount-list");
 	}
 	//删除管理员
 	public function shopdeleteman(){
 		global $_W,$_GPC;
 		$uniacid = $_W['uniacid'];
 		$id = $_GPC['id'];
 		$model = Model("acount");
 		$a = "ims_users";
 		$b = "ims_uni_account_users";
 		$c = $model->tablename("acount");
 		$d = "ims_users_permission";
 		$sql = "DELETE FROM $a WHERE uid=".$id;
 		$res =$model->query($sql);
 		$sql = "DELETE FROM $b WHERE uid=".$id;
 		$res =$model->query($sql);
 		$sql = "DELETE FROM $c WHERE uid=".$id;
 		$res =$model->query($sql);
 		$sql = "DELETE FROM $d WHERE uid=".$id;
 		$res =$model->query($sql);
 		message("删除成功",$this->routeUrl("account.shopmanagement"));
 	}
 	//查询单个管理员
 	public function shopfindman(){
 		global $_W,$_GPC;
 		$id = $_GPC['id'];
 		$model = Model("acount");
 		$a = "ims_users";
 		$b = "ims_uni_account_users";
 		$c = $model->tablename("acount");
 		$sql = "SELECT $a.*,$c.name,$c.mobile,$c.createtime FROM $a INNER JOIN $b ON $a.uid = $b.uid LEFT JOIN $c ON $a.uid=$c.uid WHERE $b.uniacid={$_W['uniacid']} and $b.role='owner' and $a.uid=$id LIMIT 1";
 		$res = $model->query($sql);
 		if($res){
 			$res = $res[0];
 		}
 		echo json_encode($res);
 	}
 	//我的店铺添加账号
 	public function shopaddmanagement(){

 		global $_W,$_GPC;
 		$shopid=getShopID();
 		$model = Model("acount");
 		$data['name'] = $_GPC['name'];
 		$data['mobile'] = $_GPC['mobile'];
 		$data['uniacid'] = $_W['uniacid'];
 		$data['createtime'] = time();
 		$data['shopid'] = $shopid;
 		$data['judge'] = 1;
 		$data['uniacid']= $_W['uniacid'];
 		$username = $_GPC['username'];
 		if($_GPC['password']){
 			$salt=random(8);
 			$password = user_hash($_GPC['password'],"$salt");
 		}
 		if($_GPC['id']>0){
 			$sql = "SELECT * FROM  ims_users where uid=".$_GPC['id']." and username='".$_GPC['username']."'";
 			$res = $model->query($sql);
 			if(!$res){
 				$sql  = "SELECT * FROM ims_users where username='".$_GPC['username']."'";
		 		$res = $model->query($sql);
		 		if($res){
		 			message("用户名重复");
		 			die();
		 		}
		 		$updata="";
		 		if($password){
		 			$updata = " password=$password,salt=$salt";
		 		}
		 		$sql ="UPDATE ims_users SET username='".$_GPC['username']."'".$update." where uid=".$_GPC['id'];
		 		$model->query($sql);
 			}
 			Model("acount")->where('uid',$_GPC['id'])->save($data);
 		}else{
 			$sql  = "SELECT * FROM ims_users where username='".$_GPC['username']."'";
	 		$res = $model->query($sql);
	 		if($res){
	 			message("用户名重复");
	 			die();
	 		}
 			$time = time();
 			$sql = "INSERT INTO ims_users (username,type,status,password,salt,joindate) VALUES('$username',1,2,'$password','$salt',$time)";
 			$model->query($sql);
 			$sql = "SELECT uid FROM ims_users WHERE username='$username'";
 			$us = $model->query($sql);
 			$uid = $us[0]['uid'];
 			$data['uid'] = $us[0]['uid'];
 			$uniacid = intval($_W['uniacid']);
 			$sql = "INSERT INTO ims_uni_account_users (uniacid,uid,role) VALUES($uniacid,$uid,'owner')";
 			$model->query($sql);
 			$sql = "INSERT INTO ims_users_permission (uniacid,uid,type,permission) VALUES($uniacid,$uid,'zsk_market','all')";
 			$model->query($sql);
 			$res = Model("acount")->add($data);
 		}
 		message("添加成功",$this->routeUrl("account.shopmanagement"));
 	}
 }