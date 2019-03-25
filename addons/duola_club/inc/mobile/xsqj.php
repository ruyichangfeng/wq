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
		$obid = 1;

        //查询是否用户登录
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id AND schoolid=:schoolid ", array(':weid' => $weid, ':id' => $it['sid'], ':schoolid' => $schoolid));
//		$category = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid =  :sid AND type = :type ", array(':sid' => $student['bj_id'], ':type' => 'theclass'));
//
//        $tid = $category['tid'];
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
				$c_id = join(',',$kc_ids);
				$courses = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND id in ({$c_id})  ORDER BY tid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid));

				$tid = $_GPC['tid'] ? $_GPC['tid'] : $courses[0]['tid'];

				$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} AND id = {$tid} ORDER BY id ASC, id DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');

			}
			$item = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ", array(':uid' => $it['uid'], ':uniacid' => $_W ['uniacid']));

		    $userinfo = iunserializer($it['userinfo']);
		    $this->checkobjiect($schoolid, $student['id'], $obid);
		 include $this->template(''.$school['style2'].'/xsqj');
          }else{
//         include $this->template('bangding');
			include $this->template(''.$school['style2'].'/addchild');
          }        
?>