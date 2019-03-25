<?php
global $_W, $_GPC;
session_start();

$this->checkreg();

$openid = $_W['fans']['from_user'];
if (empty($_W['fans']['follow'])){
	header('Location:'.$this->getBase('lead'));
	exit();
}

$foo = $_GPC['foo'];
$foos = array('index', 'ok', 'submitok');
$foo = in_array($foo, $foos) ? $foo : 'ok';

if($foo == 'index'){
	load()->model('mc');
	$members = mc_fetch($_W['member']['uid'], array('realname', 'mobile', 'gender', 'resideprovince','residecity','residedist'));

	$authen = $this->getBase('authen');
	if($authen == 1 && $members['mobile'] == ''){	
		$timeout = $this->getBase('timeout')*60;
		include $this->template($this->temp.'_authmobile');
		exit();
	}
		
	$examine = $this->getBase('examine');
	if($examine == 1){
		$getCheck = $this->checkexamine($openid);
		if($getCheck == 0){
			$page = 'index';
			include $this->template($this->temp.'_examineinfo');
			exit();
		}
	}
		
	$id 	  = intval($_GPC['id']);
	$staff_id = intval($_GPC['staff_id']);

	$item_a = pdo_get('xm_gohome_adrstr', array('weid'=>$_W['uniacid']), array('adrstr'));
	$adrstr = substr($item_a['adrstr'], 0, 3);
	if(empty($adrstr)){
		$arr = pdo_fetchall("select openid,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and find_in_set(".$id.",serve_type) and delstate=1 and openid != ''");
	}else{
		$arr = pdo_fetchall("select openid,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and find_in_set(".$id.",serve_type) and delstate=1 and openid != '' and adrstr like '".$adrstr."%'");
	}
	$total = count($arr);
	
	$data = pdo_fetch("select id,type_name,chao,link,temp_id,remark,price,price_unit,unit,front,diytime,diymobile,diyname,diypic,diyaddress from ".tablename('xm_gohome_servetype')." where id=".$id." and delstate=1");
	if($data['chao'] == 1){
		header("Location:".$data['link']);	
		exit();
	}

	if(empty($data['temp_id'])){
		message('该模型不存在！', $this->createMobileUrl('Index',array()), 'error');
		exit();
	}

	$item = pdo_fetch("select temp_token,bgcolor,bgimage,html from ".tablename('xm_gohome_temp')." where delstate=1 and id =".$data['temp_id']);
	if(empty($item['html'])){
		message('该服务项目下暂无模型，请联系管理员添加模型！',$this->createMobileUrl('Index',array()), 'error');
		exit();
	}
	
	$nowtime = date('Y-m-d H:i:s', time());
	$random  = $this->generate_code(8);
	$_SESSION['serve_type'] = $id; 
	$_SESSION['staff_id']   = $staff_id; 
	$_SESSION['temp_id']    = $data['temp_id'];
	$title     = $this->title;
	$type_name = $data['type_name'];
	
	$front	   = $data['front'];
	$frontdiv  = '';
	if($front > 0){
		$frontdiv = '<div class="ub-f1 uinn31 ulev-2 c-org t-wh tx-c">此单需预付款'.$front.'元</div>';
	}
	
	$residecity = '';
	$residedist = '';
	$o_item = pdo_fetch("select lat,lng,address,lou from ".tablename('xm_gohome_order')." where weid=".$this->weid." and openid='".$openid."' order by id desc limit 0,1");
	$m_lat 	 = $o_item['lat'];
	$m_lng 	 = $o_item['lng'];
	$address = $o_item['address'];
	$lou     = $o_item['lou'];
	
	if($members['gender'] == 1){
		$sexchecked_a = 'checked';
		$sexchecked_b = '';
	}else{
		$sexchecked_a = '';
		$sexchecked_b = 'checked';
	}
	if($data['price'] == 0){
		$mark    = "市场价:面议";
	}else{
		$mark    = "市场价:".$data['price'].'/'.$data['unit'];	
	}
	if($data['price_unit'] == 0){
		$sale    = "优惠价:面议";
	}else{
		$sale    = "优惠价:".$data['price_unit'].'/'.$data['unit'];	
	}
	$price = $mark.'&nbsp;&nbsp;&nbsp;&nbsp;'.$sale;
	$remark  = $data['remark'];
	$bgcolor = $item['bgcolor'];
	$bgimage = $_W['attachurl'].$item['bgimage'];
	$random = $this->generate_code(8);
	if(empty($data['diytime'])){
		$diytime = '服务时间';
	}else{
		$diytime = $data['diytime'];
	}
	if(empty($data['diymobile'])){
		$diymobile = '联系电话';
	}else{
		$diymobile = $data['diymobile'];
	}
	if(empty($data['diyname'])){
		$diyname = '您的称呼';
	}else{
		$diyname = $data['diyname'];
	}
	if(empty($data['diypic'])){
		$diypic = '上传图片';
	}else{
		$diypic = $data['diypic'];
	}
	if(empty($data['diyaddress'])){
		$diyaddress = '详细地址';
	}else{
		$diyaddress = $data['diyaddress'];
	}
	$ak = $this->getBase('ak');
	$qq_ak = $this->getBase('qq_ak');

	$item_b = pdo_fetch("SELECT lng,lat FROM ".tablename('xm_gohome_base')." WHERE weid=".$this->weid);
	$lng = $item_b['lng'];
	$lat = $item_b['lat'];
	$picurl = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=UploadPic&m=xm_gohome";
	$delpic = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=DeletePic&m=xm_gohome";
				 
	$html = str_replace("{title}", $title, base64_decode($item['html']));
	$html = str_replace("{jsconfig}", json_encode($_W['account']['jssdkconfig']), $html);
	$html = str_replace("{baidumapak}", $ak, $html); 
	$html = str_replace("{qqmapak}", $qq_ak, $html); 
	$html = str_replace("{front}", $frontdiv, $html);
	$html = str_replace("{servicename}", $type_name, $html);
	$html = str_replace("{sernum}", $total, $html);
	$html = str_replace("{servicename_s}", '', $html);
	$html = str_replace("{MODULE_URL}", MODULE_URL, $html);
	$html = str_replace("{attachurl}", $_W["attachurl"], $html);
	$html = str_replace("{price}", $price, $html);
	$html = str_replace("{xm_price_a}", $data['price'], $html);
	$html = str_replace("{xm_price_b}", $data['price_unit'], $html);
	$html = str_replace("{bkcolor}", $bgcolor, $html);
	$html = str_replace("{bkpic}", $bgimage, $html);
	$html = str_replace("{pr_mark}", $remark, $html);
	$html = str_replace("{token}", $_W['token'], $html);
	$html = str_replace("{lat}", $lat, $html);
	$html = str_replace("{lng}", $lng, $html);

	$html = str_replace("{address}", $address, $html);
	$html = str_replace("{lou}", $lou, $html);
	$html = str_replace("{mlat}", $m_lat, $html);
	$html = str_replace("{mlng}", $m_lng, $html);

	$html = str_replace("{datetime}", $nowtime, $html);
	$html = str_replace("{mobile}", $members['mobile'], $html);
	$html = str_replace("{realname}", $members['realname'], $html);
	$html = str_replace("{sexchecked_a}", $sexchecked_a, $html);
	$html = str_replace("{sexchecked_b}", $sexchecked_b, $html);
	$html = str_replace("{random}", $random, $html);
	$html = str_replace("{picurl}", $picurl, $html);
	$html = str_replace("{delpic}", $delpic, $html);
	$html = str_replace("{diytime}", $diytime, $html);
	$html = str_replace("{diymobile}", $diymobile, $html);
	$html = str_replace("{diyname}", $diyname, $html);
	$html = str_replace("{diypic}", $diypic, $html);
	$html = str_replace("{diyaddress}", $diyaddress, $html);

	$page = 'index';
	
	include $this->template($this->temp.'_temppage');	
}

