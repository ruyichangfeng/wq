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
		$userss = !empty($_GPC['userid']) ? intval($_GPC['userid']) : 1;
		$id = intval($_GPC['id']);
		$scid = $_GPC['scid'];
		$setid = $_GPC['setid'];		
		$obid = 2;
        //查询是否用户登录
		mload()->model('user');
		$_SESSION['user'] = check_userlogin($weid,$schoolid,$openid,$userss);
		if ($_SESSION['user'] ==2){
			include $this->template('bangding');
		}			
		$it = pdo_fetch("SELECT id,sid FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));	
		$school = pdo_fetch("SELECT style2,title,spic,tpic,title FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		$student = pdo_fetch("SELECT s_name,icon FROM " . tablename($this->table_students) . " where id = :id", array(':id' => $it['sid']));
        if(!empty($it)){
			if($_GPC['op'] =='savedata'){
				if(!$_GPC['op'] || !$_GPC['schoolid'] || !$_GPC['weid'] || !$_GPC['sid'] ){
					$data ['status'] = 2;
					$data ['info'] = '非法请求！';
				}
				if(!$_GPC['comment']){
					$data ['status'] = 2;
					$data ['info'] = '评语不能为空！';						
	
				}else{
					$temp = array(  //存储文字评价 条件  老师id  评语 时间
						'weid'=> $weid,
						'schoolid'=> $schoolid,
						'scid'=> $_GPC['scid'],
						'sid'=> $_GPC['sid'],
						'setid'=> $_GPC['setid'],
						'userid'=> $_GPC['userid'],
						'jzword'=> trim($_GPC['comment']),
						'fromto'=> 2,
						'type'=> 1,
						'createtime'=> time()
					);
					pdo_insert($this->table_scforxs, $temp);
					$performance = explode(',',$_GPC['performance']);
					foreach($performance as $key => $row){
						$performance[$key] = explode('_',$row);
						if(!empty($row)){
							$temp1 = array(  //存储表现登记评价 条件  老师id  等级id及等级 时间
								'weid'=> $weid,
								'schoolid'=> $schoolid,
								'scid'=> $_GPC['scid'],
								'setid'=> $_GPC['setid'],
								'sid'=> $_GPC['sid'],
								'userid'=> $_GPC['userid'],
								'iconsetid'=> $performance[$key][0],
								'iconlevel'=> $performance[$key][1],
								'fromto'=> 2,
								'type'=> 2,
								'createtime'=> time()
							);	
							pdo_insert($this->table_scforxs, $temp1);
							//p($row);
						}
					}
					$data ['status'] = 1;
					$data ['info'] = '保存成功！';						
				}
				die ( json_encode ( $data ) );
			}
			if($_GPC['op'] =='updata'){
				if(!$_GPC['op'] || !$_GPC['schoolid'] || !$_GPC['weid'] || !$_GPC['sid'] ){
					$data ['status'] = 2;
					$data ['info'] = '非法请求！';
				}
				if(!$_GPC['comment']){
					$data ['status'] = 2;
					$data ['info'] = '评语不能为空！';						
	
				}else{
					$temp = array(  //存储文字评价 条件  老师id  评语 时间
						'weid'=> $weid,
						'schoolid'=> $schoolid,
						'scid'=> $_GPC['scid'],
						'sid'=> $_GPC['sid'],
						'setid'=> $_GPC['setid'],
						'userid'=> $_GPC['userid'],
						'jzword'=> trim($_GPC['comment']),
						'fromto'=> 2,
						'type'=> 1,
						'createtime'=> time()
					);
					$ispyhave = pdo_fetch("SELECT id FROM " . tablename($this->table_scforxs) . " where weid = :weid And schoolid = :schoolid And sid = :sid And scid = :scid And userid = :userid And type = :type And fromto = :fromto", array(
						':weid' => $weid,
						':schoolid' => $schoolid,
						':sid' => $_GPC['sid'],
						':scid' => $_GPC['scid'],
						':userid' => $_GPC['userid'],
						':type' => 1,
						':fromto' => 2
					));
					if($ispyhave['id']){
						pdo_update($this->table_scforxs, $temp, array('id' => $ispyhave['id']));
					}else{
						pdo_insert($this->table_scforxs, $temp);
					}
					$performance = explode(',',$_GPC['performance']);
					foreach($performance as $key => $row){
						$performance[$key] = explode('_',$row);
						if(!empty($row)){
							$ispyhave1 = pdo_fetch("SELECT id FROM " . tablename($this->table_scforxs) . " where weid = :weid And schoolid = :schoolid And setid = :setid And sid = :sid And scid = :scid And iconsetid = :iconsetid And type = :type And fromto = :fromto", array(
								':weid' => $weid,
								':schoolid' => $schoolid,
								':sid' => $_GPC['sid'],
								':scid' => $_GPC['scid'],
								':setid' => $_GPC['setid'],
								':iconsetid' => $performance[$key][0],
								':type' => 2,
								':fromto' => 2
							));							
							$temp1 = array(  //存储表现登记评价 条件  老师id  等级id及等级 时间
								'weid'=> $weid,
								'schoolid'=> $schoolid,
								'scid'=> $_GPC['scid'],
								'setid'=> $_GPC['setid'],
								'sid'=> $_GPC['sid'],
								'userid'=> $_GPC['userid'],
								'iconsetid'=> $performance[$key][0],
								'iconlevel'=> $performance[$key][1],
								'fromto'=> 2,
								'type'=> 2,
								'createtime'=> time()
							);	
							if($ispyhave1['id']){
								pdo_update($this->table_scforxs, $temp1, array('id' => $ispyhave1['id']));
								//p($ispyhave1);
							}else{
								pdo_insert($this->table_scforxs, $temp1);
								//p($ispyhave1);
							}
						}
					}
					$data ['status'] = 1;
					$data ['info'] = '保存成功！';						
				}				
				die ( json_encode ( $data ) );
			}			
			$toppic = pdo_fetch("SELECT top2,top1 FROM " . tablename($this->table_scset) . " where id=:id ", array(':id' => $setid));
			$mypl = pdo_fetch("SELECT jzword FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And userid = :userid And type = :type And fromto = :fromto", array(':sid' => $it['sid'],':scid' => $scid,':userid' => $it['id'],':type' => 1,':fromto' => 2));		
			if($_GPC['op'] =='edite'){
				$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_scicon) . " where :schoolid = schoolid And :weid = weid And :setid = setid And :type = type  ORDER BY ssort ASC", array(
					 ':weid' => $weid,
					 ':schoolid' => $schoolid,
					 ':setid' => $setid,
					 ':type' => 2
				));
				foreach($list as $key => $row){
					$scforxs = pdo_fetch("SELECT iconlevel FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto And iconsetid = :iconsetid ", array(
						':sid' => $it['sid'],
						':scid' => $scid,
						':type' => 2,
						':fromto' => 2,
						':iconsetid' => $row['id'],
					));
					$list[$key]['iconlevel'] = $scforxs['iconlevel'];
				}
			}elseif($_GPC['op'] =='check'){
				if($_GPC['type'] =='home' || !$_GPC['type']){
					$allpl = pdo_fetchall("SELECT jzword,userid,createtime FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto ORDER BY createtime DESC", array(
						':sid' => $it['sid'],
						':scid' => $scid,
						':type' => 1,
						':fromto' => 2
					));
					foreach($allpl as $key => $row){
						$user = pdo_fetch("SELECT userinfo,pard,uid FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $row['userid']));
						$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $weid, ':uid' => $user['uid']));
						if($user['pard'] == 2){
							$pard = "-妈妈";
						}
						if($user['pard'] == 3){
							$pard = "-爸爸";
						}
						if($user['pard'] == 4){
							$pard = "";
						}
						if($user['pard'] == 5){
							$pard = "-家长";
						}
						if($user['userinfo']){
							$userinfo = iunserializer($user['userinfo']);
						}
						$allpl[$key]['tname'] = $userinfo['name'].$pard;
						$allpl[$key]['thumb'] = $member['avatar'];
						$allpl[$key]['time'] = sub_day($row['createtime']);
					}
					$list1 = pdo_fetchall("SELECT iconsetid,iconlevel FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto  ORDER BY iconsetid ASC", array(
						':sid' => $it['sid'],
						':scid' => $scid,
						':type' => 2,
						':fromto' => 2
					));
					foreach($list1 as $key => $row){
						$scicon = pdo_fetch("SELECT * FROM " . tablename($this->table_scicon) . " where id = :id ", array(':id' => $row['iconsetid']));
						$list1[$key]['title'] = $scicon['title'];	
						if ($row['iconlevel'] == 1){
							$list1[$key]['icontitle'] = $scicon['icon1title'];
							$list1[$key]['icon'] = $scicon['icon1'];						
						}
						if ($row['iconlevel'] == 2){
							$list1[$key]['icontitle'] = $scicon['icon2title'];
							$list1[$key]['icon'] = $scicon['icon2'];						
						}
						if ($row['iconlevel'] == 3){
							$list1[$key]['icontitle'] = $scicon['icon3title'];
							$list1[$key]['icon'] = $scicon['icon3'];						
						}
						if ($row['iconlevel'] == 4){
							$list1[$key]['icontitle'] = $scicon['icon4title'];
							$list1[$key]['icon'] = $scicon['icon4'];						
						}
						if ($row['iconlevel'] == 5){
							$list1[$key]['icontitle'] = $scicon['icon5title'];
							$list1[$key]['icon'] = $scicon['icon5'];						
						}					
					}
				}
				if($_GPC['type'] =='school'){
					$allpl = pdo_fetchall("SELECT tword,tid,createtime FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto ORDER BY createtime DESC", array(
						':sid' => $it['sid'],
						':scid' => $scid,
						':type' => 1,
						':fromto' => 1
					));
					foreach($allpl as $key => $row){
						$teacher = pdo_fetch("SELECT thumb,tname FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $row['tid']));
						$allpl[$key]['tname'] = $teacher['tname']."老师";
						$allpl[$key]['thumb'] = $teacher['thumb'];
						$allpl[$key]['time'] = sub_day($row['createtime']);
					}					
					$list1 = pdo_fetchall("SELECT iconsetid,iconlevel FROM " . tablename($this->table_scforxs) . " where sid = :sid And scid = :scid And type = :type And fromto = :fromto  ORDER BY iconsetid ASC", array(
						':sid' => $it['sid'],
						':scid' => $scid,
						':type' => 2,
						':fromto' => 1
					));
					foreach($list1 as $key => $row){
						$scicon = pdo_fetch("SELECT * FROM " . tablename($this->table_scicon) . " where id = :id ", array(':id' => $row['iconsetid']));
						$list1[$key]['title'] = $scicon['title'];	
						if ($row['iconlevel'] == 1){
							$list1[$key]['icontitle'] = $scicon['icon1title'];
							$list1[$key]['icon'] = $scicon['icon1'];						
						}
						if ($row['iconlevel'] == 2){
							$list1[$key]['icontitle'] = $scicon['icon2title'];
							$list1[$key]['icon'] = $scicon['icon2'];						
						}
						if ($row['iconlevel'] == 3){
							$list1[$key]['icontitle'] = $scicon['icon3title'];
							$list1[$key]['icon'] = $scicon['icon3'];						
						}
						if ($row['iconlevel'] == 4){
							$list1[$key]['icontitle'] = $scicon['icon4title'];
							$list1[$key]['icon'] = $scicon['icon4'];						
						}
						if ($row['iconlevel'] == 5){
							$list1[$key]['icontitle'] = $scicon['icon5title'];
							$list1[$key]['icon'] = $scicon['icon5'];						
						}					
					}
				}				
			}else{	
				$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_scicon) . " where :schoolid = schoolid And :weid = weid And :setid = setid And :type = type  ORDER BY ssort ASC", array(
					 ':weid' => $weid,
					 ':schoolid' => $schoolid,
					 ':setid' => $setid,
					 ':type' => 2
				));				
			}
			
			include $this->template(''.$school['style2'].'/scforxs');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>