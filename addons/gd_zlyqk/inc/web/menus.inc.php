<?php
//菜单页面
global $_W,$_GPC;
$where['group']=6;
$where['uniacid']=$_W['uniacid'];
$config = $this->beforeSettingList($where);
$baseConfig =$this->getLang();
$ky=$_W['config']['cookie']['pre']."__api";
$nk=$_W['config']['cookie']['pre']."m_name";
$result =$this->checkUser();
$notice = ($result['code']==0)?true:false;
$staffName=$_COOKIE[$nk];
$isApi=isset($_COOKIE[$ky])?1:0;
$mId=$_GPC['m_id'];
//判断是否是超级管理员
//检查应用是否存在
$appInfo = $this->getDefaultApp(array("is_default"=>1));
if(empty($appInfo)){
    $appInfo=$this->getDefaultApp();
}

//检查管理员是否存在，如果不存在则自动添加
if(empty($_GPC['m_id'])){
    $supAdmin = pdo_get("gd_admin",array("uniacid"=>$_W['uniacid'],'is_sys'=>1));
    if(empty($supAdmin)){
        $insert['uniacid']=$_W['uniacid'];
        $insert['name']="管理员";
        $insert['mobile']="adm".time();
        $insert['password']="adm".time();
        $insert['organize']=2;
        $insert['create_time']=time();
        $insert['is_sys']=1;
        pdo_insert("gd_admin",$insert);
        $insertId = pdo_insertid();
        $supAdmin=$insert;
        $supAdmin['id']=$insertId;
    }
    $mobile=$supAdmin['mobile'];
    $password =$supAdmin['password'];
    load()->model('user');
    //系统登录
    $midAdmin=pdo_get("gd_admin",array("mobile"=>$mobile));
    if(empty($midAdmin)){
        return false;
    }
    if($midAdmin['password']!=$password){
        return false;
    }
    isetcookie('m_name', $midAdmin['name'], 7 * 86400);
    isetcookie('m_id', $midAdmin['id'], 7 * 86400);
    isetcookie('m_avatar', $midAdmin['avatar'], 7 * 86400);
    isetcookie('is_sys',$midAdmin['is_sys'], 7 * 86400);
    $_GPC['is_sys']=$midAdmin['is_sys'];
    $_GPC['m_name']=$midAdmin['name'];
    $_GPC['m_id']=$midAdmin['id'];
}else{
    $supAdmin = $this->getAdminInfo($_GPC['m_id']);
}
$accList = $this->getCokMenu();
include $this->template('menus');