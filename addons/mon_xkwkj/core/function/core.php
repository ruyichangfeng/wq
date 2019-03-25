<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2016/4/8
 * Time: 23:04
 */

//define("MON_XKWKJ", "mon_xkwkj");
//define("MON_XKWKJ_RES", "../addons/" . MON_XKWKJ . "/");


require IA_ROOT. '/addons/mon_xkwkj/core/defines.php';
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/dbutil.class.php";
require IA_ROOT . "/addons/" . MON_XKWKJ . "/oauth2.class.php";
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/value.class.php";
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/monUtil.class.php";
require_once IA_ROOT . "/addons/" . MON_XKWKJ . "/WxPayPubHelper/WxPayPubHelper.php";

class Core extends WeModuleSite {

	function __construct() {
		global $_W;
	}


	public function getMobileTemplate($tid) {

		if (empty($tid)) {
			return "templates/default/";
		}

		$templdate = DBUtil::findById(DBUtil::$TABLE_XKWKJ_TEMPLATE, $tid);

		if (empty($templdate)) {
			message("模板删除或不存在，请检查!!");
		}

		return "templates/". $templdate['dirname'] . "/";
	}

}