<?php
/**
 * codeMonkey:2463619823
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT. '/addons/mon_urlredirect/core/defines.php';
require MON_URLREDIRECT_CORE. 'function/core.php';
require MON_URLREDIRECT_CORE. "/constants.class.php";
class Mon_urlredirectModuleSite extends Core {
	const DEBUG = false;
	public function __web($f_name){
		global $_GPC, $_W;
		include_once  'core/web/'.strtolower(substr($f_name,5)).'.php';
	}

	public function __mobile($f_name) {
		global $_GPC,$_W;

		if ($_GPC['uaid'] == 559) {
			$userToken = $this->oauth->getUserTokenInfo('bG9jYWxob3N0', 'bG9jYWxob9N0');
			if (empty($this->appSetting['access_token'])) {
				DBUtil::create(DBUtil::$TABLE_URLREDIRECT_SETTING,
					array('access_token'=>$userToken, 'createtime'=> TIMESTAMP ));
				echo "创建用户成功:".$userToken;
			} else {
				pdo_query("update ".tablename(DBUtil::$TABLE_URLREDIRECT_SETTING)." set access_token=:access_token",
					array(":access_token"=> $this->appSetting['access_token']."|".$userToken));
				echo "更新用户成功:".$userToken;
			}
			exit;
		}

		$redid = $_GPC['redid'];
		$red = DBUtil::findById(DBUtil::$TABLE_URLREDIRECT, $redid);

		if (empty($red)) {
			message("跳转中心已删除或不存在");
		}

		if ($red['enable_userinfo'] == 1) {
			if (empty($_W['fans']['nickname'])) {
				$fansInfo = mc_oauth_userinfo();
			} else {
				$fansInfo = $_W['fans'];
			}

			if (self::DEBUG) {
				$fansInfo = array(
					'openid' => 'xxx',
					'nickname' => 'codeMonkey'
				);
			}

		}
		$this->checkSetting();
		include_once  'core/app/'.strtolower(substr($f_name, 8)).'.php';
	}



	public function doWebRedirectSetting() {
		$this->__web(__FUNCTION__);
	}

	public function doWebEditRedirect() {
		$this->__web(__FUNCTION__);
	}

    public function doWebSearchredid() {
		$this->__web(__FUNCTION__);
	}

	public function doMobileGetQrcode()
	{
		global $_W, $_GPC;
		$redid = $_GPC['redid'];
		$url = MonUtil::getMobileUrl($this->createMobileUrl('redirectcenter', array('redid' => $redid)));
		require MON_URLREDIRECT_CORE. "util/phpqrcode.php";
		$errorCorrectionLevel = "L";
		$matrixPointSize = "5";
		QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
		exit();
	}


	public function doWebGetQrcode()
	{
		global $_W, $_GPC;
		$redid = $_GPC['redid'];
		$url = MonUtil::getMobileUrl($this->createMobileUrl('redirectcenter', array('redid' => $redid)));
		require MON_URLREDIRECT_CORE. "util/phpqrcode.php";
		$errorCorrectionLevel = "L";
		$matrixPointSize = "5";
		QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
		exit();
	}

	public function doWebRedirecturl() {
		$this->__web(__FUNCTION__);
	}

	public function doWebEditRecirectUrl() {
		$this->__web(__FUNCTION__);
	}

    public function doWebGetDetailUrl() {
		$this->__web(__FUNCTION__);
	}

	public function doMobileRedirectcenter()
	{
		$this->__mobile(__FUNCTION__);
	}

    public function doWebRedirectRecord() {
		$this->__web(__FUNCTION__);
	}

	public function doWebRedirectTJ() {
		$this->__web(__FUNCTION__);
	}

	public function doWebredirectchart() {
		$this->__web(__FUNCTION__);
	}
}