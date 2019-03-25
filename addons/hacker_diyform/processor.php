<?php
/**
 * DIY多表单模块处理程序
 *
 * @author Jason
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Hacker_diyformModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W,$_GPC;
		$rid = $this->rule;
		
		  
		  
		$row = pdo_fetch("SELECT * FROM ".tablename('hackerdiyform_reply')." WHERE uniacid = :uniacid and rid = ".$rid, array(':uniacid' => $_W['uniacid']));
	
		
		
		return $this->respNews(array( 
		'Title' => $row['title'], 
		'Description' => $row['description'], 
		'PicUrl' => tomedia($row['image']),
		 'Url' => $this->createMobileUrl('index', array('rid' => $rid)), //创建一个带openid信息的访问模块introduce方法的地址，这里也可以直接写http://we7.cc
		 ));


	}
}