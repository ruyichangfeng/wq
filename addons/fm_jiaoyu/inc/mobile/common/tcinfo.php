<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
		$schoolid = intval($_GPC['schoolid']);
		$tid = intval($_GPC['tid']);
        
		//教师列表按教师入职时间先后顺序排列，先入职再前
		$leixing = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid =:weid ORDER BY id ASC, ssort DESC", array(':weid' => $weid), 'id');
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid = :weid AND schoolid =:schoolid AND tid =:tid ORDER BY end DESC", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $tid));
        $it = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		$item = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " WHERE schoolid = :schoolid And id = :id ", array(':schoolid' => $schoolid, ':id' => $tid));
       

        if (empty($item)) {
            message('参数错误！');
        }
		
        include $this->template(''.$school['style1'].'/tcinfo');
?>