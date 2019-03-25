<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *
 * @author 驽马壹號
 * @url http://we7.yiquanr.com
 */
defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
load()->func('tpl');
 $operation = isset($_GPC['op'])?$_GPC['op']:'display';
 
 /*$field_types = array(
			"input"=>"文本框","radio"=>"单选框","checkbox"=>"多选框","select"=>"下拉框",
			"textarea"=>"多行文本输入框","image"=>"图片上传框",
			"number"=>"数字输入框","email"=>"邮件输入框","date"=>"日期输入框","datetime"=>"时间输入框",
			"editor"=>"编辑框","multi_image"=>"多图片上传","url"=>"链接地址"
 ); */
 $field_types = array(
			"input"=>"文本框","date"=>"日期输入框",
 ); 
if($operation=="display"){//活动列表页面 
				$pindex = max(1, intval($_GPC['page']));
				$psize = 15; 
				$where ="";
				$params = array(); 
				$where .="where uniacid=:uniacid"; 
				$params[":uniacid"] = $_W['uniacid']; 
				  
				$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
				$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
				if($opt_type!="" && $keywords!=""){
					    if($opt_type=='uid'){
					    	  $where.=" and $opt_type =$keywords";  
					    }else{
					    	   $where.=" and $opt_type like '%".$keywords."%'";  
					    }   
				}
				
				$orderby = "addtime desc";
				
				$result_array = $this->_getDataList("numa_vote_activity",$where,$params,$orderby,$pindex,$psize);
			    $total = $result_array['total'];
			    $data_list = $result_array['data_list'];
			    $pager = $result_array['pager']; 
}elseif($operation=='post'){//活动新增编辑页面
		$id = isset($_GPC['id'])?intval($_GPC['id']):0;
	     $data = array();    
         if($id){
         	  $vote = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$id));
         	  if(empty($vote)){
         	  	    message("投票活动信息不存在!",$this->createWebUrl("vote"),"error");
         	  } 
         	  $extend_field_list = pdo_getall("numa_vote_fields",array("uniacid"=>$_W['uniacid'],"activity_id"=>$id),array(),'',"listorder asc");
         	  //获取赞助商列表
         	  $sponsors =array();
         	  if($vote['sponsors']!=''){
         	  		$sponsors_temp = explode("|",$vote['sponsors']);
         	  		
         	  		foreach($sponsors_temp as $sponsor_id){ 
         	  			   $sponsor = pdo_get("numa_vote_sponsor",array("uniacid"=>$_W['uniacid'],"id"=>$sponsor_id,'status'=>1));
         	  			   if(!empty($sponsor)){
         	  			   		$sponsors[] = $sponsor;
         	  			   }
         	  		} 
         	  }  
        }else{
         	  	$vote =array("title"=>"","begin_time"=>time(),
         	  							 "end_time"=> time()+7*86400, 
										"begin_tip"=>"活动尚未开始","end_tip"=>"活动已经结束",
										"begin_time_bm"=>time(),
										"end_time_bm"=>time()+7*86400, 
										"guanzhu_comm"=>"如:请先进入公众号XXX，回复关键词XXX参与活动",
										"listrows"=>20,
										"auth_type"=>1,
                                        "adv_type" =>0,
				   ); 
         } 
         $type_options = "";
         foreach($field_types as $k_field=>$field){
         	   $type_options.="<option value='".$k_field."'>".$field."</option>";
         }
         
	   	 if(checksubmit('submit')){
			   	       	  if(empty($_GPC['title'])){
			   	       	  	     message("请填写投票活动标题!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
			   	       	  }	
			   	       	  $begin_tip= !empty($_GPC['begin_tip'])?$_GPC['begin_tip']:'';
			   	       	  if(empty($begin_tip)){
			   	       	  	  	 message("请填写投票活动开始前提示",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
			   	       	  }
			   	       	  $baoming_open= !empty($_GPC['baoming_open'])?$_GPC['baoming_open']:0;
			   	       	  $baoming_content = trim($_GPC['baoming_content']);
			   	       	   if(!$baoming_open && $baoming_content==""){
			   	       	  	     message("请填写投票活动报名须知!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
			   	       	  }	
			   	       	  if(empty($_GPC['top_image'])){
			   	       	  	     message("请上传投票活动封面图片!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
			   	       	  }	
			   	       	 // if(empty($_GPC['share_logo'])){
			   	       	  //	     message("请上传投票活动分享图片!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
			   	       	//  }	 
			   	       	  
			   	       	  $must_guanzhu= !empty($_GPC['must_guanzhu'])?$_GPC['must_guanzhu']:0;
			   	       	  $guanzhu_comm = trim($_GPC['guanzhu_comm']);
			   	       	  $guanzhu_url = trim($_GPC['guanzhu_url']);
			   	       	   if($must_guanzhu && ($guanzhu_comm=="" || $guanzhu_url=="")){
			   	       	  	     message("请填写关注提示语或关注链接!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
			   	       	  }

			   	       	  //报名页底广告位
                           $adv_open = !empty($_GPC['adv_open'])?intval($_GPC['adv_open']):0;
                           $adv_type = !empty($_GPC['adv_type'])?intval($_GPC['adv_type']):1;
			   	       	   $adv_image = $_GPC['adv_image'];
			   	       	   $adv_video = $_GPC['adv_video'];
			   	       	   $adv_url = $_GPC['adv_url'];
			   	       	   if($adv_open==1){
                               if($adv_type==1 && $adv_image==""){
                                   message("请上传报名页面广告图片!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
                               }
                               if($adv_type==1 && $adv_url==""){
                                   message("请上传报名页面广告图片跳转地址!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
                               }
                               if($adv_type==2 && $adv_video==""){
                                   message("请填写报名页面广告视频地址!",$this->createWebUrl("vote",array('op'=>'post',"id"=>$id)),'info');
                               }
                           }
			   	       	  	//扩展字段
			   	       	  	$field_id = $_GPC['field_id'];
							$field_name = $_GPC['field_name'];
							$field_type = $_GPC['field_type'];
							$field_require = $_GPC['field_require'];
							$field_default = $_GPC['field_default'];
							$field_options = $_GPC['field_options'];
							$extend_field = array();
							$ids = array();
							if(!empty($field_name)){
									foreach($field_name as $k=>$field){
											if($field_id[$k]>0){
												    	$ids[] = $field_id[$k];
											}
										    $temp=array();
										    $temp['id'] = $field_id[$k];
											$temp['name'] = $field_name[$k];
											$temp['type'] = $field_type[$k];
											$temp['is_required'] = $field_require[$k];
											$temp['default'] = $field_default[$k];
											$temp['options'] = $field_options[$k];
											$temp['listorder'] = $k;
											$extend_field[]=$temp; 
									} 
								    $where=" where uniacid=:uniacid and activity_id=".$id; 
								    $sql = "delete from ".tablename("numa_vote_fields").$where;
									 if(!empty($ids) && $id){ 
									 	            $ids_str = "'".implode("','",$ids)."'";
												    $where =" and id not in (".$ids_str.")"; 
												    $sql = $sql.$where;  
												    pdo_query($sql,array("uniacid"=>$_W['uniacid']));
									 } 
						  }elseif($id){
						  			$where = "";
								    $where .=" where uniacid=:uniacid and activity_id=".$id; 
								    $sql = "delete from ".tablename("numa_vote_fields").$where;
								    pdo_query($sql,array("uniacid"=>$_W['uniacid'])); 
						  }
						  
			   	       	  $data = array();
			   	       	  $data['uniacid'] = intval($_W['uniacid']);
			   	       	  $data['title'] = $_GPC['title'];
			   	       	  //开始结束时间
			   	       	  $time = $_GPC['time'];
			   	       	  $data['begin_time'] = strtotime($time['start']);
			   	       	  $data['end_time'] = strtotime($time['end']);
			   	       	  
			   	       	  $data['begin_tip'] = $_GPC['begin_tip'];
			   	       	  $data['end_tip'] = $_GPC['end_tip'];
			   	       	  $bmtime =  $_GPC['bmtime'];
			   	       	  $data['begin_time_bm'] = strtotime($bmtime['start']);
			   	       	  $data['end_time_bm'] = strtotime($bmtime['end']);
			   	       	  
			   	       	  $data['auth_type'] = empty($_GPC['auth_type'])?1:$_GPC['auth_type'];
			   	       	  //是否强制关注
			   	       	  $data['must_guanzhu'] = empty($_GPC['must_guanzhu'])?0:intval($_GPC['must_guanzhu']);
			   	       	  $data['guanzhu_comm'] =  trim($_GPC['guanzhu_comm']);
			   	       	  $data['guanzhu_url'] =  trim($_GPC['guanzhu_url']);
			   	       	  $data['guanzhu_image'] =  trim($_GPC['guanzhu_image']);
			   	       	  
			   	       	  $data['viewnums'] = intval($_GPC['viewnums']);
			   	       	  //报名页面底部广告
                          $data['adv_open'] = $adv_open;
                          $data['adv_type'] = $adv_type;
                          $data['adv_image'] = $adv_image;
                          $data['adv_video'] = $adv_video;
                          $data['adv_url'] = $adv_url;

			   	       	  $data['baoming_open'] =  empty($_GPC['baoming_open'])?0:intval($_GPC['baoming_open']);
			   	       	  $data['baoming_content'] = trim($_GPC['baoming_content']);
			   	       	   
			   	       	  //投票限制
			   	       	  $data['everyday_count'] =  empty($_GPC['everyday_count'])?0:intval($_GPC['everyday_count']);
			   	       	  $data['limit_num'] =  empty($_GPC['limit_num'])?0:intval($_GPC['limit_num']);
			   	       	  $data['vote_num'] =  empty($_GPC['vote_num'])?0:intval($_GPC['vote_num']);
			   	       	  
			   	       	  $data['description'] =  trim($_GPC['description']);
			   	       	  $data['flow'] = trim($_GPC['flow']);
			   	       	  $data['awards'] = trim($_GPC['awards']);
			   	       	  $data['voterule'] = trim($_GPC['voterule']);
			   	       	  $data['competition_rules'] = trim($_GPC['competition_rules']);
			   	       	   
			   	       	  $data['addtime'] = date('Y-m-d H:i:s',time());
			   	       	  //赞助商
						  $sponsor_ids = $_GPC['sponsor_ids'];
						  if(!empty($sponsor_ids)){
						  		array_unique($sponsor_ids);
						  		$data['sponsors'] = implode("|",$sponsor_ids);
						  }else{
						  	     $data['sponsors'] ="";
						  }
			   	       	  //
			   	       	  $data['top_image'] = $_GPC['top_image'];
			   	       	  $data['share_title'] = $_GPC['share_title'];
			   	       	  $data['share_desc'] = $_GPC['share_desc'];
			   	       	  $data['share_logo'] = $_GPC['share_logo'];
			   	       	   
			   	       	   $data['listrows'] =  empty($_GPC['listrows'])?20:intval($_GPC['listrows']);
			   	       	   $data['tongji'] = $_GPC['tongji'];
			   	       	   $data['company_zhuban'] = $_GPC['company_zhuban'];
			   	       	   $data['company_chengban'] = $_GPC['company_chengban'];
			   	       	   $data['tpl_id'] = empty($_GPC['tpl_id'])?"default":$_GPC['tpl_id'];
			   	       	   //是否显示赞助 
			   	       	   $data['is_sponsor'] =  empty($_GPC['is_sponsor'])?0:intval($_GPC['is_sponsor']);
			   	       	   //限制省份及城市
			   	       	   $data['limit_province'] = trim($_GPC['limit_province']);
			   	       	   $data['limit_city'] = trim($_GPC['limit_city']);
			   	       	   
			   	       	   $listrows = empty($_GPC['listrows'])?20:intval($_GPC['listrows']);
			   	       	   $data["listrows"] = $listrows;
			   	       	   //判断选手选项
			   	       	   $extend_fields = $_GPC['extend_fields'];
			   	       	   if (!$id) {
									$rtn_code = pdo_insert('numa_vote_activity', $data);  
									$activity_id = pdo_insertid();
			   	       	   }else{
			   	       	   	        unset($data['addtime']); 
			   	       	  	    	$rtn_code =pdo_update('numa_vote_activity', $data, array('id' => $id));
			   	       	  	    	$activity_id = $id;
			   	       	   }
				 		 if($rtn_code !==false){  
						    	 if(!empty($extend_field)){ 
									 	   foreach($extend_field as $k=> $field){
									 	   	  		$data = array();
									 	   	  		$data['activity_id']=$activity_id;
									 	   	  		$data['uniacid'] = $_W['uniacid'];
									 	   	  		$data['activity_name'] = $_GPC['title'];
									 	   	  		$data['name'] =$field['name'];
									 	   	  		$data['type'] = $field['type'];
									 	   	  		$data['is_required'] = $field['is_required'];
									 	   	  		$data['default'] = $field['default'];
									 	   	  		$data['options'] = $field['options'];
									 	   	  		$data['listorder'] = $k;  
									 	   	  		if($field['id']>0){ 
									 	   	  			     pdo_update('numa_vote_fields',$data,array("uniacid"=>$_W['uniacid'],"id"=>$field['id'])); 
									 	   	  		}else{
									 	   	  			      pdo_insert('numa_vote_fields',$data);  
									 	   	  		}
									 	   }
									 }
									if($id){
										message("投票活动更新成功!",$this->createWebUrl("vote"),'success'); 
									}else{
										message("投票活动新增成功!",$this->createWebUrl("vote"),'success');
									} 
						    }else{
						    	    if($id){
										message("投票活动更新失败!",$this->createWebUrl("vote"),'error'); 
									}else{
										message("投票活动新增失败!",$this->createWebUrl("vote"),'error');
									} 
						    } 
	   }
}elseif($operation=='delete'){//活动删除
		$id = intval($_GPC['id']);
	   	if($id){
	   		    $activity = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    if(empty($activity)){
	   		    	   message("要删除的投票活动不存在!",$this->createWebUrl("vote"),"error");
	   		    }else{  
	   		    	  $rtn_code = pdo_delete("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    	  if(false!==$rtn_code){ 
	   		    	  		//删除相关数据
	   		    	  		 pdo_delete("numa_vote_fields",array("uniacid"=>$_W['uniacid'],"activity_id"=>$id)); 
	   		    	  		 pdo_delete("numa_vote_item",array("uniacid"=>$_W['uniacid'],"activity_id"=>$id));
	   		    	  		 pdo_delete("numa_vote_item_bm",array("uniacid"=>$_W['uniacid'],"activity_id"=>$id));
	   		    	  		 pdo_delete("numa_vote_log",array("uniacid"=>$_W['uniacid'],"activity_id"=>$id));
	   		    	  		 message("投票活动删除成功!",$this->createWebUrl("vote"),"success");
	   		    	  }else{
	   		    	    	 message("投票活动删除失败!",$this->createWebUrl("vote"),"error");
	   		    	  }
	   		    }
	   	}else{
	   		   message("链接有误，缺少必要的参数!",$this->createWebUrl("vote"),"error");
	   	}
}elseif($operation=='itemlist'){
				$pindex = max(1, intval($_GPC['page']));
				$aid = intval($_GPC['id']);
				$psize = 15; 
				$where ="";
				$params = array(); 
				$where .="where uniacid=:uniacid and activity_id=:activity_id"; 
				$params[":uniacid"] = $_W['uniacid']; 
				 $params[":activity_id"] = $aid;
				$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
				$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
				if($opt_type!="" && $keywords!=""){
					    if($opt_type=='activity_id' || $opt_type=='no'){
					 		  $where.=" and $opt_type =$keywords";  
					    }else{
					    	   $where.=" and $opt_type like '%".$keywords."%'";  
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
}
include $this->template("index");
?>