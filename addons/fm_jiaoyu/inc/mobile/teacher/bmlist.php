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
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));	
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));  
        if(!empty($userid['id'])){
		    $leave = pdo_fetchall("SELECT a.sid,a.sname,b.* FROM " . tablename($this->table_classify) . " as a LEFT JOIN". tablename($this->table_signup). " as b ON a.sid = b.nj_id where a.weid = :weid And a.tid = :tid And a.type = :type AND b.schoolid = :schoolid ORDER BY b.createtime DESC, b.status ASC ", array(
						':weid' => $_W ['uniacid'], 
						':tid' => $it['tid'],
						':type' => 'semester',
						':schoolid' => $schoolid,
						));
			foreach ($leave as $index => $row) {
				$member = pdo_fetch("SELECT avatar FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid And uid = :uid ", array(':uniacid' => $_W ['uniacid'], ':uid' => $row['uid']));
				$leave[$index]['avatar'] = empty($row['icon']) ? $member['avatar'] : $row['icon'];
			}
				 	
			include $this->template(''.$school['style3'].'/bmlist');
        }else{
			include $this->template('bangding');
        }        
?>