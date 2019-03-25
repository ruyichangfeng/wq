<?php
/**
 * 扫码会员管理模块处理程序
 *
 * 美丽心情
 * QQ:513316788 
 */
defined('IN_IA') or exit('Access Denied');
include '../addons/bm_qrcodex/phpqrcode.php';
class bm_qrcodexModuleSite extends WeModuleSite {
    public $weid;
    public function __construct() {
        global $_W;
        $this->weid = IMS_VERSION<0.6?$_W['weid']:$_W['uniacid'];
    }

	public function doWebMember(){
		global $_W,$_GPC;
		load()->model('reply');
		load()->func('tpl');
		$weid=$_W['uniacid'];
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		if ($op == 'unbind') {
			$data = array(
				'status'   => 3,
			);
			pdo_update('bm_qrcodex_member',$data,array("id" => $_GPC['id']));
			message("更新成功",referer(),'success');
		}elseif( $op == 'display'){
			$sql="SELECT * FROM ".tablename('bm_qrcodex_member')." WHERE weid='{$weid}' order by id desc";
			$list = pdo_fetchAll($sql);
		}elseif( $op == 'delete'){
			pdo_delete("bm_qrcodex_member",array('id' => $_GPC['id'] ));
			message("删除成功",referer(),'success');
		}
		include $this->template('member');
	}

	public function doWebOperator(){
		global $_W,$_GPC;
		load()->model('reply');
		load()->func('tpl');
		$weid=$_W['uniacid'];
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		if ($op == 'post') {
			if (!empty($_GPC['id'])) {
				$item = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_operator')." WHERE id='{$_GPC['id']}' order by id desc");
			}
			$data = array(
				'weid'          => $weid,
				'name'          => $_GPC['name'],
				'from_user'        => $_GPC['from_user'],
				'datetime'    => TIMESTAMP,
			);
			if ($_W['ispost']) {
				if (empty($_GPC['id'])) {
					pdo_insert('bm_qrcodex_operator',$data);
				}else{
					pdo_update('bm_qrcodex_operator',$data,array("id" => $_GPC['id']));
				}
				message("更新成功",referer(),'success');
			}
		}elseif( $op == 'display'){
			$sql="SELECT * FROM ".tablename('bm_qrcodex_operator')." WHERE weid='{$weid}' order by id desc";
			$list = pdo_fetchAll($sql);
		}elseif( $op == 'delete'){
			pdo_delete("bm_qrcodex_operator",array('id' => $_GPC['id'] ));
			message("删除成功",referer(),'success');
		}
		include $this->template('operator');
	}
	
	public function doWebType(){
		global $_W,$_GPC;
		load()->model('reply');
		load()->func('tpl');
		$weid=$_W['uniacid'];
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		if ($op == 'post') {
			if (!empty($_GPC['id'])) {
				$item = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_type')." WHERE id='{$_GPC['id']}' order by id desc");
			}
			$data = array(
				'weid'          => $weid,
				'name'          => $_GPC['name'],
				'status'        => $_GPC['status'],
				'datetime'    => TIMESTAMP,
			);
			if ($_W['ispost']) {
				if (empty($_GPC['id'])) {
					pdo_insert('bm_qrcodex_type',$data);
				}else{
					pdo_update('bm_qrcodex_type',$data,array("id" => $_GPC['id']));
				}
				message("更新成功",referer(),'success');
			}
		}elseif( $op == 'display'){
			$sql="SELECT * FROM ".tablename('bm_qrcodex_type')." WHERE weid='{$weid}' order by id desc";
			$list = pdo_fetchAll($sql);
		}elseif( $op == 'delete'){
			pdo_delete("bm_qrcodex_type",array('id' => $_GPC['id'] ));
			message("删除成功",referer(),'success');
		}
		include $this->template('type');
	}

