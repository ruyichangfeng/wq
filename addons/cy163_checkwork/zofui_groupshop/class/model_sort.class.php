<?php 


class model_sort
{
	// 查询单条分类
	static function getSingleSort($id){
		$id = intval($id);
		return Util::getDataByCacheFirst('sort',$id,array('Util','getSingelDataInSingleTable'),array('zofui_groupshop_sort',array('id'=>$id)));
		//需删除缓存
	}
	
	//查询所有分类
	static function getAllSort(){
		return Util::getDataByCacheFirst('sort','allsort',array('Util','getAllDataInSingleTable'),array('zofui_groupshop_sort',array('uniacid'=>$_W['uniacid']),1,100,'`order` DESC'));
		//需删除缓存
	}
	
	//删除分类
	static function deleteSort($id){
		$id = intval($id);
		$res = Util::deleteData($id,'zofui_groupshop_sort');
		Util::deleteCache('sort',$id);
		Util::deleteCache('sort','allsort');		
		return $res;
	}	
	
	
}