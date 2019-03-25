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
$userinfo = unserialize($user['userinfo']);
$op     = $_GPC['op'] ? $_GPC['op'] : 'borrow_in';
//if(!empty($user)){
    if($op == 'jiesuan'){
        if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        $bookIds = explode(',',trim($_GPC['bookIds'],','));
        //判断是借书还是易书
        $is_accept_exchange = $_GPC['is_accept_exchange'];
        if($is_accept_exchange == 1){
            //检查对方额度是否到达上限
            $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $_GPC['bookownerid']));
            $margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin). " where type = 'book_max'");
            $balance = $userAccount['balance'] + $_GPC['price'];
            $maxAmount = $margin['amount'] +$userAccount['cz_amount']+$userAccount['jy_amount']+$userAccount['couponAmount'];
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
            foreach($bookIds as $bookId){
                $book = pdo_fetch("SELECT mybook.openid,mybook.status,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :bookid = mybook.bookid", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':bookid' => $bookId));
                if($book['status'] != 2){
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '抱歉,您所借的['.$book['title'].'],对方已下架！'
                    ) ) );
                }
                //验证订单状态
                $bookOrder = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->table_myorder) . " where find_in_set({$bookId},bookIds) and orderStatus in(1,2)");
                if($bookOrder['orderCount'] > 0){
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '您的手速慢了哦,所借的['.$book['title'].'],已被他人借走！'
                    ) ) );
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
            $result = pdo_insert($this->table_myorder,$data);
            if($result){
                //添加日志
                $orderId = pdo_insertid();
                $logData = array(
                    'orderId' => $orderId,
                    'amount'  => $_GPC['price'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $openid,
                    'remark'  => '借书'
                );
                pdo_insert($this->table_booklog,$logData);
                //更新图书状态
                foreach($bookIds as $bookId){
                    pdo_update($this->table_mybook,array('status' => 3),array('bookid' => $bookId,'openid' => $_GPC['bookownerid']));
                }
                //发送模板消息
                $this->sendMobileXsddtz($schoolid,$orderId,$weid,'borrow','out');
                die ( json_encode ( array (
                    'result' => true,
                    'msg' => '借书成功!'
                ) ) );
            }else{
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '借书失败!'
                ) ) );
            }
        }else{
            //检查是否有订单
//            $bookOrder = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->table_mytransferorder) . " where openid = '{$openid}' and orderStatus in(1,2,3,4,5)");
//            if($bookOrder['orderCount'] > 0){
//                die ( json_encode ( array (
//                    'result' => false,
//                    'msg' => '您有易书订单未处理,请去订单中心处理!'
//                ) ) );
//            }
            if($_GPC['orderType'] == 'transfer' && !empty($_GPC['orderId'])){
                //检查是否有订单
                $bookOrder = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where id = {$_GPC['orderId']}");
                //价差必须大于0
                if($bookOrder['inPrice'] > $_GPC['price']){
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '为保证交易顺利完成,您选的额度需大于对方额度!'
                    ) ) );
                }
                //检出图书状态是否可以借出
                foreach($bookIds as $bookId){
                    $book = pdo_fetch("SELECT mybook.openid,mybook.status,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :bookid = mybook.bookid", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':bookid' => $bookId));
                    if($book['status'] != 2){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '抱歉,您所借的['.$book['title'].'],对方已下架！'
                        ) ) );
                    }
                    //验证订单状态
                    $bookOrder1 = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->table_mytransferorder) . " where find_in_set({$bookId},outBookIds) and orderStatus in(1,2,3,4,5)");
                    if($bookOrder1['orderCount'] > 0){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '您的手速慢了哦,所借的['.$book['title'].'],已被他人交换！'
                        ) ) );
                    }
                }
                //更新订单
                $data = array(
                    'outBookIds'     => trim($_GPC['bookIds'],','),
                    'outPrice'       => $_GPC['price'],
                    'orderStatus'    => 2,
                    'outDate'        => time()
                );
                $result = pdo_update($this->table_mytransferorder,$data,array('id' => $bookOrder['id']));
                $logData = array(
                    'orderId' => $bookOrder['id'],
                    'amount'  => $_GPC['price'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $openid,
                    'remark'  => '选书成功'
                );
                pdo_insert($this->table_booklog,$logData);
                //更新图书状态
                foreach($bookIds as $bookId){
                    pdo_update($this->table_mybook,array('status' => 3),array('bookid' => $bookId,'openid' => $_GPC['bookownerid']));
                }
                //发送模板消息
                $this->sendMobileXsddtz($schoolid,$_GPC['orderId'],$weid,'transfer');
                die ( json_encode ( array (
                    'result' => true,
                    'msg' => '交换成功!'
                ) ) );
            }else{
               //检出图书状态是否可以借出
               foreach($bookIds as $bookId){
                   $book = pdo_fetch("SELECT mybook.openid,mybook.status,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :bookid = mybook.bookid", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':bookid' => $bookId));
                   if($book['status'] != 2){
                       die ( json_encode ( array (
                           'result' => false,
                           'msg' => '抱歉,您所借的['.$book['title'].'],对方已下架！'
                       ) ) );
                   }
                   //验证订单状态
                   $bookOrder = pdo_fetch("SELECT count(id) as orderCount FROM ".tablename($this->table_mytransferorder) . " where find_in_set({$bookId},inBookIds) and orderStatus in(1,2,3,4,5)");
                   if($bookOrder['orderCount'] > 0){
                       die ( json_encode ( array (
                           'result' => false,
                           'msg' => '您的手速慢了哦,所借的['.$book['title'].'],已被他人交换！'
                       ) ) );
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
                $result = pdo_insert($this->table_mytransferorder,$data);
               if($result){
                   $orderId = pdo_insertid();
                   $logData = array(
                       'orderId' => $orderId,
                       'amount'  => $_GPC['price'],
                       'type'    => $_GPC['orderType'],
                       'openid'  => $openid,
                       'remark'  => '申请易书'
                   );
                   pdo_insert($this->table_booklog,$logData);
                   //发送模板消息
                   $this->sendMobileXsddtz($schoolid,$orderId,$weid,'transfer');
                   //更新图书状态
                   foreach($bookIds as $bookId){
                       pdo_update($this->table_mybook,array('status' => 3),array('bookid' => $bookId,'openid' => $_GPC['bookownerid']));
                   }
                   die ( json_encode ( array (
                       'result' => true,
                       'msg' => '交换成功!'
                   ) ) );
               }else{
                   die ( json_encode ( array (
                       'result' => false,
                       'msg' => '交换失败!'
                   ) ) );
               }
            }
        }
    }elseif($op == 'ruku'){
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        //入库操作
        //更新图书属性
        if($_GPC['orderType'] == 'borrow'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where  id = '{$_GPC['orderId']}'");
            if($order['orderStatus'] == 4){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '您已入库,不可重复操作！'
                ) ) );
            }
            if(!empty($order)){
                //查询额度,确定是否可以交易
                $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
                $balance = $userAccount['balance'] - $order['price'];
                if($balance < 0){
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '您的可用余额不足,不可以入库！'
                    ) ) );
                }
                pdo_update($this->table_bookaccount,array('balance' => $balance),array('openid' => $userAccount['openid']));
                //对方额度信息
                $userAccount1 = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $order['bookownerid']));
                $balance1 = $userAccount1['balance'] + $order['price'];
                pdo_update($this->table_bookaccount,array('balance' => $balance1),array('openid' => $userAccount1['openid']));
                //订单状态更新为已完成
                pdo_update($this->table_myorder,array('orderStatus' => 4),array('id' => $order['id']));
                //额度变动明细
                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $order['price'],
                    'type'    => $_GPC['orderType'].'_sub',
                    'openid'  => $order['openid'],
                    'remark'  => '闲书入库消费'
                );
                pdo_insert($this->table_booklog,$logData);

                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $order['price'],
                    'type'    => $_GPC['orderType'].'_add',
                    'openid'  => $order['bookownerid'],
                    'remark'  => '闲书出库增额'
                );
                pdo_insert($this->table_booklog,$logData);
                //模板消息通知
                $msgBody = array(
                    'schoolid'   => $schoolid,
                    'weid'       => $weid,
                    'orderId'    => $_GPC ['orderId'],
                    'orderType'  => $_GPC['orderType'],
                    'amountData' => array(
                        $order['openid'] => array(
                            'preAmount'   => $userAccount['balance'],
                            'afterAmount' => $balance,
                            'action'      => 'in'
                        ),
                        $order['bookownerid'] => array(
                            'preAmount'   => $userAccount1['balance'],
                            'afterAmount' => $balance1,
                            'action'      => 'out'
                        ),
                    )
                );
                $this->sendMobileXsedbdtz($msgBody);
                //查询我的图书
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
            }
        }elseif($_GPC['orderType'] == 'transfer'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
            if($openid == $order['openid']){
                //首发订单入库,交易完成
                if($order['orderStatus'] != 5){
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '当前状态不能入库！'
                    ) ) );
                }
                if(!empty($order)){
                    //查询我的图书
                    $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['inBookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                }
                if($order['orderStatus'] == 5){
                    $diff = $order['outPrice'] - $order['inPrice'];
                    $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $order['openid']));
                    $balance = $userAccount['balance'] + $diff;
                    //对方额度信息
                    $userAccount1 = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $order['partybopenid']));
                    $balance1 = $userAccount1['balance'] - $diff;
                    if($balance1 < 0){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '无法入库,对方的余额不足！'
                        ) ) );
                    }
                    pdo_update($this->table_bookaccount,array('balance' => $balance),array('openid' => $userAccount['openid']));
                    pdo_update($this->table_bookaccount,array('balance' => $balance1),array('openid' => $userAccount1['openid']));
                    pdo_update($this->table_mytransferorder,array('orderStatus' => 6),array('id' => $order['id']));

                    $msgBody = array(
                        'schoolid'   => $schoolid,
                        'weid'       => $weid,
                        'orderId'    => $_GPC ['orderId'],
                        'orderType'  => $_GPC['orderType'],
                        'amountData' => array(
                            $order['openid'] => array(
                                'preAmount'   => $userAccount['balance'],
                                'afterAmount' => $balance
                            ),
                            $order['partybopenid'] => array(
                                'preAmount'   => $userAccount1['balance'],
                                'afterAmount' => $balance1
                            ),
                        )
                    );
                    $this->sendMobileXsedbdtz($msgBody);
                }
                //额度变动明细
                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $diff,
                    'type'    => $_GPC['orderType'].'_add',
                    'openid'  => $order['openid'],
                    'remark'  => '首发订单入库增额'
                );
                pdo_insert($this->table_booklog,$logData);

                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $diff,
                    'type'    => $_GPC['orderType'].'_sub',
                    'openid'  => $order['partybopenid'],
                    'remark'  => '回选订单出库减额'
                );
                pdo_insert($this->table_booklog,$logData);
            }else{
                if($order['orderStatus'] != 3){
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '当前状态您还不能入库！'
                    ) ) );
                }
                if(!empty($order)){
                    //查询我的图书
                    $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                }

                if($order['orderStatus'] == 3){
                    //更新额度
                    $diff = $order['outPrice'] - $order['inPrice'];
                    if($diff < 0){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '无法入库,您的易书金额小于对方易书金额！'
                        ) ) );
                    }

                    //更新订单状态
                    pdo_update($this->table_mytransferorder,array('orderStatus' => 4),array('id' => $order['id']));
                }else{
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '订单状态有误,您还不能入库！'
                    ) ) );
                }
                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $order['outPrice'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $openid,
                    'remark'  => '回选订单入库'
                );
                pdo_insert($this->table_booklog,$logData);
            }
        }else{
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        if(empty($books)){
            die ( json_encode ( array (
                'result' => false,
                'msg' => '订单有误！'
            ) ) );
        }

        $updata = array(
            'openid' => $openid,
            'status' => 1,
            'lng'    => $userinfo['lng'],
            'lat'    => $userinfo['lat']
        );
        foreach($books as $book){
            pdo_update($this->table_mybook,$updata,array('id' => $book['id']));
        }
        die ( json_encode ( array (
            'result' => true,
            'msg' => '入库成功！'
        ) ) );
    }elseif($op == 'chuku'){
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        //查询额度
//        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
//        if($_GPC['orderType'] == 'borrow'){
//            $balance = $userAccount['balance'] + $order['price'];
//        }
        //出库操作
        //更新图书属性
        if($_GPC['orderType'] == 'borrow'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where  id = '{$_GPC['orderId']}'");
            if($order['isOk'] == 2){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '您已出库,不可重复操作！'
                ) ) );
            }
            if(!empty($order)){
                //查询我的图书
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                if(empty($books)){
                    die ( json_encode ( array (
                        'result' => false,
                        'msg' => '订单有误！'
                    ) ) );
                }
            }
            //订单状态更新为已完成
            pdo_update($this->table_myorder,array('isOk' => 2,'orderStatus' => 3),array('id' => $order['id']));
            $updata = array(
                'openid' => $order['openid']
            );
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['price'],
                'type'    => $_GPC['orderType'],
                'openid'  => $openid,
                'remark'  => '出库'
            );
            pdo_insert($this->table_booklog,$logData);
            foreach($books as $book){
                pdo_update($this->table_mybook,$updata,array('id' => $book['id']));
            }
        }elseif($_GPC['orderType'] == 'transfer'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
            if(!empty($order)){
                //更新订单状态
                if($order['openid'] == $openid){
                    //回选订单
                    if(empty($order['outBookIds'])){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '订单有误！'
                        ) ) );
                    }
                    if($order['orderStatus'] == 3){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '您已出库,不能重复出库！'
                        ) ) );
                    }
                    //查询我的图书
                    $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                    if(empty($books)){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '订单有误！'
                        ) ) );
                    }
                    pdo_update($this->table_mytransferorder,array('outOk' => 2,'orderStatus' => 3),array('id' => $order['id']));
                    $updata = array(
                        'openid' => $order['partybopenid']
                    );
                    $logData = array(
                        'orderId' => $order['id'],
                        'amount'  => $order['outPrice'],
                        'type'    => $_GPC['orderType'],
                        'openid'  => $openid,
                        'remark'  => '回选订单出库'
                    );
                    pdo_insert($this->table_booklog,$logData);
                    foreach($books as $book){
                        pdo_update($this->table_mybook,$updata,array('id' => $book['id']));
                    }
                }else{
                    if(empty($order['inBookIds'])){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '订单有误！'
                        ) ) );
                    }
                    //查询我的图书
                    $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['inBookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                    if(empty($books)){
                        die ( json_encode ( array (
                            'result' => false,
                            'msg' => '订单有误！'
                        ) ) );
                    }
                    pdo_update($this->table_mytransferorder,array('inOk' => 2,'orderStatus' => 5),array('id' => $order['id']));
                    $updata = array(
                        'openid' => $openid
                    );
                    $logData = array(
                        'orderId' => $order['id'],
                        'amount'  => $order['inPrice'],
                        'type'    => $_GPC['orderType'],
                        'openid'  => $openid,
                        'remark'  => '首发订单出库'
                    );
                    pdo_insert($this->table_booklog,$logData);
                    foreach($books as $book){
                        pdo_update($this->table_mybook,$updata,array('id' => $book['id']));
                    }
                }
            }
        }else{
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        die ( json_encode ( array (
            'result' => true,
            'msg' => '出库成功！'
        ) ) );
    }elseif($op == 'cancel'){
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        //取消操作
        //更新图书属性
        if($_GPC['orderType'] == 'borrow'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where  id = '{$_GPC['orderId']}'");
            if($order['isOk'] == 2){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '已出库,不能取消！'
                ) ) );
            }
            if($order['orderStatus'] == 3 || $order['orderStatus'] == 4){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态,不能取消！'
                ) ) );
            }
            if(!empty($order)){
                //查询我的图书
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
            }
            if($books){
                $upbook = array(
                    'status' => 2
                );
                foreach($books as $book){
                    pdo_update($this->table_mybook,$upbook,array('id' => $book['id']));
                }
            }
            //订单状态更新为已完成
            $cancelData = array(
                'orderStatus' => 5,
                'cancelOpenid' => $openid,
                'canceltime' => time()
            );
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['price'],
                'type'    => $_GPC['orderType'],
                'openid'  => $openid,
                'remark'  => '取消'
            );
            pdo_insert($this->table_booklog,$logData);
            pdo_update($this->table_myorder,$cancelData,array('id' => $order['id']));
        }elseif($_GPC['orderType'] == 'transfer'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
            if($order['orderStatus'] != 1){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态,不能取消！'
                ) ) );
            }
            if(!empty($order['outBookIds'])){
                $bookIds = array_merge(explode(',',$order['outBookIds']), explode(',',$order['inBookIds']));
            }else{
                $bookIds = explode(',',$order['inBookIds']);
            }
            //查询我的图书
            $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in (".implode(',',$bookIds).")", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
            if($books){
                $upbook = array(
                    'status' => 2
                );
                foreach($books as $book){
                    pdo_update($this->table_mybook,$upbook,array('id' => $book['id']));
                }
            }
            $cancelData = array(
                'orderStatus' => 7,
                'cancelOpenid' => $openid,
                'canceltime' => time()
            );
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['outPrice']+$order['inPrice'],
                'type'    => $_GPC['orderType'],
                'openid'  => $openid,
                'remark'  => '取消'
            );
            pdo_insert($this->table_booklog,$logData);
            pdo_update($this->table_mytransferorder,$cancelData,array('id' => $order['id']));
            if($_GPC['sendMsg'] == 1){
                $this->sendMobileXsqxtz($schoolid,$_GPC ['orderId'],$weid,'transfer');
            }
        }else{
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        die ( json_encode ( array (
            'result' => true,
            'msg' => '取消成功！'
        ) ) );

    }elseif($op == 'updateStatus'){
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId'] || ! $_GPC ['orderStatus']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        //状态还原操作
        if($_GPC['orderType'] == 'transfer'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
            if(in_array($order['orderStatus'],array(1,6,7))){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态,不能取消！'
                ) ) );
            }
            $cancelData = array(
                'cancelOpenid' => $openid,
                'canceltime' => time()
            );
            if($order['orderStatus'] == 5){
                $cancelData['orderStatus'] = 4;
                $cancelData['inOk'] = 1;
            }elseif($order['orderStatus'] == 4){
                $cancelData['orderStatus'] = 3;
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                if($books){
                    $upbook = array(
                        'openid' => $order['openid']
                    );
                    foreach($books as $book){
                        pdo_update($this->table_mybook,$upbook,array('id' => $book['id']));
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
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['outBookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                if($books){
                    $upbook = array(
                        'status' => 2
                    );
                    foreach($books as $book){
                        pdo_update($this->table_mybook,$upbook,array('id' => $book['id']));
                    }
                }
                //取消发送模板消息
                $this->sendMobileXsqxtz($schoolid,$_GPC ['orderId'],$weid,'transfer');
            }
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['outPrice']+$order['inPrice'],
                'type'    => $_GPC['orderType'],
                'openid'  => $openid,
                'remark'  => '状态还原'
            );
            pdo_insert($this->table_booklog,$logData);
            pdo_update($this->table_mytransferorder,$cancelData,array('id' => $order['id']));
        }elseif($_GPC['orderType'] == 'borrow'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where  id = '{$_GPC['orderId']}'");
            if(in_array($order['orderStatus'],array(4,5))){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态,不能取消！'
                ) ) );
            }
            $cancelData = array(
                'cancelOpenid' => $openid,
                'canceltime' => time()
            );
            if($order['orderStatus'] == 3){
                $cancelData['orderStatus'] = 2;
                $cancelData['isOk'] = 1;
                $books = pdo_fetchall("SELECT * FROM " . tablename($this->table_mybook) . " where :schoolid = schoolid And :weid = weid  And :is_delete = is_delete And bookid in ({$order['bookIds']})", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1), 'id');
                foreach($books as $book){
                    pdo_update($this->table_mybook,array('openid' => $order['bookownerid']),array('id' => $book['id']));
                }
            }elseif($order['orderStatus'] == 2){
                $cancelData['orderStatus'] = 1;
            }elseif($order['orderStatus'] == 1){
                $cancelData['orderStatus'] = 5;
                //取消发送模板消息
                $this->sendMobileXsqxtz($schoolid,$_GPC ['orderId'],$weid,'borrow');
            }
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['outPrice']+$order['inPrice'],
                'type'    => $_GPC['orderType'],
                'openid'  => $openid,
                'remark'  => '状态还原'
            );
            pdo_insert($this->table_booklog,$logData);
            pdo_update($this->table_myorder,$cancelData,array('id' => $order['id']));
        }else{
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        die ( json_encode ( array (
            'result' => true,
            'msg' => '取消成功！'
        ) ) );

    }elseif($op == 'confirmOrder'){
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        //确认操作
        //更新图书属性
        if($_GPC['orderType'] == 'borrow'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where  id = '{$_GPC['orderId']}'");
            if($order['orderStatus'] != 1){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态不能确认！'
                ) ) );
            }
            //订单状态更新为可出库
            $confirmData = array(
                'orderStatus' => 2
            );
            $logData = array(
                'orderId' => $order['id'],
                'amount'  => $order['price'],
                'type'    => $_GPC['orderType'],
                'openid'  => $openid,
                'remark'  => '接受订单'
            );
            pdo_insert($this->table_booklog,$logData);
            pdo_update($this->table_myorder,$confirmData,array('id' => $order['id']));
            $this->sendMobileXsqdtz($schoolid,$_GPC ['orderId'],$weid,'borrow','in');
        }elseif($_GPC['orderType'] == 'transfer'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");
            if($order['orderStatus'] != 1 && $order['orderStatus'] != 3){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态不能确认！'
                ) ) );
            }
            if($openid == $order['openid']){
                $confirmData = array(
                    'orderStatus' => 4
                );
                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $order['outPrice'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $openid,
                    'remark'  => '接受订单'
                );
                pdo_insert($this->table_booklog,$logData);
            }else{
                $confirmData = array(
                    'orderStatus' => 2
                );
                $logData = array(
                    'orderId' => $order['id'],
                    'amount'  => $order['inPrice'],
                    'type'    => $_GPC['orderType'],
                    'openid'  => $openid,
                    'remark'  => '接受订单'
                );
                pdo_insert($this->table_booklog,$logData);
            }
            pdo_update($this->table_mytransferorder,$confirmData,array('id' => $order['id']));
        }else{
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        die ( json_encode ( array (
            'result' => true,
            'msg' => '确认成功！'
        ) ) );
    }elseif($op == 'cancelBook'){
        //取消订单中的某本书
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        //取消操作
        //更新图书属性
        if($_GPC['orderType'] == 'borrow'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_myorder) . " where  id = '{$_GPC['orderId']}'");
            if($order['isOk'] == 2){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '已出库,不能取消！'
                ) ) );
            }
            if($order['orderStatus'] == 3 || $order['orderStatus'] == 4){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态,不能取消！'
                ) ) );
            }
            $bookIds = explode(',',$order['bookIds']);
            //图书状态还原
            pdo_update($this->table_mybook,array('status' => 2),array('id' => $_GPC['bookid']));
            if(count($bookIds) <=1 ){
                //删除该笔订单
                $cancelData = array(
                    'orderStatus' => 4,
                    'cancelOpenid' => $openid,
                    'canceltime' => time()
                );
                pdo_update($this->table_myorder,$cancelData,array('id' => $order['id']));
            }else{
                //更新订单图书
                $index = array_search($_GPC ['orderId'],$bookIds);
                unset($bookIds[$index]);
                $cancelData = array(
                    'bookIds' => implode(',',$bookIds)
                );
                pdo_update($this->table_myorder,$cancelData,array('id' => $order['id']));
            }
        }elseif($_GPC['orderType'] == 'transfer'){
            $order = pdo_fetch("SELECT * FROM ".tablename($this->table_mytransferorder) . " where  id = '{$_GPC['orderId']}'");

            if(($_GPC['action'] == 'in' && $order['inOk'] == 2) || ($_GPC['action'] == 'out' && $order['outOk'] == 2)){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '已出库,不能取消！'
                ) ) );
            }
            if($order['orderStatus'] == 5 || $order['orderStatus'] == 6){
                die ( json_encode ( array (
                    'result' => false,
                    'msg' => '当前状态,不能取消！'
                ) ) );
            }
            //图书状态还原
            pdo_update($this->table_mybook,array('status' => 2),array('id' => $_GPC['bookid']));
            if(count($bookIds) <= 1){
                //删除订单
                $cancelData = array(
                    'orderStatus' => 6,
                    'cancelOpenid' => $openid,
                    'canceltime' => time()
                );
                pdo_update($this->table_mytransferorder,$cancelData,array('id' => $order['id']));
            }else{
                //更新订单图书信息
                if($_GPC['action'] == 'in'){
                    $bookIds = explode(',',$order['inBookIds']);
                    $index = array_search($_GPC ['orderId'],$bookIds);
                    unset($bookIds[$index]);
                    $cancelData = array(
                        'inBookIds' => implode(',',$bookIds)
                    );
                    pdo_update($this->table_mytransferorder,$cancelData,array('id' => $order['id']));
                }else{
                    $bookIds = explode(',',$order['outBookIds']);
                    $index = array_search($_GPC ['orderId'],$bookIds);
                    unset($bookIds[$index]);
                    $cancelData = array(
                        'outBookIds' => implode(',',$bookIds)
                    );
                    pdo_update($this->table_mytransferorder,$cancelData,array('id' => $order['id']));
                }
            }
        }else{
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        die ( json_encode ( array (
            'result' => true,
            'msg' => '取消成功！'
        ) ) );
    }else{
        //查询闲书额度
        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
        $balance = $userAccount['balance'];
        //未处理的订单会影响额度
        $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2)", array(':openid' => $openid));
        if($orders['orderPrice']){
            $balance -= $orders['orderPrice'];
        }
        switch($op){
            case 'borrow_out' :
                //我借书待出库订单
                $bookOrder = pdo_fetchall("SELECT * FROM ".tablename($this->table_myorder) . " where   bookownerid = '{$openid}' order by createDate desc");
                $orderType = 'borrow';
                $action    = 'out';
                break;
            case 'transfer' :
                //我的易书待入库订单
                $bookOrder = pdo_fetchall("SELECT * FROM ".tablename($this->table_mytransferorder) . " where   (openid = '{$openid}' or partybopenid = '{$openid}') order by createDate desc ");
                $orderType = 'transfer';
                break;
            case 'borrow_in' :
            default:
                //我借书待入库订单
                $bookOrder = pdo_fetchall("SELECT * FROM ".tablename($this->table_myorder) . " where   openid = '{$openid}' order by createDate desc");
                $orderType = 'borrow';
                $action    = 'in';
                break;

        }

        //查询所有订单待处理
        //待出库数量
        $bookOrderOut = pdo_fetch("SELECT count(id) as cnt FROM ".tablename($this->table_myorder) . " where  orderStatus in(1,2,3) and bookownerid = '{$openid}'");
        $borrowOutCount = $bookOrderOut['cnt'];
        //待入库数量
        $bookOrderIn = pdo_fetch("SELECT count(id) as cnt FROM ".tablename($this->table_myorder) . " where  orderStatus in(1,2,3) and openid = '{$openid}'");
        $borrowInCount = $bookOrderIn['cnt'];
        $transferCnt = pdo_fetch("SELECT count(id) as cnt FROM ".tablename($this->table_mytransferorder) . " where  orderStatus in(1,2,3,4,5) and (openid = '{$openid}' or partybopenid = '{$openid}')");
        $transferCount = $transferCnt['cnt'];
        //获取对方信息
        $orders = array();
        $users = array();
        foreach($bookOrder as $item){
            if(empty($users[$item['openid']])){
                $partyb = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $item['openid']), 'id');
                $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $weid));
                $users[$item['openid']] = array(
                    'userinfo' => unserialize($partyb['userinfo']),
                    'userImg'  => $mcInfo['avatar'],
                    'nickname' => $mcInfo['nickname'],
                );
            }
            if($orderType == 'borrow'){
                if($item['openid'] == $openid){
                    $partybid = $item['bookownerid'];
                }else{
                    $partybid = $item['openid'];
                }
                if(!empty($item['orderTime'])){
                    $item['createDate'] = date('Y-m-d H:i:s',$item['orderTime']);
                }
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
                if(empty($users[$item['bookownerid']])){
                    $partyb = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $item['bookownerid']), 'id');
                    $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $weid));
                    $users[$item['bookownerid']] = array(
                        'userinfo' => unserialize($partyb['userinfo']),
                        'userImg'  => $mcInfo['avatar'],
                        'nickname' => $mcInfo['nickname'],
                    );
                }
                $kmDistance = $this->getDistance($users[$item['openid']]['userinfo']['lat'],$users[$item['openid']]['userinfo']['lng'],$users[$item['bookownerid']]['userinfo']['lat'],$users[$item['bookownerid']]['userinfo']['lng']);;
                $item['distance'] = $this->mToKm($kmDistance);

            }else {
                if ($item['openid'] == $openid) {
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
                    $partyb = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $item['partybopenid']), 'id');
                    $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $partyb['uid'], ':uniacid' => $weid));
                    $users[$item['partybopenid']] = array(
                        'userinfo' => unserialize($partyb['userinfo']),
                        'userImg'  => $mcInfo['avatar'],
                        'nickname' => $mcInfo['nickname'],
                    );
                }
                $kmDistance = $this->getDistance($users[$item['openid']]['userinfo']['lat'],$users[$item['openid']]['userinfo']['lng'],$users[$item['partybopenid']]['userinfo']['lat'],$users[$item['partybopenid']]['userinfo']['lng']);;
                $item['distance'] = $this->mToKm($kmDistance);
            }
            $item['userinfo'] = $users[$item['openid']]['userinfo'];
            $item['userImg'] = $users[$item['openid']]['userImg'];
            $item['nickname'] = $users[$item['openid']]['nickname'];
            if($orderType == 'borrow'){
                $item['userinfo1'] = $users[$item['bookownerid']]['userinfo'];
                $item['userImg1'] = $users[$item['bookownerid']]['userImg'];
                $item['nickname1'] = $users[$item['bookownerid']]['nickname'];
            }else{
                $item['userinfo1'] = $users[$item['partybopenid']]['userinfo'];
                $item['userImg1'] = $users[$item['partybopenid']]['userImg'];
                $item['nickname1'] = $users[$item['partybopenid']]['nickname'];
            }
            $item['partybid'] = $partybid;
            if($item['inPrice'] > 0 && $item['outPrice'] > 0){
                $item['diff'] = $item['outPrice'] - $item['inPrice'];
            }else{
                $item['diff'] = 0;
            }
            $orders[] = $item;
        }
        $this->checkBookAccount($openid,$schoolid,$weid);
        if($op == 'transfer'){
            include $this->template('book/mytransferorder');
        }else{
            include $this->template('book/mybookorder');
        }
    }
//}else{
//    $userType = 'bookUser';
//    include $this->template('bangding');
//}
?>