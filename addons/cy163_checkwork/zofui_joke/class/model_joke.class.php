<?php 

class model_joke {


	static function getAllJoke(){
		global $_W;
		//$cache = Util::getCache('joke','all');

		if( empty( $cache ) ){

			$where = array('uniacid'=>$_W['uniacid']);
			$data = Util::getAllDataInSingleTable('zofui_joke_joke',$where,1,1111111,'`total` DESC',false,false,'*,falsenum + num AS total');
			$cache = $data[0];
			Util::setCache('joke','all',$cache);
		}
		return $cache;
	}

	
	
	static function getAllDraw($where,$page,$num,$order,$iscache,$pager,$select,$str=''){
		global $_W;
		
		$data = Util::structWhereStringOfAnd($where,'a');
		$commonstr = tablename('zofui_timeredbag_draw') ." AS a LEFT JOIN ".tablename($table)." AS b ON a.`openid` = b.`openid`  WHERE ".$data[0];
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$iscache,$pager,$str);
		if( is_array($res[0]) && $table == 'mc_mapping_fans'){
			foreach ($res[0] as $k => &$v) {
				$tag = iunserializer( base64_decode( $v['tag'] ) );
				$v['headimgurl'] = $tag['headimgurl'];
			}
		}
		return $res;

	}	

}