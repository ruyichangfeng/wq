<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = $_W['openid'];
//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
$op     = $_GPC['op'] ? $_GPC['op'] : '';
$userinfo = unserialize($user['userinfo']);
if(!empty($user)){
    if($op == 'score'){
        if(empty($_GPC['schoolid']) || empty($_GPC['orderId']) || empty($_GPC['orderType'])){
            message('非法访问!');
        }
        $data = array(
            'openid'       => $openid,
            'orderid'      => $_GPC['orderId'],
            'orderType'    => $_GPC['orderType'],
            'book_quality' => $_GPC['book_quality'],
            'book_service' => $_GPC['book_service'],
            'book_time'    => $_GPC['book_time']
        );
        pdo_insert($this->table_bookscore,$data);
        die(json_encode(
            array(
                'result' => true,
                'msg'    => '评价成功!'
            )
        ));
    }elseif($op == 'search'){
        //进入评价系统
        $orderID   = $_GPC['orderID'];
        $orderType = $_GPC['orderType'];
        if(empty($orderID) || empty($orderType)){
            message('非法访问!');
        }
        include $this->template('book/bookscore');
    }else{
        //查询数据
        $orderDatas = pdo_fetchall("SELECT * FROM ".tablename($this->table_myorder) . " where  orderStatus = 4  and (bookownerid = '{$openid}' or openid = '{$openid}')");
        $orders = array();
        $users = array();
        if($orderDatas){
            foreach($orderDatas as $order){
                if($order['openid'] == $openid){
                    $useropenid =  $order['bookownerid'];
                }else{
                    $useropenid = $order['openid'];
                }
                if(!empty($useropenid)){
                    if(empty($users[$useropenid])){
                        $bookOwner = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $useropenid), 'id');
                        $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $bookOwner['uid'], ':uniacid' => $weid));
                        $users[$useropenid] = array(
                            'userImg' => $mcInfo['avatar'],
                            'nickname' => $mcInfo['nickname']
                        );
                    }
                    //查询是否评价过
                    $count = pdo_fetch("select count(id) as orderCount from ".tablename($this->table_bookscore)." where :openid = openid And :orderid = orderid And :orderType = orderType",array(':openid' => $openid,':orderid' => $order['id'],':orderType' => 'borrow'));
                    if($count['orderCount'] > 0){
                        continue;
                    }
                    $order['icon'] = $users[$useropenid]['userImg'];
                    $order['nickname'] = $users[$useropenid]['nickname'];
                    $order['orderScore'] = $count['orderCount'];
                    $orders[] = $order;
                }
            }
        }
        $tranferDatas = pdo_fetchall("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  orderStatus = 6 and (partybopenid = '{$openid}' or openid = '{$openid}')");
        $tranferorders = array();
        $users1 = array();
        if($tranferDatas){
            foreach($tranferDatas as $order){
                $order['price'] = abs($order['inPrice']-$order['outPrice']);
                $order['createDate'] = date('Y-m-d H:i:s',$order['inDate']);
                if(empty($users1[$order['partybopenid']])){
                    $bookOwner = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $order['partybopenid']), 'id');
                    $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $bookOwner['uid'], ':uniacid' => $weid));
                    $users1[$order['partybopenid']] = array(
                        'userImg' => $mcInfo['avatar'],
                        'nickname' => $mcInfo['nickname']
                    );
                }
                if(empty($users1[$order['openid']])){
                    $bookOwner = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $order['openid']), 'id');
                    $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $bookOwner['uid'], ':uniacid' => $weid));
                    $users1[$order['openid']] = array(
                        'userImg' => $mcInfo['avatar'],
                        'nickname' => $mcInfo['nickname']
                    );
                }
                //查询是否评价过
                $count = pdo_fetch("select count(id) as orderCount from ".tablename($this->table_bookscore)." where :openid = openid And :orderid = orderid And :orderType = orderType",array(':openid' => $openid,':orderid' => $order['id'],':orderType' => 'transfer'));
                if($count['orderCount'] > 0){
                    continue;
                }
                if($order['openid'] == $openid){
                    $order['icon'] = $users1[$order['partybopenid']]['userImg'];
                    $order['nickname'] = $users1[$order['partybopenid']]['nickname'];
                }else{
                    $order['icon'] = $users1[$order['openid']]['userImg'];
                    $order['nickname'] = $users1[$order['openid']]['nickname'];
                }
                $order['orderScore'] = $count['orderCount'];
                $tranferorders[] = $order;
            }

        }
        $count = count($orders) + count($tranferorders);
        include $this->template('book/bookscorelist');
    }
}else{
    include $this->template('bangding');
}
?>