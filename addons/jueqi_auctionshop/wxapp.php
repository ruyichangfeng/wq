<?php
/**
 * 竞拍小程序模块小程序接口定义
 */
defined('IN_IA') or exit('Access Denied');
class jueqi_auctionshopModuleWxapp extends WeModuleWxapp {
	//获取后台填写的url内嵌网址
	public function doPageGetUrl(){
		global $_GPC, $_W;
		$data = pdo_fetch("select * from ".tablename('jueqi_auctionshop_data')." where flag = :flag",array(':flag'=>'xcx'));
		
		$system = pdo_fetch("SELECT data FROM ".tablename('jueqi_auctionshop_data')." WHERE flag='system'", array());
		$system = json_decode($system['data'],true);
		if(!empty($data['data'])){
			$arr = json_decode($data['data'],true);//将json转为数组
			if(strstr($arr['xcx_site'],'&amp;')){
				$arr['xcx_site'] = str_replace('&amp;','&',$arr['xcx_site']);
			}
			$arr['xcx_title'] = $system['m_name'];
			return $this ->result(0,'geturl',$arr);
		}		
		return $this->result(0,'0',$data);
	}
	//支付
	public function doPagePay() {
        global $_GPC, $_W;
        //获取订单号，保证在业务模块中唯一即可
        $orderid = $this->get_Orderid();
		$unionid = $_GPC['unionid'];
		$fee = $_GPC['fee'];
		$mid = $_GPC['mid'];
        //构造支付参数
        $order = array(
            'tid' => $orderid,
            'user' => $unionid,//用户unionid
            'fee' => floatval($fee), //金额
            'title' => '小程序支付示例',
        );
		if($unionid){
			$mid_sql = 'select id from '.tablename('jueqi_auctionshop_member').' where unionid="'.$unionid.'"';
		}else{
			$mid_sql = 'select id from '.tablename('jueqi_auctionshop_member').' where id='.$mid.'';
		}
		
		$mid = pdo_fetch($mid_sql);
		$pay = array(
			'uniacid' => $_W['uniacid'],
			'openid' => $_W['openid'],
			'ordersn' =>$orderid,
			'price' => $_GPC['fee'],
			'mid'=>$mid['id'],
			'payflag'=>'cz',
			'data'=>$_GPC['czjb'],
			'status' => 0,
			'createtime' => time()
		);
		$result = pdo_insert('jueqi_auctionshop_pay', $pay);
		if (!empty($result)) {
			$id = pdo_insertid();
		}
        //生成支付参数，返回给小程序端
        $pay_params = $this->pay($order);
		$pay_params['id'] = $id;
        if (is_error($pay_params)) {
            return $this->result(1, '支付失败，请重试',$pay_params);
        }
        return $this->result(0, '', $pay_params);
    }
	//支付成功
	public function doPagePaysuccess(){
		global $_GPC, $_W;
		$unionid = $_GPC['unionid'];
		$mid = $_GPC['mid'];
		$price = (int)$_GPC['fee'];
		$czjb = (int)$_GPC['czjb'];
		$chuizi = (int)$_GPC['chuizi'];
		$id = $_GPC['id'];//订单ID
		$pay_data['status'] = 1;
		$up_pay = pdo_update('jueqi_auctionshop_pay',$pay_data,array('id'=>$id));//更新订单为成功
		if($unionid){
			$param[':unionid'] = $unionid;		
			$member = pdo_fetch('select * from '.tablename('jueqi_auctionshop_member').' where unionid=:unionid',$param);
		}else{
			$param[':id'] = $mid;		
			$member = pdo_fetch('select * from '.tablename('jueqi_auctionshop_member').' where id=:id',$param);
		}
		$member_data['hammer'] = (int)$member['hammer']+$chuizi;//锤子
		$member_data['currency'] = (int)$member['currency']+$czjb;//虚拟币
		$up_member = pdo_update('jueqi_auctionshop_member',$member_data,array('unionid'=>$unionid));//更新个人虚拟币锤子数量
		if(!empty($up_pay)&&!empty($up_member)){
			return $this->result(0,'支付成功','');
		}
		return $this->result(0,'支付失败','');
	}
	//一口价支付
	public function doPagePayfull(){
		global $_GPC, $_W;
		$price = $_GPC['price'];  
		$type = 1;
		$aid = $_GPC['aid'];
		$gid= $_GPC['gid'];	
		$ordsn = $this->get_Orderid();
		$mid = $_GPC['mid'];
		$flag = $_GPC['flag'];
		if($flag=='pay_order'){
			if( empty($price) || empty($type) || empty($aid) || empty($gid) ){
				$mes = "参数错误！";
				$type = '<span class="mui-msg-error"></span>';
				include $this->template('message'); exit;
			}
			$p_order = array(
				'uid' => $mid,
				'orderno' =>$ordsn,
			    'ordermoney' => $price,
				'type' => $type,
				'goodsid' => $gid,
				'address_id'=>$aid,
				'status' => 0,
				'remark' => $_GPC['remark'],
				'createtime' => time()
			);
			pdo_insert('jueqi_auctionshop_order', $p_order);
			$order_id = pdo_insertid();
			$pay = array(
				'uniacid' => $_W['uniacid'],
				'openid' => $_W['openid'],
				'ordersn' =>$ordsn,
				'price' => $price,
				'mid'=>$mid,  
				'payflag'=>'goods',
				'data'=>$gid,
				'status' => 0,
				'createtime' => time()
			);
			pdo_insert('jueqi_auctionshop_pay', $pay);
			$pay_id = pdo_insertid();
			return $this->result(0,'生成订单成功',array('order_id'=>$order_id,'pay_id'=>$pay_id));
		}elseif($flag=='pay_success'){
			$orderno = $_GPC['orderno'];
			$data['status'] = 1;
			if(!empty($orderno)){
				pdo_update('jueqi_auctionshop_order',$data,array('orderno'=>$orderno));
				pdo_update('jueqi_auctionshop_pay',$data,array('ordersn'=>$orderno));
			}else{
				$order_id = $_GPC['order_id'];
				$pay_id = $_GPC['pay_id'];				
				pdo_update('jueqi_auctionshop_order',$data,array('id'=>$order_id));
				pdo_update('jueqi_auctionshop_pay',$data,array('id'=>$pay_id));
			}		
			
			//消息通知
			if(!empty($orderno)){
				$where[':ordersn'] = $orderno;	
				$pay = pdo_fetch('select p.mid,p.price,p.createtime,g.title from '.tablename('jueqi_auctionshop_pay').' p LEFT JOIN '.tablename('jueqi_auctionshop_goods').' g ON p.data=g.id where p.ordersn=:ordersn',$where);
			}else{
				$where[':id'] = $pay_id;	
				$pay = pdo_fetch('select p.mid,p.price,p.createtime,g.title from '.tablename('jueqi_auctionshop_pay').' p LEFT JOIN '.tablename('jueqi_auctionshop_goods').' g ON p.data=g.id where p.id=:id',$where);
			}
			$n_data['userid'] = $pay['mid'];
			$n_data['ncontent']= 9;
			$n_data['by1'] = $pay['title'];
			$n_data['by2'] = $pay['price'];
			$n_data['by3'] = '';
			$n_data['createtime'] = $pay['createtime'];
			pdo_insert('jueqi_auctionshop_notice',$n_data);
		}
	}
	//检查订单号
	public function doPageCheckorderno(){
		global $_GPC ,$_W;
		$orderno = $_GPC['orderno'];
		$where[':orderno'] = $orderno;
		$order = pdo_fetch('select * from '.tablename('jueqi_auctionshop_order').' where orderno=:orderno',$where);
		if(!empty($order)){
			return $this->result(0,'查询成功',$order);
		}
	}
	//获取用户信息
	public function doPageGetuserinfo()
    {
		global $_GPC ,$_W;
        $avatarUrl = $_GPC["avatarUrl"];//头像图片地址
        $gender = $_GPC["gender"];//性别 0：未知、1：男、2：女
        $nickName = $_GPC["nickName"];//微信名
        $userinfo = array(
			'unionid' => $_W['fans']['unionid'],
			'avatar' => $avatarUrl,
			'sex' => $gender,
			'nickname' => $nickName,
		);
		$sql = 'SELECT COUNT(*) FROM '.tablename('jueqi_auctionshop_member').' WHERE unionid=:unionid';
		$param[':unionid'] = $_W['fans']['unionid'];
		$result = pdo_fetchcolumn($sql,$param);
		if($result==0) {
           pdo_insert('jueqi_auctionshop_member',$userinfo);
		}
        if($userinfo)
        {
            $userData = array("code"=>1 ,"msg"=>"获取用户信息成功","unionid"=>$_W['fans']['unionid'],"openid"=>$_W['openid']);
            $this->result(0, '登录成功', $userData);
        }else{
            $userData = array("code"=>0 ,"msg"=>"获取用户信息失败");
            $this->result(0, '登录失败', $userData);
        }
    }
	//获取订单号
	private function get_Orderid(){
		$ordsn = date('md') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
		return $ordsn;
	}
}