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
			$user = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $it['tid']));
			if(!empty($_GPC['nj_id'])){
				$bj_id = $_GPC['nj_id'];
			}else{
				$mybjlist = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = {$schoolid} And type = 'semester' And tid = {$it['tid']} ORDER BY ssort DESC LIMIT 0,1 ");
				$bj_id = $mybjlist['sid'];
			}
			if ($user['status'] == 2){
				$njlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = :schoolid And weid = :weid And type = :type ORDER BY SID DESC", array(
						':weid' => $weid,
						':schoolid' => $schoolid,
						':type' => 'semester'
				));
			}else{
				$njlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = :schoolid And weid = :weid And type = :type And tid = :tid ORDER BY SID DESC", array(
						':weid' => $weid,
						':schoolid' => $schoolid,
						':type' => 'semester',
						':tid' => $it['tid']
				));				
			}
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
			          
			$teacher = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " where weid = '{$weid}' AND schoolid = '{$schoolid}' AND (xq_id1 = '{$bj_id}' OR xq_id2 = '{$bj_id}' OR xq_id3 = '{$bj_id}') ORDER BY id ASC");
			$rlogmub = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_checklog) . " where bj_id = :bj_id $condition ", array(':bj_id' => $bj_id));
			$nlogmub = pdo_fetchcolumn("SELECT count(*) FROM " . tablename($this->table_checklog) . " where bj_id = :bj_id $condition ", array(':bj_id' => $bj_id));
			$snum = count($teacher);
			$notrowcount = 0;
			foreach($teacher as $index => $row){
				$ischeck = pdo_fetch("SELECT * FROM " . tablename($this->table_checklog) . " where tid = {$row['id']} $condition ");
				$jxlog = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where tid = {$row['id']} And leixing = 1 $condition ");
				$lxlog = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where tid = {$row['id']} And leixing = 2 $condition ");
				$yclog = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where tid = {$row['id']} And leixing = 3 $condition ");
				$teacher[$index]['ischeck'] = $ischeck['id'];	
				$teacher[$index]['jxnum'] = count($jxlog);
				$teacher[$index]['lxnum'] = count($lxlog);
				$teacher[$index]['ycnum'] = count($yclog);	
				if (!empty($ischeck)){
					$notrowcount++;
				}						
			}
			
			
			include $this->template(''.$school['style3'].'/jschecklog');
        }else{
			include $this->template('bangding');
        }        
?>