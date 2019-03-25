<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
        
		$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_signup) . " where :openid = openid And :weid = weid And :schoolid = schoolid ORDER BY createtime DESC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				':openid' => $openid,
			));
		foreach($list as $key => $row){
			$xueqi = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $row['nj_id']));
			$class = pdo_fetch("SELECT sname,cost FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $row['bj_id']));
			$order = pdo_fetch("SELECT status FROM " . tablename($this->table_order) . " where signid = :signid ", array(':signid' => $row['id']));
			if($row['sid']){
				$student = pdo_fetch("SELECT code FROM " . tablename($this->table_students) . " where :id = id", array(':id' => $row['sid']));
				$list[$key]['code'] = $student['code'];
			}			
			$list[$key]['njname'] = $xueqi['sname'];
			$list[$key]['bjname'] = $class['sname'];
			$list[$key]['bmcost'] = $class['cost'];
			$list[$key]['ispay'] = $order['status'];
		}
		$school = pdo_fetch("SELECT id,title,style1 FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));

		include $this->template(''.$school['style1'].'/signuplist');       
?>