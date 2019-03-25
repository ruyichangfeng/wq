<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$userss = !empty($_GPC['userid']) ? intval($_GPC['userid']) : 1;
		$openid = $_W['openid'];
		$obid = 2;

        //查询是否用户登录

		mload()->model('user');
		$_SESSION['user'] = check_userlogin($weid,$schoolid,$openid,$userss);
		if ($_SESSION['user'] ==2){
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
		}
		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
        if(!empty($it)){
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
			$student = pdo_fetch("SELECT bj_id FROM " . tablename($this->table_students) . " where id = :id AND schoolid = :schoolid ", array(':id' => $it['sid'], ':schoolid' => $schoolid));
			$starttime = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$endtime = $starttime + 86399;	
			$condition = " AND createtime > '{$starttime}' AND createtime < '{$endtime}'";			
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_checklog) . " where schoolid = :schoolid AND sid = :sid $condition ORDER BY createtime DESC", array(':schoolid' => $schoolid, ':sid' => $it['sid'])); 
		    $this->checkobjiect($schoolid, $it['sid'], $obid);
			include $this->template(''.$school['style2'].'/wxsign');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;			
        }        
?>