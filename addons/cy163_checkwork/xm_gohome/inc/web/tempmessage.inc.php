<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'add', 'addok', 'edit', 'editok', 'delete', 'default', 'defaultok');
$foo = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('xm_gohome_tempmessage')." WHERE weid =".$this->weid." ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.",{$psize}");

	if (!empty($list)) {
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_tempmessage')." WHERE weid = ".$this->weid." ORDER BY id DESC");
		$pager = pagination($total, $pindex, $psize);			
		unset($row);
	}
		
	include $this->template('web/tempmessage/message-list');
}

if($foo == 'add'){

	include $this->template('web/tempmessage/message-add');
}

if($foo == 'addok'){
	if(checksubmit('submit')){
		if(empty($_GPC['message_name'])){
			message('模板消息名称不能为空！');
		}
		if(empty($_GPC['msg_id'])){
			message('模板编号不能为空！');
		}
		if(empty($_GPC['dataname'])){
			message('模板参数不能为空！');
		}
		if(empty($_GPC['datavalue'])){
			message('模板参数值不能为空！');
		}
		if(empty($_GPC['color_title'])){
			$color_title = '#FF0000';
		}else{
			$color_title = $_GPC['color_title'];
		}
		if(empty($_GPC['color_content'])){
			$color_content = '#173177';
		}else{
			$color_content = $_GPC['color_content'];
		}
		$check = pdo_fetch("select id from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and message_name='".$_GPC['message_name']."'");
		if(empty($check)){
			
			$app = 'gohome';
			$weid = $this->weid;
			$key_info = $this->key_info;
			$data['app'] = 'gohome';
			$data['key'] = $key_info;
			$data['tmpid'] = $_GPC['msg_id'];
			$data['color_title'] = $color_title;
			$data['color_content'] = $color_content;
			$data['dataname'] = trim($_GPC['dataname']);
			$data['datavalue'] = trim($_GPC['datavalue']);
				
			$url = POSTURL."creattmpmsg.php";
			$res = $this->post($url, $data, 5);
			$res = str_replace('(','',$res);
			$res = str_replace(')','',$res);
			$arr = json_decode($res,true);

			if($res == ''){
				message('模板消息添加失败！');
			}else{
				$data1['weid'] = $this->weid;
				$data1['message_name'] = $_GPC['message_name'];
				$data1['msg_id'] = $_GPC['msg_id'];
				$data1['color_title'] = $color_title;
				$data1['color_content'] = $color_content;
				$data1['dataname'] = $_GPC['dataname'];
				$data1['datavalue'] = $_GPC['datavalue'];
				$data1['msg_content'] = $arr['tmpstr'];
				$result = pdo_insert('xm_gohome_tempmessage',$data1);
				if($result){
					message('模板消息添加成功！', $this->createWebUrl('tempmessage', array('foo'=>'index')), 'success');
				}else{
					message('模板消息添加失败！');
				}
			}
		}else{
			message('该模板消息名称已存在！');
		}
	}
}

if($foo == 'edit'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('参数错误：未获取到ID');
		exit();
	}
	$item = pdo_fetch("select * from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and id=".$id);
		
	include $this->template('web/tempmessage/message-edit');
}

