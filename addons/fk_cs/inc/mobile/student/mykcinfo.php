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

		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));		

		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND schoolid=:schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $its['sid']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_kcbiao) . " WHERE weid = :weid AND schoolid =:schoolid AND kcid = :kcid  ORDER BY date ASC", array(':weid' => $weid, ':schoolid' => $schoolid, ':kcid' => $id));
        $item1 = pdo_fetch("SELECT * FROM " . tablename($this->table_kcbiao) . " WHERE id = :id ", array(':id' => $id));
		$item = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = :id ", array(':id' => $id));
        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND id=:id", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $item['tid']));
		$title = $item['title'];
        $category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid = :weid AND schoolid = :schoolid ", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
				
		$isxiangqing =false;
		
		if ($item1['isxiangqing'] == 1){
			
		$isxiangqing =true;
		
		}
		   		
        include $this->template(''.$school['style2'].'/mykcinfo');
?>