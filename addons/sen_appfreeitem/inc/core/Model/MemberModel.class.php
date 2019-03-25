<?php

/*
用户表
*/
class MemberModel {
	/*
	用于对数组列表的拼接，直接拼接uinfo节点为用户信息
	*/
	static function listJoin($list,$openid_name = 'openid') {
		global $_W;
		foreach($list as &$item) {
			$item['uinfo'] = self::info($item[$openid_name]);
		}

		return $list;
	}
	/*
	获取用户信息
	*/
	static function info($openid) {
		global $_W;
		static $infos = array();
		if(!isset($infos[$openid])) {
			$infos[$openid] = pdo_fetch("select * from ".tablename('intelligent_kindergarten_member')." where uniacid={$_W['uniacid']} and openid='$openid'");
		}
		return $infos[$openid];
	}
	/*
	更新用户的notice_times，置为0
	*/
	static function flushNoticeTimes($openid) {
		global $_W;
		pdo_update('intelligent_kindergarten_member',array('update_time'=>date('Y-m-d H:i:s'),'notice_times'=>0),array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
	}
	/*
	用户总量计算
	*/
	static function sumCounts() {
		global $_W;
		static $counts;
		if(!$counts) {
			$res = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_member')." where uniacid={$_W['uniacid']}");	
			$counts = $res['num'];
		}

		return $counts;
	}

	/*
	返回今日新增数量
	*/
	static function todayAddNum() {
		global $_W;
		static $num;

		if(!$num) {
			$res = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_member')." where add_time>:today and uniacid={$_W['uniacid']}",array(':today'=>date("Y-m-d")));
			$num = $res['num'];
		}

		return $num;
	}

	/*
	用户列表加载
	*/
	static function userList($openid,$sex = '',$begin = 0,$offset = 32) {
		global $_W;

		$sql =  $sex ? " and  sex='$sex' " : '';

		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_member')." where 1=1 and uniacid={$_W['uniacid']} $sql order by update_time desc limit $begin,$offset");

		return $list;
	}

	/*
	按照距离筛选用户
	*/
	static function nearbyList($openid,$begin = 0,$offset = 20) {

		global $_W;
		$info = self::info($openid);

		$list = pdo_fetchall("select *,ABS({$info['lng']}-lng) as lng_d,ABS({$info['lat']}-lat) as lat_d from ".tablename('intelligent_kindergarten_member')." where openid<>'$openid' and lat<>'' and lng<>'' and sex='{$info['choose_sex']}'  and isvisible='open' and uniacid={$_W['uniacid']} order by lng_d+lat_d asc limit $begin,$offset");

		return $list;
	}

	// 花月用户信息表写入
	// 由于历史原因，导致uid值写入一次，不在跟随用户信息变化！其唯一性和uid一样。可以保证其他的逻辑不在改动
	static function appMember($userinfo)
	{
		global $_W;
		// 性别未知  处理为 女
		if($userinfo['sex'] === '0' || $userinfo['sex'] === 0)
		{
			$userinfo['sex'] = 2;
		}

		$data = array();
		$data['openid'] = $userinfo['openid'];
		$data['nickname'] = $userinfo['nickname'];
		$data['sex'] = $userinfo['sex'];
		$data['province'] = $userinfo['province'];
		$data['city'] = $userinfo['city'];
		$data['country'] = $userinfo['country'];
		$data['headimgurl'] = $userinfo['avatar'];
		$data['uniacid'] = $_W['uniacid'];
		$data['acid'] = $_W['account']['acid'];
		$data['account'] = $_W['account']['name'];
		$data['add_time'] = date("Y-m-d H:i:s");
		$data['age'] = '';
		$data['isvisible'] = 'open'; // 首次写入，默认开启对附近可见

		// 待查看性别对象
		if($data['sex'] == 2)
		{
			$data['choose_sex'] = 1;
		}
		else
		{
			$data['choose_sex'] = 2;
		}

		$info = self::info($userinfo['openid']);

		if($info)
		{
			$new_info = array();

			unset($data['headimgurl']);
			unset($data['isvisible']);
			unset($data['nickname']);
			unset($data['update_time']);
			unset($data['add_time']);
			unset($data['age']);
			$data['update_time'] = date("Y-m-d H:i:s");
			$r = self::update($data,array('openid'=>$userinfo['openid'],'uniacid'=>$_W['uniacid']));
			if($r === false)
			{
				exit('update error');
			}
		}
		else
		{
			$res = pdo_insert('intelligent_kindergarten_member',$data);
			if($res === false)
			{
				exit(' insert error');
			}
		}
	}

	/*
	加载用户列表，支持筛选、分页、性别
	*/
	static function searchList($keyword='',$cond = array(),$begin=1,$offset=20,$sort_type,$sort_val) {
		global $_W;
		$sql = '';
		// 拆解搜索条件
		if($cond) {
			foreach($cond as $k=>$v) {
				$sql .= " and $k = '$v' ";
			}
		}
		// 排序条件
		if($sort_type && $sort_val) {
			$sort_cond = " order by $sort_type $sort_val ";
		}else {
			$sort_cond = " order by update_time desc ";
		}

		// 模糊搜索
		if($keyword) {
			$sql .= " and nickname like '%$keyword%' ";
		}

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_member')." where 1=1 $sql and uniacid={$_W['uniacid']} $sort_cond limit $begin,$offset");
	}

	/*
	根据搜索条件来统计数量
	*/
	static function searchListCounts($keyword='',$cond = array(),$begin=1,$offset=20) {
		global $_W;
		$sql = '';
		// 拆解搜索条件
		if($cond) {
			foreach($cond as $k=>$v) {
				$sql .= " and $k = '$v' ";
			}
		}

		// 模糊搜索
		if($keyword) {
			$sql .= " and nickname like '%$keyword%' ";
		}
		
		$res =  pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_member')." where 1=1 $sql and uniacid={$_W['uniacid']}");
		return $res['num'];
	}


	// ========= 基本操作

	/*
	更新
	*/
	static function update($data,$where) {
		global $_W;

		$r = pdo_update('intelligent_kindergarten_member',$data,$where);

		return $r;
	}

	static function updateUserInfo($openid,$userinfo) {
		global $_W,$_GPC;

		return pdo_update('intelligent_kindergarten_member',$userinfo,array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
	}

	/*
	收到打赏，使用事务进行+操作
	*/
	static function addMoney($openid,$money) {
		global $_W;
		if(!$money) {
			return false;
		}
		pdo_begin();
		$r = pdo_fetch("select * from ".tablename('intelligent_kindergarten_member')." where uniacid='{$_W['uniacid']}' and openid='$openid' for update");
		if(!$r) {
			pdo_rollback();
			return false;
		}
		$avaliable_money = $r['avaliable_money'] + $money;
		$r = pdo_update('intelligent_kindergarten_member',array('avaliable_money'=>$avaliable_money),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
		if(!$r) {
			pdo_rollback();
			return false;
		}
		pdo_commit();
		return true;
	}

	/*
	申请提现的操作
	外层已经开启事务，所以方法中只需要for update
	*/
	static function drawMoney($openid,$money) {
		global $_W;
		if(!$money) {
			return false;
		}
		$r = pdo_fetch("select * from ".tablename('intelligent_kindergarten_member')." where uniacid='{$_W['uniacid']}' and openid='$openid' for update");
		if(!$r) {
			return false;
		}
		$avaliable_money = $r['avaliable_money'] - $money;
		$draw_money = $r['draw_money'] + $money;
		$r = pdo_update('intelligent_kindergarten_member',array('avaliable_money'=>$avaliable_money,'draw_money'=>$draw_money),array('uniacid'=>$_W['uniacid'],'openid'=>$openid));
		if(!$r) {
			return false;
		}
		return true;
	}

}