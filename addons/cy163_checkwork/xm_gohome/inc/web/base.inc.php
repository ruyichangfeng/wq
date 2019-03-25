<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('list', 'addok', 'running', 'runningok', 'diy', 'diyok', 'question', 'questionok', 'shuoming', 'shuomingok', 'geren', 'gerenok', 'fuwu', 'fuwuok');
$foo = in_array($foo, $foos) ? $foo : 'list';

if($foo == 'list') {
	pdo_query("delete from ".tablename('xm_gohome_base')." where weid < 1");

    $item = pdo_fetch("select * from ".tablename('xm_gohome_base')." where weid=".$_W['uniacid']);
    
    $list3 = pdo_fetchall("select id,adr_name from ".tablename('xm_gohome_address')." where weid=".$_W['uniacid']." order by id desc");
	
	if(empty($item['id']))
	{
		$data_p['site'] = $_SERVER['HTTP_HOST'];
		$url = POSTURL."getkey.php";
		$res = $this->post($url, $data_p, 5);
		$res = str_replace('(','',$res);
		$res = str_replace(')','',$res);
		$arr = json_decode($res,true);
		
		$data['weid'] = $this->weid;
		$data['lead'] = '';
        $data['yuming'] = '/';
        $data['lng'] = '111.310981';
		$data['lat'] = '30.732758';
		$data['key_info'] = $arr['key'];
		if(!empty($_W['uniacid'])){
			$result = pdo_insert('xm_gohome_base',$data);
		}
    }
	$getLat = array('lng'=>$item['lng'], 'lat'=>$item['lat']);
		
	load()->func('tpl');
		
	include $this->template('web/base/index');
}

if($foo == 'addok') {
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		if(empty($_GPC['bili'])){
			$bili = 1;
		}else{
			$bili = $_GPC['bili'];
		}
		$location = $_GPC['location'];
		if(empty($location['lng'])){
			$lng = '116.403963';
		}else{
			$lng = $location['lng'];
		}
		if(empty($location['lat'])){
			$lat = '39.923966';
		}else{
			$lat = $location['lat'];
		}
		if(empty($_GPC['yuming'])){
			$yuming = "/";
		}else{
			$yuming = $_GPC['yuming'];
		}
		if(empty($_GPC['title'])){
			$title = "幸福到家";
		}else{
			$title = $_GPC['title'];
		}
		if(empty($_GPC['icon_name'])){
			$icon_name = "外卖服务";
		}else{
			$icon_name = $_GPC['icon_name'];
		}
		$data_p['site'] = $_SERVER['HTTP_HOST'];
		$url = POSTURL."getkey.php";
		$res = $this->post($url, $data_p, 5);
		$res = str_replace('(','',$res);
		$res = str_replace(')','',$res);
		$arr = json_decode($res,true);
		
		$data['bili'] = $bili;
		$data['lead'] = $_GPC['lead'];
		$data['lng'] = $lng;
		$data['lat'] = $lat;
		$data['yuming'] = $yuming;
		$data['logo'] = $_GPC['logo'];
		$data['title'] = $title;
		$data['key_info'] = $arr['key'];
		$data['xianzhi'] = $_GPC['xianzhi'];
		$data['banquan'] = htmlspecialchars_decode($_GPC['banquan']);
		$data['ak'] = $_GPC['ak'];
		$data['qq_ak'] = $_GPC['qq_ak'];
		$data['pai_temp'] = $_GPC['pai_temp'];
		$data['authen'] = $_GPC['authen'];
		$data['sauthen'] = $_GPC['sauthen'];
		$data['timeout'] = $_GPC['timeout'];
		$data['examine'] = $_GPC['examine'];
		$data['cash'] = $_GPC['cash'];
		$data['tuistate'] = $_GPC['tuistate'];
		$data['pai_temp'] = $_GPC['pai_temp'];
		$data['type'] = $_GPC['type'];
		$data['type_id'] = $_GPC['type_id'];
		$data['diywait'] = $_GPC['diywait'];
		$data['diypay'] = $_GPC['diypay'];
		$data['diygrab'] = $_GPC['diygrab'];
		$data['diyyes'] = $_GPC['diyyes'];
		$data['catch_bg'] = $_GPC['catch_bg'];
		$data['takeout_icon'] = $_GPC['takeout_icon'];
		$data['icon_name'] = $icon_name;
		$data['page'] = $_GPC['page'];
		$data['search'] = $_GPC['search'];
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_base',$data);
			if($result){
				message('添加数据成功！', $this->createWebUrl('Base', array()), 'success');
			}else{
				message('添加数据失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_base', $data, array('id'=>$id));
			if($result){
				message('修改数据成功！', $this->createWebUrl('base', array()), 'success');
			}else{
				message('修改数据失败！');
			}
		}
	}
}

if($foo == "running"){

	$item = pdo_fetch("select id,type,type_id from ".tablename('xm_gohome_base')." where weid=".$_W['uniacid']);

	$list = pdo_fetchall("select id,type_name from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and child_num=0 and delstate=1");

	include $this->template('web/base/running');
}

if($foo == "runningok"){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		
		$data['type'] = $_GPC['type'];
		$data['type_id'] = $_GPC['type_id'];
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_base',$data);
			if($result){
				message('运营配置成功！', $this->createWebUrl('base', array('foo'=>'running')), 'success');
			}else{
				message('运营配置失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_base', $data, array('id'=>$id));
			if($result){
				message('运营配置修改成功！', $this->createWebUrl('base', array('foo'=>'running')), 'success');
			}else{
				message('运营配置修改失败！');
			}
		}
	}
}

