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
		$s_name = trim($_GPC['s_name']);
		if (empty($_GPC ['str'])){
			$od1 = $orderid;
		}else{
			$od1 = $data[0];
		}
		
		$school = pdo_fetch("SELECT cardset,title,style2 FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $schoolid));
		
		if ($od1){
		$card = unserialize($school['cardset']);
		
		$kc1 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND id=:id ", array(':weid' => $weid, ':id' => $od1)); 
		$flag = 1;
		if ($kc1['status'] ==2)	{
			$flag = 2;
		}
		
		$kecheng = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		
		$teacher = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		
		$cost = pdo_fetchall("SELECT * FROM " . tablename($this->table_cost) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		
		$uniacid = !empty($kc1['payweid']) ? $kc1['payweid'] : $weid ;
		$setting = uni_setting($uniacid, 'payment');
		if (!empty($setting['payment']['credit']['switch'])) {
			$credtis = mc_credit_fetch($_W['member']['uid']);
		}		
		$temp = array(
		   'weid' => $weid,
           'schoolid' => $schoolid,	   
		   'od1' => $od1,
		   'payweid' => $kc1['payweid'],
		   'cose' => $kc1['cose'],
		   'openid' => empty($s_name) ? $_SESSION['user'] : $s_name,
		   'status'=>1
		);
		pdo_insert($this->table_wxpay, $temp);
		$wxpay_id = pdo_insertid();	
        $params = array(
            'tid' => $wxpay_id,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
            'ordersn' => time(),  //收银台中显示的订单号
            'title' => '在线缴费',          //收银台中显示的标题
            'fee' => $kc1['cose'],
			'module' => $this->module['name'],
            //'user' => $_W['member']['uid'],     //付款用户, 付款的用户名(选填项)
        );			
		$log = pdo_get('core_paylog', array('uniacid' => $uniacid, 'module' => $params['module'], 'tid' => $params['tid']));
		if (empty($log)) {
			$log = array(
					'uniacid' => $uniacid,
					'acid' => $uniacid,
					'openid' => $_W['member']['uid'],
					'module' => $this->module['name'], 
					'tid' => $params['tid'],
					'fee' => $params['fee'],
					'card_fee' => $params['fee'],
					'status' => '0',
					'is_usecard' => '0',
			);
			pdo_insert('core_paylog', $log);
		}
		
			include $this->template(''.$school['style2'].'/gopay');
		}else{
			include $this->template('common/404');
		}
                
?>