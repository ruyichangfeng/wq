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
		$time = $_GPC['time'];
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $userid['id']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
        if(!empty($userid['id'])){
			if(!empty($_GPC['bj_id'])){
				$bj_id = $_GPC['bj_id'];
			}else{
				$mybjlist = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = {$schoolid} And type = 'theclass' And tid = {$it['tid']} ORDER BY ssort DESC LIMIT 0,1 ");
				$bj_id = $mybjlist['sid'];
			}
			$bjlist = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
			if(empty($time)){
				
				$starttime = mktime(0,0,0,date("m"),date("d"),date("Y"));
	 
				$endtime = $starttime + 86399;
				
				$condition = " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}else{
				
				$date = explode ( '-', $time );
				
				$starttime = mktime(0,0,0,$date[1],$date[2],$date[0]);
				
				$endtime = $starttime + 86399;
				
				$condition = " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}			
			$bjidname = pdo_fetch("SELECT sid,sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $bj_id));
			$qdwqram =  pdo_fetchall("SELECT id,sid,createtime FROM " . tablename($this->table_checklog) . " where schoolid = {$schoolid} And bj_id = {$bj_id} And leixing = 1 And isconfirm = 2 $condition ORDER BY createtime ASC");
			$qdams = count($qdwqram);
			foreach($qdwqram as $key =>$row){
				$student = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where schoolid = :schoolid AND id = :id ", array(':schoolid' => $schoolid, ':id' => $row['sid']));
				$qdwqram[$key]['s_name'] = $student['s_name'];
			}
			$qdwqrpm =  pdo_fetchall("SELECT id,sid,createtime FROM " . tablename($this->table_checklog) . " where schoolid = {$schoolid} And bj_id = {$bj_id} And leixing = 2 And isconfirm = 2 $condition ORDER BY createtime ASC");
			$qdamspm = count($qdwqrpm);
			foreach($qdwqrpm as $key =>$row){
				$student = pdo_fetch("SELECT s_name FROM " . tablename($this->table_students) . " where schoolid = :schoolid AND id = :id ", array(':schoolid' => $schoolid, ':id' => $row['sid']));
				$qdwqrpm[$key]['s_name'] = $student['s_name'];
			}			
			$students = pdo_fetchall("SELECT id,s_name,bj_id FROM " . tablename($this->table_students) . " where schoolid = :schoolid AND bj_id = :bj_id ORDER BY id ASC", array(':schoolid' => $schoolid, ':bj_id' => $bj_id));
			$rlogmub = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_checklog) . " where bj_id = :bj_id $condition ", array(':bj_id' => $bj_id));
			$nlogmub = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_checklog) . " where bj_id = :bj_id $condition ", array(':bj_id' => $bj_id));
			$snum = count($students);
			$wqdnum = 0;
			$yqdnum = 0;
			$wqdnumpm = 0;
			$yqdnumpm = 0;			
			foreach($students as $index => $row){
				$ischeck = pdo_fetch("SELECT id,createtime FROM " . tablename($this->table_checklog) . " where sid = {$row['id']} And bj_id = {$row['bj_id']} And leixing = 1 And isconfirm = 1 $condition ORDER BY createtime ASC LIMIT 0,1");
				$ischeckpm = pdo_fetch("SELECT id,createtime FROM " . tablename($this->table_checklog) . " where sid = {$row['id']} And bj_id = {$row['bj_id']} And leixing = 2  And isconfirm = 1 $condition ORDER BY createtime DESC LIMIT 0,1");
				$students[$index]['ischeck'] = $ischeck['id'];
				$students[$index]['ischeckpm'] = $ischeckpm['id'];
				if(!$ischeck['id']){
					$wqdnum ++;
				}else{
					$students[$index]['amtime'] = $ischeck['createtime'];
					$students[$index]['logid'] = $ischeck['id'];
					$yqdnum ++;
				}	
				if(!$ischeckpm['id']){
					$wqdnumpm ++;
				}else{
					$students[$index]['pmtime'] = $ischeckpm['createtime'];
					$students[$index]['logid'] = $ischeckpm['id'];
					$yqdnumpm ++;
				}				
			}
			$jxl=round($yqdnum/$snum*100, 2);
			$lxl=round($yqdnumpm/$snum*100, 2);
			include $this->template(''.$school['style3'].'/signlist');
        }else{
			include $this->template('bangding');
        }        
?>