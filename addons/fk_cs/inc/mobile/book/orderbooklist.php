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
if(!empty($user)){
    if(empty($_GPC['orderId']) || empty($_GPC['orderType'])){
        message('非法请求!');
    }
    $action = $_GPC['action'];
    $orderType = $_GPC['orderType'];
    $orderId = $_GPC['orderId'];
    if($_GPC['orderType'] == 'borrow'){
        $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where  id = {$_GPC['orderId']}");
        if(!empty($order)){
            $books = pdo_fetchall("SELECT mybook.openid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete  And mybook.bookid in ({$order['bookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
        }
    }else{
        if(!empty($_GPC['inBookIds'])){
            $bookIds = $_GPC['inBookIds'];
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = {$_GPC['orderId']}  and inBookIds = '{$_GPC['inBookIds']}'");
        }elseif(!empty($_GPC['outBookIds'])){
            $bookIds = $_GPC['outBookIds'];
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = {$_GPC['orderId']}  and outBookIds = '{$_GPC['outBookIds']}'");
        }
        if(!empty($order)){
            $books = pdo_fetchall("SELECT mybook.openid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete  And mybook.bookid in ({$bookIds})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
        }
    }

    include $this->template('book/orderbooklist');
}else{
    include $this->template('bangding');
}
?>