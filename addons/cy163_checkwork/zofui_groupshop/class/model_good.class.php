<?php 

class model_good
{
	
	//判断商品是否可购买
	static function checkIsCanBuyThisGood($gid,$buynumber,$verifystock = true){	
		global $_W;	
		$goodinfo = model_good::getSingleGood($gid);
		if(empty($goodinfo)) return '当前商品不存在'; //商品不存在
		if($goodinfo['status'] == 1) return '商品已经下架了';  //已经下架
		if($verifystock && $goodinfo['stock'] < $buynumber) return '商品库存不足'; //没有库存了
		if($goodinfo['stock'] < $buynumber) return '商品库存不足'; //没有库存了
		if($goodinfo['maxallow'] >0 && $buynumber > $goodinfo['maxallow']) return '商品最多下单'.$goodinfo['maxallow'].'件';
		
		//是否限购
		if($goodinfo['limitbuy'] == 1){
			$time = time() - $goodinfo['limittime']*3600*24;
			
			$buyednumber = pdo_fetchall("SELECT SUM(b.buynum) AS totalbuy FROM ".tablename('zofui_groupshop_order')." AS a INNER JOIN ".tablename('zofui_groupshop_ordergood')." AS b ON a.`id` = b.`idoforder` WHERE a.`status` NOT IN (1,2) AND a.`uniacid` = :uniacid AND a.`openid` = :openid AND a.`createtime` >= :createtime AND b.`gid` = :gid ",array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid'],':createtime'=>$time,':gid'=>$gid));
			
			$nownumber = intval($buyednumber[0]['totalbuy']);
			
			$canbuy = ($goodinfo['limitnum'] - $nownumber) <= 0 ? 0 : $goodinfo['limitnum'] - $nownumber;
			if($nownumber + $buynumber > $goodinfo['limitnum']) return '商品限购，目前您能购买'. $canbuy.'件';
		}
		
		return 1;
	}
	
	static function getGoodCommentNumber($gid){
		$data = Util::getCache('commentnumber',$gid);
		if(empty($data)){
			$data['good'] = Util::countDataNumber('zofui_groupshop_comment',array('uniacid'=>$_W['uniacid'],'gid'=>$gid,'level'=>1,'status'=>0));
			$data['soso'] = Util::countDataNumber('zofui_groupshop_comment',array('uniacid'=>$_W['uniacid'],'gid'=>$gid,'level'=>2,'status'=>0));
			$data['bad'] = Util::countDataNumber('zofui_groupshop_comment',array('uniacid'=>$_W['uniacid'],'gid'=>$gid,'level'=>3,'status'=>0));
			$data['all'] = 	$data['good'] + $data['soso'] + $data['bad'];
			util::setCache('commentnumber',$gid,$data);
		}
		return $data;
	}
	
	//编辑删除商品时候改变装修的页面商品
	static function editGoodWithEditPage($gid,$type,$module){
		$gid = intval($gid);
		global $_W;
		$page = Util::getAllDataInSingleTable('zofui_groupshop_custom',array('uniacid'=>$_W['uniacid']),1,500,'id DESC',false,' * ');
		foreach($page[0] as $k=>$v){
			$params = iunserializer($v['params']);
				
			$ischange = 0; //是否更新了商品标识
			foreach($params as $kk => $vv){
				if($vv['temp'] == 'goods1'){
					foreach($vv['data'] as $kkk => $vvv){
						
						if($vvv['gid'] == $gid){

							if($type == 'edit'){
								$good = self::getSingleGood($gid);
								//var_dump($params[$kk]['data'][$kkk]);
								$params[$kk]['data'][$kkk]['img'] = tomedia($good['pic'][0]);
								$params[$kk]['data'][$kkk]['title'] = $good['title'];
								$params[$kk]['data'][$kkk]['price'] = $good['groupprice'];
								$params[$kk]['data'][$kkk]['groupnum'] = $good['groupnum'];
								
								if($module->module['config']['shoptype'] == 2){
									$params[$kk]['data'][$kkk]['price'] = $good['nowprice'];
								}else{
									$params[$kk]['data'][$kkk]['price'] = $good['groupprice'];
								}									
								$params[$kk]['data'][$kkk]['oldprice'] = $good['oldprice'];
								
								//var_dump($params[$kk]['data'][$kkk]);
							}elseif($type == 'delete'){
								unset($params[$kk]['data'][$kkk]);
							}
							$ischange = 1; //改为1说明改变了。
						}
						
					}
				}
			}
			//对商品进行了改变再更新
			if($ischange == 1){

				pdo_update('zofui_groupshop_custom',array('params' => iserializer($params),'time'=>time()),array('id'=>$v['id'],'uniacid'=>$_W['uniacid']));
				if($v['status'] == 0) Util::deleteCache('custompage','index');
				Util::deleteCache('custompage',$v['id']);
			}
		}
	}
	
	// 查询单条商品
	static function getSingleGood($id){
		$id = intval($id);
		$goodinfo = Util::getDataByCacheFirst('good',$id,array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_good',array('id'=>$id,'status'=>0,'isdust'=>0)));
		if(empty($goodinfo)) return array();
		return self::initSingleGoodPro($goodinfo);
		//需删除缓存
	}
	
	
	// 查询多条商品
	static function getAllGood($where,$page,$num,$order='`order` DESC'){
		$goodinfo = Util::getAllDataInSingleTable('zofui_groupshop_good',$where,$page,$num,$order);
		foreach($goodinfo[0] as $k=>$v){
			$newgoodinfo[$k] = self::initSingleGoodPro($v);
		}
		return array($newgoodinfo,$goodinfo[1],$goodinfo[2]);
	}	
	
	//前端查询多条商品
	static function getAllGoodInAppWithSort($where,$page,$num,$order='`order` DESC'){
		
		//没有分类，查询全部。
		if(empty($where['sortid'])){
			$data = Util::getAllDataInSingleTable('zofui_groupshop_good',$where,$page,$num,$order,false,'id,nowprice,oldprice,groupprice,pic,title,groupnum,sales');
		}else{
			$temp = $where['sortid'];
			unset($where['sortid']);
			$res = Util::structWhereStringOfAnd($where,'a');
			$res[0] .= ' AND b.`sortid` = :sortid';
			$res[1][':sortid'] = $temp;
		
			$select = ' a.nowprice,a.oldprice,groupprice,a.pic,a.title,a.id,a.groupnum,a.sales';
			$selectStr = "SELECT $select FROM ".tablename('zofui_groupshop_good') ." AS a LEFT JOIN ".tablename('zofui_groupshop_goodsort') ." AS b ON a.`id` = b.`gid` WHERE ".$res[0];
			$data = Util::fetchFunctionInCommon('',$selectStr,$res[1],$page,$num,$order,false);			
		}
		return $data;	
	}	

	
	//转化商品图片等
	static function initSingleGoodPro($goodinfo){
		$goodinfo = $goodinfo;
		$goodinfo['pic'] = iunserializer($goodinfo['pic']);
		$goodinfo['rulearray'] = iunserializer($goodinfo['rulearray']);
		$goodinfo['params'] = iunserializer($goodinfo['params']);
		$goodinfo['inco'] = iunserializer($goodinfo['inco']);		
		$goodinfo['sort'] = self::getGoodSort($goodinfo['id']);
		
		return $goodinfo;
	}
	
	//查询商品分类
	static function getGoodSort($gid){
		$sortinfo = Util::getAllDataInSingleTable('zofui_groupshop_goodsort',array('gid'=>$gid),1,50);	
		foreach($sortinfo[0] as $k=>$v){
			$array[$k] = $v['sortid'];
		}
		return $array;
	}
	
	//处理商品规格
	static function decodeGoodRule($rulearray){
		if(empty($rulearray)) return false;
		if(empty($rulearray[0]['nowprice'])){ //不同价格的规格
			foreach($rulearray as $k=>$v){
				$data[$k]['name'] = $v['name'];
				$str = trim($v['pro'],',');
				$data[$k]['pro'] = explode(',',$str);
			}
		}else{
			foreach($rulearray as $k=>$v){
				$data[$v['name']] = array('nowprice'=>$v['nowprice'],'groupprice'=>$v['groupprice']);
			}			
		}
		return $data;
	}
	
	//验证购买的规格是否在商品规格内
	static function  checkBuyRuleIsInGoodRule($ruletype,$buyrule,$goodrule){
		if(!is_array($goodrule)) $goodrule = iunserializer($goodrule);
		if(empty($buyrule)) return true; //没有选择规格
		if($ruletype == 0) return false; //商品是无规格的		
		if($ruletype == 1){ //相同规格
			$num = count($buyrule);
			$flag = 0;
			foreach($goodrule as $k=>$v){
				$value = explode(',',trim($v['pro'],','));
				foreach($buyrule as $kk => $vv){
					if($v['name'] == $kk && in_array($vv,$value)) $flag ++;
				}
			}
			if($num == $flag) return true;
		}elseif($ruletype == 2){ //不同价规格
			$flag = 0;
			foreach($goodrule as $k=>$v){
				if($v['name'] == $buyrule['name']){
					$flag = 1;
					break;
				}
			}
			if($flag == 1) return true;
		}
		return false;
	}	
	
	//返回所选商品规格价格 rulearray必须是经过处理的。
	static function getGoodPriceInRule($goodinfo,$buytype,$rulename = ''){

		if($goodinfo['ruletype'] == 0 || $goodinfo['ruletype'] == 1){
			if($buytype == 'single' || $buytype == 'cart') $price = $goodinfo['nowprice'];
			if($buytype == 'group' || $buytype == 'joingroup') $price = $goodinfo['groupprice'];
		}elseif($goodinfo['ruletype'] == 2){
			$pricearray =$goodinfo['rulearray'][$rulename];
			if($buytype == 'single' || $buytype == 'cart') $price = $pricearray['nowprice'];
			if($buytype == 'group' || $buytype == 'joingroup') $price = $pricearray['groupprice'];
		}
		return $price;
	}
	
	//返回选购的规格，用于在页面展示，返回字符串。 在确认订单，购物车页面需要
	static function getGoodRuleToView($goodruletype,$buyrule){
		if($goodruletype == 1){
			foreach($buyrule as $kk=>$vv){
				$rule .= $kk.':'.$vv.' , ';
			}
			$rule = trim($rule,', ');
		}elseif($goodruletype == 2){
			$rule = $buyrule['name'];
		}else{
			$rule = '默认';
		}
		return $rule;
	}	
	
}


