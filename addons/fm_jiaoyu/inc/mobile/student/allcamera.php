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

		mload()->model('user');
		$_SESSION['user'] = check_userlogin($weid,$schoolid,$openid,$userss);
		if ($_SESSION['user'] == 2){
			include $this->template('bangding');
		}
		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " where :weid = weid And :openid = openid And :tid = tid", array(
				':weid' => $weid,
				':openid' => $openid,
				':tid' => 0
		));
		$bdsun = count($user);
		foreach($user as $key => $row){
			$student = pdo_fetch("SELECT s_name,id,schoolid,bj_id FROM " . tablename($this->table_students) . " where id=:id ", array(':id' => $row['sid']));
			$bajinam = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid=:sid ", array(':sid' => $student['bj_id']));
			$user[$key]['s_name'] = $student['s_name'];
			$user[$key]['bjname'] = $bajinam['sname'];
			$user[$key]['sid'] = $student['id'];  
			$user[$key]['schoolid'] = $student['schoolid'];
		}		
		$school = pdo_fetch("SELECT style2,title,videopic FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $schoolid));	
        if(!empty($it)){
			$student = pdo_fetch("SELECT id,bj_id,s_name FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));
			$mybj = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And sid = '{$student['bj_id']}' ");
			$myplsl  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_camerapl) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND bj_id = '{$student['bj_id']}' And type = 2");
			$mydzsl  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_camerapl) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND bj_id = '{$student['bj_id']}' And type = 1");
			$myisdz = pdo_fetch("SELECT id FROM " . tablename($this->table_camerapl) . " where weid = :weid AND schoolid = :schoolid AND bj_id = :bj_id AND userid = :userid AND type =:type", array(':weid' => $weid, ':schoolid' => $schoolid, ':bj_id' => $student['bj_id'], ':userid' => $it['id'],':type' => 1));		
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_allcamera) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' ORDER BY ssort DESC");
            foreach ($list as $key => $row) {
				$plsl  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_camerapl) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND carmeraid = '{$row['id']}' And type = 2");
				$dzsl  = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_camerapl) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND carmeraid = '{$row['id']}' And type = 1");
				$isdz = pdo_fetch("SELECT id FROM " . tablename($this->table_camerapl) . " where weid = :weid AND schoolid = :schoolid AND carmeraid = :carmeraid AND userid = :userid", array(':weid' => $weid, ':schoolid' => $schoolid, ':carmeraid' => $row['id'], ':userid' => $it['id']));
				$list[$key]['plsl'] = $plsl;
				$list[$key]['dianzan'] = $dzsl;
				$list[$key]['isdz'] = $isdz;					
				if(!empty($row['bj_id'])){
					$list[$key]['myvideo'] = explode(',', $row['bj_id']);
					foreach($list[$key]['myvideo'] as $r) {
							$list[$key]['myvideo']['pic'] == $row['videopic'];
							$list[$key]['myvideo']['name'] == $row['name'];
					}
				}
            }
			include $this->template(''.$school['style2'].'/allcamera');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>