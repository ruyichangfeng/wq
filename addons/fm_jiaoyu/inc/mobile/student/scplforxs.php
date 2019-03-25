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
		$sid = intval($_GPC['sid']);
		$scid = intval($_GPC['scid']);
		if (!empty($_W['setting']['remote']['type'])) { 
			$urls = $_W['attachurl']; 
		} else {
			$urls = $_W['siteroot'].'attachment/';
		}
		$school = pdo_fetch("SELECT style2,spic,tpic,shoucename,title,logo FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$student = pdo_fetch("SELECT icon,bj_id,s_name FROM " . tablename($this->table_students) . " where schoolid = :schoolid AND id = :id", array(':schoolid' => $schoolid, ':id' => $sid));
		$bjidname = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $student['bj_id']));
		$shouce = pdo_fetch("SELECT * FROM " . tablename($this->table_sc) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And id = '{$scid}'");
		$scset = pdo_fetch("SELECT * FROM " . tablename($this->table_scset) . " where :id = id ", array(':id' => $shouce['setid'])); 
		$kc = pdo_fetch("SELECT name FROM " . tablename($this->table_tcourse) . " where id = '{$shouce['kcid']}' ");
		$teacher = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " where :id = id ", array(':id' => $vule['tid']));
		$alldianz = pdo_fetchall("SELECT id FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type ORDER BY createtime DESC", array(
			':sid' => $sid,
			':scid' => $scid,
			':type' => 3
		));	
		$snum = count($alldianz);
		if($_GPC['op'] == 'dianzan'){
			$mydz = pdo_fetch("SELECT id FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And dianzopenid = :dianzopenid ORDER BY createtime DESC", array(
				':sid' => trim($_GPC['sid']),
				':scid' => trim($_GPC['scid']),
				':dianzopenid' => trim($_GPC['openid']),
				':type' => 3
			));			
			if($mydz['id']){
				$data ['status'] = 2;
				$data ['info'] = '您已经点过赞了！';				
			}else{
				$temp = array(
					'weid' => trim($_GPC['weid']),
					'schoolid' => trim($_GPC['schoolid']),
					'sid' => trim($_GPC['sid']),
					'scid' => trim($_GPC['scid']),
					'dianzopenid' => trim($_GPC['openid']),
					'type' => 3
				);
				pdo_insert($this->table_scforxs, $temp);
				$data ['status'] = 1;
				$data ['info'] = '点赞成功！';				
			}
			die ( json_encode ( $data ) );			
		}	
		$alljzpl = pdo_fetchall("SELECT jzword,userid,createtime FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto ORDER BY createtime DESC", array(
			':sid' => $sid,
			':scid' => $scid,
			':type' => 1,
			':fromto' => 2
		));
		foreach($alljzpl as $key => $row){
			$user = pdo_fetch("SELECT userinfo,pard,uid FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $row['userid']));
			$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $weid, ':uid' => $user['uid']));
			if($user['pard'] == 2){
				$pard = "-妈妈";
			}
			if($user['pard'] == 3){
				$pard = "-爸爸";
			}
			if($user['pard'] == 4){
				$pard = "";
			}
			if($user['pard'] == 5){
				$pard = "-家长";
			}
			if($user['userinfo']){
				$userinfo = iunserializer($user['userinfo']);
			}
			$alljzpl[$key]['tname'] = $userinfo['name'].$pard;
			$alljzpl[$key]['thumb'] = $member['avatar'];
			$alljzpl[$key]['time'] = sub_day($row['createtime']);
		}
		$list2 = pdo_fetchall("SELECT iconsetid,iconlevel FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto  ORDER BY iconsetid ASC", array(
			':sid' => $sid,
			':scid' => $scid,
			':type' => 2,
			':fromto' => 2
		));
		foreach($list2 as $key => $row){
			$scicon = pdo_fetch("SELECT * FROM " . tablename($this->table_scicon) . " where id = :id ", array(':id' => $row['iconsetid']));
			$list2[$key]['title'] = $scicon['title'];	
			if ($row['iconlevel'] == 1){
				$list2[$key]['icontitle'] = $scicon['icon1title'];
				$list2[$key]['icon'] = $scicon['icon1'];						
			}
			if ($row['iconlevel'] == 2){
				$list2[$key]['icontitle'] = $scicon['icon2title'];
				$list2[$key]['icon'] = $scicon['icon2'];						
			}
			if ($row['iconlevel'] == 3){
				$list2[$key]['icontitle'] = $scicon['icon3title'];
				$list2[$key]['icon'] = $scicon['icon3'];						
			}
			if ($row['iconlevel'] == 4){
				$list2[$key]['icontitle'] = $scicon['icon4title'];
				$list2[$key]['icon'] = $scicon['icon4'];						
			}
			if ($row['iconlevel'] == 5){
				$list2[$key]['icontitle'] = $scicon['icon5title'];
				$list2[$key]['icon'] = $scicon['icon5'];						
			}					
		}
		$alllspl = pdo_fetchall("SELECT tword,tid,createtime FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto ORDER BY createtime DESC", array(
			':sid' => $sid,
			':scid' => $scid,
			':type' => 1,
			':fromto' => 1
		));
		foreach($alllspl as $key => $row){
			$teacher = pdo_fetch("SELECT thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
			$alllspl[$key]['tname'] = $teacher['tname'];
			$alllspl[$key]['thumb'] = $teacher['thumb'];
			$alllspl[$key]['time'] = sub_day($row['createtime']);
		}					
		$list1 = pdo_fetchall("SELECT iconsetid,iconlevel FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto  ORDER BY iconsetid ASC", array(
			':sid' => $sid,
			':scid' => $scid,
			':type' => 2,
			':fromto' => 1
		));
		foreach($list1 as $key => $row){
			$scicon = pdo_fetch("SELECT * FROM " . tablename($this->table_scicon) . " where id = :id ", array(':id' => $row['iconsetid']));
			$list1[$key]['title'] = $scicon['title'];	
			if ($row['iconlevel'] == 1){
				$list1[$key]['icontitle'] = $scicon['icon1title'];
				$list1[$key]['icon'] = $scicon['icon1'];						
			}
			if ($row['iconlevel'] == 2){
				$list1[$key]['icontitle'] = $scicon['icon2title'];
				$list1[$key]['icon'] = $scicon['icon2'];						
			}
			if ($row['iconlevel'] == 3){
				$list1[$key]['icontitle'] = $scicon['icon3title'];
				$list1[$key]['icon'] = $scicon['icon3'];						
			}
			if ($row['iconlevel'] == 4){
				$list1[$key]['icontitle'] = $scicon['icon4title'];
				$list1[$key]['icon'] = $scicon['icon4'];						
			}
			if ($row['iconlevel'] == 5){
				$list1[$key]['icontitle'] = $scicon['icon5title'];
				$list1[$key]['icon'] = $scicon['icon5'];						
			}					
		}
		

		include $this->template(''.$school['style2'].'/scplforxs');
       
?>