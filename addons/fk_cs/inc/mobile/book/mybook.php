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
        include $this->template('book/mybook');
    }
}else{
    include $this->template('bangding');
}
?>