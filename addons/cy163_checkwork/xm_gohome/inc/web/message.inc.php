<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'aly', 'ok1', 'ok2');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$item = pdo_fetch("select * from ".tablename('xm_gohome_message')." where weid=".$this->weid." and platform=1");
	$item_s = pdo_fetch("select platform from ".tablename('xm_gohome_message')." where weid=".$this->weid." and selected=1");
	$selected = 0;
	if(!empty($item_s)){
		$selected = $item_s['platform'];
	}
		
	include $this->template('web/message/message');
}

if($foo == 'aly'){
	$item = pdo_fetch("select * from ".tablename('xm_gohome_message')." where weid=".$this->weid." and  platform=2");

	$item_s = pdo_fetch("select platform from ".tablename('xm_gohome_message')." where weid=".$this->weid." and selected=1");
	$selected = 0;
	if(!empty($item_s)){
		$selected = $item_s['platform'];
	}
		
	include $this->template('web/message/message1');
}

if($foo == 'ok1'){
	if(checksubmit('submit')){
		$id 	  = intval($_GPC['id']);
		$platform = $_GPC['platform'];
		if(empty($platform)){
			message('请选择短信平台');
		}
		if(empty($_GPC['plat_name'])){
			message('在短信宝平台注册用户的用户名不能为空');
		}
		if(empty($id)){
			if(empty($_GPC['plat_pwd'])){
				message('在短信宝平台注册用户的密码不能为空');
			}
		}
		
		$qianming = $_GPC['qianming'];
		//$first    = mb_substr($qianming, 0, 1, "UTF-8");
		//$last     = mb_substr($qianming, -1, 1, "UTF-8");
		if(empty($qianming)){
			message('签名不能为空');
		}
		/*
		if($first != "【" || $last != "】"){
			message('签名格式错误,必须以【开头，】结尾');
		}
		*/

		if($_GPC['message1'] == 1){
			if(empty($_GPC['message1_content'])){
				message('你启用了用户下单短信通知，下单短信通知内容不能为空');
			}
		}
		if($_GPC['message2'] == 1){
			if(empty($_GPC['message2_content'])){
				message('你启用了抢单短信提示，抢单短信提示内容不能为空');
			}
		}
		if($_GPC['message3'] == 1){
			if(empty($_GPC['message3_content'])){
				message('你启用了选定服务人员短信提醒，选定服务人员提醒内容不能为空');
			}
		}
		if($_GPC['message4'] == 1){
			if(empty($_GPC['message4_content'])){
				message('你启用了外卖下单短信通知，外卖下单短信内容不能为空');
			}
		}
		if($_GPC['message5'] == 1){
			if(empty($_GPC['message5_content'])){
				message('你启用了服务人员确认价格短信通知，确认价格短信内容不能为空');
			}
		}

		$selected = intval($_GPC['selected']);
		$data['platform'] = $_GPC['platform'];
		$data['plat_name'] = $_GPC['plat_name'];
		if(!empty($_GPC['plat_pwd'])){
			$data['plat_pwd'] = md5($_GPC['plat_pwd']);
		}
		$data['qianming'] = $_GPC['qianming'];
		$data['selected'] = $selected;
		$data['message1'] = $_GPC['message1'];
		$data['message1_content'] = $_GPC['message1_content'];
		$data['message2'] = $_GPC['message2'];
		$data['message2_content'] = $_GPC['message2_content'];
		$data['message3'] = $_GPC['message3'];
		$data['message3_content'] = $_GPC['message3_content'];
		$data['message4'] = $_GPC['message4'];
		$data['message4_content'] = $_GPC['message4_content'];
		$data['message5'] = $_GPC['message5'];
		$data['message5_content'] = $_GPC['message5_content'];
		if(empty($id)){
			$data['weid'] = $this->weid;
			$res = pdo_insert('xm_gohome_message',$data);
			if($res){
				if($selected == 1){
					$newId = pdo_insertid();
					pdo_query("update ".tablename('xm_gohome_message')." set selected=0 where weid=".$this->weid." and id !=".$newId);
				}
				message('数据添加成功！', $this->createWebUrl('message', array()), 'success');
			}else{
				message('数据添加失败！');
			}
		}else{
			$res = pdo_update('xm_gohome_message',$data,array('id'=>$id));
			if($res){
				if($selected == 1){
					pdo_query("update ".tablename('xm_gohome_message')." set selected=0 where weid=".$this->weid." and id !=".$id);
				}	
				message('数据修改成功！', $this->createWebUrl('message', array()), 'success');
			}else{
				message('数据修改失败！');
			}
		}
	}
}

