<?php

class CommentTableHandle {
	/*
	返回某人的点评列表
	*/
	static function getList($openid,$page,$pagesize,$mid = '') {
		global $_W;

		if($mid) 
		{
			$id_sql = " and mid=$mid ";
		}

		$begin = ($page-1)*$pagesize;
		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_comment')." where is_del='n' and comment_openid='{$openid}' and uniacid={$_W['uniacid']} $id_sql order by add_time desc limit $begin,$pagesize ");

		// 头像处理
		$u_arr = array();
		foreach($list as $item)
		{
			if(!isset($u_arr[$item['user_openid']]))
			{
				$u_arr[$item['user_openid']] = MemberTableHandle::info($item['user_openid']);
			}
			if(!isset($u_arr[$item['reply_openid']]))
			{
				$u_arr[$item['reply_openid']] = MemberTableHandle::info($item['reply_openid']);
			}
		}
		foreach ($list as $key => $item)
		{
			if(isset($u_arr[$item['user_openid']]))
			{
				$list[$key]['usericon'] = $u_arr[$item['user_openid']]['headimgurl'];
				$list[$key]['username'] = $u_arr[$item['user_openid']]['nickname'];
				$list[$key]['add_time'] = timeShortHandle($item['add_time']);
				$list[$key]['reply_user']['username'] =  $u_arr[$item['reply_openid']]['nickname'];
			}
		}
		return $list;
	}
	/*
	支持分页获取内容
	*/
	static function getAll($begin,$offset) {
		global $_W;

		return pdo_fetchall("select * from ".tablename('intelligent_kindergarten_comment')." where is_del='n'  and uniacid='{$_W['uniacid']}' order by add_time desc limit $begin,$offset");
	}
	/*
	统计总数
	*/
	static function sumNum() {
		global $_W;

		$res = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_comment')." where is_del='n' and uniacid='{$_W['uniacid']}'");
		return $res['num'];
	}

	/*
	更新操作
	*/
	static function update($data,$where) {
		
		return pdo_update('intelligent_kindergarten_comment',$data,$where);
	}
}