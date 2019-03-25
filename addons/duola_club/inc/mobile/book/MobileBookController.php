<?php

/**
 * 闲书控制器
 * Created by PhpStorm.
 * User: liu
 * Date: 2017/2/4
 * Time: 下午2:17
 */
require_once 'BookController.php';
class MobileBookController extends BookController
{
    /**
     * MobileBookController constructor.
     * @param $schoolid
     * @param $openid
     * @param $weid
     */
    public function __construct($schoolid, $openid, $weid)
    {
        parent::__construct($schoolid, $openid, $weid);
    }


    /**
     *
     */
    public function display(){
        return $this->displayBorrowIn();
    }
    /**
     *入库操作
     */
    public function ruKu(){
        global $_GPC;
        $this->checkSubmitData();
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where  id = '{$_GPC['orderId']}'");
        if($order['orderStatus'] == 4){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '您已入库,不可重复操作！'
            ));
        }
        if(!empty($order)){
            //查询额度,确定是否可以交易
            $userBalance1 = $this->getBalance($order['openid']);
            $userAccount = $userBalance1['userAccount'];
            $balance = $userAccount['balance'] - $order['price'];
            if($balance < 0){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '您的可用余额不足,不可以入库！'
                ));
            }
            $margin = pdo_fetch("SELECT amount FROM " . tablename($this->duolaSite->table_bookmargin). " where type = 'book_discount'");
            $discountAmount = 0;
            if(!empty($margin) && $userAccount['onSaleAmount'] > 0){
                $discountAmount = sprintf('%0.2f',$order['price']*($margin['amount']/100));
                $logData = array(
                    'orderId' => 10000,
                    'amount'  => $discountAmount,
                    'type'    => 'xj',
                    'openid'  => $order['bookownerid'],
                    'remark'  => '下架'.$order['price'].'减额'.$discountAmount.''
                );
                pdo_insert($this->duolaSite->table_booklog,$logData);
            }
            pdo_update($this->duolaSite->table_bookaccount,array('balance' => $balance),array('openid' => $userAccount['openid']));
            //对方额度信息
            $userBalance2 = $this->getBalance($order['bookownerid']);
            $userAccount1 = $userBalance2['userAccount'];
            $couponAmount = $userAccount1['couponAmount'];
            if(!empty($discountAmount)){
                $couponAmount = floatval($userAccount1['couponAmount']) - floatval($discountAmount);
            }
            $balance1 = $userAccount1['balance'] + $order['price']-$discountAmount;
            pdo_update($this->duolaSite->table_bookaccount,array('balance' => $balance1,'onSaleAmount' => ($userAccount1['onSaleAmount'] - $order['price']),'couponAmount' => $couponAmount),array('openid' => $userAccount1['openid']));
            //订单状态更新为已完成
            pdo_update($this->duolaSite->table_myorder,array('orderStatus' => 4),array('id' => $order['id']));
            //额度变动明细
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['price'],
                'type'    => $_GPC['orderType'].'_sub',
                'openid'  => $order['openid'],
                'remark'  => '闲书入库消费'
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);

            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['price'],
                'type'    => $_GPC['orderType'].'_add',
                'openid'  => $order['bookownerid'],
                'remark'  => '闲书出库增额'
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);
            //模板消息通知
            $msgBody = array(
                'schoolid'   => $this->schoolid,
                'weid'       => $this->weid,
                'orderId'    => $_GPC ['orderId'],
                'orderType'  => $_GPC['orderType'],
                'amountData' => array(
                    $order['openid'] => array(
                        'preAmount'   => $userBalance1['balance']+$order['price'],
                        'afterAmount' => $userBalance1['balance'],
                        'action'      => 'in'
                    ),
                    $order['bookownerid'] => array(
                        'preAmount'   => $userBalance2['balance'],
                        'afterAmount' => $userBalance2['balance']+$order['price']-$discountAmount,
                        'discountAmount' => $discountAmount,
                        'action'      => 'out'
                    ),
                )
            );
            $this->duolaSite->sendMobileXsedbdtz($msgBody);
            //查询我的图书
            $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
        }
        if(empty($books)){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '订单有误！'
            ));
        }

        $updata = array(
            'openid' => $this->openid,
            'status' => 1,
            'lng'    => $this->userInfo['lng'],
            'lat'    => $this->userInfo['lat']
        );
        foreach($books as $book){
            pdo_update($this->duolaSite->table_mybook,$updata,array('id' => $book['id']));
        }
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '入库成功！'
        ));
    }

    /**
     *出库操作
     */
    public function chuKu(){
        global $_GPC;
        $this->checkSubmitData();
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where  id = '{$_GPC['orderId']}'");
        if($order['isOk'] == 2){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '您已出库,不可重复操作！'
            ));
        }
        if(!empty($order)){
            //查询我的图书
            $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
            if(empty($books)){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '订单有误！'
                ));
            }
        }
        //订单状态更新为已完成
        pdo_update($this->duolaSite->table_myorder,array('isOk' => 2,'orderStatus' => 3),array('id' => $order['id']));
        $updata = array(
            'openid' => $order['openid']
        );
        $logData = array(
            'orderId' => $order['id'],
            'amount'  => $order['price'],
            'type'    => $_GPC['orderType'],
            'openid'  => $this->openid,
            'remark'  => '出库'
        );
        pdo_insert($this->duolaSite->table_booklog,$logData);
        foreach($books as $book){
            pdo_update($this->duolaSite->table_mybook,$updata,array('id' => $book['id']));
        }
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '出库成功！'
        ));
    }

    /**
     *取消订单
     */
    public function cancelOrder(){
       global $_GPC;
       $this->checkSubmitData();
       $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where  id = '{$_GPC['orderId']}'");
       if($order['isOk'] == 2){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '已出库,不能取消！'
            ));
        }
        if($order['orderStatus'] == 3 || $order['orderStatus'] == 4){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '当前状态,不能取消！'
            ));
        }
        if(!empty($order)){
            //查询我的图书
            $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
        }
        if($books){
            $upbook = array(
                'status' => 2
            );
            foreach($books as $book){
                pdo_update($this->duolaSite->table_mybook,$upbook,array('id' => $book['id']));
            }
        }
        //订单状态更新为已取消
        $cancelData = array(
            'orderStatus' => 5,
            'cancelReasonId' => $_GPC['cancelId'],
            'cancelOpenid' => $this->openid,
            'canceltime' => time()
        );
        $logData = array(
            'orderId' => $order['id'],
            'amount'  => $order['price'],
            'type'    => $_GPC['orderType'],
            'openid'  => $this->openid,
            'remark'  => '取消'
        );
        pdo_insert($this->duolaSite->table_booklog,$logData);
        pdo_update($this->duolaSite->table_myorder,$cancelData,array('id' => $order['id']));
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '取消成功！'
        ));
    }

    /**
     *确定订单
     */
    public function confirmOrder(){
        global $_GPC;
        $this->checkSubmitData();
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where  id = '{$_GPC['orderId']}'");
        if($order['orderStatus'] != 1){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '当前状态不能确认！'
            ));
        }
        //订单状态更新为可出库
        $confirmData = array(
            'orderStatus' => 2
        );
        $logData = array(
            'orderId' => $order['id'],
            'amount'  => $order['price'],
            'type'    => $_GPC['orderType'],
            'openid'  => $this->openid,
            'remark'  => '接受订单'
        );
        pdo_insert($this->duolaSite->table_booklog,$logData);
        pdo_update($this->duolaSite->table_myorder,$confirmData,array('id' => $order['id']));
        $this->duolaSite->sendMobileXsqdtz($this->schoolid,$_GPC ['orderId'],$this->weid,'borrow','in');
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '确认成功！'
        ));
    }

    /**
     *下订单
     */
    public function order(){
        global $_GPC;
        if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '非法请求！'
            ));
        }
        //检查对方额度是否到达上限
