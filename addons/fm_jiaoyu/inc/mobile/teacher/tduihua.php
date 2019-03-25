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
		$id = intval($_GPC['id']);

        //查询是否用户登录
		$it = pdo_fetch("SELECT id,tid FROM " . tablename($this->table_user) . " where  weid = :weid And schoolid = :schoolid And openid = :openid And sid = :sid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid,
					':openid' => $openid,
					':sid' => 0
		));	
		$school = pdo_fetch("SELECT style3,spic,tpic FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$thisleave = pdo_fetch("SELECT userid,touserid FROM " . tablename($this->table_leave) . " where weid = :weid AND id = :id ", array(':weid' => $weid, ':id' => $id));
		$teachers = pdo_fetch("SELECT thumb FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['tid']));
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
				mload()->model('user');
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
			include $this->template(''.$school['style3'].'/tduihua');
        }else{
			include $this->template('bangding');
        }        
?>