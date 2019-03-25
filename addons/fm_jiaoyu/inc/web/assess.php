<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
		global $_GPC, $_W;
		$action            = 'assess';
		$this1             = 'no2';
		$schoolid          = intval($_GPC['schoolid']);
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
		$weid              = $_W['uniacid'];
		$logo              = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if(empty($schoolid)){
			$this->imessage('非法操作!', referer(), 'error');
		}
		if($operation == 'post'){
			load()->func('tpl');
			$id = intval($_GPC['id']);
			$fz = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'jsfz', ':schoolid' => $schoolid));
			$xueqi = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));
			$km = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
			$bj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
			$lastid = pdo_fetch("SELECT id FROM " . tablename($this->table_class) . " ORDER by id DESC LIMIT 0,1");
			$lastids = empty($lastid['id']) ? 1000 :$lastid['id'];
			if(!empty($id)){
				$item = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $id));
				$bjlists = get_mylist($schoolid,$item['id'],'teacher');
				if(empty($item)){
					$this->imessage('抱歉，教师不存在或是已经删除！', referer(), 'error');
				}else{
					if(!empty($item['thumb_url'])){
						$item['thumbArr'] = explode('|', $item['thumb_url']);
					}
				}
			}
			if($item['code'] == 0){
				$randStr = str_shuffle('123456789');
				$rand    = substr($randStr, 0, 6);
			}else{
				$rand = $item['code'];
			}
			if(!empty($_GPC['code'])){
				$rand = $_GPC['code'];
			}
			if(checksubmit('submit')){
				$data = array(
					'weid'      => $weid,
					'schoolid'  => $schoolid,
					'tname'     => trim($_GPC['tname']),
					'birthdate' => strtotime($_GPC['birthdate']),
					'tel'       => trim($_GPC['tel']),
					'mobile'    => trim($_GPC['mobile']),
					'thumb'     => trim($_GPC['thumb']),
					'email'     => trim($_GPC['email']),
					'jiontime'  => strtotime($_GPC['jiontime']),
					'sex'       => intval($_GPC['sex']),
					'is_show'   => intval($_GPC['is_show']),
					'status'    => intval($_GPC['status']),
					'sort'      => intval($_GPC['sort']),
					'fz_id'     => trim($_GPC['fz_id']),
					'headinfo'  => trim($_GPC['headinfo']),
					'jinyan'    => trim($_GPC['jinyan']),
					'info'      => htmlspecialchars_decode($_GPC['info']),
					'code'      => $rand,
				);
				
				if(empty($data['tname'])){
					$this->imessage('请输入教师姓名！', referer(), 'error');
				}
				if(!empty($_FILES['thumb']['tmp_name'])){
					load()->func('file');
					file_delete($_GPC['thumb_old']);
					$upload = file_upload($_FILES['thumb']);
					if(is_error($upload)){
						$this->imessage($upload['message'], '', 'error');
					}
					$data['thumb'] = $upload['path'];
				}
				if(!$_W['isfounder']){
					if($id == 44){
						$this->imessage('抱歉，你无权编辑此教师（此老师是管理员绑定的），请另行添加或解绑其他老师！');
					}				
					if($id == 13){
						$this->imessage('抱歉，你无权编辑此教师（此老师是管理员绑定的），请另行添加或解绑其他老师！');
					}
				}
				if(empty($id)){
					pdo_insert($this->table_teachers, $data);
					$thistid = pdo_insertid();
				}else{
					unset($data['dateline']);
					pdo_update($this->table_teachers, $data, array('id' => $id));
					$thistid = $id;
				}
				if(!empty($_GPC['thisid'])){
					if(!empty($_GPC['old'])){
						foreach($_GPC['thisid'] as $key => $thisid){
							if(!empty($thisid)){
								$data1  = array(
									'bj_id' 	 => trim($_GPC['bj_id'][$key]),
									'km_id' 	 => trim($_GPC['km_id'][$key]),
								);
								pdo_update($this->table_class, $data1, array('id' => $thisid));
							}
						}
					}
					if(!empty($_GPC['new'])){
						foreach($_GPC['new'] as $key => $title){
							$data2  = array(
								'weid'       => $weid,
								'schoolid'   => $schoolid,
								'tid'      	 => $thistid,
								'bj_id' 	 => trim($_GPC['bj_id_new'][$key]),
								'km_id' 	 => trim($_GPC['km_id_new'][$key]),
								'type'       => 1
							);
							pdo_insert($this->table_class, $data2);
						}
					}
				}else{
					foreach($_GPC['new'] as $key => $title){
						$data3  = array(
							'weid'       => $weid,
							'schoolid'   => $schoolid,
							'tid'      	 => $thistid,
							'bj_id' 	 => trim($_GPC['bj_id_new'][$key]),
							'km_id' 	 => trim($_GPC['km_id_new'][$key]),
							'type'       => 1
						);
						pdo_insert($this->table_class, $data3);
					}
				}				
				$this->imessage('操作成功', $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}
		}elseif($operation == 'changebjdata'){
				$oldbjdata = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} ORDER BY id DESC");
				foreach($oldbjdata as $index => $row){
					if($row['bj_id1']){
						$data1 = array(
							'weid'     => $weid,
							'schoolid' => $schoolid,
							'tid'      => $row['id'],
							'bj_id'    => $row['bj_id1'],
							'km_id'    => $row['km_id1'],
							'type'     => 1,
						);
						pdo_insert($this->table_class, $data1);
					}
					if($row['bj_id2']){
						$data2 = array(
							'weid'     => $weid,
							'schoolid' => $schoolid,
							'tid'      => $row['id'],
							'bj_id'    => $row['bj_id2'],
							'km_id'    => $row['km_id2'],
							'type'     => 1,
						);
						pdo_insert($this->table_class, $data2);						
					}
					if($row['bj_id3']){
						$data2 = array(
							'weid'     => $weid,
							'schoolid' => $schoolid,
							'tid'      => $row['id'],
							'bj_id'    => $row['bj_id3'],
							'km_id'    => $row['km_id3'],
							'type'     => 1,
						);
						pdo_insert($this->table_class, $data2);							
					}					
				}
				$this->imessage('操作成功', $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
		}elseif($operation == 'display'){

			$pindex    = max(1, intval($_GPC['page']));
			$psize     = 8;
			$condition = '';
			if(!empty($_GPC['keyword'])){
				$condition .= " AND tname LIKE '%{$_GPC['keyword']}%'";
			}

			if(!empty($_GPC['bj_id'])){
				$bj_id     = $_GPC['bj_id'];
				$condition .= " AND (bj_id1 = '{$bj_id}' or bj_id2 = '{$bj_id}' or bj_id3 = '{$bj_id}')";
			}

			if(!empty($_GPC['km_id'])){
				$km_id     = $_GPC['km_id'];
				$condition .= " AND (km_id1 = '{$km_id}' or km_id2 = '{$km_id}' or km_id3 = '{$km_id}')";
			}
			$checkbjold = pdo_fetch("SELECT * FROM " . tablename($this->table_class) . " WHERE schoolid = :schoolid And type = :type ", array(':schoolid' => $schoolid,':type' => 1));
			//////////导出数据/////////////////
			if($_GPC['out_putbjlist'] == 'out_putbjlist'){
				$listss = pdo_fetchall("SELECT tname,id FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} ORDER BY id DESC");
				$ii   = 0;
				foreach($listss as $index => $row){
					$arr[$ii]['id'] = $row['id'];
					$arr[$ii]['tname']  = $row['tname'];
					$ii++;
				}
				$this->exportexcel($arr, array('ID','姓名','班级ID','科目ID'), 'example_bjlist');
                exit();
			}
			////////////////////////////////			
			//////////导出数据/////////////////
			if($_GPC['out_putcode'] == 'out_putcode'){
				$listss = pdo_fetchall("SELECT tname,code,mobile FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ORDER BY id DESC");
				$ii   = 0;
				foreach($listss as $index => $row){
					$arr[$ii]['tname'] = $row['tname'];
					$arr[$ii]['code']  = $row['code'];
					$arr[$ii]['mobile']= $row['mobile'];
					$ii++;
				}
				$this->exportexcel($arr, array('教师','绑定码','手机'), '教师绑定码');
                exit();
			}
			////////////////////////////////
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition ORDER BY status DESC, sort DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			foreach($list as $key => $value){
				$member                 = pdo_fetch("SELECT nickname,avatar FROM " . tablename('mc_members') . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['uid']));	
				$kcnum = pdo_fetchcolumn("select count(*) FROM ".tablename($this->table_tcourse)." WHERE tid = '".$value['id']."'");
				$nowtime = time();
				$zks = pdo_fetchcolumn("select count(*) FROM ".tablename($this->table_kcbiao)." WHERE tid = '".$value['id']."'");
				$wwks = pdo_fetchcolumn("select count(*) FROM ".tablename($this->table_kcbiao)." WHERE date > '".$nowtime."' And  tid = '".$value['id']."'");
				$ywks = pdo_fetchcolumn("select count(*) FROM ".tablename($this->table_kcbiao)." WHERE date < '".$nowtime."' And  tid = '".$value['id']."'");
				$list[$key]['nickname'] = $member['nickname'];
				$list[$key]['avatar']   = $member['avatar'];
				$list[$key]['kcnum'] = $kcnum;
				$bjlists = get_mylist($schoolid,$value['id'],'teacher');
				$list[$key]['bjlist'] = $bjlists;
				$list[$key]['zks'] = $zks;
				$list[$key]['wwks'] = $wwks;
				$list[$key]['ywks'] = $ywks;
			}
			
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_teachers) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition");

			$pager = pagination($total, $pindex, $psize);
			
		}elseif($operation == 'delete'){
			$tid = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $tid));
			if(empty($row)){
				$this->imessage('抱歉，教师不存在或是已经被删除！', referer(), 'error');
			}
			if(!empty($row['openid'])){
				$this->imessage('请先解绑该教师的微信！', referer(), 'error');
			}
			if(!empty($row['thumb'])){
				load()->func('file');
				file_delete($row['thumb']);
			}
			if(!empty($row['userid'])){
				pdo_delete($this->table_user, array('id' => $row['userid']));
			}else{
				pdo_delete($this->table_user, array('tid' => $id, 'sid' => 0));
			}
			pdo_delete($this->table_teachers, array('id' => $tid));
			$this->imessage('删除成功！', $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
		}elseif($operation == 'jiebang'){
			$id  = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $id));
			if(empty($row)){
				$this->imessage('抱歉，教师不存在或是已经被删除！', referer(), 'error');
			}
			if($row['id'] == 13){
				$this->imessage('抱歉，你无权解绑此教师（此老师是管理员绑定的），请另行添加或解绑其他老师！', referer(), 'error');
			}			
			$temp = array(
				'openid' => '',
				'userid' => 0,
				'uid'    => 0
			);
			if(!empty($row['userid'])){
				pdo_delete($this->table_user, array('id' => $row['userid']));
			}else{
				pdo_delete($this->table_user, array('tid' => $id, 'openid' => $row['openid'], 'sid' => 0, 'pard' => 0));
			}
			pdo_update($this->table_teachers, $temp, array('id' => $id));
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'deleteall'){
			$rowcount    = 0;
			$notrowcount = 0;
			foreach($_GPC['idArr'] as $k => $id){
				$id = intval($id);
				if(!empty($id)){
					$assess = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $id));
					if(!empty($assess['uid'])){
						$message = '批量删除失败，老师' . $assess['tname'] . '微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}
					if(empty($assess)){
						$notrowcount++;
						continue;
					}
					pdo_delete($this->table_teachers, array('id' => $id, 'weid' => $weid));
					$rowcount++;
				}
			}
			$message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";

			$data ['result'] = true;

			$data ['msg'] = $message;

			die (json_encode($data));
		}elseif($operation == 'add'){
			load()->func('tpl');
			$id      = intval($_GPC['id']);
			$xueqi = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));
			$km = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
			$bj = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
			$row     = pdo_fetch("SELECT id, thumb FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $id));
			$payweid = pdo_fetchall("SELECT * FROM " . tablename('account_wechats') . " where level = 4 ORDER BY acid ASC");
			if(!empty($id)){
				$item = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE id = :id", array(':id' => $id));
				if(empty($item)){
					$this->imessage('抱歉，教师不存在或是已经删除！', referer(), 'error');
				}else{
					if(!empty($item['thumb_url'])){
						$item['thumbArr'] = explode('|', $item['thumb_url']);
					}
				}
			}
			if(checksubmit('submit')){
				$data = array(
					'weid'     => $weid,
					'schoolid' => $schoolid,
					'tid'      => intval($_GPC['id']),
					'xq_id'    => trim($_GPC['xq']),
					'km_id'    => trim($_GPC['km']),
					'bj_id'    => trim($_GPC['bj']),
					'name'     => trim($_GPC['name']),
					'is_hot'   => intval($_GPC['is_hot']),
					'minge'    => trim($_GPC['minge']),
					'cose'     => trim($_GPC['cose']),
					'dagang'   => trim($_GPC['dagang']),
					'adrr'     => trim($_GPC['adrr']),
					'start'    => strtotime($_GPC['start']),
					'end'      => strtotime($_GPC['end']),
					'payweid'  => empty($_GPC['payweid']) ? $weid : intval($_GPC['payweid']),
				);

				pdo_insert($this->table_tcourse, $data);
				$this->imessage('操作成功', $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}
		}elseif($operation == 'delclass'){
			$id      = intval($_GPC['id']);
			pdo_delete($this->table_class, array('id' => $id,'schoolid' => $schoolid));
		}elseif($operation == 'clear'){
			pdo_delete($this->table_teachers, array('birthdate' => 0, 'sex' => 0, 'jiontime' => 0, 'weid' => $weid, 'schoolid' => $schoolid));
			$this->imessage('清理成功', $this->createWebUrl('assess', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
		}
		include $this->template('web/assess');
?>