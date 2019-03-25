<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$leaveid = $_GPC['id'];
		$obid = 3;

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));

		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
        $parents = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND schoolid = :schoolid And openid=:openid And userType=:userType", array(':weid' => $weid, ':schoolid' => $schoolid,':openid' => $openid,':userType'=> 'parents'));
		if(!empty($parents['area_addr_location'])){
			$parents['area_addr_location'] = json_decode($parents['area_addr_location'],true);
		}
				
        if(!empty($it)){
            
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['sid']));
						
			$category = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid And schoolid = :schoolid And sid = :sid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':sid' => $student['bj_id']));

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
			if(count($kc_ids) > 0) {
				$c_id = join(',', $kc_ids);
				$courses = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND id in ({$c_id})  ORDER BY tid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid),'id');
				$loopData = $courses;
				$course  = empty($_GPC['course_id']) ? array_shift($courses) : $courses[$_GPC['course_id']];
			}
			$this->checkobjiect($schoolid, $student['id'], $obid);
			
			include $this->template(''.$school['style2'].'/video');
        }else{
//			session_destroy();
//            include $this->template('bangding');
			include $this->template(''.$school['style2'].'/addchild');
        }        
?>