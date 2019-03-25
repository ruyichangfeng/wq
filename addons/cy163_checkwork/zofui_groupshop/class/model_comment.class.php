<?php 

class model_comment {
	
	
	//查询所有评价
	static function getAllComment($where,$page,$num,$order,$isNeedpage,$select){
		global $_W;
		$data = Util::structWhereStringOfAnd($where,'a');
		
		$commonstr = tablename('zofui_groupshop_comment') ." AS a LEFT JOIN ".tablename('zofui_groupshop_good')." AS b ON a.`gid` = b.`id` WHERE ".$data[0].$str ;
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select,b.pic AS gpic,a.pic as cpic FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$isNeedpage);
		foreach($res[0] as $k=>$v){
			$pic = iunserializer($v['gpic']);
			$res[0][$k]['gpic'] = $pic[0];
		}
		return $res;
	}
	
	
	
	
	
}