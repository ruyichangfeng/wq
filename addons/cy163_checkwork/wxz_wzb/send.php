<?php
define('IN_MOBILE', true);
$basedir = dirname(dirname(dirname(__FILE__)));
require $basedir.'/framework/bootstrap.inc.php';

load()->model('mc');
load()->model('account');
load()->classs('weixin.account');

while(true) {
	$flag = true;
	$ok = true;
	$exist = true;
	$send = false;
	$dateline = time();
	//$result = cache_load('notice');
	$result = pdo_fetchAll("SELECT * FROM ".tablename('wxz_wzb_notice') . ' WHERE `status` = 0 and os = 1');

	if(!empty($result) && is_array($result)){
		foreach($result as $key => $v){
			if($v['timeType']==1){
				$send = true;
			}
			if($v['timeType']==2){
				if($v['timer']<= $dateline){
					$send = true;
				}
			}
			if($send === true){
				
				$notice = $v;

				if($notice['status']==0){
					
					$accObj = WeixinAccount::create($notice['uniacid']);
					if($notice['type']==1){
						$user = pdo_fetchAll("SELECT openid FROM ".tablename('mc_mapping_fans')." WHERE uniacid = :uniacid", array(':uniacid' => $notice['uniacid']));
					}elseif($notice['type']==2){
							
						$user = pdo_fetchAll("SELECT b.openid as openid,b.nickname as nickname FROM ".tablename('wxz_wzb_viewer')." as a left join ".tablename('wxz_wzb_user')." as b on a.uid = b.id WHERE a.rid = :rid AND b.uniacid = :uniacid AND b.openid !=''", array(':rid' => $notice['rid'],':uniacid' => $notice['uniacid']));
							
					}
					
					if(!empty($user)){
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

							$single = pdo_fetch("SELECT * FROM ".tablename('wxz_wzb_notice_logs') . ' WHERE `tid` = '.$notice['id'].' and rid='.$notice['rid'].' and openid ="'.$touser['openid'].'"');
							
							if(!empty($single)){
								$exist = false;
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
							if($flag===true && $exist===true){
								
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
								if(is_array($result) && strstr($result, 'access_token')){
									$accObj->clearAccessToken($notice['uniacid']);
								}
								if($result['errmsg'] != 'ok'){
									$ok = false;
								}
								$rec = array();
								$rec['openid'] = $touser['openid'];
								$rec['nickname'] = $touser['nickname'];
								$rec['uniacid'] = $notice['uniacid'];
								$rec['rid'] = $notice['rid'];
								$rec['tid'] = $notice['id'];
								$rec['status'] = $result['errmsg'];
								$rec['dateline'] = time();
								pdo_insert('wxz_wzb_notice_logs', $rec);
							}
						}
						if($ok===true){
							pdo_update('wxz_wzb_notice',array('status'=>'1'),array('id'=>$notice['id']));
						}
					}
				}
			}
		}
	}
	echo 'ok';
	sleep(1200);
}
