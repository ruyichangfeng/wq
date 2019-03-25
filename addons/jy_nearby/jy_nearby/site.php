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
define('USER_TABLE', 'jy_nearby_user');
define('USER_ATTR_TABLE', 'jy_nearby_user_attr');
define('NEARBY_CSS', '../addons/jy_nearby/static/css/');
define('NEARBY_JS', '../addons/jy_nearby/static/js/');
define('NEARBY_IMAGE', '../addons/jy_nearby/static/images/');
define('STAT_TABLE', 'jy_nearby_stat');
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
		include $this->template('getLoc');
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
		$sta = $_GPC['sta'] ? $_GPC['sta'] : 1;
		$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$title = $setting['title'];
		/*获取幻灯片*/
		$sql = "select * from ".tablename(BANNER_TABLE)." where weid='{$weid}' and status=1";
		$baners = pdo_fetchall($sql);

		/*获取首页导航*/
		$sql_type = "select * from ".tablename(INDEX_TABLE)." where weid='{$weid}' and enabled=1";
		$types = pdo_fetchall($sql_type);

		/*获取门店信息*/
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 limit 0,5";
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
		include $this->template('index');
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
		
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		if($_SESSION['posi']){
			$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
		}
		$do = $_GPC['do'];
		$act = "dis";
		$id = $_GPC['pid'];
		$update = "update ".tablename(CLASS_TABLE)." set visit = visit+1 where weid='{$weid}' and id='{$id}'";
		pdo_query($update);
		/*获取分类信息*/
		$sql = "select catename from ".tablename(CLASS_TABLE)." where weid='{$weid}' and id='{$id}'";
		$class = pdo_fetch($sql);
		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' and lng <>0 and lat <>0 limit 0,5";
		$stores = pdo_fetchall($stores_sql);
		$newarr = array();
		foreach ($stores as $k => $v) {
			$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
			$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
			$stores[$k]['disc'] = round(($discont/1000),2);
			$newarr[$k][]=round(($discont/1000),2);
		}
		$stores = $this->array_sort($stores,'disc');
		include $this->template('type');
	}

	//最新
	public function doMobileTlist(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		if($_SESSION['posi']){
			$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
		}
		$do = $_GPC['do'];
		$act = "new";
		$id = $_GPC['pid'];
		$sql = "select catename from ".tablename(CLASS_TABLE)." where weid='{$weid}' and id='$id'";
		$class = pdo_fetch($sql);
		$title = $class['catename'];
		/*获取设置信息*/
		$sql_set = "select * from ".tablename(SETTING_TABLE)." where weid='{$weid}'";
		$setting = pdo_fetch($sql_set);
		$stores_sql = "select * from ".tablename(STORE_TABLE)." where weid='{$weid}' and enabled=1 and mdcateid='{$id}' order by id desc limit 0,5 ";
		$stores = pdo_fetchall($stores_sql);
		foreach ($stores as $k => $v) {
			if($v['lat']&&$v['lng']){
				$dd = $this->Convert_GCJ02_To_BD09($v['lat'],$v['lng']);
				$discont = $this->GetDistance($dd['lat'],$dd['lng'],$_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
				$stores[$k]['disc'] = round(($discont/1000),2);
			}
		}
		include $this->template('type');
	}

	public function doMobileshowDetail(){
		global $_W,$_GPC;
		$weid=$_W['uniacid'];
		$this->_Auth();//获取用户信息
		$this->__douser();//存储用户信息
		if($_SESSION['posi']){
			$this->__cull($_SESSION['posi']['lat'],$_SESSION['posi']['lng']);
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
		$updatesql = "update ".tablename(STAT_TABLE)." set storeid='{$id}',classid='{$infos['mdcateid']}' where weid='{$weid}' and id='{$_SESSION['statid']}'";
		pdo_query($updatesql);
		include $this->template('showdetail');
		
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
				'updatetime'=>TIMESTAMP,
				);
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
	        if(!empty($_GPC['keyword']))
	        {
	        	$condition.=" AND a.title LIKE '%{$_GPC['keyword']}%' ";
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
	            if (empty($_GPC['catename'])) {
	                message('抱歉，请输入Banner名称！');
	            }
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
			include $this->template ( 'web/class' );
		}elseif ($operation == 'post') {
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
						'remark' => $_GPC ['remark'],
						'enabled' => intval ( $_GPC ['enabled'] ),
						'displayorder' => intval ( $_GPC ['displayorder'] ) ,
						'createtime' => TIMESTAMP
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
			$list = pdo_fetchall ( "SELECT a.*,b.catename FROM " . tablename ( STORE_TABLE ) . " a left join ".tablename( CLASS_TABLE )." b on a.mdcateid=b.id WHERE a.weid = '{$_W['weid']}' ORDER BY a.id ASC" );
			include $this->template ( 'web/store' );
		}elseif ($operation == 'post') {
			$id = intval ( $_GPC ['id'] );
			if (! empty ( $id )) {
				$item = pdo_fetch ( "SELECT * FROM " . tablename ( STORE_TABLE ) . " WHERE id = '$id'" );
				$item['thumbs'] = unserialize($item['thumb']);
			} else {
				$item = array (
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
						'storename' => $_GPC ['storename'],
						'mdcateid' => $_GPC ['mdcateid'],
						'thumb' => serialize($_GPC ['thumb']),
						'tel' => $_GPC ['tel'],
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
						'createtime' => TIMESTAMP
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
		}
	}

	//用户管理
	public function doWebuser(){
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		checklogin();
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'post';
		$sql = "select a.*,b.province, b.city , b.district from ".tablename(USER_TABLE)." a left join ".tablename(USER_ATTR_TABLE)." b on a.id=b.mid where a.weid='{$weid}'";
		$lists = pdo_fetchall($sql);
		foreach ($lists as $key => $value) {
			$sqls = "select nickname,avatar from ".tablename('mc_members'). " where uniacid='{$weid}' and uid = '{$value['uid']}'";
			$infos = pdo_fetch($sqls);
			$lists[$key]['nickname']=$infos['nickname'];
			$lists[$key]['avatar']=$infos['avatar'];
		}
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
         							'createtime' => TIMESTAMP,
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
         								'createtime' => TIMESTAMP,
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
}