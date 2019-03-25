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
		$noticeid = $_GPC['noticeid'];
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));
		$school = pdo_fetch("SELECT style3,spic,tpic FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
        if(!empty($userid['id'])){
			$list1 = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$noticeid}' And readtime = 0 ORDER BY id DESC ");
			$wdsum = count($list1);
			foreach ($list1 as $key => $row) {
				$student = pdo_fetch("SELECT s_name,icon FROM " . tablename ($this->table_students) . " where id = :id ", array(':id' => $row['sid']));
				$teacher = pdo_fetch("SELECT thumb,tname,mobile FROM " . tablename ($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$user = pdo_fetch("SELECT pard,userinfo,uid FROM " . tablename ($this->table_user) . " where id = :id", array(':id' => $row ['userid']));
				$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $user['uid']));
				if($row['sid']){
					if($user['pard'] ==2){
						$guanxi = "妈妈";
						$list1[$key]['sicon'] = empty($member['avatar'])?$school['spic']:$member['avatar'];
					}
					if($user['pard'] ==3){
						$guanxi = "爸爸";
						$list1[$key]['sicon'] =  empty($member['avatar'])?$school['spic']:$member['avatar'];
					}
					if($user['pard'] ==4){
						$guanxi = "";
						$list1[$key]['sicon'] =  empty($student['icon'])?$school['spic']:$student['icon'];;
					}
					if($user['pard'] ==5){
						$guanxi = "家长";
						$list1[$key]['sicon'] =  empty($member['avatar'])?$school['spic']:$member['avatar'];
					}
					$list1[$key]['s_name'] = $student['s_name'].$guanxi;
					if ($user['userinfo']){
						$userinfo = iunserializer($user['userinfo']);
						$list1[$key]['name'] = $userinfo['name'];
						$list1[$key]['mobile'] = $userinfo['mobile'];
					}
				}
				if($row['tid']){
					$list1[$key]['s_name'] = $teacher['tname']."（老师）";
					$list1[$key]['sicon'] = empty($teacher['thumb'])?$school['tpic']:$teacher['thumb'];;
					$list1[$key]['mobile'] = $teacher['mobile'];
				}	
			}
			$list2 = pdo_fetchall("SELECT * FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$noticeid}' And readtime > 5000 ORDER BY readtime DESC ");
			$ydsum = count($list2);
			foreach ($list2 as $key => $row) {
				if($row['sid']){
					$student = pdo_fetch("SELECT s_name,icon FROM " . tablename ($this->table_students) . " where id = :id ", array(':id' => $row['sid']));
					$user = pdo_fetch("SELECT pard,userinfo,uid FROM " . tablename ($this->table_user) . " where id = :id", array(':id' => $row ['userid']));
					$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $user['uid']));
					if($user['pard'] ==2){
						$guanxi = "妈妈";
						$list2[$key]['sicon'] = empty($member['avatar'])?$school['spic']:$member['avatar'];
					}
					if($user['pard'] ==3){
						$guanxi = "爸爸";
						$list2[$key]['sicon'] = empty($member['avatar'])?$school['spic']:$member['avatar'];
					}
					if($user['pard'] ==4){
						$guanxi = "";
						$list2[$key]['sicon'] = empty($student['icon'])?$school['spic']:$student['icon'];;
					}
					if($user['pard'] ==5){
						$guanxi = "家长";
						$list2[$key]['sicon'] = empty($member['avatar'])?$school['spic']:$member['avatar'];
					}
					$list2[$key]['s_name'] = $student['s_name'].$guanxi;
					if ($user['userinfo']){
						$userinfo = iunserializer($user['userinfo']);
						$list2[$key]['name'] = $userinfo['name'];
						$list2[$key]['mobile'] = $userinfo['mobile'];
					}
				}
				if($row['tid']){
					$teacher = pdo_fetch("SELECT thumb,tname,mobile FROM " . tablename ($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
					$list2[$key]['s_name'] = $teacher['tname']."（老师）";
					$list2[$key]['sicon'] = empty($teacher['thumb'])? $school['tpic'] : $teacher['thumb'];
					$list2[$key]['mobile'] = $teacher['mobile'];
				}
				$list2[$key]['time'] = sub_day($row['readtime']);
			}			
			include $this->template(''.$school['style3'].'/recod');
        }else{
			include $this->template('bangding');
        }        
?>