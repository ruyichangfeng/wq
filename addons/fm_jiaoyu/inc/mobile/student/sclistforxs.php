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
		$obid = 2;
        //查询是否用户登录
		mload()->model('user');
		$_SESSION['user'] = check_userlogin($weid,$schoolid,$openid,$userss);
		if ($_SESSION['user'] == 2){
			include $this->template('bangding');
		}			
		$it = pdo_fetch("SELECT id,sid FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));		
		$school = pdo_fetch("SELECT style2,spic,tpic,title FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$student = pdo_fetch("SELECT icon,bj_id FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));
		if(!empty($it)){
			$bjidname = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $student['bj_id']));
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_sc) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And bj_id = '{$student['bj_id']}' ORDER BY createtime DESC");
			foreach($list as $key => $vule){
				$scset = pdo_fetch("SELECT icon,allowshare FROM " . tablename($this->table_scset) . " where :id = id ", array(':id' => $vule['setid'])); 
				$kc = pdo_fetch("SELECT name FROM " . tablename($this->table_tcourse) . " where id = '{$vule['kcid']}' ");
				$teacher = pdo_fetch("SELECT tname FROM " . tablename($this->table_teachers) . " where :id = id ", array(':id' => $vule['tid']));
				$bj = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $vule['bj_id']));
				$qh = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $vule['xq_id']));
				$islsdp = pdo_fetch("SELECT id FROM " . tablename ($this->table_scforxs) . " where schoolid = :schoolid And scid = :scid And sid = :sid And type = :type And fromto = :fromto", array(':schoolid' => $schoolid, ':scid' => $vule['id'], ':type' => 2, ':fromto' => 1, ':sid' => $it['sid']));	
				$isjzdp = pdo_fetch("SELECT id FROM " . tablename ($this->table_scforxs) . " where schoolid = :schoolid And scid = :scid And sid = :sid And type = :type And fromto = :fromto", array(':schoolid' => $schoolid, ':scid' => $vule['id'], ':type' => 2, ':fromto' => 2, ':sid' => $it['sid']));				
				$list[$key]['islsdp'] = $islsdp['id'];
				$list[$key]['isjzdp'] = $isjzdp['id'];
				if ($scset['allowshare'] == 1){
					$list[$key]['allowshare'] = $scset['allowshare'];
				}
				$list[$key]['icon'] = $scset['icon'];
				$list[$key]['kcname'] = $kc['name'];
				$list[$key]['bjname'] = $bj['sname'];
				$list[$key]['xqname'] = $qh['sname'];
				$list[$key]['tname'] = $teacher['tname'];
			}		
			$this->checkobjiect($schoolid, $it['sid'], $obid);
			include $this->template(''.$school['style2'].'/sclistforxs');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>