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
$orderId     = $_GPC['orderId'];
$orderType     = $_GPC['orderType'];
//查询是否用户登录
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
//if(!empty($user)){
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
    $book_user = pdo_fetch("SELECT name,mobile,area_addr,userAttribute FROM " . tablename($this->table_parents) . " where :schoolid = schoolid And :weid = weid And :openid = openid ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $ownerOpenId), 'id');
    $is_institution = false;
    if(!empty($book_user) && $book_user['userAttribute'] == 2){
        $is_institution = true;
    }
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
    $min = !empty($_GPC['min']) ? $_GPC['min'] : 0;
    $balance      = sprintf('%0.2f',$balance);
    $needReg = false;
    if(empty($user)){
        $needReg = true;
    }
    $bookMax = pdo_fetch("SELECT amount FROM " . tablename($this->table_bookmargin) . " where type = :type", array(':type' => 'book_max'));
    $bookMin = pdo_fetch("SELECT amount FROM " . tablename($this->table_bookmargin) . " where type = :type", array(':type' => 'book_min'));
    //查询今日已成交闲书订单金额
    $todayXianshuMoney = 0;
    $x_orders = pdo_fetch("SELECT sum(price) as x_price FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2,3) and from_unixtime(orderTime,'%Y-%m-%d') = :date", array(':openid' => $openid,':date' => date('Y-m-d')));
    if(!empty($x_orders)){
        $todayXianshuMoney = $x_orders['x_price'];
    }
    //查询易书订单
    $t_orders = pdo_fetch("SELECT sum(inPrice+outPrice) as t_price FROM " . tablename($this->table_mytransferorder) . " where  orderStatus in (1,2,3,4,5) and ((from_unixtime(inDate,'%Y-%m-%d') = {date('Y-m-d')} and openid = '{$openid}') or (from_unixtime(outDate,'%Y-%m-%d') = {date('Y-m-d')} and partybopenid = '{$openid}'))");
    $todayYishuMoney = 0;
    if(!empty($t_orders)){
        $todayYishuMoney =   $t_orders['t_price'];
    }
    $orderCount = $todayYishuMoney+$todayXianshuMoney;
//查询种类分布
$bookCats = array();
$cats     = array();
foreach ($books as $bk){
    if($bookCats[$bk['age_id']]['count'] > 0){
        $bookCats[$bk['age_id']]['count'] += 1;
    }else{
        $bookCats[$bk['age_id']]['count'] = 1;
    }
    if(empty($cats[$bk['age_id']])){
        $cats[$bk['age_id']] = array('age_id' => $bk['age_id'],'age_name' => $book_age[$bk['age_id']]['sname']);
    }
}
$content = '';
foreach ($cats as $bc){
    if(!empty($bookCats[$bc['age_id']])){
        $content .= $bc['age_name'].':'.$bookCats[$bc['age_id']]['count'].'本'.'|';
    }
}
    $links = $_W['siteroot'] .'app/'.$this->createMobileUrl('bookCenter',array('schoolid' => $schoolid,'ownerOpenId' => $ownerOpenId));
    $imgsUrl = $_W['siteroot'].'attachment/images/9/2017/01/logo_6.png';
    $content = trim($content,' ');
    if($justSee){
        include $this->template('book/mybookcenter');
    }else{
        include $this->template('book/bookCenter');
    }
//}else{
//    include $this->template('bangding');

//}
?>