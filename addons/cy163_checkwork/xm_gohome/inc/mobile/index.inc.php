<?php
global $_W, $_GPC;

$this->checkreg();

$foo  = $_GPC['foo'];
$foos = array('index', 'child', 'city', 'scanlist', 'adrstr');
$foo  = in_array($foo, $foos) ? $foo : 'index';

if($foo == 'index') {

	$adv = pdo_fetchall("select * from ".tablename('xm_gohome_adv')." where weid=".$this->weid." and stop = 1 and show_adr ='shouye' order by top asc");
	//超链接项目
	$clist = pdo_fetchall("select * from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and chao=1 and stop=1 and parent_id=0 and delstate=1 order by top asc limit 0,4");
	//1
	$list1 = pdo_fetchall("select * from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and chao=0 and stop=1 and parent_id=0 and delstate=1 order by top asc");

	$list = pdo_fetchall("select * from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and stop=1 and parent_id=0 and delstate=1 order by top asc");
	//2
	$list2_1 = pdo_fetchall("select * from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and stop=1 and parent_id=0 and delstate=1 order by top asc limit 0,4");
	$list2_2 = pdo_fetchall("select * from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and stop=1 and parent_id=0 and delstate=1 order by top asc limit 5,30");

	//3
	$list3_1 = pdo_fetchall("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and stop=1 and delstate=1 order by id desc");
    $list3_2 = pdo_fetchall("select id,merchant_name,coverpic,merchant_song from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and stop=1 and state=1 and delstate=1 and top1 =1 order by ordersum desc");

    //推荐员工
	$slist = pdo_fetchall("select id,staff_name,avatar from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and flag=1 and stop=1 and delstate=1 and indextop=1 order by addtime desc limit 0,6");
	//推荐服务
	$glist = pdo_fetchall("select * from ".tablename('xm_gohome_gg')." where weid=".$this->weid." and stop=1 and gg_adr='shouye' order by top asc");

	$check = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1");
	$url = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&foo=scanlist&do=needs&";

	if($this->getBase('type') == 0){
		$page = 'index';

		$file_path = MODULE_ROOT."/template/mobile/".$_W['uniacid']."/u_index.html";
		if(file_exists($file_path)){
			include $this->template($_W['uniacid'].'/u_index');
		}else{
			include $this->template('u_notemp');
		}
 
	}else{
		header("Location:".$this->createMobileUrl('templateok', array('foo'=>'index', 'id'=>$this->getBase('type_id')))."");
	}
}

if($foo == 'child'){
	$parent_id = $_GPC['parent_id'];
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and stop=1 and parent_id=".$parent_id." and delstate=1 order by top asc");
		
	$page = 'index';
		
	include $this->template($this->temp.'_child');
}

if($foo == 'city'){
	$list = pdo_fetchall("select * from ".tablename('xm_gohome_address')." where weid=".$this->weid." and stop=1 and delstate=1 order by addtime desc");
	$url  = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=index&m=xm_gohome";
	$page = 'index';
		
	include $this->template($this->temp.'_city');
}

if($foo == 'adrstr'){
	$lat = $_GPC['lat'];
	$lng = $_GPC['lng'];

	$adrstr = $this->encode_geohash($lat,$lng,12);
	$check = pdo_get('xm_gohome_adrstr', array('weid'=>$_W['uniacid']), array('id','adrstr'));
	if(empty($check)){
		$data['weid'] = $_W['uniacid'];
		$data['lat']  = $lat;
		$data['lng']  = $lng;
		$data['adrstr'] = $adrstr;
		pdo_insert('xm_gohome_adrstr', $data);
	}else{
		$data['adrstr'] = $adrstr;
		$data['lat']  = $lat;
		$data['lng']  = $lng;
		pdo_update('xm_gohome_adrstr', $data, array('id'=>$check['id']));
	}
}


?>