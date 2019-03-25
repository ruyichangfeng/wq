<?php
/**
 * DIY多表单模块定义
 *
 * @author Jason
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Hacker_diyformModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		global $_W,$_GPC;
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		$row = pdo_fetch("SELECT * FROM ".tablename('hackerdiyform_reply')." WHERE uniacid = :uniacid and rid = :rid", array(':uniacid' => $_W['uniacid'],':rid' => $rid));
		include $this->template('reply');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		global $_W,$_GPC;
		
		$row = pdo_fetch("SELECT * FROM ".tablename('hackerdiyform_reply')." WHERE uniacid = :uniacid and rid = :rid", array(':uniacid' => $_W['uniacid'],':rid' => $rid));
		
		if(!empty($row)){
		$user_data = array(
			//'rid' => $rid,
			'uniacid' => $_W['uniacid'],
			'description' => $_GPC['description'],
			'title' => $_GPC['title'],
			'image' => $_GPC['img'],
			'issend' => $_GPC['issend'],
			'sendmethod' => $_GPC['sendmethod'],
			'smsnum' => $_GPC['smsnum'],
			'smsuser' => $_GPC['smsuser'],
			'smspass' => $_GPC['smspass'],
			'sendopenid' => $_GPC['sendopenid'],
			'sendid' => $_GPC['sendid'],
			'isfollow' => $_GPC['isfollow'],
			'postnum' => $_GPC['postnum'],
			'url' => htmlspecialchars_decode($_GPC['url']),
			);
			$result = pdo_update('hackerdiyform_reply', $user_data, array('rid' => $rid));
				if (!empty($result)) {
					message('更新成功','','success');
				}
			
			}else{
		
		$user_data = array(
			'rid' => $rid,
			'uniacid' => $_W['uniacid'],
			'description' => $_GPC['description'],
			'title' => $_GPC['title'],
			'image' => $_GPC['img'],
			
			'issend' => $_GPC['issend'],
			'sendmethod' => $_GPC['sendmethod'],
			'smsnum' => $_GPC['smsnum'],
			'smsuser' => $_GPC['smsuser'],
			'smspass' => $_GPC['smspass'],
			'sendopenid' => $_GPC['sendopenid'],
			'sendid' => $_GPC['sendid'],
			'isfollow' => $_GPC['isfollow'],
			'postnum' => $_GPC['postnum'],
			'url' => htmlspecialchars_decode($_GPC['url']),
			);
			$result = pdo_insert('hackerdiyform_reply', $user_data);
			if (!empty($result)) {
				$uid = pdo_insertid();
				message('添加表单成功','','success');
			}
			
			}
		
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		global $_W,$_GPC;
				$result = pdo_delete('hackerdiyform_reply', array('rid' => $rid,'uniacid'=>$_W['uniacid']));
		if (!empty($result)) {
			message('删除成功','','success');
		}
		
	}


}