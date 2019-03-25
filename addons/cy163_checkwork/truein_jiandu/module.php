<?php
/**
 * 初音科技朋友圈广告模块定义
 *
 * @author 初音科技
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Truein_jianduModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		global $_W, $_GPC;

        $reply = pdo_fetch("SELECT * FROM " . tablename('truein_jiandu_reply') . " WHERE rid = :rid", array(':rid' => $rid));
		
        load() -> func('tpl');
		$list = pdo_fetchall("SELECT * FROM " . tablename('truein_jiandu_ad') . " WHERE weid = :weid", array(':weid' => $_W['uniacid']));
        $adlist = @explode(',', $reply['adlist']);
		include $this -> template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		global $_W, $_GPC;
        $id = intval($_GPC['reply_id']);
        $insert = array('rid' => $rid, 'weid' => $_W['uniacid'], 'uid' => $_W['uniacid'],'cover' => $_GPC['cover'], 'title' => $_GPC['title'], 'description' => $_GPC['description'], 'starttime' => strtotime($_GPC['starttime']), 'endtime' => strtotime($_GPC['endtime']), 'status' => intval($_GPC['status']),'adtype' => intval($_GPC['adtype']),'readcounttype' => intval($_GPC['readcounttype']),'reprint' => intval($_GPC['reprint']),'aid' => $_GPC['aid'], 'gift' => trim($_GPC['gift']), 'help' => trim($_GPC['help']),'appid' => trim($_W['account']['key']), 'secret' => trim($_W['account']['secret']));
        if (empty($id)){
            pdo_insert('truein_jiandu_reply', $insert);
        }else{
            pdo_update('truein_jiandu_reply', $insert, array('id' => $id));
        }
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		load() -> func('file');
        pdo_delete('truein_jiandu_reply', array('id' => $rid));
        return true;
	}


}