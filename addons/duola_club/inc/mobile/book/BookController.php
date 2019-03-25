<?php

/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2017/2/5
 * Time: 下午2:58
 */
abstract class BookController
{
    protected $schoolid;
    protected $openid;
    protected $weid;
    protected $duolaSite;
    protected $school;
    protected $user;
    protected $userInfo;
    protected $companyLogo;
    protected $bookLogo;
    const UN_COMPLETE_STATUS = '1,2,3';
    const UN_COMPLETE_TRANSFER_STATUS = '1,2,3,4,5';

    /**
     * BookController constructor.
     * @param $schoolid
     * @param $openid
     * @param $weid
     */
    protected function __construct($schoolid, $openid, $weid)
    {
        $this->duolaSite = new Duola_clubModuleSite();
        $this->openid = $openid;
        $this->schoolid = $schoolid;
        $this->weid = $weid;
        $this->school = pdo_fetch("SELECT title,is_showew,is_showad FROM " . tablename($this->duolaSite->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
        $this->user   = pdo_fetch("SELECT * FROM " . tablename($this->duolaSite->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid), 'id');
        if(!empty($this->user)){
            $this->userInfo = unserialize($this->user['userinfo']);
        }
        global $_W;
        $this->bookLogo    = $_W['siteroot'].'attachment/images/9/2017/01/logo_6.png';
        $this->companyLogo = $_W['siteroot'].'attachment/images/9/2017/01/logo_5.png';
    }

    /**
     * @return array
     */
    protected function getCancelReason(){
        $cancelReasons = pdo_fetchall("SELECT * FROM ".tablename($this->duolaSite->table_bookmargin) . " where  type = 'book_cancel' order by id desc");
        return $cancelReasons;
    }
    /**
     * 获取待出库、入库、易书数量
     * @return array
     */
    protected function getAmount(){
        //待出库数量
        $bookOrderOut = pdo_fetch("SELECT count(id) as cnt FROM ".tablename($this->duolaSite->table_myorder) . " where  orderStatus in(".self::UN_COMPLETE_STATUS.") and bookownerid = '{$this->openid}'");
        $borrowOutCount = $bookOrderOut['cnt'];
        //待入库数量
        $bookOrderIn = pdo_fetch("SELECT count(id) as cnt FROM ".tablename($this->duolaSite->table_myorder) . " where  orderStatus in(".self::UN_COMPLETE_STATUS.") and openid = '{$this->openid}'");
        $borrowInCount = $bookOrderIn['cnt'];
        //易书订单
        $transferCnt = pdo_fetch("SELECT count(id) as cnt FROM ".tablename($this->duolaSite->table_mytransferorder) . " where  orderStatus in(".self::UN_COMPLETE_TRANSFER_STATUS.") and (openid = '{$this->openid}' or partybopenid = '{$this->openid}')");
        $transferCount = $transferCnt['cnt'];
        return array('borrowOutCount' => $borrowOutCount,'borrowInCount' => $borrowInCount,'transferCount' => $transferCount);
    }

    /**
     * 验证数据是否正确
     */
    protected function checkSubmitData(){
        global $_GPC;
        if (! $_GPC ['schoolid'] || ! $_GPC ['orderId']) {
            $this->formatJsonData(array('result' => false, 'msg' => '非法请求！'));
        }
    }

    /**
     * @param array $return
     */
    protected function formatJsonData(array $return){
        die(json_encode($return));
    }
    /**
     * 获取额度
     * @return array
     */
    protected function getBalance($openid = null){
        //查询闲书额度
        if($openid == null){
            $openId = $this->openid;
        }else{
            $openId = $openid;
        }
        $userAccount = pdo_fetch("SELECT * FROM " . tablename($this->duolaSite->table_bookaccount) . " where openid = :openid", array(':openid' => $openId));
        $balance = $userAccount['balance'];
        //未处理的订单会影响额度
        $orders = pdo_fetch("SELECT sum(price) as orderPrice FROM " . tablename($this->duolaSite->table_myorder) . " where openid = :openid and orderStatus in (".self::UN_COMPLETE_STATUS.")", array(':openid' => $openId));
        if($orders['orderPrice']){
            $balance -= $orders['orderPrice'];
        }
        $trans_orders = pdo_fetchall("SELECT inPrice,outPrice,openid,partybopenid FROM " . tablename($this->duolaSite->table_mytransferorder) . " where  orderStatus in (".self::UN_COMPLETE_TRANSFER_STATUS.") And (openid = '{$openId}' or partybopenid = '{$openId}')");
        $orderPrice = 0;
        if(count($trans_orders) > 0){
            foreach ($trans_orders as $trans_order){
                if($openId == $trans_order['openid'] && $trans_order['inPrice'] > 0){
                    $orderPrice += $trans_order['inPrice'];
                }
                if($openId == $trans_order['partybopenid'] && $trans_order['outPrice'] > 0){
                    //处理回选订单
                    if($trans_order['outPrice'] > $trans_order['inPrice']){
                        $orderPrice += ($trans_order['outPrice']-$trans_order['inPrice']);
                    }
                }
            }
            $balance -= $orderPrice;
        }
        $realBalance = $balance;
        if($balance < 0){
            $balance = 0;
        }
        return array('userAccount' => $userAccount,'balance' => $balance,'realBalance' => $realBalance);
    }

    abstract function formatData($data);

    protected function formatReturn($bookOrder,$orderType,$action = null){
        $balance = $this->getBalance();
        $account = $this->getAmount();
        $cancelReason = $this->getCancelReason();
        return array(
            'order'          => $this->formatData($bookOrder),
            'orderType'      => $orderType,
            'action'         => $action,
            'userAccount'    => $balance['userAccount'],
            'balance'        => $balance['balance'],
            'borrowInCount'  => $account['borrowInCount'],
            'borrowOutCount' => $account['borrowOutCount'],
            'transferCount'  => $account['transferCount'],
            'schoolid'       => $this->schoolid,
            'weid'           => $this->weid,
            'openid'         => $this->openid,
            'school'         => $this->school,
            'user'           => $this->user,
            'userInfo'       => $this->userInfo,
            'cancelReason'  => $cancelReason
        );
    }
    protected function commonReturn($data){

        return $data;
    }

    protected function getUserInfo($openid){
        if(!empty($openid)){
            $user = pdo_fetch("SELECT uid,userinfo FROM " . tablename($this->duolaSite->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And (sid > 0 Or tid > 0 Or pid > 0) order by createtime", array(':weid' => $this->weid, ':schoolid' => $this->schoolid, ':openid' => $openid), 'id');
            $mcInfo = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $user['uid'], ':uniacid' => $this->weid));
            $userInfo = unserialize($user['userinfo']);
            $book_user = pdo_fetch("SELECT name,mobile,area_addr,userAttribute FROM " . tablename($this->duolaSite->table_parents) . " where :schoolid = schoolid And :weid = weid And :openid = openid ", array(':weid' => $this->weid, ':schoolid' => $this->schoolid, ':openid' => $openid), 'id');
            return array(
                'user'     => $user,
                'userInfo' => $userInfo,
                'mcInfo'   => $mcInfo,
                'book_user' => $book_user
            );
        }
    }

    protected function curlRequest($url){
        $ch = curl_init();
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.2) Gecko/2008070208 Firefox/3.0.1';
        curl_setopt_array($ch,array(
            CURLOPT_URL            => $url,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_USERAGENT      => $userAgent,
            CURLOPT_RETURNTRANSFER => 1
        ));
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data,true);
    }
}