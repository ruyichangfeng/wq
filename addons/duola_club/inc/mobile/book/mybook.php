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
$op = $_GPC['op'] ? $_GPC['op'] : 'display';
if(!empty($user)){
    $fans = pdo_fetch("select follow FROM ".tablename('mc_mapping_fans')." WHERE acid = '".$weid."' And openid = '".$openid."' ");
    if($fans['follow'] == 0){
        $url = "./index.php?i={$weid}&c=entry&id=2&do=ranking&m=sdl_code";
        echo "<script type='text/javascript'>alert('请先关注公众号');window.location.href='{$url}';</script>";
        exit;
    }
    if($op == 'show_img'){
        $book = pdo_fetch("select * from " .tablename($this->table_mybook)."where openid = '{$_GPC['owneropenid']}' and bookid = {$_GPC['bookid']} and is_delete = 1");
        include $this->template('book/mybookimg');
    }else{
        //查询个人账户
        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
        $item = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $user['uid'], ':uniacid' => $weid));
        //查询保证金
        $margins = pdo_fetchall("SELECT * FROM " . tablename($this->table_bookmargin));
        $bookMargin = array();
        foreach($margins as $margin){
            $bookMargin[$margin['type']] = $margin;
        }
//        //检查是否有未处理易书订单
//        $bookOrder = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->table_mytransferorder) . " where partybopenid = '{$openid}' and orderStatus in(1,2,3,4,7)");
//        $orderCount = $bookOrder['orderCount'];
        $this->checkBookAccount($openid,$schoolid,$weid);
        //查询未评价订单
        $orderDatas = pdo_fetchall("SELECT * FROM ".tablename($this->table_myorder) . " where  orderStatus = 4  and (bookownerid = '{$openid}' or openid = '{$openid}')");
        $orders = array();
        if($orderDatas){
            foreach($orderDatas as $order){
                if($order['openid'] == $openid){
                    $useropenid =  $order['bookownerid'];
                }else{
                    $useropenid = $order['openid'];
                }
                if(!empty($useropenid)){
                    //查询是否评价过
                    $count = pdo_fetch("select count(id) as orderCount from ".tablename($this->table_bookscore)." where :openid = openid And :orderid = orderid And :orderType = orderType",array(':openid' => $openid,':orderid' => $order['id'],':orderType' => 'borrow'));
                    if($count['orderCount'] > 0){
                        continue;
                    }
                    $orders[] = $order;
                }
            }
        }
        $tranferDatas = pdo_fetchall("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  orderStatus = 6 and (partybopenid = '{$openid}' or openid = '{$openid}')");
        $tranferorders = array();
        if($tranferDatas){
            foreach($tranferDatas as $order){
                if($data['openid'] == $openid){
                    $useropenid =  $order['partybopenid'];
                }else{
                    $useropenid = $order['openid'];
                }
                if(!empty($useropenid)){
                    //查询是否评价过
                    $count = pdo_fetch("select count(id) as orderCount from ".tablename($this->table_bookscore)." where :openid = openid And :orderid = orderid And :orderType = orderType",array(':openid' => $openid,':orderid' => $order['id'],':orderType' => 'transfer'));
                    if($count['orderCount'] > 0){
                        continue;
                    }
                    $tranferorders[] = $order;
                }
            }
        }
        $count = count($orders) + count($tranferorders);
        $jizanUrl = './index.php?i='.$weid.'&c=entry&id=2&do=index&issub=1&m=jy_reads';
        //查询押金余额
        load()->model('mc');
        $result = mc_credit_fetch($_W['member']['uid']);
        //查询简记
        $countJj = pdo_fetchcolumn("select count(1) from ".tablename('junsion_simpledaily_works')." where openid='{$mem['openid']}' and status=0");
        //获取简记id
        $jianji = pdo_fetch("select * from ".tablename('junsion_simpledaily_member')." where openid = '{$openid}'");
        $jian_url = './index.php?i='.$weid.'&c=entry&mid='.$jianji['id'].'&do=MyWorks&m=junsion_simpledaily';
        //待上架数量
        $unsalebooks = pdo_fetch("SELECT count(1) as unsaleCount FROM " .tablename($this->table_mybook)." where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And :status = status  And :openid = openid ", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':status' => 1,':openid' => $openid), 'id');
        //未处理的订单会影响额度
        $balance = $userAccount['balance'];
        $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $openid));
        if($orders['orderPrice']){
            $balance -= $orders['orderPrice'];
        }
        $trans_orders = pdo_fetchall("SELECT inPrice,outPrice,openid,partybopenid FROM " . tablename($this->table_mytransferorder) . " where  orderStatus in (1,2,3,4,5) And (openid = '{$openid}' or partybopenid = '{$openid}')");
        if(count($trans_orders) > 0){
            $orderPrice = 0;
            foreach ($trans_orders as $trans_order){
                if($openid == $trans_order['openid'] && $trans_order['inPrice'] > 0){
                    $orderPrice += $trans_order['inPrice'];
                }
                if($openid == $trans_order['partybopenid'] && $trans_order['outPrice'] > 0){
                    if($trans_order['outPrice'] > $trans_order['inPrice']){
                        $orderPrice += ($trans_order['outPrice']-$trans_order['inPrice']);
                    }
                }
            }
            $balance -= $orderPrice;
        }
        if($balance < 0){
            $balance = 0;
        }
        include $this->template('book/mybook');
    }
}else{
    $userType = 'bookUser';
    $typeName = '闲书用户信息完善';
    $userData = array();
    $p = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND openid=:openid AND schoolid=:schoolid AND :userType = userType", array(':weid' => $weid, ':openid' => $openid, ':schoolid' => $schoolid,':userType' => 'parents'));
    if(empty($p)){
        $it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where  weid = :weid And schoolid = :schoolid And openid = :openid And sid = :sid And pid = :pid Order by createtime desc ", array(
            ':weid' => $weid,
            ':schoolid' => $schoolid,
            ':openid' => $openid,
            ':sid' => 0,
            ':pid' => 0
        ));
        $p = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $it['tid']));
    }
    $location = json_decode($p['area_addr_location'],true);
    $userData['name'] = $p['name'] ? $p['name'] : $p['tname'];
    $userData['mobile'] = $p['mobile'];
    $userData['area_addr'] = $p['area_addr'];
    $userData['lng'] = $location['lng'];
    $userData['lat'] = $location['lat'];
    include $this->template('bangding');
}
?>