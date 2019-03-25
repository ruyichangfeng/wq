<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *	选手相关页面（报名、详情、及投票处理）
 * @author 驽马壹號
 * @url http://we7.yiquanr.com
 */
 defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
load()->func('tpl');
$id = intval($_GPC['id']);  
//获取活动信息
$activity = pdo_get("numa_vote_activity",array("uniacid"=>$_W['uniacid'],"id"=>$id));
if(empty($activity)){
	 message("活动不存在或者已经结束","","error");
} 
//强制关注时内容
if($activity['guanzhu_image']!=""){
	$guanzhu_content = "<img src='".tomedia($activity['guanzhu_image'])."'><p>".$activity['guanzhu_comm']."</p>";
}else{
	$guanzhu_content = "<p>".$activity['guanzhu_comm']."</p>";
}
$share_url = alinuma_getCurrentUrl();
$share_title =  $activity['title']." 快来帮选手们投票吧";
$share_logo = empty($activity['share_logo'])?tomedia($activity['thumb']):tomedia($activity['share_logo']);
$share_desc = $share_title ;
//赞助商
$sponsors = $this->_getSponsorList($activity,$_W['uniacid']); 
//各链接地址
$urls = $this->_getPageUrl($id);
extract($urls, EXTR_SKIP);
$where = " where uniacid=:uniacid and activity_id=:activity_id and status=1";
$params = array();
$params[':uniacid'] = $_W['uniacid'];
$params[':activity_id'] = $id; 
$total = pdo_fetchcolumn("select count(*) from ".tablename("numa_vote_item").$where,$params);
$operation=empty($_GPC['op'])?'display':$_GPC['op'];

