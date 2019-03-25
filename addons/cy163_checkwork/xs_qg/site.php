<?php
/**
 * 限时抢购单页模块微站定义
 *
 * @author D&K
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Xs_qgModuleSite extends WeModuleSite {

	public function doMobileIndex() {
		//这个操作被定义用来呈现 功能封面
		global $_GPC, $_W;
		if($_POST){
			$num=$_GPC['goods_num'];
			if ($num) {

			$id = intval($_GPC['id']);
			$list = pdo_fetch('select * from '.tablename('xs_dy').' where id=:id and uniacid=:uniacid ', array('uniacid'=>$_W['uniacid'],'id'=>$id));
			// 一些业务代码。
			if ($list['dtime']<time()) {
					echo "抢购结束。";
					die();
				}
			if ($list['stime']>time()) {
					echo "抢购未开始。";
					die();
				}
			$chargerecord['tid']=$_SESSION['tid'];
			$fee = $list['money']*intval($_GPC['goods_num']);

			if($fee <= 0) {
				message('支付错误, 金额小于0');
			}
			//构造支付请求中的参数
			$params = array(
				'tid' => $chargerecord['tid'],      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
				'ordersn' => $chargerecord['tid'],  //收银台中显示的订单号
				'title' => '商品购买',          //收银台中显示的标题
				'fee' =>$fee ,      //收银台中显示需要支付的金额,只能大于 0
			);

			$log = pdo_get('xs_order', array('uniacid' => $_W['uniacid'], 'tid' => $params['tid']));
			//在pay方法中，要检测是否已经生成了paylog订单记录，如果没有需要插入一条订单数据
			//未调用系统pay方法的，可以将此代码放至自己的pay方法中，进行漏洞修复
			if (empty($log)) {
		        $log = array(
		        		'tid'=>$params['tid'],
		        		'goods_id'=>$id,
		        		'goods_state'=>0,
		        		'goods_num'=>$_GPC['goods_num'],
		        		'name'=>$_GPC['name'],
		        		'tel'=>$_GPC['phone_num'],
		        		'address'=>$_GPC['buyer_address'],
		        		'state'=>0,
		        		'money'=>$fee,
		        		'createtime'=>time(),
		                'uniacid' => $_W['uniacid']
		        );
	        pdo_insert('xs_order', $log);
	    	}
			//调用pay方法
			$this->pay($params);
			die();
			}
		}
		$id = intval($_GPC['id']);
		if ($id) {
			$list = pdo_fetch('select * from '.tablename('xs_dy').' where id=:id and uniacid=:uniacid ', array('uniacid'=>$_W['uniacid'],'id'=>$id));
			if ($list) {
				$_SESSION['tid']=date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
				$images1=explode('-',$list['one']);
				$images2=explode('-',$list['two']);
				$images3=explode('-',$list['three']);

				if ($list['stime']>time()) {
					$start=1;
				}else{
					$start=0;
				}
				include $this->template('index');
			}else{
				echo "查看的页面不存在";
			}	
		}else{
			echo "oh on!";
		}
		
	}
	public function doWebOrder() {
		global $_GPC, $_W;
		checklogin();
		$field = array();
		if ($_GET['state']) {
			if ($_GET['state']==1) {
				$condation = ' and state=:state ';
				$field['state'] = 1;
			}else{
				$condation = ' and state=:state ';
				$field['state'] = 0;
			}
			
		}
		
		if ($_GPC['fahuo']==1) {
			$id=$_GPC['id'];
			$user_data = array(
				'goods_state' => 1,
			);
			$result = pdo_update('xs_order', $user_data, array('id' => $id,'uniacid'=>$_W['uniacid']));
			if (!empty($result)) {
				message('发货成功');
			}
		}
		if ($_GPC['del']==1) {
			$id=$_GPC['id'];
			$result2 = pdo_query("DELETE FROM ".tablename('xs_order')." WHERE id = :id and uniacid=:uniacid", array(':id' => $id,':uniacid'=>$_W['uniacid']));
			if (!empty($result2)) {
				message('删除成功');
			}
		}


		$state=array('未付款','已付款');
		$goods_state=array('未发货','已发货');
		$pindex    = max(1, intval($_GPC['page']));
    	$psize     = 20;
    	$field['uniacid'] = $_W['uniacid'];
    	$sql = "select * from".tablename('xs_order')." where uniacid=:uniacid ".$condation." order by id desc";
    	$sql .= " limit " . ($pindex - 1) * $psize . ',' . $psize;
var_dump($sql);
    	$list = pdo_fetchall($sql,$field);

		$total = pdo_fetchcolumn("select count(*) from".tablename('xs_order')." where  uniacid=:uniacid ".$condation." order by id desc",$field);
	    $pager = pagination($total, $pindex, $psize);
		include $this->template('web/order');
	}
	public function doWebDanye(){
		global $_GPC, $_W;
		checklogin();
		if ($_GPC['del']==1) {
			$id=$_GPC['id'];
			$result = pdo_query("DELETE FROM ".tablename('xs_dy')." WHERE id = :id", array(':id' => $id));
			if (!empty($result)) {
				message('删除成功');
			}
		}

		$pindex    = max(1, intval($_GPC['page']));
    	$psize     = 20;

    	$sql = "select * from".tablename('xs_dy')." where uniacid=:uniacid order by id desc";
    	$sql .= " limit " . ($pindex - 1) * $psize . ',' . $psize;

    	$list = pdo_fetchall($sql, array('uniacid'=>$_W['uniacid']));

		$total = pdo_fetchcolumn("select count(*) from".tablename('xs_dy')." where uniacid=:uniacid order by id desc",array('uniacid'=>$_W['uniacid']));
	    $pager = pagination($total, $pindex, $psize);

		include $this->template('web/index');
	}
	public function doWebDanyeadd() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_GPC, $_W;
		checklogin();

		if ($_POST['title']) {
			$one='';
 			for ($i=0; $i < count($_GPC['one']); $i++) { 
 				$one.=$_GPC['one'][$i].'-';
 			}

 			$two='';
 			for ($i=0; $i < count($_GPC['two']); $i++) { 
 				$two.=$_GPC['two'][$i].'-';
 			}
 			$three='';
 			for ($i=0; $i < count($_GPC['three']); $i++) { 
 				$three.=$_GPC['three'][$i].'-';
 			}
			$user_data = array(
			'title' => $_GPC['title'],
			'one' => $one,
			'two' => $two,
			'three' => $three,
			'shipin' => $_GPC['shipin'],
			'tel' => $_GPC['tel'],
			'money' => intval($_GPC['money']),
			'dtime' => $_GPC['dtime'],
			'createtime' => time(),
			'uniacid' => $_W['uniacid'],
			);
			$result = pdo_insert('xs_dy', $user_data);
			if (!empty($result)) {
				$uid = pdo_insertid();
				message('添加单页成功。');
			}
		}else{
			include $this->template('web/add');
		}
		
	}

	public function payResult($params) {
		    global $_GPC,$_W;

			//一些业务代码
			//根据参数params中的result来判断支付是否成功
			if ($params['result'] == 'success' && $params['from'] == 'return') {
				//此处再次判断用户支付的金额是否与其生成订单的金额相符，二次验证支付安全
				$order = pdo_get('xs_order', array('uniacid' => $_W['uniacid'], 'tid' => $params['tid']));

				if ($params['fee'] != $order['money']) {
					exit('用户支付的金额与订单金额不符合');
				}
				$data = array(
						'state'=>'1' //修改为已付款
					    );
				$result = pdo_update('xs_order', $data, array('tid' => $params['tid'],'uniacid'=>$_W['uniacid']));
				

			}
			if (empty($params['result']) || $params['result'] != 'success') {
				//此处会处理一些支付失败的业务代码
			}
			if ($params['from'] == 'return') {
				if ($params['result'] == 'success') {
					message('支付成功！请关闭页面');
				} else {
					message('支付失败！');
				}
			}
	}
	//修改页面
	public function doWebDanyexg()
	{
		global $_GPC, $_W;
		if ($_POST['title']) {
			$one='';
 			for ($i=0; $i < count($_GPC['one']); $i++) { 
 				$one.=$_GPC['one'][$i].'-';
 			}

 			$two='';
 			for ($i=0; $i < count($_GPC['two']); $i++) { 
 				$two.=$_GPC['two'][$i].'-';
 			}
 			$three='';
 			for ($i=0; $i < count($_GPC['three']); $i++) { 
 				$three.=$_GPC['three'][$i].'-';
 			}
 			$a=strtotime($_GPC['dtime']);
			$user_data = array(
			'title' => $_GPC['title'],
			'one' => $one,
			'two' => $two,
			'three' => $three,
			'shipin' => $_GPC['shipin'],
			'tel' => $_GPC['tel'],
			'money' => intval($_GPC['money']),
			'stime' => strtotime($_GPC['stime']),
			'dtime' => $a,
			'dtimewz' => $_GPC['dtimewz'],
			'createtime' => time(),
			
			);
			$result = pdo_update('xs_dy', $user_data,array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
			if (!empty($result)) {
				$uid = pdo_insertid();
				message('修改单页成功。');
			}
		}else{
		if ($_GPC['xiugai']==1) {
				if ($_GPC['id']) {
					$list = pdo_fetch('select * from '.tablename('xs_dy').' where id=:id and uniacid=:uniacid ', array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
					$one1=explode('-',$list['one']);
					unset($one1[count($one1)-1]);
					$two1=explode('-',$list['two']);
					unset($two1[count($two1)-1]);
					$three1=explode('-',$list['three']);
					unset($three1[count($three1)-1]);

					include $this->template('web/xiugai');
				}
			}
		}
	}

}