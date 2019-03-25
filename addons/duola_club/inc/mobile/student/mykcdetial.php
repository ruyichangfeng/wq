<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid']; 
		$openid = $_W['openid'];
        $id = intval($_GPC['id']);
        $schoolid = intval($_GPC['schoolid']);
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_kcbiao) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $id));
        $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $item['schoolid'])); 

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));	        
		
		if(!empty($it)){
            include $this->template(''.$school['style2'].'/mykcdetial');
        }else{
			session_destroy();
            include $this->template('bangding');
        }
		
?>