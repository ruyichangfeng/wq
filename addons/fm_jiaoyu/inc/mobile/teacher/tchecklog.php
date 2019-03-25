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
			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
			if(empty($time)){
				
				$starttime = mktime(0,0,0,date("m"),date("d"),date("Y"));
	 
				$endtime = $starttime + 86399;
				
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}else{
				
				$date = explode ( '-', $time );
				
				$starttime = mktime(0,0,0,$date[1],$date[2],$date[0]);
				
				$endtime = $starttime + 86399;
				
				$condition .= " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";
			}			
			$bjidname = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $bj_id));
			          
			$student = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND bj_id = :bj_id ORDER BY id ASC", array(':weid' => $weid, ':bj_id' => $bj_id));
			$rlogmub = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_checklog) . " where bj_id = :bj_id $condition ", array(':bj_id' => $bj_id));
			$nlogmub = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_checklog) . " where bj_id = :bj_id $condition ", array(':bj_id' => $bj_id));
			$snum = count($student);
			foreach($student as $index => $row){
				$ischeck = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " where sid = {$row['id']} And bj_id = {$row['bj_id']} $condition ");
				$jxlog = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where sid = {$row['id']} And bj_id = {$row['bj_id']} And leixing = 1 $condition ");
				$lxlog = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where sid = {$row['id']} And bj_id = {$row['bj_id']} And leixing = 2 $condition ");
				$yclog = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where sid = {$row['id']} And bj_id = {$row['bj_id']} And leixing = 3 $condition ");
				$student[$index]['ischeck'] = $ischeck['id'];	
				$student[$index]['jxnum'] = count($jxlog);
				$student[$index]['lxnum'] = count($lxlog);
				$student[$index]['ycnum'] = count($yclog);	
			}
			
			
			include $this->template(''.$school['style3'].'/tchecklog');
        }else{
			include $this->template('bangding');
        }        
?>