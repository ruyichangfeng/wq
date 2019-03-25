<?php 
	global $_W,$_GPC;
	$GPC = Util::trimWithArray($_GPC);
	if(!$_W['isajax']) die;
	
	//改变分类
	if($_GPC['op'] == 'changesort'){
		$res = WebCommon::insertGoodSort($_GPC['params'],$_GPC['id'],'edit'); //这里不用删除缓存，因为商品的分类没有缓存
		if($res) die('1'); die('2');
	
	//custom页面搜索
	}elseif($_GPC['op'] == 'customsearch'){
	
		if($_GPC['type'] == 'good'){
			$where['status'] = 0;
			$where['isdust'] = 0;
			$where['stock>'] = 0.1;
			if(!empty($_GPC['kw'])) $where['title@'] = htmlspecialchars($_GPC['kw']);
			
			$data = model_good::getAllGood($where,intval($_GPC['page']),10,'`order` DESC','id,title,pic,nowprice,oldprice,groupprice,groupnum');
			$list = $data[0];
			foreach((array)$list as $k=>$v){
				$list[$k]['thumpic'] = tomedia($v['pic'][0]);
				$list[$k]['url'] = $_W['siteroot'] . 'app/' . 'index.php?i='.$_W['uniacid'].'&c=entry&id='.$v['id'].'&do=good&m=zofui_groupshop';
				
				if($this->module['config']['shoptype'] == 2){
					$list[$k]['realprice'] = $v['nowprice'];
				}else{
					$list[$k]['realprice'] = $v['groupprice'];
				}				
				
			}
		}
		
		if($_GPC['type'] == 'card'){ //卡券
			$where['status'] = 0;
			$where['lastnum>'] = 0.1;
			$where['endtime>'] = time();
			$where['cardtype<'] = 2; //卡券类型
			
			$info = Util::getAllDataInSingleTable('zofui_groupshop_card',$where,$_GPC['page'],10,' `id` DESC ',false);
			$list = $info[0];
		}
		if($_GPC['type'] == 'page'){ //页面
			
			$where['uniacid'] = $_W['uniacid'];
			$data = Util::getAllDataInSingleTable('zofui_groupshop_custom',$where,$_GPC['page'],10,' `id` DESC ',false,' id,pagename ');
			$list = $data[0];
			foreach($list as $k=>$v){
				$list[$k]['url'] = $_W['siteroot'] . 'app/' . 'index.php?i='.$_W['uniacid'].'&c=entry&id='.$v['id'].'&do=index&m=zofui_groupshop';
			}
		}

		if($_GPC['type'] == 'sort'){ //分类
			
			$sortdata = model_sort::getAllSort();
			$list = $sortdata[0];

			foreach((array)$list as $k=>$v){
				if( $v['class'] == 1 ){
					unset( $list[$k] );
					continue;
				}
				$list[$k]['url'] = Util::createModuleUrl('sort',array('op'=>'detail','sortid'=>$v['id']));
			}
		}		

		$data['list'] = $list;
		echo json_encode($data);
		die;		
	
	// savecustom 保存自定义页面
	}elseif($_GPC['op'] == 'savecustom'){
		$pageid = intval($_GPC['pageid']);
		$data['type'] = intval($_GPC['pagetype']);
		$data['pagename'] = htmlspecialchars($_GPC['pagename']);
		$basicparams = json_decode(htmlspecialchars_decode($_GPC['basicparams']),true);
		$params =   json_decode(htmlspecialchars_decode($_GPC['params']),true);
		
		$data['basicparams'] = iserializer($basicparams);
		$data['params'] = iserializer($params);
		$data['time'] = time();
		$data['status'] = 1;
		
		if(empty($pageid)){
			$res = Util::inserData('zofui_groupshop_custom',$data);
		}else{
			unset($data['status']);
			$res = pdo_update('zofui_groupshop_custom',$data,array('uniacid'=>$_W['uniacid'],'id'=>$pageid));
			Util::deleteCache('custompage',$pageid);
			util::deleteCache('custompage','index');
		}
		if($res) die('1');die('2');
		
	//deletecache 删除缓存
	}  elseif($_GPC['op'] == 'deletecache'){ 
		$res = cache_clean('zofui_groupshop');
		if($res) die('1'); die('2');
		
	//发货
	}  elseif($_GPC['op'] == 'sendgood'){
		$type = intval($_GPC['expresstype']);
		$dealtype = $_GPC['type'];
		$name = htmlspecialchars($_GPC['expressname']);
		$number = htmlspecialchars($_GPC['expressnumber']);
		$id = intval($_GPC['id']);
		if($type == 1 && (empty($name) || !isset($number))){
			die('您还没有填写订单编号');
		}	
		
		if($type == 0) $uparray = array('sendtime'=>time(),'status'=>4,'isneedexpress'=>1);
		if($type == 1) $uparray = array('expressname'=>$name,'expressnumber'=>$number,'sendtime'=>time(),'status'=>4,'isneedexpress'=>2);
		
		if($dealtype == 'editexpress') unset($uparray['sendtime'],$uparray['status']); //编辑快递编号，不改变发货时间和状态
		
		$res = model_order::sendGood($id,$uparray,$dealtype);
		if($res['status']) die('1'); echo '操作失败:'.$res['err_code']; die;
		
		
	//markorder 备注订单
	}  elseif($_GPC['op'] == 'markorder'){ 
		$data['adminmark'] = htmlspecialchars($_GPC['value']);
		$id = intval($_GPC['id']);
		if(empty($data['adminmark'])) die('没有填写内容');
		$res = pdo_update('zofui_groupshop_order',$data,array('id'=>$id,'uniacid'=>$_W['uniacid']));
		Util::deleteCache('order',$id); //删除缓存
		if($res) die('1'); die('备注失败');
		
	//markorder 删除订单
	}  elseif($_GPC['op'] == 'deleteOrder'){ 
		$id = intval($_GPC['id']);
		$res = WebCommon::deleteSingleOrder($id);
		if($res) die('1'); die('删除失败');		
		
	//editOrderOfAddress 修改订单收件信息
	}  elseif($_GPC['op'] == 'editOrderOfAddress'){ 
		$id = intval($_GPC['id']);
		$data['name'] = htmlspecialchars($_GPC['name']);
		$data['tel'] = htmlspecialchars($_GPC['tel']);
		$data['address'] = htmlspecialchars($_GPC['address']);
		
		$res = pdo_update('zofui_groupshop_order',$data,array('id'=>$id,'uniacid'=>$_W['uniacid']));
		Util::deleteCache('order',$id); //删除缓存
		if($res) die('1'); die('修改失败');			
		
	// 查询快递信息
	}  elseif($_GPC['op'] == 'getexpressinfo'){ 		
		//$res = model_express::getExpressInfo($_GPC['name'],$_GPC['number']);
		
		$info['ShipperCode'] = model_express::decodeExpress($_GPC['name']);
		$info['LogisticCode'] = $_GPC['number'];
		$info["EBusinessID"] = $this->module['config']['kdniaoid'];
		$info["AppKey"] = $this->module['config']['kdniaokey'];	
		
		$express = new SubExpress($info,1);
		$res = $express -> getOrderTracesByJson();
		
		$res = json_decode($res,true);
		$res['Traces'] = array_reverse($res['Traces']);
		
		$status = 0;
		if($res['Success']){
			$status = 1;
			$str = '<ul class="timeline">';
			foreach($res['Traces'] as $k=>$v){
				$str .= <<<div
					<div class="input_item item_cell_box" style="display:-webkit-box;">
						<div class="express_time" >{$v['AcceptTime']}</div>
						<div class="input_form item_cell_flex express_detail">
							{$v['AcceptStation']}
						</div>
					</div>
div;
			}
			$str .= '</ul>';
		}else{
			$str = empty($res['Reason'])?'查询失败，可能快递编号不正确':$res['Reason'];
		}
		echo json_encode(array('status'=>$status,'data'=>$str));die;
		
	//拒绝退款
	}  elseif($_GPC['op'] == 'refuserefund'){ 
		$id = intval($_GPC['id']);
		$res = pdo_update('zofui_groupshop_order',array('refundstatus'=>4,'refuserefundtime'=>time()),array('id'=>$id,'uniacid'=>$_W['uniacid'],'refundstatus'=>1));
		Util::deleteCache('order',$id); //删除缓存
		if($res) die('1'); die('拒绝退款失败');
		
	//单个退款
	}  elseif($_GPC['op'] == 'refundsingle'){ 
		$id = intval($_GPC['id']);
		$money = sprintf('%.2f',$_GPC['money']);
		
		$res = model_order::refundMoney($id,$money,$this,'web');
		
		if($res['status']) die('1'); echo '退款失败,'.$res['error_code']; die;
	
	//全团退款
	}  elseif($_GPC['op'] == 'refundgroup'){ 
		$id = intval($_GPC['id']);
		$groupinfo = model_group::getSingleGroup(array('id'=>$id,'uniacid'=>$_W['uniacid']),$id);
		if(empty($groupinfo)) die('团不存在');
		$status = model_group::decodeGroupStatus($groupinfo['status'],$groupinfo['overtime'],$groupinfo['isrefund'],$groupinfo['lastnumber']);
		if($status != 2) die('当前团不能退款'); //不是失败状态的团不能退款
		
		
		pdo_update('zofui_groupshop_group',array('isrefund'=>1),array('id'=>$id,'uniacid'=>$_W['uniacid']));
		Util::deleteCache('group',$id);
		die('1'); die('退款失败');
		 	
		
	//查询要评价的商品
	}elseif($_GPC['op'] == 'selectcommentgood'){ 
		$id = intval($_GPC['id']);
		$good = Util::getSingelDataInSingleTable('zofui_groupshop_good',array('uniacid'=>$_W['uniacid'],'id'=>$id),' id,title,pic ');
		if(empty($good)) {
			echo json_encode(array('status'=>0,'data'=>'没有找到要评价的商品'));die;
		}
		$good['pic'] = iunserializer($good['pic']);		
		$str = '<img src="'.tomedia($good['pic'][0]).'"> <p>'.$good['title'].'</p><input type="hidden" value="'.$good['id'].'" name="commentgoodid">';
		echo json_encode(array('status'=>1,'data'=>$str));die;
		
	//随机获取一条评价人
	}elseif($_GPC['op'] == 'getnickname'){ 
		$datanumber = pdo_fetchcolumn(" SELECT COUNT(*) FROM " . tablename('mc_members'));
		for($i;$i<10;$i++){
			$id = rand(1,$datanumber);
			$user =pdo_fetch(' SELECT nickname,avatar FROM '. tablename('mc_members') .' WHERE uid = :uid ',array('uid'=>$id));
			if(!empty($user['nickname']) && !empty($user['avatar'])) break;
		}
	
		if(empty($user)){
			echo json_encode(array('status'=>0,'data'=>'没有找到合适的会员数据'));die;
		}
		
		echo json_encode(array('status'=>1,'data'=>$user));die;		
		
		
	//搜索管理员
	}elseif($_GPC['op'] == 'getadmin'){ 		
		
		$nickname = $_GPC['nickname'];
		$sql = " SELECT * FROM ".tablename('mc_mapping_fans')." WHERE uniacid = ".$_W['uniacid']." AND nickname LIKE '%".$nickname."%' ORDER BY rand() ";
		$user = pdo_fetch($sql);
		
		if(empty($user)){
			echo json_encode(array('status'=>0,'data'=>'没有找到搜索的会员'));die;
		}else{
			$tag = iunserializer( base64_decode( $user['tag'] ) );
			$admin['headimgurl'] = $tag['headimgurl'];
			$admin['nickname'] = $user['nickname'];
			$admin['openid'] = $user['openid'];
			
			echo json_encode(array('status'=>1,'data'=>$admin));die;	
		}


	//提醒买家要过期了
	}elseif($_GPC['op'] == 'reminduser'){ 
		$id = intval($_GPC['id']);
		$message = $_GPC['value'];
		$order = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('id'=>$id),' orderid,openid,totalmoney,createtime,isremind ');
		if(empty($order)) die('无此订单');
		if($order['isremind'] == 1) die('此订单已发过提醒消息了');
		
		$res = Message::kmessage($order['openid'],$message,$this,$order['totalmoney'],'点击此处查看详情',$order['createtime'],$order['orderid'],$id);
		
		if($res){
			pdo_update('zofui_groupshop_order',array('isremind'=>1),array('id'=>$id));
			Util::deleteCache('order',$id);
			die('1');
		} 
		die('发送失败，请检查模板消息是否填写正确');
		
	//增加卡券测试数据
	}elseif($_GPC['op'] == 'testcard'){
		
		$num = Util::countDataNumber('zofui_groupshop_card',array('uniacid'=>$_W['uniacid']));
		if($num >= 20) die('0');
		for($i;$i<4;$i++){
			$data = array(
				'cardtype' => rand(1,2),
				'cardname' => '测试优惠券'.rand(100,999),
				'needcredit' => rand(10,30),
				'cardvalue' => rand(10,99),
				'fullmoney' => rand(100,300),
				'totalnum' => rand(100,300),
				'limitnum' => rand(1,10),
				'expire' => rand(10,30),
				'starttime' => time(),
				'endtime' => time()+3600*24*30,
				'status' => 0,
				'time' => time()
			);
			$data['lastnum'] = $data['totalnum'];
			if($data['cardtype'] == 2 || $data['cardtype'] == 4) $data['cardvalue'] = $data['cardvalue']/100;
			
			$res = Util::inserData('zofui_groupshop_card',$data);
		}
		if($res) die('1');die('2');
	
	//商品测试数据
	}elseif($_GPC['op'] == 'testgood'){
		$imgurl = $_W['siteroot'].'addons/zofui_groupshop/public/images/test/';
		
		for($i=0;$i<5;$i++){
			$testarray = array(
				  "title"=> "泰国红心柚1只装 单果重900g-1200g",
				  'uniacid'=>$_W['uniacid'],
				  "descrip"=>"泰国红心柚，乃泰国柚子中的贵族。跟普通柚子相比，果型稍扁，柚香味浓。果肉呈浅粉色，软嫩多汁，清香凉润，人口清甘，夹杂淡淡微酸，口感层次丰富多变。含有大量天然叶酸，有预防贫血症状发生和促进胎儿发育的功效，很适合孕妇食用",
				  "oldprice"=> rand(100,200),
				  "nowprice"=> rand(50,100),
				  "groupprice"=> rand(35,45),
				  "groupnum"=> 10,
				  "groupendtime" => 24,
				  "stock"=> 100,
				  "sales"=> rand(100,200),
				  "order"=> rand(1,100),
				  "ruletype"=> 1,
				  "inco" => 'a:4:{i:0;s:6:"包邮";i:1;s:14:"24小时发货";i:2;s:12:"正品保证";i:3;s:12:"限时抢购";}',
				  "expresstype"=> 1,
				  "expressmoney"=> 5,
				  "expressid"=> 5,
				  "iscredit"=> 1,
				  "maxcredit"=> 10,
				  "isfreeexpress"=>NULL,
				  "fullmoney"=> "",
				  "isfirstcut"=>NULL,
				  "firstcutmoney"=> "",
				  "iscard" => 1,
				  "limitbuy"=> 0,
				  "limittime"=> "",
				  "limitnum"=> "",
				  "maxallow" =>5,
				  "pic"=> 'a:2:{i:0;s:51:"'.$imgurl.rand(1,5).'.jpg";i:1;s:51:"'.$imgurl.rand(1,5).'.jpg";}',
				  "status"=> "0",
				  "detail" => htmlspecialchars('<p><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1795616675/TB2xORzpFXXXXXNXFXXXXXXXXXX-1795616675.jpg" class="img-ks-lazyload"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1795616675/TB2DsFVpFXXXXc8XXXXXXXXXXXX-1795616675.jpg" class="img-ks-lazyload"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i4/1795616675/TB2TZt5pFXXXXa5XXXXXXXXXXXX-1795616675.jpg" class="img-ks-lazyload"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1795616675/TB27AX0pFXXXXb5XXXXXXXXXXXX-1795616675.jpg" class="img-ks-lazyload"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1795616675/TB2q5XBpFXXXXcqXpXXXXXXXXXX-1795616675.jpg" class="img-ks-lazyload"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i1/1795616675/TB28vB0pFXXXXb0XXXXXXXXXXXX-1795616675.jpg" class="img-ks-lazyload"><img align="absmiddle" src="https://img.alicdn.com/imgextra/i3/1795616675/TB2G4JWpFXXXXcwXXXXXXXXXXXX-1795616675.jpg" class="img-ks-lazyload"></p>'),
				  "createtime"=> time(),
				  "edittime"=> time(),
				  "usercredit"=> 5,
				  "rulearray"=> 'a:2:{i:0;a:2:{s:4:"name";s:6:"颜色";s:3:"pro";s:21:"黑色,黄色,绿色,";}i:1;a:2:{s:4:"name";s:6:"尺寸";s:3:"pro";s:9:"s,l,m,sl,";}}',
				  'params' =>  'a:4:{i:0;a:2:{s:4:"name";s:4:"1111";s:3:"pro";s:4:"1111";}i:1;a:2:{s:4:"name";s:5:"22222";s:3:"pro";s:6:"222222";}i:2;a:2:{s:4:"name";s:6:"333333";s:3:"pro";s:8:"33333333";}i:3;a:2:{s:4:"name";s:9:"444444444";s:3:"pro";s:9:"444444444";}}'
			);	
			
			$res = pdo_insert('zofui_groupshop_good',$testarray);
			
		}
		if($res) die('1'); die('2');
	
		//增加订单测试数据
	}elseif($_GPC['op'] == 'testorder'){
		$num = Util::countDataNumber('zofui_groupshop_order',array('uniacid'=>$_W['uniacid']));
		if($num >= 100) die('0');
		for($i = 0;$i<5;$i++){
			$goodinfo = pdo_fetch(" SELECT * FROM ".tablename('zofui_groupshop_good')." WHERE uniacid = '{$_W['uniacid']}'  ORDER BY rand() LIMIT 1");
			$goodinfo['pic'] = iunserializer($goodinfo['pic']);
			if(empty($goodinfo)) die('还没有商品数据，请先发布一些商品');
			
			$data = array(
				'uniacid' => $_W['uniacid'],
				'orderid' => date("YmdHis") . $_W['uniacid'] . 0 . rand(10000,99999),
				'ordertype' => 4,
				'totalexpress' => 15,
				'totalmoney' => $goodinfo['nowprice'] + 15,
				'status' => rand(1,7),
				'name' => '测试订单',
				'tel' => '13112345678',
				'address' => '广东省,深圳市,福田区,好人路88号',
				'message' => '测试数据',
				'totalnum' => 1,
				'createtime' => time(),
			);
			$res = pdo_insert('zofui_groupshop_order',$data);
			$newid = pdo_insertid();
			
			$gooddata = array(
				'idoforder' => $newid,
				'gid' => $goodinfo['id'],
				'pic' => $goodinfo['pic'][0],
				'title' => $goodinfo['title'],
				'buyprice' => $goodinfo['nowprice'],
				'buynum' => 1,
				'buyexpressmoney' => 15,
				'buymoney' => $goodinfo['nowprice'] + 15
			);
			
			$res = Util::inserData('zofui_groupshop_ordergood',$gooddata);
		}
		if($res) die('1');die('2');
	
	}
	
	elseif( $_GPC['op'] == 'queue'){

		for( $i = 0;$i<3;$i++ ){
			$cache = Util::getCache('queue','q');
			if( empty( $cache ) || $cache['time'] < ( time() - 40 ) ){
				if( $i == 2 ){
					$url = Util::createModuleUrl('message',array('op'=>1));
					$res = Util::httpGet($url,'', 1);
					die('2');
				}
				sleep(1);
			}else{
				die('1');
			}			
			
		}

		

	}
	
	