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
        $act = "wd";
        //查询是否用户登录	
        //查询该微信是否绑定了教师（Lee 0721）	
		$schoollist = get_myschool($weid,$openid);
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where  weid = :weid And schoolid = :schoolid And openid = :openid And sid = :sid ", array(
					':weid' => $weid,
					':schoolid' => $schoolid,
					':openid' => $openid,
					':sid' => 0
					));
		$guid = need_guid($it['id'],$schoolid,2);
		if(!empty($guid)){
			pdo_update($this->table_user, array('is_frist' => 2), array('id' => $it['id']));	
			$stopurl = $_W['siteroot'] . 'app/index.php?i=' . $weid . '&c=entry&do=guid&m=fm_jiaoyu'.'&schoolid='.$schoolid.'&guid='.$guid.'&place=myschool';
			header("location:$stopurl");
			exit;
		}					
		$bjlists = get_mylist($schoolid,$it['tid'],'teacher');		
		if(!empty($schoollist)){
			// 获取该微信绑定的老师的学校信息（Lee 0721）
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
			//获取老师信息（Lee 0721）
			$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $it['tid']));
			//获取一条该教师在该学校的班级信息   （Lee 0721） 
			$bzj = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid And type = :type", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid'], ':type' => 'theclass'));
			//获取该教师在该学校的年级信息 （Lee 0721）年级主任
			$njzr = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid And type = :type", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid'], ':type' => 'semester'));
				//获取所有该教师在该学校的班级信息   （Lee 0721） 		
			$bjlist = pdo_fetchall("SELECT sid,sname FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
			//格式化userinfo  （Lee 0721） 
		    $userinfo = iunserializer($it['userinfo']); 
			if($schoolid){
				include $this->template(''.$school['style3'].'/myschool');
			}else{
				include $this->template('teacher/myschool');
			}
        }else{
			if($schoolid){
				$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
				header("location:$stopurl");
			}else{
				$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('binding');
				header("location:$stopurl");
			}			
        }        
?>