//        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->duolaSite->table_bookaccount) . " where openid = :openid", array(':openid' => $_GPC['bookownerid']));
//        $margin = pdo_fetch("SELECT * FROM " . tablename($this->duolaSite->table_bookmargin). " where type = 'book_max'");
//        $balance = $userAccount['balance'] + $_GPC['price'];
//        $maxAmount = $margin['amount'] +$userAccount['cz_amount']+$userAccount['jy_amount']+$userAccount['couponAmount'];
//            if($balance > $maxAmount){
//                die(
//                    json_encode(
//                        array(
//                            'result' => false,
//                            'msg'    => '对方额度已满,超出额度:'.($balance-$maxAmount)
//                        )
//                    )
//                );
//            }
        //检出图书状态是否可以借出
        $bookIds = explode(',',trim($_GPC['bookIds'],','));
        foreach($bookIds as $bookId){
            $book = pdo_fetch("SELECT mybook.openid,mybook.status,book.* FROM " . tablename($this->duolaSite->table_mybook) . " as mybook left Join ".tablename($this->duolaSite->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :bookid = mybook.bookid And mybook.openid = :openid", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1,':bookid' => $bookId,':openid' => $_GPC['bookownerid']));
            if($book['status'] != 2){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '抱歉,您所借的['.$book['title'].'],对方已下架！'
                ));
            }
            //验证订单状态
            $bookOrder = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->duolaSite->table_myorder) . " where find_in_set({$bookId},bookIds) and orderStatus in(".self::UN_COMPLETE_STATUS.")");
            if($bookOrder['orderCount'] > 0){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '您的手速慢了哦,所借的['.$book['title'].'],已被他人借走！'
                ));
            }
            //检查自己书库是否包含这本书
            $book1 = pdo_fetch("SELECT mybook.openid,mybook.status,book.title FROM " . tablename($this->duolaSite->table_mybook) . " as mybook left Join ".tablename($this->duolaSite->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :bookid = mybook.bookid And mybook.openid = :openid", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1,':bookid' => $bookId,':openid' => $this->openid));
            if(!empty($book1)){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '您的书库里已经有['.$book1['title'].']！'
                ));
            }
        }

        //生成订单
        $data = array(
            'weid'        => $_GPC['weid'],
            'schoolid'    => $_GPC['schoolid'],
            'openid'      => $_GPC['openid'],
            'bookownerid' => $_GPC['bookownerid'],
            'price'       => $_GPC['price'],
            'bookIds'     => trim($_GPC['bookIds'],','),
            'orderTime'   => time()
        );
        $result = pdo_insert($this->duolaSite->table_myorder,$data);
        if($result){
            //添加日志
            $orderId = pdo_insertid();
            $logData = array(
                'orderId' => $orderId,
                'amount'  => $_GPC['price'],
                'type'    => $_GPC['orderType'],
                'openid'  => $this->openid,
                'remark'  => '借书'
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);
            //更新图书状态
            foreach($bookIds as $bookId){
                pdo_update($this->duolaSite->table_mybook,array('status' => 3),array('bookid' => $bookId,'openid' => $_GPC['bookownerid']));
            }
            //发送模板消息
            $this->duolaSite->sendMobileXsddtz($this->schoolid,$orderId,$this->weid,'borrow','out');
            $this->formatJsonData(array (
                'result' => true,
                'msg' => '借书成功!'
            ));
        }else{
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '借书失败!'
            ));
        }
    }

    /**
     *更新订单状态
     */
    public function updateOrderStatus(){
        global $_GPC;
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId'] || ! $_GPC ['orderStatus']) {
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '非法请求！'
            ));
        }
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where  id = '{$_GPC['orderId']}'");
        if(in_array($order['orderStatus'],array(4,5))){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '当前状态,不能取消！'
            ));
        }
        $cancelData = array(
            'cancelOpenid' => $this->openid,
            'canceltime' => time()
        );
        if($order['orderStatus'] == 3){
            $cancelData['orderStatus'] = 2;
            $cancelData['isOk'] = 1;
            $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
            foreach($books as $book){
                pdo_update($this->duolaSite->table_mybook,array('openid' => $order['bookownerid']),array('id' => $book['id']));
            }
        }elseif($order['orderStatus'] == 2){
            $cancelData['orderStatus'] = 1;
        }elseif($order['orderStatus'] == 1){
            $cancelData['orderStatus'] = 5;
            $cancelData['cancelReasonId'] = $_GPC['cancelId'];
            //更新图书状态
            $books = pdo_fetchall("SELECT id FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
            foreach($books as $book){
                pdo_update($this->duolaSite->table_mybook,array('status' => 2),array('id' => $book['id']));
            }
            //取消发送模板消息
            $this->duolaSite->sendMobileXsqxtz($this->schoolid,$_GPC ['orderId'],$this->weid,'borrow');
        }
        $logData = array(
            'orderId' => $order['id'],
            'amount'  => $order['outPrice']+$order['inPrice'],
            'type'    => $_GPC['orderType'],
            'openid'  => $this->openid,
            'remark'  => '状态还原'
        );
        pdo_insert($this->duolaSite->table_booklog,$logData);
        pdo_update($this->duolaSite->table_myorder,$cancelData,array('id' => $order['id']));
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '取消成功！'
        ));
    }

    /**
     *取消订单中某一本书
     */
    public function cancelBook(){
        global $_GPC;
        $this->checkSubmitData();
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where  id = '{$_GPC['orderId']}'");
        if($order['isOk'] == 2){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '已出库,不能取消！'
            ));
        }
        if($order['orderStatus'] == 3 || $order['orderStatus'] == 4){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '当前状态,不能取消！'
            ));
        }
        $bookIds = explode(',',$order['bookIds']);
        //图书状态还原
        pdo_update($this->duolaSite->table_mybook,array('status' => 2),array('id' => $_GPC['bookid']));
        if(count($bookIds) <=1 ){
            //删除该笔订单
            $cancelData = array(
                'orderStatus' => 4,
                'cancelOpenid' => $this->openid,
                'canceltime' => time()
            );
            pdo_update($this->duolaSite->table_myorder,$cancelData,array('id' => $order['id']));
        }else{
            //更新订单图书
            $index = array_search($_GPC ['orderId'],$bookIds);
            unset($bookIds[$index]);
            $cancelData = array(
                'bookIds' => implode(',',$bookIds)
            );
            pdo_update($this->duolaSite->table_myorder,$cancelData,array('id' => $order['id']));
        }
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '取消成功！'
        ));
    }


    /**
     *查询待入库闲书
     */
    public function displayBorrowIn(){
        $bookOrder = pdo_fetchall("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where   openid = '{$this->openid}' order by createDate desc");
        $orderType = 'borrow';
        $action    = 'in';
        return $this->formatReturn($bookOrder,$orderType,$action);
    }

    /**
     *查询待出口闲书
     */
    public function displayBorrowOut(){
        $bookOrder = pdo_fetchall("SELECT * FROM ".tablename($this->duolaSite->table_myorder) . " where   bookownerid = '{$this->openid}' order by createDate desc");
        $orderType = 'borrow';
        $action    = 'out';
        return $this->formatReturn($bookOrder,$orderType,$action);
    }


    /**
     * @param $bookOrder
     * @return array
     */
    public function formatData($bookOrder){
        $orders = array();
        $users = array();
        foreach($bookOrder as $item){
            if(empty($users[$item['openid']])){
                //获取闲书订单发起人信息
                $partyb = pdo_fetch("SELECT * FROM " . tablename($this->duolaSite->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $this->weid, ':schoolid' => $this->schoolid, ':openid' => $item['openid']), 'id');
                $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $this->weid));
                $users[$item['openid']] = array(
                    'userinfo' => unserialize($partyb['userinfo']),
                    'userImg'  => $mcInfo['avatar'],
                    'nickname' => $mcInfo['nickname'],
                );
            }
            //判断当前用户是否订单发起人
            if($item['openid'] == $this->openid){
                $partybid = $item['bookownerid'];
            }else{
                $partybid = $item['openid'];
            }

            //处理订单下单时间
            if(!empty($item['orderTime'])){
                $item['createDate'] = date('Y-m-d H:i:s',$item['orderTime']);
            }

            //转换订单状态
            if($item['orderStatus'] == 1){
                $item['orderStatusName'] = '订单待确认';
            }elseif($item['orderStatus'] == 2){
                $item['orderStatusName'] = '确认待实物出库';
            }elseif($item['orderStatus'] == 3){
                $item['orderStatusName'] = '出库待入库';
            }elseif($item['orderStatus'] == 4){
                $item['orderStatusName'] = '已完成';
            }elseif($item['orderStatus'] == 5){
                $item['orderStatusName'] = '已取消';
            }

            //获取卖家信息
            if(empty($users[$item['bookownerid']])){
                $partyb = pdo_fetch("SELECT * FROM " . tablename($this->duolaSite->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $this->weid, ':schoolid' => $this->schoolid, ':openid' => $item['bookownerid']), 'id');
                $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $this->weid));
                $users[$item['bookownerid']] = array(
                    'userinfo' => unserialize($partyb['userinfo']),
                    'userImg'  => $mcInfo['avatar'],
                    'nickname' => $mcInfo['nickname'],
                );
            }
            //获取两者之间的距离
            $kmDistance = $this->duolaSite->getDistance($users[$item['openid']]['userinfo']['lat'],$users[$item['openid']]['userinfo']['lng'],$users[$item['bookownerid']]['userinfo']['lat'],$users[$item['bookownerid']]['userinfo']['lng']);;
            $item['distance'] = $this->duolaSite->mToKm($kmDistance);

            //买家头像，用户名和基本信息
            $item['userinfo'] = $users[$item['openid']]['userinfo'];
            $item['userImg'] = $users[$item['openid']]['userImg'];
            $item['nickname'] = $users[$item['openid']]['nickname'];
            //卖家头像，用户名和基本信息
            $item['userinfo1'] = $users[$item['bookownerid']]['userinfo'];
            $item['userImg1'] = $users[$item['bookownerid']]['userImg'];
            $item['nickname1'] = $users[$item['bookownerid']]['nickname'];
            $item['partybid'] = $partybid;
            $orders[] = $item;
        }
        return $orders;
    }

}