	public function doWebRecord(){
		global $_W,$_GPC;
		load()->model('reply');
		load()->func('tpl');
		$weid=$_W['uniacid'];
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		$sql="SELECT * FROM ".tablename('bm_qrcodex_type')." WHERE weid='{$weid}' order by id desc";
		$types = pdo_fetchAll($sql);
		$condition = '';
		if (!empty($_GPC['username'])) {
			$condition .= " AND username like '%{$_GPC['username']}%' ";
		}
		if (!empty($_GPC['typeid'])) {
			$condition .= " AND typeid = '{$_GPC['typeid']}' ";
		}
		if (!empty($_GPC['operatorname'])) {
			$condition .= " AND operatorname like '%{$_GPC['operatorname']}%' ";
		}
		if (!empty($_GPC['startdate'])) {
			$condition .= " and date_format(FROM_UNIXTIME(datetime),'%Y-%m-%d')>='" . $_GPC['startdate']. "' ";
		}
		if (!empty($_GPC['enddate'])) {
			$condition .= " and date_format(FROM_UNIXTIME(datetime),'%Y-%m-%d')<='" . $_GPC['enddate']. "' ";
		}
		
		if ($op == 'post') {
			if (!empty($_GPC['id'])) {
				$item = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_record')." WHERE id='{$_GPC['id']}' order by id desc");
			}
			$data = array(
				'weid'          => $weid,
				'name'          => $_GPC['name'],
				'status'        => $_GPC['status'],
				'datetime'    => TIMESTAMP,
			);
			if ($_W['ispost']) {
				if (empty($_GPC['id'])) {
					pdo_insert('bm_qrcodex_record',$data);
				}else{
					pdo_update('bm_qrcodex_record',$data,array("id" => $_GPC['id']));
				}
				message("更新成功",referer(),'success');
			}
		}elseif( $op == 'display'){
			print_r($condition);
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$sql="SELECT * FROM ".tablename('bm_qrcodex_record')." WHERE weid='{$weid}' $condition order by id desc";
			$list = pdo_fetchAll($sql);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('bm_qrcodex_record') . " WHERE weid='{$weid}' $condition ");
			$totalmoney = pdo_fetchcolumn('SELECT sum(credit1) FROM ' . tablename('bm_qrcodex_record') . " WHERE weid='{$weid}' $condition ");
			$pager = pagination($total, $pindex, $psize);
		}elseif( $op == 'delete'){
			pdo_delete("bm_qrcodex_record",array('id' => $_GPC['id'] ));
			message("删除成功",referer(),'success');
		}
		include $this->template('record');
	}

	public function doMobileShow() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }		
		$rid = trim($_GPC['rid']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_qrcodex_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}	
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		if ($reply['pictype'] == 1) {
			if ((empty($_W['fans']['follow'])) || ($_W['fans']['follow'] == 0)){
				header("Location: " . $reply['urlx']); 
				exit;
			}
		}
		$member = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_member')." WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array('rid' => $rid , ':from_user' => $_W['fans']['openid']));
		if (empty($member)) {
			$value = $_W['siteroot'] . 'app/' . $this->createmobileurl('credit',array('rid' => $rid , 'from_user' => $_W['fans']['openid']));
			$errorCorrectionLevel = 'H';
			$matrixPointSize = '16';
			$rand_file = random(6, 1) . '.png';
			$att_target_file = 'qrm-' . $rand_file;
			$target_file = '../addons/bm_qrcodex/tmppic/' . $att_target_file;
			QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);			
			$data = array(
				'rid'         => $rid,	
				'weid'        => $weid,	
				'from_user'   => $_W['fans']['openid'],	
				'username'    => $_W['fans']['nickname'],	
				'avatar'      => $_W['fans']['tag']['avatar'],	
				'qrcode'      => $target_file,
			);
			pdo_insert('bm_qrcodex_member',$data);
		} elseif (empty($reply['qrcode'])) {
			$value = $_W['siteroot'] . 'app/' . $this->createmobileurl('credit',array('rid' => $rid , 'from_user' => $_W['fans']['openid']));
			$errorCorrectionLevel = 'H';
			$matrixPointSize = '16';
			$rand_file = random(6, 1) . '.png';
			$att_target_file = 'qrm-' . $rand_file;
			$target_file = '../addons/bm_qrcodex/tmppic/' . $att_target_file;
			QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);	
			pdo_update('bm_qrcodex_member',array("qrcode" => $target_file),array('rid' => $rid , 'from_user' => $_W['fans']['openid']));						
		}
		$member = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_member')." WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array('rid' => $rid , ':from_user' => $_W['fans']['openid']));
		include $this->template('show');
	}

	public function doMobileApply() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }		
		$rid = trim($_GPC['rid']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_qrcodex_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}	
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		if ($reply['pictype'] == 1) {
			if ((empty($_W['fans']['follow'])) || ($_W['fans']['follow'] == 0)){
				header("Location: " . $reply['urlx']); 
				exit;
			}
		}
		$member = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_member')." WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array('rid' => $rid , ':from_user' => $_W['fans']['openid']));
		if (empty($member)) {
			$value = $_W['siteroot'] . 'app/' . $this->createmobileurl('credit',array('rid' => $rid , 'from_user' => $_W['fans']['openid']));
			$errorCorrectionLevel = 'H';
			$matrixPointSize = '16';
			$rand_file = random(6, 1) . '.png';
			$att_target_file = 'qrm-' . $rand_file;
			$target_file = '../addons/bm_qrcodex/tmppic/' . $att_target_file;
			QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);			
			$data = array(
				'rid'         => $rid,	
				'weid'        => $weid,	
				'from_user'   => $_W['fans']['openid'],	
				'username'    => $_W['fans']['nickname'],	
				'avatar'      => $_W['fans']['tag']['avatar'],	
				'qrcode'      => $target_file,
			);
			pdo_insert('bm_qrcodex_member',$data);
		} elseif (empty($reply['qrcode'])) {
			$value = $_W['siteroot'] . 'app/' . $this->createmobileurl('credit',array('rid' => $rid , 'from_user' => $_W['fans']['openid']));
			$errorCorrectionLevel = 'H';
			$matrixPointSize = '16';
			$rand_file = random(6, 1) . '.png';
			$att_target_file = 'qrm-' . $rand_file;
			$target_file = '../addons/bm_qrcodex/tmppic/' . $att_target_file;
			QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);	
			pdo_update('bm_qrcodex_member',array("qrcode" => $target_file),array('rid' => $rid , 'from_user' => $_W['fans']['openid']));
		}
		$member = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_member')." WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array(':rid' => $rid , ':from_user' => $_W['fans']['openid']));
		$op=$_GPC['op'];
		if ($op=='bind') {
			pdo_update('bm_qrcodex_member',array("cardid" => $_GPC['name'] , "status" => 1),array('rid' => $rid , 'from_user' => $_W['fans']['openid']));
			message("成功绑定条码ID！",$reply['urly'],'success');
		} elseif ($op=='unbind') {
			pdo_update('bm_qrcodex_member',array("memo" => $_GPC['comp'] , "mobile" => $_GPC['mobile'] , "status" => 2),array('rid' => $rid , 'from_user' => $_W['fans']['openid']));
			message("解绑申请已成功提交！",$reply['urly'],'success');
		}
		include $this->template('apply');
	}

	public function doMobileCredit() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }		
		$rid = trim($_GPC['rid']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_qrcodex_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$type = pdo_fetchall("SELECT * FROM " . tablename('bm_qrcodex_type') . " WHERE weid = :weid ORDER BY `id` DESC", array(':weid' => $weid));
		$from_user = trim($_GPC['from_user']);
		$member = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_member')." WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array(':rid' => $rid , ':from_user' => $from_user));
		$openid = $_W['fans']['openid'];
		$operator = pdo_fetch("SELECT * FROM ".tablename('bm_qrcodex_operator')." WHERE weid = :weid and from_user = :from_user ORDER BY `id` DESC", array(':weid' => $weid , ':from_user' => $openid));
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}
		if (empty($operator)) {
			message("请联系管理员为你服务！",$reply['urly'],'success');
		}
		$op=$_GPC['op'];
		if ($op=='post') {
			$typex = pdo_fetch("SELECT * FROM " . tablename('bm_qrcodex_type') . " WHERE id = :id ORDER BY `id` DESC", array(':id' => $_GPC['residedist']));
			$data = array(
				'rid'         => $rid,	
				'weid'        => $weid,	
				'from_user'   => $member['from_user'],	
				'username'    => $member['username'],	
				'avatar'      => $member['avatar'],	
				'weight'      => $_GPC['realname'],
				'credit1'     => intval($_GPC['mobile']),
				'datetime'    => TIMESTAMP,
				'typeid'      => $_GPC['residedist'],
				'typename'    => $typex['name'],
				'operatorid'  => $operator['id'],
				'operatorname'=> $operator['name'],
			);
			pdo_insert('bm_qrcodex_record',$data);
			$user = fans_search($from_user);
			$sql_member = "SELECT a.uid FROM " . tablename('mc_mapping_fans') . " a inner join " . tablename('mc_members') . " b on a.uid=b.uid WHERE b.uniacid='{$_W['uniacid']}' and a.openid='{$from_user}'";
			$uid = pdo_fetchcolumn($sql_member);			
			mc_credit_update($uid , 'credit1' , intval($_GPC['mobile']) , array( 0 => 'system', 1 => '扫码会员送积分' ));
			$credit=mc_credit_fetch($uid,array('credit1'));
			$template = array('touser' => $from_user,
							'template_id' => $reply['templateid'],
							'url' => $urlrpt,
							'topcolor' => "#7B68EE",
							'data' => array('first'	=> array('value' => urlencode('感谢您参加'.$reply['title'].'的活动！'),
															 'color' => "#743A3A",
															  ),
										  'keyword1' => array('value' => urlencode($_GPC['mobile']),
															 'color' => "#FF0000",
															  ),
										  'keyword2' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
															 'color' => "#0000FF",
															  ),
										  'remark' 	=> array('value' => urlencode("此次完成的种类：" . $typex['name'] . "，重量：" . $_GPC['realname'] . "，期待您的再次参与！"),
															 'color' => "#008000",
															  ),
										  )
							);			
			$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
			$row = pdo_fetch($sql, array(':acid' => $reply['weid']));
			$appid = $row['key'];
			$appsecret = $row['secret'];
			$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
			$res = $this->http_request($url);
			$result = json_decode($res, true);
			$access_token = $result["access_token"];
			$lasttime = time();
			$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);
			$template = array('touser' => $openid,
							'template_id' => $reply['templateid'],
							'url' => $urlrpt,
							'topcolor' => "#7B68EE",
							'data' => array('first'	=> array('value' => urlencode($reply['title'].'有客户参与活动！'),
															 'color' => "#743A3A",
															  ),
										  'keyword1' => array('value' => urlencode($_GPC['mobile']),
															 'color' => "#FF0000",
															  ),
										  'keyword2' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
															 'color' => "#0000FF",
															  ),
										  'remark' 	=> array('value' => urlencode("客户昵称：" . $member['username'] . "，种类：" . $typex['name'] . "，重量：" . $_GPC['realname']),
															 'color' => "#008000",
															  ),
										  )
							);		
			$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);
			message("成功增加积分！",$reply['urly'],'success');
		}
		include $this->template('credit');
	}
	
    private function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }		

	private function send_template_message($data,$access_token)
    {
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $res = $this->http_request($url, $data);
        return json_decode($res, true);
	}	
	
}
?>