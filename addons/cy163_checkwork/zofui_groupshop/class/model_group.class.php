<?php 


class model_group
{
	
	
	static function decodeGroupStatus($status,$overtime,$isrefund,$lastnumber){
		global $_W;		
		if($isrefund == 1){
			return 4; //组团失败退款中
		}else{
			if($status == 1 && $overtime > time() && $lastnumber > 0){
				return 1; //团购中
			}elseif(($status == 2 || $overtime < time()) && $lastnumber > 0){
				return 2; //组团失败
			}elseif($status == 3 || $lastnumber == 0){
				return 3; //组团成功
			}
		}
		return 2;
	}
	
	//判断团是否完成
	static function checkGroupIsFinished($groupid,$openid,$module){
		global $_W;
		$group = Util::getSingelDataInSingleTable('zofui_groupshop_group',array('id'=>$groupid));
		if($group['lastnumber'] <= 0){
			$res = pdo_update('zofui_groupshop_group',array('status'=>3,'finishtime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$groupid));
			pdo_update('zofui_groupshop_order',array('iscomplete'=>1),array('uniacid'=>$_W['uniacid'],'groupid'=>$groupid));
			$queue = new queue; //将待发团完成消息插入数据库
			$queue -> addMessage(4,$groupid);
		}else{
			//Message::cmessage($openid,$module,$group['overtime'],$group['lastnumber'],$group['id']); //发参团成功通知\
			$good = model_good::getSingleGood($group['gid']);
			Message::cmessage($openid,$module,$good['title'],$group['overtime'],$good['groupprice'],$group['id']);
		}
		Util::deleteCache('group',$groupid); //删除缓存
		if($res) return true; return false;
	}
	
	//查询最近团
	static function getLatelyGroup($where,$str,$page,$num,$select,$order,$isNeedpage){
		$data = Util::structWhereStringOfAnd($where,'a');
		$commonstr = tablename('zofui_groupshop_group')." AS a LEFT JOIN ".tablename('zofui_groupshop_user')." AS b ON a.`createrid` = b.`id` WHERE ".$data[0].$str;
		$countStr = "SELECT  COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT  $select FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$isNeedpage);
		return $res;
	}
	
	
	// 查询单条团购信息
	static function getSingleGroup($whereb,$groupid){
		$res = Util::getDataByCacheFirst('group',$groupid,array('model_group','getAllGroup'),array('',$whereb,'',' b.*,a.pic,a.title,a.oldprice,a.nowprice,a.groupprice ',1,1,' a.id DESC ',false));
		 return $res[0][0];
		//需删除缓存
	}
	
	
	//批量查询团购
	static function getAllGroup($wherea,$whereb,$statusstr,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($wherea,'a');
		$datab = Util::structWhereStringOfAnd($whereb,'b');
		
		$params = array_merge((array)$dataa[1],(array)$datab[1]);
		
		if(!empty($dataa[0]) && !empty($datab[0])) $datab[0] = ' AND '.$datab[0];
		
		$commonstr = tablename('zofui_groupshop_good')." AS a RIGHT JOIN ".tablename('zofui_groupshop_group')." AS b ON a.`id` = b.`gid` WHERE ".$dataa[0].$datab[0].$statusstr;
		
		$countStr = "SELECT  COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT  $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order,$isNeedpage);
		foreach($data[0] as $k=>$v){
			$pic = iunserializer($v['pic']);
			$data[0][$k]['pic'] = $pic[0];
		}
		return $data;
	}
	
	
	//批量查询团购订单
	static function getAllGroupOrder($wherea,$whereb,$statusstr,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($wherea,'a');
		$datab = Util::structWhereStringOfAnd($whereb,'b');
		
		if(!empty($statusstr)) $str = ' AND '.$statusstr;
		$params = array_merge((array)$dataa[1],(array)$datab[1]);
		
		if(!empty($dataa[0]) && !empty($datab[0])) $datab[0] = ' AND '.$datab[0];
		
		$select = $select.',c.title,c.pic,c.buynum,c.buymoney ';
		
		$commonstr = tablename('zofui_groupshop_order') ." AS a LEFT JOIN ".tablename('zofui_groupshop_group')." AS b ON a.`groupid` = b.`id` LEFT JOIN  ".tablename('zofui_groupshop_ordergood')." AS c ON c.`idoforder` = a.`id`  WHERE ".$dataa[0].$datab[0].$str ;
	
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order,$isNeedpage);
		
		return $data;
	}	
	
	//前端group页面展示成员，查询缓存 只能前端这一个地方使用，因为是按需查询
	static function getGroupMemberWithCache($groupid){
		$groupid = intval($groupid);
		$where = array('status>'=>3,'groupid'=>$groupid);
		$select = ' a.headimgurl,a.nickname,a.id AS userid,b.paytime';
		$res = Util::getDataByCacheFirst('groupmember',$groupid,array('model_group','getGroupMember'),array($where,$select,1,1000,' b.id ASC ',false));
		return $res;
	}
	
	// 查询团成员
	static function getGroupMember($where,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($where,'b');		
		$commonstr = tablename('zofui_groupshop_user') ." AS a LEFT JOIN ".tablename('zofui_groupshop_order')." AS b ON a.`id` = b.`userid`  WHERE ".$dataa[0];
		if(empty($select)) $select = ' a.*,a.status AS astatus,a.id AS userid,b.status AS bstatus,b.orderid,b.id AS bid ';
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$dataa[1],$page,$num,$order,$isNeedpage);
		return $data;
	}
	
	
	//验证是否允许参团，在ajaxdeal的提交支付和pay的重新支付里
	static function checkIsAllowJoinGroup($groupid){
		global $_W;
		$groupid = intval($groupid);
		$groupinfo = pdo_get('zofui_groupshop_group',array('uniacid'=>$_W['uniacid'],'id'=>$groupid));
		if(empty($groupinfo)) return '您要参与的团不存在';
		if($groupinfo['lastnumber'] <= 0 || $groupinfo['status'] == 3) return '您要参与的团已经满了';
		if($groupinfo['overtime'] <= time()  || $groupinfo['status'] == 2) return '您要参与的团已经结束了';
		$isingroup = model_order::getSingleOrderByStatus(array('groupid'=>$data['groupid'],'openid'=>$_W['openid']),' NOT IN (1,2) '); 
		if(!empty($isingroup)) return '您已参与过此团';
		return 1;
	}
	
}