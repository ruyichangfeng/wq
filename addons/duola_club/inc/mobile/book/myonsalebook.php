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

$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
$user   = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
$myOnSale = $_GPC['onSaleAmount'] ? $_GPC['onSaleAmount'] : 0;
$myBalance = $_GPC['balance'] ? $_GPC['balance'] : 0;
$userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
if(!empty($user)){
    $op = $_GPC['op'] ? $_GPC['op'] : 'display';
    if($op == 'unsale'){
        //下架图书
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
                'msg' => '下架失败！'
            ) ) );
        }
        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->table_bookaccount) . " where openid = :openid", array(':openid' => $openid));
        $margin = pdo_fetch("SELECT * FROM " . tablename($this->table_bookmargin). " where type = 'book_min'");
        $onSaleAmount = $userAccount['onSaleAmount'] - $bookData['price'];
        if(!empty($margin) && $onSaleAmount < $margin['amount'] && $userAccount['couponAmount'] > 0){
            die(
            json_encode(array(
                'result' => false,
                'msg'    => '不能低于最低金额'.$margin['amount'].'元!'
            ))
            );
        }
        pdo_update($this->table_mybook,array('status' => 1),array('id' => $_GPC['id']));
        //更新账户余额
        $amountData = array(
            'onSaleAmount' => $onSaleAmount,
        );
        pdo_update($this->table_bookaccount,$amountData,array('openid' => $userAccount['openid']));
        die(
            json_encode(array(
                'result' => true,
                'msg'    => '下架成功!'
            ))
        );
    }else{
        $balance = $userAccount['balance'];
        $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->table_myorder) . " where openid = :openid and orderStatus in (1,2,3)", array(':openid' => $openid));
        if($orders['orderPrice']){
            $balance -= $orders['orderPrice'];
        }
        $status = $_GPC['status'] ? $_GPC['status'] : 2;
        $item = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $user['uid'], ':uniacid' => $weid));
        $onsalebooks = pdo_fetchall("SELECT mybook.openid,mybook.id as mybookid,book.* FROM " . tablename($this->table_mybook) . " as mybook left Join ".tablename($this->table_book)." as book on  mybook.bookid = book.id where :schoolid = mybook.schoolid And :weid = mybook.weid  And :is_delete = mybook.is_delete And :status = mybook.status  And :openid = mybook.openid $condition order by mybook.createDate desc", array(':weid' => $weid, ':schoolid' => $schoolid,':is_delete' => 1,':status' => $status,':openid' => $openid), 'id');
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
        foreach ($onsalebooks as $bk){
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
        include $this->template('book/myonsalebook');
    }
}else{
    include $this->template('bangding');
}
?>