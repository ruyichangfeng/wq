<?php
/**
 * 微教育模块订阅器
 *
 * @author 高贵血迹
 * @url http://bbs.we7.cc
 */
defined('IN_IA') or exit('Access Denied');

class Duola_clubModuleReceiver extends WeModuleReceiver {

	public $table_qrinfo = 'wx_school_qrcode_info';
	public $table_qrstat = 'wx_school_qrcode_statinfo';

	public function receive() {
		global $_W;
		 load()->func('logging');
		 WeUtility::logging('duola_club_messagelog', $this->message);
		if ($this->message['event'] == 'subscribe' && !empty($this->message['ticket'])) {
			$sceneid = $this->message['scene'];
			$row = pdo_fetch("SELECT * FROM " . tablename($this->table_qrinfo) . " WHERE qrcid = '{$sceneid}' and weid = '{$_W['uniacid']}'");
			if (empty($row)) return;
			   $insert = array(
					'weid' => $_W['uniacid'],
					'qid' => $row['id'],
					'openid' => $this->message['from'],
					'type' => 1,
					'qrcid' => $sceneid,
					'name' => $row['name'],
					'group_id' => $row['group_id'],
					'createtime' => TIMESTAMP
				);
			$url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=%s";
			$weixindata = "{\"openid\":\"{$this->message['from']}\",\"to_groupid\":{$row['group_id']}}";
			$this->weixin_fans_group($url, $weixindata);
			pdo_insert($this->table_qrstat, $insert);
			$scannum = $row['subnum'] + 1;
			    $temp = array(
				    'subnum' => $scannum
				);
			pdo_update($this->table_qrinfo, $temp, array('id' => $row['id']));

		} else if($this->message['event'] == 'SCAN') {
			$sceneid = $this->message['scene'];
			$row = pdo_fetch("SELECT * FROM " . tablename($this->table_qrinfo) . " WHERE qrcid = '{$sceneid}' and weid = '{$_W['uniacid']}'");
			$statinfo = pdo_fetch("SELECT * FROM " . tablename($this->table_qrstat) . " WHERE openid = '{$this->message['from']}' and weid={$_W['uniacid']}");
				$insert = array(
					'weid' => $_W['uniacid'],
					'qid' => $row['id'],
					'qrcid' => $sceneid,
					'group_id' => $row['group_id'],
					'name' => $row['name'],
					'createtime' => TIMESTAMP
				);
			$url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=%s";
			$weixindata = "{\"openid\":\"{$this->message['from']}\",\"to_groupid\":{$row['group_id']}}";
			$this->weixin_fans_group($url, $weixindata);
			$scannum = $row['subnum'] + 1;
			    $temp = array(
				    'subnum' => $scannum
				);
			pdo_update($this->table_qrinfo, $temp, array('id' => $row['id']));
			pdo_update($this->table_qrstat, $insert, array('id' => $statinfo['id']));

		}
	}

	public function weixin_fans_group($url, $weixindata)
	{
		global $_W, $_GPC;
		load()->func('logging');
		$weid = $_W['uniacid'];
		load()->classs('weixin.account');
		$accObj = WeixinAccount::create($weid);
		$access_token = WeAccount::token();
		$url = sprintf($url, $access_token);
		logging_run("$url===$weixindata");
		load()->func('communication');
		$response = ihttp_request($url, $weixindata);
		if (is_error($response)) {
			logging_run("访问公众平台接口失败, 错误: {$response['message']},$weixindata");
		}
		$result = @json_decode($response['content'], true);
		if (empty($result)) {
			logging_run("服务器没有返回");
		} elseif (!empty($result['errcode'])) {
			logging_run("访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']},$weixindata");
			exit();
		} else {
			logging_run('weixin_fans_group接口调用成功');
		}
		return $result;
	}
}