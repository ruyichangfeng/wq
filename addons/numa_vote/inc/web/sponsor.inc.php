<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *赞助商信息
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
					    if($opt_type=='id'){
					    	  $where.=" and ".$opt_type."=".$keywords;  
					    }else{
					    	   $where.=" and ".$opt_type." like '%".$keywords."%'";  
					    }    
				}
				
				$orderby = "listorder desc";
				
				$result_array = $this->_getDataList("numa_vote_sponsor",$where,$params,$orderby,$pindex,$psize);
			    $total = $result_array['total'];
			    $data_list = $result_array['data_list'];
			    $pager = $result_array['pager']; 
			    include $this->template("sponsor");
}elseif($operation=='post'){//赞助商新增编辑
	     $id = isset($_GPC['id'])?intval($_GPC['id']):0;
	     $data = array();    
         if($id){
         	  $sponsor = pdo_get("numa_vote_sponsor",array("uniacid"=>$_W['uniacid'],"id"=>$id));
         	  if(empty($sponsor)){
         	  	    	message("赞助商信息不存在!",$this->createWebUrl("sponsor"),"error");
         	  } 
        }else{
         	  	$sponsor =array(); 
         } 
         if(checksubmit("submit")){//数据提交
         		if(empty($_GPC['name'])){
         				message("请填写赞助商名称!",$this->createWebUrl("sponsor"),"info");
         		}
         		if(empty($_GPC['logo'])){
         				message("请上传赞助商LOGO!",$this->createWebUrl("sponsor"),"info");
         		}
         		if(empty($_GPC['qrcode'])){
         				message("请上传赞助商二维码!",$this->createWebUrl("sponsor"),"info");
         		}
         		$data = array();
         		$data['uniacid'] = $_W['uniacid'];
         		$data['name'] = $_GPC['name'];
         		$data['url'] = $_GPC['url'];
         		$data['video_url'] = $_GPC['video_url'];
         		$data['logo'] = $_GPC['logo'];
         		$data['qrcode'] = $_GPC['qrcode'];
         		$data['slide_image'] = $_GPC['slide_image'];
         		$data['desc'] = $_GPC['desc'];
         		$data['content'] = $_GPC['content']; 
         		$data['guanzhu_url'] = $_GPC['guanzhu_url'];
         		$data['address'] = $_GPC['address'];
         		$data['map_jwd'] = $_GPC['map_jwd'];
         		$data['contact'] = $_GPC['contact'];
         		$data['mobile'] = $_GPC['mobile'];
         		$data['status'] = !empty($_GPC['status'])?$_GPC['status']:0;
         		$data['listorder'] = $_GPC['listorder'];
         		$data['is_scroll'] = !empty($_GPC['is_scroll'])?$_GPC['is_scroll']:0; 
         		if (!$id) {
						$rtn_code = pdo_insert('numa_vote_sponsor', $data); 
					    if($rtn_code !==false){ 
					    		message("赞助商新增成功!",$this->createWebUrl("sponsor"),'success');
					    }else{
					    	    message("赞助商新增失败!","","error");
					    }
				 } else {   
					  $result_code = pdo_update("numa_vote_sponsor",$data,array("id"=>$id,"uniacid"=>$_W['uniacid']));
					  if($rtn_code !==false){ 
					    		message("赞助商更新成功!",$this->createWebUrl("sponsor"),'success');
					  }else{
					    	    message("赞助商更新失败!",$this->createWebUrl("sponsor"),"error");
					  }
				}   
         }
         include $this->template("sponsor");
}elseif($operation=='delete'){//赞助商删除
		$id = intval($_GPC['id']);
	   	if($id){
	   		    $adv = pdo_get("numa_vote_sponsor",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    if(empty($adv)){
	   		    	   message("查询赞助商信息错误!",$this->createWebUrl("sponsor"),"error");
	   		    }else{ 
	   		    	  $rtn_code = pdo_delete("numa_vote_sponsor",array("uniacid"=>$_W['uniacid'],"id"=>$id));
	   		    	  if(false!==$rtn_code){ 
	   		    	  		 message("赞助商删除成功!",$this->createWebUrl("sponsor"),"success");
	   		    	  }else{
	   		    	    	 message("赞助商删除失败!",$this->createWebUrl("sponsor"),"error");
	   		    	  }
	   		    }
	   	}else{
	   		   message("链接有误，缺少必要的参数!",$this->createWebUrl("sponsor"),"error");
	   	}
}elseif($operation=='choice'){//赞助商选择窗口
			   $single = empty($_GPC['single'])?1:$_GPC['single'];//1是单选2多选
			   $pindex = max(1, intval($_GPC['page']));
			   $psize = 6; 
			   $where ="";
				$params = array(); 
				$where .="where uniacid=:uniacid and status=1"; 
				$params[":uniacid"] = $_W['uniacid']; 
				  
				$opt_type = isset($_GPC['opt_type'])?$_GPC['opt_type']:'';
				$keywords =  isset($_GPC['keywords'])?$_GPC['keywords']:'';
				if($opt_type!="" && $keywords!=""){
					    if($opt_type=='id'){
					    		  $where.=" and ".$opt_type."=".$keywords;  
					    }else{
					    	   $where.=" and ".$opt_type." like '%".$keywords."%'";  
					    }     
				}
				
				$orderby = "listorder desc";
				
				$result_array = $this->_getDataList("numa_vote_sponsor",$where,$params,$orderby,$pindex,$psize);
			    $total = $result_array['total'];
			    $data_list = $result_array['data_list'];
			    $pager = $result_array['pager']; 
			    include $this->template("sponsor.choice");
} 
?>