if($operation=='info'){
	    $openid = isset($_W['openid'])?$_W['openid']:"";
	    $openid_key = 'numa_vote_openid_'.$_W['uniacid'];
	    $is_fans = 0;
	    if($openid==""){
	    	  $openid = ( isset($_SESSION[$openid_key]['openid']) && !empty($_SESSION[$openid_key]['openid']))?$_SESSION[$openid_key]['openid']:"";
	    } 
	    if($openid=="" && $activity['must_guanzhu']==0){ 
	    		if($activity['auth_type']==3){  
	    			 include MODULE_ROOT.'/inc/mobile/common_oauth.php';
	    		}else{
	    			  message("获取网页授权失败,请检查相关设置!","","error");
	    		} 
	    }
	    $is_fans = 0; 
	    $fan = $this->_get_mc_fansinfo($openid,$_W['uniacid']);
	    if(!empty($fan) ) $is_fans=1;  
		$iid = intval($_GPC['iid']);
		$where = array();
		$where['uniacid'] = $_W['uniacid'];
		$where['activity_id'] = $id;
		$where['id'] = $iid;
		$where['status'] = 1;
		$item = pdo_get("numa_vote_item",$where);
		if(empty($item)){
				message("查询选手信息失败或已被禁止",$this->createMobileUrl('index',array('id'=>$id)),'info');
		}
		 pdo_update("numa_vote_item",array("viewnums +="=>1),array("uniacid"=>$_W['uniacid'],"id"=>$iid));
		 $where =" where uniacid=:uniacid and activity_id=:activity_id and status=1";
		 $params = array();
		 $params[':uniacid'] = $_W['uniacid'];
		 $params[':activity_id'] = $id;  
		 $sql = "select * from ".tablename("numa_vote_item").$where." order by num desc,viewnums desc";
		 $items_temp = pdo_fetchall($sql,$params); 
		 $items = array(); 
		 if(!empty($items_temp)){
		 	   foreach($items_temp as $k=>$item1){
		 	   		  $item1['rank_no'] = ($k + 1) + ($page-1)*$pagesize;
					 $items[$item1['id']] = $item1;
		 	   }
		 }  
		$item_pics_temp = json_decode($item['pics'],true);
		$item_pics = array();
	    $item['rank_no'] = $items[$iid]['rank_no'];
	    //生成压缩图片
	    foreach($item_pics_temp as $v_pic){ 
			 $compress_image = alinuma_getCompress($v_pic,0.5);
			 $item_pics[]=$compress_image;
 	    }
	    $replace_key = array("#name#","#activity_title#","#rank#","#no#","#num#");
	    $replace_item = array($item['name'],$activity['title'],$item['rank_no'],$item['no'],$item['num']);
	    $share_title = empty($activity['share_title'])?($item['name']." 正在参加 ".$activity['title']." 快来帮TA投票吧"):str_replace($replace_key,$replace_item,$activity['share_title']);
		$share_logo = tomedia($item['thumb']);
		$share_desc = empty($activity['share_desc'])?($item['name']." 正在参加 ".$activity['title']." 快来帮TA投票吧"):str_replace($replace_key,$replace_item,$activity['share_desc']);
 
		 include $this->template("item"); 
}elseif($operation=='sign'){
	    $baoming_open = $activity['baoming_open'];
	    $openid = isset($_W['openid'])?$_W['openid']:"";
	    $openid_key = 'numa_vote_openid_'.$_W['uniacid'];
	
	    $is_fans = 0;
	    if($openid==""){  
	    	 	$openid = ( isset($_SESSION[$openid_key]['openid']) && !empty($_SESSION[$openid_key]['openid']))?$_SESSION[$openid_key]['openid']:"";
	    }  
	    $fan = $this->_get_mc_fansinfo($openid,$_W['uniacid']); 
	     if(!empty($fan)) $is_fans=1; 
	     if(checksubmit("submit1")){//提交报名 
	     			if($this->_checkBlacklist($openid,$_W['uniacid'])){
	     				   message("已被列入黑名单,不能报名参与该活动",$this->createMobileUrl("item",array("op"=>'sign','id'=>$id)),"error");
	     			} 
		    		if(empty($_GPC['name'])){
							message("填写选手名称!",$this->createMobileUrl("item",array("id"=>$id,"op"=>'sign')),"info");
					}
					if(empty($_GPC['mobile'])){
							message("填写联系电话!",$this->createMobileUrl("item",array("id"=>$id,"op"=>'sign')),"info");
					}
					if(empty($_GPC['thumb']) && empty($_GPC['pics'])){
							message("上传选手图片!",$this->createMobileUrl("item",array("id"=>$id,"op"=>'sign')),"info");
					}
				
					$data = array();
					$data["uniacid"] = $_W['uniacid'];
					$data["activity_id"] = $id;
					$data["activity_title"] = $activity['title']; 
					
					$data["addtime"] = alinuma_toDate(time(),"Y-m-d H:i:s"); 
					
					$data['nickname'] = isset($fan['nickname'])?$fan['nickname']:(isset($_SESSION[$openid_key]['nickname'])?$_SESSION[$openid_key]['nickname']:"");
					$data['openid'] = $openid;
					
					$data["name"] = $_GPC['name'];
					$data["mobile"] = $_GPC['mobile'];
					$data["desc"] = $_GPC['desc'];
					$pics = $_GPC['pics'];
					if(!empty($_GPC['thumb'])){
						$data["thumb"] = $_GPC['thumb'];
					}else{
						 $data["thumb"] = isset($pics[0])?$pics[0]:'';
					} 
				    $data["pics"] = json_encode($_GPC['pics']); 
				    $data["status"] = 0; 
				     //扩展内容
				    $extend_fields = $_GPC['fields'];
				    $extend_value = array();
					if(!empty($extend_fields)){
					 		foreach($extend_fields as $kid=>$field){ 
					 				$extend_value[$kid]=$field;
					 		}
					 }
				    $data['extend_fields'] = json_encode($extend_value);  
		    		$result_code = pdo_insert("numa_vote_item_bm",$data);
		    		if(false!==$result_code){
		    	    		message("报名提交成功,等待审核",$this->createMobileUrl("item",array("op"=>'sign','id'=>$id)),"success");
		    	    }else{
		    	    	   message("报名提交失败",$this->createMobileUrl("item",array("op"=>'sign','id'=>$id)),"error");
		    	    } 
	    }else{  
			   if($baoming_open==1){//开启前端报名时需要获取填写字段
			            $baoming_count =0;
			            if($openid!=""){//
			            	    $where = array();
			            	    $where['uniacid']=$_W['uniacid'];
			            	    $where['activity_id']=$id;
			            	    $where['openid']=$openid;
			            	    $where['status'] = array(0,1);
			            	    $bminfo =  pdo_get("numa_vote_item_bm",$where);
			            	   if(!empty($bminfo)){
			            	   		 $baoming_count =1;
			            	   }
			             }elseif($activity['must_guanzhu']==0 && $activity['auth_type']==3){//不强制关注时通过第三方获取openid及昵称
			             	   include MODULE_ROOT.'/inc/mobile/common_oauth.php';
			             }
			             if($baoming_count==0){
				   	 			 $fields_temp = pdo_getall("numa_vote_fields",array("uniacid"=>$_W['uniacid'],"activity_id"=>$id),array(),"","listorder asc");
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
			             }
			    }else{
			    	   	$baoming_content = $activity['baoming_content'];
			    }
				include $this->template("sign");
	    }
}elseif($operation=='click'){//点击投票
		if($_W['isajax']){
				    $rtn_array = array("code"=>"1","msg"=>"成功");
				    $openid = isset($_W['openid'])?$_W['openid']:"";
				    $openid_key = 'numa_vote_openid_'.$_W['uniacid'];
				    $is_fan = 0;
				    if($openid==""){
				    	 	$openid = ( isset($_SESSION[$openid_key]['openid']) && !empty($_SESSION[$openid_key]['openid']))?$_SESSION[$openid_key]['openid']:"";
				    }
				    if($openid==""){
				    	   $rtn_array['code']=0;
				    	   $rtn_array['msg']="获取人员识别码失败!";
				    	   exit(json_encode($rtn_array));
				    }
				    if($this->_checkBlacklist($openid,$_W['uniacid'])){
				    	   $rtn_array['code']=0;
				    	   $rtn_array['msg']="已被列入黑名单,不能参与投票!";
				    	   exit(json_encode($rtn_array));
	     			 } 
	     			$location = alinuma_getIpLookup( alinuma_getClientIp());
	     			if($location!==false){
	     				    $result = $this->_checkLimitArea($activity,$location['province'],$location['city']); 
	     				    if($result['code']==0){
	     				    		$rtn_array['code']=0;
						    	    $rtn_array['msg']=$result['msg'];
						    	   exit(json_encode($rtn_array));
	     				    }
	     			}
				    $fan = $this->_get_mc_fansinfo($openid,$_W['uniacid']);
				    if(!empty($fan)) $is_fans=1; 
				    if($activity['begin_time']>time()){
				 	  	    $begin_date = alinuma_toDate($activity['begin_time'],'Y-m-d H:i');
				 	  	    $rtn_array['code']=0;
				 	  	    if($activity['begin_tip']==""){
				 	  	    		$rtn_array['msg'] ="活动将于".$begin_date."开始!";
				 	  	    }else{
				 	  	    		$rtn_array['msg'] =$activity['begin_tip'];
				 	  	    } 
	 					    exit(json_encode($rtn_array)); 
					 } 
				   if($activity['end_time']<time()){
					    	 $rtn_array['code']=0;
					        if($activity['end_tip']==""){
				 	  	    		$rtn_array['msg'] ="投票活动已经结束!";
				 	  	    }else{
				 	  	    		$rtn_array['msg'] =$activity['end_tip'];
				 	  	    }
				 	  	    exit(json_encode($rtn_array)); 
					} 
				    if($activity['must_guanzhu']==1 && $is_fans==0){
		     					 $rtn_array['code']=100;
		     					 $rtn_array['msg'] = '尚未关注';
		     					 exit(json_encode($rtn_array)); 
		     	    }  
				    $iid = intval($_GPC['iid']);
				    $item = pdo_get("numa_vote_item",array("uniacid"=>$_W['uniacid'],"activity_id"=>$id,'id'=>$iid));
				    if(empty($item)){
				    	   $rtn_array['code']=0;
				    	   $rtn_array['msg']="获取选手信息失败!";
				    	   exit(json_encode($rtn_array));
				    }
				    if($item['status']!=1){
				    	   $rtn_array['code']=0;
				    	   $rtn_array['msg']="选手状态异常,不能给TA投票!";
				    	   exit(json_encode($rtn_array));
				   }
				   
				   $nowDayTime = strtotime(date('Y-m-d',time()));
				   $params=array(); 
			       $params[':activity_id'] = $item['activity_id']; 
			       $params[':uniacid'] = $_W['uniacid'];
				   $params[':itemid'] = $iid;
				   $params[':openid'] = $openid;
				   $params[':time_key'] = $nowDayTime;
				   $where = ' where activity_id=:activity_id and uniacid=:uniacid and itemid=:itemid and openid=:openid and time_key=:time_key';
				   
				   $todayTpCount = pdo_fetchcolumn("select count(*) from ".tablename("numa_vote_log").$where,$params); 
				   if($activity['limit_num']>0 && $todayTpCount >=$activity['limit_num']){
				    		$rtn_array['code']=0;
     					  	$rtn_array['msg'] = '给TA投票达到每日上限';
					   	    exit(json_encode($rtn_array)); 
				    }
				    if($activity['vote_num']>0){
				    		unset($params[':openid']); 
				    		$where = ' where  activity_id=:activity_id and uniacid=:uniacid and itemid=:itemid and  time_key=:time_key';
				   
						    $todayTpCount = pdo_fetchcolumn("select count(*) from ".tablename("numa_vote_log").$where,$params); 
						    if($activity['vote_num']>0 && $todayTpCount >=$activity['vote_num']){
						    		$rtn_array['code']=0;
		     					  	$rtn_array['msg'] = '投票已达上限';
							   	    exit(json_encode($rtn_array)); 
						   }
				    } 
				    unset($params[':itemid']); 
				    $params[':openid'] = $openid;
				     $ip_str = alinuma_getClientIp();
				     $ip = ip2long($ip_str); 
				    // $params[':ip_str'] = $ip_str; 不判断IP
				  //$where = ' where  activity_id=:activity_id  and uniacid=:uniacid and openid=:openid and time_key=:time_key and ip_str=:ip_str';
				    $where = ' where  activity_id=:activity_id  and uniacid=:uniacid and openid=:openid and time_key=:time_key';
				    $ipcount = pdo_fetchcolumn("select count(*) from ".tablename("numa_vote_log").$where,$params); 
		            if($ipcount >= $activity['everyday_count'] && $activity['everyday_count']>0){
				    	       $rtn_array['code']=0;
     					       $rtn_array['msg'] = '您已达每日投票上限';
     					       exit(json_encode($rtn_array)); 
					} 
					$insertData = array();
					$insertData['uniacid'] = $_W['uniacid'];
					$insertData['activity_id']      = $activity['id'];  
					$insertData['activity_title'] = $activity['title'];
				    $insertData['itemid']      = $iid;
				    $insertData['item_name'] = $item['name'];
				    $insertData['userid']      =  isset($fan['uid'])?$fan['uid']:0;
				    $insertData['openid']      = $openid;
				     
	    			//调用粉丝名称
	    			$insertData['username'] = isset($fan['nickname'])?$fan['nickname']:(isset($_SESSION[$openid_key]['nickname'])?$_SESSION[$openid_key]['nickname']:"");
					$insertData['time_key']     = $nowDayTime; 
				    
					$insertData['ip'] = alinuma_getClientIp(1);
				    $insertData['time_key']        = $nowDayTime;
				    $insertData['logtime']     = alinuma_toDate(time()); 
					$insertData['ip_str'] = alinuma_getClientIp();
					 
					if(false!==$location){
							$insertData['province']  = $location['province'];
					    	$insertData['city'] = $location['city']; 
					}
					$rtn_code = pdo_insert("numa_vote_log",$insertData);
					if(false!==$rtn_code){ 
					         $updateData = array(); 
					         $updateData['num +='] = 1;
							 $updateData['viewnums +='] = 1;
							 pdo_update("numa_vote_item",$updateData,array("uniacid"=>$_W['uniacid'],"id"=>$iid));
							 $rtn_array['code']=1;
							 $rtn_array['num'] = intval($item['num'])+1;
     					     $rtn_array['msg'] = '投票成功';
					   		 exit(json_encode($rtn_array));
				    }else{
							 $rtn_array['code']=0;
     					     $rtn_array['msg'] = '投票失败';
					   		 exit(json_encode($rtn_array));
				    }
		}
}
?>