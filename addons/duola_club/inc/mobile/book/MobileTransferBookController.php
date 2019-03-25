<?php

/**
 * 易书订单处理器
 * Created by PhpStorm.
 * User: liu
 * Date: 2017/2/5
 * Time: 下午2:56
 */
require_once 'BookController.php';
class MobileTransferBookController extends BookController
{
    private $CAN_NOT_CANCEL_STATUS = [1,6,7];
    private $CAN_CONFIRM_STATUS = [1,3];
    /**
     * MobileTransferBookController constructor.
     * @param $schoolid
     * @param $openid
     * @param $weid
     */
    public function __construct($schoolid, $openid, $weid)
    {
        parent::__construct($schoolid, $openid, $weid);
    }
    /**
     *入库操作
     */
    public function ruKu(){
        global $_GPC;
        $this->checkSubmitData();
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
        if($this->openid == $order['openid']){
            //首发订单入库,交易完成
            if($order['orderStatus'] != 5){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '当前状态不能入库！'
                ));
            }
            if(!empty($order)){
                //查询我的图书
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['inBookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
            }
            if($order['orderStatus'] == 5){
                $diff = $order['outPrice'] - $order['inPrice'];
                $userBalance1 = $this->getBalance($order['openid']);
                $userAccount = $userBalance1['userAccount'];
                //对方额度信息
                $userBalance2 = $this->getBalance($order['partybopenid']);
                $userAccount1 = $userBalance2['userAccount'];
                $margin = pdo_fetch("SELECT amount FROM " . tablename($this->duolaSite->table_bookmargin). " where type = 'book_discount'");
                $discountAmount = $discountAmount1 = 0;
                $couponAmount = $userAccount['couponAmount'];
                $couponAmount1 = $userAccount1['couponAmount'];
                if(!empty($margin)){
                    if($userAccount['onSaleAmount'] > 0){
                        $discountAmount = sprintf('%0.2f',$order['outPrice']*($margin['amount']/100));
                        $couponAmount = $userAccount['couponAmount'] - $discountAmount;
                    }
                    if($userAccount1['onSaleAmount'] > 0){
                        $discountAmount1 = sprintf('%0.2f',$order['inPrice']*($margin['amount']/100));
                        $couponAmount1 = $userAccount1['couponAmount'] - $discountAmount1;
                    }
                }
                $balance = $userAccount['balance'] + $diff-$discountAmount;
                $balance1 = $userAccount1['balance'] - $diff-$discountAmount1;
                if($diff > 0){
                    if($balance1 < 0){
                        $this->formatJsonData(array (
                            'result' => false,
                            'msg' => '无法入库,回选订单用户的余额不足！'
                        ));
                    }
                }elseif($diff <= 0 ){
                    if($balance < 0){
                        $this->formatJsonData(array (
                            'result' => false,
                            'msg' => '无法入库,首发订单用户的余额不足！'
                        ));
                    }
                }
                if($discountAmount > 0){
                    $logData = array(
                        'orderId' => 10000,
                        'amount'  => $discountAmount,
                        'type'    => 'xj',
                        'openid'  => $order['openid'],
                        'remark'  => '下架'.$order['outPrice'].'减额'.$discountAmount.''
                    );
                    pdo_insert($this->duolaSite->table_booklog,$logData);
                }
                if($discountAmount1 > 0){
                    $logData1 = array(
                        'orderId' => 10000,
                        'amount'  => $discountAmount1,
                        'type'    => 'xj',
                        'openid'  => $order['partybopenid'],
                        'remark'  => '下架'.$order['inPrice'].'减额'.$discountAmount1.''
                    );
                    pdo_insert($this->duolaSite->table_booklog,$logData1);
                }
                pdo_update($this->duolaSite->table_bookaccount,array('balance' => $balance,'onSaleAmount' => ($userAccount['onSaleAmount'] - $order['outPrice']),'couponAmount' => $couponAmount),array('openid' => $userAccount['openid']));
                pdo_update($this->duolaSite->table_bookaccount,array('balance' => $balance1,'onSaleAmount' => ($userAccount1['onSaleAmount'] - $order['inPrice']),'couponAmount' => $couponAmount1),array('openid' => $userAccount1['openid']));
                pdo_update($this->duolaSite->table_mytransferorder,array('orderStatus' => 6),array('id' => $order['id']));
                $b1= $userBalance1['balance'];
                if($b1 == 0){
                    $b1 =   $userBalance1['userAccount']['balance'];
                }else{
                    $b1 =  $userBalance1['balance']+$order['inPrice'];
                }
                $msgBody = array(
                    'schoolid'   => $this->schoolid,
                    'weid'       => $this->weid,
                    'orderId'    => $_GPC ['orderId'],
                    'orderType'  => $_GPC['orderType'],
                    'amountData' => array(
                        $order['openid'] => array(
                            'preAmount'   => $b1,
                            'afterAmount' =>  $b1 + $diff-$discountAmount,
                            'discountAmount' => $discountAmount
                        ),
                        $order['partybopenid'] => array(
                            'preAmount'   => $diff > 0 ? ($userBalance2['balance'] + $diff ) : $userBalance2['balance'],
                            'afterAmount' => $diff > 0 ? ($userBalance2['balance']-$discountAmount1) : ($userBalance2['balance']- $diff-$discountAmount1),
                            'discountAmount' => $discountAmount1
                        ),
                    )
                );
                $this->duolaSite->sendMobileXsedbdtz($msgBody);
            }
            //额度变动明细
            if($diff > 0){
                $t1 = '首发订单入库增额';
                $type1 = $_GPC['orderType'].'_add';
                $t2 = '回选订单出库减额';
                $type2 = $_GPC['orderType'].'_sub';
            }else{
                $t1 = '首发订单入库减额';
                $type1 = $_GPC['orderType'].'_sub';
                $t2 = '回选订单出库增额';
                $type2 = $_GPC['orderType'].'_add';
            }
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => abs($diff),
                'type'    => $type1,
                'openid'  => $order['openid'],
                'remark'  => $t1
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);

