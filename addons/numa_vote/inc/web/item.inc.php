<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *选手信息及选手导出及单个选手日志导出
 * @author 驽马壹號
 * @url http://we7.yiquanr.com
 */
 defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
load()->func('tpl');
$operation  = empty($_GPC['op'])?'display':$_GPC['op'];
$muti_params = array("multiple"=>5,"preview"=>1);
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
					    if($opt_type=='activity_id' || $opt_type=='no'){
					    	  $where.=" and ".$opt_type."=".$keywords;  
					    }else{
					    	   $where.=" and ".$opt_type." like '%".$keywords."%'";  
					    } 
				}
				$sort = $_GPC['sort'];
				$orderby = "addtime desc";
				if($sort==1){
					 $orderby = "num desc";
				}elseif($sort==2){
					 $orderby = "no asc";
				}
				$result_array = $this->_getDataList("numa_vote_item",$where,$params,$orderby,$pindex,$psize);
			    $total = $result_array['total'];
			    $data_list = $result_array['data_list'];
			    $pager = $result_array['pager']; 
}elseif($operation=='post'){//选手新增编辑
		$id = intval($_GPC['id']);
		$aid = intval($_GPC['aid']);
		if($aid){
				 $activity = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$aid));
				 if(empty($activity)){
				 			message("查询活动信息失败!",$this->createWebUrl("vote"),"info");
				 }
				 //获取扩展字段信息
				 $fields_temp = pdo_getall("numa_vote_fields",array("uniacid"=>$_W['uniacid'],"activity_id"=>$aid));
				 $fields = array();
				 if(!empty($fields_temp)){
				 	  foreach($fields_temp as $k=>$field){
				 	  	     $options = array();
				 	  		 if(in_array($field['type'],array("radio","checkbox","select"))){
				 	  		 	   $options_temp = explode("|",$field['options']); 
				 	  		 	   if(!empty($options_temp)){
				 	  		 	   			foreach($options_temp as $opt){
				 	  		 	   					$temp = explode(",",$opt);
				 	  		 	   					$options[$temp[0]]=$temp[1];
				 	  		 	   			}
				 	  		 	   } 
				 	  		 }
				 	  		 $field['options'] = $options; 
				 	  		 $fields[] = $field;
				 	  }
				 }
				 if($id){
				 	 	$item = pdo_get("numa_vote_item",array("uniacid"=>$_W['uniacid'],"id"=>$id,"activity_id"=>$aid));
						 if(empty($item)){
						 	 message("查询选手信息失败!",$this->createWebUrl("vote"),"info");
						 }
						 $extend_values = json_decode($item['extend_fileds'],true);
				 }else{
				 	     $item = array(); 
				 }
				  if(checksubmit("submit")){//提交保存
							if(empty($_GPC['name'])){
									message("填写选手姓名!",$this->createWebUrl("item",array("id"=>$id,"aid"=>$aid)),"info");
							}
							if(empty($_GPC['mobile'])){
									message("填写选手联系电话!",$this->createWebUrl("item",array("id"=>$id,"aid"=>$aid)),"info");
							}
							if(empty($_GPC['thumb'])){
									message("上传选手封面图片!",$this->createWebUrl("item",array("id"=>$id,"aid"=>$aid)),"info");
							}
							
							$data = array();
							$data["uniacid"] = $_W['uniacid'];
							$data["activity_id"] = $aid;
							$data["activity_title"] = $activity['title'];
							if(!$id){
								   $sql = "select count(*),max(no) from ".tablename("numa_vote_item")." where uniacid=:uniacid and activity_id=:activity_id";
								   $max_num = pdo_fetchcolumn($sql,array(":uniacid"=>$_W['uniacid'],":activity_id"=>$aid),1);
								   if(empty($max_num)){
								   	    $data['no'] = 1;
								   }else{
								   	     $data['no'] = $max_num +1;
								   }
								   $data["addtime"] = alinuma_toDate(time(),"Y-m-d H:i:s");
							}
							$data["name"] = $_GPC['name'];
							$data["mobile"] = $_GPC['mobile'];
							$data["desc"] = $_GPC['desc'];
							$data["thumb"] = $_GPC['thumb'];
						    $data["pics"] = json_encode($_GPC['pics']);
						      
						    if($data["thumb"]==''){ 
								  $data['thumb0'] = "";
							 }else{
									//更新压缩图片
								    $compress_image = alinuma_getCompress($data['thumb'],0.25);
								    $data["thumb0"] =$compress_image;
							}
						     
						    $data["num"] = intval($_GPC['num']);
						    $data["status"] = intval($_GPC['status']); 
						     //扩展内容
						    $extend_fields = $_GPC['fields'];
						    $extend_value = array();
							if(!empty($extend_fields)){
							 		foreach($extend_fields as $kid=>$field){ 
							 				$extend_value[$kid]=$field;
							 		}
							 }
						    $data['extend_fileds'] = json_encode($extend_value); 
						    if($id){
						    	    $result_code = pdo_update("numa_vote_item",$data,array("uniacid"=>$_W['uniacid'],"id"=>$id));
						    	    if(false!==$result_code){
						    	    		message("选手资料更新成功",$this->createWebUrl("item"),"success");
						    	    }else{
						    	    	   message("选手资料更新失败",$this->createWebUrl("item"),"error");
						    	    }
						    }else{
						    		$result_code = pdo_insert("numa_vote_item",$data);
						    		if(false!==$result_code){
						    	    		message("选手新增成功",$this->createWebUrl("item"),"success");
						    	    }else{
						    	    	   message("选手新增失败",$this->createWebUrl("item"),"error");
						    	    }
						    }
				  }  
		}else{
			 message("缺少必要参数!",$this->createWebUrl("vote"),"error");
		} 
}elseif($operation=='delete'){//选手删除
	    $id = intval($_GPC['id']);
	   	if($id){
	   		    $item = pdo_get("numa_vote_item",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    if(empty($item)){
	   		    	   message("要删除的选手不存在!",$this->createWebUrl("item"),"error");
	   		    }else{  
	   		    	  $rtn_code = pdo_delete("numa_vote_item",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    	  if(false!==$rtn_code){  
	   		    	  		  pdo_delete("numa_vote_log",array("uniacid"=>$_W['uniacid'],"activity_id"=>$item['activity_id'],"itemid"=>$id));
	   		    	  		  pdo_delete("numa_vote_item_bm",array("uniacid"=>$_W['uniacid'],"activity_id"=>$item['activity_id'],"itemid"=>$id));
	   		    	  		  message("选手删除成功!",$this->createWebUrl("item"),"success");
	   		    	  }else{
	   		    	    	 message("选手删除失败!",$this->createWebUrl("item"),"error");
	   		    	  }
	   		    }
	   	}else{
	   		   message("链接有误，缺少必要的参数!",$this->createWebUrl("item"),"error");
	   	}
}elseif($operation=="export"){  
	   	 	$aid = intval($_GPC['aid']);//获取活动ID 
	   	 	
	   	 	$activity = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$aid));  
			$extend_fields =  pdo_getall("numa_vote_fields",array("uniacid"=>$_W['uniacid'],"activity_id"=>$aid)); 
			
			$fields = array(); 
			if(!empty($extend_fields)){
				foreach($extend_fields as $k3=>$v3) { 
							$temp=array();
							$temp['field'] =$v3['id'];
							$temp['name'] = $v3['name']; 
							$temp['type'] = $v3['type'];
							$options = array();
							if($v3['type']=='select' || $v3['type']=='checkbox' || $v3['type']=='radio' ){
								   //解析$options
								   if($v3['options']!=""){
								   	      $temp_options = explode("|",$v3['options']);
								   	      if(!empty($temp_options)){
								   	      	     foreach($temp_options as $t_opt){
								   	      	     		$temp_1=explode(",",$t_opt);
								   	      	     		$options[$temp_1[0]]=$temp_1[1];
								   	      	     }
								   	      }
								   }
							}
							$temp['options'] = $options;
							$fields[] = $temp; 
					}
			}
			$headers= array('编号','姓名','手机号','票数','点击数','图片','宣言');
			 
			$header_extend = array();
			foreach($fields as $k1=>$v1){
				$header_extend[]=$v1['name'];
			}
			$headers  = array(array_merge($headers,$header_extend));
			
			$where = array();
			$where["uniacid"] = $_W['uniacid'];
			$where["activity_id"] = $aid; 
			$exp_list_temp = pdo_getall("numa_vote_item",$where,array(),"","num desc,viewnums desc");
			foreach($exp_list_temp as $k=>$v){
				 $temp=array(); 
				 $temp[0]=$v['no'];
				 $temp[1]=$v['name'];
				 $temp[2]=$v['mobile'];
				 $temp[3]=$v['num'];
				 $temp[4]=$v['viewnums']; 
				 $temp[5]=tomedia($v['thumb']);
				 $temp[6]=$v['desc'];
				 $temp_i = 7;
				 //获取扩展数据
				 $extend_values = json_decode($v['extend_fileds'],true);
				 
				 foreach($fields as $k2=>$v2){
				 	$temp_value=$temp_value_1="";
				 	if($v2['type']=='checkbox' ){
				 		   $temp_value = isset($extend_values[$v2['field']])?$extend_values[$v2['field']]:array(); 
				 	}elseif($v2['type']=='multi_image'){
				 		   $temp_value_1 = isset($extend_values[$v2['field']])?$extend_values[$v2['field']]:array(); 
				 	}else{
				 		   $temp_value = isset($extend_values[$v2['field']])?$extend_values[$v2['field']]:"";
				 	} 
				 	if(is_array($temp_value) && !empty($temp_value)){
				 		    $temp_value_str="";
				 			foreach($temp_value as $t_value){
				 					$temp_value_str.=" ".(isset($v2["options"][$t_value])?$v2["options"][$t_value]:$t_value);
				 			}
				 			$temp[$temp_i] = $temp_value_str;
				 	}elseif(!is_array($temp_value)){
				 		  $temp[$temp_i] = $temp_value;
				 	} 
				 	if(is_array($temp_value_1) && !empty($temp_value_1)){ 
				 		   $temp_value_str="";
				 			foreach($temp_value_1 as $t_value){
				 					$temp_value_str.= tomedia($t_value)."\r\n";
				 			}
				 			$temp[$temp_i] = $temp_value_str;
				 	}
				 	
					$temp_i++;
				 }
				 $exp_list[] = $temp;
			} 
	    	//生成文件名 
	    	$order_counts = count($exp_list);     
	    	$file_name = $activity['title']."-投票名单(".$order_counts.")";
		 	$fileurl =  IA_ROOT . '/data/tmp/'.IN_MODULE."/";  
		 	alinuma_mkDir($fileurl);
		 	$filename =  $file_name.".xls";
		 	$fileurl = $fileurl.md5($file_name).".xls";  
		    alinuma_writeXls($fileurl,$headers,$exp_list); 	
		    alinuma_downFile($fileurl,$filename); 
		    exit;  
}elseif($operation=='log'){//访问日志
	    $pindex = max(1, intval($_GPC['page']));
		$itemid = intval($_GPC['iid']);
		$activity_id = intval($_GPC['aid']);
		$psize = 15; 
		$where ="";
		$params = array(); 
		$where .="where uniacid=:uniacid and activity_id=:activity_id and itemid=:itemid"; 
		$params[":uniacid"] = $_W['uniacid']; 
		$params[":activity_id"] = $activity_id;
		$params[":itemid"] = $itemid;
		$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
		$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
		if($opt_type!="" && $keywords!=""){
			    if($opt_type=='userid'){
			    	  $where.=" and $opt_type=$keywords";  
			    }else{
			    	   $where.=" and $opt_type like '%$keywords%'";  
			    }  
		} 
		$orderby = "logtime desc";
		 
		$result_array = $this->_getDataList("numa_vote_log",$where,$params,$orderby,$pindex,$psize);
	    $total = $result_array['total'];
	    $data_list = $result_array['data_list'];
	    $pager = $result_array['pager']; 
}elseif($operation=='explog'){
		    $aid = intval($_GPC['aid']);//获取活动ID
	   	 	$iid = intval($_GPC['iid']);
	   	 	$activity = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$aid)); 
			$item_info = pdo_get("numa_vote_item",array("uniacid"=>$_W['uniacid'],"id"=>$iid));   
			
			$headers= array(array('OPENID','昵称','IP','省份','城市','投票时间','投票日期'));  
			 
			$where = array();
			$where['activity_id'] = $aid; 
			$where['uniacid'] = $_W['uniacid'];
			$where['itemid']= $iid;
			$exp_list_temp =  pdo_getall("numa_vote_log",$where,array(),"","logtime desc"); 
			foreach($exp_list_temp as $k=>$v){
				 $temp=array(); 
				 //获取openid 
				 $temp[0]=$v['openid'];
				 $temp[1]=$v['username'];
				 //转换IP地址 
				 $temp[2]=$v['ip_str'];
				 $temp[3]=$v['province'];
				 $temp[4]=$v['city'];
				 $temp[5]=$v['logtime'];
				 $temp[6]=alinuma_toDate($v['time_key'],'Y-m-d'); 
				 $exp_list[] = $temp;
			} 
	    	//生成文件名 
	    	$order_counts = count($exp_list);    
	    	$file_name = $activity['title']."-".$item_info['name']."-投票记录-".time(); 
		 	$fileurl =  IA_ROOT . '/data/tmp/'.IN_MODULE."/"; 
		 	alinuma_mkDir($fileurl);
		 	$filename =  $file_name.".xls";
		 	$fileurl = $fileurl.md5($file_name).".xls"; 
		    alinuma_writeXls($fileurl,$headers,$exp_list); 	
		    alinuma_downFile($fileurl,$filename);   
	        exit;   
}elseif($operation=="blacklist"){//粉丝黑名单
				if(!empty($_GPC['ids'])) {
						foreach ($_GPC['ids'] as   $id) {
								$rtn_code = pdo_delete('numa_vote_blacklist', array('id' => $id, 'uniacid' => $_W['uniacid']));
						}
						if(false!==$rtn_code){ 
							 message('批量删除成功！', $this->createWebUrl('item', array('op' => 'blacklist')), 'success');
			    		 }else{
							 message('批量删除失败！', $this->createWebUrl('item', array('op' => 'blacklist')), 'error');
			            }
				}  
				$pindex = max(1, intval($_GPC['page']));
				$psize = 15; 
				$where ="";
				$params = array(); 
				$where .="where uniacid=:uniacid"; 
				$params[":uniacid"] = $_W['uniacid']; 
				  
				$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
				$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
				if($opt_type!="" && $keywords!=""){
					   $where.=" and ".$opt_type." like '%".$keywords."%'";   
				}
				$orderby = "addtime desc"; 
				$result_array = $this->_getDataList("numa_vote_blacklist",$where,$params,$orderby,$pindex,$psize);
			    $total = $result_array['total'];
			    $data_list = $result_array['data_list'];
			    $pager = $result_array['pager']; 
}elseif($operation=='addblack'){
	  if($_W['isajax']==1){
	  		  $openid = trim($_GPC['openid']);
	  		  if($openid==""){
	  		  	     message("请填写粉丝OPENID","","error");
	  		  }
	  		  $data = array();
	  		  $data['uniacid'] = $_W['uniacid'];
	  		  $data['openid'] = $openid;
	  		  $data['addtime'] = alinuma_toDate(time());
	  		  
	  		  $rtn_code = pdo_insert("numa_vote_blacklist",$data);
	  		  if($rtn_code!==false){
	  		  	    message("添加成功!","","success");
	  		  }else{
	  		  	    message("添加失败!","","error");
	  		  }
	  } 
}elseif($operation=='delblack'){
	  if($_W['isajax']==1){
	  		  $id = intval($_GPC['id']);
	  		  if($id==""){
	  		  	     message("缺少必要参数!","","error");
	  		  }
	  		  $blackinfo = pdo_get("numa_vote_blacklist",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	  		  if(empty($blackinfo)){
	  		  	     message("查询黑名单信息出错!","","error");
	  		  }else{
	  		  			 $rtn_code = pdo_delete("numa_vote_blacklist",array("uniacid"=>$_W['uniacid'],"id"=>$id));
				  		  if($rtn_code!==false){
				  		  	    message("删除成功!","","success");
				  		  }else{
				  		  	    message("删除失败!","","error");
				  		  }
	  		  }  
	  }
}
include $this->template("item");
?>