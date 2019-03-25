<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
global $_W, $_GPC;
$weid = $_W['uniacid'];
$schoolid = intval($_GPC['schoolid']);
$openid = empty($_GPC['openid']) ? $_W['openid'] : $_GPC['openid'];
//查询是否用户登录
$myOnSale = $_GPC['onSaleAmount'] ? $_GPC['onSaleAmount'] : 0;
$myBalance = $_GPC['balance'] ? $_GPC['balance'] : 0;
$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
$userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
if(!empty($user)){
    $op = $_GPC['op'] ? $_GPC['op'] : 'display';
    if($op == 'onsale'){
        //上架图书
        if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        $bookData = pdo_fetch("SELECT mybook.openid,mybook.id as mybookid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :id = mybook.id", array(':id' => $_GPC['id']));
        if(empty($bookData)){
            die ( json_encode ( array (
                'result' => false,
                'msg' => '上架失败！'
            ) ) );
        }
        pdo_update($this->table_mybook,array('status' => 2),array('id' => $_GPC['id']));
        //更新我的账户
        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
        $newOnSaleAmount = $userAccount['onSaleAmount'] + $bookData['price'];
        $amountData = array(
            'onSaleAmount' => $newOnSaleAmount
        );
        //查询保证金数据
        $margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin) . " where type = 'book_margin'");
        if(!empty($margin) && $newOnSaleAmount > $margin['amount'] && $userAccount['couponAmount'] == 0){
            $amountData['balance'] = $margin['couponAmount']+$userAccount['balance'];
            $amountData['couponAmount'] = $margin['couponAmount'];
            //发送模板消息
            $msgBody = array(
                'schoolid'   => $schoolid,
                'weid'       => $weid,
                'orderId'    => '10000',
                'orderType'  => 'mz',
                'amountData' => array(
                        'preAmount'   => $userAccount['balance'],
                        'afterAmount' => $amountData['balance'],
                        'amount'      => $margin['couponAmount'],
                        'triggerValue'=> $margin['amount']
                )
            );
            $this->sendMobileXsedbdtz($msgBody);
            $logData = array(
                'orderId' => 10000,
                'amount'  => $margin['couponAmount'],
                'type'    => 'mz',
                'openid'  => $openid,
                'remark'  => '上架满'.$margin['amount'].'赠送'.$margin['couponAmount'].''
            );
            pdo_insert($this->table_booklog,$logData);
        }
        pdo_update($this->table_bookaccount,$amountData,array('openid' => $userAccount['openid']));
        die(
        json_encode(array(
            'result' => true,
            'msg'    => '上架成功!'
        ))
        );
    }elseif($op == 'delete'){
        //上架图书
        if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
            die ( json_encode ( array (
                'result' => false,
                'msg' => '非法请求！'
            ) ) );
        }
        pdo_update($this->table_mybook,array('is_delete' => 2),array('id' => $_GPC['id']));
        die(
        json_encode(array(
            'result' => true,
            'msg'    => '删除成功!'
        ))
        );
    }else{
        $balance = $userAccount['balance'];
        $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $openid));
        if($orders['orderPrice']){
            $balance -= $orders['orderPrice'];
        }
        $status = $_GPC['status'] ? $_GPC['status'] : 1;
        $item = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $user['uid'], ':uniacid' => $weid));
        $unsalebooks = pdo_fetchall("SELECT mybook.openid,mybook.id as mybookid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :status = mybook.status  And :openid = mybook.openid  $condition order by mybook.createDate desc", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':status' => $status,':openid' => $openid), 'id');
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
        $book_lb = $book_age =array();
        foreach($category as $key => $value){
            switch($value['type']){
                case 'book_lb':
                    $book_lb[$value['sid']] = $value;
                    break;
                case 'book_age':
                    $book_age[$value['sid']] = $value;
                    break;
                default:
                    break;
            }
        }
        //查询种类分布
        $bookCats = array();
        $cats     = array();
        foreach ($unsalebooks as $bk){
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
                $content .= $bc['age_name'].$bookCats[$bc['age_id']]['count'].'本'.' ';
            }
        }
        $links = $_W['siteroot'] .'app/'.$this->createMobileUrl('bookCenter',array('schoolid' => $schoolid,'openid' => $openid));
        $imgsUrl = $_W['siteroot'].'attachment/images/9/2017/01/logo_6.png';
        $content = trim($content,' ');
        $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $user['uid'], ':uniacid' => $weid));
        include $this->template('book/myunsalebook');
    }
}else{
    include $this->template('bangding');
}
?>