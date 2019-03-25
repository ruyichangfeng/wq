<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$bj_id = intval($_GPC['bj_id']);
		$xq_id = intval($_GPC['xq_id']);
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		$parents = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND openid=:openid AND schoolid=:schoolid ", array(':weid' => $weid, ':openid' => $openid, ':schoolid' => $schoolid));
		if(!empty($parents['area_addr_location'])){
			$parents['area_addr_location'] = json_decode($parents['area_addr_location'],true);
		}
		if(!empty($it)){
			$orderList = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid ORDER BY createtime DESC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				':sid' => $it['sid']
			));
			$kc_ids = array();
			foreach($orderList as $list){
				if($list['type'] == 2 || ($list['type'] == 1 && $list['status'] == 2)){
					$kc_ids[$list['kcid']] = $list['kcid'];
				}
			}
			if(count($kc_ids) > 0){
				//教师列表按教师入职时间先后顺序排列，先入职再前
				$id = join(',',$kc_ids);
				$courses = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND id IN ({$id})  ORDER BY tid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid));
				$tids = array_column($courses,'tid');
				$teachers = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} AND id in(".join(',',$tids).") ORDER BY id ASC, id DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
				$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} AND type = 'subject' ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
				$list = array();
				foreach($teachers as $teacher){
					if(!empty($teacher['km_id1'])){
						$teacher['km1_name'] = $category[$teacher['km_id1']]['sname'];
					}
					if(!empty($teacher['km_id2'])){
						$teacher['km2_name'] = $category[$teacher['km_id2']]['sname'];
					}
					if(!empty($teacher['km_id3'])){
						$teacher['km3_name'] = $category[$teacher['km_id3']]['sname'];
					}
					$list[$teacher['id']] = $teacher;
				}
			}

			include $this->template(''.$school['style2'].'/mytecher');
		}else{
//			session_destroy();
			include $this->template(''.$school['style2'].'/addchild');
		}
?>