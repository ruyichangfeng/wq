<?php
/**
 * codeMonkey:2463619823
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT. '/addons/mon_xkwkj/core/defines.php';
require MON_XKWKJ_CORE. 'function/core.php';
/**
 * Class Mon_WkjModuleSite
 */
class Mon_XKWkjModuleSite extends Core {
	public $weid;
	public $acid;
	public $oauth;
	public static $USER_COOKIE_KEY = "__monkxwkj322332323223322";
    public static $GCODE = 1002;
	public static $KJ_STATUS_WKS = 0;//未开始
	public static $KJ_STATUS_ZC = 1;//正常
	public static $KJ_STATUS_JS = 2;//结束

	public static $KJ_STATUS_XD = 3;//已下单
	public static $KJ_STATUS_GM = 4;//已支付
	public static $KJ_STATUS_YFH = 5;//已发货


	public static $TIP_DIALOG = 1;//对话框
	public static $TIP_U_FIRST = 2;//首次
	public static $TIP_U_ALREADY = 3;//已经砍过了
	public static $TIP_RANK = 4;//页面
	public static $TIP_FK_FIRST = 5;//好友
	public static $TIP_FK_ALREADY = 6;//好友已看
	public static $PAGE_SIZE = 6;

	const PAY_TYPE_WX = 1;
	const PAY_ZT = 2; //自提，到店取货


	const LQ_TYPE_KD = 0; //快递
	const LQ_TYPE_ZT = 1; //自提
	const LQ_TYPE_ZX = 2; //自选

	const PPT_INDEX = 1;

	public $xkkjSetting;

	function __construct()
	{
		global $_W;
		$this->weid = $_W['uniacid'];
		$this->xkkjSetting = $this->findXKKJsetting();
		$this->oauth = new Oauth2($this->xkkjSetting['appid'], $this->xkkjSetting['appsecret']);
	}

	public function __web($f_name){
		global $_GPC, $_W;
		include_once  'core/web/'.strtolower(substr($f_name,5)).'.php';
	}


	public function __mobile($f_name) {
		global $_W, $_GPC;
		MonUtil::checkmobile();

		if (MonUtil::$DEBUG) {
			$fansInfo = $this->getClientUserInfo();
		} else {
			if (empty($_W['fans']['nickname'])) {
				$fans = mc_oauth_userinfo();
				$fansInfo = $fans;
			} else {
				$fansInfo = $_W['fans'];
			}
		}
		MonUtil::setClientCookieUserInfo($fansInfo, $this::$USER_COOKIE_KEY . "" . $this->weid);//保存到cookie
		$uc = $this->findUniUserInfo($fansInfo['openid'], $this->weid);
		include_once  'core/app/'.strtolower(substr($f_name,8)).'.php';
	}

	public function doMobileEwm() {
		return $this->createPoster(1, 1628);
	}

	public function doMobilePoster() {
		global $_GPC, $_W;
		$kid = $_GPC['kid'];
		$uid = $_GPC['uid'];
		$imagUrl =  $this->createPoster($kid, $uid);
		header("location: $imagUrl");
	}


	/************************************************手机*********************************/
	/**
	 * author: codeMonkey QQ:2463619823
	 * 用户砍价页
	 */
	public function  doMobileIndex()
	{
		$this->__mobile(__FUNCTION__);
	}

