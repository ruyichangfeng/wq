<?php
/**
 * Created by 微小区.
 * User: 晓锋
 * Date: 16/9/5
 * Time: 下午6:02
 * Function:
 */
global $_W,$_GPC;
$op = in_array($_GPC['op'],array('list','open','ajax','visit','door','qrcreate','xqdoor')) ? $_GPC['op'] : 'list';
$member = $this->changemember();
if(empty($member['mobile'])){
    $menu = pdmenu('opendoor');
    if(empty($menu['view'])){
        message('对不起,你不是本小区的业主,可在个人中心完善账户信息',$this->createMobileUrl('register',array('op' => 'member','regionid' => $member['regionid'])),'error');exit();
    }
}
$count = readnotice($member['regionid']);
//获取购物车数量
$carttotal = $this->getCartTotal();

if($op == 'list'){
    if(empty($member['open_status'])){
        message('您还没有使用智能门禁的权限,请联系物业办理',$this->createMobileUrl('home'),'error');exit();
    }
    $slides = xqslide(2,$member['regionid']);
    $xqset = $this->set($member['regionid'],'xqset');
    if($xqset['auth']){
        //$doors = pdo_getall('xcommunity_bind_door',array('openid' => $_W['fans']['from_user']),array('regionid','deviceid'));
        $doors =pdo_fetchall('select d.*,r.title from'.tablename('xcommunity_bind_door').'as d left join'.tablename('xcommunity_region').'as r on d.regionid = r.id where openid=:openid ',array(':openid' => $_W['fans']['from_user']));
//        print_r($doors);
        include $this->template($this->xqtpl('opendoor/xqlist'));
    }else{
        $list = pdo_getall('xcommunity_building_device',array('regionid' =>$member['regionid'],'type' => 2),array('id','title'));
        include $this->template($this->xqtpl('opendoor/list'));
    }

}elseif($op == 'open'){
    $list = pdo_getall('xcommunity_building_device',array('regionid' =>$member['regionid'],'type' => 2),array('id','title'));


    include $this->template($this->xqtpl('opendoor/door'));
}elseif($op == 'ajax'){
    if($_W['isajax']){
        $condition = " ";
        if($member['regionid']){
            $condition .="regionid =:regionid";
            $params[':regionid'] = $member['regionid'];
        }
        if($member['build']){
            $build = $member['build'].'栋';
            $condition .=" AND title =:build";
            $params[':build'] = $build;
        }
        if($member['unit']){
            $unit = $member['unit'].'单元';
            $condition .=" AND unit =:unit";
            $params[':unit'] = $unit;
        }
        $item = pdo_fetch("SELECT * FROM".tablename('xcommunity_building_device')."WHERE $condition",$params);
        //$item = pdo_get('xcommunity_building_device',$condition,array('id'));
        $id = $item['id'];
        //    if(empty($id)){
        //        message('设备不存在,请联系物业','ajax');exit();
        //    }else{
        echo json_encode(array('status' => 1,'id' => $id));exit();
        //    }
    }


}elseif($op == 'visit'){
    if($_W['isajax']){
        $type = intval($_GPC['type']);
        $door = intval($_GPC['door']);
        //二维码开门数据
        $data = array(
            'uniacid' => $_W['uniacid'],
            'regionid' => $member['regionid'],
            'opentime' => $_GPC['opentime'],
            'type' => $type,
            'createtime' => TIMESTAMP,
            'build' => $member['build'].'栋',
            'unit' => $member['unit'].'单元',
            'room' => $member['room'].'室',
            'address' => $member['address']
         );
        pdo_insert('xcommunity_opendoor_data',$data);
        $did = pdo_insertid();
        if($door){
            //说明是大门
            $url = $this->createMobileUrl('opendoor',array('op' => 'qrcreate','id' => $door,'did' => $did));
            echo json_encode(array('url' => $url,'status' => 1));exit();
        }else{
            //单元门
            $condition = " ";
            if($member['regionid']){
                $condition .="regionid =:regionid";
                $params[':regionid'] = $member['regionid'];
            }
            if($member['build']){
                $build = $member['build'].'栋';
                $condition .=" AND title =:build";
                $params[':build'] = $build;
            }
            if($member['unit']){
                $unit = $member['unit'].'单元';
                $condition .=" AND unit =:unit";
                $params[':unit'] = $unit;
            }
//            echo $condition;
            $item = pdo_fetch("SELECT * FROM".tablename('xcommunity_building_device')."WHERE $condition",$params);
//            print_r($item);

            if(empty($item[id])){
                //用户缺少楼栋和单元
                message('您还未开通智能门禁,请联系物业','ajax');exit();
            }else{
                $url = $this->createMobileUrl('opendoor',array('op' => 'qrcreate','id' => $item['id'],'did' => $did));
                echo json_encode(array('url' => $url,'status' => 1));exit();
            }

        }

    }

    include $this->template($this->xqtpl('opendoor/visit'));
}elseif($op == 'door'){
    if($_W['isajax']){
//        $member = $this->changemember();
        $list = pdo_getall('xcommunity_building_device',array('regionid' =>$member['regionid'],'type' => 2),array('id','title'));
        echo json_encode($list);
    }
}elseif($op == 'qrcreate'){
    $id = intval($_GPC['id']);
    $did = intval($_GPC['did']);
    require_once IA_ROOT. '/framework/library/qrcode/phpqrcode.php';
    $url = $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&c=entry&id={$id}&did={$did}&do=lock&m=xfeng_community";//二维码内容
    //		QRcode::png($url);
    $errorCorrectionLevel = 'L';//容错级别
    $matrixPointSize = 10;//生成图片大小
    //生成二维码图片
    QRcode::png($url, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
    //    $logo = $user['tag']['avatar'];//准备好的logo图片
    $QR = 'qrcode.png';//已经生成的原始二维码图
    echo "<div style='font-size: 48px;text-align:center;margin:0 auto '>长按二维码转发给朋友哦！</div><img src='qrcode.png' style='width: 100%;margin-top: 20px'>";
}elseif($op =='xqdoor'){
    if($_W['isajax']){
        $id = intval($_GPC['id']);
        if(empty($id)){
            echo json_encode(array('status' => 1,'content' => '缺少参数'));exit();
        }
        $doors = pdo_get("xcommunity_bind_door",array('id' => $id),array('deviceid'));
        if(empty($doors)){
            echo json_encode(array('status' => 2,'content' => '信息不存在或已删除'));exit();
        }
        $sql = "select id,title,unit from".tablename('xcommunity_building_device')."where id in({$doors['deviceid']}) order by displayorder asc";
        $devices = pdo_fetchall($sql);
        if($devices){
            echo json_encode(array('status' => 3,'content' => $devices));exit();
        }
    }
}

