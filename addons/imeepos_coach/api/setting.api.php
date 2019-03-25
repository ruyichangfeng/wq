<?php

class settingApi{
	public function settingIndex(){
		global $_W,$_GPC;

		$advs = M('advs')->getall(array('position'=>'adv'));

		$data = array(
			'title'=>'首页1',
			'advs'=>$advs
		);
		return $data;
	}

	public function advClick($id){
		global $_W,$_GPC;
		// ini_set("display_errors", "On");
		// error_reporting(E_ALL | E_STRICT);
		$adv = M('advs')->getInfo($id);
		$member = M('member')->getInfo($_W['openid']);
		//点击奖励
		$sum = floatval($adv['credit_sum']);
		$click = floatval($adv['credit']);
		//检查是否点击过
		$canClick = M('advs_log')->check($_W['openid']);
		if(($sum >= $click) && $canClick){
			$adv['credit_sum'] = $sum - $click;
			M('advs')->update($adv);
			//增加积分
			$member['credit'] = floatval($member['credit']) + $click;
			M('member')->update_or_insert($member);
			//插入纪录
			$data = array();
			$data['uniacid'] = $_W['uniacid'];
			$data['openid'] = $_W['openid'];
			$data['credit'] = $credit;
			$data['adv_id'] = $id;
			$data['create_time'] = time();
			M('advs_log')->update($data);
		}

		if($sum < $click){
			$adv['status'] = 0;
			M('advs')->update($adv);
		}
	}
}