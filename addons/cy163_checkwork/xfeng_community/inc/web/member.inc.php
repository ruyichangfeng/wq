<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 后台小区用户信息
 */

	global $_GPC,$_W;
    $do = $_GPC['do'];
    $method = 'fun';
    $GLOBALS['frames'] = $this->NavMenu($do, $method);
    $xqmenu = $this->xqmenu();
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
	$id        = intval($_GPC['id']);
    $regions = $this->regions();
    $user = $this->user();
	if ($op == 'list') {
	        if($_W['ispost']){
	            $door = pdo_get('xcommunity_bind_door',array('openid' => $_GPC['openid'],'regionid' => intval($_GPC['regionid'])),array('id'));
	            $data = array(
                    'regionid' => intval($_GPC['regionid']),
                    'deviceid' => implode(",",$_GPC['deviceid']),
                    'openid'   => $_GPC['openid']
                );
	            if($door){
	                pdo_update('xcommunity_bind_door',$data,array('id'=> $door['id']));
                }else{
                    $data['uniacid'] =  $_W['uniacid'];
	                pdo_insert('xcommunity_bind_door',$data);
                }
                message("绑定成功",referer(),'success');
            }
			$condition = ' AND m.type = 0';
			if (!empty($_GPC['realname'])) {
				$condition .= " AND m.realname LIKE '%{$_GPC['realname']}%'";
			}
			if (!empty($_GPC['mobile'])) {
				$condition .= " AND m.mobile LIKE '%{$_GPC['mobile']}%'";
			}
			if (!empty($_GPC['openid'])) {
				$condition .= " AND m.openid='{$_GPC['openid']}'";
			}
			if (!empty($_GPC['room'])) {
				$condition .= " AND m.address LIKE '%{$_GPC['room']}%'";
			}
			if (is_array($_GPC['regionid'])) {
				$regionid = implode(',', $_GPC['regionid']);
				$condition .= " AND m.regionid in($regionid)";
			}
            if ($user[type] == 3) {
                //普通管理员
                $condition .= " and m.regionid in({$user['regionid']})";
            }
			//显示业主信息
			$pindex = max(1, intval($_GPC['page']));
			$psize  = 10;
			$sql    = "select m.*,r.title as title,r.city,r.dist from ".tablename("xcommunity_member")."as m left join".tablename('xcommunity_region')."as r on m.regionid = r.id where m.weid='{$_W['weid']}' $condition  order by m.createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize;
			$list   = pdo_fetchall($sql,$params);
			foreach ($list as $key => $value) {
				$list[$key]['cctime'] = date('Y-m-d H:i',$value['createtime']);
				$list[$key]['s'] = empty($value['status']) ? '未审核' : '通过';
			}
			$total  = pdo_fetchcolumn('select count(*) from'.tablename("xcommunity_member")."as m left join".tablename('xcommunity_region')."as r on m.regionid = r.id where m.weid='{$_W['weid']}' $condition order by m.id desc",$params);
			$pager  = pagination($total, $pindex, $psize);
			if ($_GPC['export'] == 1) {
				$sql    = "select m.*,r.title as title,r.city,r.dist from ".tablename("xcommunity_member")."as m left join".tablename('xcommunity_region')."as r on m.regionid = r.id where m.weid='{$_W['weid']}' $condition order by m.id desc ";
				$li   = pdo_fetchall($sql,$params);
                foreach ($li as $key => $value) {
                    $li[$key]['cctime'] = date('Y-m-d H:i',$value['createtime']);
                    $li[$key]['s'] = empty($value['status']) ? '未审核' : '通过';
                }
				$this->export($li,array(
			            "title" => "会员数据-" . date('Y-m-d-H-i', time()),
			            "columns" => array(
			                array(
			                    'title' => '姓名',
			                    'field' => 'realname',
			                    'width' => 12
			                ),
			                array(
			                    'title' => '手机号',
			                    'field' => 'mobile',
			                    'width' => 12
			                ),
			                array(
			                    'title' => '地址',
			                    'field' => 'address',
			                    'width' => 12
			                ),
			                array(
			                    'title' => '注册时间',
			                    'field' => 'cctime',
			                    'width' => 12
			                ),
			                array(
			                    'title' => '状态',
			                    'field' => 's',
			                    'width' => 12
			                ),
			            )
			        ));
			}
			load()->func('file');
			include $this->template('web/member/list');

	}elseif($op == 'add') {
		//查看住户信息
		if ($id) {
			$member = pdo_fetch("SELECT * FROM".tablename('xcommunity_member')."WHERE id=:id",array(':id' => $id));
		}
		// print_r($member);exit();
		//查看小区信息
		$regions = $this->regions();
		if(checksubmit('submit')){
		//修改用户信息
			$data = array(
				'regionid'   =>$_GPC['_regionid'],
				'remark'     =>$_GPC['remark'],
				'createtime' =>$_W['timestamp'],
				'mobile'	 =>$_GPC['mobile'],
				'realname'   =>$_GPC['realname'],
				'build'		 => $_GPC['build'],
				'unit'		 => $_GPC['unit'],
				'room'		 => $_GPC['room'],
				'address'    => $_GPC['address']
 			);
			load()->model('mc');
			if($member['memberid']){
				$result = mc_fetch($member['memberid'], array('uid', 'mobile'));
				if($result){
//					$r = mc_update($member['memberid'], array('mobile' => $_GPC['mobile'],'realname' => $_GPC['realname'],'address' => $_GPC['address']));
					pdo_update('mc_members',array('mobile' => $_GPC['mobile'],'realname' => $_GPC['realname'],'address' => $_GPC['address']),array('uid' => $member['memberid']));
				}
			}
			if ($id) {
				pdo_update("xcommunity_member",$data,array('id' => $id));
				message('修改成功',$this->createWebUrl('member'), 'success');
			}
			
		}	
		include $this->template('web/member/add');	
	}elseif ($op == 'delete') {
		//删除用户
		
			if (empty($id)) {
				exit('缺少参数');
			}
			$r = pdo_delete("xcommunity_member",array('id' => $id));
			if ($r) {
				message('删除成功',referer(),'success');
				
			}
	
	}elseif($op == 'verify'){
		//审核用户
		$id = intval($_GPC['id']);
		$type = $_GPC['type'];
		$data = intval($_GPC['data']);
		if (in_array($type, array('status','open_status'))) {
			$data = ($data==1?'0':'1');
			pdo_update("xcommunity_member", array($type => $data), array("id" => $id, "weid" => $_W['uniacid']));
			die(json_encode(array("result" => 1, "data" => $data)));
		}
	}elseif($op == 'visit'){
		$condition = ' AND m.type = 1';

		if (is_array($_GPC['regionid'])) {
			$regionid = implode(',', $_GPC['regionid']);
			$condition .= " AND m.regionid in($regionid)";
		}
        if ($user[type] == 2) {
            //普通管理员
            $condition .= " AND uid='{$_W['uid']}'";
        }
        if (!empty($_GPC['openid'])) {
            $condition .= " AND m.openid='{$_GPC['openid']}'";
        }
		//显示业主信息
		$pindex = max(1, intval($_GPC['page']));
		$psize  = 10;
		$sql    = "select m.*,r.title as title,r.city,r.dist from ".tablename("xcommunity_member")."as m left join".tablename('xcommunity_region')."as r on m.regionid = r.id where m.weid='{$_W['weid']}' $condition order by m.id desc LIMIT ".($pindex - 1) * $psize.','.$psize;
		$list   = pdo_fetchall($sql,$params);
		foreach ($list as $key => $value) {
			$list[$key]['cctime'] = date('Y-m-d H:i',$value['createtime']);
			$list[$key]['s'] = empty($value['status']) ? '未审核' : '通过';
			load()->model('mc');
			$user = mc_fetch($value['openid'], array('nickname'));
			$list[$key]['nickname'] = $user['nickname'];
		}
		$total  = pdo_fetchcolumn('select count(*) from'.tablename("xcommunity_member")."as m left join".tablename('xcommunity_region')."as r on m.regionid = r.id where m.weid='{$_W['weid']}' $condition order by m.id desc",$params);
		$pager  = pagination($total, $pindex, $psize);
		include $this->template('web/member/visit');

	}elseif($op == 'bind'){
        $id = intval($_GPC['id']);
        if(empty($id)){
            message('缺少参数',referer(),'error');exit();
        }
        $member = pdo_get("xcommunity_member",array('id' => $id,'weid' => $_W['uniacid']),array('openid'));
        if(empty($member)){
            message('信息不存在或已被删除',referer(),'error');exit();
        }
        $members = pdo_getall('xcommunity_member',array('openid'=> $member['openid'],'weid' => $_W['uniacid'],'enable' => 0),array('realname','mobile','status','createtime','address','regionid','id'));
        foreach ($members as $key=>$val){
            $region = $this->region($val['regionid']);
            $members[$key][regiontitle] = $region['title'];
        }
	    include $this->template('web/member/bind');
    }elseif($op =='binddoor'){
	    if($_W['isajax']){
            $regionid = intval($_GPC['regionid']);
            if(empty($regionid)){
                echo json_encode(array('status' => 1,'content' => '缺少参数'));exit();
            }
            $openid = trim($_GPC['openid']);
            $door = pdo_get('xcommunity_bind_door', array('openid' => $openid, 'regionid' => $regionid), array('deviceid'));
            $doors = explode(',',$door['deviceid']);
            $devices = pdo_getall('xcommunity_building_device', array('regionid' => $regionid, 'uniacid' => $_W['uniacid']), array('title', 'id','unit'));
            $content ='';
            foreach ($devices as $key => $item){
                if(in_array($item['id'],$doors)){
                    $check = 'checked';
                    $devices[$key]['check'] = $check;
                }
            }
            if($devices){
                if($door){
                    echo json_encode(array('status' => 2,'content' => $devices,'result' => $door['deviceid']));exit();
                }else{
                    echo json_encode(array('status' => 2,'content' => $devices));exit();
                }

            }else{
                echo json_encode(array('status' => 3,'content' => '该小区未开通微信开门权限'));exit();
            }
        }

    }elseif($op =='m'){
        $condition = ' AND m.type = 0';
        if (!empty($_GPC['realname'])) {
            $condition .= " AND m.realname LIKE '%{$_GPC['realname']}%'";
        }
        if (!empty($_GPC['mobile'])) {
            $condition .= " AND m.mobile LIKE '%{$_GPC['mobile']}%'";
        }
        if (!empty($_GPC['openid'])) {
            $condition .= " AND m.openid='{$_GPC['openid']}'";
        }
        if (!empty($_GPC['room'])) {
            $condition .= " AND m.address='{$_GPC['room']}'";
        }
        if (is_array($_GPC['regionid'])) {
            $regionid = implode(',', $_GPC['regionid']);
            $condition .= " AND m.regionid in($regionid)";
        }
        if ($user[type] == 3) {
            //普通管理员
            $condition .= " and m.regionid in({$user['regionid']})";
        }
        //显示业主信息
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 10;
        $sql    = "select m.*,r.title as title,r.city,r.dist from ".tablename("xcommunity_member")."as m left join".tablename('xcommunity_region')."as r on m.regionid = r.id where m.weid='{$_W['weid']}' $condition and m.enable = 0 order by m.createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize;
        $list   = pdo_fetchall($sql,$params);
        foreach ($list as $key => $value) {
            $list[$key]['cctime'] = date('Y-m-d H:i',$value['createtime']);
            $list[$key]['s'] = empty($value['status']) ? '未审核' : '通过';
        }
        $total  = pdo_fetchcolumn('select count(*) from'.tablename("xcommunity_member")."as m left join".tablename('xcommunity_region')."as r on m.regionid = r.id where m.weid='{$_W['weid']}' $condition and m.enable = 0 order by m.id desc",$params);
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('web/member/m');
    }
