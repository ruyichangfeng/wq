<?php
//员工绑定

global $_GPC,$_W;
$adminId=$_GPC['id'];
$uid=$_W['member']['uid'];

//删除之前绑定信息
$update['uid']=0;
$update['is_bind']=0;
$update['open_id']="";
pdo_update("gd_admin",$update,array("uid"=>$uid));

//重新绑定
$insert['uid']=$uid;
$insert['is_bind']=1;
$insert['open_id']=$_W['openid'];
$mc =mc_fansinfo($_W['openid']);
$insert['avatar']=$mc['avatar'];
if(pdo_update("gd_admin",$insert,array("id"=>$adminId))){
    $_SESSION['is_admin']=1;
}
//查找会员信息是否存在
$member = pdo_get("gd_member",array("uid"=>$uid));
if(empty($member)){
    $this->initUser();
}
pdo_update("gd_member",array("admin_id"=>0),array("admin_id"=>$adminId));
//更新用户信息
$adminInfo = pdo_get("gd_admin",array("id"=>$adminId));
$mUpdate['name']=$adminInfo['name'];
$mUpdate['mobile']=$adminInfo['mobile'];
$mUpdate['admin_id']=$adminInfo['id'];
$mUpdate['is_register']=1;
pdo_update("gd_member",$mUpdate,array("uid"=>$uid));
message("绑定成功",$this->createMobileUrl('staff'),'success');