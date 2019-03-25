<?php 

class MomentsModel  {

	/*
	加载moments的列表，支持ajax的分页
	*/
	static  function loadMomentList($self_openid,$page,$offset=10,$openid = '',$is_del='n')
	{
		global $_W;

		$page = $page ? $page : 1;
		$begin = ($page-1)*$offset;

		// 可以用于加载个人or全体的动态
		$openid_cond =  $openid ? " and openid='$openid' " : '';

		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_moments')." where uniacid={$_W['uniacid']} $openid_cond and is_del='$is_del' order by add_time desc limit $begin,$offset");

		if($list)
		{
			foreach($list as $key=>$item)
			{
				$albumlist = array();
				if($item['type'] == 'image')
				{
					$albumlist = pdo_fetchall("select img_url from ".tablename('intelligent_kindergarten_album')." where uniacid={$_W['uniacid']} and mid='{$item['id']}' and is_del='n' order by add_time asc");
					
				}
				$list[$key]['albums'] = $albumlist;
				// 构造时间
				$list[$key]['add_time'] = timeShortHandle($item['add_time']);
				// 归属
				if($item['openid'] == $self_openid)
				{
					$list[$key]['belong_type'] = 'self';
				}
				else
				{
					$list[$key]['belong_type'] = 'other';	
				}
				// 统计点评次数
				$comment_count = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_comment') ." where is_del='n' and uniacid={$_W['uniacid']} and mid={$item['id']}");
				$list[$key]['comment_count'] = $comment_count['num'];
			}
			
		}

		return $list;
	}

	/*
	获取详细信息
	*/
	static function info($id) {
		global $_W;
		static $infos;
		if(!isset($infos[$id])) {
			$infos[$id] = pdo_fetch("select * from ".tablename('intelligent_kindergarten_moments') ." where is_del='n' and uniacid='{$_W['uniacid']}' and id='$id'");
		}
		return $infos[$id];
	}
	/*
	获取moments的详情，包括图片和点评次数
	*/
	static function detail($id)
	{
		global $_W;

		$info = self::info($id);
		if($info['type'] == 'image')
		{
			$albumlist = pdo_fetchall("select img_url from ".tablename('intelligent_kindergarten_album')." where uniacid={$_W['uniacid']} and mid='{$info['id']}' and is_del='n' order by add_time asc");
		}
		$info['albums'] = $albumlist;
		$info['add_time'] =  timeShortHandle($info['add_time']);
		// 统计点评次数
		$comment_count = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_comment') ." where is_del='n' and uniacid={$_W['uniacid']} and mid=$id");

		$info['comment_count'] = $comment_count['num'];

		return $info;
	}

	// 加载最新的几条moments
	static function loadMoments($openid)
	{
		global $_W;

		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_moments')." where uniacid={$_W['uniacid']} and openid='$openid' and is_del='n' order by add_time desc limit 10");

		if($list)
		{
			foreach($list as $key=>$item)
			{
				$albumlist = array();
				if($item['type'] == 'image')
				{
					$albumlist = pdo_fetchall("select img_url from ".tablename('intelligent_kindergarten_album')." where uniacid={$_W['uniacid']} and mid='{$item['id']}' and is_del='n' order by add_time asc");
					
				}
				$list[$key]['albums'] = $albumlist;
				$list[$key]['add_time'] = timeShortHandle($item['add_time']);
			}
		}

		return $list;
	}

	/*
	统计所有的点评数量
	*/ 
	static function sumNums($is_del ='n',$openid='') 
	{
		if($openid) {
			$sql = " and openid='$openid' ";
		}
		$res = pdo_fetch("select count(*) as num from ".tablename('intelligent_kindergarten_moments')." where 1=1 $sql and is_del='$is_del'");

		return $res['num'];
	}

	/*
	删除某条记录
	*/
	static function delete($mid) 
	{
		global $_W;

		return pdo_update("intelligent_kindergarten_moments",array('is_del'=>'y'),array('uniacid'=>$_W['uniacid'],'id'=>$mid));
	}

	/*
	还原动态
	*/
	static function restore($mid) 
	{
		global $_W;

		return pdo_update("intelligent_kindergarten_moments",array('is_del'=>'n'),array('uniacid'=>$_W['uniacid'],'id'=>$mid));
	}

	/*
	加载最新的列表
	*/
	static function getNewList($begin,$offset) {
		global $_W;
		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_moments')." where uniacid={$_W['uniacid']}  and is_del='n' order by add_time desc limit $begin,$offset");
		foreach($list as &$value)
		{
			$uinfo = MemberModel::info($value['openid']);
			$value['uinfo'] = $uinfo;
			$albumlist = array();
			if($value['type'] == 'image')
			{
				$albumlist = pdo_fetchall("select img_url from ".tablename('intelligent_kindergarten_album')." where uniacid={$_W['uniacid']} and mid='{$value['id']}' and is_del='n' order by add_time asc");
				
			}
			$value['albums'] = $albumlist;
		}

		return $list;
	}
	/*
	热门帖子
	*/
	static function getHotList($begin,$offset) {
		global $_W;
		// $date = date("Y-m-d H:i:s",strtotime('-1 week'));
		$list = pdo_fetchall("select distinct(mid) from ".tablename('intelligent_kindergarten_comment')." where uniacid={$_W['uniacid']}  and is_del='n' limit $begin,$offset");


		foreach($list as &$value)
		{
			$minfo = self::info($value['mid']);
			$uinfo = MemberModel::info($minfo['openid']);
			$albumlist = array();
			if($minfo['type'] == 'image')
			{
				$albumlist = pdo_fetchall("select img_url from ".tablename('intelligent_kindergarten_album')." where uniacid={$_W['uniacid']} and mid='{$minfo['id']}' and is_del='n' order by add_time asc");
				
			}
			$value['albums'] = $albumlist;
			$value['uinfo'] = $uinfo;
			$value['minfo'] = $minfo;
		}
		return $list;
	}
}