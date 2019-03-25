<?php
/*
注   需导入  ims_uni_account_users 表
	需导入 ims_users表
	ims_users_permission 表
*/
class Login extends ZskPage
{ 
	//加载登录
	public function index(){
		include $this->template("web/login/login");
	}
	// 执行登录
	public function getlogin(){
		global $_W,$_GPC;
		$username = $_GPC['username'];
		$password = $_GPC['password'];
		$a = "`ims_users`";
		$b = "`ims_uni_account_users`";
		$c = "`ims_users_permission`";
		$sql = "SELECT $a.*,$b.role FROM $a LEFT JOIN $b ON $a.uid = $b.uid LEFT JOIN $c ON $c.uid = $a.uid where $a.username='$username'  limit 1";
		// and $c.type='zsk_market'
		$model = Model("shop");
		$res = $model->query($sql);
		$ress = $res[0];
		$password = user_hash($password,$ress['salt']);
		if($password!=$ress['password']){//密码是否正确
			$res = false;
		}
		session_start();
		unset($_SESSION['judgeid']);
		unset($_SESSION['menujudge']);
		if($res!=false){
			//判断是否为总管理员
			$shopM=Model("shop");
			if($ress['type']==0&&$ress['status']==0){
				$user = Model("shop")->where("account='".$ress['username']."'")->get();
				if($user){
					$_SESSION['username'] = $user['account'];
					$_SESSION['logingusername'] = $username; 
					// $_SESSION['judgeid'] = $ress['role'];
					// owner 权限侧边栏全显示
					$_SESSION['judgeid'] = "owner";
					$_SESSION['uniacid'] = intval($user['uniacid']);
					$res = true;
                    $_SESSION['power'] = '2';
				}else{
					//总管理初次登录 进行创建店铺
					$setting=getSetting();//初始化设置
					global $_W,$_GPC;  
					session_start();
					unset($_SESSION['currentShop']);
					$uniacid=intval($_W['uniacid']);
					$shopid=getShopID(); 
					//******   初始化默认店铺   ******//
				 	$shopM=Model("shop");
				 	$first=Model("shop")->exist("uniacid=$uniacid");
				 	if(!$first){//第一次进入小程序没有默认店铺，那就加一个呗
				 		$shop=array(
				 			"isdefault"=>1,
				 			"account"=>$ress['username'],
					 		"name"=>$_W['uniaccount']['name'], 
					 		"joindate"=>date("Y-m-d",time()),
					 		"limitdate"=>date("Y-m-d",time()+86400*365*50),
					 		"status"=>1,
					 		"uniacid"=>$uniacid,
					 	);
				 		$shopM->add($shop);
				 		$user = Model("shop")->where("account='".$ress['username']."'")->get();
				 		session_start();
						$_SESSION['username'] = $user['account'];
						$_SESSION['logingusername'] = $username; 
						// $_SESSION['judgeid'] = $ress['role'];
						$_SESSION['judgeid'] = "owner";
						$_SESSION['uniacid'] = intval($user['uniacid']);
						$res = true;
                        $_SESSION['power'] = '2';
						unset($_SESSION['currentShop']);
				 	}
				}

			}else{
				if($ress['role']=="operator"){

					$req = Model("acount")->where('uid='.$ress['uid'])->get();//查询当前账号信息
					if($req){
						$user = Model("shop")->where("id=".$req['shopid'])->get();//查询当前账号店铺id
						if (!$user) {
							$user = Model("shop")->where("account='".$ress['username']."'")->get();
						}
					}else{
						$user = Model("shop")->where("account='".$ress['username']."'")->get();
						//查询当前账号店铺id
					}
					$sql = "SELECT * FROM ims_users WHERE username=".$user['account'];
					$te = Model("shop")->query($sql);
					if($user){ 
						session_start();
						if($te){
	                        if($te[0]['status']==0&&$te[0]['type']==0){
					            $_SESSION['username'] = $username; 
					       	}else{
					            $_SESSION['username'] = $user['account'];
					        }
	                    }else{
	                    	$_SESSION['username'] = $user['account'];
	                    }
						$_SESSION['logingusername'] = $username; 
						$_SESSION['judgeid'] = $ress['role'];
						$res = true;
						$_SESSION['uniacid'] = intval($user['uniacid']);
						// judge=1 店铺店员权限  部分添加功能无法使用
						if($req['judge']==1){
							$_SESSION['menujudge'] = 1;
						}
					}
				}else if($ress['role']=="owner"||$ress['role']=="founder"){
					// 查询店铺管理员id
					$user = Model("shop")->where("account='".$ress['username']."'")->get();
					if($user){
						session_start();
						$_SESSION['username'] = $user['account'];
						$_SESSION['logingusername'] = $username; 
						$_SESSION['judgeid'] = $ress['role'];
						$res = true;
						$_SESSION['uniacid'] = intval($user['uniacid']);
						//  role 等于owner 或founder 时 judge=1 为商城店员 
						if($req['judge']==1){
							$_SESSION['menujudge'] = 1;
						}
					}
				}
			}
		}
		echo json_encode($res);die();
	}
	//退出登录
	public function outlogin(){
		session_start();
		unset($_SESSION['username']);
		unset($_SESSION['power']);
		echo JSON_OUT("ok");
		// include ZSK_PATH."index.php";
	}
	public function edit(){
		global $_W,$_GPC;
		$username = $_GPC['username'];
		$password = $_GPC['password'];
		$newpassword = $_GPC['newpassword'];
		$a = "`ims_users`";
		$sql = "SELECT * FROM $a where username='$username' limit 1";
		$model = Model("shop");
		$res = $model->query($sql);
		$ress = $res[0];
		$password = user_hash($password,$ress['salt']);
		if($password!=$ress['password']){//密码是否正确
			$res = false;
		}
		if($res!=false){
			$password = user_hash($newpassword,$ress['salt']);
			$sql = "UPDATE $a SET password='".$password."' where uid=".$ress['uid'];
			$res = $model->query($sql);
			if($res){
				message("保存成功");
			}else{
				message("保存失败");
			}
		}else{
				message("保存失败");
		}

	}
}