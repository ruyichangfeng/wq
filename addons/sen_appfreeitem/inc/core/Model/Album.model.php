<?php

/*
图片表操作类
*/

class AlbumTableHandle {
	/*
	返回指定数量的照片，并且按照$offset进行分片
	*/
	static function getSliceList($openid,$num,$offset=4) {
		global $_W;
		$list = pdo_fetchall("select * from ".tablename('intelligent_kindergarten_album')." where openid='{$openid}' and is_del='n' and uniacid={$_W['uniacid']} order by add_time desc limit $num");
		// 截取4的倍数
		if(count($list)%4 != 0) 
		{
			$list = array_slice($list,0, count($list) - count($list)%4);
		}
		return $list;
	}

	/*
	
	*/
}