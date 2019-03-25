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
		$obid = 1;
        $nowtime = time();
        //查询是否用户登录
		if(!$_SESSION['user']){
			mload()->model('user');
			$_SESSION['user'] = check_userlogin($weid,$schoolid,$openid,$userss);
			if ($_SESSION['user'] ==2){
				include $this->template('bangding');
			}
		}
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$this->checkobjiect($schoolid, $it['sid'], $obid);
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid)); 		
        if($it){
			$student = pdo_fetch("SELECT s_name,bj_id FROM " . tablename($this->table_students) . " where id = :id", array(':id' => $it['sid']));
			$bjidname = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where :sid = sid ", array(':sid' => $student['bj_id']));
			$weekplanlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_zjh) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And bj_id = '{$student['bj_id']}' And is_on = 2 ORDER BY createtime,is_on DESC");
			foreach($weekplanlist as $key => $vule){
				if($vule['type'] == 1){
					$weekplanlist[$key]['type'] = 'img';
				}else{
					$weekplanlist[$key]['type'] = 'word';
				}
			}		
			include $this->template(''.$school['style2'].'/szjhlist');
        }else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
        }        
?>