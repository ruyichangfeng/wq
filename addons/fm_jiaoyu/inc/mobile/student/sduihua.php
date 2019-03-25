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
		$userss = !empty($_GPC['userid']) ? intval($_GPC['userid']) : 1;
		$id = intval($_GPC['id']);
		$obid = 2;
        //查询是否用户登录
		mload()->model('user');
		$_SESSION['user'] = check_userlogin($weid,$schoolid,$openid,$userss);
		if ($_SESSION['user'] ==2){
			include $this->template('bangding');
		}			
		$it = pdo_fetch("SELECT id,sid FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));		
		$school = pdo_fetch("SELECT style2,spic,tpic FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$thisleave = pdo_fetch("SELECT userid,touserid FROM " . tablename($this->table_leave) . " where weid = :weid AND id = :id ", array(':weid' => $weid, ':id' => $id));
		$student = pdo_fetch("SELECT icon FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));
       // p($thisleave);
		if(!empty($it)){
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_leave) . " where weid = :weid AND leaveid = :leaveid ORDER BY createtime ASC ", array(':weid' => $weid, ':leaveid' => $id));	
			foreach ($list as $k => $v) {
				if($v['userid'] == $it['id']){
					$users = pdo_fetch("SELECT pard,sid,tid,userinfo FROM " . tablename($this->table_user) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $v['touserid']));
				}
				if($v['touserid'] == $it['id']){
					$users = pdo_fetch("SELECT pard,sid,tid,userinfo FROM " . tablename($this->table_user) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $v['userid']));
					if($v['isread'] ==1){
						pdo_update($this->table_leave, array('isread' =>  2), array('id' =>  $v['id']));
					}		
				}	
				$students = pdo_fetch("SELECT s_name,icon FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $users['sid']));
				$teacher = pdo_fetch("SELECT tname,thumb FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $users['tid']));
				$gx = check_gx($users['pard']);
				if($users['userinfo']){
					$userinfo = iunserializer($users['userinfo']);
					$name = $userinfo['name'];
				}
				//p($students);
				$list[$k]['time'] = sub_day($v['createtime']);
				if ($users['sid']){
					$list[$k]['name'] = $students['s_name'].$gx.$name;
					$list[$k]['icon'] = empty($students['icon']) ? $school['spic'] : $students['icon'];					
				}else{
					$list[$k]['name'] = $teacher['tname']." 老师";
					$list[$k]['icon'] =  empty($teacher['thumb']) ? $school['tpic'] : $teacher['thumb'];					
				}				
			}		
			$this->checkobjiect($schoolid, $it['sid'], $obid);
			include $this->template(''.$school['style2'].'/sduihua');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>