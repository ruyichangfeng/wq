<?php
global $_W, $_GPC;

checklogin();

$foo = $_GPC['foo'];
$foos = array('index', 'downok', 'ma', 'reset', 'resetok', 'xiu', 'xiuok', 'power');
$foo = in_array($foo, $foos) ? $foo : 'index';

$check = $_W['isfounder'];
if($check != 1){
	message('你不是站长，您没有权限操作！');
	exit();
}

if($foo == 'index') {
    $item = pdo_fetch("select version from ".tablename('xm_gohome_base')." where weid=".$this->weid);
	$old_version = $item['version']*100;
		
	$data['key'] = $this->key_info;
	$data['app'] = 'gohome';
	$url = POSTURL."getver.php";
	$res = $this->post($url, $data, 5);
	$res = str_replace('(','',$res);
	$res = str_replace(')','',$res);
	$arr = json_decode($res,true);
	$new_version = $arr['ver']*100;
	$dis = base64_decode($arr['dis']);
	$key_info = $this->key_info;
	$app = 'gohome';
	
	include $this->template('web/system/version');
}

if($foo == 'ma'){
	include $this->template('web/system/ma');
}

if($foo == 'downok') {
	$check = $_W['isfounder'];
	if($check != 1){
		message('你不是站长，您没有权限操作！');
		exit();
	}
	$old_version = $_GPC['old_version'];
	$singekey = $_GPC['singekey'];
		
	$data['key'] = $this->key_info;
	$data['app'] = 'gohome';
	$data['pre'] = $this->getTablePre();
	$data['old_version'] = $old_version;
	$data['singekey'] = $singekey;
	
	$p_url = POSTURL."updateinfo.php";
	$res = $this->post($p_url, $data, 5);
	$res = str_replace('(','',$res);
	$res = str_replace(')','',$res);			
	$arr = json_decode($res,true);
	$url = base64_decode($arr['url']);
	$sql = base64_decode($arr['sql']);
		
	if($url==''){
		message('更新失败！',$this->createWebUrl('version',array('foo'=>'index')), 'error');
		exit();
	}
	$ver = $arr['ver']/100;
	$info = $this->version_down($url,$ver,$sql);
	if($info == 1){
		$msg = '更新成功！';
		include $this->template('web/system/version-info');
	}elseif($info == 2){
		message('更新失败，下载路径为空，请重试！',$this->createWebUrl('Version',array()), 'error');
	}elseif($info == 3){
		message('更新失败，文件下载格式不正确，请重试！',$this->createWebUrl('Version',array()), 'error');
	}elseif($info == 4){
		message('更新失败，文件夹权限不够，请重试！',$this->createWebUrl('Version',array()), 'error');
	}else{
		message('更新失败，请重试！',$this->createWebUrl('Version',array()), 'error');
	}
}

if($foo == 'reset'){
	$check = $_W['isfounder'];
	if($check != 1){
		message('你不是站长，您没有权限操作！');
		exit();
	}
	include $this->template('web/system/reset');
}

if($foo == 'resetok'){
	$check = $_W['isfounder'];
	if($check != 1){
		echo 0;
	}else{
		pdo_delete('xm_gohome_attend', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_card', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_code', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_comment', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_commentreply', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_companygetmoney', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_companygetmoney_merchant', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_falog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_grab', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_invite', array('weid'=>$this->weid));

		pdo_delete('xm_gohome_moneylog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_msglog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_needgrab', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_needmsglog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_needorder', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_order', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_paylog', array('weid'=>$this->weid));
		
		pdo_delete('xm_gohome_rechargelog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_userfrontlog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_tixianlog', array('weid'=>$this->weid));
		
		pdo_query("delete from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=0");
		pdo_query("delete from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and delstate=0");
		pdo_query("delete from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and delstate=0");
		
		$arr = pdo_fetchall("select temp_token from ".tablename('xm_gohome_temp')." where weid=".$this->weid." and delstate=1");
		if(!empty($arr)){
			foreach ($arr as $val) {
				$tablename = 'xm_gohome_'.$val['temp_token'];
				pdo_delete($tablename, array('weid'=>$this->weid));				
			}
		}

		pdo_delete('xm_gohome_takeorder', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_takeorderitem', array('weid'=>$this->weid));
		//pdo_delete('xm_gohome_takeaddress', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_takegetlog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_takekeep', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_takepaylog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_zanlog', array('weid'=>$this->weid));
		pdo_delete('xm_gohome_tixianlog_merchant', array('weid'=>$this->weid));

		//$data['money'] = 0;
		$data['get_order'] = 0;
		$data['grab_order'] = 0;
		$data['good'] = 0;
		$data['center'] = 0;
		$data['bad'] = 0;
		$data['xing'] = 0;
		$data['cperson'] = 0;
		$data['grade_id'] = 0;
		$data['grade_money'] = 0;
		pdo_update('xm_gohome_staff',$data, array('weid'=>$this->weid));

		echo 1;
	}
}

if($foo == 'xiu'){
	$check = $_W['isfounder'];
	if($check != 1){
		message('你不是站长，您没有权限操作！');
		exit();
	}
	include $this->template('web/system/xiu');
}

if($foo == 'xiuok'){
	$check = $_W['isfounder'];
	if($check != 1){
		echo 0;
	}else{
		repair();
		echo 1;
	}
}

if($foo == "power"){
	message('正在开发中...');
}
?>