            $logData = array(
                'orderId' => $order['id'],
                'amount'  => abs($diff),
                'type'    => $type2,
                'openid'  => $order['partybopenid'],
                'remark'  => $t2
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);
        }else{
            if($order['orderStatus'] != 3){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '当前状态您还不能入库！'
                ));
            }
            if(!empty($order)){
                //查询我的图书
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
            }

            if($order['orderStatus'] == 3){
                //更新额度
//                $diff = $order['outPrice'] - $order['inPrice'];
//                if($diff < 0){
//                    $this->formatJsonData(array (
//                        'result' => false,
//                        'msg' => '无法入库,您的易书金额小于对方易书金额！'
//                    ));
//                }
                //更新订单状态
                pdo_update($this->duolaSite->table_mytransferorder,array('orderStatus' => 4),array('id' => $order['id']));
            }else{
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '订单状态有误,您还不能入库！'
                ));
            }
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['outPrice'],
                'type'    => $_GPC['orderType'],
                'openid'  => $this->openid,
                'remark'  => '回选订单入库'
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);
        }
        if(empty($books)){
            die ( json_encode ( array (
                'result' => false,
                'msg' => '订单有误！'
            ) ) );
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
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
        if(!empty($order)){
            //更新订单状态
            if($order['openid'] == $this->openid){
                //回选订单
                if(empty($order['outBookIds'])){
                    $this->formatJsonData(array (
                        'result' => false,
                        'msg' => '订单有误！'
                    ));
                }
                if($order['orderStatus'] == 3){
                    $this->formatJsonData(array (
                        'result' => false,
                        'msg' => '您已出库,不能重复出库！'
                    ));
                }
                //查询我的图书
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
                if(empty($books)){
                    $this->formatJsonData(array (
                        'result' => false,
                        'msg' => '订单有误！'
                    ));
                }
                pdo_update($this->duolaSite->table_mytransferorder,array('outOk' => 2,'orderStatus' => 3),array('id' => $order['id']));
                $updata = array(
                    'openid' => $order['partybopenid']
                );
                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $order['outPrice'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $this->openid,
                    'remark'  => '回选订单出库'
                );
                pdo_insert($this->duolaSite->table_booklog,$logData);
                foreach($books as $book){
                    pdo_update($this->duolaSite->table_mybook,$updata,array('id' => $book['id']));
                }
            }else{
                if(empty($order['inBookIds'])){
                    $this->formatJsonData(array (
                        'result' => false,
                        'msg' => '订单有误！'
                    ));
                }
                //查询我的图书
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['inBookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
                if(empty($books)){
                    $this->formatJsonData(array (
                        'result' => false,
                        'msg' => '订单有误！'
                    ));
                }
                pdo_update($this->duolaSite->table_mytransferorder,array('inOk' => 2,'orderStatus' => 5),array('id' => $order['id']));
                $updata = array(
                    'openid' => $this->openid
                );
                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $order['inPrice'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $this->openid,
                    'remark'  => '首发订单出库'
                );
                pdo_insert($this->duolaSite->table_booklog,$logData);
                foreach($books as $book){
                    pdo_update($this->duolaSite->table_mybook,$updata,array('id' => $book['id']));
                }
            }
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
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
//        if($order['orderStatus'] != 1){
//            $this->formatJsonData(array (
//                'result' => false,
//                'msg' => '当前状态,不能取消！'
//            ));
//        }
        if(!empty($order['outBookIds'])){
            $bookIds = array_merge(explode(',',$order['outBookIds']), explode(',',$order['inBookIds']));
        }else{
            $bookIds = explode(',',$order['inBookIds']);
        }
        //查询我的图书
        $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in (".implode(',',$bookIds).")", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
        if($books){
            $upbook = array(
                'status' => 2
            );
            foreach($books as $book){
                pdo_update($this->duolaSite->table_mybook,$upbook,array('id' => $book['id']));
            }
        }
        $cancelData = array(
            'orderStatus' => 7,
            'cancelOpenid' => $this->openid,
            'cancelReasonId' => $_GPC['cancelId'],
            'canceltime' => time()
        );
        $logData = array(
            'orderId' => $order['id'],
            'amount'  => $order['outPrice']+$order['inPrice'],
            'type'    => $_GPC['orderType'],
            'openid'  => $this->openid,
            'remark'  => '取消'
        );
        pdo_insert($this->duolaSite->table_booklog,$logData);
        pdo_update($this->duolaSite->table_mytransferorder,$cancelData,array('id' => $order['id']));
        if($_GPC['sendMsg'] == 1){
            $this->duolaSite->sendMobileXsqxtz($this->schoolid,$_GPC ['orderId'],$this->weid,'transfer');
        }
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
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
        if(!in_array($order['orderStatus'],$this->CAN_CONFIRM_STATUS)){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '当前状态不能确认！'
            ));
        }
        if($this->openid == $order['openid']){
            $confirmData = array(
                'orderStatus' => 4
            );
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['outPrice'],
                'type'    => $_GPC['orderType'],
                'openid'  => $this->openid,
                'remark'  => '接受订单'
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);
        }else{
            $confirmData = array(
                'orderStatus' => 2
            );
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['inPrice'],
                'type'    => $_GPC['orderType'],
                'openid'  => $this->openid,
                'remark'  => '接受订单'
            );
            pdo_insert($this->duolaSite->table_booklog,$logData);
        }
        pdo_update($this->duolaSite->table_mytransferorder,$confirmData,array('id' => $order['id']));
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '确认成功！'
        ));
    }

    /**
     *下易书订单
     */
    public function order(){
        global $_GPC;
        if (! $_GPC ['schoolid'] || ! $_GPC ['bookIds']) {
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '非法请求！'
            ));
        }
        $bookIds = explode(',',trim($_GPC['bookIds'],','));
        if(!empty($_GPC['orderId'])){
            //回选订单
            $this->exchangeBook($bookIds);
        }else{
            //生产易书订单
            //检出图书状态是否可以借出
            foreach($bookIds as $bookId){
                $book = pdo_fetch("SELECT mybook.openid,mybook.status,book.* FROM " . tablename($this->duolaSite->table_mybook) . " as mybook left Join ".tablename($this->duolaSite->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :bookid = mybook.bookid And mybook.openid = :openid", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1,':bookid' => $bookId,':openid' =>  $_GPC['bookownerid']));
                if($book['status'] != 2){
                    $this->formatJsonData(array (
                        'result' => false,
                        'msg' => '抱歉,您所借的['.$book['title'].'],对方已下架！'
                    ));
                }
                //验证订单状态
                $bookOrder = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->duolaSite->table_mytransferorder) . " where find_in_set({$bookId},inBookIds) and orderStatus in(".self::UN_COMPLETE_TRANSFER_STATUS.")");
                if($bookOrder['orderCount'] > 0){
                    $this->formatJsonData(array (
                        'result' => false,
                        'msg' => '您的手速慢了哦,所借的['.$book['title'].'],已被他人交换！'
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
                'weid'          => $_GPC['weid'],
                'schoolid'      => $_GPC['schoolid'],
                'openid'        => $_GPC['openid'],
                'inBookIds'     => trim($_GPC['bookIds'],','),
                'inPrice'       => $_GPC['price'],
                'partybopenid'  => $_GPC['bookownerid'],
                'outBookIds'    => '',
                'outPrice'      => '',
                'inDate'        => time()
            );
            $result = pdo_insert($this->duolaSite->table_mytransferorder,$data);
            if($result){
                $orderId = pdo_insertid();
                $logData = array(
                    'orderId' => $orderId,
                    'amount'  => $_GPC['price'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $this->openid,
                    'remark'  => '申请易书'
                );
                pdo_insert($this->duolaSite->table_booklog,$logData);
                //发送模板消息
                $this->duolaSite->sendMobileXsddtz($this->schoolid,$orderId,$this->weid,'transfer');
                //更新图书状态
                foreach($bookIds as $bookId){
                    pdo_update($this->duolaSite->table_mybook,array('status' => 3),array('bookid' => $bookId,'openid' => $_GPC['bookownerid']));
                }
                $this->formatJsonData(array (
                    'result' => true,
                    'msg' => '交换成功!'
                ));
            }
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
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
        if(in_array($order['orderStatus'],$this->CAN_NOT_CANCEL_STATUS)){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '当前状态,不能取消！'
            ));
        }
        $cancelData = array(
            'cancelOpenid' => $this->openid,
            'canceltime' => time()
        );
        if($order['orderStatus'] == 5){
            $cancelData['orderStatus'] = 4;
            $cancelData['inOk'] = 1;
        }elseif($order['orderStatus'] == 4){
            $cancelData['orderStatus'] = 3;
            $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
            if($books){
                $upbook = array(
                    'openid' => $order['openid']
                );
                foreach($books as $book){
                    pdo_update($this->duolaSite->table_mybook,$upbook,array('id' => $book['id']));
                }
            }
        }elseif($order['orderStatus'] == 3){
            $cancelData['orderStatus'] = 2;
            $cancelData['outOk'] = 1;
        }elseif($order['orderStatus'] == 2){
            $cancelData['orderStatus'] = 1;
            $cancelData['outDate'] = 0;
            $cancelData['outBookIds'] = '';
            $cancelData['outPrice'] = 0;
            $cancelData['cancelReasonId'] = $_GPC['cancelId'];
            $books = pdo_fetchall("SELECT * FROM " . tablename($this->duolaSite->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1), 'id');
            if($books){
                $upbook = array(
                    'status' => 2
                );
                foreach($books as $book){
                    pdo_update($this->duolaSite->table_mybook,$upbook,array('id' => $book['id']));
                }
            }
            //取消发送模板消息
            $this->duolaSite->sendMobileXsqxtz($this->schoolid,$_GPC ['orderId'],$this->weid,'transfer');
        }
        $logData = array(
            'orderId' => $order['id'],
            'amount'  => $order['outPrice']+$order['inPrice'],
            'type'    => $_GPC['orderType'],
            'openid'  => $this->openid,
            'remark'  => '状态还原'
        );
        pdo_insert($this->duolaSite->table_booklog,$logData);
        pdo_update($this->duolaSite->table_mytransferorder,$cancelData,array('id' => $order['id']));
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '取消成功！'
        ) );
    }

    /**
     *取消订单中某一本书
     */
    public function cancelBook(){
        global $_GPC;
        $this->checkSubmitData();
        $order = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
        if(($_GPC['action'] == 'in' && $order['inOk'] == 2) || ($_GPC['action'] == 'out' && $order['outOk'] == 2)){
            die ( json_encode ( array (
                'result' => false,
                'msg' => '已出库,不能取消！'
            ) ) );
        }
        if(!in_array($order['orderStatus'],$this->CAN_NOT_CANCEL_STATUS)){
            $this->formatJsonData(array (
                'result' => false,
                'msg' => '当前状态,不能取消！'
            ));
        }
        //图书状态还原
        pdo_update($this->duolaSite->table_mybook,array('status' => 2),array('id' => $_GPC['bookid']));

        //更新订单图书信息
        if($_GPC['action'] == 'in'){
            $bookIds = explode(',',$order['inBookIds']);
            if(count($bookIds) <= 1){
                //删除订单
                $cancelData = array(
                    'orderStatus' => 7,
                    'cancelOpenid' => $this->openid,
                    'canceltime' => time()
                );
                pdo_update($this->duolaSite->table_mytransferorder,$cancelData,array('id' => $order['id']));
            }else{
                $index = array_search($_GPC ['orderId'],$bookIds);
                unset($bookIds[$index]);
                $cancelData = array(
                    'inBookIds' => implode(',',$bookIds)
                );
                pdo_update($this->duolaSite->table_mytransferorder,$cancelData,array('id' => $order['id']));
            }
        }else{
            $bookIds = explode(',',$order['outBookIds']);
            $index = array_search($_GPC ['orderId'],$bookIds);
            unset($bookIds[$index]);
            $cancelData = array(
                'outBookIds' => implode(',',$bookIds)
            );
            pdo_update($this->duolaSite->table_mytransferorder,$cancelData,array('id' => $order['id']));
        }
       $this->formatJsonData(array (
           'result' => true,
           'msg' => '取消成功！'
       ));
    }

    private function exchangeBook($bookIds){
        global $_GPC;
        if(empty($_GPC['orderId'])){
            return;
        }
        //检查是否有订单
        $bookOrder = pdo_fetch("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where id = {$_GPC['orderId']}");
        //价差必须大于0
//        if($bookOrder['inPrice'] > $_GPC['price']){
//            $this->formatJsonData(array (
//                'result' => false,
//                'msg' => '为保证交易顺利完成,您选的额度需大于对方额度!'
//            ));
//        }
        //检出图书状态是否可以借出
        foreach($bookIds as $bookId){
            $book = pdo_fetch("SELECT mybook.openid,mybook.status,book.* FROM " . tablename($this->duolaSite->table_mybook) . " as mybook left Join ".tablename($this->duolaSite->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :bookid = mybook.bookid And mybook.openid = :openid", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1,':bookid' => $bookId,':openid' => $bookOrder['openid']));
            if($book['status'] != 2){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '抱歉,您所借的['.$book['title'].'],对方已下架！'
                ));
            }
            //验证订单状态
            $bookOrder1 = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->duolaSite->table_mytransferorder) . " where find_in_set({$bookId},outBookIds) and orderStatus in(".self::UN_COMPLETE_TRANSFER_STATUS.")");
            if($bookOrder1['orderCount'] > 0){
                $this->formatJsonData(array (
                    'result' => false,
                    'msg' => '您的手速慢了哦,所借的['.$book['title'].'],已被他人交换！'
                ));
            }
        }
        //更新订单
        $data = array(
            'outBookIds'     => trim($_GPC['bookIds'],','),
            'outPrice'       => $_GPC['price'],
            'orderStatus'    => 2,
            'outDate'        => time()
        );
        $result = pdo_update($this->duolaSite->table_mytransferorder,$data,array('id' => $bookOrder['id']));
        $logData = array(
            'orderId' => $bookOrder['id'],
            'amount'  => $_GPC['price'],
            'type'    => $_GPC['orderType'],
            'openid'  => $this->openid,
            'remark'  => '选书成功'
        );
        pdo_insert($this->duolaSite->table_booklog,$logData);
        //更新图书状态
        foreach($bookIds as $bookId){
            pdo_update($this->duolaSite->table_mybook,array('status' => 3),array('bookid' => $bookId,'openid' => $_GPC['bookownerid']));
        }
        //发送模板消息
        $this->duolaSite->sendMobileXsddtz($this->schoolid,$_GPC['orderId'],$this->weid,'transfer');
        $this->formatJsonData(array (
            'result' => true,
            'msg' => '交换成功!'
        ));
    }

    public function displayTransfer(){
        $bookOrder = pdo_fetchall("SELECT * FROM ".tablename($this->duolaSite->table_mytransferorder) . " where   (openid = '{$this->openid}' or partybopenid = '{$this->openid}') order by createDate desc ");
        $orderType = 'transfer';
        return $this->formatReturn($bookOrder,$orderType,null);
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
                $userAccount = $this->getBalance($item['openid']);
                $priceData = pdo_fetch("SELECT SUM(book.price) as price FROM " . tablename($this->duolaSite->table_mybook) . " as mybook left Join ".tablename($this->duolaSite->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :status = mybook.status And mybook.openid = :openid ", array(':weid' => $this->weid, ':schoolid' => $this->schoolid,':is_delete' => 1,':status' => 2,':openid' => $item['openid']));
                $users[$item['openid']] = array(
                    'userinfo' => unserialize($partyb['userinfo']),
                    'userImg'  => $mcInfo['avatar'],
                    'nickname' => $mcInfo['nickname'],
                    'account' => $userAccount,
                    'totalOnSalePrices' => $priceData['price']
                );
            }
            //判断当前用户是否订单发起人
            if ($item['openid'] == $this->openid) {
                $partybid = $item['partybopenid'];
            } else {
                $partybid = $item['openid'];
            }
            if ($item['orderStatus'] == 1) {
                $item['statusName'] = '首发订单待回选';
            } elseif ($item['orderStatus'] == 2) {
                $item['statusName'] = '回选生成待实物交接';
            } elseif ($item['orderStatus'] == 3) {
                $item['statusName'] = '回选出库待入库';
            } elseif ($item['orderStatus'] == 4) {
                $item['statusName'] = '回选完毕待首选出库';
            } elseif ($item['orderStatus'] == 5) {
                $item['statusName'] = '首选出库待入库';
            } elseif ($item['orderStatus'] == 6) {
                $item['statusName'] = '订单完成';
            } elseif ($item['orderStatus'] == 7) {
                $item['statusName'] = '订单已取消';
            }

            if(!empty($item['outDate'])){
                $item['outDate'] = date('Y-m-d H:i:s',$item['outDate']);
            }
            if(!empty($item['inDate'])){
                $item['createDate'] = date('Y-m-d H:i:s',$item['inDate']);
            }
            if(empty($users[$item['partybopenid']])){
                $partyb = pdo_fetch("SELECT * FROM " . tablename($this->duolaSite->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $this->weid, ':schoolid' => $this->schoolid, ':openid' => $item['partybopenid']), 'id');
                $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $this->weid));
                $partyAccount = $this->getBalance($item['partybopenid']);
                $users[$item['partybopenid']] = array(
                    'userinfo' => unserialize($partyb['userinfo']),
                    'userImg'  => $mcInfo['avatar'],
                    'nickname' => $mcInfo['nickname'],
                    'account'  => $partyAccount
                );

            }
            //获取两者之间的距离
            $kmDistance = $this->duolaSite->getDistance($users[$item['openid']]['userinfo']['lat'],$users[$item['openid']]['userinfo']['lng'],$users[$item['partybopenid']]['userinfo']['lat'],$users[$item['partybopenid']]['userinfo']['lng']);;
            $item['distance'] = $this->duolaSite->mToKm($kmDistance);

            //买家头像，用户名和基本信息
            $item['userinfo'] = $users[$item['openid']]['userinfo'];
            $item['userImg'] = $users[$item['openid']]['userImg'];
            $item['nickname'] = $users[$item['openid']]['nickname'];
            //卖家头像，用户名和基本信息
            $item['userinfo1'] = $users[$item['partybopenid']]['userinfo'];
            $item['userImg1'] = $users[$item['partybopenid']]['userImg'];
            $item['nickname1'] = $users[$item['partybopenid']]['nickname'];
            $item['partybid'] = $partybid;

            //获取差价
            if($item['inPrice'] > 0 && $item['outPrice'] > 0){
                $item['diff'] = $item['outPrice'] - $item['inPrice'];
            }else{
                $item['diff'] = 0;
            }
            //判断差额
            $max = $users[$item['partybopenid']]['account']['balance']+$item['inPrice'];
            $min = 0;
            if($users[$item['openid']]['account']['balance'] > 0){
                $item['priceSpan'] = '0~'.$max;
            }else{
                $item['priceSpan'] = abs($users[$item['openid']]['account']['realBalance']).'~'.$max;
                $min = abs($users[$item['openid']]['account']['realBalance']);
            }
            $item['min'] = $min;
            $item['firstOneOnSalePrice'] = $users[$item['openid']]['totalOnSalePrices'];
            $orders[] = $item;
        }
        return $orders;
    }

}