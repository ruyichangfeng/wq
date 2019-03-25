<?php
/**
*
*
* @author voldemort
*/
defined('IN_IA') or exit('Access Denied');
class Voldemort_shelfModuleSite extends WeModuleSite {
	
	private function errCode($code){
		$errs = array(
			'45007'=>'语音播放时间超过限制(长度不超过60s)',
			);
		return $code .' : ' . (array_key_exists($code, $errs) ? $errs[$code] : '未知错误');
	}
	
	
	
	public function doWebOthers(){
		include $this->template('others');
	}
	
}

class Sucai_news extends WeModule {
	public $replies = array();
	
	public function fieldsFormValidate($rid = 0) {
		global $_GPC, $_W;
		$this->replies = @json_decode(htmlspecialchars_decode($_GPC['replies']), true);
		if(empty($this->replies)) {
			return '必须填写有效的回复内容.';
		}
		$column = array('id', 'parent_id', 'title', 'author', 'displayorder', 'thumb', 'description', 'content', 'url', 'incontent', 'createtime');
		foreach($this->replies as $i => &$group) {
			foreach($group as $k => &$v) {
				if(empty($v)) {
					unset($group[$k]);
					continue;
				}
				if (trim($v['title']) == '') {
					return '必须填写有效的标题.';
				}
				if (trim($v['thumb']) == '') {
					return '必须填写有效的封面链接地址.';
				}
				$v['thumb'] = str_replace($_W['attachurl'], '', $v['thumb']);
				$v['content'] = htmlspecialchars_decode($v['content']);
				$v['createtime'] = TIMESTAMP;
				$v = array_elements($column, $v);
			}
			if(empty($group)) {
				unset($i);
			}
		}
		if(empty($this->replies)) {
			return '必须填写有效的回复内容.';
		}
		return '';
	}
}