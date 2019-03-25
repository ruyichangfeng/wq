<?php
/**
 * 甜橙表单模块处理程序
 *
 * @author 甜橙网络
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Cx_tcbdModuleProcessor extends WeModuleProcessor {
		public function respond() {
		global $_W;
		$rid = $this->rule;
		$sql = "SELECT * FROM " . tablename('cx_tcbd_form') . " WHERE `rid`=:rid LIMIT 1";
		$row = pdo_fetch($sql, array(':rid' => $rid));

		if ($row == false) {
			return $this->respText("活动已取消...");
		}
		
		if ($row['valid_time_start'] > time()) {
			return $this->respText("活动未开始，请等待...");
		}
		
		if ($row['valid_time_end'] < time()) {
			return $this->respText("活动已结束...");
		}				
		return $this->respNews(array(
				'Title' => $row['form_theme'],
				'Description' => strip_tags($row['details']),
				'PicUrl' => toimage($row['form_pic']),
				'Url' => $this->createMobileUrl('index', array('rid' => $rid)),
			));
	}
}