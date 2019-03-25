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
		$leaveid = $_GPC['id'];
		$record_id = intval($_GPC['record_id']);
		$obid = 1;
		
		if (!empty($_GPC['userid'])){
			$_SESSION['user'] = $_GPC['userid'];
		}
        //查询是否用户登录		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_notice) . " where :id = id", array(':id' => $leaveid));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		
        if(!empty($it)){
			
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['sid']));
			$this->checkpay($schoolid, $student['id'], $it['id'], $it['uid']);
			$this->checkobjiect($schoolid, $student['id'], $obid);
			$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid = :uid", array(':uniacid' => $_W ['uniacid'], ':uid'=> $leave['uid']));
			$isbzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['tid']));
			$picarr = iunserializer($leave['picarr']);
			$record = pdo_fetch("SELECT * FROM " . tablename($this->table_record) . " where id = :id", array(':id' => $record_id));
			if(empty($record['readtime'])){
				$date = array(
					'readtime' =>time()
				);
				pdo_update($this->table_record, $date, array('id' => $record_id));				
			}			
		    include $this->template(''.$school['style2'].'/snotice');
        }else{
			session_destroy();
            $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('mnotice', array('schoolid' => $schoolid, 'id' =>  $leaveid, 'record_id' => $record_id));
			header("location:$stopurl");
			exit;
        }        
?>