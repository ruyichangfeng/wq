<?php

/*
成长值
*/
class GrowthTableHandle {
	/*
	添加成长值
	*/
	static function add($openid,$score,$intro) {
		global $_GPC,$_W;

		//  每天只能增加一次成长值
		$add_date = date('Y-m-d');
		$log = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_growth')." where add_date=:add_date and openid=:openid and uniacid={$_W['uniacid']}",array(':openid'=>$openid,':add_date'=>$add_date));

		if($log['num'])
		{
			return false;
		}
		pdo_begin();
		// 获取用户信息
		$info = MemberTableHandle::info($openid);

		if(!$info)
		{
			pdo_rollback();
			return false;
		}
		
		$data = array();
		$data['uniacid'] = $_W['uniacid'];
		$data['openid'] = $openid;
		$data['score'] = $score;
		$data['intro'] = $intro;
		$data['add_date'] = date("Y-m-d");
		$data['add_time'] = date("Y-m-d H:i:s");

		// 写入记录表
		$res = pdo_insert('intelligent_kindergarten_growth',$data);
		if(!$res)
		{
			pdo_rollback();
			return false;
		}

		$update = array();
		$update['growth_score'] = $info['growth_score'] + $score;

		$where = array();
		$where['openid'] = $openid;
		$where['uniacid']= $_W['uniacid'];

		// 更新成长值
		$res = pdo_update('intelligent_kindergarten_member',$update,$where);
		if(!$res)
		{
			pdo_rollback();
			return false;
		}

		pdo_commit();
		return true;
	}

	
	// 成长值排行榜
	static function getGrowthRanking($begin = 0,$limit = 100)
	{
		global $_W;
		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_member')." where uniacid={$_W['uniacid']} order by growth_score desc limit $begin ,$limit");

		return $list;
	}

}