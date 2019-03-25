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
		$leaveid = $_GPC['id'];
		$obid = 3;

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));

		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id ", array(':weid' => $weid, ':id' => $schoolid));
		
				
        if(!empty($it)){
            
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['sid']));
						
			$category = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid And schoolid = :schoolid And sid = :sid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':sid' => $student['bj_id']));
			
			$this->checkobjiect($schoolid, $student['id'], $obid);
			
			include $this->template(''.$school['style2'].'/video');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>