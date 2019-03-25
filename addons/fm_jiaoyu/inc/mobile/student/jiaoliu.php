<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid']; 
		$openid = $_W['openid'];
		$schoolid = intval($_GPC['schoolid']);
		$userss = intval($_GPC['userid']);
		$obid = 1;
		if(!empty($userss)){
			$ite = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(':schoolid' => $schoolid,':weid' => $weid, ':id' => $userss));
			if(!empty($ite)){
				$_SESSION['user'] = $ite['id'];
			}else{
				$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('myschool', array('schoolid' => $schoolid));
				header("location:$stopurl");
				exit;
			}			
		}else{
			if(empty($_SESSION['user'])){
				$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid LIMIT 0,1 ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
				$_SESSION['user'] = $userid['id'];
			}
		}
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		if(!empty($it)){
			$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $it['sid']));
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
			$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :uid = uid And :bj_id = bj_id And :isliuyan = isliuyan ORDER BY createtime ASC LIMIT 1", array(
					 ':weid' => $weid,
					 ':schoolid' => $schoolid,
					 ':bj_id' => $students['bj_id'],
					 ':uid' => $it['uid'],
					 ':isliuyan' => 1,
					 ':sid' => $it['sid']
					 )); 
			
			$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid =:schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
			
			$tid = $category[$students['bj_id']]['tid'];
			
			$techers = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid = :weid AND schoolid =:schoolid ORDER BY id ASC, id DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'id');
			
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_leave) . " WHERE weid = :weid AND schoolid =:schoolid AND bj_id = :bj_id AND leaveid = :leaveid And :isliuyan = isliuyan ORDER BY createtime DESC", array(':isliuyan' => 1, ':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':bj_id' => $students['bj_id'], ':leaveid' => $leave['id']));
			foreach ($list as $index => $row) {
				$member = pdo_fetch("SELECT avatar,nickname FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $row['uid']));
				$members = pdo_fetch("SELECT avatar,nickname FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $row['tuid']));
				$teacher = pdo_fetch("SELECT tname,thumb FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $row['tid']));
				$list[$index]['tlogo'] = $teacher['thumb'];
				$list[$index]['tname'] = $teacher['tname'];
				$list[$index]['avatar'] = $member['avatar'];
				$list[$index]['nickname'] = $member['nickname'];
				$list[$index]['tavatar'] = $members['avatar'];
				$list[$index]['tnickname'] = $members['nickname'];
			}		
			$this->checkobjiect($schoolid, $students['id'], $obid);
			include $this->template(''.$school['style2'].'/jiaoliu');
		}else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;	
		}
?>