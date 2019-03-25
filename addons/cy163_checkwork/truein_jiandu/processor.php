<?php
/**
 * 初音科技朋友圈广告模块处理程序
 *
 * @author 初音科技
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Truein_jianduModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		$reply = pdo_fetch("SELECT * FROM " . tablename('truein_jiandu_reply') . " WHERE rid = :rid", array(':rid' => $this -> rule));
        if (!empty($reply)){
            $rid = $this -> rule;
            $response[] = array('title' => $reply['title'], 'description' => $reply['description'], 'picurl' => $_W['attachurl'] . $reply['cover'], 'url' => $this -> createMobileUrl('index', array('rid' => $rid, 'r' => TIMESTAMP)));
            return $this -> respNews($response);
        }
	}
}