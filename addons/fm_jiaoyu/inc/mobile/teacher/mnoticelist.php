<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
        $obid = 1;
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));	
		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['tid']));		

		$thistime = trim($_GPC['limit']);
			if($thistime){
			$condition = " AND createtime < '{$thistime}'";	
		    $leave1 = pdo_fetchall("SELECT id,title,tname,createtime,type,tid,content FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And type = 2   $condition  ORDER BY createtime DESC LIMIT 0,5 ");			
			foreach($leave1 as $key =>$row){
				
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
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
					$leave1[$key]['tzlx'] = "校园通知";
				}				
				$leave1[$key]['time'] = date('Y-m-d H:i', $row['createtime']);	
			} 
			include $this->template('comtool/mnoticelist'); 
		}else{
		    $leave = pdo_fetchall("SELECT id,bj_id,title,tname,createtime,type,tid,content FROM " . tablename($this->table_notice) . " where weid = '{$weid}' And schoolid = '{$schoolid}' And type = 2    ORDER BY createtime DESC LIMIT 0,5 ");
			foreach($leave as $key =>$row){
				
				$teach = pdo_fetch("SELECT status,thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
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
			include $this->template(''.$school['style3'].'/mnoticelist');	
		}	
 if(!empty($it)){
		
			$this->checkobjiect($schoolid, $teachers['id'], $obid);
 }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }       








?>