<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $id = intval($_GPC['id']);
		$openid = $_W['openid'];
		$schoolid = intval($_GPC['schoolid']);
		$op = $_GPC['op'] ? $_GPC['op'] : 'display';
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid And :pid = pid ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0,':pid' => 0), 'id');
		$its = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $_SESSION['user']));
		$userinfo = iunserializer($its['userinfo']);
		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND schoolid=:schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $its['sid']));
		//获取学生
		$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :weid = weid And :openid = openid And :tid = tid And :pid = pid And sid > 0", array(
			':weid' => $weid,
			':openid' => $openid,
			':tid' => 0,
			':pid' => 0
		));
		foreach($user as $key => $row){
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id=:id ", array(':id' => $row['sid']));
			$user[$key]['s_name'] = $student['s_name'];
			$user[$key]['sid'] = $student['id'];
			$user[$key]['schoolid'] = $student['schoolid'];
		}
		$currentStudentCount = 0;
		if(!empty($user)){
			$currentStudentCount = count($user);
		}
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_kcbiao) . " WHERE weid = '{$weid}' AND schoolid ={$schoolid} AND kcid = {$id}  ORDER BY date ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':kcid' => $id));
        $item1 = pdo_fetch("SELECT * FROM " . tablename($this->table_kcbiao) . " WHERE id = :id ", array(':id' => $id));
		$item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $item['tid']));
		$title = $item['title'];
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$weid}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		
		$rest = $item['minge'] - $item['yibao'];
		
		$isfull =false;
		
		if ($item['yibao'] >= $item['minge']){
			
		$isfull =true;
		
		}
		
		$km = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = '{$weid}' AND schoolid =$schoolid And type = 'subject' ORDER BY ssort DESC", array(':weid' => $weid, ':type' => 'subject', ':schoolid' => $schoolid));
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE sid = :sid", array(':sid' => $sid));
		if($op == 'searchFreinds'){
			if(empty($_GPC['mobiles'])){
				die(json_encode(array(
					'result' => false,
					'msg'    => '手机号码有误!'
				)));
			}
			//查询手机号码
			$otherStudents = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND schoolid=:schoolid AND mobile in ({$_GPC['mobiles']})", array(':weid' => $weid, ':schoolid' => $schoolid));
			foreach($otherStudents as $otherStudent){
				$user[] = array(
					's_name'   => $otherStudent['s_name'],
					'sid'      => $otherStudent['id'],
					'schoolid' => $otherStudent['schoolid'],
				);
			}
			$classSize = $_GPC['classSize'];
			include $this->template(''.$school['style1'].'/selectStudents');
		}else{
			include $this->template(''.$school['style1'].'/kcinfo');
		}
?>