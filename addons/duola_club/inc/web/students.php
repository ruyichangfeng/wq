<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_GPC, $_W;
       
        $weid = $_W['uniacid'];
        $action = 'students';
		$GLOBALS['frames'] = $this->getNaveMenu($_GPC['schoolid'],$action);
		$schoolid = intval($_GPC['schoolid']);
		$logo = pdo_fetch("SELECT logo,title FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
//		$xueqi = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'semester' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'semester', ':schoolid' => $schoolid));
//		$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'subject' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
//		$bj = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'theclass' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'theclass', ':schoolid' => $schoolid));
//		$xq = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'week' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'week', ':schoolid' => $schoolid));
//		$sd = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'timeframe' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'timeframe', ':schoolid' => $schoolid));
//		$qh = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid ={$schoolid} And type = 'score' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'score', ':schoolid' => $schoolid));
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		$xueqi = $km = $districtCenter = $xq = $sd = $courseCats = $qh = $classSize = array();
		foreach($category as $key => $value){
			switch($value['type']){
				case 'semester':
					$xueqi[] = $value;
					break;
				case 'subject':
					$km[] = $value;
					break;
				case 'districtCenter':
					$districtCenter[] = $value;
					break;
				case 'subject':
					$km[] = $value;
					break;
				case 'week':
					$xq[] = $value;
					break;
				case 'timeframe':
					$sd[] = $value;
					break;
				case 'courseClassification':
					$courseCats[] = $value;
					break;
				case 'score':
					$qh[] = $value;
					break;
				case 'classSize':
					$classSize[] = $value;
					break;
				default:
					break;
			}
		}
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post') {
            load()->func('tpl');
            $id = intval($_GPC['id']);
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
				if (empty($item)) {
                    message('抱歉，学生不存在或是已经删除！', '', 'error');
                } else {
                    if (!empty($item['thumb_url'])) {
                        $item['thumbArr'] = explode('|', $item['thumb_url']);
                    }
					if(!empty($item['area_addr_location'])){
						$item['area_addr_location'] = json_decode($item['area_addr_location'],true);
					}
                }
            }
            if (checksubmit('submit')) {
                $data = array(
				    'weid' => $weid,
					'schoolid' => $schoolid,
                    's_name' => trim($_GPC['s_name']),
					'icon' => trim($_GPC['icon']),
					'sex' => intval($_GPC['sex']),
					'bj_id' => trim($_GPC['bj']),
					'xq_id' => trim($_GPC['xueqi']),
					'numberid' => trim($_GPC['numberid']),
					'birthdate' => strtotime($_GPC['birthdate']),
                    'homephone' => trim($_GPC['tel']),
                    'mobile' => trim($_GPC['mobile']),
					'area_addr' => trim($_GPC['addr']),
					'seffectivetime' => strtotime($_GPC['seffectivetime']),
					'stheendtime' => strtotime($_GPC['stheendtime']),
					'note' => trim($_GPC['note']),
					'province' => trim($_GPC['reside']['province']),
					'city' => trim($_GPC['reside']['city']),
					'district' => trim($_GPC['reside']['district']),
                );
                if (empty($data['s_name'])) {
                    message('请输入学生姓名！');
                }
				if (empty($data['mobile'])) {
                    message('清输入学生家长手机');
                }				
                if (empty($id)) {
                    pdo_insert($this->table_students, $data);
                } else {
                    unset($data['dateline']);
                    pdo_update($this->table_students, $data, array('id' => $id));
                }
                message('添加学生信息成功！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');
            }
        } elseif ($operation == 'display') {

            $pindex = max(1, intval($_GPC['page']));
            $psize = 8;
            $condition = '';
            if (!empty($_GPC['keyword'])) {
                $condition .= " AND s_name LIKE '%{$_GPC['keyword']}%'";
            }

			$km_id = '';
			if(!empty($_GPC['km_id']) && empty($_GPC['lb_id'])){
				$km_id = $_GPC['km_id'];
			}else{
				if (!empty($_GPC['lb_id'])) {
					$kms = array_filter($km,function($item) use ($_GPC){
						if($item['parentid'] == $_GPC['lb_id']){
							return true;
						}
						return false;
					});
					if($kms){
						$km_ids = array_column($kms,'sid');
					}else{
						$km_ids = array();
					}
					if(count($km_ids) > 0){
						//查找订单表
						if(!empty($_GPC['km_id']) && in_array($_GPC['km_id'],$km_ids)){
							$km_id = $_GPC['km_id'];
						}else if(empty($_GPC['km_id'])){
							$km_id = join(',',$km_ids);
						}else{
							$km_id = 0;
						}

					}
				}
			}
			if(!empty($km_id)){
				//查询课程
				$courses = pdo_fetchall("SELECT id FROM " . tablename($this->table_tcourse) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} AND km_id in({$km_id}) ORDER BY id DESC  ");
				if($courses){
					$kc_ids = join(',',array_column($courses,'id'));
					//查询订单中的学生id
					$orders = pdo_fetchall("SELECT DISTINCT sid FROM " . tablename($this->table_order) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} AND status=2 AND kcid in({$kc_ids}) ORDER BY id DESC  ");
					if(count($orders) > 0){
						$sid = join(',',array_column($orders,'sid'));
						$condition .= " AND id in ({$sid})";
					}
				}
			}
			if($km_id === 0){
				$list = array();
			}else{
				$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
				foreach ($list as $key => $value) {
					$member1 = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['ouid']));
					$member2 = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['muid']));
					$member3 = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['duid']));
					$member4 = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $value['otheruid']));
					$list[$key]['onickname'] = $member1['nickname'];
					$list[$key]['oavatar'] = $member1['avatar'];
					$list[$key]['mnickname'] = $member2['nickname'];
					$list[$key]['mavatar'] = $member2['avatar'];
					$list[$key]['dnickname'] = $member3['nickname'];
					$list[$key]['davatar'] = $member3['avatar'];
					$list[$key]['othernickname'] = $member4['nickname'];
					$list[$key]['otheravatar'] = $member4['avatar'];
				}
				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_students) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} $condition");
				$pager = pagination($total, $pindex, $psize);
			}
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
            if (empty($row)) {
                message('抱歉，学生不存在或是已经被删除！');
            }
            pdo_delete($this->table_students, array('id' => $id));
			if (!empty($row['otheruserid'])){
				pdo_delete($this->table_user, array('id' => $row['otheruserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}
			if (!empty($row['ouserid'])){
				pdo_delete($this->table_user, array('id' => $row['ouserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}
			if (!empty($row['muserid'])){
				pdo_delete($this->table_user, array('id' => $row['muserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}
			if (!empty($row['duserid'])){
				pdo_delete($this->table_user, array('id' => $row['duserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id));
			}			
            message('删除成功！', referer(), 'success');
        } elseif ($operation == 'own') {
            $id = intval($_GPC['id']);
			$openid = $_GPC['openid'];
            $row = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
            if (empty($row)) {
                message('抱歉，学生不存在或是已经被删除！');
            }
			$temp = array(
			        'own'  => 0,
					'ouserid'  => 0,
		           	'ouid' => 0
			       );
			if (!empty($row['ouserid'])){
				pdo_delete($this->table_user, array('id' => $row['ouserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['ouid'], 'tid' => 0, 'pard' => 4));
			}				    
			pdo_update($this->table_students, $temp, array('id' => $id));
            message('解绑成功！', referer(), 'success');
        } elseif ($operation == 'mom') {
            $id = intval($_GPC['id']);
			$openid = $_GPC['openid'];
            $row = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
            if (empty($row)) {
                message('抱歉，学生不存在或是已经被删除！');
            }

			$temp = array(
			        'mom'   => 0,
					'muserid'  => 0,
		           	'muid'  => 0
			       );
			if (!empty($row['muserid'])){
				pdo_delete($this->table_user, array('id' => $row['muserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['muid'], 'tid' => 0, 'pard' => 2));
			}				   	
			pdo_update($this->table_students, $temp, array('id' => $id));
            message('解绑成功！', referer(), 'success');
        } elseif ($operation == 'dad') {
            $id = intval($_GPC['id']);
			$openid = $_GPC['openid'];
            $row = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
            if (empty($row)) {
                message('抱歉，学生不存在或是已经被删除！');
            }
			$temp = array(
			        'dad'   => 0,
					'duserid'  => 0,
		           	'duid'  => 0
			       );
			if (!empty($row['duserid'])){
				pdo_delete($this->table_user, array('id' => $row['duserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['duid'], 'tid' => 0, 'pard' => 3));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
            message('解绑成功！', referer(), 'success');
        } elseif ($operation == 'other') {
            $id = intval($_GPC['id']);
			$openid = $_GPC['openid'];
            $row = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
            if (empty($row)) {
                message('抱歉，学生不存在或是已经被删除！');
            }
			$temp = array(
			        'other'   => 0,
					'otheruserid'  => 0,
		           	'otheruid'  => 0
			       );
			if (!empty($row['otheruserid'])){
				pdo_delete($this->table_user, array('id' => $row['otheruserid']));
			}else{
				pdo_delete($this->table_user, array('sid' => $id, 'openid' => $openid, 'uid' => $row['duid'], 'tid' => 0, 'pard' => 3));
			}
			pdo_update($this->table_students, $temp, array('id' => $id));
            message('解绑成功！', referer(), 'success');			
        } elseif ($operation == 'deleteall') {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC['idArr'] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));
					if (!empty($goods['mom'])){
						
						$message = '批量删除失败，学生'.$goods['s_name'].'母亲微信未解绑！';

						die ( json_encode ( array (
							'result' => false,
							'msg' => $message 
							   ) ) );						
					}
					if (!empty($goods['dad'])){
						
						$message = '批量删除失败，学生'.$goods['s_name'].'父亲微信未解绑！';

						die ( json_encode ( array (
							'result' => false,
							'msg' => $message 
							   ) ) );
					}
					if (!empty($goods['own'])){
						
						$message = '批量删除失败，学生'.$goods['s_name'].'本人微信未解绑！';

						die ( json_encode ( array (
							'result' => false,
							'msg' => $message 
							   ) ) );
					}					
                    if (empty($goods)) {
                        $notrowcount++;
                        continue;
                    }
                    pdo_delete($this->table_students, array('id' => $id, 'weid' => $weid));
                    $rowcount++;
                }
            }
            $message = "操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!";
			
			$data ['result'] = true;
	
			$data ['msg'] =  $message;
			
			die ( json_encode ( $data ) );
			
        } elseif ($operation == 'add') {
			load()->func('tpl');
            $id = intval($_GPC['id']);
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE id = :id", array(':id' => $id));				
                if (empty($item)) {
                    message('抱歉，学生不存在或是已经删除！', '', 'error');
                }
            }
			if (checksubmit('submit')) {
                $data = array(
				    'weid' => $weid,
					'schoolid' => $schoolid,
					'sid' => intval($_GPC['id']),
					'km_id' => trim($_GPC['km']),
					'bj_id' => trim($_GPC['bj']),
					'qh_id' => trim($_GPC['qh']),
					'xq_id' => trim($_GPC['xueqi']),
					'my_score' => trim($_GPC['score']),
					'info' => trim($_GPC['info']),
                );
				pdo_insert($this->table_score, $data);
            	message('录入成功，请勿重复录入！', $this->createWebUrl('students', array('op' => 'display', 'schoolid' => $schoolid)), 'success');    
            }
		}	
        include $this->template ( 'web/students' );
?>