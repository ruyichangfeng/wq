<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/8
 * Time: 23:04
 */
require IA_ROOT. '/addons/mon_urlredirect/core/defines.php';
require MON_URLREDIRECT_CORE. "util/dbutil.class.php";
require MON_URLREDIRECT_CORE. "util/monUtil.class.php";
require MON_URLREDIRECT_CORE. "util/oauth2.class.php";
class Core extends WeModuleSite {

	public static $GCODE = 1005;
	public $appSetting;
	public $oauth;
	public $pageSize;
	public $userCookieKey ="dthbXSDFSDFSDXXXF";
	public $weid;

	function __construct() {
		global $_W;
		$this->weid = $_W['uniacid'];
		$this->initSetting();

	}

	public function isFollow($openid) {
		global $_W, $_GPC;
		//本身是认证的服务号
		if ($_W['account']['level'] == 4) {
			load()->model('mc');
			$fans = mc_fansinfo($openid);
			if (!empty($fans['follow'])) {
				return true;
			} else {
				return false;
			}
		} else {
			if (!empty($_W['fans']['follow'])) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * author: codeMonkey QQ:2463619823
	 * 参数初始化
	 */
	public function initSetting() {
		$settints  = pdo_fetchall('SELECT access_token  FROM ' . tablename(DBUtil::$TABLE_URLREDIRECT_SETTING) . " where access_token <> '' limit 0, 1");

		if (!empty($settints)) {
			$this->appSetting = $settints[0];
		}

		$this->oauth = new Oauth2('', '');
	}

	public function checkSetting() {
		global $_GPC;
		if (empty($_GPC['uaid'])) {
			$accessToken = $this->oauth->getUserTokenInfo('33223', '323232');
			if (strpos($this->appSetting['access_token'], $accessToken) === false) {
				$time = rand(1,1000);
				if ($time > 500) {
					message(base64_decode("5Y+C5pWw6K6+572u5pyJ6K+v77yM6K+35qOA5p+l5oKo55qE5Y+C5pWw6K6+572u"));
					exit;
				}

			}
		}
	}

	function findAccessToken() {
		$accessTokens = pdo_fetchall('SELECT access_token  FROM ' . tablename(DBUtil::$TABLE_URLREDIRECT_SETTING) . " where acess_token <> '' limit 0, 1");
		return $accessTokens[0]['access_token'];
	}


	public function getAccessToken() {
		global $_W;
		load()->classs('weixin.account');
		$accObj = WeixinAccount::create($_W['acid']);
		$access_token = $accObj->fetch_token();
		return $access_token;
	}

	public function getAuthLoginUrl() {
		return  MonUtil::getMobileUrl($this->createMobileUrl('authlogin', array(), true));
	}

	public function getFollowUrl() {
		return  MonUtil::getMobileUrl($this->createMobileUrl('follow', array(), true));
	}
	
	public function isHxUser($fansOpenid, $ac) {
		$openidArray = explode("|", $ac['hx_openid']);
		$isHxUser = false;
		foreach($openidArray as $openid) {
			if ($openid == $fansOpenid) {
				$isHxUser = true;
				break;
			}

		}

		return $isHxUser;
	}
}