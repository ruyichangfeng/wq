<?php 


class model_express
{
	// 查询单条模板
	static function getSingleExpress($id){
		$id = intval($id);
		return Util::getDataByCacheFirst('express',$id,array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_express',array('id'=>$id)));
		//需删除缓存
	}
	
	//查询所有模板
	static function getAllExpress(){
		return Util::getDataByCacheFirst('express','allexpress',array('Util','getAllDataInSingleTable'),array('zofui_groupshop_express',array('uniacid'=>$_W['uniacid']),1,100,'`id` DESC'));
		//需删除缓存
	}
	
	
	//删除模板
	static function deleteExpress($id){
		$id = intval($id);
		$res = Util::deleteData($id,'zofui_groupshop_express');
		Util::deleteCache('express',$id);
		Util::deleteCache('express','allexpress');		
		return $res;
	}	
	
	//计算邮费
	static function countExpressMoney($goodinfo,$buynum,$province){
		global $_W;
	
		if($goodinfo['expresstype'] == 0){		
			$expressmoney = 0;
		}elseif($goodinfo['expresstype'] == 1){
		
			$expressmoney = $goodinfo['expressmoney'] * $buynum;
		}elseif($goodinfo['expresstype'] == 2){
		
			$expressid = intval($goodinfo['expressid']);
			$expressinfo = model_express::getSingleExpress($expressid);
			
			if(empty($expressinfo)) return 0; //运费模板已被删除，直接包邮处理
			
			//计算默认邮费
			if($buynum <= $expressinfo['defaultnum']){
				$expressmoney = $expressinfo['defaultmoney'];
			}else{
				$expressmoney = $expressinfo['defaultmoney'] + ceil(($buynum - $expressinfo['defaultnum'])/$expressinfo['defaultnumex'])*$expressinfo['defaultmoneyex'];
			}
			$expressarray = iunserializer($expressinfo['expressarray']);							
			if(is_array($expressarray) && !empty($province)){					
				foreach($expressarray as $k=>$v){
					if(strpos($v['area'],$province) !== false){									
						$expressmoney = $v['money'] + ceil(($buynum - $v['num'])/$v['numex'])*$v['moneyex'];
						break;
					}
				}
			}
		}else{
			$expressmoney = 0;
		}
	
		return $expressmoney;
	}	
	
	
	//查询快递
	static function getExpressInfo($expressname,$expressnum){
	
		if( !(strpos($expressname,'顺丰') === false) ){
			$str = 'shunfeng';
		}elseif( !(strpos($expressname,'申通') === false) ){
			$str = 'shentong';
		}elseif( !(strpos($expressname,'韵达') === false) ){
			$str = 'yunda';			
		}elseif(!(strpos($expressname,'天天') === false) ){
			$str = 'tiantian';			
		}elseif( !(strpos($expressname,'圆通') === false)){
			$str = 'yuantong';			
		}elseif( !(strpos($expressname,'中通') === false)){
			$str = 'zhongtong';			
		}elseif( !(strpos($expressname,'ems') === false)){
			$str = 'ems';			
		}elseif( !(strpos($expressname,'汇通') === false)){
			$str = 'huitongkuaidi';			
		}elseif(!(strpos($expressname,'全峰') === false)){
			$str = 'quanfengkuaidi';			
		}elseif( !(strpos($expressname,'宅急') === false)){
			$str = 'zhaijisong';			
		}elseif( !(strpos($expressname,'德邦') === false)){
			$str = 'debangwuliu';			
		}
		$url = 'http://www.kuaidi.com/index-ajaxselectcourierinfo-'.$expressnum.'-'.$str.'.html'; 
		$result = Util::httpGet($url);
	
		$data = json_decode($result,true);
		if($data['success']){
			return	array('data'=>$data['data'],'status'=>1);
		}else{
			return array('data'=>$data['reason'],'status'=>0);
		}	
		
	}
	
	//返回快递码
	static function decodeExpress($expressname){
		if( !(strpos($expressname,'顺丰') === false) ){
			$str = 'SF';
		}elseif( !(strpos($expressname,'申通') === false) ){
			$str = 'STO';
		}elseif( !(strpos($expressname,'韵达') === false) ){
			$str = 'YD';			
		}elseif(!(strpos($expressname,'天天') === false) ){
			$str = 'HHTT';			
		}elseif( !(strpos($expressname,'圆通') === false)){
			$str = 'YTO';			
		}elseif( !(strpos($expressname,'中通') === false)){
			$str = 'ZTO';			
		}elseif( !(strpos($expressname,'ems') === false)){
			$str = 'EMS';			
		}elseif( !(strpos($expressname,'汇通') === false)){
			$str = 'huitongkuaidi';			
		}elseif(!(strpos($expressname,'全峰') === false)){
			$str = 'QFKD';			
		}elseif( !(strpos($expressname,'宅急') === false)){
			$str = 'ZJS';			
		}elseif( !(strpos($expressname,'德邦') === false)){
			$str = 'DBL';			
		}
		return	$str;
	}	
	
}