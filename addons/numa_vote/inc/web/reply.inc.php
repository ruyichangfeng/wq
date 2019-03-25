<?php
/**
 * 微信投票高级营销[驽马]模块微站定义
 *设置规则信息
 * @author 驽马壹號
 * @url http://we7.yiquanr.com
 */
 defined('IN_IA') or exit('Access Denied');
global $_GPC,$_W;
load()->func('tpl'); 

$id = intval($_GPC['id']);
if($id){
		$rule = pdo_get("cover_reply",array("uniacid"=>$_W['uniacid'],"rid"=>$id,"module"=>$this->current_module)); 
		 if(checksubmit("submit")){
		 	   if(empty($_GPC['title'])){
		 	   		message("请填写标题",$this->createWebUrl("reply",array("id"=>$id)),"info");
		 	   }
		 	   if(empty($_GPC['thumb'])){
		 	   		message("请上传封面图片",$this->createWebUrl("reply",array("id"=>$id)),"info");
		 	   }
		 	   if(empty($_GPC['url'])){
		 	   		message("请填写活动链接地址",$this->createWebUrl("reply",array("id"=>$id)),"info");
		 	   }
		 	   $data = array();
		 	   $data['uniacid'] = $_W['uniacid'];
		 	   $data['rid'] = $id;
		 	   $data['module'] = $this->current_module;
		 	   $data['do'] = "rule";
		 	   $data['title'] = $_GPC['title'];
		 	   $data['description'] = $_GPC['description'];
		 	   $data['thumb'] = $_GPC['thumb'];
		 	   $data['url'] = $_GPC['url']; 
		 	   if(empty($rule)){
		 	   		  $result_code = pdo_insert("cover_reply",$data);
		 	   }else{
		 	   	     $result_code = pdo_update("cover_reply",$data,array("id"=>$rule['id']));
		 	   }
		 	  if(false!==$result_code){
						message("回复规则设置成功!",$this->createWebUrl("reply",array('id'=>$id)),'success'); 
				}else{
						message("回复规则设置失败!",$this->createWebUrl("reply",array("id"=>$id)),'error');
				} 
		 }
}else{
		message("缺少必要参数",$this->createWebUrl("vote"),"error");
}
include $this->template("rule");
?>
