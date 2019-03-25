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
        
		//教师列表按教师入职时间先后顺序排列，先入职再前
		$leixing = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid =:weid ORDER BY id ASC, ssort DESC", array(':weid' => $_W['uniacid']), 'id');
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE weid = :weid AND schoolid =:schoolid AND is_show =:is_show ORDER BY id DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_show' => 0));
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE schoolid = :schoolid ", array(':schoolid' => $schoolid));
        $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
	
        include $this->template(''.$school['style1'].'/teachers');
?>