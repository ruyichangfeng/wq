<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
		global $_GPC, $_W;
		$weid              = $_W['uniacid'];
		$action            = 'students';
		$this1             = 'no2';
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'], $action);
		$schoolid          = intval($_GPC['schoolid']);
		$school            = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
		$logo              = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");	
				
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($operation == 'post'){
			load()->func('tpl');
			$id = intval($_GPC['id']);
			if(!empty($id)){
				$item = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
				if(empty($item)){
					$this->imessage('抱歉，学生不存在或是已经删除！', '', 'error');
				}else{
					if(!empty($item['thumb_url'])){
						$item['thumbArr'] = explode('|', $item['thumb_url']);
					}
				}
			}
			$xueqi             = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));
			$bj                = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));			
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
				$data  = array(
					'weid'           => $weid,
					'schoolid'       => $schoolid,
					's_name'         => trim($_GPC['s_name']),
					'icon'           => trim($_GPC['icon']),
					'sex'            => intval($_GPC['sex']),
					'bj_id'          => trim($_GPC['bj']),
					'xq_id'          => trim($_GPC['xueqi']),
					'numberid'       => trim($_GPC['numberid']),
					'birthdate'      => strtotime($_GPC['birthdate']),
					'homephone'      => trim($_GPC['tel']),
					'mobile'         => trim($_GPC['mobile']),
					'area_addr'      => trim($_GPC['addr']),
					'seffectivetime' => strtotime($_GPC['seffectivetime']),
					'stheendtime'    => strtotime($_GPC['stheendtime']),
					'note'           => trim($_GPC['note']),
					'code'           => $rand,
				);
				$check = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE s_name = :s_name And mobile = :mobile And schoolid = :schoolid", array(':s_name' => $_GPC['s_name'], ':mobile' => $_GPC['mobile'], ':schoolid' => $schoolid));
				if(empty($data['s_name'])){
					$this->imessage('请输入学生姓名！');
				}
				if(empty($data['mobile'])){
					$this->imessage('清输入学生家长手机');
				}
				if(empty($id)){
					if(!empty($check)){
						$this->imessage('录入失败，您输入的学生信息有重复！');
					}
					pdo_insert($this->table_students, $data);
				}else{
					$checkcard = pdo_fetch("SELECT * FROM " . tablename($this->table_idcard) . " WHERE sid = :sid", array(':sid' => $id));
					if($checkcard){
						pdo_update($this->table_idcard, array('bj_id' => trim($_GPC['bj'])), array('sid' => $id));
					}
					pdo_update($this->table_students, $data, array('id' => $id));
				}
				$this->imessage('操作学生信息成功！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}
		}elseif($operation == 'changebjdata'){
				$oldbjdata = pdo_fetchall("SELECT id,bj_id FROM " . tablename($this->table_students) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY id DESC");
				foreach($oldbjdata as $index => $row){
					if($row['bj_id']){
						$data1 = array(
							'weid'     => $weid,
							'schoolid' => $schoolid,
							'sid'      => $row['id'],
							'bj_id'    => $row['bj_id'],
							'type'     => 2,
						);
						pdo_insert($this->table_class, $data1);
					}					
				}
				$this->imessage('操作成功', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');			
		}elseif($operation == 'display'){
			$allbj             = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
			$pindex    = max(1, intval($_GPC['page']));
			$psize     = 15;
			$condition = '';
			if(!empty($_GPC['keyword'])){
				$condition .= " AND s_name LIKE '%{$_GPC['keyword']}%'";
			}
			if(!empty($_GPC['bj_id'])){
				$condition .= " AND bj_id = '{$_GPC['bj_id']}'";
			}
			$checkbjold = pdo_fetch("SELECT * FROM " . tablename($this->table_class) . " WHERE schoolid = :schoolid And type = :type ", array(':schoolid' => $schoolid,':type' => 2));			
			//////////导出数据/////////////////
			if($_GPC['out_putcode'] == 'out_putcode'){
				$lists = pdo_fetchall("SELECT s_name,code,mobile,numberid,bj_id FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY id DESC");
				$ii   = 0;
				foreach($lists as $index => $row){
					$bj                = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = '{$row['bj_id']}'");
					$arr[$ii]['s_name'] = $row['s_name'];
					$arr[$ii]['code']  = $row['code'];
					$arr[$ii]['mobile']  = $row['mobile'];
					$arr[$ii]['numberid']  = $row['numberid'];
					$arr[$ii]['banji']  = $bj['sname'];
					$ii++;
				}
				$this->exportexcel($arr, array('学生', '绑定码', '报名预留手机号', '学号', '班级'), '学生绑定信息表');
				exit();
			}
			////////////////////////////////
			$category = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			foreach($list as $key => $value){
				$member1                     = pdo_fetch("SELECT avatar,nickname FROM " . tablename('mc_members') . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['ouid']));
				$member2                     = pdo_fetch("SELECT avatar,nickname FROM " . tablename('mc_members') . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['muid']));
				$member3                     = pdo_fetch("SELECT avatar,nickname FROM " . tablename('mc_members') . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['duid']));
				$member4                     = pdo_fetch("SELECT avatar,nickname FROM " . tablename('mc_members') . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['otheruid']));
				$bj                = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = '{$row['bj_id']}'");
				$list[$key]['onickname']     = $member1['nickname'];
				$list[$key]['oavatar']       = $member1['avatar'];
				$list[$key]['mnickname']     = $member2['nickname'];
				$list[$key]['mavatar']       = $member2['avatar'];
				$list[$key]['dnickname']     = $member3['nickname'];
				$list[$key]['davatar']       = $member3['avatar'];
				$list[$key]['othernickname'] = $member4['nickname'];
				$list[$key]['otheravatar']   = $member4['avatar'];
			}
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' $condition");

			$pager = pagination($total, $pindex, $psize);
		}elseif($operation == 'delete'){
			$id  = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			pdo_delete($this->table_students, array('id' => $id));
			if(!empty($row['otheruserid'])){
				pdo_delete($this->table_user, array('id' => $row['otheruserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}
			if(!empty($row['ouserid'])){
				pdo_delete($this->table_user, array('id' => $row['ouserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}
			if(!empty($row['muserid'])){
				pdo_delete($this->table_user, array('id' => $row['muserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}
			if(!empty($row['duserid'])){
				pdo_delete($this->table_user, array('id' => $row['duserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}
			$this->imessage('删除成功！', referer(), 'success');
		}elseif($operation == 'own'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			$temp = array(
				'own'     => 0,
				'ouserid' => 0,
				'ouid'    => 0
			);
			if(!empty($row['ouserid'])){
				pdo_delete($this->table_user, array('id' => $row['ouserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['ouid'], 'tid' => 0, 'pard' => 4));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'mom'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}

			$temp = array(
				'mom'     => 0,
				'muserid' => 0,
				'muid'    => 0
			);
			if(!empty($row['muserid'])){
				pdo_delete($this->table_user, array('id' => $row['muserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['muid'], 'tid' => 0, 'pard' => 2));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'dad'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			$temp = array(
				'dad'     => 0,
				'duserid' => 0,
				'duid'    => 0
			);
			if(!empty($row['duserid'])){
				pdo_delete($this->table_user, array('id' => $row['duserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['duid'], 'tid' => 0, 'pard' => 3));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'other'){
			$id     = intval($_GPC['id']);
			$openid = $_GPC['openid'];
			$row    = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
			if(empty($row)){
				$this->imessage('抱歉，学生不存在或是已经被删除！');
			}
			$temp = array(
				'other'       => 0,
				'otheruserid' => 0,
				'otheruid'    => 0
			);
			if(!empty($row['otheruserid'])){
				pdo_delete($this->table_user, array('id' => $row['otheruserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['duid'], 'tid' => 0, 'pard' => 3));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
			$this->imessage('解绑成功！', referer(), 'success');
		}elseif($operation == 'makecode'){
			$nocode = pdo_fetchall("SELECT id,code FROM " . tablename($this->table_students) . " WHERE schoolid = :schoolid ", array(':schoolid' => $schoolid));
			if($nocode){
				$notrowcount = 0;
				foreach($nocode as $k => $row){
					if(empty($row['code'])){
						$randStr = str_shuffle('123456789');
						$rand    = substr($randStr, 0, 6);
						$data = array(
							'code'     => $rand
						);					
						pdo_update($this->table_students, $data, array('id' => $row['id']));
						$notrowcount++;
					}
				}
				$this->imessage('操作成功,共为'.$notrowcount.'个学生生成了绑定码！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}else{
				$this->imessage('本校学生全部已生成绑定码，无需重复操作！', '', 'error');
			}
		}elseif($operation == 'deleteall'){
			$rowcount    = 0;
			$notrowcount = 0;
			foreach($_GPC['idArr'] as $k => $id){
				$id = intval($id);
				if(!empty($id)){
					$goods = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
					if(!empty($goods['mom'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '母亲微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}
					if(!empty($goods['dad'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '父亲微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}
					if(!empty($goods['own'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '本人微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}
					if(!empty($goods['other'])){

						$message = '批量删除失败，学生' . $goods['s_name'] . '家长微信未解绑！';

						die (json_encode(array(
							'result' => false,
							'msg'    => $message
						)));
					}					
					if(empty($goods)){
						$notrowcount++;
						continue;
					}
					pdo_delete($this->table_students, array('id' => $id, 'weid' => $weid));
					$rowcount++;
				}
			}
			$message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";

			$data ['result'] = true;

			$data ['msg'] = $message;

			die (json_encode($data));

		}elseif($operation == 'add'){
			load()->func('tpl');
			$id = intval($_GPC['id']);
			if(!empty($id)){
				$km                = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
				$category = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
				$qh                = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where weid = :weid AND schoolid = :schoolid And type = :type ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'score', ':schoolid' => $schoolid));
				$item = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
				if(empty($item)){
					$this->imessage('抱歉，学生不存在或是已经删除！', '', 'error');
				}
			}
			if(checksubmit('submit')){
				$data = array(
					'weid'     => $weid,
					'schoolid' => $schoolid,
					'sid'      => intval($_GPC['id']),
					'km_id'    => trim($_GPC['km']),
					'bj_id'    => trim($_GPC['bj']),
					'qh_id'    => trim($_GPC['qh']),
					'xq_id'    => trim($_GPC['xueqi']),
					'my_score' => trim($_GPC['score']),
					'info'     => trim($_GPC['info']),
				);

				pdo_insert($this->table_score, $data);
				$this->imessage('录入成功，请勿重复录入！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
			}
		}elseif($operation == 'deleteallstudents'){
			pdo_delete($this->table_students, array('schoolid' => $schoolid, 'weid' => $weid));
			$this->imessage('已全部删除本校学生！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
		}
		include $this->template('web/students');
?>