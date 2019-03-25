<?php
global $_W, $_GPC;
$settings = $this->module["config"];
load()->func("tpl");
$op = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$uniacid = $_W["uniacid"];
$openid = $_W['openid'];

$modulename = $this->modulename;


if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) {
  $openid = getip();
}


$cgc_voice_book_groupuser = new cgc_voice_book_groupuser();

$cgc_voice_book_group = new cgc_voice_book_group();

if ($op == "display") {
	
	
	$user = pdo_fetch("SELECT * FROM " . tablename('cgc_voice_book_groupuser') . " WHERE uniacid = $uniacid AND openid='$openid' $user_con ");
	
	if ($user) {		
		$qun = pdo_fetch("SELECT * FROM " . tablename('cgc_voice_book_group') . " t where uniacid = $uniacid and id=" . $user['group_id']);
	} else {
		$con = "";
		//$order = " ORDER BY RAND()";
		
		$order = " ORDER BY id";
	 
		$qun = pdo_fetch("SELECT * FROM " . tablename('cgc_voice_book_group') . " t where uniacid = $uniacid $con and status=1 and t.num_max>t.num  $order LIMIT 1");
		
		if ($qun) {
			//添加用户
			$input = array();
			$input["uniacid"] = $uniacid;
			$input["group_id"] = $qun["id"];
	
			$input["openid"] = $openid;
			
			load()->model('mc');
			$member=mc_fetch($openid);
			
			$input["nickname"] = $member['nickname'];
			$input["headimgurl"] = $member['avatar'];
			$input["createtime"] = TIMESTAMP;
			$cgc_voice_book_groupuser->insert($input);
			
			$num = $qun['num'] + 1;
			
			if ($num >= $qun['num_max']) {
				$cgc_voice_book_group->modify($qun["id"], array('num' => $num, is_full => 1));//群已达上限
			} else {
				$cgc_voice_book_group->modify($qun["id"], array('num' => $num));
			}
		} else {
			message('抱歉,群不存在,请联系管理员！');
		}
	}
	
	if (empty($qun)) {
	message('二唯码不存在！');
	}
	
	
	if ($qun['qr_code']) {
		$qr_code = tomedia($qun['qr_code']);
	} else {
		message('二唯码图片不存在！');
	}
	include $this->template('cgc_voice_book_group');
}
