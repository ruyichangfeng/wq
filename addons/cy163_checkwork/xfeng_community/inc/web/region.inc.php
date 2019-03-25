<?php
/**
 * 微小区模块
 *
 * [晓锋] Copyright (c) 2013 qfinfo.cn
 */
/**
 * 后台小区信息
 */
	global $_GPC,$_W;
    $do = $_GPC['do'];
    $method = 'fun';
    $GLOBALS['frames'] = $this->NavMenu($do, $method);
    $xqmenu = $this->xqmenu();
	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
	$uid = $_W['uid'];
	$id = intval($_GPC['id']);
    //判断是否是操作员
    $user = $this->user();
	if ($op == 'add') {
		if (empty($id)) {
            if($user){
                $total =pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_region')."WHERE weid='{$_W['uniacid']}' and uid=:uid",array(':uid' => $_W['uid']));
                if($user['uuid']&&$user['uuid']!=1){
                    $u = pdo_fetch("SELECT groupid FROM".tablename("xcommunity_users")."WHERE weid=:uniacid AND uid=:uid",array(":uniacid" => $_W['uniacid'],":uid" => $user['uuid']));
                    $groupid = $u['groupid'];
                    if($groupid){
                        $group = pdo_get('xcommunity_users_group',array('id'=> $groupid),array('maxaccount'));
                        $maxaccount = $group['maxaccount'];
                    }
                }else{
                    $xquser = pdo_fetch("SELECT * FROM".tablename('xcommunity_users')."as u left join".tablename('xcommunity_users_group')."as g on u.groupid = g.id WHERE u.uid=:uid",array(':uid' => $uid));
                    if($xquser){
                        $groupid = $xquser['groupid'];
                        $maxaccount = $xquser['maxaccount'];
                    }
                }
                if($groupid){
                    if($total >= $maxaccount){
                        message("已经达到添加小区上限",$this->createWebUrl('region',array('op' => 'list')),'success');exit();
                    }
                }

            }
		}
		if ($id) {
				$item = pdo_fetch("SELECT * FROM".tablename('xcommunity_region')."WHERE weid=:weid AND id=:id",array(":id" => $id,":weid" => $_W['weid']));
				if (empty($item)) {
					message('不存在该小区信息或已删除',referer(),'error');
				}
			}
		if (checksubmit('submit')) {
			$reside = $_GPC['reside'];
			$data = array(
					'weid' => $_W['weid'],
					'title' => $_GPC['title'],
					'linkmen' => $_GPC['linkmen'],
					'linkway' => $_GPC['linkway'],
					'lng' => $_GPC['baidumap']['lng'],
                	'lat' => $_GPC['baidumap']['lat'],
                	'address' => $_GPC['address'],
                	'url' => $_GPC['url'],
                	'thumb' => $_GPC['thumb'],
                	'qq' => $_GPC['qq'],
                	'province' => $reside['province'],
					'city' => $reside['city'],
					'dist' => $reside['district'],
					'pic' => $_GPC['pic'],
                    'keyword' => $_GPC['keyword']
				);
			$ru = pdo_get('rule',array('name' => $_GPC['title']),array('id'));
			if(empty($ru)){
				$rule = array(
					'uniacid' => $_W['uniacid'],
					'name'    => $_GPC['title'],
					'module'  => 'cover',
					'status'  => 1,
				);
				$result = pdo_insert('rule', $rule);
				$rid = pdo_insertid();
			}else{
				$rid = $ru['id'];
			}
			if ($id) {
				$data['rid'] = $ru['id'];
				pdo_update("xcommunity_region",$data,array('id'=>$_GPC['id']));
				$regionid = $id;
			}else{
				$region = pdo_fetch("SELECT id FROM".tablename('xcommunity_region')."WHERE weid='{$_W['weid']}' AND title='{$_GPC['title']}' AND province='{$_GPC['province']}' AND city='{$_GPC['city']}' AND dist='{$_GPC['dist']}'");
				if ($region) {
					message('该小区已经存在,无需在添加.',referer(),'error');
				}
				$data['rid'] = $rid;
                $data['uid'] = $_W['uid'];
				pdo_insert("xcommunity_region",$data);
				$regionid = pdo_insertid();
				if($user){
                    $company =pdo_get('xcommunity_property',array('id' => $user['companyid']),array('id','regionid'));
                    $regionids = unserialize($company['regionid']);
                    $newregionid = implode(',',$regionids).','.$regionid;
                    $newregionids = serialize(explode(',',$newregionid));
                    pdo_update('xcommunity_property',array('regionid'=>$newregionids),array('id'=> $company['id']));
                }


			}
			$rules = pdo_get("rule_keyword",array('rid' => $rid),array('id'));
			$covers = pdo_get('cover_reply',array('rid' => $rid),array('id'));
            $ruleword = array(
                'rid' => $rid,
                'uniacid' => $_W['uniacid'],
                'module' => 'cover',
                'content' => $data['keyword'],
                'type' => 1,
                'status' => 1,
            );
			if(empty($rules)){
				pdo_insert('rule_keyword', $ruleword);
			}else{
			    pdo_update('rule_keyword',$ruleword,array('id'=>$rules['id']));
            }
			$crid = $ru ? $ru['id'] : $rid;
			$entry = array(
				'uniacid' =>  $_W['uniacid'],
				'multiid' => 0,
				'rid' => $crid,
				'title' => $_GPC['title'],
				'description' => '',
				'thumb' => tomedia($_GPC['pic']),
				'url' => $this->createMobileUrl('register', array('op' => 'member','regionid' => $regionid ,'type' => 1)),
				'do' => 'register',
				'module' => 'xfeng_community',
			);
 			if(empty($covers)){

				pdo_insert('cover_reply', $entry);
			}else{

				pdo_update('cover_reply',$entry,array('rid' => $crid));
			}

			message('提交成功',referer(), 'success');
		}
		load()->func('tpl');
		include $this->template('web/region/add');
	}elseif ($op == 'list') {
		$pindex = max(1, intval($_GPC['page']));
		$psize  = 20;
		$condition = '';
		if (!empty($_GPC['keyword'])) {
			$condition .= " AND r.title LIKE :keyword";
			$params[':keyword'] = "%{$_GPC['keyword']}%";
		}
		$reside = $_GPC['reside'];
		if (!empty($reside)) {
			if ($reside['province']) {
				$condition .= " AND r.province = :province";
				$params[':province'] = $reside['province'];
			}
			if ($reside['city']) {
				$condition .= " AND r.city = :city";
				$params[':city'] = $reside['city'];
			}
			if ($reside['district']) {
				$condition .= " AND r.dist = :dist";
				$params[':dist'] = $reside['district'];
			}
			
		}
        if ($user[type] == 2) {
            //普通管理员
            $condition .= " AND r.uid='{$_W['uid']}'";
        }
        if ($user[type] == 3) {
            //普通管理员
            $condition .= " AND r.id in({$user['regionid']})";
        }
		$list = pdo_fetchall("SELECT r.commission as commission,r.address as address,r.province as province,r.city as city ,r.dist as dist,r.qq,r.title as rtitle ,r.id,r.linkmen,r.linkway,p.title as ptitle,r.url FROM".tablename('xcommunity_region')."as r left join ".tablename('xcommunity_property')."as p on r.pid = p.id WHERE r.weid='{$_W['weid']}' $condition LIMIT ".($pindex - 1) * $psize.','.$psize,$params);
		$total =pdo_fetchcolumn("SELECT COUNT(*) FROM".tablename('xcommunity_region')."as r left join ".tablename('xcommunity_property')."as p on r.pid = p.id WHERE r.weid='{$_W['weid']}' $condition",$params);
		$pager  = pagination($total, $pindex, $psize);
		load()->func('tpl');
		include $this->template('web/region/list');
	}elseif ($op == 'delete') {
		//小区删除
		if ($id) {
			$item = pdo_fetch("SELECT * FROM".tablename('xcommunity_region')."WHERE id=:id AND weid=:weid",array(":id" => $id,":weid" => $_W['weid']));
			if (empty($item)) {
				message("不存在该小区信息或已删除",referer(),'error');
			}
			pdo_delete('xcommunity_region',array('id' => $_GPC['id']));
			pdo_delete('xcommunity_member',array('regionid' => $_GPC['id']));
			message('删除成功',referer(), 'success');
		}

	}elseif ($op == 'room') {
		//房号导入
		if (checksubmit('submit')) {
				if (!empty($_FILES['room']['name'])) {
						$tmp_file   = $_FILES['room']['tmp_name'];
						$file_types = explode(".",$_FILES['room']['name']);
						$file_type  = $file_types[count($file_types)-1];
						/*判别是不是.xls文件，判别是不是excel文件*/
						if (strtolower ( $file_type ) !="xls" && strtolower ( $file_type ) !="xlsx") 
						{
							message('类型不正确，请重新上传',referer(),'error');
						}
					  /*设置上传路径*/
					   $savePath = IA_ROOT.'/addons/xfeng_community/template/upFile/';
					  /*以时间来命名上传的文件*/
					   $str = date('Ymdhis'); 
					   $file_name = $str.".".$file_type;
					   /*是否上传成功*/
					   if (!copy($tmp_file,$savePath.$file_name)) {
					   		message('上传失败');
					     
					   }
					  $res = $this->read($savePath.$file_name);
					  $result = pdo_fetch("SELECT * FROM".tablename('xcommunity_room')."WHERE regionid=:id AND uniacid=:uniacid ",array(':uniacid' => $_W['uniacid'],':id' => $id));
				  	  if ($result) {
				  	  	message('该小区已存在房号数据',referer(),'success');exit();
				  	  }
					  /*对生成的数组进行数据库的写入*/
					  foreach ( $res as $k => $v ) {
						    if ($k != 0) {
								$data['room']     = $v[0];
								$data['mobile']   = $v[1];
								$data['code']     = random(8);
								$data['regionid'] = $id;
								$data['uniacid']  = $_W['uniacid'];
								//print_r($data);exit();
								$result = pdo_insert('xcommunity_room',$data);
						    }
					  }

					  if($result){
				       		message('导入成功',referer(),'success');
				     	}
					}
				}

		include $this->template('web/region/room');
	}elseif ($op == 'rlist') {
		//房号显示
		$pindex = max(1, intval($_GPC['page']));
		$psize  = 20;
		$condition = 'uniacid=:uniacid';
		$params[':uniacid'] = $_W['uniacid'];
		$condition .= ' AND regionid=:regionid';
		$params[':regionid'] = $id;
		if (!empty($_GPC['keyword'])) {
			$condition .= " AND room LIKE :keyword";
			$params[':keyword'] = "%{$_GPC['keyword']}%";
		}
		$rid=$_GPC['rid'];
		if (!empty($rid)) {
			$ids = implode(',',$rid);
			$condition .=" AND id in({$ids})";
		}
		$sql = "SELECT * FROM".tablename('xcommunity_room')."WHERE $condition LIMIT ".($pindex - 1) * $psize.','.$psize;
		$list = pdo_fetchall($sql,$params);
		$tsql = "SELECT COUNT(*) FROM".tablename('xcommunity_room')."WHERE $condition";
		$total =pdo_fetchcolumn($tsql,$params);
		$pager  = pagination($total, $pindex, $psize);
		//删除用户
		if (checksubmit('delete')) {
			
			if (!empty($ids)) {
				foreach ($ids as $key => $id) {
					pdo_delete('xcommunity_room',array('id' => $id));
				}
				message('删除成功',referer(),'success');
			}
		}
		//导出用户
		if (checksubmit('export')) {
			$sql = "SELECT * FROM".tablename('xcommunity_room')."WHERE $condition ";
			$li = pdo_fetchall($sql,$params);
				$this->export($li,array(
			            "title" => "房号数据-" . date('Y-m-d-H-i', time()),
			            "columns" => array(
			                array(
			                    'title' => '房号',
			                    'field' => 'room',
			                    'width' => 16
			                ),
			                array(
			                    'title' => '手机号',
			                    'field' => 'mobile',
			                    'width' => 14
			                ),
			                array(
			                    'title' => '注册码',
			                    'field' => 'code',
			                    'width' => 18
			                ),
			              
			            )
					));
		}
		if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'room' => $_GPC['room'],
					'mobile' => $_GPC['mobile'],
					'regionid' => $id,
					'code' => random(8)
				);
			$room = pdo_fetch("SELECT * FROM".tablename('xcommunity_room')."WHERE mobile=:mobile or room=:room",array(':mobile' => $data['mobile'],':room' => $data['room']));
			if ($room) {
				message('手机号码或者房号已存在',$this->createWebUrl('region',array('op' => 'rlist','id' => $id)),'error');exit();
			}
			if (empty($room)) {
				$r = pdo_insert('xcommunity_room',$data);
				if ($r) {
					message('添加成功',$this->createWebUrl('region',array('op' => 'rlist','id' => $id)),'success');
				}
			}
		}
		include $this->template('web/region/rlist');
	}elseif ($op == 'edit') {
		//房号编辑
		$rid = intval($_GPC['rid']);
		if (empty($rid)) {
			message('缺少参数',referer,'error');
		}
		if ($rid) {
			$item = pdo_fetch("SELECT room,mobile FROM".tablename('xcommunity_room')."WHERE id=:id",array(':id' => $rid));
		}
		if (checksubmit('submit')) {
			$data = array(
					'room' => $_GPC['room'],
					'mobile' => $_GPC['mobile'],
				);
			if ($rid) {
				$r = pdo_update('xcommunity_room',$data,array('id' => $rid));
				if ($r) {
					message('修改成功',$this->createWebUrl('region',array('op' => 'rlist','id' => $id)),'success');
				}
			}
		}
		include $this->template('web/region/edit');
	}elseif($op == 'open'){
		//显示访客记录信息
		$pindex = max(1, intval($_GPC['page']));
		$psize  = 20;
		$regionid = intval($_GPC['regionid']);
		$params[':uniacid'] = $_W['uniacid'];
		$params[':regionid'] = $regionid;
		$condition ='';
		if($user[type] == 3){
		    $condition .=" and r.id in({$user['$regionid']})";
        }
		$sql    = "select l.*,r.title from ".tablename("xcommunity_open_log")."as l left join".tablename("xcommunity_region")."as r on l.regionid = r.id where l.uniacid=:uniacid AND l.regionid=:regionid order by createtime desc LIMIT ".($pindex - 1) * $psize.','.$psize;
		$list   = pdo_fetchall($sql,$params);
		foreach ($list as $key=> $val){
		    $member = $this->member($val['openid']);
		    $list[$key]['address'] = $member['address'];
        }
		$total  = pdo_fetchcolumn('select count(*) from'.tablename("xcommunity_open_log")."as l left join".tablename("xcommunity_region")."as r on l.regionid = r.id where l.uniacid=:uniacid AND l.regionid=:regionid order by createtime desc ",$params);
		$pager  = pagination($total, $pindex, $psize);
        //删除
        if ($_W['ispost']) {
            $ids=$_GPC['ids'];
            if (!empty($ids)) {
                foreach ($ids as $key => $id) {
                    pdo_delete('xcommunity_open_log',array('id' => $id));
                }
                message('删除成功',referer(),'success');
            }
        }
		include $this->template('web/region/open');
	}elseif ($op == 'set'){
        $regionid = trim(intval($_GPC['regionid']));
        $key = 'xqset';
        $set = ln_syssetting_read($regionid,$key);
        if(checksubmit('submit')){
            $data = $_GPC['set'];
            if (ln_syssetting_save($data,$key, $regionid)){
                message('提交成功',referer(),'success');
            }
        }

	    include $this->template('web/region/set');
    }elseif($op =='sms'){
        $regionid = trim(intval($_GPC['regionid']));
        $key = 'xqsms';
        $set = ln_syssetting_read($regionid,$key);
        if(checksubmit('submit')){
            $data = $_GPC['sms'];
            if (ln_syssetting_save($data,$key, $regionid)){
                message('提交成功',referer(),'success');
            }
        }

        include $this->template('web/region/sms');
    }elseif($op =='xqprint'){
        $regionid = trim(intval($_GPC['regionid']));
        $key = 'xqprint';
        $set = ln_syssetting_read($regionid,$key);

        if(checksubmit('submit')){
            $data = $_GPC['print'];
            if (ln_syssetting_save($data,$key, $regionid)){
                message('提交成功',referer(),'success');
            }
        }

        include $this->template('web/region/xqprint');
    }elseif($op == 'fields'){
        $regionid = trim(intval($_GPC['regionid']));
        $key = 'field';
        $set = ln_syssetting_read($regionid,$key);

        if(checksubmit('submit')){
            $data = $_GPC['set'];
            if (ln_syssetting_save($data,$key, $regionid)){
                message('提交成功',referer(),'success');
            }
        }

        include $this->template('web/region/fields');
    }












	