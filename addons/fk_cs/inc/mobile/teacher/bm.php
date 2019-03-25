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
		$signid = $_GPC['id'];
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':sid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $userid['id']));
        $school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		//查询是否是客服
		$category = pdo_fetch("SELECT count(openid) as openidCount FROM " . tablename($this->table_classify) . " WHERE :schoolid = schoolid And :weid = weid And :openid = openid AND :type = type ",array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid,':type' => 'customerService'));
	   if(!empty($userid['id']) || $category['openidCount'] > 0){

			$item = pdo_fetch("SELECT * FROM " . tablename($this->table_signup) . " where :id = id", array(':id' => $signid));
			if(!empty($item['home_location'])){
				$item['home_location'] = json_decode($item['home_location'],true);
			}
//		    $xueqi = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $item['nj_id']));
//			$class = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where sid = :sid ", array(':sid' => $item['bj_id']));
			$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $item['orderid']));
			
//			$bjlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " where schoolid = '{$schoolid}' And weid = '{$weid}' And parentid = '{$item['nj_id']}' And type = 'theclass' ORDER BY ssort ASC");
		   include $this->template(''.$school['style3'].'/bm');
        }else{
			include $this->template('bangding');
        }        
?>