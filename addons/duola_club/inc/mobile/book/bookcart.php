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
$ownerOpenId = $_GPC['ownerOpenId'];//图书拥有者openid
$orderType   = $_GPC['orderType'] ? $_GPC['orderType'] : 'borrow';//订单类型
$orderId     = $_GPC['orderId'] ? $_GPC['orderId'] : '';//订单id
//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
if(!empty($user)){
    $fans = pdo_fetch("select follow FROM ".tablename('mc_mapping_fans')." WHERE acid = '".$weid."' And openid = '".$openid."' ");
    if($fans['follow'] == 0){
        $url = "./index.php?i={$weid}&c=entry&id=2&do=ranking&m=sdl_code";
        echo "<script type='text/javascript'>alert('请先关注公众号');window.location.href='{$url}';</script>";
        exit;
    }
    //查询book
    $books = pdo_fetchall("SELECT mybook.openid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :status = mybook.status And :openid = mybook.openid And mybook.bookid in ({$_GPC['bookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':status' => 2,':openid' => $ownerOpenId), 'id');
    //查询个人闲书信息
    $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
    $balance = $userAccount['balance'];
    //未处理的订单会影响额度
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
    //查询头像
    $partyb = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $ownerOpenId), 'id');
    $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $weid));
    $ownerData = array(
        'userinfo' => unserialize($partyb['userinfo']),
        'userImg'  => $mcInfo['avatar'],
        'nickname' => $mcInfo['nickname'],
    );
    //已选书的总价值
    $chooseAmount = 0;
    foreach($books as $book){
        $chooseAmount +=  $book['price'];
    }
    $chooseAmount = sprintf('%0.2f',$chooseAmount);
    $balance      = sprintf('%0.2f',$balance);

    if($orderType == 'borrow' && !empty($orderId)){
        $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where id = {$orderId}");
    }elseif($orderType == 'transfer' && !empty($orderId)){
        $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where id = {$orderId}");
    }
    include $this->template('book/bookcart');
}else{
    include $this->template('bangding');
}
?>