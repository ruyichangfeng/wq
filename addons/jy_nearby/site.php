<?php
/**
 * 附近门店模块微站定义
 *
 * @author Walter
 * @url http://anonymous.orz.xyz/
 */
defined('IN_IA') or exit('Access Denied');
define('SETTING_TABLE', 'jy_nearby_setting');
define('BANNER_TABLE', 'jy_nearby_banner');
define('INDEX_TABLE', 'jy_nearby_index');
define('CLASS_TABLE', 'jy_nearby_class');
define('STORE_TABLE', 'jy_nearby_store');
define('STORE_ATTR_TABLE', 'jy_nearby_store_attr');
define('USER_TABLE', 'jy_nearby_user');
define('USER_ATTR_TABLE', 'jy_nearby_user_attr');
define('COMMENTS_TABLE', 'jy_nearby_comments');
define('MENU_TABLE', 'jy_nearby_menu');
define('NEARBY_CSS', '../addons/jy_nearby/static/css/');
define('NEARBY_JS', '../addons/jy_nearby/static/js/');
define('NEARBY_IMAGE', '../addons/jy_nearby/static/images/');
define('STAT_TABLE', 'jy_nearby_stat');
define('PSIZE', '2000');
if($_W['container'] == 'wechat'){
	define('WEIXIN', '1');
}else{
	define('WEIXIN', '2');
}


