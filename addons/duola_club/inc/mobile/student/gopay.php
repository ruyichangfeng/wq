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
		$data = explode ( ',', $_GPC ['str'] );
		$orderid = intval($_GPC['orderid']);
		if (empty($_GPC ['str'])){
			$od1 = $orderid;
		}else{
			$od1 = $data[0];
		}
		
		$school = pdo_fetch("SELECT cardset,title,style2 FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		
		$card = unserialize($school['cardset']);
		
		$kc1 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $od1)); 
		$flag = 1;
		if ($kc1['status'] ==2)	{
			$flag = 2;
		}
		$kecheng = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		
		$teacher = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		
		$cost = pdo_fetchall("SELECT * FROM " . tablename($this->table_cost) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');

		include $this->template(''.$school['style2'].'/gopay');
                
?>