if($foo == 'editok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		if(empty($_GPC['message_name'])){
			message('模板消息名称不能为空！');
		}
		if(empty($_GPC['msg_id'])){
			message('模板编号不能为空！');
		}
		if(empty($_GPC['dataname'])){
			message('模板参数不能为空！');
		}
		if(empty($_GPC['datavalue'])){
			message('模板参数值不能为空！');
		}
		if(empty($_GPC['color_title'])){
			$color_title = '#FF0000';
		}else{
			$color_title = $_GPC['color_title'];
		}
		if(empty($_GPC['color_content'])){
			$color_content = '#173177';
		}else{
			$color_content = $_GPC['color_content'];
		}
		$check = pdo_fetch("select id from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and message_name='".$_GPC['message_name']."' and id !=".$id);
		if(empty($check)){

			$app = 'gohome';
			$weid = $this->weid;
			$key_info = $this->key_info;
			$data['app'] = 'gohome';
			$data['key'] = $key_info;
			$data['tmpid'] = $_GPC['msg_id'];
			$data['color_title'] = $color_title;
			$data['color_content'] = $color_content;
			$data['dataname'] = $_GPC['dataname'];
			$data['datavalue'] = $_GPC['datavalue'];
			$url = POSTURL."creattmpmsg.php";
			$res = $this->post($url, $data, 5);
			$res = str_replace('(','',$res);
			$res = str_replace(')','',$res);
			$arr = json_decode($res,true);
				
			$data1['message_name'] = $_GPC['message_name'];
			$data1['msg_id'] = $_GPC['msg_id'];
			$data1['color_title'] = $color_title;
			$data1['color_content'] = $color_content;
			$data1['dataname'] = trim($_GPC['dataname']);
			$data1['datavalue'] = trim($_GPC['datavalue']);
			$data1['msg_content'] = $arr['tmpstr'];
			$result = pdo_update('xm_gohome_tempmessage',$data1, array('id'=>$id));
			if($result){
				message('模板消息修改成功！', $this->createWebUrl('tempmessage', array('foo'=>'index')), 'success');
			}else{
				message('模板消息修改失败！');
			}
		}else{
			message('该模板消息名称已存在！');
		}
	}
}

if($foo == 'delete'){
	
	$id = intval($_GPC['id']);
	$res = pdo_delete('xm_gohome_tempmessage', array('id'=>$id));
	if($res){
		message('删除成功！', $this->createWebUrl('tempmessage', array('foo'=>'index')), 'success');
	}else{
		message('删除失败！');
	}
}

if($foo == 'default'){
	$list = pdo_fetchall("select id,message_name from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid);
	
	$item= pdo_fetch("select * from ".tablename('xm_gohome_tempmessagedefault')." where weid=".$this->weid);
		
	include $this->template('web/tempmessage/message-default');
}

if($foo == 'defaultok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
			
		$data['stmpmsg_id'] = $_GPC['stmpmsg_id'];
		$data['ctmpmsg_id'] = $_GPC['ctmpmsg_id'];
		$data['mtmpmsg_id'] = $_GPC['mtmpmsg_id'];
		$data['otmpmsg_id'] = $_GPC['otmpmsg_id'];
		$data['qtmpmsg_id'] = $_GPC['qtmpmsg_id'];
		$data['xtmpmsg_id'] = $_GPC['xtmpmsg_id'];
		$data['wtmpmsg_id'] = $_GPC['wtmpmsg_id'];
		$data['ttmpmsg_id'] = $_GPC['ttmpmsg_id'];
		$data['utmpmsg_id'] = $_GPC['utmpmsg_id'];
		$data['needtmpmsg_id'] = $_GPC['needtmpmsg_id'];
		$data['grabtmpmsg_id'] = $_GPC['grabtmpmsg_id'];
		$data['quetmpmsg_id'] = $_GPC['quetmpmsg_id'];
		$data['suretmpmsg_id'] = $_GPC['suretmpmsg_id'];
			
		if(empty($id)){
			$data['weid'] = $this->weid;
			$res = pdo_insert('xm_gohome_tempmessagedefault',$data);
			if($res){
				message('添加成功！', $this->createWebUrl('Tempmessage', array('foo'=>'default')), 'success');
			}else{
				message('添加失败！');
			}
		}else{
			$res = pdo_update('xm_gohome_tempmessagedefault',$data, array('id'=>$id));
			if($res){
				message('修改成功！', $this->createWebUrl('tempmessage', array('foo'=>'default')), 'success');
			}else{
				message('修改失败！');
			}
		}	
	}
}

?>