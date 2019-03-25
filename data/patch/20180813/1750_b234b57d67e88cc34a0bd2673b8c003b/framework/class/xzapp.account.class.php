<?php
defined('IN_IA') or exit('Access Denied');

class XzappAccount extends WeAccount {
	public $tablename = 'account_xzapp';

	public function __construct($account = array()) {
		$this->menuFrame = 'account';
		$this->type = ACCOUNT_TYPE_XZAPP_NORMAL;
		$this->typeName = '熊掌号';
		$this->typeSign = XZAPP_TYPE_SIGN;
		$this->typeTempalte = '-xzapp';
	}

	public function checkIntoManage() {
		if (empty($this->account) || (!empty($this->uniaccount['account']) && $this->uniaccount['type'] != ACCOUNT_TYPE_XZAPP_NORMAL && !defined('IN_MODULE'))) {
			return false;
		}
		return true;
	}

	public function fetchAccountInfo() {
		$account_table = table('account_xzapp');
		$account = $account_table->getXzappAccount($this->uniaccount['acid']);
		return $account;
	}

	public function accountDisplayUrl() {
		return url('account/display', array('type' => XZAPP_TYPE_SIGN));
	}

	public function isTagSupported() {
		if (!empty($this->account['key']) && !empty($this->account['secret'])) {
			return true;
		} else {
			return false;
		}
	}

	public function fansTagFetchAll() {
		$token = $this->getAccessToken();

		if (is_error($token)) {
			return $token;
		}

		$url = "https://openapi.baidu.com/rest/2.0/cambrian/tags/get?access_token={$token}";
		$result = $this->requestApi($url);
		return $result;
	}

	public function fansAll($startopenid = '') {
		global $_W;
		$token = $this->getAccessToken();
		if (is_error($token)) {
			return $token;
		}

		$url = "https://openapi.baidu.com/rest/2.0/cambrian/user/get?start_index=0&access_token={$token}";
		if (!empty($_GPC['next_openid'])) {
			$url .= '&start_index=' . $_GPC['next_openid'];
		}

		$res = ihttp_get($url);
		$content = json_decode($res['content'], true);

		if ($content['error_code']) {
			return error(-1, '访问熊掌号接口失败, 错误代码: 【' . $content['error_code'] . '】, 错误信息：【' . $content['error_msg'] . '】');
		}

		$return = array();
		$return['total'] = $content['total'];
		$return['fans'] = $content['data'];
		$return['next'] = $content['start_index'];
		return $return;
	}

	public function fansQueryInfo($uniid, $isOpen = true) {
		if ($isOpen) {
			$openid = $uniid;
		} else {
			exit('error');
		}
		$token = $this->getAccessToken();
		if(is_error($token)){
			return $token;
		}
		$data = array(
			'user_list' => array(
				array(
					'openid' => $uniid,
				)
			),
		);
		$url = "https://openapi.baidu.com/rest/2.0/cambrian/user/info?access_token={$token}";
		$res = ihttp_post($url, json_encode($data));
		$content = json_decode($res['content'], true);

		if ($content['error_code']) {
			return error(-1, "访问熊掌号接口失败, 错误代码：【{$content['error_code']}】, 错误信息：【{$content['error_msg']}】");
		}

		return $content['user_info_list'][0];
	}

	public function fansBatchQueryInfo($data) {
		if (empty($data)) {
			return error(-1, '粉丝 openid 错误');
		}

		$token = $this->getAccessToken();
		if (is_error($token)) {
			return $token;
		}

		$list['user_list'] = array();
		foreach ($data as $da) {
			$list['user_list'][] = array('openid' => $da);
		}

		$url = "https://openapi.baidu.com/rest/2.0/cambrian/user/info?access_token={$token}";
		$res = ihttp_post($url, json_encode($list));
		$content = json_decode($res['content'], true);

		if ($content['error_code']) {
			return error(-1, "访问熊掌号接口失败, 错误代码：【{$content['error_code']}】, 错误信息：【{$content['error_msg']}】");
		}

		return $content['user_info_list'];
	}

		public function menuCurrentQuery() {
		$token = $this->getAccessToken();
		if (is_error($token)) {
			return $token;
		}
		$url = "https://openapi.baidu.com/rest/2.0/cambrian/menu/get?access_token={$token}";
		$res = ihttp_get($url);
		$content = json_decode($res['content'], true);
		if ($content['error_code']) {
			return error(-1, "访问熊掌号接口失败, 错误代码：【{$content['error_code']}】, 错误信息：【{$content['error_msg']}】");
		}
		return $content;
	}

	public function checkSign() {
		$arrParams = array(
			$token = $this->account['token'],
			$intTimeStamp = $_GET['timestamp'],
			$strNonce = $_GET['nonce'],
		);
		sort($arrParams, SORT_STRING);
		$strParam = implode($arrParams);
		$strSignature = sha1($strParam);
		return $strSignature == $_GET['signature'];
	}

	public function getAccessToken() {
		$cachekey = cache_system_key('accesstoken', array('acid' => $this->account['acid']));
		$cache = cache_load($cachekey);

		if (!empty($cache) && !empty($cache['token']) && $cache['expire'] > TIMESTAMP) {
			$this->account['access_token'] = $cache;
			return $cache['token'];
		}

		if (empty($this->account['key']) || empty($this->account['secret'])) {
			return error('-1', '未填写熊掌号的 appid 或者 appsecret！');
		}

		$url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id={$this->account['key']}&client_secret={$this->account['secret']}";
		$content = ihttp_get($url);
		$token = @json_decode($content['content'], true);

		$record = array();
		$record['token'] = $token['access_token'];
		$record['expire'] = TIMESTAMP + $token['expires_in'] - 200;
		$this->account['access_token'] = $record;

		cache_write($cachekey, $record);
		return $record['token'];
	}

	protected function requestApi($url, $post = '') {
		$response = ihttp_request($url, $post);
		$result = @json_decode($response['content'], true);
		if (is_error($result)) {
			return error($result['error_code'], "访问熊掌号接口失败, 错误详情： {$result['error_msg']}");
		}
		return $result;
	}

}