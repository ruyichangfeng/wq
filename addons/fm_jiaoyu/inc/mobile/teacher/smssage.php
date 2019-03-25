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
		        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id = :id ", array(':weid' => $weid, ':id' => $userid['id']));	
		$teachers = pdo_fetch("SELECT id,tname FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $it['tid']));		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
        if(!empty($userid['id'])){
			if(!empty($_GPC['bj_id'])){
				$bj_id = $_GPC['bj_id'];
			}else{
				$mybjlist = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = {$schoolid} And type = 'theclass' And tid = {$it['tid']} ORDER BY ssort DESC LIMIT 0,1 ");
				$bj_id = $mybjlist['sid'];
			}
			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");			
			$bjidname = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $bj_id));			
		    $leave = pdo_fetchall("SELECT * FROM " . tablename($this->table_leave) . " where :schoolid = schoolid And :weid = weid And :tid = tid And :bj_id = bj_id And :isliuyan = isliuyan ORDER BY status ASC , createtime DESC", array(
		         ':weid' => $weid,
				 ':schoolid' => $schoolid,
				 ':bj_id' => $bj_id,
				 ':tid' => 0,
				 ':isliuyan' => 0
				 ));
			$thisid = 0;	 
			foreach ($leave as $index => $row) {
				$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $row['uid']));
				$student = pdo_fetch("SELECT * FROM " . tablename ($this->table_students) . " where weid = :weid And id = :id ", array(':weid' => $weid, ':id' => $row['sid']));
				$user = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where uid = :uid And openid = :openid And sid = :sid ", array(':uid' => $row['uid'],':openid' => $row['openid'],':sid' => $row['sid']));
				if($user['pard'] ==2){
					$leave[$index]['guanxi'] = "妈妈";
				}
				if($user['pard'] ==3){
					$leave[$index]['guanxi'] = "爸爸";
				}
				if($user['pard'] ==4){
					$leave[$index]['guanxi'] = "本人";
				}
				if($user['pard'] ==5){
					$leave[$index]['guanxi'] = "家长";
				}
				if(!$row['cltid']){
					$teacher = pdo_fetch("SELECT tname,thumb FROM " . tablename($this->table_teachers) . " where id = :id AND schoolid = :schoolid ", array(':id' => $it['tid'], ':schoolid' => $schoolid));
					$leave[$index]['tname'] = $teacher['tname'];
					$leave[$index]['thumb'] = $teacher['thumb'];					
				}else{
					$teacher = pdo_fetch("SELECT tname,thumb FROM " . tablename($this->table_teachers) . " where id = :id AND schoolid = :schoolid ", array(':id' => $row['cltid'], ':schoolid' => $schoolid));
					$leave[$index]['tname'] = $teacher['tname'];
					$leave[$index]['thumb'] = $teacher['thumb'];
				}
				$leave[$index]['s_name'] = $student['s_name'];
				$leave[$index]['key'] = $thisid;
				$thisid ++;
			}	 			
			include $this->template(''.$school['style3'].'/smssage');
        }else{
			include $this->template('bangding');
        }        
?>