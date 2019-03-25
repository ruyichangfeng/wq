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
    //查询book
    $books = pdo_fetchall("SELECT mybook.openid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :status = mybook.status And :openid = mybook.openid And mybook.bookid in ({$_GPC['bookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':status' => 2,':openid' => $ownerOpenId), 'id');
    //查询个人闲书信息
    $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
    $balance = $userAccount['balance'];
    //未处理的订单会影响额度
    $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2)", array(':openid' => $openid));
    if($orders['orderPrice']){
        $balance -= $orders['orderPrice'];
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