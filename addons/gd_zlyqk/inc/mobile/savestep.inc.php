<?php
global $_GPC,$_W;
$sort=isset($_GPC['sort'])?$_GPC['sort']:0;
if($sort==0){
    $result = pdo_fetch("select * from ".tablename("gd_member_ext")." where sort>$sort order by sort asc limit 1");
    if(empty($result)){
        $url = $this->createMobileUrl("member");
        header("location:".$url);
        exit(1);
    }
    $sort = $result['sort'];
}
$memberInfo=$this->getMemberInfo();
$fansInfo =mc_fansinfo($_W['openid']);
$baseConfig =$this->getLang();
$extInfo = pdo_get("gd_member_ext",array("uniacid"=>$_W['uniacid'],'sort'=>$sort));
$xml = json_decode($extInfo['xml'],true);
$stepList = pdo_fetchall("select * from ".tablename("gd_member_ext")." where uniacid={$_W['uniacid']} order by sort asc ");
$html=$this->createRegisterForm($xml);
$submit = $this->getMenus();
//获取菜单
$menus = $this->getWxMenu();
include $this->template("register_form");