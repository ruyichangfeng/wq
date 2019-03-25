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
$age_id      = $_GPC['age_id'];//适合年龄id
$orderType   = $_GPC['orderType'] ? $_GPC['orderType'] : 'borrow';//订单类型
$orderId     = $_GPC['orderId'] ? $_GPC['orderId'] : '';//订单id
//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
if(!empty($user)){
    $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
    $book_lb = $book_age = $book_distance =array();
    foreach($category as $key => $value){
        switch($value['type']){
            case 'book_lb':
                $book_lb[$value['sid']] = $value;
                break;
            case 'book_age':
                $book_age[$value['sid']] = $value;
                break;
            case 'book_distance':
                $book_distance[$value['sid']] = $value;
            default:
                break;
        }
    }
    $condition = '';
    if(!empty($age_id)){
        $condition .= " AND book.age_id = '{$age_id}'";
    }
    //查询book
    $books = pdo_fetchall("SELECT mybook.openid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :status = mybook.status And :openid = mybook.openid $condition", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':status' => 2,':openid' => $ownerOpenId), 'id');
    //查询个人闲书信息
    $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
    $balance = $userAccount['balance'];
    //未处理的订单会影响额度
    $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2)", array(':openid' => $openid));
    $orderPrice = 0;
    if($orders['orderPrice']){
        $balance -= $orders['orderPrice'];
        $orderPrice += $orders['orderPrice'];
    }
    //查询头像
    $partyb = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $ownerOpenId), 'id');
    $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $weid));
    //对方最大可接受额度
    $margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin). " where type = 'book_max'");
    $partybAmount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $ownerOpenId));
    //获取简记id
    $jianji = pdo_fetch("select * from ".tablename('junsion_simpledaily_member')." where openid = '{$ownerOpenId}'");
    $ownerData = array(
        'userinfo' => unserialize($partyb['userinfo']),
        'userImg'  => $mcInfo['avatar'],
        'nickname' => $mcInfo['nickname'],
        'balance'  => $margin['amount'] - $partybAmount['balance']+$partybAmount['cz_amount']+$partybAmount['jy_amount']+$partybAmount['couponAmount']-$orderPrice,
        'jian_url'  => !empty($jianji) ? './index.php?i='.$weid.'&c=entry&mid='.$jianji['id'].'&do=MyWorks&m=junsion_simpledaily' : '#'
    );
    $justSee = !empty($_GPC['see']) ? $_GPC['see'] : false;
    if($justSee){
        include $this->template('book/mybookcenter');
    }else{
        include $this->template('book/bookCenter');
    }

}else{
    include $this->template('bangding');
}
?>