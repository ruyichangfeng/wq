<?php
/**
 * Created by IntelliJ IDEA.
 * User: codeMonkey QQ:2463619823
 * Date: 2017/6/26
 * Time: 21:28
 */

defined('IN_IA') or exit('Access Denied');
		$kid = $_GPC['kid'];
		$seq_weapon = $_GPC['seq_weapon'];
		$name_seq = $_GPC['name_seq'];
		$xkwkj = DBUtil::findById(DBUtil::$TABLE_XKWKJ, $kid);
        $userInfo = $this->getClientUserInfo();

		if (empty($userInfo)) {
		    $res['code'] = 0;
			$res['price'] = 0;
			$res['msg'] = '无法获取砍价人信息，请检查你的JS分享权限设置!';
			die(json_encode($res));
		}

		if (TIMESTAMP > $xkwkj['endtime']) {
			$res['code'] = 0;
			$res['price'] = 0;
			$res['msg'] = '活动已结束';
			die(json_encode($res));
		}



       if ($xkwkj['join_follow_enable'] == 1 && empty($_W['fans']['follow'])) {
			$res['code'] = 2;
			$res['price'] = 0;
			$res['msg'] = '请关注公众号后再帮助好友砍价！';
			die(json_encode($res));
		}

		$joinUserCount = $this->findJoinUserCount($kid);
		if ($joinUserCount >= $xkwkj['join_user_limit']) {
			$res['code'] = 0;
			$res['price'] = 0;
			$res['msg'] = '对不起，参与砍价活动已满，下次再来吧!';
			die(json_encode($res));

		}

		$uniUserInfo = $this->findUniUserInfo($userInfo['openid'], $this->weid);

		if (empty($uniUserInfo)) {

			$userUniData = array(
				'weid' => $this->weid,
				'openid' => $userInfo['openid'],
				'nickname' => $userInfo['nickname'],
				'headimgurl' => $userInfo['headimgurl'],
				'uname' => $_GPC['funame'],
				'tel' => $_GPC['futel'],
				'createtime' => TIMESTAMP
			);

			DBUtil::create(DBUtil::$TABLE_XKWKJ_USER_INFO, $userUniData);//注册用户

			$unid = pdo_insertid();
		} else {
			$unid = $uniUserInfo['id'];
		}

		$dbJoinUser=DBUtil::findUnique(DBUtil::$TABLE_XKWKJ_USER,array(":kid"=>$kid,":openid"=>$userInfo['openid']));
		$res = array();
		if(empty($dbJoinUser)) {


			$userData = array(
				'kid' => $xkwkj['id'],
				'openid' => $userInfo['openid'],
				'nickname' => $userInfo['nickname'],
				'headimgurl' => $userInfo['headimgurl'],
				'price' => $xkwkj['p_y_price'],
				'ip' => $_W['clientip'],
				'createtime' => TIMESTAMP,
				'unid' => $unid
			);
			DBUtil::create(DBUtil::$TABLE_XKWKJ_USER, $userData);//注册用户
			$uid = pdo_insertid();//用户ID
			$kj_res = $this->createFriendKj($xkwkj, $uid, $userInfo['openid'], $userInfo['nickname'], $userInfo['headimgurl'], $seq_weapon, $name_seq);
			$res['code'] = $kj_res[0];
			$res['price'] = $kj_res[1];
			$res['msg'] = $kj_res[2];
			die(json_encode($res));

		} else {
			$res['code'] = 0;
			$res['price'] = 0;
			$res['msg'] = '您已经自己砍过了哦，不能再砍了哦';
			die(json_encode($res));
		}
