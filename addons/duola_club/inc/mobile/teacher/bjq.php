<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $_W ['uniacid'];
        $from_user = $_W['openid'];
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id = :id And :schoolid = schoolid", array(':weid' => $weid, ':schoolid' => $schoolid, ':id' => $userid['id']));	
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid And schoolid = :schoolid AND id = :id", array(':weid' => $_W ['uniacid'], ':schoolid' => $schoolid, ':id' => $it['tid']));		
		$bzj = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And tid = :tid", array(':weid' => $weid, ':schoolid' => $schoolid, ':tid' => $it['tid']));	
		
		$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid = '{$schoolid}' ORDER BY sid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'sid');
        
        $bjid1 = $category[$teachers['bj_id1']]['sid'];
		$bjid2 = $category[$teachers['bj_id2']]['sid'];
		$bjid3 = $category[$teachers['bj_id3']]['sid'];
		
        $name1 = $category[$teachers['bj_id1']]['sname'];
		$name2 = $category[$teachers['bj_id2']]['sname'];
		$name3 = $category[$teachers['bj_id3']]['sname'];
		
		if(empty($_GPC['bj_id'])){ 
			$bj_id = $teachers['bj_id1'];		
		}else{
			$bj_id = intval($_GPC['bj_id']);	
		}
		
        if(!empty($userid['id'])){
						
			$member = pdo_fetchall("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid']), 'uid');
			$teacher = pdo_fetchall("SELECT * FROM " . tablename ($this->table_teachers) . " where weid = :weid AND schoolid = :schoolid", array(':weid' => $weid, ':schoolid' => $schoolid), 'id');	

		$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 0 And bj_id1 = '{$bj_id}' Or bj_id2 = '{$bj_id}' Or bj_id3 = '{$bj_id}' ORDER BY createtime DESC");
		
		$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And type = 'theclass' ORDER BY sid ASC, ssort DESC");	
       // $children = array();
        
            foreach ($list as $index => $row) {
            	 if (!empty($row['sherid'])) {
					$list[$index]['picurl'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_media) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid =:sherid  ORDER BY id ASC", array(':sherid'=>$row['sherid']));
					$list[$index]['zname'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_dianzan) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND sherid =:sherid  ORDER BY createtime ASC", array(':sherid'=>$row['sherid']));
					$list[$index]['contents'] = pdo_fetchall("SELECT * FROM " . tablename($this->table_bjq) . " WHERE weid = '{$weid}' AND schoolid = '{$schoolid}' AND type=1 AND sherid =:sherid  ORDER BY createtime ASC", array(':sherid'=>$row['sherid']));
                } 
				$member = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ORDER BY uid ASC", array(':uniacid' => $_W ['uniacid'], ':uid' => $row['uid']));
				$list[$index]['avatar'] = $member['avatar'];				
            }

	    	 
            
			$item = pdo_fetch("SELECT * FROM " . tablename($this->table_bjq) . " WHERE id = :id And weid = :weid And schoolid = :schoolid", array(':weid' => $_W ['uniacid'], ':schoolid' => $schoolid, ':id' => $id));	
						
		 include $this->template(''.$school['style3'].'/bjq');
          }else{
         include $this->template('bangding');
          }        
?>