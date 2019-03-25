<?php
global $_W,$_GPC;

$acid = intval($_W['acid']);
$id = intval($_GPC['id']);
$rid = intval($_GPC['rid']);

$notice = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_notice') . ' WHERE `status` = 0 and id='.$id);
$flag = true;
load()->model('mc');
load()->model('account');
load()->classs('weixin.account');
$accObj = WeixinAccount::create($notice['uniacid']);
if(!empty($notice)){
	if (intval($_GPC['page']) == 0) {
		message('正在推送消息,请不要关闭浏览器', $this->createWebUrl('wsend',array('page' =>1,'rid' =>$rid,'id' =>$id,'acid' => $acid)), 'success');
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 50;

	if($notice['type']==1){

		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('mc_mapping_fans') . " WHERE uniacid = :uniacid AND acid = :acid AND follow = '1'", array(':uniacid' => $_W['uniacid'], ':acid' => $acid));
		$total_page = ceil($total / $psize);
		$user = pdo_fetchall("SELECT * FROM ".tablename('mc_mapping_fans') ." WHERE uniacid = :uniacid AND acid = :acid AND follow = '1' ORDER BY `fanid` DESC LIMIT ".($pindex - 1) * $psize.','.$psize, array(':uniacid' => $_W['uniacid'], ':acid' => $acid));
		
	}elseif($notice['type']==2){
			
		
		$total = pdo_fetchcolumn("SELECT count(*) as c FROM ".tablename('wxz_wzb_viewer')." as a left join ".tablename('wxz_wzb_user')." as b on a.uid = b.id WHERE a.rid = :rid AND b.uniacid = :uniacid AND b.openid !=''", array(':rid' => $notice['rid'],':uniacid' => $notice['uniacid']));

		$total_page = ceil($total / $psize);
		$user = pdo_fetchall("SELECT b.openid as openid,b.nickname as nickname FROM ".tablename('wxz_wzb_viewer')." as a left join ".tablename('wxz_wzb_user')." as b on a.uid = b.id WHERE a.rid = :rid AND b.uniacid = :uniacid AND b.openid !='' ORDER BY a.`dateline` DESC LIMIT ".($pindex - 1) * $psize.','.$psize, array(':rid' => $notice['rid'],':uniacid' => $notice['uniacid']));

	}
	
	if (!empty($user)) {
		$template_id = $notice['template_id'];
		$topcolor = '#FF683F';
		$postdata = array(
			'first' => array(
				'value' => $notice['firstvalue'],
				'color' => $notice['firstcolor']
			),
			'keyword1' => array(
				'value' => $notice['keyword1value'],
				'color' => $notice['keyword1color']
			),
			'keyword2' => array(
				'value' => $notice['keyword2value'],
				'color' => $notice['keyword2color']
			),
			'keyword3' => array(
				'value' => $notice['keyword3value'],
				'color' => $notice['keyword3color']
			),
			'remark' => array(
				'value' => $notice['remarkvalue'],
				'color' => $notice['remarkcolor']
			),
		);
		foreach($user as $u=>$touser){
			
			$single = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_notice_logs') . ' WHERE `tid` = '.$notice['id'].' and rid='.$notice['rid'].' and openid ="'.md5($touser['openid']).'"');
			if($single){
				$flag = false;
			}
			if(empty($touser)) {
				$flag = false;
			}
			if(empty($template_id)) {
				$flag = false;
			}
			if(empty($postdata) || !is_array($postdata)) {
				$flag = false;
			}

			if($flag!=false){
				$flag = true;
			}

			if($flag===true){
				
				$token = $accObj->fetch_token();
								
				$data = array();
				$data['touser'] = $touser['openid'];
				$data['template_id'] = trim($template_id);
				$data['url'] = $notice['url'];
				$data['topcolor'] = trim($topcolor);
				$data['data'] = $postdata;
				$data = json_encode($data);
				$post_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
				$response = ihttp_request($post_url, $data);
				$result = @json_decode($response['content'], true);

				$rec = array();
				$rec['openid'] = md5($touser['openid']);
				$rec['nickname'] = $touser['nickname'];
				$rec['uniacid'] = $notice['uniacid'];
				$rec['rid'] = $notice['rid'];
				$rec['tid'] = $notice['id'];
				$rec['status'] = $result['errmsg'];
				$rec['dateline'] = time();
				pdo_insert('wxz_wzb_notice_logs', $rec);
			}
		}
		
	}
	$pindex++;
	$log = ($pindex - 1) * $psize;
	if ($pindex > $total_page) {
		pdo_update('wxz_wzb_notice',array('status'=>'1'),array('id'=>$notice['id']));
		
		message('消息推送完成', $this->createWebUrl('noticelist',array('rid' =>$rid)), 'success');
	} else {
		message('正在推送消息,请不要关闭浏览器,已完成更新 ' . $log . ' 条数据。', $this->createWebUrl('wsend',array('page' =>$pindex,'rid' =>$rid,'id' =>$id,'acid' => $acid)));
	}
}else{
	pdo_update('wxz_wzb_notice',array('status'=>'1'),array('id'=>$notice['id']));
	message('消息推送完成', $this->createWebUrl('noticelist',array('rid' =>$rid)), 'success');
}