if($foo == 'ok') {
	$getState = $this->getBlackState($openid);
	if($getState == 1){
		message('对不起，您已被系统限制提交订单！');
		exit();
	}
		
	$serve_type = intval($_SESSION['serve_type']);  //服务项目ID
	$staff_id   = intval($_SESSION['staff_id']);    //服务人员ID【发现】
	$temp_id    = intval($_SESSION['temp_id']);     //关联模板ID

	$item = pdo_fetch("select temp_token,getadr from ".tablename('xm_gohome_temp')." where delstate=1 and id =".$temp_id);
	$table_name = 'xm_gohome_'.$item['temp_token'];
	$lat = $_GPC['lat']; 
	$lng = $_GPC['lng']; 
	
	if(empty($_GPC['fname'])){
		message('联系人不能为空！');
	}
	if(empty($_GPC['ftime'])){
		message('服务时间不能为空！');
	}
	if(empty($_GPC['fmobile'])){
		message('电话不能为空！');
	}
	if($item['getadr'] == 1){
		if(empty($_GPC['fadr'])){
			message('请输入服务地址！');
		}	
	}
		
	$random = $_GPC['random'];
	$check  = pdo_fetch("SELECT id FROM ".tablename($table_name)." WHERE weid=".$this->weid." AND random =".$random);
	if(empty($check['id'])){
		$ftime = str_replace('T',' ',$_GPC['ftime']);
		$data_i['weid'] 	   = $this->weid;
		$data_i['openid'] 	   = $openid;
		$data_i['serve_type']  = $serve_type;
		$data_i['ftime']       = $ftime;
		$data_i['fname']       = $_GPC['fname'];
		$data_i['fmobile']     = $_GPC['fmobile'];
				
		$item_i = pdo_fetchall("select input_type,input_name,input_laber from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id=".$temp_id." order by top asc");
		foreach($item_i as $value_i){
			if($value_i['input_type'] == 'checkbox'){
				$checkbox = $_GPC[''.$value_i['input_name'].''];
				$data_i[''.$value_i['input_name'].''] = implode(",", $checkbox);
			}
			if($value_i['input_type'] != 'checkbox'){
				$data_i[''.$value_i['input_name'].''] = $_GPC[''.$value_i['input_name'].''];
			}
		}
		$data_i['flag'] = 1;
		$data_i['dealprice'] = $_GPC['spice'];
		$data_i['fperson'] = 1;
		$data_i['random'] = $random;
		if($item['getadr'] == 1){
			$data_i['fadr'] = $_GPC['fadr'].$_GPC['flou'];	
		}
				
		$result = pdo_insert($table_name, $data_i);
		$newId = pdo_insertid();
		if($result>0){
			load()->model('mc');
			$members = mc_fetch($_W['member']['uid'], array('realname', 'mobile','residecity','residedist'));
			if(empty($members['realname'])||empty($members['mobile'])){
				$datafans = array(
					'realname' => $_GPC['fname'],	
					'mobile' => $_GPC['fmobile'],
					'residecity' => $_GPC['fadr'],
					'residedist' => $_GPC['flou'],
				);
				mc_update($_W['member']['uid'], $datafans);
			}
					
			$other_id = $newId;
			$adrstr = $this->encode_geohash($_GPC['lat'],$_GPC['lng'],12);
			$_SESSION['adrstr'] = $adrstr; 
					
			$f_item = pdo_fetch("select front,fanwei,mode,temp_msg,send_sms,mode_openid,mode_mobile,payway from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$serve_type);
			//写数据到总订单表
			$ordernumber = $this->createServeOrder();

			$data_o['weid'] 	   = $this->weid;
			$data_o['openid'] 	   = $openid;
			$data_o['ordernumber'] = $ordernumber;
			$data_o['serve_type']  = $serve_type;
			$data_o['front']  	   = $this->getServeInfo($serve_type, 'front');
			$data_o['table_name']  = $table_name;
			$data_o['other_id']    = $other_id;
			$data_o['temp_id'] 	   = $temp_id;
			$data_o['lat'] 		   = $lat;
			$data_o['lng'] 		   = $lng;
			$data_o['address'] 	   = $_GPC['fadr'];
			$data_o['lou']         = $_GPC['flou'];
			$data_o['mode'] 	   = $f_item['mode'] ;
			$data_o['flag']        = 0;
			$data_o['fname']       = $_GPC['fname'];
			$data_o['fmobile']     = $_GPC['fmobile'];
			pdo_insert('xm_gohome_order',$data_o);
			$order_id = pdo_insertid();
					
			if($f_item['front'] >0 && $f_item['payway']==0){	
				$fee = floatval($f_item['front']);
				if($fee <= 0) {
					message('支付错误, 金额小于0');
				}
						
				$params = array(
					'tid' => 'E#'.$openid.'#'.$fee.'#'.$order_id.'#'.$staff_id.'#'.$this->generate_code(5),
					'ordersn' => $this->generate_code(8), 
					'title' => '服务项目预付款',    
					'fee' => $fee,     
					'user' => $_W['member']['uid'],  
				);
				$this->pay($params);
			}else{
				$data_u['flag'] = 1;
				pdo_update('xm_gohome_order', $data_u, array('id'=>$order_id));
				$res = $this->createok($order_id,$serve_type,$other_id,$staff_id);
				
				header("Location:".$this->createMobileUrl('templateok', array('foo'=>'submitok', 'order_id'=>$order_id,'staff_id'=>$staff_id)));
			}
		}else{
			message('提交订单错误');
		}	
	}else{
		message('该订单已提交，不能重复提交');
	}	
}

if($foo == 'submitok'){
	$weid 	  = $this->weid;
	$order_id = intval($_GPC['order_id']);
	$staff_id = intval($_GPC['staff_id']);
	$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);

	$glist = pdo_fetchall("select * from ".tablename('xm_gohome_gg')." where weid=".$this->weid." and stop=1 and gg_adr='yuyue' order by top asc");
	
	$page     = 'index';

	include $this->template($this->temp.'_submitok');
}

?>