class Jy_nearbyModuleSite extends WeModuleSite {
	//首页获取地理位置
	public function doMobileIndex() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$ak = $setting['bdak'];
		include $this->template('getLoc');
	}
	public function dowebsetting2()
	{
		global $_W,$_GPC;
		if(!pdo_tableexists('jy_nearby_store_attr')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_store_attr')." (
		      	`id` int(11) NOT NULL AUTO_INCREMENT,
				`weid` int(11) NOT NULL,
				`storeid` int(11) NOT NULL,
				`btncon` varchar(255) NOT NULL COMMENT '按钮',
				`content` varchar(255) NOT NULL COMMENT '文案内容',
				`url` varchar(255) NOT NULL COMMENT '链接',
				`createtime` int(11) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_tableexists('jy_nearby_attr')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_attr')." (
		  	 	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  	`weid` int(11) unsigned NOT NULL COMMENT '所属账号',
			  	`name` varchar(50) NOT NULL COMMENT '名称',
			  	`parentid` int(10) unsigned NOT NULL COMMENT '批次ID,0为第一级',
			  	`displayorder` tinyint(3) unsigned NOT NULL COMMENT '排序',
			  	`description` varchar(255) NOT NULL COMMENT '描述',
			  	`type` tinyint(1) unsigned NOT NULL COMMENT '1多选，2填空，3下拉菜单，4市区街道 , 5三级联动 , 6手机 , 7姓名',
			  	`enabled` tinyint(1) unsigned NOT NULL COMMENT '是否开启',
			  	PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_tableexists('jy_nearby_set_attr')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_set_attr')." (
		  	 		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  	`weid` int(11) unsigned NOT NULL,
				  	`setid` int(11) unsigned NOT NULL,
				  	`attr_id` int(11) unsigned NOT NULL COMMENT '自定义字段ID',
				  	`enabled` tinyint(1) unsigned NOT NULL,
				  	`createtime` varchar(20) NOT NULL,
				  	PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_tableexists('jy_nearby_attr_value')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_attr_value')." (
			 		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  	`weid` int(10) unsigned NOT NULL,
				  	`setid` int(11) unsigned NOT NULL,
				  	`attr_id` int(11) unsigned NOT NULL,
				  	`createtime` varchar(20) NOT NULL,
				  	`zhi` text,
				  	`mid` varchar(255) NOT NULL,
				  	`state` tinyint(1) unsigned NOT NULL COMMENT '状态0:审核中 1:通过 2:不通过',
				  	PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_tableexists('jy_nearby_business')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_business')." (
		 			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  	`weid` int(11) unsigned NOT NULL,
				  	`oid` varchar(100) NOT NULL COMMENT 'openid',
				  	`createtime` varchar(20) NOT NULL,
				  	PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_tableexists('jy_nearby_business')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_business')." (
		 			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  	`weid` int(11) unsigned NOT NULL,
				  	`oid` varchar(100) NOT NULL COMMENT 'openid',
				  	`createtime` varchar(20) NOT NULL,
				  	PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_tableexists('jy_nearby_comments')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_comments')." (
		 			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `weid` int(11) unsigned NOT NULL,
					  `store_id` int(11) unsigned NOT NULL,
					  `user_id` int(11) unsigned NOT NULL,
					  `uid` int(11) unsigned NOT NULL,
					  `nickname` varchar(255) NOT NULL,
					  `content` text NOT NULL,
					  `deleted` tinyint(4) unsigned NOT NULL,
					  `updatetime` varchar(50) NOT NULL,
					  `createtime` varchar(50) NOT NULL,
					  PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_tableexists('jy_nearby_menu')){
		    $sql ="CREATE TABLE ".tablename('jy_nearby_menu')." (
		 			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `weid` int(11) unsigned NOT NULL,
					  `displayorder` int(11) unsigned NOT NULL DEFAULT '0',
					  `name` varchar(255) NOT NULL,
					  `thumb` varchar(255) NOT NULL,
					  `url` varchar(255) NOT NULL,
					  `description` varchar(255) NOT NULL,
					  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
					  PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		    pdo_query($sql);
		}

		if(!pdo_fieldexists('jy_nearby_store', 'isopenm')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `isopenm` tinyint(4) NOT NULL DEFAULT '0';");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'mdwz')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `mdwz` varchar(50) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'displayorder')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `displayorder` int(11) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'pcharge')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `pcharge` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'ptel')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `ptel` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'menuone')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `menuone` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'menuurlone')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `menuurlone` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'menuonelogo')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `menuonelogo` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'menutwo')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `menutwo` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'menuurltwo')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `menuurltwo` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'menutwologo')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `menutwologo` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_one')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_one` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_url_one')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_url_one` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_logo_one')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_logo_one` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_two')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_two` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_url_two')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_url_two` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_logo_two')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_logo_two` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'isopen')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `isopen` tinyint(4) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'openpic')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `openpic` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'formthumb')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `formthumb` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'mapkey')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `mapkey` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'sort')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `sort` tinyint(4) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'lbs_scope')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `lbs_scope` float(11,2) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_class', 'thumb')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_class')." ADD `thumb` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_class', 'turl')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_class')." ADD `turl` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_class', 'parentid')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_class')." ADD `parentid` int(11) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_class', 'icon')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_class')." ADD `icon` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_three')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_three` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_url_three')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_url_three` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_logo_three')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_logo_three` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_four')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_four` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_url_four')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_url_four` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_store', 'custom_logo_four')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_store')." ADD `custom_logo_four` varchar(255) NOT NULL  ;");
		}
		if(!pdo_fieldexists('jy_nearby_setting', 'loadding')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `loadding` varchar(255) NOT NULL  ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'index_back')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `index_back` tinyint(4) NOT NULL   ;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'index_back_thumb')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `index_back_thumb` varchar(255) NOT NULL;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'is_menu')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `is_menu` tinyint(4) unsigned NOT NULL;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'is_commen')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `is_commen` tinyint(4) unsigned NOT NULL;");
		}

		if(!pdo_fieldexists('jy_nearby_setting', 'bdak')) {
			pdo_query("ALTER TABLE ".tablename('jy_nearby_setting')." ADD `bdak` varchar(255) NOT NULL;");
		}

		message("更新成功!",$this->createWebUrl('setting'),'success');
	}

	//处理距离问题
	public function doMobilegetlalo(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$latitude = $_GPC['latitude'];
		$longitude = $_GPC['longitude'];
		$posit = $this->Convert_GCJ02_To_BD09($latitude,$longitude);
		$_SESSION['posi']= $posit;
		$_SESSION['chatp']=array(
			'latitude'=>$latitude,
			'longitude'=>$longitude,
			);
		$returns=array(
			'latitude'=>$posit['lat'],
			'longitude'=>$posit['lng'],
			'statue'=>1
			);
		echo json_encode($returns);
	}


	public function __cull($latitude,$longitude){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$userinfo = $_SESSION['userinfo'];
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, "http://api.map.baidu.com/geocoder?location={$latitude},{$longitude}&output=xml&key=28bcdd84fae25699606ffad27f8da77b");  
		curl_setopt($ch, CURLOPT_HEADER, false);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出  
		$result=curl_exec($ch);
		curl_close($ch);
		$xml = simplexml_load_string($result);
		$data = json_decode(json_encode($xml),TRUE);
		$city = $data['result']['addressComponent']['city'];
		$province = $data['result']['addressComponent']['province'];
		$dist = $data['result']['addressComponent']['district'];
		//print_r($data);exit();
		if($data['status']=='OK'){
			$datas = array(
				'weid'=>$weid,
				'city'=>$city,
				'province'=>$province,
				'mid'=>$userinfo['id'],
				'createtime'=>TIMESTAMP
				);
			pdo_insert(STAT_TABLE,$datas);
			$_SESSION['statid'] = pdo_insertid();
			$update = array(
				'province'=>$province,
				'city'=>$city,
				'district'=>$dist,
				);
			pdo_update(USER_ATTR_TABLE,$update,array('weid'=>$weid,'mid'=>$_SESSION['userinfo']['id']));
		}
	}

	//首页显示
	public function doMobileshowindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];

		/*$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息*/
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$condition = '';
		if(!empty($_GPC['keyword']))
        {
        	$condition.=" AND storename LIKE '%{$_GPC['keyword']}%' ";
        }

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}

		
		//分类信息
		$csql = "SELECT id,catename FROM ".tablename(CLASS_TABLE)." WHERE weid='{$weid}' AND parentid=0 ORDER BY displayorder DESC,id DESC";
		$clist = pdo_fetchall($csql);
		$jsinfo = json_encode($clist);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		//$lbs_scope = $setting['lbs_scope'];
		
		/*获取幻灯片*/
		$sql = "select * from ".tablename(BANNER_TABLE)." where weid='{$weid}' and status=1";
		$baners = pdo_fetchall($sql);

		/*获取首页导航*/
		$sql_type = "select * from ".tablename(INDEX_TABLE)." where weid='{$weid}' and enabled=1 ORDER BY displayorder DESC,id DESC";
		$types = pdo_fetchall($sql_type);

		/*获取门店信息*/
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 ".$condition." order by displayorder desc,id desc limit 0,{$psize}";
		$stores = pdo_fetchall($stores_sql);
		/*处理门店距离*/
		if($sta==1){
			foreach ($stores as $k => $v) {
				if($v['lat']&&$v['lng']){
					$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
					$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
					$stores[$k]['disc'] = round(($discont/1000),2);
					/*if($lbs_scope > 0){
						if($stores[$k]['disc'] > $lbs_scope){
							unset($stores[$k]);
						}
						
					}*/
				}
			}
		}
		//判断设置的排序方式如果是按距离
		if($setting['sort'] == 1){
			$stores = $this->array_sort($stores,'disc');
		}

		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename(MENU_TABLE)." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		
		include $this->template('index');
	}
	//根据分类获取门店信息
	public function doMobileclassinfo(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		// $this->_Auth();//获取用户信息
		// $this->__douser();//存储用户信息
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//$lbs_scope = $setting['lbs_scope'];
		$condition = '';

		$class_id = intval($_GPC['clid']);
		if($class_id > 0){
			$condition .= " AND mdcateid='{$class_id}'";
			//查找子分类
			$ch_list = pdo_fetchall("SELECT id FROM ".tablename(CLASS_TABLE)." WHERE weid='{$weid}' AND parentid='{$class_id}'");
			foreach($ch_list as $ck => $cv){
				$condition .= " OR mdcateid= ".$cv['id'];
			}
		}
		

		/*获取门店信息*/
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 ".$condition." order by displayorder desc,id desc";
		$stores = pdo_fetchall($stores_sql);
		
		/*处理门店距离*/
		foreach ($stores as $k => $v) {
			if($v['lat']&&$v['lng']){
				$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
				$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
				$stores[$k]['disc'] = round(($discont/1000),2);
				/*if($lbs_scope > 0){
					if($stores[$k]['disc'] > $lbs_scope){
						unset($stores[$k]);
					}
					
				}*/
			}
		}

		//判断设置的排序方式如果是按距离
		if($setting['sort'] == 1){
			$stores = $this->array_sort($stores,'disc');
		}

		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

				if(!$va['storelogo']){
					if(!$setting['avar']){
						$logo=NEARBY_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['storelogo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">';
				$storename =  mb_substr($va['storename'],0,12,'utf-8');
				$div .= $va['storename'].'</h3><p>';
				$address = mb_substr($va['province'].$va['city'].$va['address'],0,18,'utf-8');
				$div .= $address.'...</p></div>';
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				if($va['disc']){
					$div .= '<div class="disc" style="background-color:'.$color.'"><span style="color:#fff;">'.$va['disc'].'km</span></div></div>';
				}
				if(!empty($va['custom_one']) && empty($va['custom_two']) && empty($va['custom_three']) && empty($va['custom_four'])){
					$div .='<div class="contact"><div class="tel" style="width:33%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div>';
					$div .= '<div class="tel" style="width:33%;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<div class="nav" style="width:33%;"><a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a>';
					}else{
						$div .='<div class="nav" style="width:33%;"><div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div>';
					}
				}elseif(empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && empty($va['custom_four'])){
					$div .= '<div class="nav" style="width:100%;"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" style="width:9%;margin-top:6px;margin-left:20%;" width="9%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" style="width:9%;margin-top:6px;margin-left:20%;" width="9%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && empty($va['custom_four'])){
					$div .= '<div class="tel" style="border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					
					$div .= '<div class="nav" ><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && !empty($va['custom_three']) && empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_three'].'"><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';
					$div .= '<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					
					$div .= '<div class="nav" style="width:33%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && !empty($va['custom_four'])){
					
					$div .= '<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					$div .= '<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_four'].'</span></div></a>';
					$div .= '<div class="nav" style="width:33%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && !empty($va['custom_four'])){
					
					$div .= '<div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					$div .= '<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_four'].'</span></div></a>';
					$div .= '<div class="nav" style="width:33%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					
					$div .= '<div class="contact"><div class="tel" style="width:24.5%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_three'].'"><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';
					$div .= '<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					$div .= '<div class="nav" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_four'].'</span></div></a></div>';
					$div .= '<div class="nav" style="width:24.5%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && empty($va['custom_two']) && !empty($va['custom_three']) && empty($va['custom_four'])){
					
					$div .= '<div class="contact"><div class="nav" style="width:100%;border-right:none;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" style="width:12%;margin-left:30%;">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" style="width:12%;margin-left:30%;">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;margin-top:5px;">';
					}else{
						$div .= '<span style="margin-top:5px;">';
					}
					$div .= $va['custom_three'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && empty($va['custom_two']) && empty($va['custom_three']) && !empty($va['custom_four'])){
					
					$div .= '<div class="contact"><div class="nav" style="width:100%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" style="width:12%;margin-left:30%;">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" style="width:12%;margin-left:30%;">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;margin-top:5px;">';
					}else{
						$div .= '<span style="margin-top:5px;">';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="nav" style="width:50%;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';

					$div .= '<div class="nav" style="width:49.5%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$div .= '<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';

					$div .= '<div class="nav" style="width:33%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && !empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_two'].'"><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$div .= '<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';

					$div .= '<div class="nav" style="width:33%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}else{
					$div .='<div class="contact"><div class="tel"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>一键拨号</span></div></a></div><div class="nav">';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键导航</span></div></a>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">一键导航</span></div>';
					}
				}
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
		
	}
	///最新
	public function doMobilenewlist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];

		//$this->_Auth();//获取用户信息
		//$this->__douser();//存储用户信息
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$condition = '';
		if(!empty($_GPC['keyword']))
        {
        	$condition.=" AND storename LIKE '%{$_GPC['keyword']}%' ";
        }

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}

		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		
		/*获取幻灯片*/
		$sql = "select * from ".tablename(BANNER_TABLE)." where weid='{$weid}' and status=1";
		$baners = pdo_fetchall($sql);

		/*获取首页导航*/
		$sql_type = "select * from ".tablename(INDEX_TABLE)." where weid='{$weid}' and enabled=1 ORDER BY displayorder DESC,id DESC";
		$types = pdo_fetchall($sql_type);

		/*获取门店信息*/
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 ".$condition." order by id desc limit 0,{$psize}";
		$stores = pdo_fetchall($stores_sql);
		/*处理门店距离*/
		if($sta==1){
			foreach ($stores as $k => $v) {
				if($v['lat']&&$v['lng']){
				$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
				$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
				$stores[$k]['disc'] = round(($discont/1000),2);
				}
			}
		}
		//判断设置的排序方式如果是按距离
		/*if($setting['sort'] == 1){
			$stores = $this->array_sort($stores,'disc');
		}*/
		//菜单
		$menu=pdo_fetchall("SELECT * FROM ".tablename(MENU_TABLE)." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		//var_dump($menu);
		include $this->template('newindex');
	}

	public function doMobileajaxindex(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//$lbs_scope = $setting['lbs_scope'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}
		$condition = '';
		$class_id = intval($_GPC['clid']);
		if($class_id > 0){
			$condition .= " AND mdcateid='{$class_id}'";
			//查找子分类
			$ch_list = pdo_fetchall("SELECT id FROM ".tablename(CLASS_TABLE)." WHERE weid='{$weid}' AND parentid='{$class_id}'");
			foreach($ch_list as $ck => $cv){
				$condition .= " OR mdcateid= ".$cv['id'];
			}
		}
		
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 ".$condition." order by displayorder desc,id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		if($sta==1){
			foreach ($stores as $k => $v) {
				if($v['lat']&&$v['lng']){
					$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
					$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
					$stores[$k]['disc'] = round(($discont/1000),2);
					/*if($lbs_scope > 0){
						if($stores[$k]['disc'] > $lbs_scope){
							unset($stores[$k]);
						}
						
					}*/
				}
			}
		}
		//判断设置的排序方式如果是按距离
		if($setting['sort'] == 1){
			$stores = $this->array_sort($stores,'disc');
		}
		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

				if(!$va['storelogo']){
					if(!$setting['avar']){
						$logo=NEARBY_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['storelogo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">';
				$storename =  mb_substr($va['storename'],0,12,'utf-8');
				$div .= $va['storename'].'</h3><p>';
				$address = mb_substr($va['province'].$va['city'].$va['address'],0,18,'utf-8');
				$div .= $address.'...</p></div>';
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				if($va['disc']){
					$div .= '<div class="disc" style="background-color:'.$color.'"><span style="color:#fff;">'.$va['disc'].'km</span></div></div>';
				}
				if(!empty($va['custom_one']) && empty($va['custom_two']) && empty($va['custom_three']) && empty($va['custom_four'])){
					$div .='<div class="contact"><div class="tel" style="width:33%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div>';
					$div .= '<div class="tel" style="width:33%;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<div class="nav" style="width:33%;"><a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a>';
					}else{
						$div .='<div class="nav" style="width:33%;"><div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div>';
					}
				}elseif(empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && empty($va['custom_four'])){
					$div .='<div class="contact"><div class="tel" style="width:33%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div><div class="nav" style="width:33%;border-right:1px solid #e3e3e3;">';
					
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a></div>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div></div>';
					}
					$div .= '<div class="nav" style="width:33%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && empty($va['custom_four'])){
					$div .='<div class="contact"><div class="tel" style="width:24.5%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div>';
					$div .= '<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<div class="nav" style="width:24.5%;border-right:1px solid #e3e3e3;"><a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a></div>';
					}else{
						$div .='<div class="nav" style="width:24.5%;border-right:1px solid #e3e3e3;"><div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div></div>';
					}
					$div .= '<div class="nav" style="width:25%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && !empty($va['custom_three']) && empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="tel" style="width:24.5%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';
					$div .= '<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<div class="nav" style="width:24.5%;border-right:1px solid #e3e3e3;"><a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a></div>';
					}else{
						$div .='<div class="nav" style="width:24.5%;border-right:1px solid #e3e3e3;"><div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div></div>';
					}
					$div .= '<div class="nav" style="width:25%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .='<div class="contact"><div class="tel" style="width:24.5%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div>';
					$div .= '<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					$div .= '<div class="nav" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_four'].'</span></div></a>';
					$div .= '<div class="nav" style="width:24.5%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .='<div class="contact"><div class="tel" style="width:24.5%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div>';
					$div .= '<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					$div .= '<div class="nav" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_four'].'</span></div></a>';
					$div .= '<div class="nav" style="width:24.5%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					
					$div .= '<div class="contact"><div class="tel" style="width:24.5%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_three'].'"><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';
					$div .= '<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					$div .= '<div class="nav" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_four'].'</span></div></a></div>';
					$div .= '<div class="nav" style="width:24.5%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && empty($va['custom_two']) && !empty($va['custom_three']) && empty($va['custom_four'])){
					
					$div .= '<div class="contact"><div class="nav" style="width:100%;border-right:none;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" style="width:12%;margin-left:30%;">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" style="width:12%;margin-left:30%;">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;margin-top:5px;">';
					}else{
						$div .= '<span style="margin-top:5px;">';
					}
					$div .= $va['custom_three'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && empty($va['custom_two']) && empty($va['custom_three']) && !empty($va['custom_four'])){
					
					$div .= '<div class="contact"><div class="nav" style="width:100%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" style="width:12%;margin-left:30%;">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" style="width:12%;margin-left:30%;">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;margin-top:5px;">';
					}else{
						$div .= '<span style="margin-top:5px;">';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="nav" style="width:50%;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';

					$div .= '<div class="nav" style="width:49.5%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$div .= '<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';

					$div .= '<div class="nav" style="width:33%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}elseif(empty($va['custom_one']) && !empty($va['custom_two']) && !empty($va['custom_three']) && !empty($va['custom_four'])){
					$div .= '<div class="contact"><div class="tel" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_two'].'"><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$div .= '<div class="nav" style="width:33%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_three'].'" ><div class="mid">';
					if(!empty($va['custom_logo_three'])){
						$div .= '<img src="'.tomedia($va['custom_logo_three']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_three'].'</span></div></a></div>';

					$div .= '<div class="nav" style="width:33%;border-right:none;"><a href="'.$va['custom_url_four'].'" ><div class="mid">';
					if(!empty($va['custom_logo_four'])){
						$div .= '<img src="'.tomedia($va['custom_logo_four']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;;">';
					}else{
						$div .= '<span >';
					}
					$div .= $va['custom_four'].'</span></div></a>';
				}else{
					$div .='<div class="contact"><div class="tel"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>一键拨号</span></div></a></div><div class="nav">';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键导航</span></div></a>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">一键导航</span></div>';
					}
				}
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	public function doMobileajaxnewinfo(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$psize = PSIZE;//每页几条信息
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}

		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);
		if($sta==1){
			foreach ($stores as $k => $v) {
				if($v['lat']&&$v['lng']){
				$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
				$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
				$stores[$k]['disc'] = round(($discont/1000),2);
				}
			}
		}
		//判断设置的排序方式如果是按距离
		/*if($setting['sort'] == 1){
			$stores = $this->array_sort($stores,'disc');
		}*/
		if($stores){
			foreach ($stores as $ke => $va) {
				$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
				$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

				if(!$va['storelogo']){
					if(!$setting['avar']){
						$logo=NEARBY_IMAGE.'123.png';
					}else{
						$logo=$setting['avar'];
					}
				}else{
					$logo=$va['storelogo'];
				}
				$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">';
				$storename =  mb_substr($va['storename'],0,12,'utf-8');
				$div .= $va['storename'].'</h3><p>';
				$address = mb_substr($va['province'].$va['city'].$va['address'],0,18,'utf-8');
				$div .= $address.'...</p></div>';
				if(!$setting['color']){
					$color="#fff";
					$fontcolor='';
				}else{
					$color=$setting['color'];
					$fontcolor='color:#000;';
				}
				if($va['disc']){
					$div .= '<div class="disc" style="background-color:'.$color.'"><span style="color:#fff;">'.$va['disc'].'km</span></div></div>';
				}
				if(!empty($va['custom_one']) && empty($va['custom_two'])){
					$div .='<div class="contact"><div class="tel" style="width:33%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div>';
					$div .= '<div class="tel" style="width:33%;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<div class="nav" style="width:33%;"><a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a>';
					}else{
						$div .='<div class="nav" style="width:33%;"><div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div>';
					}
				}elseif(empty($va['custom_one']) && !empty($va['custom_two'])){
					$div .='<div class="contact"><div class="tel" style="width:33%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div><div class="nav" style="width:33%;border-right:1px solid #e3e3e3;">';
					
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a></div>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div></div>';
					}
					$div .= '<div class="nav" style="width:33%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}elseif(!empty($va['custom_one']) && !empty($va['custom_two'])){
					$div .='<div class="contact"><div class="tel" style="width:24.5%;"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>拨号</span></div></a></div>';
					$div .= '<div class="tel" style="width:25%;border-right:1px solid #e3e3e3;"><a href="'.$va['custom_url_one'].'"><div class="mid">';
					if(!empty($va['custom_logo_one'])){
						$div .= '<img src="'.tomedia($va['custom_logo_one']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_one'].'</span></div></a></div>';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<div class="nav" style="width:24.5%;border-right:1px solid #e3e3e3;"><a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>导航</span></div></a></div>';
					}else{
						$div .='<div class="nav" style="width:24.5%;border-right:1px solid #e3e3e3;"><div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">导航</span></div></div>';
					}
					$div .= '<div class="nav" style="width:25%"><a href="'.$va['custom_url_two'].'" ><div class="mid">';
					if(!empty($va['custom_logo_two'])){
						$div .= '<img src="'.tomedia($va['custom_logo_two']).'" width="25%" height="100%">';
					}else{
						$div .= '<img src="'.NEARBY_IMAGE.'123.png" width="25%" height="100%">';
					}
					if($setting['color']){
						$div .= '<span style="color:#000;">';
					}else{
						$div .= '<span>';
					}
					$div .= $va['custom_two'].'</span></div></a>';
				}else{
					$div .='<div class="contact"><div class="tel"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'tel.png" width="30%" height="100%"><span>一键拨号</span></div></a></div><div class="nav">';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键导航</span></div></a>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">一键导航</span></div>';
					}
				}
				
				$div .='</div></div></div></div></a>';
			}

			$returns=array(
				'statue'=>1,
				'data'=>$div,
				'page'=>$pindex,
				);
		}else{
			$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
		}
		echo json_encode($returns);
	}

	//处理用户信息
	public function __douser(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$uid = $_SESSION['uid'];
		$openid = $_SESSION['openid'];
		$sql = "select * from ".tablename(USER_TABLE)." where weid='{$weid}' and uid='{$uid}'";
		$minfo = pdo_fetch($sql);
		if($minfo['enable']==2){
			$this->returnError('很抱歉，此账号已被封号!请联系客服！');
		}
		if($minfo){
			$update = array(
				'updatetime'=>TIMESTAMP,
				);
			pdo_update(USER_TABLE,$update,array('weid'=>$weid,'uid'=>$uid));//更新登录时间
			$_SESSION['userinfo'] = $minfo;
		}else{
			$data = array(
				'weid'=>$weid,
				'uid'=>$uid,
				'openid'=>$openid,
				'enable'=>1,
				'createtime'=>TIMESTAMP,
				'updatetime'=>TIMESTAMP,
			);
			pdo_insert(USER_TABLE,$data);
			$pdo_insertid = pdo_insertid();
			$indata = array(
				'weid'=>$weid,
				'mid'=>$pdo_insertid,
				);
			pdo_insert(USER_ATTR_TABLE,$indata);
			$_SESSION['userinfo'] = $data;
			$_SESSION['userinfo']['id']=$pdo_insertid;
		}
	}


	//距离
	public function doMobilelist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		/*$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息*/
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "dis";
		$id = $_GPC['pid'];
		$update = "update ".tablename(CLASS_TABLE)." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取分类信息*/
		$sql = "select id,catename,thumb,turl from ".tablename(CLASS_TABLE)." where weid='{$weid}' and id='{$id}'";
		$class = pdo_fetch($sql);
		//子分类
		$children = array();
		if(!empty($class)){
			$parentid = $class['id'];
			$csql = "select id,catename,thumb,icon from ".tablename(CLASS_TABLE)." where weid='{$weid}' and parentid='{$parentid}' order by displayorder desc";
			$children = pdo_fetchall($csql);
		}
		$condition = '';
		foreach($children as $key1 => $val1){
			$condition .= ' or mdcateid = '.$val1['id'];
		}
		
		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$menu=pdo_fetchall("SELECT * FROM ".tablename(MENU_TABLE)." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		//var_dump($menu);
		//$lbs_scope = $setting['lbs_scope'];
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 and mdcateid='{$id}'".$condition." and lng <>0 and lat <>0 order by displayorder desc,id desc";
		$storess = pdo_fetchall($stores_sql);
		$newarr = array();
		foreach ($storess as $k => $v) {
			$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
			$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			$storess[$k]['disc'] = round(($discont/1000),2);
			$newarr[$k][]=round(($discont/1000),2);
			/*if($lbs_scope > 0){
				if($storess[$k]['disc'] > $lbs_scope){
					unset($storess[$k]);
				}	
			}*/
		}
		//判断设置的排序方式如果是按距离
		if($setting['sort'] == 1){
			$storess = $this->array_sort($storess,'disc');
		}
		// $storess = $this->array_sort($storess,'disc');//

		$i=($pindex-1)*$psize; $j=1;
		$t=0;
		if($doajax==1){
			foreach ($storess as $key => $value) {
				if($j>$i){
					if($t<$psize){
						$new[]=$value;
						$t++;
					}else{
						break;
					}
				}
				$j++;
			}
			$stores=$new;
			if($stores){
				foreach ($stores as $ke => $va) {
					$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
					$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

					if(!$va['storelogo']){
						if(!$setting['avar']){
							$logo=NEARBY_IMAGE.'123.png';
						}else{
							$logo=$setting['avar'];
						}
					}else{
						$logo=$va['storelogo'];
					}
					$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">';
					$storename =  mb_substr($va['storename'],0,12,'utf-8');
					$div .= $va['storename'].'</h3><p>';
					$address = mb_substr($va['province'].$va['city'].$va['address'],0,18,'utf-8');
					$div .= $address.'...</p></div>';
					if(!$setting['color']){
						$color="#fff";
						$fontcolor='';
					}else{
						$color=$setting['color'];
						$fontcolor='color:#000;';
					}
					if($va['disc']){
						$div .= '<div class="disc" style="background-color:'.$color.'"><span style="color:#fff;">'.$va['disc'].'km</span></div></div>';
					}
					$div .='<div class="contact"><div class="tel"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键拨号</span></div></a></div><div class="nav">';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						// $div .='<a href="'.$this->createMobileUrl('map',array('lat'=>$va['lat'],'lng'=>$va['lng'])).'">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键导航</span></div></a>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">一键导航</span></div>';
					}
					$div .='</div></div></div></div></a>';
				}
				$returns=array(
					'statue'=>1,
					'data'=>$div,
					'page'=>$pindex,
					);
			}else{
				$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
			}
			echo json_encode($returns);
		}else{
			foreach ($storess as $key => $value) {
				if($t<$psize){
					$new[]=$value;
					$t++;
				}else{
					break;
				}
			}
			$stores=$new;
			include $this->template('type');
		}
	}

	//
	//距离
	public function doMobileclist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		
		/*$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息*/
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "dis";
		$id = $_GPC['cid'];
		$update = "update ".tablename(CLASS_TABLE)." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取分类信息*/
		$sql = "select id,catename,thumb from ".tablename(CLASS_TABLE)." where weid='{$weid}' and id='{$id}' order by displayorder desc";
		$class = pdo_fetch($sql);
		
		
		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//$lbs_scope = $setting['lbs_scope'];
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' and lng <>0 and lat <>0 order by displayorder desc,id desc";
		$storess = pdo_fetchall($stores_sql);
		$newarr = array();
		foreach ($storess as $k => $v) {
			$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
			$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			$storess[$k]['disc'] = round(($discont/1000),2);
			$newarr[$k][]=round(($discont/1000),2);
			/*if($lbs_scope > 0){
				if($storess[$k]['disc'] > $lbs_scope){
					unset($storess[$k]);
				}	
			}*/
		}
		//判断设置的排序方式如果是按距离
		if($setting['sort'] == 1){
			$storess = $this->array_sort($storess,'disc');
		}
		$menu=pdo_fetchall("SELECT * FROM ".tablename(MENU_TABLE)." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		//var_dump($menu);
		// $storess = $this->array_sort($storess,'disc');//
		$i=($pindex-1)*$psize; $j=1;
		$t=0;
		if($doajax==1){
			foreach ($storess as $key => $value) {
				if($j>$i){
					if($t<$psize){
						$new[]=$value;
						$t++;
					}else{
						break;
					}
				}
				$j++;
			}
			$stores=$new;
			if($stores){
				foreach ($stores as $ke => $va) {
					$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
					$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

					if(!$va['storelogo']){
						if(!$setting['avar']){
							$logo=NEARBY_IMAGE.'123.png';
						}else{
							$logo=$setting['avar'];
						}
					}else{
						$logo=$va['storelogo'];
					}
					$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">';
					$storename =  mb_substr($va['storename'],0,12,'utf-8');
					$div .= $va['storename'].'</h3><p>';
					$address = mb_substr($va['province'].$va['city'].$va['address'],0,18,'utf-8');
					$div .= $address.'...</p></div>';
					if(!$setting['color']){
						$color="#fff";
						$fontcolor='';
					}else{
						$color=$setting['color'];
						$fontcolor='color:#000;';
					}
					if($va['disc']){
						$div .= '<div class="disc" style="background-color:'.$color.'"><span style="color:#fff;">'.$va['disc'].'km</span></div></div>';
					}
					$div .='<div class="contact"><div class="tel"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键拨号</span></div></a></div><div class="nav">';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						// $div .='<a href="'.$this->createMobileUrl('map',array('lat'=>$va['lat'],'lng'=>$va['lng'])).'">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键导航</span></div></a>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">一键导航</span></div>';
					}
					$div .='</div></div></div></div></a>';
				}
				$returns=array(
					'statue'=>1,
					'data'=>$div,
					'page'=>$pindex,
					);
			}else{
				$returns=array(
					'statue'=>2,
					'msg'=>'已加载全部数据',
					'page'=>$pindex,
					);
			}
			echo json_encode($returns);
		}else{
			foreach ($storess as $key => $value) {
				if($t<$psize){
					$new[]=$value;
					$t++;
				}else{
					break;
				}
			}
			$stores=$new;
			include $this->template('ctype');
		}

	}

	//最新
	public function doMobileTlist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		/*$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息*/
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "new";
		$id = $_GPC['pid'];
		$sql = "select id,catename,thumb from ".tablename(CLASS_TABLE)." where weid='{$weid}' and id='{$id}'";
		$class = pdo_fetch($sql);
		//子分类
		$children = array();
		if(!empty($class)){
			$parentid = $class['id'];
			$csql = "select id,catename,thumb,icon from ".tablename(CLASS_TABLE)." where weid='{$weid}' and parentid='{$parentid}' order by displayorder desc";
			$children = pdo_fetchall($csql);
		}
		$condition = '';
		foreach($children as $key1 => $val1){
			$condition .= ' or mdcateid = '.$val1['id'];
		}

		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//$lbs_scope = $setting['lbs_scope'];
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 and mdcateid='{$id}'".$condition." order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);

		
		foreach ($stores as $k => $v) {
			if($v['lat']&&$v['lng']){
				$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
				$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
				$stores[$k]['disc'] = round(($discont/1000),2);
				/*if($lbs_scope > 0){
					if($stores[$k]['disc'] > $lbs_scope){
						unset($stores[$k]);
					}	
				}*/
			}
		}
		if($doajax==1){
			if($stores){
				foreach ($stores as $ke => $va) {
					$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
					$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

					if(!$va['storelogo']){
						if(!$setting['avar']){
							$logo=NEARBY_IMAGE.'123.png';
						}else{
							$logo=$setting['avar'];
						}
					}else{
						$logo=$va['storelogo'];
					}
					$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">';
					$storename =  mb_substr($va['storename'],0,12,'utf-8');
					$div .= $va['storename'].'</h3><p>';
					$address = mb_substr($va['province'].$va['city'].$va['address'],0,18,'utf-8');
					$div .= $address.'...</p></div>';
					if(!$setting['color']){
						$color="#fff";
						$fontcolor='';
					}else{
						$color=$setting['color'];
						$fontcolor='color:#000;';
					}
					if($va['disc']){
						$div .= '<div class="disc" style="background-color:'.$color.'"><span style="color:#fff;">'.$va['disc'].'km</span></div></div>';
					}
					$div .='<div class="contact"><div class="tel"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键拨号</span></div></a></div><div class="nav">';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						// $div .='<a href="'.$this->createMobileUrl('map',array('lat'=>$va['lat'],'lng'=>$va['lng'])).'">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键导航</span></div></a>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">一键导航</span></div>';
					}
					$div .='</div></div></div></div></a>';
				}

				$returns=array(
					'statue'=>1,
					'data'=>$div,
					'page'=>$pindex,
					);
			}else{
				$returns=array(
						'statue'=>2,
						'msg'=>'已加载全部数据',
						'page'=>$pindex,
						);
			}
				echo json_encode($returns);
		}else{
			include $this->template('type');
		}
		
	}

	//最新
	public function doMobileTlistc(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		/*$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息*/
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}
		$do = $_GPC['do'];
		$doajax = $_GPC['doajax'] ? $_GPC['doajax'] : 2;//是否ajax查询
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = PSIZE;//每页几条信息
		$act = "new";
		$id = $_GPC['cid'];
		$sql = "select catename,thumb from ".tablename(CLASS_TABLE)." where weid='{$weid}' and id='{$id}'";
		$class = pdo_fetch($sql);
		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		//$lbs_scope = $setting['lbs_scope'];
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' order by id desc limit ".($pindex-1)*$psize.",{$psize}";
		$stores = pdo_fetchall($stores_sql);

		
		foreach ($stores as $k => $v) {
			if($v['lat']&&$v['lng']){
				$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
				$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
				$stores[$k]['disc'] = round(($discont/1000),2);
				/*if($lbs_scope > 0){
					if($stores[$k]['disc'] > $lbs_scope){
						unset($stores[$k]);
					}	
				}*/
			}
		}
		if($doajax==1){
			if($stores){
				foreach ($stores as $ke => $va) {
					$div .= "<a href='".$this->createMobileUrl('showDetail',array('id'=>$va['id']))."'>";
					$div .= '<div class="point-div"><div class="con"><div class="detail"><div class="pic">';

					if(!$va['storelogo']){
						if(!$setting['avar']){
							$logo=NEARBY_IMAGE.'123.png';
						}else{
							$logo=$setting['avar'];
						}
					}else{
						$logo=$va['storelogo'];
					}
					$div .= '<img src="'.tomedia($logo).'" width="100%"></div><div class="title"><h3 style="height:25px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">';
					$storename =  mb_substr($va['storename'],0,12,'utf-8');
					$div .= $va['storename'].'</h3><p>';
					$address = mb_substr($va['province'].$va['city'].$va['address'],0,18,'utf-8');
					$div .= $address.'...</p></div>';
					if(!$setting['color']){
						$color="#fff";
						$fontcolor='';
					}else{
						$color=$setting['color'];
						$fontcolor='color:#000;';
					}
					if($va['disc']){
						$div .= '<div class="disc" style="background-color:'.$color.'"><span style="color:#fff;">'.$va['disc'].'km</span></div></div>';
					}
					$div .='<div class="contact"><div class="tel"><a data="'.$va['tel'].'"><div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键拨号</span></div></a></div><div class="nav">';
					$va['remark']= htmlspecialchars_decode($va['remark']);
					$va['remark']= preg_replace("/<(.*?)>/","",$va['remark']); 
					if($va['lat']&&$va['lng']){
						$div .='<a href="http://api.map.baidu.com/marker?location='.$va['lat'].','.$va['lng'].'&title='.$va['storename'].'&name='.$va['storename'].'&content='.$va['remark'].'&output=html&src=weiba|weiweb">';
						// $div .='<a href="'.$this->createMobileUrl('map',array('lat'=>$va['lat'],'lng'=>$va['lng'])).'">';
						$div .='<div class="mid"><img src="'.NEARBY_IMAGE.'dw.png" width="30%" height="100%"><span>一键导航</span></div></a>';
					}else{
						$div .='<div class="mid nodh"><img src="'.NEARBY_IMAGE.'dw.png" width="25%" height="100%"><span style="'.$fontcolor.'">一键导航</span></div>';
					}
					$div .='</div></div></div></div></a>';
				}

				$returns=array(
					'statue'=>1,
					'data'=>$div,
					'page'=>$pindex,
					);
			}else{
				$returns=array(
						'statue'=>2,
						'msg'=>'已加载全部数据',
						'page'=>$pindex,
						);
			}
				echo json_encode($returns);
		}else{
			include $this->template('ctype');
		}
		
	}

	public function doMobileshowDetail(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$weixin=0;
			$weid=$_GPC['i'];
		}else{
			if($_SESSION['posi']){
				$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			}else{
				$this->doMobileIndex();
			}
		}
		
		$id = $_GPC['id'];
		//更新门店访问量
		$update = "update ".tablename(STORE_TABLE)." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and id='{$id}'";
		$infos = pdo_fetch($sql);

		$infos['thumb'] = unserialize($infos['thumb']);
		$title=$infos['storename'];
		$typename = pdo_fetch("select catename from ".tablename(CLASS_TABLE)." where weid='{$weid}' and id='{$infos['mdcateid']}'");
		$all = pdo_fetchall("select * from ".tablename(STORE_ATTR_TABLE)." where weid='{$weid}' and storeid='{$id}'");

		$updatesql = "update ".tablename(STAT_TABLE)." set storeid='{$id}',classid='{$infos['mdcateid']}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
		pdo_query($updatesql);

		//评论信息
		$commen_list = pdo_fetchall("SELECT * FROM ".tablename(COMMENTS_TABLE)." WHERE weid='{$weid}' AND deleted=0 AND store_id='{$id}' ORDER BY id DESC");
		foreach($commen_list as $ckey => $cval){
			$mc_info = pdo_fetch("SELECT uid,nickname,avatar FROM ".tablename('mc_members')." WHERE uniacid='{$weid}' AND uid='{$cval['uid']}'");
			$commen_list[$ckey]['avatar'] = $mc_info['avatar'];
		}
		$menu=pdo_fetchall("SELECT * FROM ".tablename(MENU_TABLE)." WHERE weid=".$weid." AND enabled=1 ORDER BY displayorder DESC");
		include $this->template('showdetail');
		
	}

	public function doMobileaddcommen(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false) {
			$returns = array(
				'status'=>2,
				'mess'=>'请在微信客户端打开再评论'
			);
			echo json_encode($returns);exit;
		}
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息

		$store_id = intval($_GPC['storeid']);
		$com_content = trim($_GPC['content']);
		$openid = $_W['openid'];
		$user_info = pdo_fetch("SELECT id,uid FROM ".tablename(USER_TABLE)." WHERE weid='{$weid}' AND openid='{$openid}'");
		$member_info = pdo_fetch("SELECT uid,nickname,avatar FROM ".tablename('mc_members')." WHERE uniacid='{$weid}' AND uid='{$user_info['uid']}'");
	
		$mdata = array(
			'weid'=>$weid,
			'store_id'=>$store_id,
			'user_id'=>$user_info['id'],
			'uid'=>$user_info['uid'],
			'nickname'=>$member_info['nickname'],
			'content'=>$com_content,
			'updatetime'=>TIMESTAMP,
			'createtime'=>TIMESTAMP
		);
		pdo_insert(COMMENTS_TABLE,$mdata);
		$cid = pdo_insertid();

		$returns_arr = array(
			'status'=>1,
			'content'=>$com_content,
			'nickname'=>$member_info['nickname'],
			'avatar'=>$member_info['avatar']
		);
		echo json_encode($returns_arr);exit;
	}

	/**
       * 腾讯地图坐标转百度地图坐标
       * @param [String] $lat 腾讯地图坐标的纬度
       * @param [String] $lng 腾讯地图坐标的经度
       * @return [Array] 返回记录纬度经度的数组
	*/
	public function Convert_GCJ02_To_BD09($lat,$lng){
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $lng;
        $y = $lat;
        $z =sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) + 0.000003 * cos($x * $x_pi);
        $lng = $z * cos($theta) + 0.0065;
        $lat = $z * sin($theta) + 0.006;
        return array('lng'=>$lng,'lat'=>$lat);
	}

	/**
       * 腾讯地图坐标转百度地图坐标
       * @param [String] $lat1 A点的纬度
       * @param [String] $lng1 A点的经度
       * @param [String] $lat2 B点的纬度
       * @param [String] $lng2 B点的经度
       * @return [String] 两点坐标间的距离，输出单位为米
	*/
	public function GetDistance($lat1, $lng1, $lat2, $lng2)  
	{  
	   $earth_radius = 6378.137;//地球的半径
	   $radLat1 = $this->rad($lat1);   
	   $radLat2 = $this->rad($lat2);  
	   $a = $radLat1 - $radLat2;  
	   $b = $this->rad($lng1) - $this->rad($lng2);  
	   $s = 2 * asin(sqrt(pow(sin($a/2),2) +  
	    cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));  
	   $s = $s * $earth_radius;  
	   $s = round($s * 10000) / 10000;
	   $s=$s*1000;
	   return ceil($s);  
	}  

	public function rad($d)  
	{  
	       return $d * 3.1415926535898 / 180.0;  
	} 

	//排序
	private function array_sort($arr,$keys,$type='asc'){ 
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
	}

	//基本设置
	public function doWebSetting() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();

		load()->func('tpl');

		$item=pdo_fetch("SELECT * FROM ".tablename(SETTING_TABLE)." WHERE weid=".$weid);
		if(empty($item))
		{
			$item['color'] = '#46CEC0';
			$item['is_menu'] = 0;
			$item['is_commen'] = 1;
		}

		$attr_arr=array();
		$attr_arr2=array();

		// $ziliao = $pdo_fetchall('SELECT a.enabled,b.id,b.name,b.type FROM '.tablename('jy_nearby_set_attr')." as a left join ".tablename('jy_nearby_attr')." as b on a.attr_id = b.id WHERE a.weid =".$weid." AND b.enabled = 1 order by b.displayorder desc");
		// $ziliao=pdo_fetchall('SELECT a.enabled,b.name,b.id,b.type FROM '.tablename('jy_nearby_set_attr')." as a left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid."  AND b.enabled=1 ORDER BY b.displayorder desc");
		$ziliao=pdo_fetchall('SELECT b.enabled,a.name,a.id,a.type FROM '.tablename('jy_nearby_attr')." as a left join ".tablename('jy_nearby_set_attr')." as b on b.attr_id=a.id WHERE a.weid=".$weid."  AND a.enabled=1 AND a.parentid=0 ORDER BY a.displayorder desc");
		$ziliao2=pdo_fetchall('SELECT a.enabled,b.name,b.id,b.type FROM '.tablename('jy_nearby_set_attr')." as a left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid."  AND b.parentid=0 ORDER BY b.displayorder desc");
		foreach ($ziliao2 as $key => $value) {
			if($value['enabled']==0)
			{
				array_push($attr_arr, $value['id']);
			}
			else
			{
				array_push($attr_arr2, $value['id']);
			}
			
		}

		if(empty($ziliao)){
		$attr_info = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_attr')." WHERE weid=".$weid." AND enabled=1 AND parentid=0 ORDER BY displayorder DESC,id ASC");

		}else{
			$attr_info = array();
		}

		if(checksubmit()) {
			
			$data=array(
				'weid'=>$weid,
				'aname'=>$_GPC['aname'],
				'title'=>$_GPC['title'],
				'wdcx'=>$_GPC['wdcx'],
				'avar'=>$_GPC['avar'],
				'sharetitle'=>$_GPC['sharetitle'],
				'sharedesc'=>$_GPC['sharedesc'],
				'sharelogo'=>$_GPC['sharelogo'],
				'notice' => $_GPC ['notice'],
				'copyright' => $_GPC ['copyright'],
				'copyrighturl' => $_GPC ['copyrighturl'],
				'color' => $_GPC ['color'],
				'isopen' => $_GPC ['isopen'],
				'sort' => $_GPC ['sort'],
				'lbs_scope'=>$_GPC['lbs_scope'],
				'openpic' => $_GPC ['openpic'],
				'formthumb' => $_GPC ['formthumb'],
				'mapkey' => $_GPC ['mapkey'],
				'loadding'=>$_GPC['loadding'],
				'index_back'=>intval($_GPC['index_back']),
				'index_back_thumb'=>$_GPC['index_back_thumb'],
				'is_menu'=>intval($_GPC['is_menu']),
				'is_commen'=>intval($_GPC['is_commen']),
				'bdak'=>trim($_GPC['bdak']),
				'updatetime'=>TIMESTAMP,
			);
			pdo_delete("jy_nearby_set_attr",array('weid'=>$weid));
			if(!empty($_GPC['attr_set'])){
				$attr_set = $_GPC['attr_set'];
				foreach ($attr_set as $key => $value) {
					$enabled=substr($value, 0 , 1 );
					$attr_id=substr($value, 2 );
					$data2=array(
							'weid'=>$weid,
							'attr_id'=>$attr_id,
							'enabled'=>$enabled,
							'createtime'=>TIMESTAMP,
						);
					pdo_insert('jy_nearby_set_attr',$data2);
				}
			}
			
			
			if(empty($item['id']))
			{
				$data['createtime']=time();
				pdo_insert(SETTING_TABLE,$data);
			}
			else
			{
				pdo_update(SETTING_TABLE,$data,array('weid'=>$weid));
			}

			message("设置成功!",$this->createWebUrl('setting'),'success');
		}
		include $this->template('web/setting');
	}

	//底部菜单设置
	public function doWebmenu() {
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update (MENU_TABLE, array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '自定义菜单管理更新成功！', $this->createWebUrl ( 'menu', array ('op' => 'display') ), 'success' );
			}
			$category = pdo_fetchall ( "SELECT * FROM " . tablename ( MENU_TABLE ) . " WHERE weid = '{$_W['weid']}' ORDER BY displayorder DESC,id ASC" );
			include $this->template ( 'web/menu' );
		} elseif ($operation == 'post') {
			$id = intval ( $_GPC ['id'] );
			load()->func('tpl');
			$condition='';
			if (! empty ( $id )) {
				$category = pdo_fetch ( "SELECT * FROM " . tablename ( MENU_TABLE ) . " WHERE id = '$id'" );
				$condition.=" AND id!=".$id;
			} else {
				$category = array (
						'displayorder' => 0,
						'thumb' => '',
						'url' => '',
						'enabled' => 1
				);
			}
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['catename'] )) {
					message ( '抱歉，请输入自定义菜单管理！' );
				}

				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( MENU_TABLE ) . " WHERE weid=" . $weid . " AND name='" . $_GPC ['catename'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该自定义菜单管理！', $this->createWebUrl ( 'url', array ('op' => 'display' ) ), 'error' );
				}
				$enabled=intval($_GPC['enabled']);
				if($enabled==1)
				{
					$temp=pdo_fetchcolumn("SELECT count(id) FROM ".tablename(MENU_TABLE)." WHERE weid=".$weid." AND enabled=1 ".$condition);
				}
				if($temp==4)
				{
					message("自定义菜单最多设置4个显示项，请先去除其他显示项！");
				}
				if (empty ( $_GPC ['thumb'] )) {
					message ( '抱歉，请上传自定义菜单icon！' );
				}
				$data = array (
						'weid' => $_W ['weid'],
						'name' => $_GPC ['catename'],
						'description' => $_GPC ['description'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'thumb' => $_GPC ['thumb'],
						'url' => $_GPC ['url'],
						'displayorder' => intval ( $_GPC ['displayorder'] ) 
				);
				$type=intval($_GPC['type']);
				if($type==1)
				{
					$data['url']=$this->createMobileUrl('index');
				}
				if($type==2)
				{
					$data['url']=$this->createMobileUrl('record');
				}
				
				if($type==3)
				{
					$data['url']=$this->createMobileUrl('geren');
				}
				if (! empty ( $id )) {
					pdo_update ( MENU_TABLE, $data, array ('id' => $id ) );
				} else {
					pdo_insert ( MENU_TABLE, $data );
					$id = pdo_insertid ();
				}
				message ( '更新自定义菜单管理设置成功！', $this->createWebUrl ( 'menu', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/menu' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( MENU_TABLE ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，自定义菜单管理设置不存在或是已经被删除！', $this->createWebUrl ( 'menu', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( MENU_TABLE, array ('id' => $id ) );
			message ( '自定义菜单管理设置删除成功！', $this->createWebUrl ( 'menu', array ('op' => 'display' ) ), 'success' );
		}
	}


	//幻灯片设置
	public function doWebBanner() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();

		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	    if ($operation == 'display') {
	        if (!empty($_GPC['displayorder'])) {
	            foreach ($_GPC['displayorder'] as $id => $displayorder) {
	                pdo_update(BANNER_TABLE, array('displayorder' => $displayorder), array('id' => $id));
	            }
	            message('Banner更新成功！', $this->createWebUrl('banner', array('op' => 'display')), 'success');
	        }
	        $condition = '';
	        if(!empty($_GPC['keyword']))
	        {
	        	$condition.=" AND catename LIKE '%{$_GPC['keyword']}%' ";
	        }
	        $category = pdo_fetchall("SELECT * FROM " . tablename(BANNER_TABLE) . " WHERE weid = '{$_W['weid']}' ".$condition." ORDER BY displayorder DESC,id ASC");
	        include $this->template('web/banner');
	    } elseif ($operation == 'post') {
	    	load()->func('tpl');

	        $id = intval($_GPC['id']);
	        if (!empty($id)) {
	            $category = pdo_fetch("SELECT * FROM " . tablename(BANNER_TABLE) . " WHERE id = '$id'");
	        } else {
	            $category = array(
	                'displayorder' => 0,
	                'enabled' =>0,
	                'status' =>1,
	            );
	        }

	        if (checksubmit('submit')) {
	            // if (empty($_GPC['catename'])) {
	            //     message('抱歉，请输入Banner名称！');
	            // }
	            $link=$_GPC['url'];
				if(!empty($link)){
					if (!preg_match("/^(http|ftp):/", $link)){
					   $link='http://'.$link;
					}
				}
				if($this->text_len($link)>500){
					message("链接内容超长啦！");
				}
	            $data = array(
	                'weid' => $_W['weid'],
	                'catename' => $_GPC['catename'],
	                'thumb' => $_GPC['thumb'],
	                'content' => $_GPC['content'],
	                'enabled' => $_GPC['enabled'],
	                'url' => $link,
	                'displayorder' => intval($_GPC['displayorder']),
	                'status' => intval($_GPC['status']),
	            );

	            if (!empty($id)) {
	                pdo_update(BANNER_TABLE, $data, array('id' => $id));
	            } else {
	            	$data['createtime']=TIMESTAMP;
	                pdo_insert(BANNER_TABLE, $data);
	                $id = pdo_insertid();
	            }
	            message('更新Banner成功！', $this->createWebUrl('banner', array('op' => 'display')), 'success');
	        }
	        include $this->template('web/banner');
	    } elseif ($operation == 'delete') {
	        $id = intval($_GPC['id']);
	        $category = pdo_fetch("SELECT id FROM " . tablename(BANNER_TABLE) . " WHERE id = '$id'");
	        if (empty($category)) {
	            message('抱歉，Banner不存在或是已经被删除！', $this->createWebUrl('banner', array('op' => 'display')), 'error');
	        }
	        pdo_delete(BANNER_TABLE, array('id' => $id));
	        message('Banner删除成功！', $this->createWebUrl('banner', array('op' => 'display')), 'success');
	    }
	}

	//首页导航
	public function doWebindex() {
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( INDEX_TABLE, array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '首页导航管理更新成功！', $this->createWebUrl ( 'index', array ('op' => 'display') ), 'success' );
			}
			$category = pdo_fetchall ( "SELECT * FROM " . tablename ( INDEX_TABLE ) . " WHERE weid = '{$_W['weid']}' ORDER BY displayorder DESC,id ASC" );
			include $this->template ( 'web/index' );
		} elseif ($operation == 'post') {
			$id = intval ( $_GPC ['id'] );
			load()->func('tpl');
			if (! empty ( $id )) {
				$category = pdo_fetch ( "SELECT * FROM " . tablename ( INDEX_TABLE ) . " WHERE id = '$id'" );
			} else {
				$category = array (
						'displayorder' => 0,
						'thumb' => '',
						'url' => '',
						'enabled' => 1
				);
			}
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['catename'] )) {
					message ( '抱歉，请输入首页导航管理！' );
				}
				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( INDEX_TABLE ) . " WHERE weid=" . $weid . " AND catename='" . $_GPC ['catename'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该首页导航管理！', $this->createWebUrl ( 'index', array ('op' => 'display' ) ), 'error' );
				}
				$data = array (
						'weid' => $_W ['weid'],
						'catename' => $_GPC ['catename'],
						'description' => $_GPC ['description'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'thumb' => $_GPC ['thumb'],
						'url' => $_GPC ['url'],
						'displayorder' => intval ( $_GPC ['displayorder'] ) 
				);
				if (! empty ( $id )) {
					pdo_update ( INDEX_TABLE, $data, array ('id' => $id ) );
				} else {
					pdo_insert ( INDEX_TABLE, $data );
					$id = pdo_insertid ();
				}
				message ( '更新首页导航管理设置成功！', $this->createWebUrl ( 'index', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/index' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( INDEX_TABLE ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，首页导航管理设置不存在或是已经被删除！', $this->createWebUrl ( 'index', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( INDEX_TABLE, array ('id' => $id ) );
			message ( '首页导航管理设置删除成功！', $this->createWebUrl ( 'index', array ('op' => 'display' ) ), 'success' );
		}
	}

	//分类管理
	public function doWebclass(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		if ($operation == 'display') {
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( CLASS_TABLE, array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '分类管理更新成功！', $this->createWebUrl ( 'class', array ('op' => 'display') ), 'success' );
			}
			$category = pdo_fetchall ( "SELECT * FROM " . tablename ( CLASS_TABLE ) . " WHERE weid = '{$_W['weid']}' ORDER BY displayorder DESC,id ASC" );
			$children = array();
			foreach($category as $ck => $cv){
				if (!empty($cv['parentid'])) {
	                $children[$cv['parentid']][] = $cv;
	                unset($category[$ck]);
	            }
			}

			include $this->template ( 'web/class' );
		}elseif ($operation == 'post') {
			$parentid = intval($_GPC['parentid']);
			$id = intval ( $_GPC ['id'] );
			load()->func('tpl');
			if (! empty ( $id )) {
				$category = pdo_fetch ( "SELECT * FROM " . tablename ( CLASS_TABLE ) . " WHERE id = '$id'" );
			} else {
				$category = array (
						'displayorder' => 0,
						'enabled' => 1
				);
			}
			if (!empty($parentid)) {
	            $parent = pdo_fetch("SELECT id, catename FROM " . tablename(CLASS_TABLE) . " WHERE id = '{$parentid}'");
	            if (empty($parent)) {
	                message('抱歉，该类型不存在或是已经被删除！', $this->createWebUrl('post'), 'error');
	            }
	        }
	        
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['catename'] )) {
					message ( '抱歉，请输入分类名称！' );
				}
				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( CLASS_TABLE ) . " WHERE weid=" . $weid . " AND catename='" . $_GPC ['catename'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该分类管理！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'error' );
				}
				$data = array (
						'weid' => $_W ['weid'],
						'catename' => $_GPC ['catename'],
						'thumb' => $_GPC ['thumb'],
						'turl' => $_GPC ['turl'],
						'icon' => $_GPC ['icon'],
						'remark' => $_GPC ['remark'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'displayorder' => intval ( $_GPC ['displayorder'] ) ,
						'createtime' => TIMESTAMP,
						'parentid' => intval($parentid),
				);
				if (! empty ( $id )) {
					pdo_update ( CLASS_TABLE, $data, array ('id' => $id ) );
				} else {
					pdo_insert ( CLASS_TABLE, $data );
					$id = pdo_insertid ();
				}
				message ( '分类管理设置成功！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/class' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( CLASS_TABLE ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，分类管理设置不存在或是已经被删除！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( CLASS_TABLE, array ('id' => $id ) );
			message ( '分类管理设置删除成功！', $this->createWebUrl ( 'class', array ('op' => 'display' ) ), 'success' );
		}
	}

	//门店管理
	public function doWebStore() {
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
		load()->func('tpl');
		$types = pdo_fetchall( "SELECT * FROM " . tablename ( CLASS_TABLE ) . " WHERE weid = '{$_W['weid']}' ORDER BY id ASC" );
		if ($operation == 'display') {
			if (! empty ( $_GPC ['displayorder'] )) {
				foreach ( $_GPC ['displayorder'] as $id => $displayorder ) {
					pdo_update ( STORE_TABLE, array ('displayorder' => $displayorder ), array ('id' => $id) );
				}
				message ( '门店排序更新成功！', $this->createWebUrl ( 'store', array ('op' => 'display') ), 'success' );
			}
			$condition = '';
			if(!empty($_GPC['keyword']))
	        {
	        	$condition.=" AND a.storename LIKE '%{$_GPC['keyword']}%' ";
	        }
			$list = pdo_fetchall ( "SELECT a.*,b.catename FROM " . tablename ( STORE_TABLE ) . " a left join ".tablename( CLASS_TABLE )." b on a.mdcateid=b.id WHERE a.weid = '{$_W['weid']}' ".$condition." ORDER BY a.displayorder desc,a.id DESC" );
			include $this->template ( 'web/store' );
		}elseif ($operation == 'post') {
			$id = intval ( $_GPC ['id'] );
			if (! empty ( $id )) {
				$item = pdo_fetch ( "SELECT * FROM " . tablename ( STORE_TABLE ) . " WHERE id = '$id'" );
				$md = pdo_fetchall("select * from ".tablename(STORE_ATTR_TABLE)." where weid='{$weid}' and storeid='{$id}'");
				$item['thumbs'] = unserialize($item['thumb']);
			} else {
				$item = array (
						'displayorder' => 0,
						'enabled' => 1
				);
			}
			if (checksubmit ( 'submit' )) {
				if (empty ( $_GPC ['storename'] )) {
					message ( '抱歉，请输入门店名称！' );
				}
				$temp = pdo_fetch ( "SELECT id FROM " . tablename ( STORE_TABLE ) . " WHERE weid=" . $weid . " AND storename='" . $_GPC ['storename'] . "'" );
				if (! empty ( $temp ) && $id != $temp ['id']) {
					message ( '已存在该门店名称！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'error' );
				}
				$data = array (
						'weid' => $_W ['weid'],
						'displayorder' => intval ( $_GPC ['displayorder'] ) ,
						'storename' => $_GPC ['storename'],
						'pcharge' => $_GPC ['pcharge'],
						'ptel' => $_GPC ['ptel'],
						'mdcateid' => $_GPC ['mdcateid'],
						'thumb' => serialize($_GPC ['thumb']),
						'tel' => $_GPC ['tel'],
						'isopenm' => $_GPC ['isopenm'],
						'mdwz' => $_GPC ['mdwz'],
						'xj' => $_GPC ['xj'],
						'storelogo' => $_GPC ['storelogo'],
						'address' => $_GPC ['address'],
						'province' => $_GPC['reside']['province'],
						'city' => $_GPC['reside']['city'],
						'district' => $_GPC['reside']['district'],
						'lng' => $_GPC['location']['lng'],
						'lat' => $_GPC['location']['lat'],
						'remark' => $_GPC ['remark'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'menuone'=>$_GPC['menuone'],
						'menuurlone'=>$_GPC['menuurlone'],
						'menuonelogo'=>$_GPC['menuonelogo'],
						'menutwo'=>$_GPC['menutwo'],
						'menuurltwo'=>$_GPC['menuurltwo'],
						'menutwologo'=>$_GPC['menutwologo'],
						'custom_one'=>$_GPC['custom_one'],
						'custom_url_one'=>$_GPC['custom_url_one'],
						'custom_logo_one'=>$_GPC['custom_logo_one'],
						'custom_two'=>$_GPC['custom_two'],
						'custom_url_two'=>$_GPC['custom_url_two'],
						'custom_logo_two'=>$_GPC['custom_logo_two'],
						'custom_three'=>$_GPC['custom_three'],
						'custom_url_three'=>$_GPC['custom_url_three'],
						'custom_logo_three'=>$_GPC['custom_logo_three'],
						'custom_four'=>$_GPC['custom_four'],
						'custom_url_four'=>$_GPC['custom_url_four'],
						'custom_logo_four'=>$_GPC['custom_logo_four'],
						'createtime' => TIMESTAMP,
				);
				if (! empty ( $id )) {
					pdo_update ( STORE_TABLE, $data, array ('id' => $id ) );
				} else {
					pdo_insert ( STORE_TABLE, $data );
					$id = pdo_insertid ();
				}
				message ( '更新门店成功！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'success' );
			}
			include $this->template ( 'web/store' );
		} elseif ($operation == 'delete') {
			$id = intval ( $_GPC ['id'] );
			$category = pdo_fetch ( "SELECT id FROM " . tablename ( STORE_TABLE ) . " WHERE id = '$id'" );
			if (empty ( $category )) {
				message ( '抱歉，门店不存在或是已经被删除！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'error' );
			}
			pdo_delete ( STORE_TABLE, array ('id' => $id ) );
			message ( '门店删除成功！', $this->createWebUrl ( 'store', array ('op' => 'display' ) ), 'success' );
		}elseif($operation == 'commen'){
			$id = intval($_GPC['id']);
			$psize = 20;
			$pindex = max(1, intval($_GPC['page']));
			//$sql = "SELECT * FROM ".tablename(COMMENTS_TABLE)." WHERE weid='{$weid}' AND store_id='{$id}' AND deleted=0 ORDER BY id DESC LIMIT ".($pindex - 1) * $psize . ',' . $psize;
			$conment_list = pdo_fetchall("SELECT * FROM ".tablename(COMMENTS_TABLE)." WHERE weid='{$weid}' AND deleted=0 AND store_id='{$id}' ORDER BY id DESC LIMIT ".($pindex - 1) * $psize . ',' . $psize);
			
			foreach($conment_list as $key => $val){
				$mc_info = pdo_fetch("SELECT uid,nickname,avatar FROM ".tablename('mc_members')." WHERE uniacid='{$weid}' AND uid='{$val['uid']}'");
				$conment_list[$key]['avatar'] = $mc_info['avatar'];
			}
			
			$tosql = "SELECT count(id) FROM ".tablename(COMMENTS_TABLE)." WHERE weid='{$weid}' AND deleted=0 AND store_id='{$id}'";
			$total = pdo_fetchcolumn($tosql);
	    	$pager = pagination($total, $pindex, $psize);
			include $this->template ( 'web/store' );
		}elseif($operation == 'delcom'){
			$common_id = intval($_GPC['cid']);
			$comments = pdo_fetch("SELECT * FROM ".tablename(COMMENTS_TABLE)." WHERE weid='{$weid}' AND deleted=0 AND id='{$common_id}'");
			pdo_update(COMMENTS_TABLE,array('deleted'=>1,'updatetime'=>TIMESTAMP),array('weid'=>$weid,'id'=>$common_id));
			message ( '评论删除成功！', $this->createWebUrl ( 'store', array ('op' => 'commen','id'=>$comments['store_id'] ) ), 'success' );
		}
	}

	//添加模块相同
	public function doWebstoremad(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$btnc = $_GPC['btnc'];
		$content = $_GPC['content'];
		$url = $_GPC['url'];
		$yureid = ($_GPC['yureid']=='undefined') ? '' : $_GPC['yureid'];

		$data = array(
			'weid'=>$weid,
			'storeid'=>$id,
			'btncon'=>$btnc,
			'content'=>$content,
			'url'=>$url,
			'createtime'=>TIMESTAMP,
			);
		if(!empty($yureid)){
			pdo_update(STORE_ATTR_TABLE,$data,array('weid'=>$weid,'id'=>$yureid));
			$returns = array(
				'status'=>1,
				'yureid'=>$yureid,
				);
		}else{
			pdo_insert(STORE_ATTR_TABLE,$data);
			$insterid = pdo_insertid();
			$returns = array(
				'status'=>1,
				'yureid'=>$insterid,
				);
		}

		echo json_encode($returns);
	}

	public function doWebstoremdel(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$yureid = $_GPC['yureid'];
		pdo_delete(STORE_ATTR_TABLE,array('weid'=>$weid,'id'=>$yureid));
		echo 1;
	}

	//用户管理
	public function doWebuser(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$pindex = max(1, intval($_GPC['page']));//当前第几页
		$psize = 10;//每页几条信息
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'post';
		$sql = "select a.*,b.province, b.city , b.district from ".tablename(USER_TABLE)." a left join ".tablename(USER_ATTR_TABLE)." b on a.id=b.mid where a.weid='{$weid}' limit ".($pindex-1)*$psize.",{$psize}";
		$lists = pdo_fetchall($sql);
		$all_sql = "select count(id) as a from ".tablename(USER_TABLE)." where weid='{$weid}'";
		$abc = pdo_fetch($all_sql);
		foreach ($lists as $key => $value) {
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$value['uid']}'";
			$infos = pdo_fetch($sqls);
			$lists[$key]['nickname']=$infos['nickname'];
			$lists[$key]['avatar']=$infos['avatar'];
		}
		$pager = pagination($abc['a'], $pindex, $psize);
		include $this->template('web/user');
	}

	public function doWebshoudetail(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'detail';
		$id = $_GPC['id'];
		$sql = "select c.* ,d.nickname,d.avatar from (select a.*,b.mid,b.city,b.province,b.district from ".tablename(USER_TABLE)." as a , ".tablename(USER_ATTR_TABLE)." as b where a.id=b.mid ) c left join ".tablename('mc_members')." d on c.uid=d.uid where c.weid='{$weid}' and c.id='{$id}'";
		$infos = pdo_fetch($sql);
		$sql_s = "select count(mid) as a from ".tablename(STAT_TABLE)." where weid='{$weid}' and mid='{$id}'";
		$a = pdo_fetch($sql_s);
		$sql_a = "select count(distinct(storeid)) as b from ".tablename(STAT_TABLE)." where weid='{$weid}' and mid='{$id}'";
		$abc = pdo_fetch($sql_a);
		$sql_f = "select count(distinct(classid)) as b from ".tablename(STAT_TABLE)." where weid='{$weid}' and mid='{$id}'";
		$af = pdo_fetch($sql_f);
		include $this->template('web/detail');
	}

	//封号处理
	public function doWebBanuser(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$id = $_GPC['id'];
		$op = $_GPC['op'];
		if($op){
			$update=array(
				'enable'=>1,
				);
			pdo_update(USER_TABLE,$update, array('weid'=>$weid,'id'=>$id));
			message('已解封',$this->createWebUrl('user'),'success');
		}else{
			$update=array(
				'enable'=>2,
				);
			pdo_update(USER_TABLE,$update , array('weid'=>$weid,'id'=>$id));
			message('已封号',$this->createWebUrl('user'),'success');
		}
	}

	//门店统计
	public function doWebstat(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		//门店统计
		$sql_store = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}'";
		$infos_store = pdo_fetchall($sql_store);
		//分类统计
		$sql_class = "select * from ".tablename(CLASS_TABLE)." where weid='{$weid}'";
		$infos_class = pdo_fetchall($sql_class);

		//省统计
		$sql_p = "select province,count(province) as p from ".tablename(STAT_TABLE)." where weid='{$weid}' group by province";
		$infos_p = pdo_fetchall($sql_p);
		//市统计
		$sql_p = "select city,count(city) as ct from ".tablename(STAT_TABLE)." where weid='{$weid}' group by province";
		$infos_c = pdo_fetchall($sql_p);

		$counts = pdo_fetch("select count(id) as a from ".tablename(STORE_TABLE)." where weid='{$weid}'");
		$countc = pdo_fetch("select count(id) as a from ".tablename(CLASS_TABLE)." where weid='{$weid}'");
		$countp = pdo_fetch("select count(DISTINCT(province)) as a from ".tablename(STAT_TABLE)." where weid='{$weid}'");
		$countct = pdo_fetch("select count(DISTINCT(city)) as a from ".tablename(STAT_TABLE)." where weid='{$weid}'");
		include $this->template('web/stat');
	}

	//区域统计
	public function doWebstat1(){
		global $_W, $_GPC;
		$weid = $_W ['uniacid'];
		checklogin ();
		include $this->template('web/stat');
	}

	//分类统计
	// public function doWebstat2(){
	// 	global $_W, $_GPC;
	// 	$weid = $_W ['uniacid'];
	// 	$sql_class = "select * from ".tablename(CLASS_TABLE)." where weid='{$weid}'";
	// 	$infos_class = pdo_fetchall($sql_class);
	// 	include $this->template('web/stat');
	// }

	protected function _Auth()
         	{
         		global $_GPC , $_W;
         		$weid=$_W['uniacid'];
         		if ($_W['container'] != 'wechat') {
         			return $this->returnError('请将该页面分享到微信打开！', '', 'error');
         		}

         		if (!isset($_SESSION['jy_openid']) || empty($_SESSION['jy_openid']) || !isset($_SESSION['uid']) || empty($_SESSION['uid'])){
         			unset($uid);
         		}
         		else
         		{
         			$from_user=$_SESSION['jy_openid'];

         			$member_temp=pdo_fetch("SELECT uid,nickname,follow FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);
         			if(empty($member_temp['nickname']) || $member_temp['uid']==0)
         			{
         				unset($uid);
         			}
         			else
         			{
         				$uid=$member_temp['uid'];
         				$_W['member']['uid']=$uid;
         				unset($member_temp);
         				$huiyuan_temp=pdo_fetch("SELECT nickname FROM ".tablename('mc_members')." WHERE uniacid=".$weid." AND  uid=".$uid);
         				if(empty($huiyuan_temp['nickname']))
         				{
         					unset($uid);
         				}
         			}
         		}
         		if(empty($uid))
         		{
         			if (!empty($_W['openid']) && intval($_W['account']['level']) >= 3) {
         				$accObj = WeiXinAccount::create($_W['account']);
         				$userinfo = $accObj->fansQueryInfo($_W['openid']);
         			}

         			$state = '9yeid-'.$_W['session_id'];

         			$_SESSION['dest_url'] = base64_encode($_SERVER['QUERY_STRING']);

         			$op=$_GPC['op'];

         			$code = $_GET['code'];
         			$from_user=$_W['openid'];

         			if(empty($code)){
         				if($userinfo['subscribe']==0)
         				{
         					$url = $_W['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING'];
         					$callback = urlencode($url);
         					$forward = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$_W['oauth_account']['key'].'&redirect_uri='.$callback.'&response_type=code&scope=snsapi_userinfo&state='.$state.'#wechat_redirect';

         					header("Location: ".$forward);
         				}
         				else
         				{
         					//用户已经关注改公众号了
         					$weid=$_W['uniacid'];

                  //  老胡旧方法
         			  	// 	$fan_temp=pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);

                  /**
                   * 解决袁文涛fans 表唯一问题
                   */
                   $fans_temp=pdo_fetchall("SELECT uniacid FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' ");

                   $fan_temp = '';
                   if(empty($fans_temp[0])){
                      $_isUnique =  false;
                   }else{
                       $_isUnique = 'not';
                   }

                   foreach ($fans_temp as $key => $value) {
                       if($value['uniacid']==$weid){
                           $fan_temp=pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);
                           $_isUnique = true;
                       }
                   }


         					if(!empty($userinfo) && !empty($userinfo['headimgurl']) && !empty($userinfo['nickname']))
         					{
         						$userinfo['avatar'] = $userinfo['headimgurl'];
         						unset($userinfo['headimgurl']);

         						//开启了强制注册，自定义注册
         						$default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));

         						$data = array(
         							'uniacid' => $_W['uniacid'],
         							'email' => md5($_W['openid']).'@9yetech.com'.$op,
         							'salt' => random(8),
         							'groupid' => $default_groupid,
         							'nickname' 		=> stripslashes($userinfo['nickname']),
         							'avatar' 		=> $userinfo['avatar'],
         							'gender' 		=> $userinfo['sex'],
         							'nationality' 	=> $userinfo['country'],
         							'resideprovince'=> $userinfo['province'] . '省',
         							'residecity' 	=> $userinfo['city'] . '市',
         						);
         						$data['password'] = md5($_W['openid'] . $data['salt'] . $_W['config']['setting']['authkey']);
         						if(empty($fan_temp))
         						{
         							$data['createtime'] = TIMESTAMP;
         							pdo_insert('mc_members', $data);
         							$uid = pdo_insertid();
         						}
         						else
         						{
         							pdo_update('mc_members' ,$data ,array('uid'=>$fan_temp['uid']));
         							$uid=$fan_temp['uid'];
         						}



         						$record = array(
         							'openid' 		=> $_W['openid'],
         							'uid' 			=> $uid,
         							'acid' 			=> $_W['acid'],
         							'uniacid' 		=> $_W['uniacid'],
         							'salt' 			=> random(8),
         							'updatetime' 	=> TIMESTAMP,
         							'nickname' 		=> stripslashes($userinfo['nickname']),
         							'follow' 		=> $userinfo['subscribe'],
         							'followtime' 	=> $userinfo['subscribe_time'],
         							'unfollowtime' 	=> 0,
         							'tag' 			=> base64_encode(iserializer($userinfo))
         						);
         						$record['uid'] = $uid;
         						if(empty($fan_temp)&&$_isUnique!='not'&&!$_isUnique)
         						{
         							pdo_insert('mc_mapping_fans', $record);
         						}
         						else
         						{
         							pdo_update('mc_mapping_fans' ,$record ,array('fanid'=>$fan_temp['fanid']));
         						}
         						$_SESSION['jy_openid']=$_W['openid'];
         						$_SESSION['openid']=$_W['openid'];
         						$_SESSION['uid']=$uid;
         					}
         				}
         			}
         			else
         			{
         				//未关注，通过网页授权
         				$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$_W['oauth_account']['key']."&secret=".$_W['oauth_account']['secret']."&code=".$code."&grant_type=authorization_code";
         				load()->func('communication');
         				$response = ihttp_get($url);
         				$oauth = @json_decode($response['content'], true);

         				$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$oauth['access_token']}&openid={$oauth['openid']}&lang=zh_CN";
         				$response = ihttp_get($url);


         				if (!is_error($response)) {

         					$userinfo = array();
         					$userinfo = @json_decode($response['content'], true);

         					$userinfo['avatar'] = $userinfo['headimgurl'];
         					unset($userinfo['headimgurl']);


         					$_SESSION['userinfo'] = base64_encode(iserializer($userinfo));

         						if(!empty($userinfo) && !empty($userinfo['avatar']) && !empty($userinfo['nickname']))
         						{
         							$weid=$_W['uniacid'];

         							$fan_temp=pdo_fetch("SELECT * FROM ".tablename('mc_mapping_fans')." WHERE openid='$from_user' AND uniacid=".$weid);
         							//开启了强制注册，自定义注册
         							$default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
         							$data = array(
         								'uniacid' => $_W['uniacid'],
         								'email' => md5($_W['openid']).'@9yetech.com'.$op,
         								'salt' => random(8),
         								'groupid' => $default_groupid,
         								'nickname' 		=> stripslashes($userinfo['nickname']),
         								'avatar' 		=> rtrim($userinfo['avatar'], '0') . 132,
         								'gender' 		=> $userinfo['sex'],
         								'nationality' 	=> $userinfo['country'],
         								'resideprovince'=> $userinfo['province'] . '省',
         								'residecity' 	=> $userinfo['city'] . '市',
         							);
         							$data['password'] = md5($_W['openid'] . $data['salt'] . $_W['config']['setting']['authkey']);

         							if(empty($fan_temp))
         							{
         								$data['createtime'] = TIMESTAMP;
         								pdo_insert('mc_members', $data);
         								$uid = pdo_insertid();
         							}
         							else
         							{
         								pdo_update('mc_members' ,$data ,array('uid'=>$fan_temp['uid']));
         								$uid=$fan_temp['uid'];
         							}

         							$record = array(
         								'openid' 		=> $oauth['openid'],
         								'uid' 			=> $uid,
         								'acid' 			=> $_W['acid'],
         								'uniacid' 		=> $_W['uniacid'],
         								'salt' 			=> random(8),
         								'updatetime' 	=> TIMESTAMP,
         								'nickname' 		=> stripslashes($userinfo['nickname']),
         								'follow' 		=> $userinfo['subscribe'],
         								'followtime' 	=> $userinfo['subscribe_time'],
         								'unfollowtime' 	=> 0,
         								'tag' 			=> base64_encode(iserializer($userinfo))
         							);
         							$record['uid'] = $uid;

         							if(empty($fan_temp)&&!$_isUnique)
         							{
         								pdo_insert('mc_mapping_fans', $record);
         							}
         							else if($_isUnique=='not'){

                      }
                      else
         							{
         								$temp=pdo_update('mc_mapping_fans' ,$record ,array('fanid'=>$fan_temp['fanid']));
         							}
         							$_SESSION['jy_openid']=$oauth['openid'];
         							$_SESSION['openid']=$oauth['openid'];
         							$_SESSION['uid']=$uid;

         						}

         				} else {
         					$this->returnError('微信授权获取用户信息失败,请重新尝试: ' . $response['message']);
         				}
         			}
         		}
         	}

	protected function returnError($message, $data = '', $status = 0, $type = '')
	{
		global $_W;
		if ($_W['isajax'] || $type == 'ajax') {
			header('Content-Type:application/json; charset=utf-8');
			$ret = array('status' => $status, 'info' => $message, 'data' => $data);
			exit(json_encode($ret));
		} else {
			return $this->returnMessage($message, $data, 'error');
		}
	}

	protected function returnSuccess($message, $data = '', $status = 1, $type = '')
	{
		global $_W;
		if ($_W['isajax'] || $type == 'ajax') {
			header('Content-Type:application/json; charset=utf-8');
			$ret = array('status' => $status, 'info' => $message, 'data' => $data);
			exit(json_encode($ret));
		} else {
			return $this->returnMessage($message, $data, 'success');
		}
	}
	protected function returnMessage($msg, $redirect = '', $type = '')
	{
		global $_W, $_GPC;
		if ($redirect == 'refresh') {
			$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
		}
		if ($redirect == 'referer') {
			$redirect = referer();
		}
		if ($redirect == '') {
			$type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'info';
		} else {
			$type = in_array($type, array('success', 'error', 'info', 'warn')) ? $type : 'success';
		}
		if (empty($msg) && !empty($redirect)) {
			header('location: ' . $redirect);
		}
		$label = $type;
		if ($type == 'error') {
			$label = 'warn';
		}
		include $this->template('inc/message');
		exit();
	}

	//自定义字段
	public function doWebAttr(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();
        load()->func('tpl');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	    if ($operation == 'display') {
	    	
	        if (!empty($_GPC['displayorder'])) {
	            foreach ($_GPC['displayorder'] as $id => $displayorder) {
	                pdo_update('jy_nearby_attr', array('displayorder' => $displayorder), array('id' => $id));
	            }
	            message('自定义字段更新成功！', $this->createWebUrl('attr', array('op' => 'display')), 'success');
	        }
	        $children = array();
	        $category = pdo_fetchall("SELECT * FROM " . tablename('jy_nearby_attr') . " WHERE weid = '{$_W['weid']}' ORDER BY displayorder DESC,id ASC");
	        foreach ($category as $index => $row) {
	            if (!empty($row['parentid'])) {
	                $children[$row['parentid']][] = $row;
	                unset($category[$index]);
	            }
	        }

	        include $this->template('web/attr');
	    } elseif ($operation == 'post') {
	        $parentid = intval($_GPC['parentid']);
	        $id = intval($_GPC['id']);

	        if (!empty($id)) {
	            $category = pdo_fetch("SELECT * FROM " . tablename('jy_nearby_attr') . " WHERE id = '$id'");
	        } else {
	            $category = array(
	                'displayorder' => 0,
	                'type' => 1,
	                'enabled' => 1,
	            );
	        }
	        if (!empty($parentid)) {
	            $parent = pdo_fetch("SELECT id, name FROM " . tablename('jy_nearby_attr') . " WHERE id = '$parentid'");
	            if (empty($parent)) {
	                message('抱歉，该类型不存在或是已经被删除！', $this->createWebUrl('post'), 'error');
	            }
	        }
	        if (checksubmit('submit')) {
	            if (empty($_GPC['catename'])) {
	                message('抱歉，请输入字段名称！');
	            }
	            $data = array(
	                'weid' => $_W['weid'],
	                'name' => $_GPC['catename'],
	                'description' => $_GPC['description'],
	                'enabled' => intval($_GPC['enabled']),
	                'displayorder' => intval($_GPC['displayorder']),
	                'type' => intval($_GPC['type']),
	                'enabled' => intval($_GPC['enabled']),
	                'parentid' => intval($parentid),
	            );

	            if (!empty($id)) {
	                unset($data['parentid']);
	                pdo_update('jy_nearby_attr', $data, array('id' => $id));
	            } else {
	                pdo_insert('jy_nearby_attr', $data);
	                $id = pdo_insertid();
	            }
	            message('更新自定义字段设置成功！', $this->createWebUrl('attr', array('op' => 'display')), 'success');
	        }
	        include $this->template('web/attr');
	    } elseif ($operation == 'delete') {
	        $id = intval($_GPC['id']);
	        $category = pdo_fetch("SELECT id, parentid FROM " . tablename('jy_nearby_attr') . " WHERE id = '$id'");
	        if (empty($category)) {
	            message('抱歉，不存在或是已经被删除！', $this->createWebUrl('attr', array('op' => 'display')), 'error');
	        }
	        pdo_delete('jy_nearby_attr', array('id' => $id, 'parentid' => $id), 'OR');
	        message('删除成功！', $this->createWebUrl('attr', array('op' => 'display')), 'success');
	    }
	}
	//地图
	public function doMobileMap(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$lat = $_GPC['lat'];
		$lng = $_GPC['lng'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$key = $setting['mapkey'];
		include $this->template('map');
	}
	//上传图片
	public function doMobileFabu(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$media_id=$_GPC['media_id'];
	    /*load()->func('file');
	    $WeiXinAccountService = WeiXinAccount::create($_W['oauth_account']);
	    $ret=$WeiXinAccountService->downloadMedia(array(
	        'media_id'=>$media_id,
	        'type'=>'image'
	    ));
	    if(is_error($ret)){
	        echo '图片上传失败:'.$ret['message'];
	        exit;
	    }*/
	    load()->classs('weixin.account');
	    $accObj = WeixinAccount::create($_W['account']['acid']);
	    $access_token = $accObj->fetch_token();
	    load()->func('communication');
	    load()->func('file');
	    $contentType['image/gif'] = '.gif';
	    $contentType['image/jpeg'] = '.jpeg';
	    $contentType['image/png'] = '.png';
	    $contentType['audio/amr'] = '.amr';
	    $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $access_token . '&media_id=' . $media_id;
        $data = ihttp_get($url);
        $filetype = $data['headers']['Content-Type'];
        $filename = date('YmdHis') . '_' . rand(1000000000, 9999999999.0) . '_' . rand(1000, 9999) . $contentType[$filetype];
	    $wr = file_write('/images/jy_nearby/' . $filename, $data['content']);
	    if(empty($filename)){
	    	echo '图片上传失败';exit;
	    }
	    /*if(is_error($ret)){
	        echo '图片上传失败:'.$ret['message'];
	        exit;
	    }*/
	    //echo $_W['siteroot'].'attachment/'.$ret;
	    echo $_W['attachurl'].'/images/jy_nearby/' . $filename;
	    exit;
	    //echo $_W['siteroot'].'attachment/'.$ret;
	    echo $_W['attachurl'].$ret;
	    exit;
	}

	public function doMobileShowform(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		load()->func('tpl');
		$media_id = 'j0NS0Q8TON2daeWNxXdXx_cu6hPxGqx9ZpO7Q8LW59yUzcD_TcyYETruCoJGQ7ER';
	    $WeiXinAccountService = WeiXinAccount::create($_W['oauth_account']);
	    
	    $ret=$WeiXinAccountService->downloadMedia(array(
	        'media_id'=>$media_id,
	        'type'=>'image'
	    ));
	    
		$op = $_GPC['op'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		// var_dump($setting);exit;
		//判断是否有资料
		$openid = $_W['openid'];
		$sql_attr_val = "SELECT * FROM ".tablename('jy_nearby_attr_value')." WHERE mid = '{$openid}' AND weid='{$weid}'";
		$attr_val_info = pdo_fetch($sql_attr_val);
		if($op != 'reply'){
			if(!empty($attr_val_info)){
				if($attr_val_info['state'] == 0){
					include $this->template('zform');
					exit;
				}elseif($attr_val_info['state'] == 1){
					// exit('您的资料审核已通过!');
					include $this->template('cform');
					exit;
				}elseif($attr_val_info['state'] == 2){

					include $this->template('eform');
					exit;
				}
			}
		}else{
			pdo_delete("jy_nearby_attr_value",array('mid'=>$_W['openid']));
			pdo_delete("jy_nearby_business",array('oid'=>$_W['openid']));
		}
		
		//判断是否开启商家入住
		if($setting['isopen'] == 1){
			//$ziliao=pdo_fetchall('SELECT b.enabled,a.name,a.id,a.type FROM '.tablename('jy_nearby_attr')." as a left join ".tablename('jy_nearby_set_attr')." as b on b.attr_id=a.id WHERE a.weid=".$weid."  AND a.enabled=1 AND a.parentid=0 ORDER BY a.displayorder desc");
			$ziliao=pdo_fetchall('SELECT a.enabled,b.name,b.id,b.type FROM '.tablename('jy_nearby_set_attr')." as a left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid."  AND b.parentid=0 ORDER BY b.displayorder desc");
			
			foreach($ziliao as $k => $v){
				if($v['type']==3)
				{
					$xx[$v['id']]=pdo_fetchall("SELECT id,name FROM ".tablename('jy_nearby_attr')." WHERE weid=".$weid." AND parentid=".$v['id']." AND enabled=1 ORDER BY displayorder desc");
				}
			}
			
		}else{

		}

		
		
		if($op == 'add'){

			
			foreach($ziliao as $key => $val){
				// if (!empty($_GPC['zl_'.$val['id']])){
					
					$zl_data = array(
						'weid'=>$weid,
						'attr_id'=>$val['id'],
						'zhi'=>$_GPC['zl_'.$val['id']],
						'mid'=>$_W['openid'],
						'state'=>0,
						'createtime'=>TIMESTAMP,
					);


					// if($val['id'] == 6){
					// 	$mobile = $_GPC['zl_'.$val['id']];
					// }
					pdo_insert("jy_nearby_attr_value",$zl_data);
					$pdo_insertid = pdo_insertid();
				// }
				
			}

			$b_data = array(
				'weid'=>$weid,
				'oid'=>$_W['openid'],
				'createtime'=>TIMESTAMP,
			);

			pdo_insert("jy_nearby_business",$b_data);
			$pdo_bid = pdo_insertid();

			if($pdo_insertid && $pdo_bid){
				echo 1;
				exit;
			}else{
				echo 0;
			}
			
		}
		include $this->template('form');
	}

	//商家入住管理
	public function doWebBusiness(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();
		$op=$_GPC['op'];
		
		if(empty($op))
		{
			$op='display';
			$list = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_business')." WHERE weid =".$weid." order by id desc");
			foreach($list as $key => $val){
				if(!empty($val['oid'])){
					$list[$key]['zl'] = pdo_fetchall("SELECT a.id,a.attr_id,a.zhi,a.mid,a.state,a.createtime,b.name,b.type FROM ".tablename('jy_nearby_attr_value')." as a  left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid." AND a.state=0 AND a.mid = '".$val['oid']."' order by a.id ASC");
				}else{}
				if(empty($list[$key]['zl'])){
					unset($list[$key]);
				}
			}
			
		}

		if($op == 'through')
		{
			$list = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_business')." WHERE weid =".$weid." order by id desc");
			foreach($list as $key => $val){
				if(!empty($val['oid'])){
					$list[$key]['zl'] = pdo_fetchall("SELECT a.id,a.attr_id,a.zhi,a.mid,a.state,a.createtime,b.name,b.type FROM ".tablename('jy_nearby_attr_value')." as a  left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid." AND a.state=1 AND a.mid = '".$val['oid']."' order by a.id ASC");
				}else{}
				if(empty($list[$key]['zl'])){
					unset($list[$key]);
				}
			}
			
		}

		if($op == 'nopass')
		{
			$list = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_business')." WHERE weid =".$weid." order by id desc");
			foreach($list as $key => $val){
				if(!empty($val['oid'])){
					$list[$key]['zl'] = pdo_fetchall("SELECT a.id,a.attr_id,a.zhi,a.mid,a.state,a.createtime,b.name,b.type FROM ".tablename('jy_nearby_attr_value')." as a  left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid." AND a.state=2 AND a.mid = '".$val['oid']."' order by a.id ASC");
				}else{}
				if(empty($list[$key]['zl'])){
					unset($list[$key]);
				}
			}
			
		}

		if($op == 'add'){
			$id = $_GPC['id'];
			$b_info = pdo_fetch("SELECT * FROM ".tablename('jy_nearby_business')." WHERE id = ".$id." AND weid = ".$weid);
			if(!empty($b_info)){
				$b_info['zl'] = pdo_fetchall("SELECT a.id,a.attr_id,a.zhi,a.mid,a.state,a.createtime,b.name,b.type FROM ".tablename('jy_nearby_attr_value')." as a  left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid." AND a.mid = '".$b_info['oid']."' order by a.id ASC");
			}

			if(checksubmit('submit')){
				$bid = $_GPC['bid'];
				$buss_info = pdo_fetch("SELECT * FROM ".tablename('jy_nearby_business')." WHERE id = ".$bid." AND weid = ".$weid);
				$attr_val_list = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_attr_value')." WHERE weid = ".$weid." AND mid = '".$buss_info['oid']."'");
				if(!empty($attr_val_list)){
					$state = $_GPC['status'];
					$data = array(
						'state'=>$state,
					);
					pdo_update('jy_nearby_attr_value', $data, array('mid' => $buss_info['oid']));
				}
				message("设置成功！",$this->createWebUrl('business'),'success');
			}
			
		}

		if($op == 'delete'){
			$id = intval($_GPC['id']);
	        $category = pdo_fetch("SELECT * FROM " . tablename('jy_nearby_business') . " WHERE id = '$id'");
	        if (empty($category)) {
	            message('抱歉，不存在或是已经被删除！', $this->createWebUrl('business', array('op' => 'display')), 'error');
	        }
	        pdo_delete('jy_nearby_business', array('id' => $id));
	        pdo_delete('jy_nearby_attr_value',array('mid'=>$category['oid']));
	        message('删除成功！', $this->createWebUrl('business'), 'success');
		}
		
		include $this->template('web/business');
	}

	//导出数据
	public function doWebBmexport() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();
		
		$attr_list = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_attr')." WHERE weid='{$weid}' AND parentid=0 order by displayorder desc limit 13");
		
		
		$list=pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_business')." WHERE weid='{$weid}'");

		foreach($list as $key1 => $val1){
			$list[$key1]['zl'] = pdo_fetchall("SELECT a.*,b.name,b.type FROM ".tablename('jy_nearby_attr_value')." as a  left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid." AND a.state=0 AND a.mid = '".$val1['oid']."' order by a.id asc;");
			if(empty($list[$key1]['zl'])){
				unset($list[$key1]);
			}
		}
		
		ob_end_clean();

		require_once '../framework/library/phpexcel/PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		// Add some data
		$e_array = array(
			'0'=>'A',
			'1'=>'B',
			'2'=>'C',
			'3'=>'D',
			'4'=>'E',
			'5'=>'F',
			'6'=>'G',
			'7'=>'H',
			'8'=>'I',
			'9'=>'J',
			'10'=>'K',
			'11'=>'L',
			'12'=>'M',
		);
		
		if(!empty($attr_list)){
			foreach($attr_list as $key2 => $val2){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($e_array[$key2].'1', $val2['name']);
			}
		}
		
		$i=2;
		if(!empty($list)){
			foreach ($list as $key => $row) {


				foreach($row['zl'] as $key3 => $val3){
					if(!empty($attr_list)){
						foreach($attr_list as $key4 => $val4){
							if($val3['name'] == $val4['name']){
								
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue($e_array[$key4].$i, $val3['zhi']);
							}else{
								
								
							}
						}
					}

				}
				
				

				$i++;

			}
		}

		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('商家入驻数据'."_".date('Y-m-d'));


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.'商家入驻数据'."_".date('Ymd').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		ob_flush();
		flush();

		message("导出成功",$this->createWebUrl('baoming'),'success');
	}

	public function doWebBmexportpass() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();
		
		$attr_list = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_attr')." WHERE weid='{$weid}' AND parentid=0 order by displayorder desc limit 13");
		
		
		$list=pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_business')." WHERE weid='{$weid}'");

		foreach($list as $key1 => $val1){
			$list[$key1]['zl'] = pdo_fetchall("SELECT a.*,b.name,b.type FROM ".tablename('jy_nearby_attr_value')." as a  left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid." AND a.state=1 AND a.mid = '".$val1['oid']."' order by a.id asc;");
			if(empty($list[$key1]['zl'])){
				unset($list[$key1]);
			}
		}
		
		ob_end_clean();

		require_once '../framework/library/phpexcel/PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		// Add some data
		$e_array = array(
			'0'=>'A',
			'1'=>'B',
			'2'=>'C',
			'3'=>'D',
			'4'=>'E',
			'5'=>'F',
			'6'=>'G',
			'7'=>'H',
			'8'=>'I',
			'9'=>'J',
			'10'=>'K',
			'11'=>'L',
			'12'=>'M',
		);
		
		if(!empty($attr_list)){
			foreach($attr_list as $key2 => $val2){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($e_array[$key2].'1', $val2['name']);
			}
		}
		
		$i=2;
		if(!empty($list)){
			foreach ($list as $key => $row) {


				foreach($row['zl'] as $key3 => $val3){
					if(!empty($attr_list)){
						foreach($attr_list as $key4 => $val4){
							if($val3['name'] == $val4['name']){
								
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue($e_array[$key4].$i, $val3['zhi']);
							}else{
								
								
							}
						}
					}

				}
				
				

				$i++;

			}
		}

		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('商家入驻数据'."_".date('Y-m-d'));


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.'商家入驻数据'."_".date('Ymd').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		ob_flush();
		flush();

		message("导出成功",$this->createWebUrl('baoming'),'success');
	}

	public function doWebBmexportnopass() {
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		checklogin();
		
		$attr_list = pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_attr')." WHERE weid='{$weid}' AND parentid=0 order by displayorder desc limit 13");
		
		
		$list=pdo_fetchall("SELECT * FROM ".tablename('jy_nearby_business')." WHERE weid='{$weid}'");

		foreach($list as $key1 => $val1){
			$list[$key1]['zl'] = pdo_fetchall("SELECT a.*,b.name,b.type FROM ".tablename('jy_nearby_attr_value')." as a  left join ".tablename('jy_nearby_attr')." as b on a.attr_id=b.id WHERE a.weid=".$weid." AND a.state=2 AND a.mid = '".$val1['oid']."' order by a.id asc;");
			if(empty($list[$key1]['zl'])){
				unset($list[$key1]);
			}
		}
		
		ob_end_clean();

		require_once '../framework/library/phpexcel/PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		// Add some data
		$e_array = array(
			'0'=>'A',
			'1'=>'B',
			'2'=>'C',
			'3'=>'D',
			'4'=>'E',
			'5'=>'F',
			'6'=>'G',
			'7'=>'H',
			'8'=>'I',
			'9'=>'J',
			'10'=>'K',
			'11'=>'L',
			'12'=>'M',
		);
		
		if(!empty($attr_list)){
			foreach($attr_list as $key2 => $val2){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($e_array[$key2].'1', $val2['name']);
			}
		}
		
		$i=2;
		if(!empty($list)){
			foreach ($list as $key => $row) {


				foreach($row['zl'] as $key3 => $val3){
					if(!empty($attr_list)){
						foreach($attr_list as $key4 => $val4){
							if($val3['name'] == $val4['name']){
								
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue($e_array[$key4].$i, $val3['zhi']);
							}else{
								
								
							}
						}
					}

				}
				
				

				$i++;

			}
		}

		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('商家入驻数据'."_".date('Y-m-d'));


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.'商家入驻数据'."_".date('Ymd').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');

		ob_flush();
		flush();

		message("导出成功",$this->createWebUrl('baoming'),'success');
	}
}