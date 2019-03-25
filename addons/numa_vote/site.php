<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *
 * @author yofung168
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
class Numa_voteModuleSite extends WeModuleSite { 
       protected $settings,$current_module,$staticPath;
	   
	   public function __construct() { 
				global $_W,$_GPC;  
				include_once ( IA_ROOT . '/addons/'.$_W['current_module']['name'].'/func/alinuma.func.php'); 
				$settings = pdo_getcolumn("uni_account_modules",array("uniacid"=>$_W['uniacid'],"module"=>"numa_vote"),"settings");
			    $this->settings = iunserializer($settings); 
			    $this->current_module = "numa_vote"; 
			    $this->staticPath ="../addons/".IN_MODULE."/resource";   
			    if($_W['os']=='mobile' && defined("IN_MODULE")){ 
			    	  //判断是否微信
			    	  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false){
					 		 message("请复制链接在微信客户端打开","","info");
					  } 
			    	  $id = intval($_GPC['id']);
			    	  pdo_update("numa_vote_activity",array("viewnums +="=>1),array("uniacid"=>$_W['uniacid'],"id"=>$id));
			    }
	   } 
	   	  /**
	   * 获取列表
	   */
	  protected function _getDataList($tablename,$condition="",$params=array(),$orderby="",$pindex=1,$pagesize=15,$alias="a"){
	  			$sql = "select count(*) from ".tablename($tablename)." ".$alias." ".$condition;
				$total = pdo_fetchcolumn($sql,$params);
				$data_list = array();
				$pager = "";
				if (!empty($total)) {
						$sql = 'SELECT * FROM ' . tablename($tablename)." ".$alias." ".$condition 
								. ($orderby!=""?' ORDER BY '.$orderby:"")
								.' LIMIT ' . ($pindex - 1) * $pagesize . ',' . $pagesize;
						$data_list = pdo_fetchall($sql, $params);
						$pager = pagination($total, $pindex, $pagesize);
				 }
				 return array("total"=>$total,"data_list"=>$data_list,"pager"=>$pager);
	  }
	  /**
	   * 获取赞助商列表
	   */
	  protected function _getSponsorList($activity,$uniacid){ 
	  	        $sponsors = array();
			    $sponsor = $activity['sponsors']; 
				if($sponsor!=""){
					  $temp_sponsor = explode("|",$sponsor);
					  foreach($temp_sponsor as $spon_id){
					  		  $sponsorinfo = pdo_get("numa_vote_sponsor",array("uniacid"=>$uniacid,"id"=>$spon_id,"status"=>1));
					  		  $sponsors[] = $sponsorinfo;
					  }
				}
				return $sponsors;
	  }
	  /**
	   * 获取各页面链接
	   * @param id 活动ID 
	   */
	   protected function _getPageUrl($id){
	   		  $url = array();
	   		  //报名链接
	   		  $url['add_url'] = $this->createMobileUrl("item",array("op"=>'sign','id'=>$id));
	   		  //参赛选手
	   		  $url['index_url'] = $this->createMobileUrl("index",array("op"=>'display','id'=>$id));
	   		  //参赛详情
	   		  $url['detail_url'] = $this->createMobileUrl("index",array("op"=>'info','id'=>$id));
	   		  //赞助商列表
	   		  $url['sponsor_url']=$this->createMobileUrl("sponsor",array("op"=>'display','id'=>$id)); 
	   		  //排行榜
	   		  $url['rank_url']=$this->createMobileUrl("index",array("op"=>'rank','id'=>$id)); 
	   		  //排行榜
	   		  $url['myvote_url']=$this->createMobileUrl("index",array("op"=>'myvote','id'=>$id)); 
	   		  return $url;
	   }  
	   /**
	    * 获取粉丝信息
	    */
	    protected function _get_mc_fansinfo($openid,$uniacid){
	    	global $_W;
	    	$fan = array();
	    	$where = array(); 
	    	$where['uniacid'] =$uniacid;
	    	$where['openid'] = $openid;
	    	$fan = pdo_get('mc_mapping_fans',$where);
	    	if (!empty($fan)) {
					if (!empty($fan['tag']) && is_string($fan['tag'])) {
						if (is_base64($fan['tag'])) {
							$fan['tag'] = @base64_decode($fan['tag']);
						}
						if (is_serialized($fan['tag'])) {
							$fan['tag'] = @iunserializer($fan['tag']);
						}
						if (is_array($fan['tag']) && !empty($fan['tag']['headimgurl'])) {
							$fan['tag']['avatar'] = tomedia($fan['tag']['headimgurl']);
							unset($fan['tag']['headimgurl']);
							$fan['nickname'] = $fan['tag']['nickname'];
							$fan['gender'] = $fan['sex'] = $fan['tag']['sex'];
							$fan['avatar'] = $fan['headimgurl'] = $fan['tag']['avatar'];
						}
					} else {
						$fan['tag'] = array();
					}
				}
		       if(empty($fan) && $openid == $_W['openid'] && !empty($_SESSION['userinfo'])) {
						$fan['tag'] = unserialize(base64_decode($_SESSION['userinfo']));
						$fan['uid'] = 0;
						$fan['openid'] = $fan['tag']['openid'];
						$fan['follow'] = 0;
						$fan['nickname'] = $fan['tag']['nickname'];
						$fan['gender'] = $fan['sex'] = $fan['tag']['sex'];
						$fan['avatar'] = $fan['headimgurl'] = $fan['tag']['headimgurl'];
						$mc_oauth_fan = mc_oauth_fans($fan['openid']);
						if (!empty($mc_oauth_fan)) {
							$fan['uid'] = $mc_oauth_fan['uid'];
						} 
		     }
	    	return $fan;
	 }
	 /**
	  * 验证是否为黑名单
	  */
	 protected function _checkBlacklist($openid,$uniacid){
	 		$blackinfo = pdo_get("numa_vote_blacklist",array("uniacid"=>$uniacid,"openid"=>$openid));
	 		if(empty($blackinfo)){
	 			  return false;
	 		}else{
	 			   return true;
	 		}
	 }
	 /**
	  * 验证地区是否有效
	  */
	   protected function _checkLimitArea($activity,$province='',$city=''){
	   	    $result = array("code"=>1,"msg"=>""); 
	   		if($province!='' && $activity['limit_province']!=''){
	   			  $limit_provinces = str_replace(array("省","市","特别行政区","自治区"),array("","","",""),$activity['limit_province']);
	   			  $limit_provinces = explode("|",$limit_provinces);
	   			  if(!in_array($province,$limit_provinces)){
	   			  		$result = array("code"=>0,"msg"=>$province." 不在投票范围内");
	   			  		return $result; 
	   			  }
	   		}
	   		if($city!='' && $activity['limit_city']!=''){
	   			  $limit_citys = str_replace(array("市","区"),array("",""),$activity['limit_city']);
	   			  $limit_citys = explode("|",$limit_citys);
	   			  if(!in_array($city,$limit_citys)){
	   			  		$result = array("code"=>0,"msg"=>$city." 不在投票范围内"); 
	   			  		 return $result;
	   			  }
	   		}
	   		return $result;
	   }
}