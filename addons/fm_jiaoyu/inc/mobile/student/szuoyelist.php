<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$obid = 1;
        //查询是否用户登录		
		
		$it = pdo_fetch("SELECT id,sid FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));	
		
		$school = pdo_fetch("SELECT logo,title,style2,id FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		
		$student = pdo_fetch("SELECT id,bj_id FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));		

		$bj_id = $student['bj_id'];
		$thistime = trim($_GPC['limit']);
		if($thistime){
			$condition = " AND createtime < '{$thistime}'";	
			$leave1 = pdo_fetchall("SELECT id,bj_id,title,tname,tid,createtime,content,ismobile,km_id FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And type = 3 And bj_id = '{$bj_id}' $condition ORDER BY createtime DESC LIMIT 0,10 ");
			foreach($leave1 as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$kemu = pdo_fetch("SELECT sname,icon FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['km_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$leave1[$key]['kmname'] = $kemu['sname'];
				$leave1[$key]['kmicon'] = empty($kemu['icon']) ? $school['logo'] : $kemu['icon'];
				$leave1[$key]['banji'] = $banji['sname'];
				$leave1[$key]['name'] = $teach['tname'];
				mload()->model('read');
				$ydrs = check_readtype($weid,$schoolid,$it['id'],$row['id']);
				$leave1[$key]['ydrs'] = $ydrs;
				$leave1[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template('comtool/szuoyelist'); 
		}else{
			$leave = pdo_fetchall("SELECT id,bj_id,title,tname,tid,createtime,content,ismobile,km_id FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And type = 3 And bj_id = '{$bj_id}' ORDER BY createtime DESC LIMIT 0,10 ");
			foreach($leave as $key =>$row){
				$banji = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['bj_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$kemu = pdo_fetch("SELECT sname,icon FROM " . tablename($this->table_classify) . " where sid = :sid And schoolid = :schoolid ", array(':schoolid' => $schoolid,':sid' => $row['km_id']));
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
				$leave[$key]['kmname'] = $kemu['sname'];
				$leave[$key]['kmicon'] = empty($kemu['icon']) ? $school['logo'] : $kemu['icon'];
				$leave[$key]['banji'] = $banji['sname'];
				$leave[$key]['name'] = $teach['tname'];
				mload()->model('read');
				$ydrs = check_readtype($weid,$schoolid,$it['id'],$row['id']);
				$leave[$key]['ydrs'] = $ydrs;
				$leave[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template(''.$school['style2'].'/szuoyelist');
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