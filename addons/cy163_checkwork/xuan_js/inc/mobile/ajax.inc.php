<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$op=!empty($_GPC['op'])?$_GPC['op']:'index';
$uidopenid=m('member')->get_uidopenid();
/*if (!$_W['isajax']) {
	exit;
}*/
if ($op=="index") {
	echo "Access Denied";exit;
}else if ($op=="fabu") {
	/*********发布ajax************/
	
	$data['uid']=$uidopenid['uid'];
	$data['title']=$_GPC['title'];
	$data['amount']=$_GPC['amount'];
	$data['shengyu']=$_GPC['amount'];
	$data['college']=$_GPC['college'];
	$data['grade']=$_GPC['grade'];
	$data['description']=$_GPC['description'];
	$data['type']=$_GPC['type'];
	$data['price']=$_GPC['price']; 
	$data['sprice']=$_GPC['sprice'];
	$data['fengmian']=$_GPC['fengmian'];
	$data['img']=$_GPC['img'];
	$data['oprice']=$_GPC['oprice'];
	$data['face']=$_GPC['face'];
	$data['kuaidi']=$_GPC['kuaidi'];
	$data['kuaidifee']=$_GPC['kuaidifee'];
	$data['onlinepay']=$_GPC['onlinepay'];
	$data['offlinepay']=$_GPC['offlinepay'];
	$data['weixin']=$_GPC['weixin'];
	$data['fenlei1']=$_GPC['dafen'];//一级分类
	$data['fenlei2']=$_GPC['fenlei'];//二级分类
	$data['phone']=$_GPC['phone'];
	$data['createtime']=time();
	$data['openid']=$uidopenid['openid'];
	$data['uniacid']=$_W['uniacid'];
	$in_id = pdo_insert('xuan_js_fabu',$data);
	if ($in_id) {
		echo json_encode(array('code'=>1,'msg'=>"发布成功等待审核"));exit;
	}else{
		echo json_encode(array('code'=>-1,'msg'=>"发布失败请重试"));exit;
	}
}elseif ($op=="getlist") {
	//消息获取ajax 
	if ($_GPC['hot']==2) {
		$order="view";
	}else{
		$order="id";
	}
	$page=isset($_GPC['page'])?intval($_GPC['page']):1; ;
	$num="10";
	$start=($page-1)*$num;

	$limit = "limit ".$start.",".$num;

	if ($_GPC['fenlei']=="1") {
		/******加载各分类 最新最热******/
		$list=m('fabu')->getlist(array('fenlei2'=>$_GPC['id'],'order'=>$order,'orderby'=>'desc','limit'=>$limit));
		echo json_encode(array('code' =>1 ,'msg'=>$list ));exit;
	}
	$list=m('fabu')->getlist(array('order'=>$order,'orderby'=>'desc','limit'=>$limit));

	echo json_encode(array('code' =>1 ,'msg'=>$list ));exit;
}elseif ($op=="zan") {
	$goods_id=$_GPC['id'];
	if ($goods_id) {
		if (m('member')->getzan($uidopenid['uid'],$goods_id)) {
			return;
		}
        $img=m('member')->getinfo($uidopenid['uid'],'avatar');
		$user_data = array(
		    'fid' => $goods_id,
		    'img' => $img['avatar'],
		    'uid' => $uidopenid['uid'],
		    'createtime'=>time(),
		);
		$result = pdo_insert('xuan_js_zan', $user_data);
	}
}elseif ($op=="pinglun") {
	$goods_id=$_GPC['id'];
	if ($goods_id) {
        $img=m('member')->getinfo($uidopenid['uid'],'avatar,nickname');
		$user_data = array(
		    'fid' => $goods_id,
		    'img' => $img['avatar'],
		    'nickname' => $img['nickname'],
		    'uid' => $uidopenid['uid'],
		    'content'=>$_GPC['content'],
		    'createtime'=>time(),
		);
		$result = pdo_insert('xuan_js_pinglun', $user_data);
		echo json_encode(array('code' =>1));exit;
	}
	//失败返回
	echo json_encode(array('code' =>1));exit;
}elseif ($op=="order") {
	if ($uidopenid['uid']) {
		//获取商品
		$goods=m('goods')->getone($_GPC['id']);
		if ($goods['shengyu']!=-1) {
			if ($goods['shengyu']==0) {
				die();
			}
			/*******减少商品数量********/
			$shengyu=$goods['shengyu']-1;
	 		pdo_update('xuan_js_fabu', array('shengyu'=>$shengyu), array('id' => $goods['id'],'uniacid'=>$_W['uniacid']));
		}
		//订单状态 
		$status=0;
		$money=$goods['price'];
		//快递费用
		$kuaidifee = 0;

		$tid=$uidopenid['uid'].time();
		if ($_GPC['offlinepay']==1) {
			$status="COMPLETE";//完成 免费送订单直接完成
		}
		/******价格计算********/
		if ($_GPC['kuaidi']) {
			//计算价格
			$kuaidifee =$goods['kuaidifee'];
			$money=$goods['price']+$goods['kuaidifee'];
		}elseif ($_GPC['face']){
			//当面交易
			$money=$goods['price'];
		}
		$user_data = array(
		    'zhifu'=>'0',
		    'uid' => $uidopenid['uid'],
		    'buid' => $goods['uid'],
		    'tid'=>$tid,
		    'kuaidi'=>$_GPC['kuaidi'],
		    'face'=>$_GPC['face'],
		    'money'=>$money,
		    'weixin'=>$_GPC['weixin'],
		    'kuaidifee'=>$kuaidifee,
		    'wxpay'=>$_GPC['wxpay'],
		    'offlinepay'=>$_GPC['offlinepay'],
		    'fid'=>$_GPC['id'],
		    'status'=>$status,//0未付款
		    'name'=>$_GPC['name'],
		    'phone'=>$_GPC['phone'],
		    'address'=>$_GPC['address'],
		    'liuyan'=>$_GPC['liuyan'],
		    'createtime'=>time(),
		    'uniacid'=>$_W['uniacid']
		);
		$result = pdo_insert('xuan_js_order', $user_data);
		if ($status==0) {
			//转跳支付页面
			echo json_encode(array('code' =>2,'msg'=>$tid));exit;
		}else{
			//转跳完成页面
			echo json_encode(array('code' =>1,'msg'=>$tid));exit;
		}
		
	}
	
}elseif ($op=="pay") {
	$sql = "SELECT * FROM " . tablename('xuan_js_order') . " where tid=:tid and uniacid=:uniacid";
    $order = pdo_fetch($sql, array('tid'=>$_GPC['tid'],'uniacid'=>$_W['uniacid']));
    echo json_encode(array('fee' =>$order['money'],'ordertid'=>$order['tid']));exit;
}elseif ($op=="goodsstatus") {
	$id=$_GPC['id'];
	$status=$_GPC['status']; 
	$data = array(
                'status'=>$status//修改为已付款
            );
    pdo_update('xuan_js_fabu', $data, array('id' => $id,'uniacid'=>$_W['uniacid'],'uid'=>$uidopenid['uid']));
}elseif ($op=="shoucang") {
	$goods_id=$_GPC['id'];
	$shoucang = pdo_fetch("SELECT id FROM ".tablename('xuan_js_shoucang')." WHERE fid = :fid and uid=:uid", array(':fid' => $goods_id,':uid'=>$uidopenid['uid']));
	
	if ($goods_id) {
        if ($shoucang) {
			pdo_delete('xuan_js_shoucang', array('fid' => $goods_id,'uid'=>$uidopenid['uid']));
		}else{
			$user_data = array(
		    'fid' => $goods_id,
		    'uid' => $uidopenid['uid'],
		    'createtime'=>time(),
			);
			$result = pdo_insert('xuan_js_shoucang', $user_data);
		}
		
	}
}elseif ($op=="cancelorder") {
	 /*******取消订单要检查是否付费*******/
	 $order=pdo_fetch("SELECT * FROM ".tablename('xuan_js_order')." where id=:id and uniacid=:uniacid", array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));
	 if($order['zhifu']==1){
	 	//返还用户金额
	 	load()->model('mc');
	 	mc_credit_update($order['uid'], 'credit2', $order['money'], array(0, '取消订单返还金额'));
	 }

	 /***********数量不是-1要增加商品剩余+1**********/
	 $good = m('goods')->getone($order['fid']);
	 if($good['shengyu']!=-1){
	 	$shengyu=$good['shengyu']+1;
	 	pdo_update('xuan_js_fabu', array('shengyu'=>$shengyu), array('id' => $order['fid'],'uniacid'=>$_W['uniacid']));
	 }
	 $data2 = array(
               'status'=>'-1'//修改为取消
             );
	 	/*********发送提醒**********/
        $data  = array(
                        "first"=>array( "value"=> '您的订单取消了！'),
                        "orderProductPrice"=>array('value' => $order['money']),
                        "orderProductName"=>array('value' => $good['title']),
                        "orderAddress"=>array('value' => $order['address']),
                        "orderName"=>array('value' => $order['tid']),
                        "remark"=>array('value' => '点击查看详情,订单金额已退款'),
                );
        $user=pdo_fetch('select openid,uid from '.tablename('mc_mapping_fans').' where uid='.$order['uid']);
		$user2=pdo_fetch('select openid,uid from '.tablename('mc_mapping_fans').' where uid='.$order['buid']);

        $this->sendtixing($user['openid'],'cancelorder',$data,$this->createMobileUrl('person',array('op'=>'buyorder')));
        $this->sendtixing($user2['openid'],'cancelorder',$data,$this->createMobileUrl('person',array('op'=>'outorder')));
		/*********发送结束**********/

      pdo_update('xuan_js_order', $data2, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
}elseif($op=="fahuo"){
	  $order=pdo_fetch('select * from '.tablename('xuan_js_order').' where id=:id and uniacid=:uniacid',array(':id'=>$_GPC['id'],':uniacid'=>$_W['uniacid']));
	  if ($order['status']=='PAYED') {
	  	$data = array(
               'status'=>'FAHUO',
               'kuaidiname'=>$_GPC['kuaidiname'],
               'danhao'=>$_GPC['danhao']

             );
        pdo_update('xuan_js_order', $data, array('id' => $_GPC['id'],'buid'=>$uidopenid['uid'],'uniacid'=>$_W['uniacid']));
        /*********发送提醒**********/
        $data  = array(
                        "first"=>array( "value"=> '您的订单发货了！'),
                        "keyword1"=>array('value' => $_GPC['kuaidiname']),
                        "keyword2"=>array('value' => $_GPC['danhao']),
                        "keyword3"=>array('value' => $order['name']),
                        "keyword4"=>array('value' => $order['phone']),
                        "keyword5"=>array('value' => $order['address']),
                        "remark"=>array('value' => "如航班有延误，请及时联系塔台。"),
                );
        $user=pdo_fetch('select openid,uid from '.tablename('mc_mapping_fans').' where uid='.$order['uid']);

        $this->sendtixing($user['openid'],'fahuo',$data,$this->createMobileUrl('person',array('op'=>'buyorder')));
		/*********发送结束**********/
	  }
	  
}elseif ($op=="shouhuo") {

	$id=$_GPC['id'];
	$order=pdo_fetch('select * from '.tablename('xuan_js_order').' where id=:id and uniacid=:uniacid',array(':id'=>$_GPC['id'],':uniacid'=>$_W['uniacid']));
	if ($order['status']!='COMPLETE') {
		$data = array(
               'status'=>'COMPLETE'
             );
     	pdo_update('xuan_js_order', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
     	mc_credit_update($order['buid'], 'credit2', $order['money'], array(0, '确认收货金额'));
	}
	


}elseif($op=="weixin"){
	$media_ids=$_GPC['serverId'];
	if ($media_ids) {
		$acc = WeAccount::create($_W['acid']);
	    $file=$acc->downloadMedia(array('type'=>'image','media_id'=>$media_ids));
	    echo $file;
	}
	
}elseif ($op=='jubao') {
	$user=m('member')->getinfo($uidopenid['uid'],'avatar,nickname');

	$data=array(
			'from_user_id'=>$uidopenid['uid'],
			'avatar'=>$user['avatar'],
			'nickname'=>$user['nickname'],
			'reason'=>$_GPC['reason'],
			'otherreason'=>$_GPC['otherreason'],
			'createtime'=>time(),
			'uniacid'=>$_W['uniacid'],
			'goodsid'=>$_GPC['id'],
			'status'=>0   //未处理
		);
	pdo_insert('xuan_js_jubao',$data);
}elseif ($op=="tixian") {
	$user=m('member')->getinfo($uidopenid['uid'],'avatar,nickname');
	$huiyuan=mc_fetch($uidopenid['uid']);
	if ($huiyuan['credit2']<1) {
		return 0;
	}
	$data=array(
			'uid'=>$uidopenid['uid'],
			'avatar'=>$user['avatar'],
			'nickname'=>$user['nickname'],
			'money'=>$huiyuan['credit2'],
			'createtime'=>time(),
			'uniacid'=>$_W['uniacid'],
			'status'=>0   //未处理
		);
	load()->model('mc');
	
	$a=mc_credit_update($uidopenid['uid'], 'credit2', '-'.$huiyuan['credit2'], array(0, '集市模块提现扣除'));
	if ($a) {
		pdo_insert('xuan_js_tixian',$data);
		//var_dump(pdo_insert('xuan_js_tixian',$data));
	}
	
	
}