if($foo == 'ok2'){
	if(checksubmit('submit')){
		$id 	  = intval($_GPC['id']);
		$platform = $_GPC['platform'];
		if(empty($platform)){
			message('请选择短信平台');
		}
		if(empty($_GPC['plat_name'])){
				message('阿里大鱼的App Key不能为空');
		}
		if(empty($id)){
			if(empty($_GPC['plat_pwd'])){
				message('阿里大鱼的App Serve不能为空');
			}
		}
		
		$qianming = $_GPC['qianming'];
		//$first    = mb_substr($qianming, 0, 1, "UTF-8");
		//$last     = mb_substr($qianming, -1, 1, "UTF-8");
		if(empty($qianming)){
			message('签名不能为空');
		}
		/*
		if($first != "【" || $last != "】"){
			message('签名格式错误,必须以【开头，】结尾');
		}
		*/

		if(empty($_GPC['tempid'])){
			message("短信验证码模板ID不能为空！");
		}

		/*
		if(empty($_GPC['pai_tempid'])){
			message("派单短信模板ID不能为空！");
		}
		*/

		if($_GPC['message1'] == 1){
			if(empty($_GPC['msg1_tempid'])){
				message('下单短信模板ID不能为空');
			}
		}
		if($_GPC['message2'] == 1){
			if(empty($_GPC['msg2_tempid'])){
				message('抢单短信模板ID不能为空');
			}
		}
		if($_GPC['message3'] == 1){
			if(empty($_GPC['msg3_tempid'])){
				message('选定服务人员短信模板ID不能为空');
			}
		}
		if($_GPC['message4'] == 1){
			if(empty($_GPC['msg4_tempid'])){
				message('外卖下单短信模板ID不能为空');
			}
		}
		if($_GPC['message5'] == 1){
			if(empty($_GPC['msg5_tempid'])){
				message('确认价格短信模板ID不能为空');
			}
		}

		$selected = $_GPC['selected'];
		$data['platform'] = $_GPC['platform'];
		$data['plat_name'] = $_GPC['plat_name'];
		if(!empty($_GPC['plat_pwd'])){
			$data['plat_pwd'] = $_GPC['plat_pwd'];
		}
		$data['qianming'] = $_GPC['qianming'];
		$data['selected'] = $selected;
		$data['tempid'] = $_GPC['tempid'];
		$data['code_content'] = $_GPC['code_content'];
		$data['pai_tempid'] = $_GPC['pai_tempid'];
		$data['pai_content'] = $_GPC['pai_content'];

		$data['message1'] = $_GPC['message1'];
		$data['msg1_tempid'] = $_GPC['msg1_tempid'];

		$data['message2'] = $_GPC['message2'];
		$data['msg2_tempid'] = $_GPC['msg2_tempid'];

		$data['message3'] = $_GPC['message3'];
		$data['msg3_tempid'] = $_GPC['msg3_tempid'];

		$data['message4'] = $_GPC['message4'];
		$data['msg4_tempid'] = $_GPC['msg4_tempid'];

		$data['message5'] = $_GPC['message5'];
		$data['msg5_tempid'] = $_GPC['msg5_tempid'];
		if(empty($id)){
			$data['weid'] = $this->weid;
			$res = pdo_insert('xm_gohome_message',$data);
			if($res){
				if($selected == 1){
					$newId = pdo_insertid();
					pdo_query("update ".tablename('xm_gohome_message')." set selected=0 where weid=".$this->weid." and id !=".$newId);
				}message('数据添加成功！', $this->createWebUrl('message', array('foo'=>'aly')), 'success');
			}else{
				message('数据添加失败！');
			}
		}else{
			$res = pdo_update('xm_gohome_message',$data,array('id'=>$id));
			if($res){
				if($selected == 1){
					pdo_query("update ".tablename('xm_gohome_message')." set selected=0 where weid=".$this->weid." and id !=".$id);
				}
				message('数据修改成功！', $this->createWebUrl('message', array('foo'=>'aly')), 'success');
			}else{
				message('数据修改失败！');
			}
		}
	}
}