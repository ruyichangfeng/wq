<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *日志信息及日志导出
 * @author 驽马壹號
 * @url http://we7.yiquanr.com
 */
 defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
load()->func('tpl');
$operation  = empty($_GPC['op'])?'display':$_GPC['op'];
if($operation=="display"){
	 	 $pindex = max(1, intval($_GPC['page']));
		$psize = 15; 
		$where ="";
		$params = array(); 
		$where .="where uniacid=:uniacid"; 
		$params[":uniacid"] = $_W['uniacid']; 
		  
		$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
		$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
		if($opt_type!="" && $keywords!=""){
			    if($opt_type=='activity_id' || $opt_type=='itemid'){
			    	  $where.=" and ".$opt_type."=".$keywords;  
			    }else{
			    	   $where.=" and ".$opt_type." like '%".$keywords."%'";  
			    }   
		} 
		$orderby = "logtime desc";
		 
		$result_array = $this->_getDataList("numa_vote_log",$where,$params,$orderby,$pindex,$psize);
	    $total = $result_array['total'];
	    $data_list = $result_array['data_list'];
	    $pager = $result_array['pager']; 
}elseif($operation=='export'){   
	   	 	$headers= array(array('OPENID','昵称','活动名','投票给','IP','省份','城市','投票时间','投票日期'));  
 			$where = array(); 
			$where['uniacid'] = $_W['uniacid']; 
			$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
			$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
			if($opt_type!="" && $keywords!=""){
				    if($opt_type=='activity_id' || $opt_type=='itemid'){
				    		$where[$opt_type] = $keywords; 
				    }else{
				    	    $where[$opt_type." like "] = "'".$keywords."'";  
				    }   
			} 
			$exp_list = array();
			$exp_list_temp =  pdo_getall("numa_vote_log",$where,array(),"","logtime desc"); 
			foreach($exp_list_temp as $k=>$v){
				 $temp=array(); 
				 //获取openid 
				 $temp[0]=$v['openid'];
				 $temp[1]=$v['username'];
				 $temp[2]="[".$v['activity_id']."]".$v['activity_title'];
				 $temp[3]="[".$v['itemid']."]".$v['item_name'];
				 //转换IP地址 
				 $temp[4]=$v['ip_str'];
				 $temp[5]=$v['province'];
				 $temp[6]=$v['city'];
				 $temp[7]=$v['logtime'];
				 $temp[8]=alinuma_toDate($v['time_key'],'Y-m-d'); 
				 $exp_list[] = $temp;
			} 
	    	//生成文件名  
	    	$order_counts = count($exp_list);   
	    	$file_name = "投票记录-".time(); 
		 	$fileurl =  IA_ROOT . '/data/tmp/'.IN_MODULE."/"; 
		 	alinuma_mkDir($fileurl);
		 	$filename =  $file_name.".xls";
		 	$fileurl = $fileurl.md5($file_name).".xls";  
		    alinuma_writeXls($fileurl,$headers,$exp_list); 	 
		    alinuma_downFile($fileurl,$filename);   
	        exit;   
} 
include $this->template("log");
?>
