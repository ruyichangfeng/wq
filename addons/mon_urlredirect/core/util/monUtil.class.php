<?php

/**
 * Class MonUtil
 * 工具类
 */
class MonUtil {

	public static $DEBUG = false;
	public static $IMG_TITLE_BG = 1;
	public static $IMG_SHARE_BG  = 2;
	public static $IMG_INTRO_BG  = 3;
	public static $IMG_SHARE_IMG  = 4;
	/**
	 * author: codeMonkey QQ:631872807
	 * @param $url
	 * @return string
	 */
	public static function getMobileUrl($url) {
		global $_W;
		return $_W['siteroot'] . 'app' . str_replace('./', '/', $url);
	}


	/**
	 * author: codeMonkey QQ:631872807
	 * 检查手机
	 */
	public static function  checkmobile() {
		if (!MonUtil::$DEBUG) {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			if (strpos($user_agent, 'MicroMessenger') === false) {
				echo "本页面仅支持微信访问!非微信浏览器禁止浏览!";
				exit();
			}
		}

	}

	/**
	 * author:codeMonkey QQ 631872807
	 * 获取哟规划信息
	 * @return array|mixed|stdClass
	 */
	public static function  getClientCookieUserInfo($cookieKey) {
		global $_GPC;
		$session = json_decode(base64_decode($_GPC[$cookieKey]), true);
		return $session;
	}


	/**
	 * author: codeMonkey QQ:631872807
	 * @param $openid
	 * @param $accessToken
	 * @return unknown
	 * cookie保存用户信息
	 */
	public static function setClientCookieUserInfo($userInfo = array(), $cookieKey) {

		if (!empty($userInfo) && !empty($userInfo['openid'])) {
			$cookie = array();
			foreach ($userInfo as $key => $value)
				$cookie[$key] = $value;
			$session = base64_encode(json_encode($cookie));

			isetcookie($cookieKey, $session, 1 * 3600 * 2);
		} else {

			message("获取用户信息错误");
		}

	}

	public static function getPicUrl($url) {
		global $_W;
		return $_W ['attachurl'] . $url;
	}

	public static function  emtpyMsg($obj, $msg) {
		if (empty($obj)) {
			message($msg);
		}
	}


	/**
	 * author: codeMonkey QQ:2463619823
	 * @param $img_type
	 * @param $xkjt
	 * @return string
	 *
	 *
	 * 	public static $IMG_TITLE_BG = 1;
	public static $IMG_SHARE_BG  = 2;
	public static $IMG_INTRO_BG  = 3;
	 */
	public static function getImg($img_type, $ac) {

		switch($img_type) {
			case MonUtil::$IMG_TITLE_BG:
				if (!empty($ac['title_img'])) {
					return MonUtil::getPicurl($ac['title_img']);
				}
				$img_name = "97b31469c67f.jpg";
				break;
			case MonUtil::$IMG_SHARE_BG:
				if (!empty($ac['share_bg'])) {
					return MonUtil::getPicurl($ac['share_bg']);
				}
				$img_name = "0ebda809a93e.png";
				break;
			case MonUtil::$IMG_INTRO_BG:
				if (!empty($ac['intro_img'])) {
					return MonUtil::getPicurl($ac['intro_img']);
				}
				$img_name = "e27141366abc.jpg";
				break;
			case MonUtil::$IMG_SHARE_IMG:
				if (!empty($ac['share_img'])) {
					return MonUtil::getPicurl($ac['share_img']);
				}
				$img_name = "d119b8f11ff9.jpg";
				break;

		}

		return "../addons/mon_coupon/static/images/" . $img_name;
	}


	public  static function getBgColor($bgColor) {
		if (empty($bgColor)) {
			return "#D42012";
		}
		return $bgColor;
	}

	public static function exportexcel($data = array(), $title = array(), $dc ,$filename = 'report') {
		ob_end_clean();
		header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Content-type:application/vnd.ms-excel;charset=UTF-8");
		header("Content-Disposition:attachment;filename=" . $filename . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//导出xls 开始
		if (!empty($title)) {
			foreach ($title as $k => $v) {
				if ($dc == 1) {
					$title[$k] = iconv("UTF-8", "GB2312", $v);
				} else if ($dc == 2) {
					$title[$k] = $v;
				}

			}
			$title = implode("\t", $title);
			echo "$title\n";
		}

		if (!empty($data)) {
			foreach ($data as $key => $val) {
				foreach ($val as $ck => $cv) {
					if ($dc == 1) {
						$data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
					} else {
						$data[$key][$ck] = $cv;
					}
				}
				$data[$key] = implode("\t", $data[$key]);
			}

			echo implode("\n", $data);
		}
	}

}