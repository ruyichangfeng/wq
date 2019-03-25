<?php 
	global $_W,$_GPC;
	$op = empty($_GPC['op'])?'list':$_GPC['op'];
	$_GPC['do'] = empty($_GPC['do'])?'order':$_GPC['do'];
	
	
	//批量删除
	if(checksubmit('delete')){
		$res = WebCommon::deleteAllOrder($_GPC['checkid']);
		message('操作完成,成功删除'.$res[0].'项，失败'.$res[1].'项',referer(),'success');
	}
	//删除测试订单
	if(checksubmit('deletetestorder')){
		
		$order = Util::getAllDataInSingleTable('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'ordertype'=>4),1,110,'id DESC',false,' id ');
		foreach($order[0] as $k => $v){
			pdo_delete('zofui_groupshop_ordergood',array('uniacid'=>$_W['uniacid'],'idoforder'=>$v['id']),'AND');
		}
		pdo_delete('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'ordertype'=>4),'AND');
		message('已全部删除',referer(),'success');
	}
	
	//批量无物流发货
	if(checksubmit('noexpresssend')) WebCommon::batchToSend($_GPC,'noexpress');
	
	//批量物流发货
	if(checksubmit('submitbatchexpress')) WebCommon::batchToSend($_GPC,'express');
	
	//导入发货
	if(checksubmit('import')) {
		$file = $_FILES['orderfile'];
		$limitsize = "1000000";
		$filename = $file['name'];
		$ftype = strtolower(substr(strrchr($filename, '.'), 1));
		
		$uploadfile = $file['tmp_name'];
		
		if (empty ($uploadfile)) message('请选择要导入的CSV文件！');
		
		$handle = fopen($uploadfile, 'r'); 
		
		$result = input_csv($handle); //解析csv 
		
		if(count($result) <= 1) message('没有数据,文件内顶部的标题栏不能删除，并且不作为数据计算！');
		if(count($result[1]) <= 1) message('文件数据不对，文件编辑好快递后要另存为:CSV(逗号分隔).*csv 文件格式');
		
		$success = 0;
		foreach($result as $k => $v){
			if($k >= 1){ //第0个是上面的标题栏
				$orderid = iconv('gb2312', 'utf-8', trim($v[0])); //中文转码 
				$data['expressname'] = iconv('gb2312', 'utf-8', trim($v[15]));  
				$data['expressnumber'] = iconv('gb2312', 'utf-8', trim($v[16])); 
				
				if(empty($data['expressname']) || empty($data['expressnumber'])) continue; //如果没有快递就进入到下一个
				$data['isneedexpress'] = 2;
				$data['status'] = 4;
				$data['sendtime'] = time();
				
				$order = Util::getSingelDataInSingleTable('zofui_groupshop_order',array('uniacid'=>$_W['uniacid'],'orderid'=>$orderid),' id,isneedexpress,status ');
				if(empty($order['id']) || !in_array($order['status'],array(3,4))) continue; //不存在 不是待发货和待收货状态
				
				if( $order['sendtype'] == 1 ) continue; // 上店自提的

				$type = 'express';
				if($order['isneedexpress'] > 0){ //编辑快递
					$type = 'edit';
					unset($data['sendtime']);
				}
				
				$res = model_order::sendGood($order['id'],$data,$type);
				
				if($res['status']) $success ++;
			}
		}
		
		fclose($handle); //关闭指针 
		message('操作完成,成功发货'.$success.'项（只有待发货和待收货的订单，而且快递编号、快递名称不能是空的订单才能发货成功）',referer(),'success');
		
	}
	
	
	if($op == 'list'){
		
		$wherea['uniacid'] = $_W['uniacid'];
		$order=' a.`id` ';
		$by = ' DESC ';		
		if(empty($_GPC['search'])){ //不是搜索
			if(!empty($_GPC['ordertype'])) $wherea['ordertype'] = intval($_GPC['ordertype']); //订单类型
			if(!empty($_GPC['firstcut'])) $wherea['firstcutmoney>'] = 0.01; //首单优惠
			if(!empty($_GPC['expresscut'])) $wherea['totalfreeexpress>'] = 0.01; //运费优惠
			if(!empty($_GPC['cardcut'])) $wherea['cardcutmoney>'] = 0.01; //卡券优惠		
			if(!empty($_GPC['creditcut'])) $wherea['creditcut>'] = 0.01; //积分优惠		
			if(!empty($_GPC['familycut'])) $wherea['familycutmoney>'] = 0.01; 			
			
			if(in_array($_GPC['status'],array(1,2,3,4,7))){
				$wherea['status'] = intval($_GPC['status']);
				$str = ' a.refundstatus NOT IN (1) ';
				if($_GPC['status'] == 3) $wherea['iscomplete'] = 1;
			} 
			if($_GPC['status'] == 'refund') $wherea['refundstatus'] = 1;
			if($_GPC['status'] == 'end') $str = ' a.status IN (5,6) ';			
			
		}else{ //是搜索
			$wherea['uniacid'] = $_W['uniacid'];
			$title = htmlspecialchars($_GPC['title']);
			$name = htmlspecialchars($_GPC['name']);		
			$orderid = htmlspecialchars($_GPC['orderid']);
			$uorderid = htmlspecialchars($_GPC['uorderid']);
			if(!empty($title)) $whereb['title@'] = $title;
			if(!empty($name)) $wherea['name'] = $name;
			if(!empty($orderid)) $wherea['orderid'] = $orderid;
			if(!empty($uorderid)) $wherea['uorderid'] = $uorderid;
		}
		
		if(!empty($_GPC['order'])) $order = ' a.'.htmlspecialchars($_GPC['order']);
		if($_GPC['order'] == 'gid') $order = ' b.`gid` ';
		if($_GPC['order'] == 'gid') $order = ' b.`gid` ';
		
		if(!empty($_GPC['by'])) $by = ' ASC ';
		
		if(!empty($_GPC['download'])) downLoadOrder($wherea,$whereb,$str,$order,$by); //下载订单
		
		$res = WebCommon::slelectOrder($wherea,$whereb,$str,$_GPC['page'],10,$order,$by);

		$pager = $res[1];
		$list = $res[0];
		
	}
	
	//单个订单详情
	if($op == 'info'){
		$id = intval($_GPC['id']);
		$data = model_order::getSingleOrderDetail($id,array('uniacid'=>$_W['uniacid'],'id'=>$id));
		$datainfo = $data[0];
		if(empty($datainfo)) message('订单不存在',referer(),'error');
		foreach($datainfo as $k=>$v){
			foreach($v as $kk => $vv){
				$goodinfo[] = $vv;
				$info = $vv;
				$info['ostatus'] = model_order::decodeOrderStatus($info['status'],$info['refundstatus']);
			}
		}
		$userinfo = model_user::getSingleUser($info['openid']);;
		
	}
	
	if($op == 'delete'){
		$res = WebCommon::deleteSingleOrder($_GPC['id']);
		if($res) message('删除成功',referer(),'success');
	}
	
	if( $op == 'comorder' ){
		pdo_update('zofui_groupshop_order',array('status'=>5,'confirmtime'=>TIMESTAMP),array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id'],'status'=>3));
		Util::deleteCache( 'order',$_GPC['id'] );
		message('操作完成',referer(),'success');
	}
	
	//下载订单
	function downLoadOrder($wherea,$whereb,$str,$order,$by){
		$info = model_order::getAllOrder($wherea,$whereb,$str,' * ',1,100000,$order.$by,false);
		$list = $info[0];
		
		/* 输入到CSV文件 */
		$html = "\xEF\xBB\xBF".$html; //添加BOM
		/* 输出表头 */		
		$html .= '平台订单号' . "\t,";
		$html .= '微信订单号' . "\t,";		
		$html .= '实收总额' . "\t,";
		$html .= '订购总量' . "\t,";		
		$html .= '订单状态' . "\t,";
		$html .= '商品标题' . "\t,";
		$html .= '请根据右边数据发货' . "\t,";		
		$html .= '单商品实收金额' . "\t,";		
		$html .= '单商品订购数量' . "\t,";
		$html .= '单商品订购规格' . "\t,";
		$html .= '收货方式' . "\t,";				
		$html .= '收货人姓名' . "\t,";
		$html .= '收货人电话' . "\t,";
		$html .= '收货地址' . "\t,";
		$html .= '用户留言' . "\t,";
		$html .= '快递名称' . "\t,";
		$html .= '快递单号' . "\t,";
		$html .= '支付时间' . "\t,";
		$html .= '管理员备注' . "\t,";
		$html .= "\n";
		
 		foreach((array)$list as $k => $v){	
			foreach($v as $kk => $vv){
				$address = str_replace(',','，',$vv['address']);
				$message = str_replace(',','，',$vv['message']);
				$paytime = empty($vv['paytime'])?'':date('Y-m-d H:i:s',$vv['paytime']);
				$rule = str_replace(',','，',$vv['rule']);
				
				$sendtype = $vv['sendtype'] == 0 ? '物流配送' : '上店自提';

				if($vv['refundstatus'] == 0 || $vv['refundstatus'] == 2 || $vv['refundstatus'] == 3){
					if($vv['status'] == 1){
						$statusstr = '待支付';
					}elseif($vv['status'] == 2){
						$statusstr = '已取消';
					}elseif($vv['status'] == 3){
						$statusstr = '待发货';
					}elseif($vv['status'] == 4){
						$statusstr = '待收货';
					}elseif($vv['status'] == 5){
						$statusstr = '已完成';
					}elseif($vv['status'] == 6){
						$statusstr = '已完成';
					}elseif($vv['status'] == 7){
						$statusstr = '已退款';
					}
				}elseif($vv['refundstatus'] == 1){
					$statusstr = '申请退款中';
				}
				
				$html .= $vv['orderid'] . "\t,";
				$html .= $vv['uorderid'] . "\t,";
				$html .= $vv['totalmoney'] . "\t,";
				$html .= $vv['totalnum'] . "\t,";
				$html .= $statusstr . "\t,";
				$html .= $vv['title'] . "\t,";
				$html .= '' . "\t,";				
				$html .= $vv['buymoney'] . "\t,";
				$html .= $vv['buynum'] . "\t,";
				$html .= $rule . "\t,";
				$html .= $sendtype . "\t,";
				$html .= $vv['name'] . "\t,";
				$html .= $vv['tel'] . "\t,";
				$html .= $address . "\t,";
				$html .= $message . "\t,";
				$html .= $vv['expressname'] . "\t,";
				$html .= $vv['expressnumber'] . "\t,";
				$html .= $paytime. "\t,";
				$html .= $vv['adminmark']. "\t,";
				$html .= "\n"; 
			}
		}
		/* 输出CSV文件 */
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=订单列表.csv");
		echo $html;
		exit();	
		
	}
	
	
	
	function input_csv($handle) { 
		$out = array (); 
		$n = 0; 
		while ($data = fgetcsv($handle, 10000)) { 
			$num = count($data); 
			for ($i = 0; $i < $num; $i++) { 
				$out[$n][$i] = $data[$i]; 
			} 
			$n++; 
		} 
		return $out; 
	} 	
	
	
	
	include $this->template('web/order');