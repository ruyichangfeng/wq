<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 微信端个人页面
 */

global $_GPC, $_W;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'member';
$mem = $this->changemember();
load()->model('mc');
$region = $this->mreg();
$userinfo = mc_oauth_userinfo();
$member = mc_fetch($_W['fans']['uid'], array('mobile', 'credit1','credit2', 'realname', 'address'));
$xqset = $this->set($mem['regionid'],'xqset');
$count = readnotice($member['regionid']);
//获取购物车数量
$carttotal = $this->getCartTotal();
if ($op == 'member') {
    $dos = "'repair','report','fled','houselease','homemaking','car','cost','shopping','business','government'";
    $menus = pdo_fetchall("SELECT * FROM" . tablename('xcommunity_nav') . "WHERE uniacid =:uniacid AND do in({$dos})", array(':uniacid' => $_W['uniacid']), 'do');
    $repair_count = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_report')."WHERE weid=:weid AND type =1 AND openid=:openid AND regionid=:regionid",array(':weid' => $_W['uniacid'],':openid' => $_W['openid'],':regionid' => $mem['regionid']));
    $report_count = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_report')."WHERE weid=:weid AND type =2 AND openid=:openid AND regionid=:regionid",array(':weid' => $_W['uniacid'],':openid' => $_W['openid'],':regionid' => $mem['regionid']));
    $cost_count = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_cost_list')."WHERE weid=:weid AND homenumber=:homenumber AND regionid=:regionid",array(':weid' => $_W['uniacid'],':homenumber' => $mem['address'],':regionid' => $mem['regionid']));
    $homemaking_count = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_homemaking')."WHERE weid=:weid AND openid=:openid AND regionid=:regionid",array(':weid' => $_W['uniacid'],':openid' => $_W['openid'],':regionid' => $mem['regionid']));
    $houselease_count = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_houselease')."WHERE weid=:weid AND openid=:openid AND regionid=:regionid",array(':weid' => $_W['uniacid'],':openid' => $_W['openid'],':regionid' => $mem['regionid']));
    $car_count = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_carpool')."WHERE weid=:weid AND openid=:openid AND regionid=:regionid",array(':weid' => $_W['uniacid'],':openid' => $_W['openid'],':regionid' => $mem['regionid']));
    $coupon_count = pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_order')."WHERE weid=:weid AND from_user=:openid AND status=1 AND type = 'business'",array(':weid' => $_W['uniacid'],':openid' => $_W['openid']));

    include $this->template($this->xqtpl('member/member'));

}
elseif ($op == 'my') {
    $region = $this->region($mem['regionid']);
    include $this->template($this->xqtpl('member/my'));
}
elseif ($op == 'edit') {
    $r = $_GPC['r'];

    $id = intval($_GPC['id']);
    if ($id) {
        $mem = pdo_fetch("SELECT * FROM" . tablename('xcommunity_member') . "WHERE id=:id AND weid=:weid and openid=:openid", array(':id' => $id, ':weid' => $_W['weid'],':openid' => $_W['openid']));
        if(empty($mem)){
            message('非法访问',referer(),'error');exit();
        }
    }
    if($r =='a'){
        $list = pdo_getall('xcommunity_member_address',array('mid' => $mem['id'],'regionid' => $mem['regionid']),array('address','enable','id','mid'));
    }
//    print_r($list);
    if ($_W['isajax']) {
        if ($r == 'm') {
            $rs = mc_update($_W['member']['uid'], array('realname' => $_GPC['realname']));
            //pdo_query("UPDATE ".tablename('xcommunity_member')."SET realname = '{$_GPC['realname']}' WHERE id=:id",array(':id' => $id));
            pdo_update('xcommunity_member', array('realname' => $_GPC['realname']), array('id' => $id));
            $result = array(
                'status' => 1,
            );
            echo json_encode($result);
            exit();
        }
        elseif ($r == 'b') {
            $rs = mc_update($_W['member']['uid'], array('mobile' => $_GPC['mobile']));
            //pdo_query("UPDATE ".tablename('xcommunity_member')."SET mobile = :mobile WHERE id=:id",array(':mobile' => $_GPC['mobile'],':id' => $id));
            pdo_update('xcommunity_member', array('mobile' => $_GPC['mobile']), array('id' => $id));
            $result = array(
                'status' => 1,
            );
            echo json_encode($result);
            exit();
        }
        elseif ($r == 'a') {
            $rs = mc_update($_W['member']['uid'], array('address' => $_GPC['address']));
            //pdo_query("UPDATE ".tablename('xcommunity_member')."SET address = :address WHERE id=:id",array(':address' => $_GPC['address'],':id' => $id));
            pdo_update('xcommunity_member', array('address' => $_GPC['address']), array('id' => $id));
            $result = array(
                'status' => 1,
            );
            echo json_encode($result);
            exit();
        }

    }
    include $this->template($this->xqtpl('member/edit'));
}elseif($op == 'bind'){

    $sql = "select r.title as title ,m.id as id,m.enable as enable from".tablename('xcommunity_region')."as r left join".tablename('xcommunity_member')."as m on r.id = m.regionid where m.openid = :openid ";
    $params[':openid'] = $_W['openid'];
    $list = pdo_fetchall($sql,$params);
//    print_r($list);

    include $this->template($this->xqtpl('member/region_bind'));
}elseif($op == 'ajax'){
    if($_W['isajax']){
        $mid = intval($_GPC['mid']);
        //查当前绑定的小区,解除绑定
        $userinfo = $this->member($_W['openid']);
        pdo_update('xcommunity_member',array('enable' => 0),array('id' => $userinfo['id']));
        if($mid){
            $r = pdo_update('xcommunity_member',array('enable' => 1),array('id' => $mid));
            if($r){
                echo json_encode(array('status' => 1));exit();
            }
        }

    }
}elseif($op == 'address'){
    $gid = intval($_GPC['gid']);
    $id = intval($_GPC['id']);
    if($id){
        $item = pdo_get('xcommunity_member_address',array('id' => $id),array('realname','telephone','address'));
    }
    if($_W['isajax']){
        $data = array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
            'mid' => $mem['id'],
            'regionid' => $mem['regionid'],
            'openid' => $_W['openid'],
            'address' => $_GPC['address'],
            'telephone' => $_GPC['telephone'],
            'realname' => $_GPC['realname']
        );
        if($id){
            $r = pdo_update('xcommunity_member_address',$data,array('id' => $id));
        }else{
            $r = pdo_insert('xcommunity_member_address',$data);
        }

        if($r){
            echo json_encode(array('status' => 1));exit();
        }
    }

    include $this->template($this->xqtpl('member/member_address'));
}elseif($op == 'addr'){

    if($_W['isajax']){
        $build = $_GPC['build'];
        $unit = $_GPC['unit'];
        $room = $_GPC['room'];
        $addr = $_GPC['build'] . '栋' . $_GPC['unit'] . '单元' . $_GPC['room'] . '室';
        $address = $_GPC['address'] ? $_GPC['address'] : $addr;
        $data = array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
            'mid' => $mem['id'],
            'regionid' => $mem['regionid'],
            'openid' => $_W['openid'],
            'build' => $build,
            'unit' => $unit,
            'room' => $room,
            'address' => $address,
            'telephone' => $mem['telephone'],
            'realname' => $mem['realname']
        );
        $r = pdo_insert('xcommunity_member_address',$data);
        if($r){
            echo json_encode(array('status' => 1));exit();
        }
    }

    include $this->template($this->xqtpl('member/address'));
}elseif($op == 'addr_ajax'){
    if($_W['isajax']){
        $aid = intval($_GPC['aid']);
        //绑定选中的地址
        pdo_update('xcommunity_member_address',array('enable' => 0),array('mid' => $mem['id'],'enable' => 1));
        pdo_update('xcommunity_member_address',array('enable'=>1),array('id' => $aid));
        $addr = pdo_get('xcommunity_member_address',array('id' => $aid),array('address'));

        pdo_update('xcommunity_member',array('address'=> $addr['address'],'build' => $addr['build'],'unit' => $addr['unit'],'room' => $addr['room']),array('id' => $mem['id']));
        echo json_encode(array('status' => 1));exit();
//        if($mid){
//            $r = pdo_update('xcommunity_member',array('enable' => 1),array('id' => $mid));
//            if($r){
//                echo json_encode(array('status' => 1));exit();
//            }
//        }

    }
}

	
	