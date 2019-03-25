<?php
/**
 * 微信投票高级营销[驽马]模块处理程序
 *
 * @author yofung168
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Numa_voteModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		$module = $this->modulename;
		$uniacid = $this->uniacid; 
		$rule = pdo_get("rule_keyword",array("uniacid"=>$uniacid,"module"=>$module,"content"=>$content));
		 if(!empty($rule)){ 
			    //获取回复规则信息
			    $ruleinfo = pdo_get("cover_reply",array("uniacid"=>$uniacid,"module"=>$module,"rid"=>$rule['rid']));
			    if(!empty($ruleinfo)){
			    	   $rows = array();
			    	   $url = $ruleinfo['url'];
			    	   if(false!==strpos($url,"?")){
			    	   		$url .= "&nmopenid=".$this->message["from"];
			    	   }else{
			    	   	     $url .= "?nmopenid=".$this->message["from"];
			    	   }  
			    	   $rows[] = array("title"=>$ruleinfo['title'],"description"=>$ruleinfo['description'],'picurl'=>$ruleinfo['thumb'],"url"=>$url);
			    	   return $this->respNews($rows);
			    }
		 }else{
		 		 return $this->respText("系统没有找到关键词回复规则");
		 }
	}
}