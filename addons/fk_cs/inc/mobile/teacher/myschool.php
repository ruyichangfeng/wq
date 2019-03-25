<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
        
        //查询是否用户登录		
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where  weid = :weid And schoolid = :schoolid And openid = :openid And sid = :sid And pid = :pid Order by createtime desc ", array(
					':weid' => $weid,
					':schoolid' => $schoolid,
					':openid' => $openid,
					':sid' => 0,
					':pid' => 0
					));
		if(!empty($it)){		
			$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));

			$rest = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_torder)." WHERE tid = {$it['tid']} And orderStatus = '1'  and weid = {$weid} and schoolid={$schoolid}");

			$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $it['tid']));

//			$bzj = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid And type = :type", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid'], ':type' => 'theclass'));
//
//			$njzr = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid And type = :type", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid'], ':type' => 'semester'));
			
//			$bj1 = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid", array(':sid' => $teacher['bj_id1']));
//
//			$bj2 = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid", array(':sid' => $teacher['bj_id2']));
//
//			$bj3 = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid", array(':sid' => $teacher['bj_id3']));

			$km1 = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid", array(':sid' => $teacher['km_id1']));

			$km2 = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid", array(':sid' => $teacher['km_id2']));

			$km3 = pdo_fetch("SELECT sname FROM " . tablename($this->table_classify) . " where sid = :sid", array(':sid' => $teacher['km_id3']));

//			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And tid = '{$it['tid']}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");
			
			
 

		    $userinfo = iunserializer($it['userinfo']);
		    
			
			include $this->template(''.$school['style3'].'/myschool');
        }else{
			$bdTeacher = true;
			include $this->template('bangding');
        }        
?>