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
        
        //查询是否用户登录		

		$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_signup) . " where :openid = openid And :weid = weid And :schoolid = schoolid ORDER BY createtime DESC", array(
				':weid' => $weid,
				':schoolid' => $schoolid,
				':openid' => $openid,
			));
		foreach($list as $key => $row){
			$xueqi = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $row['nj_id']));
			$class = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $row['bj_id']));
			$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where signid = :signid ", array(':signid' => $row['id']));
			$list[$key]['njname'] = $xueqi['sname'];
			$list[$key]['bjname'] = $class['sname'];
			$list[$key]['bmcost'] = $class['cost'];
			$list[$key]['ispay'] = $order['status'];
		}
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));

		include $this->template(''.$school['style1'].'/signuplist');       
?>