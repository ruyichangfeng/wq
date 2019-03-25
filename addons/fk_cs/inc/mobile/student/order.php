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
		if ($_GPC['user']){
			$_SESSION['user'] = intval($_GPC['user']);
		}
		$parents = pdo_fetch("SELECT * FROM " . tablename($this->table_parents) . " where weid = :weid AND openid=:openid AND schoolid=:schoolid ", array(':weid' => $weid, ':openid' => $openid, ':schoolid' => $schoolid));
		if(!empty($parents['area_addr_location'])){
			$parents['area_addr_location'] = json_decode($parents['area_addr_location'],true);
		}
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		//获取学生
		$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :weid = weid And :openid = openid And :tid = tid And :pid = pid And sid > 0", array(
			':weid' => $weid,
			':openid' => $openid,
			':tid' => 0,
			':pid' => 0
		));
        if(!empty($user)){
            $card = unserialize($school['cardset']);
//			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $it['sid']));
			$sid = array();
			foreach($user as $key => $row){
				$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id=:id ", array(':id' => $row['sid']));
				$user[$key]['s_name'] = $student['s_name'];
				$user[$key]['sid'] = $student['id'];
				$user[$key]['schoolid'] = $student['schoolid'];
				$sid[] = $student['id'];
			}
			$rest = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_order)." WHERE sid in (".(join(',',$sid)).") And status = '1'");

			$kecheng = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
			
			$cost = pdo_fetchall("SELECT * FROM " . tablename($this->table_cost) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		    
			$teacher = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
			
			$userinfo = iunserializer($it['userinfo']);
			
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And sid in (".(join(',',$sid)).")  ORDER BY createtime DESC", array(
		         ':weid' => $weid,
				 ':schoolid' => $schoolid
				 ));
			foreach($list as $key => $row){
				$kc = pdo_fetch("SELECT * FROM ".tablename($this->table_tcourse)." WHERE id = '{$row['kcid']}'");//课程
				$ct = pdo_fetch("SELECT * FROM ".tablename($this->table_cost)." WHERE id = '{$row['costid']}'");//项目
				$ls = pdo_fetch("SELECT * FROM ".tablename($this->table_teachers)." WHERE id = '{$kc['tid']}'");//老师
				$list[$key]['kcname'] = $kc['name'];
				$list[$key]['kcstart'] = $kc['start'];
				$list[$key]['kcend'] = $kc['end'];
				$list[$key]['adrr'] = $kc['adrr'];
				$list[$key]['minge'] = $kc['minge'];
				$list[$key]['yibao'] = $kc['yibao'];				
				$list[$key]['tname'] = $ls['tname'];
				$list[$key]['ticon'] = $ls['thumb'];
				$list[$key]['obname'] = $ct['name'];
				$list[$key]['obicon'] = $ct['icon'];
				$list[$key]['obstart'] = $ct['starttime'];
				$list[$key]['obend'] = $ct['endtime'];
				$list[$key]['obtime'] = $ct['dataline'];
				$list[$key]['is_time'] = $ct['is_time'];
			}	 
		    include $this->template(''.$school['style2'].'/order');
        }else{
//			session_destroy();
			include $this->template(''.$school['style2'].'/addchild');
        }        
?>