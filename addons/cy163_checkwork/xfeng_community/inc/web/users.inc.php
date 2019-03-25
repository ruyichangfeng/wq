<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 后台管理员设置
 */
global $_W,$_GPC;
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
$do = $_GPC['do'].$op;
$method = $_GPC['method'] ? $_GPC['method'] : 'perm';
$GLOBALS['frames'] = $this->NavMenu($do,$method);
$xqmenu = $this->xqmenu();

if ($op == 'list') {
    $u = $this->user();
    $uniacid = intval($_W['uniacid']);
    $account = pdo_fetch("SELECT * FROM ".tablename('uni_account')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    if (empty($account)) {
        message('抱歉，您操作的公众号不存在或是已经被删除！');
    }
    $condition ='';
//	$uuid = intval($_GPC['uuid']);
    if(intval($_GPC['uuid'])){
        $uuid = intval($_GPC['uuid']);
        $condition = " AND x.uuid='{$uuid}'";
    }else{
        $condition = " AND x.uuid='{$_W['uid']}'";
    }
    $permission = pdo_fetchall("SELECT x.type,u.uid,x.regionid as regionid,x.id as id FROM ".tablename('uni_account_users')."as u left join ".tablename('xcommunity_users') ."as x on u.uid = x.uid WHERE x.uniacid = '{$uniacid}' AND u.role='operator' $condition", array(), 'uid');
	if (!empty($permission)) {
		$member = pdo_fetchall("SELECT username, uid,status FROM ".tablename('users')."WHERE uid IN (".implode(',', array_keys($permission)).")", array(), 'uid');
		foreach ($permission as $key => $value) {
			$region = pdo_fetch("SELECT * FROM ".tablename('xcommunity_region')."WHERE id='{$value['regionid']}'") ;
			$permission[$key]['region_title'] = $region['title'];
		}
	}
	$uids = array();
	foreach ($permission as $v) {
		$uids[] = $v['uid'];
	}
	include $this->template('web/users/list');
}elseif ($op == 'add') {
    //编辑用户
    $uid = intval($_GPC['uid']);
    if($uid){
        //获取用户信息
        $user = user_single($uid);
        $userinfo = pdo_get('xcommunity_users',array('uid'=>$uid),array('type','regionid','province','city','dist'));
        if($userinfo['type'] == 3){
            $regionids = $userinfo['regionid'];
        }
    }
    if(checksubmit()) {
        load()->model('user');
        $member = array();
        $member['username'] = $uid ? $user['username'] : trim($_GPC['username']);
        if(empty($uid)){
            if (empty($_GPC['password'])) {
                echo '请输入密码';exit();
            }
            if(user_check(array('username' => $member['username']))) {
                message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
            }
            $member['password'] = $_GPC['password'];
        }else{
            if (!empty($_GPC['password'])) {
                $member['password'] = $_GPC['password'];
            }
        }

        if(!preg_match(REGULAR_USERNAME, $member['username'])) {
            message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
        }
        if (!empty($_GPC['password'])) {
            if(istrlen($member['password']) < 8) {
                message('必须输入密码，且密码长度不得低于8位。');
            }
        }
        $member['remark'] = $_GPC['remark'];
        $member['groupid'] = 1;
        $member['status'] = intval($_GPC['status']);
        //小区用户表
        $data = array(
            'uniacid' => $_W['uniacid'],
            'uuid' => $_W['uid'],
            'type' => intval($_GPC['type']),
        );
        if($data['type'] == 3){
            //普通管理员绑定小区和省市区
            $regionids = implode(',',$_GPC['regionid']);
            $birth = $_GPC['birth'];
            $data['regionid'] = $regionids;
            $data['province'] = $birth['province'];
            $data['city'] = $birth['city'];
            $data['dist'] = $birth['district'];
        }
        if ($uid) {
            //更新用户
            $member['uid'] = $uid;
            $member['salt'] = $user['salt'];
            user_update($member);
            $data['uid'] = $uid;
            pdo_update('xcommunity_users',$data,array('uid' => $uid));
            message('保存成功！', referer(),'success');
        }else{
            //添加到系统用户表中
            $user_uid = user_register($member);

            //关联添加到小区的用户表，主要是做一些其他权限使用
            $data['uid'] = $user_uid;
            pdo_insert('xcommunity_users',$data);
            //系统用户表
            $user = array(
                'uniacid' => $_W['uniacid'],
                'uid' => $user_uid,
                'role' => 'operator',
            );
            pdo_insert('uni_account_users',$user);
            //系统用户表
            $insert = array(
                'uniacid' => $_W['uniacid'],
                'uid' => $user_uid,
                'type' => 'xfeng_community',
                'permission' => 'xfeng_community_menu_manage'
            );
            pdo_insert('users_permission', $insert);
            message('用户增加成功！', referer(),'success');
        }
        if($uid > 0) {
            unset($member['password']);
        }
        message('增加用户失败，请稍候重试或联系网站管理员解决！');
    }

	include $this->template('web/users/add');
}elseif($op == 'menu'){
	$menus = $this->NavMenu($do);
	// print_r($menus);exit();
	$id = intval($_GPC['id']);
	if ($id) {
		$item = pdo_fetch("SELECT * FROM".tablename('xcommunity_users')."WHERE id=:id ",array(':id' => $id));
		$mmenus = explode(',', $item['menus']);
	}
	if (checksubmit('submit')) {
		$data = array(
				'menus' => is_array($_GPC['menus']) ? implode(',', $_GPC['menus']) : ''
			);
		if ($id) {
			$r = pdo_update('xcommunity_users',$data,array('id' => $id));
			if ($r) {
				$result = pdo_fetch("SELECT * FROM".tablename('users_permission')."WHERE uid=:uid",array(':uid' => $item['uid']));
				if (empty($result)) {
					$url = "c=home&a=welcome&do=ext&m=xfeng_community";
					pdo_insert('users_permission', array(
						'uid' => $item['uid'],
						'uniacid' => $_W['uniacid'],
						'url' => $url,
						'type' => 'xfeng_community',
						'permission' => 'all'
					));
				}
				
				message('权限修改成功',$this->createWebUrl('users',array('op' => 'list')),'success');
			}
		}
	}
	include $this->template('web/users/menu');
}elseif($op == 'set'){
	$uid = intval($_GPC['uid']);
	if (empty($uid)) {
		message('缺少参数',referer(),'error');
	}
	$type = $_GPC['type'];
	$data = intval($_GPC['data']);
	$data = ($data==1? 2:1);
	pdo_query("UPDATE ".tablename('users')."SET status = '{$data}' WHERE uid=:uid",array(":uid" => $uid ));
	die(json_encode(array("result" => 1, "data" => $data)));
}elseif ($op == 'delete') {
	$uid = intval($_GPC['uid']);
	if (empty($uid)) {
		message('缺少参数',referer(),'error');
	}
	$user = pdo_fetch("SELECT uid FROM".tablename('users')."WHERE uid=:uid",array(":uid" => $uid));
	if (empty($user)) {
		message('该用户不存在或已被删除',referer(),'error');
	}
	if (pdo_delete("users",array("uid" => $uid)) && pdo_delete("xcommunity_users",array("uid" => $uid)) && pdo_delete("uni_account_users",array("uid" => $uid)) && pdo_delete("users_permission",array("uid" => $uid))) {
		message("删除成功",referer(),'success');
	}
}elseif ($op == 'ajax') {
	if ($_GPC['companyid']) {
		$regions = pdo_fetchall("SELECT * FROM".tablename('xcommunity_region')."WHERE pid='{$_GPC['companyid']}'");
		print_r(json_encode($regions));exit();
	}
}elseif ($op == 'commission') {
	$id = intval($_GPC['id']);
	if ($id) {
		$user = pdo_fetch("SELECT * FROM".tablename('users')."as u left join ".tablename('xcommunity_users')." as x on u.uid = x.uid WHERE x.id=:id",array(':id' => $id));
	}
	if (checksubmit('submit')) {
		if ($id) {
			$r = pdo_update('xcommunity_users',array('commission' => $_GPC['commission'],'xqcommission' => $_GPC['xqcommission']),array('id' => $id));
			if ($r) {
				message('设置成功',$this->createWebUrl('users',array('op' => 'list')),'success');
			}
			
		}
	}
	include $this->template('web/users/commission');
}elseif($op == 'cash'){
    $users = pdo_fetch("SELECT * FROM" . tablename('xcommunity_users') . "WHERE uid=:uid", array(':uid' => $_W['uid']));
    if (checksubmit('submit')) {
        if($_GPC['cash']<= 0){
            message('输入金额不正确,请重新输入',referer(),'error');exit();
        }
        if ($_GPC['cash'] > $users['balance']) {
            message('余额不足，无法提现', referer(), 'error');
        }

        $data = array(
            'weid' => $_W['uniacid'],
            'ordersn' => date('YmdHi') . random(10, 1),
            'price' => $_GPC['cash'],
            'type' => 'cash',
            'createtime' => TIMESTAMP,
            'uid' => $_W['uid'],
            'pay' => trim($_GPC['pay'])
        );
        $r = pdo_insert('xcommunity_order', $data);
        if ($r) {
            pdo_update('xcommunity_users', array('balance' => $users['balance'] - number_format(floatval($_GPC['cash']), 2)), array('id' => $users['id']));
            message('提交成功', referer(), 'success');
        }
    }
    include $this->template('web/users/cash');
}






