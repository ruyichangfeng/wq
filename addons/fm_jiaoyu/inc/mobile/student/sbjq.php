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
		$obid = 2;
		$userss = intval($_GPC['userid']);
		$act = "bjq";
		//获取用户信息   （Lee 0721） 
		$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :weid = weid And :openid = openid And :tid = tid", array(
				':weid' => $weid,
				':openid' => $openid,
				':tid' => 0
				));
		$num = count($user);
		$flag = 1;
		if ($num > 1){
			$flag = 2;
		}
		foreach($user as $key => $row){
			//获取学生信息   （Lee 0721） 
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id=:id ", array(':id' => $row['sid']));
			$bajinam = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid=:sid ", array(':sid' => $student['bj_id']));
			$user[$key]['s_name'] = $student['s_name'];
			$user[$key]['bjname'] = $bajinam['sname'];
			$user[$key]['sid'] = $student['id'];
			$user[$key]['schoolid'] = $student['schoolid'];
		}
		if(!empty($userss)){
			$ite = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(':schoolid' => $schoolid,':weid' => $weid, ':id' => $userss));
			if(!empty($ite)){
				// 如果这个userss在user表里存在，就把ID写入session （Lee 0721）
				$_SESSION['user'] = $ite['id'];
			}else{
				//如果这个userss在user表里不存在，就跳转，查这个微信是否绑定了教师  （Lee 0721） 
				//同一个微信，绑定学生和绑定教师的话在user表里的ID是不同的  （Lee 0721）
				$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('myschool', array('schoolid' => $schoolid));
				header("location:$stopurl");
				exit;
			}			
		}else{
			//如果从GPC里没有获取到ID,就采用查询表的方式取得ID并写入session （Lee 0721）
			if(empty($_SESSION['user'])){
				$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid LIMIT 0,1 ", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
				$_SESSION['user'] = $userid['id'];
			}
		}
		
        //查询是否用户登录		

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And weid = :weid AND id=:id ", array(':schoolid' => $schoolid,':weid' => $weid, ':id' => $_SESSION['user']));	
		$school = pdo_fetch("SELECT style2,title,bjqstyle,spic,isopen FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));		
        $shenfen = "";	
		$isopen = 0;
		if ($it['pard'] == 2){
			$shenfen = "母亲";
		}else if($it['pard'] == 3){	
		    $shenfen = "父亲";
		}else if($it['pard'] == 4){	
		    $shenfen = "本人";			
		}else if($it['pard'] == 5){	
		    $shenfen = "家长";			
		}		
        $bj_id = $students['bj_id'];
		$bjset = pdo_fetch("SELECT is_bjzx,star FROM " . tablename($this->table_classify) . " where schoolid = :schoolid AND sid=:sid", array(':schoolid' => $schoolid, ':sid' => $bj_id));
		$star = unserialize($bjset['star']);
		$thistime = strtotime($_GPC['limit']);
		if($thistime){
			//下拉后的内容 （lee 0721）
			$condition = " AND createtime < '{$thistime}'";
			$list1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 0 And (isopen = 0 Or uid = '{$it['uid']}') And ( bj_id1 = '{$bj_id}' Or bj_id2 = '{$bj_id}' Or bj_id3 = '{$bj_id}' ) $condition ORDER BY createtime DESC LIMIT 0,10");
			foreach ($list1 as $index => $v) {
				if (!empty($v['sherid'])) {
					$list1[$index]['picurl'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_media) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid = '{$v['sherid']}'  ORDER BY id ASC" );
					//获取点赞信息  如果点赞的不止一个人，则$list1[$index]['znames']里是数组  （Lee 0721）
					$list1[$index]['znames'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_dianzan) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid = '{$v['sherid']}'  ORDER BY createtime ASC LIMIT 0,4" );
					
					//点赞人数 （lee 0721）
					$list1[$index]['num']= count($list1[$index]['znames']); //（lee 0721）
					
					$list1[$index]['contents'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND type=1 AND sherid ={$v['sherid']}  ORDER BY createtime ASC" );
					$list1[$index]['isdianz'] = pdo_fetch("SELECT id FROM " . tablename($this->table_dianzan) . " where :schoolid = schoolid And :weid = weid  And :uid = uid And :sherid = sherid", array(
			          ':weid' => $weid,
                      ':schoolid' => $schoolid,
					  ':uid' => $it['uid'],
					  ':sherid' => $v['id']
					   ));
				} 
				$members = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $v['uid']));
				$list1[$index]['avatar'] = $members['avatar'];
				$list1[$index]['time'] = sub_day($v['createtime']);
			}
			include $this->template('comtool/bjqlist');
		}else{
			//一开始的内容 （lee 0721）
			if(!empty($it)){
				if($school['bjqstyle'] =='old'){
					$tj = " ORDER BY createtime DESC";
				}
				if($school['bjqstyle'] =='new'){
					$tj = " ORDER BY createtime DESC LIMIT 0,10";
				}
				$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 0 And (isopen = 0 Or uid = '{$it['uid']}') And ( bj_id1 = '{$bj_id}' Or bj_id2 = '{$bj_id}' Or bj_id3 = '{$bj_id}') $tj ");
			
				foreach ($list as $index => $row) {
					 if (!empty($row['sherid'])) {
						$list[$index]['picurl'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_media) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid = '{$row['sherid']}'  ORDER BY id ASC" );
						$list[$index]['zname'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_dianzan) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid = '{$row['sherid']}'  ORDER BY createtime ASC" );

					$list[$index]['num']= count($list[$index]['zname']);
						
						$list[$index]['contents'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND type=1 AND sherid = '{$row['sherid']}'  ORDER BY createtime ASC" );
					}
					$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $weid, ':uid' => $row['uid']));
					$list[$index]['avatar'] = $member['avatar'];	
					$list[$index]['time'] = sub_day($row['createtime']);	
				}

			 	//检查用户是否付费开通了班级圈功能	 （lee 0721）		
				$this->checkpay($schoolid, $students['id'], $it['id'], $it['uid']);
				$this->checkobjiect($schoolid, $students['id'], $obid);
				if($school['bjqstyle'] =='old'){
					include $this->template(''.$school['style2'].'/sbjq');
				}
				if($school['bjqstyle'] =='new'){
					include $this->template(''.$school['style2'].'/sbjqnew');
				}
			}else{
				session_destroy();
				$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bjq', array('schoolid' => $schoolid));
				header("location:$stopurl");
				exit;
			}
		}   
		    
?>