<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *	赞助商页面
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
			$iid = intval($_GPC['iid']);
			$where = array();
			$where['uniacid'] = $_W['uniacid']; 
			$where['id'] = $iid;
			$where['status'] = 1;
			$sponsor = pdo_get("numa_vote_sponsor",$where);
			if(empty($sponsor)){
					message("查询赞助商信息失败或隐藏显示",$this->createMobileUrl('sponsor',array('id'=>$id)),'info');
			}
		    //根据经纬度获取地址
		    if($sponsor['map_jwd']!=""){
		    	$map_url = alinuma_getMapUrl(array("title"=>$sponsor['name'],"address"=>$sponsor['address'],"map_jwd"=>$sponsor['map_jwd']));
		    } 
}  
include $this->template("sponsor"); 
?>
