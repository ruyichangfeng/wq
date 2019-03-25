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
		$leaveid = $_GPC['id'];
		$record_id = intval($_GPC['record_id']);

		if (!empty($_GPC['userid'])){
		    $_SESSION['user'] = $_GPC['userid'];
		}
		$obid = 1;
        
        //查询是否用户登录
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where id = :id ", array(':id' => $_SESSION['user']));
		$leave = pdo_fetch("SELECT * FROM " . tablename($this->table_notice) . " where :id = id", array(':id' => $leaveid));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  :weid AND schoolid =:schoolid ORDER BY sid ASC, ssort DESC", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		
        $bzrtid = $category[$leave['bj_id']]['tid'];
		$bjname = $category[$leave['bj_id']]['sname'];
		
        if(!empty($it)){
            
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $it['sid']));
			$this->checkobjiect($schoolid, $it['sid'], $obid);
			$picarr = iunserializer($leave['picarr']);
			$record = pdo_fetch("SELECT * FROM " . tablename($this->table_record) . " where id = :id", array(':id' => $record_id));
			if(empty($record['readtime'])){
				$date = array(
					'readtime' =>time()
				);
				pdo_update($this->table_record, $date, array('id' => $record_id));				
			}
		   include $this->template(''.$school['style2'].'/szuoye');
        }else{
		   session_destroy();
           include $this->template('bangding');
        }        
?>