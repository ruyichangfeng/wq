<?php
$level = $_GPC['level'];
$id    = $profile['id'];
$flag  = $_GPC['flag'];
if($flag==1){
    $where_flag1=" and mber1.flag=1";
    $where_flag2=" and mber2.flag=1";
    $where_flag3=" and mber3.flag=1";
}else{
     $where_flag1=" and mber1.flag=0";
     $where_flag2=" and mber2.flag=0";
     $where_flag3=" and mber3.flag=0";
}
if ($level == '1' || $level == '2' || $level == '3') {
    $sql1_member = "select mber1.from_user from " . tablename('mihua_mall_member') . " mber1 where mber1.realname<>'' and mber1.id!=mber1.shareid {$where_flag1} and mber1.shareid = " . $profile['id'];
    if ($level == '1') {
        $fansall = pdo_fetchall("	select fans.*,(select uid from " . tablename('mc_mapping_fans') . " wefans where wefans.openid=fans.from_user and wefans.uniacid=fans.uniacid  limit 1) uid from " . tablename('mihua_mall_member') . " fans where from_user!='{$from_user}' and ( fans.from_user in (" . $sql1_member . ") ) and fans.uniacid={$_W['uniacid']} order by fans.createtime desc");
    }
}
if ($level == '2' || $level == '3') {
    $level2      = "select level2m.id from " . tablename('mihua_mall_member') . " level2m where level2m.id!=level2m.shareid and  level2m.shareid = " . $profile['id'];
    $sql2_member = "select mber2.from_user from " . tablename('mihua_mall_member') . " mber2 where mber2.realname<>'' and mber2.id!=mber2.shareid {$where_flag2} and mber2.shareid in (" . $level2 . ")  ";
    if ($level == '2') {
        $fansall = pdo_fetchall("	select fans.*,(select uid from " . tablename('mc_mapping_fans') . " wefans where wefans.openid=fans.from_user and wefans.uniacid=fans.uniacid limit 1) uid from " . tablename('mihua_mall_member') . " fans where  from_user!='{$from_user}' and  ( fans.from_user in (" . $sql2_member . ")) and (fans.from_user not in (" . $sql1_member . ") ) and fans.uniacid={$_W['uniacid']}  order by fans.createtime desc");
    }
}
if ($level == '3') {
    $level3      = "select level3m.id from " . tablename('mihua_mall_member') . " level3m where level3m.id!=level3m.shareid and level3m.shareid in( " . $level2 . ")";
    $sql3_member = "select mber3.from_user from " . tablename('mihua_mall_member') . " mber3 where mber3.realname<>'' and mber3.id!=mber3.shareid {$where_flag3}  and mber3.shareid in (" . $level3 . ")  ";
    if ($level == '3') {
        $fansall = pdo_fetchall("	select fans.*,(select uid from " . tablename('mc_mapping_fans') . " wefans where wefans.openid=fans.from_user and wefans.uniacid=fans.uniacid  limit 1) uid from " . tablename('mihua_mall_member') . " fans where from_user!='{$from_user}' and (fans.from_user in (" . $sql3_member . ")) and (fans.from_user not in (" . $sql1_member . ")) and (fans.from_user not in  (" . $sql2_member . ")) and fans.uniacid={$_W['uniacid']}  order by fans.createtime desc");
    }
}
if ($level == '4') {
    $sql1_member = "select mber1.from_user from " . tablename('mihua_mall_member') . " mber1 where mber1.realname<>'' and mber1.id!=mber1.shareid and mber1.shareid = " . $profile['id'];
    $fansall     = pdo_fetchall("	select fans.*,(select uid from " . tablename('mc_mapping_fans') . " wefans where wefans.openid=fans.from_user and wefans.uniacid=fans.uniacid  limit 1) uid from " . tablename('mihua_mall_member') . " fans where from_user!='{$from_user}' and ( fans.from_user in (" . $sql1_member . ") ) and fans.uniacid={$_W['uniacid']}  order by fans.createtime desc");
}
if ($level == '5') {
    $sql1_member = "select mber1.from_user from " . tablename('mihua_mall_member') . " mber1 where mber1.realname<>'' and mber1.id!=mber1.shareid and mber1.shareid = " . $profile['id'];
    $fansall     = pdo_fetchall("	select fans.*,(select uid from " . tablename('mc_mapping_fans') . " wefans where wefans.openid=fans.from_user and wefans.uniacid=fans.uniacid  limit 1) uid from " . tablename('mihua_mall_member') . " fans where (select follow from " . tablename('mc_mapping_fans') . " wefans where wefans.openid=fans.from_user and wefans.uniacid=fans.uniacid  limit 1)=1 and from_user!='{$from_user}' and ( fans.from_user in (" . $sql1_member . ") ) and fans.uniacid={$_W['uniacid']}  order by fans.createtime desc");
}
if ($fansall) {
    foreach ($fansall as $key => $value) {
        $avatar = mc_fetch($value['uid'], array('avatar'));
        if ($avatar) {

            $fansall[$key]['avatar'] = $avatar['avatar'];
        }
    }
}
include $this->template('myfansDetail');