if($foo == "diy"){

	$item = pdo_fetch("select * from ".tablename('xm_gohome_base')." where weid=".$_W['uniacid']);

	include $this->template('web/base/diy');
}

if($foo == "diyok"){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		
		if(empty($_GPC['icon_name'])){
			$icon_name = "外卖服务";
		}else{
			$icon_name = $_GPC['icon_name'];
		}
		$data['diywait']  = $_GPC['diywait'];
		$data['diypay']   = $_GPC['diypay'];
		$data['diygrab']  = $_GPC['diygrab'];
		$data['diyyes']   = $_GPC['diyyes'];
		$data['catch_bg'] = $_GPC['catch_bg'];
		$data['takeout_icon'] = $_GPC['takeout_icon'];
		$data['icon_name'] = $icon_name;
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_base',$data);
			if($result){
				message('个性化自定义配置成功！', $this->createWebUrl('base', array('foo'=>'diy')), 'success');
			}else{
				message('个性化自定义配置失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_base', $data, array('id'=>$id));
			if($result){
				message('个性化自定义配置修改成功！', $this->createWebUrl('base', array('foo'=>'diy')), 'success');
			}else{
				message('个性化自定义配置修改失败！');
			}
		}
	}
}

if($foo == 'question'){

	$item = pdo_fetch("select * from ".tablename('xm_gohome_question')." where weid=".$_W['uniacid']);
	load()->func('tpl');
		
	include $this->template('web/base/question');
}

if($foo == 'questionok'){
	if(checksubmit('submit')){
		$id = intval($_GPC['id']);
		if(empty($_GPC['q_name'])){
			message('名称不能为空！');
		}
		if(empty($_GPC['question'])){
			message('常见问题不能为空！');
		}
			
		$data['q_name'] = $_GPC['q_name'];
		$data['question'] = htmlspecialchars_decode($_GPC['question']);
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_question',$data);
			if($result){
				message('常见问题添加成功！', $this->createWebUrl('base', array('foo'=>'question')), 'success');
			}else{
				message('常见问题添加失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_question', $data, array('id'=>$id));
			if($result){
				message('常见问题修改成功！', $this->createWebUrl('base', array('foo'=>'question')), 'success');
			}else{
				message('常见问题修改失败！');
			}
		}
	}
}

if($foo == 'shuoming'){

	$item = pdo_fetch("select * from ".tablename('xm_gohome_shuoming')." where weid=".$_W['uniacid']);
	load()->func('tpl');
		
	include $this->template('web/base/shuoming');
}

if($foo == 'shuomingok'){
	if(checksubmit()){
		$id = intval($_GPC['id']);
		if(empty($_GPC['s_name'])){
			message('名称不能为空！');
		}
		if(empty($_GPC['shuoming'])){
			message('说明内容不能为空！');
		}
			
		$data['s_name'] = $_GPC['s_name'];
		$data['shuoming'] = htmlspecialchars_decode($_GPC['shuoming']);
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_shuoming',$data);
			if($result){
				message('添加服务说明成功！', $this->createWebUrl('base', array('foo'=>'shuoming')), 'success');
			}else{
				message('添加服务说明失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_shuoming', $data, array('id'=>$id));
			if($result){
				message('修改服务说明成功！', $this->createWebUrl('base', array('foo'=>'shuoming')), 'success');
			}else{
				message('修改服务说明失败！');
			}
		}
	}
}

if($foo == 'geren'){

	$item = pdo_fetch("select * from ".tablename('xm_gohome_xieyi')." where weid=".$_W['uniacid']." and type=1");
	load()->func('tpl');
		
	include $this->template('web/base/geren');
}

if($foo == 'gerenok'){
	if(checksubmit()){
		$id = intval($_GPC['id']);
		if(empty($_GPC['xieyi_content'])){
			message('协议内容不能为空！');
		}
		$data['type'] = 1;
		$data['xieyi_content'] = htmlspecialchars_decode($_GPC['xieyi_content']);
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_xieyi',$data);
			if($result){
				message('添加个人加盟协议成功！', $this->createWebUrl('base', array('foo'=>'geren')), 'success');
			}else{
				message('添加个人加盟协议失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_xieyi', $data, array('id'=>$id));
			if($result){
				message('修改个人加盟协议成功！', $this->createWebUrl('base', array('foo'=>'geren')), 'success');
			}else{
				message('修改个人加盟协议失败！');
			}
		}
	}
}

if($foo == 'fuwu'){

	$item = pdo_fetch("select * from ".tablename('xm_gohome_xieyi')." where weid=".$_W['uniacid']." and type=2");
	load()->func('tpl');
		
	include $this->template('web/base/fuwu');
}

if($foo == 'fuwuok'){
	if(checksubmit()){
		$id = intval($_GPC['id']);
		if(empty($_GPC['xieyi_content'])){
			message('协议内容不能为空！');
		}
		$data['type'] = 2;
		$data['xieyi_content'] = htmlspecialchars_decode($_GPC['xieyi_content']);
		if(empty($id)){
			$data['weid'] = $this->weid;
			$result = pdo_insert('xm_gohome_xieyi',$data);
			if($result){
				message('添加服务商加盟协议成功！', $this->createWebUrl('base', array('foo'=>'fuwu')), 'success');
			}else{
				message('添加服务商加盟协议失败！');
			}
		}else{
			$result = pdo_update('xm_gohome_xieyi', $data, array('id'=>$id));
			if($result){
				message('修改服务商加盟协议成功！', $this->createWebUrl('base', array('foo'=>'fuwu')), 'success');
			}else{
				message('修改服务商加盟协议失败！');
			}
		}
	}
}

?>