<?php
/**
 * 微家教模块处理程序
 *
 * @author CW
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Cw_weijiajiaoModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		global $_W;
    	$rid = $this->rule;
    	$sql = "SELECT * FROM " . tablename('jj_org_reply') . " WHERE `rid`=:rid LIMIT 1";
    	$row = pdo_fetch($sql, array(':rid' => $rid));
    	if (empty($row['id'])) {
    		return $this->respText("请维护机构信息") ;
    	}
    	return $this->respNews(array(
    				'Title' => $row['title'],
    				'Description' => $row['order_info'],
    				'PicUrl' => $_W['attachurl'] . $row['picurl'],
    				'Url' => $this->createMobileUrl('index',array('id' => $row['id'])),
    		));
	}
}