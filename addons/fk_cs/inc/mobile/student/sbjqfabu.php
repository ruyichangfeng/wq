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
        
        //查询是否用户登录		

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['sid']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $schoolid));		
        $bjidname = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $students['bj_id']));
			
        $shenfen = "";
		
		if ($it['pard'] == 2){
			$shenfen = "母亲";
		}else if($it['pard'] == 3){
		    $shenfen = "父亲";
		}else if($it['pard'] == 4){
		    $shenfen = "本人";
		}else if($it['pard'] == 5){
		    $shenfen = "家长";				
		}
			
        if(!empty($it)){
            			
		    include $this->template(''.$school['style2'].'/sbjqfabu');
         
		}else{
			session_destroy();
			include $this->template('bangding');  
		}        
?>