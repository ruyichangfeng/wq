<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *	选手报名信息
 * @author 驽马壹號
 * @url http://we7.yiquanr.com
 */
 defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
load()->func('tpl');
$operation  = empty($_GPC['op'])?'display':$_GPC['op'];
if($operation=="display"){
	            $type = empty($_GPC['type'])?-1:intval($_GPC['type']);
	            
				$pindex = max(1, intval($_GPC['page']));
				$psize = 15; 
				$where ="";
				$params = array(); 
				$where .="where uniacid=:uniacid "; 
				$params[":uniacid"] = $_W['uniacid']; 
				if($type!=-1){
					$where .=" and status=:status";
					$params[":status"] = $type;
				}  
				$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
				$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
				if($opt_type!="" && $keywords!=""){
					    if($opt_type=='activity_id' || $opt_type=='no'){
					    		  $where.=" and ".$opt_type."=".$keywords;  
					    }else{
					    	   $where.=" and ".$opt_type." like '%".$keywords."%'";  
					    }    
				}
				
				$orderby = "addtime desc";
				
				$result_array = $this->_getDataList("numa_vote_item_bm",$where,$params,$orderby,$pindex,$psize);
			    $total = $result_array['total'];
			    $data_list = $result_array['data_list']; 
			    $pager = $result_array['pager'];  
			    include $this->template("baoming");
}elseif($operation=='post'){//选手信息查看
		$id = intval($_GPC['id']);
		$aid = intval($_GPC['aid']);
		if($aid && $id){
				  $activity = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$aid));
				  if(empty($activity)){
				 			message("查询活动信息失败!",$this->createWebUrl("baoming"),"info");
				  }
				  //获取扩展字段信息
				  $fields = pdo_getall("numa_vote_fields",array("uniacid"=>$_W['uniacid'],"activity_id"=>$aid));
				  
		 	 	  $item = pdo_get("numa_vote_item_bm",array("uniacid"=>$_W['uniacid'],"id"=>$id,"activity_id"=>$aid));
				  if(empty($item)){
				 			message("查询选手报名信息失败!",$this->createWebUrl("baoming"),"info");
				   }
				  $extend_values = json_decode($item['extend_fields'],true);  
		}else{
			 	message("缺少必要参数!",$this->createWebUrl("baoming"),"error");
		} 
		include $this->template("baoming");
}elseif($operation=='deal'){//选手报名处理 
 		if($_W['isajax']==1){//如果是处理
				$id = intval($_GPC['id']);
				$aid = intval($_GPC['aid']);
				if($aid && $id){
						  $activity = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$aid));
						  if(empty($activity)){
						 			message("查询活动信息失败!",$this->createWebUrl("baoming"),"error");
						  }
						  //获取扩展字段信息
						  $fields = pdo_getall("numa_vote_fields",array("uniacid"=>$_W['uniacid'],"activity_id"=>$aid));
						  
				 	 	  $item = pdo_get("numa_vote_item_bm",array("uniacid"=>$_W['uniacid'],"id"=>$id,"activity_id"=>$aid));
						  if(empty($item)){
						 			message("查询选手报名信息失败!",$this->createWebUrl("baoming"),"error");
						   }  
					  	 //1、生成item信息 
						 $insertData = array();
						 $insertData["uniacid"] = $_W['uniacid'];
						 $insertData['activity_id'] = $item['activity_id'];
						 $insertData['activity_title'] = $activity['title']; 
						 $insertData['name'] = $item['name'];
						 $insertData['mobile'] = $item['mobile']; 
						 $insertData['desc'] = $item['desc'];
						 $insertData['pics'] = $item['pics'];
						 $insertData['thumb'] = $item['thumb'];
						 $insertData['addtime'] = alinuma_toDate(time(),'Y-m-d H:i:s');
						 $insertData['extend_fileds'] = $item['extend_fields'];
						 $insertData['openid'] = $item['openid'];
						 
						 $sql = "select count(*),max(no) from ".tablename("numa_vote_item")." where uniacid=:uniacid and activity_id=:activity_id";
					   	 $max_num = pdo_fetchcolumn($sql,array(":uniacid"=>$_W['uniacid'],":activity_id"=>$aid),1);
					   	 if(empty($max_num)){
					   	     $insertData['no'] = 1;
					     }else{
					   	     $insertData['no'] = $max_num+1;
					     } 
					     
						 $result_code = pdo_insert("numa_vote_item",$insertData);
						 if(false !== $result_code){
						 			$insertid = pdo_insertid();
								 	//回写报名信息//2、置状态 
								 	$updateData = array(); 
									$updateData['itemid'] = $insertid;
									$updateData['no'] =  $insertData['no']; 
									$updateData['status'] = 1;
									$updateData['update_time'] = alinuma_toDate(time()); 
									pdo_update("numa_vote_item_bm",$updateData,array("id"=>$id,"uniacid"=>$_W['uniacid']));
									message("处理成功!",$this->createWebUrl("baoming"),"success"); 
						 }else {
						 			message("处理失败!",$this->createWebUrl("baoming"),"error"); 
						 }  
				     }else{
				     	   message("缺少必要参数!",$this->createWebUrl("baoming"),"error");
				     }
      } 
}elseif($operation=='delete'){//删除选手报名
	    $id = intval($_GPC['id']);
	   	if($id){
	   		    $item = pdo_get("numa_vote_item_bm",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    if(empty($item)){
	   		    	   message("要删除的报名不存在!",$this->createWebUrl("baoming"),"error");
	   		    }else{  
	   		    	  if($item['status']==1){
	   		    	  		message("已报名成功，不能删除",$this->createWebUrl("baoming"),"error");
	   		    	  }
	   		    	  $rtn_code = pdo_delete("numa_vote_item_bm",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    	  if(false!==$rtn_code){  
	   		    	  		   message("报名信息删除成功!",$this->createWebUrl("baoming"),"success");
	   		    	  }else{
	   		    	    	   message("报名信息删除失败!",$this->createWebUrl("baoming"),"error");
	   		    	  }
	   		    }
	   	}else{
	   		   message("链接有误，缺少必要的参数!",$this->createWebUrl("baoming"),"error");
	   	}
}  
?>