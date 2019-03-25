<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
        $from_user = $_W['openid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$act = "bjq";
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id = :id And :schoolid = schoolid", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $userid['id']));
		if(empty($it)){
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
		}
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid And schoolid = :schoolid AND id = :id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $it['tid']));
		if($teachers['status'] == 1){
			$fisrtbj =  pdo_fetch("SELECT bj_id FROM " . tablename($this->table_class) . " where weid = '{$weid}' And schoolid = '{$schoolid}'  And tid = {$it['tid']} ");
		}
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
		$nowbj = pdo_fetch("SELECT sname,parentid,is_bjzx,star FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $bj_id));
		$star = unserialize($nowbj['star']);
		$bzj = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid And type = 'theclass' And sid = :sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid'], ':sid' => $bj_id));
		if($bzj){
			$thisclassstu = pdo_fetchall("SELECT id,icon,s_name FROM " . tablename($this->table_students) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And bj_id = '{$bj_id}' ORDER BY id DESC");
		}
		$bnjzr = pdo_fetch("SELECT sid FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid And sid = :sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid'], ':sid' => $nowbj['parentid']));
		$bjlists = get_mylist($schoolid,$it['tid'],'teacher');
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
		$thistime = strtotime($_GPC['limit']);
		if($thistime){
			$condition = " AND createtime < '{$thistime}'";
			$list1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 0 And ( bj_id1 = '{$bj_id}' Or bj_id2 = '{$bj_id}' Or bj_id3 = '{$bj_id}' ) $condition ORDER BY createtime DESC LIMIT 0,10");
			foreach ($list1 as $index => $v) {
				if (!empty($v['sherid'])) {
					$list1[$index]['picurl'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_media) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid =:sherid  ORDER BY id ASC", array(':sherid'=>$v['sherid']));
					$list1[$index]['znames'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_dianzan) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid =:sherid  ORDER BY createtime ASC LIMIT 0,4", array(':sherid'=>$v['sherid']));
					$num = count($list1[$index]['zname']);
					$list1[$index]['contents'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND type=1 AND sherid =:sherid  ORDER BY createtime ASC", array(':sherid'=>$v['sherid']));
					$list1[$index]['isdianz'] = pdo_fetch("SELECT id FROM " . tablename($this->table_dianzan) . " where :schoolid = schoolid And :weid = weid  And :uid = uid And :sherid = sherid", array(
			          ':weid' => $weid,
                      ':schoolid' => $schoolid,
					  ':uid' => $it['uid'],
					  ':sherid' => $v['id']
					   ));
				} 
				$members = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $weid, ':uid' => $v['uid']));
				$list1[$index]['avatar'] = $members['avatar'];
				$list1[$index]['time'] = sub_day($v['createtime']);
			}
			include $this->template('comtool/bjqlist');
		}else{
			if($bj_id != 0){
					if($school['bjqstyle'] =='old'){
						$tj = " ORDER BY createtime DESC";
					}
					if($school['bjqstyle'] =='new'){
						$tj = " ORDER BY createtime DESC LIMIT 0,10";
					}					
					$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 0 And ( bj_id1 = '{$bj_id}' Or bj_id2 = '{$bj_id}' Or bj_id3 = '{$bj_id}' ) $tj ");
				   // $children = array();
					foreach ($list as $index => $row) {
						if (!empty($row['sherid'])) {
							$list[$index]['picurl'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_media) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid =:sherid  ORDER BY id ASC", array(':sherid'=>$row['sherid']));
							$list[$index]['zname'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_dianzan) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid =:sherid  ORDER BY createtime ASC LIMIT 0,4", array(':sherid'=>$row['sherid']));
							$list[$index]['contents'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND type=1 AND sherid =:sherid  ORDER BY createtime ASC", array(':sherid'=>$row['sherid']));
							$list[$index]['isdianz'] = pdo_fetch("SELECT id FROM " . tablename($this->table_dianzan) . " where :schoolid = schoolid And :weid = weid  And :uid = uid And :sherid = sherid", array(
							  ':weid' => $weid,
							  ':schoolid' => $schoolid,
							  ':uid' => $it['uid'],
							  ':sherid' => $row['id']
							   ));								
						} 
						$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $weid, ':uid' => $row['uid']));
						$list[$index]['avatar'] = $member['avatar'];
						$list[$index]['time'] = sub_day($row['createtime']);
					}					
			}
			if($school['bjqstyle'] =='old'){
				include $this->template(''.$school['style3'].'/bjq');
			}
			if($school['bjqstyle'] =='new'){
				include $this->template(''.$school['style3'].'/bjqnew');
			}							
		}        
?>