<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *	活动相关页面
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
$params = array();
$params[':uniacid'] = $_W['uniacid'];
$params[':activity_id'] = $id; 
$total = pdo_fetchcolumn("select count(*) from ".tablename("numa_vote_item")." where uniacid=:uniacid and activity_id=:activity_id and status=1",$params);
$operation=empty($_GPC['op'])?'display':$_GPC['op'];

if($operation=='display'){//首页面   
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
	    			  message("获取网页授权失败,请检查相关设置!",$this->createMobile("index",array('id'=>$id,'op'=>'display')),"error");
	    		} 
	    }
	    $is_fans = 0; 
	    $fan = $this->_get_mc_fansinfo($openid,$_W['uniacid']);
	     if(!empty($fan)) $is_fans=1; 
		$page = max(1,intval($_GPC['page'])); 
		$pre_page = $page-1;
		$next_page = $page +1;
		//获取每页显示个数
		$pagesize = ( empty($activity['listrows']) || $activity['listrows']<=0)?20:$activity['listrows'];
		
		$start = ($page-1)*$pagesize;
		//获取选手列表
		$where =" where uniacid=:uniacid and activity_id=:activity_id and status=1";
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$params[':activity_id'] = $id;  
		//按编号或者名称查询
		$keyword = trim($_GPC['keyword']);
		if($keyword!=""){
			    if(is_numeric($keyword)){
			    	$where .=" and (no = $keyword)";
			    }else{
			    	 $where .=" and name like '%".$keyword."'";
			    }  
		}
		$sql = "select * from ".tablename("numa_vote_item").$where." order by no asc limit ".$start.",".$pagesize;
		$items_temp = pdo_fetchall($sql,$params); 
		$items = array();
		foreach($items_temp as $i_item){
				if($i_item['thumb0']==''){
					  //更新压缩图片
					  $compress_image = alinuma_getCompress($i_item['thumb'],0.25);
					  $i_item['thumb0'] = $compress_image;
					   pdo_update("numa_vote_item",array("thumb0"=>$compress_image),array("uniacid"=>$_W['uniacid'],"activity_id"=>$id,"id"=>$i_item['id']));
				}
				$items[]=$i_item;
		}
		$pages = ceil($total/$pagesize);   
}elseif($operation=='rank'){
				$page = max(1,intval($_GPC['page'])); 
	            $pagesize = 20;
				$start = ($page-1)*$pagesize; 
				$pre_page = $page-1;
				$next_page = $page +1; 
				//获取选手列表
				$where =" where uniacid=:uniacid and activity_id=:activity_id and status=1";
				$params = array();
			    $params[':uniacid'] = $_W['uniacid'];
				$params[':activity_id'] = $id;  
				$total = pdo_fetchcolumn("select count(*) from ".tablename("numa_vote_item").$where,$params);
				$sql = "select * from ".tablename("numa_vote_item").$where." order by num desc,viewnums desc limit ".$start.",".$pagesize;
				$items_temp = pdo_fetchall($sql,$params); 
				$items = array();
				$pages = ceil($total/$pagesize);  
				 if(!empty($items_temp)){
				 	   foreach($items_temp as $k=>$item){
				 	   		  $item['rank_no'] = ($k + 1) + ($page-1)*$pagesize;
							 $items[$item['id']] = $item;
				 	   }
				 } 
}elseif($operation=='myvote'){
				$openid = isset($_W['openid'])?$_W['openid']:"";
			    $openid_key = 'numa_vote_openid_'.$_W['uniacid'];
			    $is_fans = 0;
			    if($openid==""){
			    	  $openid = ( isset($_SESSION[$openid_key]['openid']) && !empty($_SESSION[$openid_key]['openid']))?$_SESSION[$openid_key]['openid']:"";
			    } 
				$page = max(1,intval($_GPC['page'])); 
	            $pagesize = 20;
				$start = ($page-1)*$pagesize; 
				$pre_page = $page-1;
				$next_page = $page +1; 
				//获取选手列表
				$where =" where uniacid=:uniacid and activity_id=:activity_id and openid=:openid";
				$params = array();
			    $params[':uniacid'] = $_W['uniacid'];
				$params[':activity_id'] = $id;  
				$params[':openid'] = $openid;
				$total = pdo_fetchcolumn("select count(*) from ".tablename("numa_vote_log").$where,$params);
				$sql = "select * from ".tablename("numa_vote_log").$where." order by logtime desc limit ".$start.",".$pagesize;
				$items = pdo_fetchall($sql,$params);  
}
include $this->template("index");
?>