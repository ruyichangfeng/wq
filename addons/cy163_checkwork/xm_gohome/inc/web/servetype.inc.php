<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'checktype', 'editok', 'delete', 'child', 'deletechild');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_servetype')." WHERE weid =".$this->weid." and parent_id=0 and delstate=1 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_servetype')." WHERE weid = ".$this->weid." and parent_id=0 and delstate=1 ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/servetype/servetype-list');
}

if($foo == "add"){
	$id = intval($_GPC['id']);

	$list1= pdo_fetchall("select id,type_name from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and parent_id = 0 and delstate=1 order by id desc");
	$list = pdo_fetchall("select id,message_name from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." order by id desc");
	$list2 = pdo_fetchall("select id,temp_name from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and delstate=1 order by id desc");
		
	load()->func('tpl');
	include $this->template('web/servetype/servechild-add');
}

if($foo == "addok"){
	if(checksubmit('submit')){
		if(empty($_GPC['type_name'])){
			message('服务类别名称不能为空');
		}
		$chao = $_GPC['chao'];
		if($chao == 1){
			if(empty($_GPC['link'])){
				message('链接地址不能为空');
			}	
			$link = $_GPC['link'];
		}else{
			$link = '';
		}
			
		if(empty($_GPC['icon'])){
			message('请上传服务类别图标');
		}
		if(empty($_GPC['temp_id'])){
			message('模型名称不能为空，请选择模型');
		}
		
		/*	
		if($_GPC['parent_id'] != 0){
			if($_GPC['price'] == ''){
				message('服务市场价格不能为空');
			}
			if($_GPC['price_unit'] == ''){
				message('服务优惠价格不能为空');
			}
			if($_GPC['unit'] == ''){
				message('服务单位不能为空');
			}
		}
		*/
			
		if($_GPC['mode'] == 1){		
			$temp_msg = 0;
			$send_sms = 0;
			$mode_openid = '';
			$mode_mobile = '';
		}else{		
			$temp_msg = $_GPC['temp_msg'];
			$temp_msg = implode(",", $temp_msg);
			$temp_msg = $temp_msg[0];
			if($temp_msg == 1){
				if(empty($_GPC['mode_openid'])){
					message('推送openid不能为空！');
				}else{
					$mode_openid = str_replace('，',',',$_GPC['mode_openid']);
				}
			}
			$send_sms = $_GPC['send_sms'];
			$send_sms = implode(",", $send_sms);
			$send_sms = $send_sms[0];
			if($send_sms == 1){
				if(empty($_GPC['mode_mobile'])){
					message('发送短信号码不能为空！');
				}else{
					$mode_mobile = str_replace('，',',',$_GPC['mode_mobile']);
				}
			}
		}
			
		if($_GPC['gettype'] == 1){
			if($_GPC['bili_bai'] == ''){
				message('你选择了按百分比方式获取佣金，百分比不能为空');
			}
			if($_GPC['start'] > $_GPC['end']){
				message('平台佣金值起始值不能大于最高值为空');
			}
			$bili_bai = $_GPC['bili_bai'];
			$bili_money = 0;
			$times = 0;
			$start = $_GPC['start'];
			$end = $_GPC['end'];
		}
			
		if($_GPC['gettype'] == 0){
			if($_GPC['bili_money'] == ''){
				message('你选择了按每单方式获取佣金，每单价格不能为空');
			}
			$bili_bai = 0;
			$bili_money = $_GPC['bili_money'];
			$times = $_GPC['times'];
			$start = 0;
			$end = 0;
		}
			
		$data['weid'] = $this->weid;
		$data['type_name'] = $_GPC['type_name'];
		$data['chao'] = $chao;
		$data['link'] = $link;
		$data['icon'] = $_GPC['icon'];
		$data['icon_pc'] = $_GPC['icon_pc'];
		$data['top'] = $_GPC['top'];
		$data['jianshu'] = $_GPC['jianshu'];
		$data['remark'] = htmlspecialchars_decode($_GPC['remark']);
		$data['stop'] = $_GPC['stop'];
		$data['temp_id'] = $_GPC['temp_id'];
		$data['mode'] = $_GPC['mode'];
				
		$data['temp_msg'] = $temp_msg;
		$data['send_sms'] = $send_sms;
		$data['mode_openid'] = $mode_openid;
		$data['mode_mobile'] = $mode_mobile;
		
		$data['first'] = $_GPC['first'];		
		$data['offer_state'] = $_GPC['offer_state'];
		$data['cardname'] = $_GPC['cardname'];
		$data['parent_id'] = $_GPC['parent_id'];
		$data['price'] = $_GPC['price'];
		$data['price_unit'] = $_GPC['price_unit'];
		$data['unit'] = $_GPC['unit'];
		$data['gettype'] = $_GPC['gettype'];
		$data['bili_bai'] = $bili_bai;
		$data['bili_money'] = $bili_money;
		$data['start'] = $start;
		$data['end'] = $end;
		$data['times'] = $times;
		$data['basemoney'] = $_GPC['basemoney'];
		$data['front'] = $_GPC['front'];
		$data['payway'] = $_GPC['payway'];
		$data['otmpmsg_id'] = $_GPC['otmpmsg_id'];
		$data['qtmpmsg_id'] = $_GPC['qtmpmsg_id'];
		$data['xtmpmsg_id'] = $_GPC['xtmpmsg_id'];
		$data['fanwei'] = $_GPC['fanwei'];
				
		$data['diytime'] = $_GPC['diytime'];
		$data['diymobile'] = $_GPC['diymobile'];
		$data['diyname'] = $_GPC['diyname'];
		$data['diypic'] = $_GPC['diypic'];
		$data['diyaddress'] = $_GPC['diyaddress'];
		$result = pdo_insert('xm_gohome_servetype',$data);	
		if($result){
			pdo_query("update ".tablename('xm_gohome_servetype')." set child_num=child_num+1 where id=".$_GPC['parent_id']);
			message('服务项目添加成功！', $this->createWebUrl('servetype', array('foo'=>'index')), 'success');
		}else{
			message('服务项目添加失败！');
		}
	}
}

if($foo == "edit"){
	$id = intval($_GPC['id']);
	
	$list1= pdo_fetchall("select id,type_name from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and parent_id = 0 and delstate=1 order by id desc");
	$list = pdo_fetchall("select id,message_name from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." order by id desc");
	$list2 = pdo_fetchall("select id,temp_name from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and delstate=1 order by id desc");
		
	$item = pdo_fetch("select * from ".tablename('xm_gohome_servetype')." where id=".$id);
		
	load()->func('tpl');
	include $this->template('web/servetype/servechild-edit');
}

if($foo == "checktype"){
	$id = intval($_GPC['id']);
	$item = pdo_fetch("select child_num from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and delstate=1 and id=".$id);
		
	echo $item['child_num'];
}

if($foo == "editok"){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		$old_parentid = $_GPC['old_parentid'];
		$parent_id = $_GPC['parent_id'];
			
		if(empty($_GPC['type_name'])){
			message('服务类别名称不能为空');
		}
		$chao = $_GPC['chao'];
		if($chao == 1){
			if(empty($_GPC['link'])){
				message('链接地址不能为空');
			}	
			$link = $_GPC['link'];
		}else{
			$link = '';
		}
		if(empty($_GPC['icon'])){
			message('请上传服务类别图标');
		}
		if(empty($_GPC['temp_id'])){
			message('模型名称不能为空，请选择模型');
		}
		
		/*	
		if($_GPC['parent_id'] != 0){
			if($_GPC['price'] == ''){
				message('服务市场价格不能为空');
			}
			if($_GPC['price_unit'] == ''){
				message('服务优惠价格不能为空');
			}
		}
		*/
			
		if($_GPC['mode'] == 1){
			$temp_msg = 0;
			$send_sms = 0;
			$mode_openid = '';
			$mode_mobile = '';
		}else{	
			$temp_msg = $_GPC['temp_msg'];
			$temp_msg = implode(",", $temp_msg);
			$temp_msg = $temp_msg[0];
			if($temp_msg == 1){
				if(empty($_GPC['mode_openid'])){
					message('推送openid不能为空！');
				}else{
					$mode_openid = str_replace('，',',',$_GPC['mode_openid']);
				}
			}
				
			$send_sms = $_GPC['send_sms'];
			$send_sms = implode(",", $send_sms);
			$send_sms = $send_sms[0];
			if($send_sms == 1){
				if(empty($_GPC['mode_mobile'])){
					message('发送短信号码不能为空！');
				}else{
					$mode_mobile = str_replace('，',',',$_GPC['mode_mobile']);
				}
			}
		}
			
		if($_GPC['gettype'] == 1){
			if($_GPC['bili_bai'] == ''){
				message('你选择了按百分比方式获取佣金，百分比不能为空');
			}
			if($_GPC['start'] > $_GPC['end']){
				message('平台佣金值起始值不能大于最高值为空');
			}
			$bili_bai = $_GPC['bili_bai'];
			$bili_money = 0;
			$times = 0;
			$start = $_GPC['start'];
			$end = $_GPC['end'];
		}
			
		if($_GPC['gettype'] == 0){
			if($_GPC['bili_money'] == ''){
				message('你选择了按每单方式获取佣金，每单价格不能为空');
			}
			$bili_bai = 0;
			$bili_money = $_GPC['bili_money'];
			$times = $_GPC['times'];
			$start = 0;
			$end = 0;
		}
			
		$data['parent_id'] = $_GPC['parent_id'];
		$data['type_name'] = $_GPC['type_name'];
		$data['chao'] = $chao;
		$data['link'] = $link;
		$data['icon'] = $_GPC['icon'];
		$data['icon_pc'] = $_GPC['icon_pc'];
		$data['top'] = $_GPC['top'];
		$data['jianshu'] = $_GPC['jianshu'];
		$data['remark'] = htmlspecialchars_decode($_GPC['remark']);
		$data['stop'] = $_GPC['stop'];
		$data['temp_id'] = $_GPC['temp_id'];
		$data['mode'] = $_GPC['mode'];
			
		$data['temp_msg'] = $temp_msg;
		$data['send_sms'] = $send_sms;
		$data['mode_openid'] = $mode_openid;
		$data['mode_mobile'] = $mode_mobile;
		
		$data['first'] = $_GPC['first'];	
		$data['offer_state'] = $_GPC['offer_state'];
		$data['cardname'] = $_GPC['cardname'];
		$data['price'] = $_GPC['price'];
		$data['price_unit'] = $_GPC['price_unit'];
		$data['unit'] = $_GPC['unit'];
		$data['gettype'] = $_GPC['gettype'];
		$data['bili_bai'] = $bili_bai;
		$data['bili_money'] = $bili_money;
		$data['start'] = $start;
		$data['end'] = $end;
		$data['times'] = $times;
		$data['basemoney'] = $_GPC['basemoney'];
		$data['front'] = $_GPC['front'];
		$data['payway'] = $_GPC['payway'];
		$data['otmpmsg_id'] = $_GPC['otmpmsg_id'];
		$data['qtmpmsg_id'] = $_GPC['qtmpmsg_id'];
		$data['xtmpmsg_id'] = $_GPC['xtmpmsg_id'];
		$data['fanwei'] = $_GPC['fanwei'];
		$data['diytime'] = $_GPC['diytime'];
		$data['diymobile'] = $_GPC['diymobile'];
		$data['diyname'] = $_GPC['diyname'];
		$data['diypic'] = $_GPC['diypic'];
		$data['diyaddress'] = $_GPC['diyaddress'];
		$data['addtime'] = date('Y-m-d H:i:s',time());
			
		$result = pdo_update('xm_gohome_servetype',$data,array('id'=>$id));
		if($result){
			if($old_parentid != $parent_id){
				pdo_query("update ".tablename('xm_gohome_servetype')." set child_num=child_num-1 where id=".$old_parentid);
				if($parent_id != 0){
					pdo_query("update ".tablename('xm_gohome_servetype')." set child_num=child_num+1 where id=".$parent_id);
				}
			}
			message('服务项目修改成功！', $this->createWebUrl('servetype', array('foo'=>'index')), 'success');
		}else{
			message('服务项目修改失败！'.$id);
		}
	}
}

if($foo == "delete"){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message("参数错误：未获取到服务项目ID");
		exit();
	}

	$data['delstate'] = 0;
	$result = pdo_update('xm_gohome_servetype',$data, array('id' => $id));
	if($result){
		pdo_update('xm_gohome_servetype', $data, array('parent_id' => $id));
		message('删除成功！', $this->createWebUrl('servetype', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

if($foo == "child"){
	$id = $_GPC['id'];
	if(empty($id)){
		message("参数错误：无法获取到项目ID");
		exit();
	}
		
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_servetype')." WHERE weid =".$this->weid." and parent_id = ".$id." and delstate=1 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_servetype')." WHERE weid = ".$this->weid." and parent_id = ".$id." and delstate=1 ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/servetype/servechild-list');
}

if($foo == "deletechild"){
	$id = intval($_GPC['id']); 
	$parent_id = intval($_GPC['parent_id']);
	if(empty($id) || empty($parent_id)){
		message("未获取到相应的参数！");
		exit();
	}
		
	$data['delstate'] = 0;
	$result = pdo_update('xm_gohome_servetype', $data, array('id' => $id));
	if($result){
		pdo_query("update ".tablename('xm_gohome_servetype')." set child_num=child_num-1 where id=".$parent_id);
		message('删除成功！', $this->createWebUrl('servetype', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

?>