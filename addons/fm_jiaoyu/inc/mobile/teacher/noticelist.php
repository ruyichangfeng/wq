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
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));	
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['tid']));		
		$fisrtbj =  pdo_fetch("SELECT bj_id FROM " . tablename($this->table_class) . " where weid = '{$weid}' And schoolid = '{$schoolid}'  And tid = {$it['tid']} ");
		if($teachers['status'] == 2){
			$myfisrtnj =  pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And tid = '{$it['tid']}' And type = 'semester'");
			$fisrtbj =  pdo_fetch("SELECT sid as bj_id FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And parentid = '{$myfisrtnj['sid']}'");
		}
		if($teachers['status'] == 3){
			$fisrtbj =  pdo_fetch("SELECT sid as bj_id FROM " . tablename($this->table_classify) . " where weid = '{$weid}' And schoolid = '{$schoolid}' ");
		}
		if(!empty($_GPC['bj_id'])){
			$bj_id = intval($_GPC['bj_id']);			
		}else{
			$bj_id = $fisrtbj['bj_id'];
		}
		$bjlists = get_mylist($schoolid,$it['tid'],'teacher');
		$nowbj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $bj_id));
		if($teachers['status'] == 2){
			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
		}
		if($teachers['status'] == 3){
			$mynjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'semester' ORDER BY ssort DESC");
			foreach($mynjlist as $key =>$row){
				$mynjlist[$key]['bjlist'] = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And parentid = '{$row['sid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
				foreach($mynjlist[$key]['bjlist'] as $k => $v){

				}
			}
		}
		$thistime = trim($_GPC['limit']);
		if($thistime){
			$condition = " AND createtime < '{$thistime}'";	
			$leave1 = pdo_fetchall("SELECT id,bj_id,title,tname,tid,createtime,content,ismobile FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And type = 1 And bj_id = '{$bj_id}' $condition ORDER BY createtime DESC LIMIT 0,10 ");
			foreach($leave1 as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$leave1[$key]['banji'] = $banji['sname'];
				$leave1[$key]['name'] = $teach['tname'];
				$leave1[$key]['thumb'] = empty($teach['thumb']) ? $school['tpic'] : $teach['thumb'];
				$leave1[$key]['shenfen'] = get_teacher($teach['status']);
				$list2 = pdo_fetchall("SELECT id FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$row['id']}' And readtime > 5000 ");
				$leave1[$key]['ydrs'] = "已读".count($list2)."人";	
				$leave1[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template('comtool/notelist'); 
		}else{
			$leave = pdo_fetchall("SELECT id,bj_id,title,tname,tid,createtime,content,ismobile FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And type = 1 And bj_id = '{$bj_id}' ORDER BY createtime DESC LIMIT 0,10 ");
			//print_r($leave1);
			foreach($leave as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$leave[$key]['banji'] = $banji['sname'];
				$leave[$key]['name'] = $teach['tname'];
				$leave[$key]['thumb'] = empty($teach['thumb']) ? $school['tpic'] : $teach['thumb'];
				$leave[$key]['shenfen'] = get_teacher($teach['status']);
				$list2 = pdo_fetchall("SELECT id FROM ".tablename($this->table_record)." WHERE weid = '{$weid}' And schoolid = '{$schoolid}' And noticeid = '{$row['id']}' And readtime > 5000 ");
				$leave[$key]['ydrs'] = "已读".count($list2)."人";	
				$leave[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template(''.$school['style3'].'/noticelist');	
		}
        if(empty($userid['id'])){
			include $this->template('bangding');
		}		
?>