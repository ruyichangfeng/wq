<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$obid = 1;
		
        //查询是否用户登录
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		
		$student = pdo_fetch("SELECT id,bj_id FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));		

		$bj_id = $student['bj_id'];
		$thistime = trim($_GPC['limit']);
		if($thistime){
			$condition = " AND createtime < '{$thistime}'";	
		    $leave1 = pdo_fetchall("SELECT id,bj_id,km_id,title,tname,createtime,type,tid,content FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And ( type = 1 Or type = 2)  And ( groupid = 1 Or groupid = 3 Or bj_id = '{$bj_id}') $condition  ORDER BY createtime DESC LIMIT 0,5 ");			
			foreach($leave1 as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$leave1[$key]['banji'] = $banji['sname'];
				$leave1[$key]['tname'] = $teach['tname'];
				$leave1[$key]['thumb'] = empty($teach['thumb']) ? $school['tpic'] : $teach['thumb'];
				$leave1[$key]['shenfen'] = get_teacher($teach['status']);
				mload()->model('read');
				$ydrs = check_readtype($weid,$schoolid,$it['id'],$row['id']);
				if($ydrs == 2){
					$leave1[$key]['ydrs'] = "未读";
				}
				if($row['type'] ==1){
					$leave1[$key]['tzlx'] = "班级通知";
				}else{
					$leave1[$key]['tzlx'] = "学校通知";
				}				
				$leave1[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template('comtool/snotelist'); 
		}else{
		    $leave = pdo_fetchall("SELECT id,bj_id,km_id,title,tname,createtime,type,tid,content FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And ( type = 1 Or type = 2)  And ( groupid = 1 Or groupid = 3 Or bj_id = '{$bj_id}')  ORDER BY createtime DESC LIMIT 0,5 ");
			foreach($leave as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$leave[$key]['banji'] = $banji['sname'];
				$leave[$key]['tname'] = $teach['tname'];
				$leave[$key]['thumb'] = empty($teach['thumb']) ? $school['tpic'] : $teach['thumb'];
				$leave[$key]['shenfen'] = get_teacher($teach['status']);
				mload()->model('read');
				$ydrs = check_readtype($weid,$schoolid,$it['id'],$row['id']);
				if($ydrs == 2){
					$leave[$key]['ydrs'] = "未读";
				}
				if($row['type'] ==1){
					$leave[$key]['tzlx'] = "班级通知";
				}else{
					$leave[$key]['tzlx'] = "校园通知";
				}				
				$leave[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template(''.$school['style2'].'/snoticelist');	
		}		
        if(!empty($it)){
		
			$this->checkobjiect($schoolid, $student['id'], $obid);
				 									
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>