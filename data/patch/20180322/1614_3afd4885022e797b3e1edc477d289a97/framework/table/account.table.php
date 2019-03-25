<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class AccountTable extends We7Table {

	protected $tableName = 'uni_account';
	protected $primaryKey = 'acid';
	
	public function baseaccount() {
		return $this->hasOne('baseaccount', 'acid', 'default_acid');
	}

	
	public function menus() {
		return $this->hasMany('menu', 'uniacid', 'uniacid');
	}

	
	public function unigroup() {
		return $this->belongsMany('unigroup', 'id', 'uniacid', 'uni_account_group', 'groupid' ,'uniacid');
	}

	public function searchAccountList($expire = false) {
		global $_W;
		$this->query->from('uni_account', 'a')->select('a.uniacid')->leftjoin('account', 'b')
				->on(array('a.uniacid' => 'b.uniacid', 'a.default_acid' => 'b.acid'))
				->where('b.isdeleted !=', '1');

				if (!user_is_founder($_W['uid']) || user_is_vice_founder()) {
			$this->query->leftjoin('uni_account_users', 'c')->on(array('a.uniacid' => 'c.uniacid'))
						->where('a.default_acid !=', '0')->where('c.uid', $_W['uid']);
		} else {
			$this->query->where('a.default_acid !=', '0');
		}
		if (!empty($expire)) {
			$this->searchWithExprie();
		}
		$this->accountUniacidOrder();
		$list = $this->query->getall('uniacid');
		return $list;
	}

	
	public function userOwnedAccount($uid = 0) {
		global $_W;
		$uid = intval($uid) > 0 ? intval($uid) : $_W['uid'];
		$is_founder = user_is_founder($uid);
		if (empty($is_founder) || user_is_vice_founder($uid)) {
			$users_table = table('users');
			$uniacid_list = $users_table->userOwnedAccount($uid);
			if (empty($uniacid_list)) {
				return array();
			}
			$this->query->where('u.uniacid', $uniacid_list);
		}
		return $this->query->from('uni_account', 'u')->leftjoin('account', 'a')->on(array('u.default_acid' => 'a.acid'))->where('a.isdeleted', 0)->getall('uniacid');
	}

	
	public function accountWechatsInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_wechats', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	
	public function accountWxappInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_wxapp', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	
	public function accountWebappInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_webapp', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	public function accountPhoneappInfo($uniacids, $uid) {
		return $this->query->from('uni_account', 'a')
				->leftjoin('account_phoneapp', 'w')
				->on(array('w.uniacid' => 'a.uniacid'))
				->leftjoin('uni_account_users', 'au')
				->on(array('a.uniacid' => 'au.uniacid'))
				->where(array('a.uniacid' => $uniacids))
				->where(array('au.uid' => $uid))
				->orderby('a.uniacid', 'asc')
				->getall('acid');
	}

	public function searchWithKeyword($title) {
		$this->query->where('a.name LIKE', "%{$title}%");
		return $this;
	}

	public function searchWithTitle($title) {
		$this->query->where('a.name', $title);
		return $this;
	}

	public function searchWithType($types = array()) {
		$this->query->where(array('b.type' => $types));
		return $this;
	}

	public function searchWithLetter($letter) {
		if (!empty($letter)) {
			$this->query->where('a.title_initial', $letter);
		} else {
			$this->query->where('a.title_initial', '');
		}
		return $this;
	}

	public function accountRankOrder() {
		$this->query->orderby('a.rank', 'desc');
		return $this;
	}

	public function accountUniacidOrder($order = 'desc') {
		$order = !empty($order) ? $order : 'desc';
		$this->query->orderby('a.uniacid', $order);
		return $this;
	}

	public function searchWithNoconnect() {
		$this->query->where('b.isconnect =', '0');
		return $this;
	}

	public function searchWithExprie() {
		global $_W;
		if (user_is_founder($_W['uid']) && !user_is_vice_founder()) {
			$this->query->leftjoin('uni_account_users', 'c')->on(array('a.uniacid' => 'c.uniacid'));
			$this->query->leftjoin('users', 'u')->on(array('c.uid' => 'u.uid'))
				->where('c.role', 'owner')->where('u.endtime !=', 0)->where('u.endtime <', TIMESTAMP);
		}

		return $this;
	}

	public function getWechatappAccount($acid) {
		return $this->query->from('account_wechats')->where('acid', $acid)->get();
	}

	public function getWxappAccount($acid) {
		return $this->query->from('account_wxapp')->where('acid', $acid)->get();
	}

	public function getWebappAccount($acid) {
		return $this->query->from('account_webapp')->where('acid', $acid)->get();
	}

	public function getPhoneappAccount($acid) {
		return $this->query->from('account_phoneapp')->where('acid', $acid)->get();
	}

	public function getUniAccountByAcid($acid) {
		$account = $this->query->from('account')->where('acid', $acid)->get();
		$uniaccount = array();
		if (!empty($account)) {
			$uniaccount = $this->query->from('uni_account')->where('uniacid', $account['uniacid'])->get();
		}
		if (empty($account)) {
			return array();
		} else {
			return array_merge($account, $uniaccount);
		}
	}

	public function getUniAccountByUniacid($uniacid) {
		$account = $this->getAccountByUniacid($uniacid);
		$uniaccount = array();
		if (!empty($account)) {
			$uniaccount = $this->query->from('uni_account')->where('uniacid', $account['uniacid'])->get();
		}
		if (empty($account)) {
			return array();
		} else {
			return !empty($uniaccount) && is_array($uniaccount) ? array_merge($account, $uniaccount) : $account;
		}
	}

	public function getAccountOwner($uniacid) {
		if (empty($uniacid)) {
			return array();
		}
		$owneruid = $this->query->from('uni_account_users')->where(array('uniacid' => $uniacid, 'role' => ACCOUNT_MANAGE_NAME_OPERATOR))->getcolumn('uid');
		if (empty($owneruid)) {
			return array();
		}
		return table('users')->usersInfo($owneruid);
	}

	public function getAccountByUniacid($uniacid) {
		return $this->query->from('account')->where('uniacid', $uniacid)->get();
	}

	public function getAccountExtraPermission($uniacid) {
		if (empty($uniacid)) {
			return array();
		}
		$result = $this->query->from('uni_group')->where('uniacid', $uniacid)->get();
		if (!empty($result)) {
			$result['modules'] = iunserializer($result['modules']);
			$result['templates'] = iunserializer($result['templates']);
		} else {
			$result = array();
		}
		return $result;
	}
}