	public function  doMobileRank()
	{
		$this->__mobile(__FUNCTION__);
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 自砍一刀
	 */
	public  function doMobileSelfKj() {
		$this->__mobile(__FUNCTION__);
	}


	/**
	 * author: codeMonkey QQ:2463619823
	 * 好友砍刀
	 */
	public  function doMobileFriendfKj() {
		$this->__mobile(__FUNCTION__);
	}
	/**
	 * author: codeMonkey QQ:2463619823
	 * 地址
	 */
	public function doMobileAddress() {
		$this->__mobile(__FUNCTION__);
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 砍价朋友页面
	 */
	public function doMobileKj()
	{
		$this->__mobile(__FUNCTION__);
	}

	function doMobileUserShare() {
		global $_GPC;
		$kid = $_GPC['kid'];
		$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
		$userInfo =$this->getClientUserInfo();
		$this->updateTJRecord($xkwkj, self::TTYPE_SHARE, $userInfo);
		die(json_encode(array('code' => 200)));
	}

	public function getShareUrl($kid, $uid)
	{
		if (empty($uid)) {
			MonUtil::str_murl($this->createMobileUrl('Auth', array('kid' => $kid, 'au' => Value::$REDIRECT_USER_INDEX), true));
		} else {
			return MonUtil::str_murl($this->createMobileUrl('Auth', array('kid' => $kid, 'uid' => $uid, 'au' => Value::$REDIRECT_KJ), true));
		}
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $uid
	 * @param $fopenid
	 * @param $fnickname
	 * @param $fheadimgurl
	 * 砍价信息
	 */
	public function  createFriendKj($xkwkj, $uid, $fopenid, $fnickname, $fheadimgurl, $seq_weapon, $name_seq)
	{
		global $_W;
		$dbFirend = $this->findHelpFirend($uid, $fopenid);
		$user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $uid);
		$leftCount = $this->getLeftCount($xkwkj);
		if ($leftCount <= 0) {
			return array(0,0, "库存已经没了，下次再来砍吧！");
		}

		if ($user['price'] <= $xkwkj['p_low_price']) {
			return array(0,0, "好友砍价过猛已经最低价啦，下次再来帮好友砍吧！");
		}

		$dayKjCount = $this->findDayKjCount($xkwkj['id'], $uid);

		if ($dayKjCount >= $xkwkj['day_help_count']) {
			return array(0,0, "亲，今天帮砍好友名额已够，明天再来帮好友砍价吧！");
		}

		$k_price = $this->getKjPrice($xkwkj, $user['price']);
		if (empty($dbFirend)) {
			$leftPrice = $user['price'] - $k_price;
			if ($leftPrice <= $xkwkj['p_low_price']) {
				$leftPrice = $xkwkj['p_low_price'];
			}
			$helpFirend = array(
				'kid' => $xkwkj['id'],
				'uid' => $uid,
				'openid' => $fopenid,
				'nickname' => $fnickname,
				'headimgurl' => $fheadimgurl,
				'ac' => '砍了',
				'k_price' => $k_price,
				'kh_price' => $leftPrice,
				'kd' => $seq_weapon,
				'kname' => $name_seq,
				'ip' => $_W['clientip'],
				'createtime' => TIMESTAMP
			);

			DBUtil::create(DBUtil::$TABLE_XKWKJ_FIREND, $helpFirend);



			DBUtil::updateById(DBUtil::$TABLE_XKWKJ_USER, array('price' => $leftPrice, 'updatetime'=> TIMESTAMP), $uid);

			$this->sendTemplateMsg($xkwkj, $fnickname, $k_price, $leftPrice, $user['openid']);

		} else{
			return array(0,0, "已经帮好友砍过价了，下次再继续吧！！");
		}

		return array(1,$k_price, $this->getTipMsg($xkwkj, $this::$TIP_DIALOG));

	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 砍价高手
	 */
	public function doMobileKjFirendList() {
		$this->__mobile(__FUNCTION__);
   }

	/**
	 * author: codeMonkey QQ:2463619823
	 * 订单提交
	 */
	public function  doMobileOrderSubmit()
	{
		$this->__mobile(__FUNCTION__);
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 付款
	 */
    public function doMobilePay() {
		$this->__mobile(__FUNCTION__);
	}

	public function toPayTemplate($user,$orderInfo, $xkwkj) {
		global $_W;
		$jsApi = new JsApi_pub($this->xkkjSetting);
		$jsApi->setOpenId($user['openid']);
		$unifiedOrder = new UnifiedOrder_pub($this->xkkjSetting);
		$unifiedOrder->setParameter("openid", $user['openid']);//商品描述
		$unifiedOrder->setParameter("body", "砍价商品" . $xkwkj['p_name']);//商品描述
		$out_trade_no = date('YmdHis', time()). "o".$orderInfo['id'];
		$unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号
		//$orderInfo['total_price']
		//$unifiedOrder->setParameter("total_fee", 1);//总金额
		$unifiedOrder->setParameter("total_fee", $orderInfo['total_price']*100);//总金额
		$notifyUrl = $_W['siteroot'] . "addons/" . MON_XKWKJ . "/notify.php";
		$unifiedOrder->setParameter("notify_url", $notifyUrl);//通知地址
		$unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
		$prepay_id = $unifiedOrder->getPrepayId();
		$jsApi->setPrepayId($prepay_id);
		DBUtil::updateById(DBUtil::$TABLE_XKWJK_ORDER, array('outno' => $out_trade_no), $orderInfo['id']);
		$jsApiParameters = $jsApi->getParameters();
		//$gmCount = $this->getOrderCount($xkwkj['id'], $this::$KJ_STATUS_GM);
		$leftCount = $this->getLeftCount($xkwkj);
		//$leftCount = 3;
		$orderInfo = $this->findOrderInfo($xkwkj['id'], $user['id']);

		include $this->template('order_pay');

	}

	/**
	 * author: codeMonkey QQ:631872807
	 * 订单
	 */
	public function  doMobileOrderInfo()
	{
		$this->__mobile(__FUNCTION__);
	}

    public function doMobileOrderDetail() {
		$this->__mobile(__FUNCTION__);
	}

	public function  doMobileQrcode() {
		$this->__mobile(__FUNCTION__);
	}

	public function getScanCode($oid) {
		$codeArray = array(
			'exeUrl' => MonUtil::str_murl($this->createMobileUrl('ExchangeApi', array('oid'=> $oid), true)),
			'gcode' => $this::$GCODE
		);
		return base64_encode(json_encode($codeArray));
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 对接兑换中心 url
	 */
	public function doMobileExchangeApi()
	{
		global $_GPC, $_W;
		$oid = $_GPC['oid'];
		$order = DBUtil::findById(DBUtil::$TABLE_XKWJK_ORDER, $oid);
		$res = array();


		if (empty($order)) {
			$res['res'] = 'fail';
			$res['msg'] = '砍价记录删除或不存在';
			die(json_encode($res));
		}

		if ($order['status'] == $this::$KJ_STATUS_YFH) {
			$res['res'] = 'fail';
			$res['msg'] = '已兑换，不能重复兑换！';
			die(json_encode($res));
		}

		$tokenUrl = urldecode($_GPC['tokenUrl']);
		$token = $_GPC['token'];

		if (empty($tokenUrl) || empty($token)) {
			$res['res'] = 'fail';
			$res['msg'] = '核销人员信息信息错误';
			die(json_encode($res));
		}

		load()->func('communication');
		//验证核销人员
		$result = ihttp_post($tokenUrl, array('token' => $token));
		$resultJson = json_decode(substr($result['content'], 3), true);

		if (empty($resultJson)) {
			$resultJson = json_decode($result['content'], true);
		}

		if (empty($resultJson)) {
			$res['res'] = 'fail';
			$res['msg'] = '验证核销人员返回为空';
			die(json_encode($res));
		} else {
			if ($resultJson['code'] == 200) {

				$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $order['kid']);
				if ($xkwkj['pay_type'] == 1 && $order['status'] != $this::$KJ_STATUS_GM) {
					$res['res'] = 'fail';
					$res['msg'] = '订单没有支付!';
					die(json_encode($res));
				}
				//开始执行核销
				DBUtil::updateById(DBUtil::$TABLE_XKWJK_ORDER, array('status'=>$this::$KJ_STATUS_YFH), $oid );
				$user = DBUtil::findById(DBUtil::$TABLE_XKWKJ_USER, $order['uid']);
				$res['res'] = 'success';
				$res['uname'] = $order['uname'];
				$res['unickname'] = $user['nickname'];
				$res['utel'] = $order['tel'];
				$res['pname'] = $xkwkj['p_name'];
				$res['remark'] = '炫酷砍价兑换成功';
				die(json_encode($res));

			} else {
				$res['res'] = 'fail';
				$res['msg'] = '核销人员删除或不存在!';
				die(json_encode($res));
			}
		}
	}

	/**
	 * author: codeMonkey QQ:631872807
	 * @param $kid
	 * @param $uid
	 * @return string
	 * 订单号
	 */
	public function  getOrderNo($kid, $uid)
	{
		return date('YmdHis', time()) . "k" . $kid . "u" . $uid;
	}

	public function  doMobileAuth()
	{
		$this->__mobile(__FUNCTION__);
	}

	public function getClientUserInfo() {
		if (MonUtil::$DEBUG) {
			return array('openid'=>'o-V_rwTOc46mEGTg5SyeO8Pb3q7gxx', 'headimgurl'=> 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLBTXRiabpibnySKSTiaUlo2KcTm8icCzKDiaJV4O5U1NduzibRHfKibWj6lpQqSrByZt4phIpdC93FnW0NUORib1A0sYbKMib2jW74h7w0o/132', 'nickname'=> 'codeMonkeyTest');
		} else {
			$userInfo = MonUtil::getClientCookieUserInfo($this::$USER_COOKIE_KEY . "" . $this->weid);
			return $userInfo;
		}
	}

	public function doMobileUcenter() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileMyAddress() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileEditAddress() {
		$this->__mobile(__FUNCTION__);
	}

    public function doMobileDeleteAddress() {
		$this->__mobile(__FUNCTION__);
	}

    public function doMobileSubmitOrder() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileOrder() {
		$this->__mobile(__FUNCTION__);
	}

	public function  doMobileAuth2()
	{
		$this->__mobile(__FUNCTION__);
	}

	/**
	 * 首页
	 */
	public function doMobileHomeIndex() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileHomePage() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileMyKjList() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileMyKjPage() {
		$this->__mobile(__FUNCTION__);
	}

	/**
	 * 活动管理
	 */
	public function  doWebXKKjManage() {
		$this->__web(__FUNCTION__);
	}

    public function doWebDesigner_poster() {
		$this->__web(__FUNCTION__);
	}

    public function doWebIndexShowEnable() {
		$this->__web(__FUNCTION__);
	}

	public function doWebUpdateSort() {
		$this->__web(__FUNCTION__);
	}

	public function doWebUpdateCatetorySort() {
		$this->__web(__FUNCTION__);
	}

	public function doWebSearchkj() {
		$this->__web(__FUNCTION__);
	}

	public function doWebXkkjEdit() {
		$this->__web(__FUNCTION__);
	}

	public function doWebPoster() {
		$this->__web(__FUNCTION__);
	}

    public function doWebPre_poster() {
		$this->__web(__FUNCTION__);
	}

	function delFileUnderDir( $dirName )
	{
		if ( $handle = opendir( "$dirName" ) ) {
			while ( false !== ( $item = readdir( $handle ) ) ) {
				if ( $item != "." && $item != ".." ) {
					if ( is_dir( "$dirName/$item" ) ) {
						$this->delFileUnderDir( "$dirName/$item" );
					} else {
						if( unlink( "$dirName/$item" ) ) {
							echo "删除文件： $dirName$item 成功<br/>";
						}
					}
              }
            }
		}
      closedir( $handle );
}

	public function doWebClearPoster() {
		$post_dir = IA_ROOT."/addons/mon_xkwkj/poster/";
		$this->delFileUnderDir($post_dir);
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 设置
	 */
	public function doWebXKKjSetting() {
		$this->__web(__FUNCTION__);
	}

    public function doWebAddppt() {
		global $_GPC, $_W;
		$defaultOrder = $_GPC['defaultOrder'];
		load()->func('tpl');
		include $this->template("ppt_template");
	}

    public function doWebGoodsManage() {
		$this->__web(__FUNCTION__);
	}

     public function doWebGoodsEdit() {
		 $this->__web(__FUNCTION__);
	 }

     public function doWebSearchgoods() {
		 $this->__web(__FUNCTION__);
	 }
	/**
	 * author: codeMonkey QQ:631872807
	 * 砍价 订单
	 */

	public function  doWebOrderList() {
		$this->__web(__FUNCTION__);
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 订单详细
	 */
	public function  doWebOrderDetail() {
		$this->__web(__FUNCTION__);
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 参与用户
	 */
	public function  doWebJoinUser() {
		$this->__web(__FUNCTION__);
	}

	public function  doWebAllUser() {
		$this->__web(__FUNCTION__);
	}
	/**
	 * author: codeMonkey QQ:63187280
	 */
	public function doWebhelpFriend() {
		$this->__web(__FUNCTION__);
	}

	public function doWebDeleteXkWkj() {
		$this->__web(__FUNCTION__);
	}

	public function doWebDeleteUser() {
		$this->__web(__FUNCTION__);
	}

	public function doWebDeleteOrder() {
		$this->__web(__FUNCTION__);
	}

    public function doWebRegisters() {
		$this->__web(__FUNCTION__);
	}

	public function doWebUserDetail() {
		$this->__web(__FUNCTION__);
	}
	/**
	 * 首页设置
	 */
	public function doWebIndexSetting() {
		$this->__web(__FUNCTION__);
	}

	public function  doWeborderDownload() {
		require_once 'orderdownload.php';
	}

	public function  doWebUDownload()
	{
		require_once 'udownload.php';
	}

	public function doWebUserwkj() {
		$this->__web(__FUNCTION__);
	}

	public function doWebCategorySetting() {
		$this->__web(__FUNCTION__);
	}

	public function doWebCategoryedit() {
		$this->__web(__FUNCTION__);
	}

	public function doWebTemplateManage() {
		$this->__web(__FUNCTION__);
	}

	public function doWebCopykj() {
		$this->__web(__FUNCTION__);
	}
	/***************************函数********************************/

	public function getJoinCount($xkwkj) {
		$userCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_USER) . " WHERE kid =:kid", array(":kid" => $xkwkj['id']));
		return $userCount + $xkwkj['v_user'];
	}
	/**
	 * author: codeMonkey QQ:631872807
	 * @param $kid
	 * @param $status
	 * @return bool数量
	 */
	public function getOrderCount($kid, $status)
	{
		$orderCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWJK_ORDER) . " WHERE kid =:kid and status=:status", array(":kid" => $kid, ":status" => $status));
		return $orderCount;
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $kid
	 * 查找剩余数量
	 */
	public function getLeftCount($xkwkj) {

		if ($xkwkj['kc_type'] == 1) { //付款后扣取
			$orderCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWJK_ORDER) . " WHERE kid=:kid and (status=4 or status=5) ", array( ":kid" => $xkwkj['id']));
		} else {
			$orderCount = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWJK_ORDER) . " WHERE kid=:kid ", array( ":kid" => $xkwkj['id']));
		}
		return $xkwkj['p_kc'] - $orderCount;
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 查找参加用户
	 */
	public function  findJoinUser($kid, $openid) {
		return DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_USER, array(':kid' => $kid, ':openid' => $openid));
	}

	public function findUserAc($kid, $openid) {
		return DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_USER, array(':kid' => $kid, ':openid' => $openid));
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $openid
	 * @param $weid
	 * @return bool 查找共享的用户信息
	 */
	public function findUniUserInfo($openid, $weid) {
		return DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_USER_INFO, array(':weid' => $weid, ':openid' => $openid));
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $uid
	 * @param $fopenid
	 * @return bool
	 * 超找帮助用户
	 */
	public function  findHelpFirend($uid, $fopenid) {
		return DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_FIREND, array(':uid' => $uid, ':openid' => $fopenid));
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $kid
	 * @param $fopenid
	 *
	 */
    public function findHelpFirendLimit($kid, $fopenid) {
		return DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_FIREND, array(':kid' => $kid, ':openid' => $fopenid));
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $kid
	 * @param $uid
	 * @return bool
	 * 每天参加砍价用户数
	 */
	public function findDayKjCount($kid, $uid) {
		$today_beginTime = strtotime(date('Y-m-d' . '00:00:00', TIMESTAMP));
		$today_endTime = strtotime(date('Y-m-d' . '23:59:59', TIMESTAMP));
		$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " WHERE  kid=:kid and uid=:uid and createtime<=:endtime and  createtime>=:starttime ", array(':kid' => $kid, ":uid" => $uid, ":endtime" => $today_endTime, ":starttime" => $today_beginTime));
		return $count;
	}

