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
		$bj_id = intval($_GPC['bj_id']);
		$id = trim($_GPC['id']); 
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
		if($it){
			$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			if($id){
				$PlanUid = $id;
				$palan = pdo_fetch("SELECT * FROM " . tablename($this->table_zjh) . " where weid = :weid AND schoolid = :schoolid  AND planuid = :planuid ", array(':weid' => $weid, ':schoolid' => $schoolid, ':planuid' => $PlanUid));
			}
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));	
			include $this->template(''.$school['style2'].'/szjh');	
		}else{
			session_destroy();
		    $stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('bangding', array('schoolid' => $schoolid));
			header("location:$stopurl");
			exit;
		}
		

		

		
		
?>