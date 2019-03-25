<?php 
	global $_GPC,$_W;
	$_GPC = Util::trimWithArray($_GPC);
	$userinfo = model_user::initUserInfo(); //用户信息	
	
	if(in_array($_GPC['op'],array('sort'))){
		
		$where['uniacid'] = $_W['uniacid'];
		$where['status'] = 0;
		$where['isdust'] = 0;
		
		if(!empty($_GPC['sortid'])) $where['sortid'] = intval($_GPC['sortid']);
		if(!empty($_GPC['isfirstcut'])) $where['isfirstcut'] = intval($_GPC['isfirstcut']);
		if(!empty($_GPC['iscredit'])) $where['iscredit'] = intval($_GPC['iscredit']);		
		if(!empty($_GPC['isfreeexpress'])) $where['isfreeexpress'] = intval($_GPC['isfreeexpress']);		
		if(!empty($_GPC['iscard'])) $where['iscard'] = intval($_GPC['iscard']);		
		if(!empty($_GPC['search'])) $where['title@'] = htmlspecialchars($_GPC['search']);
		
		$order = '`order` DESC ';
		if(in_array($_GPC['order'],array('id','groupprice','sales'))){
			$order = htmlspecialchars($_GPC['order']);
			if($_GPC['updown'] == 'asc' || $_GPC['updown'] == 'desc'){
				if( $_GPC['order'] == 'groupprice' && $this->module['config']['shoptype'] == 2 ) $order = 'nowprice';
				$order = $order.' '.$_GPC['updown'];
			}
		}
		
		
		$data = model_good::getAllGoodInAppWithSort($where,$_GPC['page'],10,$order);
		$goodinfo = $data[0];
		
		foreach($goodinfo as $k=>$v){
			$url = $this->createMobileUrl('good',array('id'=>$v['id']));
			$img = iunserializer($v['pic']);
			$pic = tomedia($img[0]);
			
			if($this->module['config']['shoptype'] == 2){
				$price = $v['nowprice'];
				$numstr = '<p class="good_btn_ordernum">已售'.$v['sales'].'件</p>';
			}else{
				$price = $v['groupprice'];
				$numstr = '<p class="good_btn_ordernum"><span class="fl">'.$v['groupnum'].'人团</span> 已售'.$v['sales'].'件</p>';
			}
			
			$str .= <<<div
		<div class="listthum nead_square_images router">
				<a href="{$url}" data-router="1">
					<img src="{$pic}">
				</a>
				<p class="good_title">{$v['title']}</p>
				<p class="good_price"><span>￥{$price}</span> <span>￥{$v['oldprice']}</span></p>
				{$numstr}
		</div>
div;
		}
	}

	
	//成员列表
	if(in_array($_GPC['op'],array('fmember'))){

		for($i=0 ; $i<10;$i++){
		
			$str .= <<<div
		<a href="javascript:void(0);" class="weui_media_box weui_media_appmsg fmember_item">
			<div class="weui_media_hd fmember_head" data-url="{$url}">
				<img class="weui_media_appmsg_thumb lazy" data-original="{$v['avatar']}" src="../addons/zofui_groupshop/public/images/menu.png">
			</div>
			<div class="weui_media_bd" data-url="{$url}">
				<p class="weui_media_title item_nickname">个个个</p>
				<p class="weui_media_desc"><span class="font_13px_999">加入时间：2016-07-16</span></p>
			</div>
			<div class="font_13px_999" data-uid="{$uid}">族长</div>
		</a>
div;
		}
	}
	
	//成员列表
	if(in_array($_GPC['op'],array('flog'))){

		for($i=0 ; $i<10;$i++){
		
			$str .= <<<div
			<div class="newlist">				
				<div class="new_shop">
					<img src="../addons/zofui_groupshop/public/images/menu.png">
				</div>
				<a href="{$url}">
					<div class="new_goodes">
						<span class="item_nickname">额外企鹅</span>
						<span class="new_title">3421412312让我确认去无人区我而去</span>
						<div class="new_pic">
							<span>1天前</span>
						</div>
					</div>
				</a>					
			</div>
div;
		}
	}	
	
	//商品评论 goodcomment
	if(in_array($_GPC['op'],array('goodcomment'))){
		
		$where['uniacid'] = $_W['uniacid'];
		$where['status'] = 0;
		$where['gid'] = intval($_GPC['goodid']);
		if($_GPC['type'] == 'good')  $where['level'] = 1;
		if($_GPC['type'] == 'soso')  $where['level'] = 2;
		if($_GPC['type'] == 'bad')  $where['level'] = 3;
		
		$data = Util::getAllDataInSingleTable('zofui_groupshop_comment',$where,intval($_GPC['page']),10,'commenttime DESC',false);
		
		foreach($data[0] as $k => $v){
			$time = Util::formatTime($v['commenttime']);
			$content = htmlspecialchars_decode($v['text']);
			$img = '';
			$v['pic'] = iunserializer($v['pic']);
			if(is_array($v['pic'])){
				foreach($v['pic'] as $kk=>$vv){
					$img .= '<img src="'.tomedia($vv).'">';
				}				
			}
			$headimg = tomedia($v['headimg']);
			
			$str .= <<<div
				<div class="comment_item padding_10">
					<div class="left fl ">
						<img src="{$headimg}">
					</div>
					<div class="right overflow_hidden">
						<li><span class="font_bold_name item_nickname">{$v['nickname']}</span></li>
						<li class="comment_title">{$content}</li>
						<li class="comment_images">
						{$img}
						</li>
						<div class="bottom font_13px_999 comment_time">{$time}</div>								
					</div>
				</div>
div;
		}
	}
	
	
	//订单
	if(in_array($_GPC['op'],array('order'))){
	
		$wherea['openid'] = $_W['openid'];
		$wherea['uniacid'] = $_W['uniacid'];
		
		if(in_array($_GPC['status'],array(1,3,4,5))){
			$wherea['status'] = intval($_GPC['status']);;
			$statusstr = ' a.`refundstatus` NOT IN (1) ';
		}
		if($_GPC['status'] == 7) $statusstr = ' a.`refundstatus` IN (1,3) ';
		if($_GPC['onlygroup'] == 1) $statusstr = ' a.`ordertype` IN (2,3) '; //来自团内的未支付
		
		$select = ' a.id,a.orderid,a.ordertype,a.totalmoney,a.totalnum,a.status,a.refundstatus,b.gid,b.pic,b.title,b.rule,b.buynum,b.buymoney,b.iscomment,b.idoforder ';
		$data = model_order::getAllOrder($wherea,$whereb,$statusstr,$select,intval($_GPC['page']),10,' a.`id` DESC',false);
//var_dump( pdo_debug() );	
		$payurl = $this->createMobileUrl('pay');
		if(!empty($data[0])){
			foreach($data[0] as $k => $v){
				$goodstr = '';
				foreach($v as $kk => $vv){
					$goodurl = $this->createMobileUrl('good',array('id'=>$vv['gid']));
					$img = tomedia($vv['pic']);
					
					$goodstr .= <<<div
					<div class="order_item_body item_cell_box order_item_in" style="border:0">
						<div class="order_good_left">
							<img src="{$img}">
						</div>
						<div class="order_good_right item_cell_flex">
							<a href="{$goodurl}">
								<div class="order_good_title good_title">{$vv['title']}</div>
							</a>
							<div class="order_good_rule font_13px_999">规格：{$vv['rule']}</div>
						</div>			
					</div>
div;
				}
				foreach($v as $kk => $vv){
					$statusstr = '';
					$dealstr = '';
					$orderurl = $this->createMobileUrl('user',array('op'=>'orderinfo','id'=>$vv['id']));
					$vv['ostatus'] = model_order::decodeOrderStatus($vv['status'],$vv['refundstatus']);
						
					if($vv['ostatus'] == 1){
						$statusstr = '待支付';
						$dealstr = '<form action="'.$payurl.'" method="post">
							<input type="hidden" name="orderid" value="'.$vv['id'].'">
							<input name="resetpay" value="去支付" class="fr order_act_btn" type="submit">
							<input name="token" type="hidden" value="'.$_W['token'].'" />
						</form>';
					}elseif($vv['ostatus'] == 2){
						$statusstr = '已取消';
					}elseif($vv['ostatus'] == 3){
						$statusstr = '待发货';
						if($vv['ordertype'] == 1 &&  $this->module['config']['iscanrefund'] == 1 && $vv['refundstatus'] == 0){
							$dealstr = '<a href="javascript:;" data-id="'.$vv['id'].'"><span class="fr order_btn_deal" data-type="refund">申请退款</span></a>';
						}
					}elseif($vv['ostatus'] == 4){
						$statusstr = '已发货';
						$dealstr = '<a href="javascript:;" data-id="'.$vv['id'].'"><span class="fr order_btn_deal" data-type="confirm">确认收货</span></a>';
					}elseif($vv['ostatus'] == 5 || $vv['ostatus'] == 6){
						$statusstr = '已完成';
						if($vv['ostatus'] == 5) {
							$dealstr = '<a href="javascript:;"><span class="fr comment_good" data-id="'.$vv['id'].'">评价商品</span></a>';
						}
					}elseif($vv['ostatus'] == 7){
						$statusstr = '已退款';
					}elseif($vv['ostatus'] == 8){
						$statusstr = '已申请退款';
						$dealstr = '<a href="javascript:;" data-id="'.$vv['id'].'"><span class="fr order_btn_deal" data-type="cancelrefund">取消退款</span></a>';
					}
					
					if($vv['ordertype'] == 2){
						$ordertype = '<span class="order_type">团购单</span>';
					}else{
						$ordertype = '';
					}
					
					$str .= <<<div
					<div class="order_good_item margin_top_5px shadow_box afterdealdelete">
						<div class="order_item_top order_item_in">
							<span>订单号:{$vv['orderid']}</span><span class="fr font_ff5f27">{$statusstr}</span>
							{$ordertype}
						</div>
						{$goodstr}
						<div class="order_item_price order_item_in">
							<span class="font_13px_999">共<span class="font_ff5f27">{$vv['totalnum']}</span>件,</span>
							<span class="font_13px_999">实付: <span class="font_ff5f27">{$vv['totalmoney']}</span>元</span>
						</div>			
						<div class="order_item_bot order_item_in" style="border:0">
							{$dealstr}
							<a href="{$orderurl}"><span class="fr look_detail">订单详情</span></a>
						</div>		
					</div>
div;
					break;
				}

			}
		}
	}

	if(in_array($_GPC['op'],array('getcard','card'))){
		$userinfo = model_user::initUserInfo(); //用户信息
		
		if($_GPC['op'] == 'getcard'){ //可领优惠券
			$where['status'] = 0;
			$where['starttime<'] = time();
			$where['endtime>'] = time();
			$where['lastnum>'] = 1;		
			$data = Util::structWhereStringOfAnd($where);
			$selectStr = $data[0].' AND `cardtype` IN (1,2) ';
			$select =  "SELECT * FROM ".tablename('zofui_groupshop_card') ." WHERE ";
			$data = Util::fetchFunctionInCommon('',$select.$selectStr,$data[1],intval($_GPC['page']),8,'`id` DESC',false);
		
		}elseif($_GPC['op'] == 'card'){ //已领取
			
			$where['status'] = 0;
			$where['userid'] = $userinfo['id'];
			$where['overtime>'] = time();
			$data = model_card::getTakedCard($where,8,intval($_GPC['page']),' b.`id` DESC','app',false);
		}
		
		foreach($data[0] as $k=>$v){
		
			if($_GPC['op'] == 'getcard'){
				//查询是否已兑换过了，兑换过了退出
				$taked = model_card::selectTakedNum($userinfo['id'],$v['id']);
				if($taked >= $v['limitnum']) continue;
				$start = date('Y-m-d',$v['starttime']);
				$end = date('Y-m-d',$v['endtime']);			
				
				$timestr = '<p>'.$start.' - '.$end.'</p>';
				$exchangestr = '<font class="card_exchange" data-id="'.$v['id'].'" data-need="'.$v['needcredit'].'">兑 换</font>';
				
			}elseif($_GPC['op'] == 'card'){
				$lasttime = Util::lastTime($v['overtime'],false);
				$timestr = '<p>距失效:'.$lasttime .'</p>';
				$exchangestr = '';
			}
			
			if($v['cardtype'] == 1 ||$v['cardtype'] == 3){ //代金券
				$value = '<p><font class="sign">￥</font>'.$v['cardvalue']*10/10 .'</p>';
				$count = '满'.$v['fullmoney']*10/10 .'减'.$v['cardvalue'];
				$typeclass = 'stamp02';
			}elseif($v['cardtype'] == 2 ||$v['cardtype'] == 4){ //折扣券
				$value = '<p>'. 10*$v['cardvalue'].'<font class="sign"> 折</font></p>';
				$count = '满'.$v['fullmoney']*10/10 .'打'.$v['cardvalue']*10 . '折';
				$typeclass = 'stamp03';
			}
			
			$taked = model_card::selectTakedNum($userinfo['id'],$v['id']);
			
			$str .= <<<div
			<div class="stamp {$typeclass} margin_top_10px">
				<span class="border_card border_01"></span>
				<span class="border_card border_02"></span>		
				<div class="par">
					<p>{$v['cardname']}</p>
					<p>{$count}</p>
					{$timestr}
					<span class="arrow_up card_cut_up"></span>
					<span class="arrow_up card_cut_down"></span>
				</div>
				<div class="copy getcard_copy">
					<div>
						{$value}
						{$exchangestr}
					</div>
				</div>
				<i></i>
			</div>
div;
		}
	}	
	
	//订单列表页面评价商品，获取商品数据
	if($_GPC['op'] == 'getcommentgoog'){
		$id = intval($_GPC['id']);
		$where = array('id'=>$id,'uniacid'=>$_W['uniacid'],'openid'=>$_W['openid'],'status'=>5);
		$data = model_order::getSingleOrderDetail($id,$where);
	
		foreach((array)$data[0] as $k=>$v){
		foreach((array)$v as $kk=>$vv){
		$img = tomedia($vv['pic']);
		
		if($vv['iscomment'] == 0){
			$str .= <<<div
				<div class="good_comment_item " data-id="{$vv['idoforder']}">
					<input name="gid" value="{$vv['gid']}" type="hidden">
					<div class="item_cell_box good_comment_good">
						<div class="">
							<img src="{$img}">
						</div>
						<div class="item_cell_flex">
							<div class="good_title">{$vv['title']}</div>
						</div>
					</div>
					<div class="good_comment_edit">
						<div class="good_comment_edit_item item_cell_box">
							<div class=" weui_cells weui_cells_checkbox comment_level">
								<label class="weui_cell weui_check_label activity_checked_card" for="{$vv['gid']}1">
									<div class="weui_cell_hd">
										<input type="radio" class="weui_check" name="{$vv['gid']}level" value="1" id="{$vv['gid']}1" >
										<i class="weui_icon_checked"></i>
									</div>好评
								</label>
							</div>
							<div class=" weui_cells weui_cells_checkbox comment_level">
								<label class="weui_cell weui_check_label activity_checked_card" for="{$vv['gid']}2">
									<div class="weui_cell_hd">
										<input type="radio" class="weui_check" name="{$vv['gid']}level" value="2" id="{$vv['gid']}2" >
										<i class="weui_icon_checked"></i>
									</div>中评
								</label>
							</div>
							<div class=" weui_cells weui_cells_checkbox comment_level">
								<label class="weui_cell weui_check_label activity_checked_card" for="{$vv['gid']}3">
									<div class="weui_cell_hd">
										<input type="radio" class="weui_check" name="{$vv['gid']}level" value="3" id="{$vv['gid']}3" >
										<i class="weui_icon_checked"></i>
									</div>差评
								</label>
							</div>
						</div>
						<div class="good_comment_edit_item weui_cell_bd weui_cell_primary">
							<textarea class="weui_textarea" name="text" placeholder="请在此输入文字" rows="2"></textarea>
						</div>
						<div class="good_comment_edit_item overflow_hidden">
							<ul class="pub_images_box fl upload_images_views"></ul>
							<div class="ti-plus fl upload_btn" id="pub_upload_images"></div>
						</div>
						<div class="good_comment_edit_item overflow_hidden">
							<span class="fr pubcomment">发布评价</span>
						</div>
					</div>
				</div>
div;
		}
		}
		}		
	}
	

	//团购订单列表
	if($_GPC['op'] == 'mygroup'){
		$wherea['openid'] = $_W['openid'];
		$selectstr = ' a.`ordertype` IN (2,3) ';
		$wherea['status>'] = 3;
		
		if(!empty($_GPC['status']))  $selectstr .= ' AND b.status = '.intval($_GPC['status']); 
		//之所以不用$whereb是因为防止出现2个uniacid ,这里不加其他的时间和剩余人数判断，交由计划任务改变状态后显示相应状态的团
		
		$select = ' a.id AS idoforder,a.groupid,a.status AS astatus,b.*,b.id AS bid,b.status AS bstatus ';
		$data = model_group::getAllGroupOrder($wherea,$whereb,$selectstr,$select,intval($_GPC['page']),10,' a.`id` DESC ',false);		
		
		foreach((array)$data[0] as $k=>$v){
			$v['gstatus'] = model_group::decodeGroupStatus($v['bstatus'],$v['overtime'],$v['isrefund'],$v['lastnumber']);
			
			if($v['gstatus'] == 1){
				$statusstr = '组团中';
			}elseif($v['gstatus'] == 2){
				if($v['astatus'] == 7){
					$statusstr = '团购失败,已退款';
				}else{
					$statusstr = '团购失败,待退款';
				}
			}elseif($v['gstatus'] == 3){
				$statusstr = '团购成功';
			}elseif($v['gstatus'] == 4){
				$statusstr = '退款中';
			}
			$groupurl = $this->createMobileUrl('group',array('groupid'=>$v['bid']));
			$orderurl = $this->createMobileUrl('user',array('op'=>'orderinfo','id'=>$v['idoforder']));
			$goodurl = $this->createMobileUrl('good',array('id'=>$v['gid']));
			$img = tomedia($v['pic']);
			
			$str .= <<<div
			<div class="order_good_item group_list_item margin_top_5px shadow_box router">
				<div class="order_item_top order_item_in">
					<span> </span><span class="fr font_ff5f27">{$statusstr}</span>
				</div>
				<div class="order_item_body item_cell_box order_item_in" style="border:0">
					<div class="order_good_left">
						<img src="{$img}">
					</div>
					<div class="order_good_right item_cell_flex">
						<a href="{$goodurl}">
							<div class="order_good_title good_title">{$v['title']}</div>
						</a>
					</div>			
				</div>
				<div class="order_item_price order_item_in">
					<span class="font_13px_999">您购买<span class="font_ff5f27">{$v['buynum']}</span>件,</span>
					<span class="font_13px_999">实付: <span class="font_ff5f27">{$v['buymoney']}</span>元</span>
				</div>
				<div class="order_item_bot order_item_in" style="border:0">
					<a href="{$groupurl}"><span class="fr look_detail">团购详情</span></a>					
					<a href="{$orderurl}"><span class="fr look_detail">订单详情</span></a>
				</div>		
			</div>
div;
		}
	}
	
	
	
	
	
	if(!empty($str)) $status = 'ok';
	if(empty($str)){
		$str = '<li class="no_data_notice"><span>没有内容了</span></li>';
		
	}
	
	$data = array('status'=>$status,'data'=>$str);
	echo json_encode($data);

?>