	public function findJoinUserCount($kid) {
		$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_USER) . " WHERE  kid=:kid", array(':kid' => $kid));
	    return $count;
	}

	public function findSameKJHelpCount($kid, $fopenid) {
		$count = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " WHERE  kid=:kid and openid=:openid", array(':kid' => $kid, ":openid" => $fopenid));
		return $count;
	}

	public function findHelpProductCount($fopenid) {
		$count = pdo_fetchcolumn('SELECT COUNT(DISTINCT kid) FROM ' . tablename(DBUtil::$TABLE_XKWKJ_FIREND) . " WHERE openid=:openid", array( ":openid" => $fopenid));
		return $count;
	}
	/**
	 * author: codeMonkey QQ:631872807
	 * @param $type
	 * 获取转向URL
	 */
	public function  getRedirectUrl($type, $parmas = array())
	{
		switch ($type) {

			case Value::$REDIRECT_USER_INDEX://首页
				$redirectUrl = $this->createMobileUrl('index', $parmas, true);
				break;
			case Value::$REDIRECT_KJ:
			case 4:
				$redirectUrl = $this->createMobileUrl('kj', $parmas, true);
				break;
			case Value::$REDIRECT_MY_KJ:
				$redirectUrl = $this->createMobileUrl('MyKjList', $parmas, true);
				break;
		}

		return MonUtil::str_murl($redirectUrl);
	}


	/**
	 * author: codeMonkey QQ:631872807
	 * @param $status
	 * 状态文字
	 */
	public function  getStatusText($status)
	{
		switch ($status) {
			case $this::$KJ_STATUS_WKS:
				return "未开始";
				break;
			case $this::$KJ_STATUS_ZC:
				return "正常";
				break;
			case $this::$KJ_STATUS_JS:
				return "已结束";
				break;
			case $this::$KJ_STATUS_XD:
				return "已下单";
				break;
			case $this::$KJ_STATUS_GM:
				return "已支付购买";
			break;
			case $this::$KJ_STATUS_YFH:
			return "已发货";
			break;
		}
	}

	public function  getOrderStatusLabel($status)
	{

		switch ($status) {
			case $this::$KJ_STATUS_WKS:
				return "未开始";
				break;
			case $this::$KJ_STATUS_ZC:
				return "正常";
				break;
			case $this::$KJ_STATUS_JS:
				return "已结束";
				break;
			case $this::$KJ_STATUS_XD:
				return '<span class="label label-primary">已下单</span>';
				break;
			case $this::$KJ_STATUS_GM:
				return '<span class="label label-success">已支付购买</span>';
				break;
			case $this::$KJ_STATUS_YFH:
				return '<span class="label label-success">已发货</span>';
				break;
		}
	}

	public function getOrderStatus($status, $pay_type) {

		switch($status) {
			case $this::$KJ_STATUS_XD:
				if ($pay_type == self::PAY_TYPE_WX) {
					return "待支付";
				}

				if ($pay_type == self::PAY_ZT) {
					return "待发货";
				}
				break;
			case $this::$KJ_STATUS_GM:
				return "待发货";
				break;
			case $this::$KJ_STATUS_YFH:
				return "已发货";
				break;
		}
	}

	public function getLQType($lq_type) {
		if ($lq_type == self::LQ_TYPE_KD) {
			return "快递送货";
		}

		if (empty($lq_type)) {
			return "快递送货";
		}

		if ($lq_type == self::LQ_TYPE_ZT) {
			return "到店取货";
		}
	}

	/**
	 * author: codeMonkey QQ:631872807
	 * @param $wkj
	 * @param $joinUser
	 * @return int
	 * 状态获取
	 */
	public function getStatus($xkwkj, $joinUser) {

		if (TIMESTAMP < $xkwkj['starttime']) {
			return $this::$KJ_STATUS_WKS;
		}
		if (TIMESTAMP > $xkwkj['endtime']) {
			return $this::$KJ_STATUS_JS;
		}

		if (!empty($joinUser)) {
			$orderInfo = $this->findOrderInfo($xkwkj['id'], $joinUser['id']);
			if (empty($orderInfo)) {
				return $this::$KJ_STATUS_ZC;
			} else {
				return $orderInfo['status'];
			}
	  } else {
	       return $this::$KJ_STATUS_ZC;
	  }

	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $kid
	 * @param $uid
	 * @return bool 超找 订单信息
	 */
	public function findOrderInfo($kid, $uid) {
		$orderInfo = DBUtil::findUnique(DBUtil::$TABLE_XKWJK_ORDER, array(':kid' => $kid, ':uid' => $uid));
		return $orderInfo;
	}

	public function findOrderInfoByOpenid($kid, $openid) {
		$orderInfo = DBUtil::findUnique(DBUtil::$TABLE_XKWJK_ORDER, array(':kid' => $kid, ':openid' => $openid));
		return $orderInfo;
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $wkj
	 * @param $user
	 * 获取砍价的价格
	 */
	public function getKjPrice($xkwkj, $userNowPrice) {

		if (empty($xkwkj['kj_rule'])) {
			return 0;
		}

		if ($userNowPrice <= $xkwkj['p_low_price']) {
			return 0;
		}

		$kj_rule = unserialize($xkwkj['kj_rule']);
		$kj_price = 0;
		$inRule = false;
		foreach ($kj_rule as $rule) {

			if ($userNowPrice >= $rule['rule_pice']) {
				$kj_price = rand($rule['rule_start'] * 100, $rule['rule_end'] * 100) / 100;
				$inRule = true;
				break;
			}

		}

		if (!$inRule) {
			$kj_price = rand(1 * 100, 2 * 100) / 100;
		}

		if ($userNowPrice - $kj_price < $xkwkj['p_low_price']) {
		    return $userNowPrice - $xkwkj['p_low_price'];
			//return 0;
		}

		return $kj_price;
	}


	/**
	 * author: codeMonkey QQ:631872807
	 * @param $wkj
	 * @param $msg_type
	 * @return mixed
	 * 获取随机文字信息
	 */
	public function  getTipMsg($wkj, $msg_type) {
		if (empty($wkj)) {
			reutrn;
		}
		switch ($msg_type) {
			case $this::$TIP_DIALOG:
				$msgContent = $wkj['kj_dialog_tip'];
				break;
			case $this::$TIP_U_FIRST:
				$msgContent = $wkj['u_fist_tip'];
				break;
			case $this::$TIP_U_ALREADY:
				$msgContent = $wkj['u_already_tip'];
				break;
			case $this::$TIP_RANK:
				$msgContent = $wkj['rank_tip'];
				break;
			case $this::$TIP_FK_FIRST:
				$msgContent = $wkj['fk_fist_tip'];
				break;
			case $this::$TIP_FK_ALREADY:
				$msgContent = $wkj['fk_already_tip'];
				break;
		}
		$msgContent = trim($msgContent);
		$msg_arr = explode("\r\n", $msgContent);
		if (count($msg_arr) == 1) {
			return $msg_arr[0];
		} else {
			return $msg_arr[rand(0, count($msg_arr) - 1)];
		}
	}

	public function findXKKJsetting()
	{
		$xkkjsetting = DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_SETTING, array(":weid" => $this->weid));
		return $xkkjsetting;
	}
	
	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $qmql
	 * @param $pname
	 * @param $fname
	 * @param $floor
	 * @param $uopenid发送模板消息
	 */
	public function sendTemplateMsg($xkwkj, $fname, $price, $uprice, $uopenid) {
		$templateMsg = array();
		if ($this->xkkjSetting['tmp_enable'] == 1) {
			$templateMsg['template_id'] = $this->xkkjSetting['tmpId'];
			$templateMsg['touser'] = $uopenid;
			$templateMsg['url'] = MonUtil::str_murl( $this->createMobileUrl ('auth',  array('kid' => $xkwkj['id'],'au'=>Value::$REDIRECT_USER_INDEX), true));
			$templateMsg['topcolor'] = '#FF0000';
			$data = array();
			$data['first'] = array('value'=>$fname. "好友帮您砍掉了".$price."元！你当前商品金额为" .$uprice . "元" , 'color'=>'#173177');

			$data['keyword1'] = array('value'=> $xkwkj['title'], 'color'=>'#173177');
			$data['keyword2'] = array('value'=> '好友帮助砍价', 'color'=>'#173177');
			$data['remark'] = array('value'=>"继续邀请好友帮您砍价吧，加油哦！", 'color'=>'#173177');

			$templateMsg['data'] = $data;
			$jsonData = json_encode($templateMsg);
			WeUtility::logging('info',"发送模板消砍价".$jsonData);
			load()->func('communication');
			$acessToken = $this->getAccessToken();
			$apiUrl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$acessToken;
			$result = ihttp_request($apiUrl, $jsonData);
			WeUtility::logging('info',"发送模板消息砍价返回".$result);

			WeUtility::logging('info',"发送模板消息砍价返回".json_encode($result));
		}
	}

	public function sendFHTemplateMsg($xkwkj, $user, $order) {
		$templateMsg = array();
		if ($this->xkkjSetting['fh_tmp_enable'] == 1) {

			$templateMsg['template_id'] = $this->xkkjSetting['fh_tmp_id'];
			$templateMsg['touser'] = $user['openid'];
			$templateMsg['url'] = MonUtil::str_murl( $this->createMobileUrl ('auth',  array('kid' => $xkwkj['id'],'au'=>Value::$REDIRECT_USER_INDEX), true));
			$templateMsg['topcolor'] = '#FF0000';
			$data = array();
			$data['first'] = array('value'=>$user['nickname']. "您好，您参与".$xkwkj['title']."砍价活动的商品已处理（发货）啦！" , 'color'=>'#173177');
			$data['keyword1'] = array('value'=> $order['order_no'] , 'color'=>'#173177');
			$data['keyword2'] = array('value'=> $xkwkj['p_name'], 'color'=>'#173177');
			$data['keyword3'] = array('value'=> 1, 'color'=>'#173177');
			$data['keyword4'] = array('value'=> $order['total_price'], 'color'=>'#173177');

			$data['remark'] = array('value'=>"备注：详情可以咨询活动主办方哦！", 'color'=>'#173177');

			$templateMsg['data'] = $data;
			$jsonData = json_encode($templateMsg);
			WeUtility::logging('info',"发送发货模板消砍价".$jsonData);
			load()->func('communication');
			$acessToken = $this->getAccessToken();
			$apiUrl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$acessToken;
			$result = ihttp_request($apiUrl, $jsonData);
			WeUtility::logging('info',"发送模板消息砍价返回".$result);

			WeUtility::logging('info',"发送模板消息砍价返回".json_encode($result));
		}
	}

	
}