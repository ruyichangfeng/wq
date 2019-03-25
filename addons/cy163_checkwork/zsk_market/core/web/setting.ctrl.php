 <?php
 !defined('ZSK_PREFIX') && define('ZSK_PREFIX','azsk_shop');
 class Setting extends ZskPage
 {

    const GOODS = '商品';
    const GOODSCATE = '分类';
    const WEBURL = '网页';
    const WXAPP = '小程序';
    const MOBILE = '拨号';
    const SHOPLIST = '店铺列表';
    const FIND = '专题';
    const AGENT_CENTER = '推客中心';
    const COUPON_CENTER = '领劵中心';
    const CONTACT = '关于我们';
    const INDEX_PINTUAN = '拼团首页';
    const INDEX_MIAOSHA = '秒杀首页';
    const INDEX_KANJIA = '砍价首页';
    const INDEX_FIND = '发现首页';
    const INDEX_JOIN = '商家入驻';
    const ORDER_MY = '我的订单';
    const COLLECT = '我的收藏';
    const SHOP_ID = '店铺ID';
    const WU = '无';

    public $eventList = [
            'goods'=> Setting::GOODS,
            'cate'=> Setting::GOODSCATE,
            'weburl'=> Setting::WEBURL,
            'wxapp'=> Setting::WXAPP,
            'mobile'=> Setting::MOBILE,
            'shoplist'=> Setting::SHOPLIST,
            'find'=> Setting::FIND,
            'agent_center'=> Setting::AGENT_CENTER,
            'coupon_center'=> Setting::COUPON_CENTER,
            'about'=> Setting::CONTACT,
            'index_pintuan'=> Setting::INDEX_PINTUAN,
            'index_miaosha'=> Setting::INDEX_MIAOSHA,
            'index_kanjia'=> Setting::INDEX_KANJIA,
            'index_find'=> Setting::INDEX_FIND,
            'index_join'=> Setting::INDEX_JOIN,
            'order_my'=> Setting::ORDER_MY,
            'collect'=> Setting::COLLECT,
            'shopid'=> Setting::SHOP_ID,
            'wu'=> Setting::WU,
        ];
    public function doWebcheckdb2(){
		//导入数据库结构json
		$debug=true;
		include ZSK_PATH."/libs/checkdb.php";
		die("操作完成");
	}
	public function index2(){
		//导入数据库结构json
		global $_W;
		$records=array();
		$tabs=pdo_fetchall("SHOW TABLES LIKE '%".ZSK_PREFIX."%'");
		$tables=array(); 
		foreach ($tabs as $sss => $ss) {  
			$tt=array_values($ss); 
			$tab=$tt[0];
			$table=pdo_fetchall("desc `$tab`");
			$s=strpos($tab,ZSK_PREFIX); 
			$tab2=substr($tab,$s,strlen($tab)-$s);
			$tables[$tab2]=$table; 
		} 
		$content=file_get_contents(ZSK_PATH.'/libs/checkdb.bak.php');
		$jj=fopen(ZSK_PATH."/libs/checkdb.php", "w+") or die("打开checkdb失败"); 
		$stream=str_replace('There is a json string', json_encode($tables) , $content);
		fwrite($jj,$stream);
		fclose($jj);  
		$strpos=stripos($stream,"update-end");
		 
		$jj=fopen(ZSK_PATH."/libs/checkdb.tab.php", "w+") or die("打开checkdb2失败"); 
		$stream2=substr($stream,0,$strpos);
		fwrite($jj,$stream2);
		fclose($jj); 
		die("输出完成");
	}
 	public function getSetting(){
 		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$setting=$model->where("uniacid=".$uniacid)->get();
		$setting['wx_conf']=json_decode($setting['wx_conf'],true);
		$setting['wxpay']=json_decode($setting['wxpay'],true);
		$setting['wxapp_layout']=json_decode($setting['wxapp_layout'],true); 
		$setting['kdniao']=json_decode($setting['kdniao'],true); 
		return $setting;
 	}
 	public function index(){  
 		global $_W; 
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("setting");
 		$setting=getSetting("pay",true);
 		$layout=$setting['wxapp_layout'];  
 		$wxconf=$setting['wx_conf'];
 		$tabc= tablename("account_wechats");
		$sql="SELECT uniacid,name,`key`,secret FROM $tabc WHERE `level`=4 ";
		$wechats=pdo_fetchall($sql); 
		$copyright=Model("copyright")->where(" uniacid=$uniacid ")->get();
		if(empty($copyright)){
			Model("copyright")->add(array("uniacid"=>$uniacid,'id'=>$uniacid));
		}
		$provinces=json_decode(file_get_contents(ZSK_STATIC."datas/province.json"),true);
		$citys=json_decode(file_get_contents(ZSK_STATIC."datas/city.json"),true);
		$kdniao=$setting['kdniao'];
		$plat_pusher=Model("pusher")->where("uniacid=".$uniacid." and type=5")->get();
		//读取当前系统版本
		$xml = simplexml_load_string(file_get_contents(ZSK_PATH.'/manifest.xml'),'SimpleXMLElement', LIBXML_NOCDATA); 
		//$xml = simplexml_load_file(ZSK_PATH.'/manifest.xml','SimpleXMLElement', LIBXML_NOCDATA);
		$version=$xml->application->version;
 		include $this->template("web/setting/index");
 		//$this->base(); 
 	}
 	//系统配置
 	public function configview(){
 		$chk=$this->checkConfig();
 		include $this->template("web/setting/config");
 	}
 	//基础设置
 	public function base(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("setting");
 		$setting=$model->where("uniacid=$uniacid")->get(); 
 		include $this->template("web/setting/index");
 	}
 	public function payset(){//支付配置
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("setting");
 		$setting=$model->where("uniacid=$uniacid")->get(); 
 		include $this->template("web/setting/index");
 	}
 	public function expset(){//快递配置
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("setting");
 		$setting=$model->where("uniacid=$uniacid")->get(); 
 		include $this->template("web/setting/index");
  	}
 	// public function mailset(){//
 	// 	global $_W,$_GPC;
 	// 	$uniacid=intval($_W['uniacid']);
 	// 	$model=Model("setting");
 	// 	$setting=$model->where("uniacid=$uniacid")->get(); 
 	// 	include $this->template("web/setting/index");

 	// }
 	public function wxset(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);
 		$model=Model("setting");
 		$setting=$model->where("uniacid=$uniacid")->get(); 
 		$wxconf=json_decode($setting['wx_conf'],true);
 		$tabc= tablename("account_wechats");
		$sql="SELECT uniacid,name,`key`,secret FROM $tabc WHERE `level`=4 ";
		$wechats=pdo_fetchall($sql); 
 		include $this->template("web/setting/index");
 	}
 	//公众号提醒设置
 	public function saveWx(){ 
 		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$set=array(
			"wx_auth_uniacid"=>$_GPC['auth_uniacid'],
			"wx_conf"=>json_encode(
				array(
					"appid"=>trim($_GPC['wx_appid']),
					"secret"=>trim($_GPC['wx_secret']),
					"tplid_order_new"=>trim($_GPC['tplid_order_new']),
					"tplid_pintuan_send"=>trim($_GPC['tplid_pintuan_send']),
					"tplid_refund_toadmin"=>trim($_GPC['tplid_refund_toadmin']),
					"tplid_withdraw_apply"=>trim($_GPC['tplid_withdraw_apply']) 
				)
			)
		);  

		$this->save($set,"uniacid=".intval($_W['uniacid'])); 
		$set=array(
			"mail_sender"=>$_GPC['email'],
			"mail_code"=>$_GPC['code']
		); 
		$this->save($set,"uniacid=".intval($_W['uniacid'])); 
		message("保存成功",$this->routeUrl("setting.index"));
 	}
 	//小程序消息模板id
 	public function saveWxappTpl(){
 		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$set=array( 
			"wxapp_conf"=>json_encode(
				array(
					"tplid_order_ok"=>trim($_GPC['tplid_order_ok']),
					"tplid_order_send"=>trim($_GPC['tplid_order_send']),
					"tplid_order_refund"=>trim($_GPC['tplid_order_refund']),
					"tplid_pintuan_ok"=>trim($_GPC['tplid_pintuan_ok']),
					"tplid_pintuan_fail"=>trim($_GPC['tplid_pintuan_fail']),
					"tplid_withdraw_ok"=>trim($_GPC['tplid_withdraw_ok']),
					"tplid_withdraw_fail"=>trim($_GPC['tplid_withdraw_fail']),
					"tplid_activity_start"=>trim($_GPC['tplid_activity_start'])
				)
			) 
		);  
		$model->where("uniacid=".intval($_W['uniacid']))->save($set);
		  
		message("保存成功",$this->routeUrl("setting.index"));
 	}
 	public function saveExp(){ 
 		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$setting=getSetting("pay",true);
		$wxpay=$setting['wxpay'];
		$wxapp_conf=$setting['wxapp_conf'];
		$wxapp_conf['tencentmap_key']=trim($_GPC['map_key']);
		$wxpay['sendway_self']=intval($_GPC['sendway_self']);
		$kdniao=$setting['kdniao'];
		$kdniao['userid']=$_GPC['kduserid'];
		$kdniao['apikey']=$_GPC['kdapikey'];
		 
		$sett=array("kdniao"=>json_encode($kdniao,JSON_UNESCAPED_UNICODE),"wxpay"=>json_encode($wxpay,JSON_UNESCAPED_UNICODE),"wxapp_conf"=>json_encode($wxapp_conf,JSON_UNESCAPED_UNICODE));

		$model->where("uniacid=".intval($_W['uniacid']))->save($sett); 
		 
	 	message("保存成功",$this->routeUrl("setting.index"));
 	}
 	public function saveBase(){
 		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$set=array(
			"appid"=>trim($_GPC['appid']),
			"secret"=>trim($_GPC['secret']),
			"name"=>trim($_GPC['name']),
			//"about"=>trim($_GPC['about']),
			"phone"=>trim($_GPC['phone'])
		);
		
		Model("copyright")->where("uniacid=$uniacid")->save(array("about"=>$_GPC['about'],"power"=>$_GPC['power']));
		$model->where("uniacid=$uniacid")->save($set,"uniacid=".intval($_W['uniacid'])); 
		message("保存成功",$this->routeUrl("setting.index"));
 	}
 	//保存发件邮箱配置
 	public function saveMail(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$set=array(
			"mail_sender"=>trim($_GPC['email']),
			"mail_code"=>trim($_GPC['code'])
		); 
		$this->save($set,"uniacid=".intval($_W['uniacid'])); 
		message("保存成功",$this->routeUrl("setting.index"));
	}
	public function savePay(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$wxpay=array(
			"mchid"=>trim($_GPC['mchid']),
			"key"=>trim($_GPC['key']),
			"payway_wx"=>intval($_GPC['payway_wx']),
			"payway_daofu"=>intval($_GPC['payway_daofu']), 
			"auto_reach"=>intval($_GPC['auto_reach']),//没做功能的，所以没放出来
			"auto_close"=>intval($_GPC['auto_close'])//没做功能的，所以没放出来
		);
		$set=array(
			"wxpay"=>json_encode($wxpay,JSON_UNESCAPED_UNICODE),
			"keypem"=>$_POST['keypem'],
			"certpem"=>$_POST['certpem']
		); 
		
		$model->where("uniacid=".intval($_W['uniacid']))->limit(1)->save($set);
		$setting=getSetting("pay",true);
		$pay=new Wxpay($setting);
		$res=$pay->saveCert();//重新保存证书
		$pay->pubkey(true);
		if($res===false){
			message("写入权限不足，保存证书失败！");
		} 
		message("保存成功",$this->routeUrl("setting.index"));
	}
	public function save($data,$where){
		//先校验当前账号是否有权限
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		$conf=$model->where($where)->get();
		if(intval($conf['uniacid'])>0){
			$res=$model->limit(1)->where($where)->save($data);
		}else{
			$data['uniacid']=$uniacid;
			$res=$model->add($data);
		} 
	} 
	//小程序端样式开关
	function saveLayout(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		if($_W['role']=="operator"){
			message("权限不足");
		} 
		//$set0=getSetting("all",true);
		$set0=$this->getSetting();
		$layout=$set0['wxapp_layout'];
		
		$layout['details_swiper_scale']=floatval($_GPC['details_swiper_scale']);//商品详情轮播比例
		$layout['tabbar_cate_status']=$_GPC['tabbar_cate_status']=="on"?"on":"off";//导航栏 - 分类
		$layout['tabbar_miaosha_status']=$_GPC['tabbar_miaosha_status']=="on"?"on":"off";//导航栏 - 秒杀
		$layout['tabbar_find_status']=$_GPC['tabbar_find_status']=="on"?"on":"off";//导航栏 - 发现
		$layout['tabbar_cart_status']=$_GPC['tabbar_cart_status']=="on"?"on":"off";//导航栏 - 购物车
		$layout['tabbar_kanjia_status']=$_GPC['tabbar_kanjia_status']=="on"?"on":"off";//导航栏 - 砍价
		$layout['tabbar_snap_status']=$_GPC['tabbar_snap_status']=="on"?"on":"off";//导航栏 - 一元抢购
		$layout['tabbar_pintuan_status']=$_GPC['tabbar_pintuan_status']=="on"?"on":"off";//导航栏 - 拼团
		$layout['mine_about_status']=$_GPC['mine_about_status']=="on"?"on":"off"; //个人中心关于我们
		$layout['mine_phone_status']=$_GPC['mine_phone_status']=="on"?"on":"off"; //联系我们，电话
		$layout['mine_wechat_status']=$_GPC['mine_wechat_status']=="on"?"on":"off"; //联系我们，客服
		$layout['mine_pintuan_status']=$_GPC['mine_pintuan_status']=="on"?"on":"off"; //我的拼团
		$layout['mine_agent_status']=$_GPC['mine_agent_status']=="on"?"on":"off"; //分销中心
		$layout['mine_join_status']=$_GPC['mine_join_status']=="on"?"on":"off"; //商家入驻 
 		$layout['mine_kanjia_status']=$_GPC['mine_kanjia_status']=="on"?"on":"off"; //商家入驻
 		$layout['mine_couponcenter_status']=$_GPC['mine_couponcenter_status']=="on"?"on":"off"; //领券中心
 		$layout['mine_coupon_status']=$_GPC['mine_coupon_status']=="on"?"on":"off"; //我的优惠券
		$set['wxapp_layout']=json_encode($layout,JSON_UNESCAPED_UNICODE);

		$model->where("uniacid=$uniacid")->limit(1)->save($set);
		message("保存成功1",$this->routeUrl("setting.index"));
	}
	//调试模式、审核模式
	function saveMode(){
		global $_W,$_GPC;
		$uniacid=intval($_W['uniacid']);
		$model=Model("setting"); 
		if($_W['role']=="operator"){
			message("权限不足");
		} 
		$set0=$this->getSetting();
		$layout=$set0['wxapp_layout'];
		$layout['index_verify_mode']=$_GPC['index_verify_mode'];//计算器tool网页weburl关闭off
		$layout['index_verify_weburl']=$_GPC['index_verify_weburl'];
		$url=trim($_GPC['index_verify_weburl']);
		if(strlen($url)>0){   
			if(stripos($url,"http")===false ){
				$url="https://".$url;
			}
			$url=str_ireplace("http://", "https://",$url);
			$layout['index_verify_weburl']=$url;
		} 
		if(isset($_GPC['index_verify_version'])&& strlen($_GPC['index_verify_version'])>2){
			$layout['index_verify_version']=$_GPC['index_verify_version'];//本次审核版本
		} 
		$layout['debug_mode']=$_GPC['debug_mode'];//线上版调试模式

		$set['wxapp_layout']=json_encode($layout,JSON_UNESCAPED_UNICODE);
		$model->where("uniacid=$uniacid")->limit(1)->save($set);
		 
		message("保存成功",$this->routeUrl("setting.index"));
	}
	 public function delKefu(){
	 	global $_W,$_GPC;
	 	$uniacid=intval($_W['uniacid']);
	 	$shopid=getShopID();
	 	$id=intval($_GPC['id']);
	 	$model=Model("pusher");
	 	$model->limit(1)->delete("uniacid=$uniacid and id=$id  ");
		 
	 	 message("删除成功",$this->routeUrl("setting.index"));
	 }
	public function checkConfig(){
 		global $_W;   
 		$uniacid=intval($_W['uniacid']);
 	 	$file=ZSK_CERTPATH."public_0.pem";
 	 	$h=fopen($file, "w+");
 	 	$writeable=fwrite($h, "");
 	 	fclose($h);  
 	 	$root=str_ireplace("http://", "https://", $_W['siteroot']);
 	 	$url=$root."app/index.php?i=".$uniacid."&t=0&v=6.0.1&from=wxapp&c=entry&a=wxapp&do=route&&m=zsk_market&sign=3840271b429709f8e64fa9b120d4d161&act=home.getSetting";
 	 	$ress=CURL_send($url);
 	 	
 	 	$res=array(
 	 		"version_php"=>0,"openssl_local"=>0,"func_exec"=>1,"openssl_php"=>0,"https"=>0
 	 	);
 	 	if(intval($ress['id'])>0){
 	 		$res['https']=1;
 	 	}else{
 	 		$res['https']=-1;
 	 	}
 	 	//通过将案例证书进行加解密检测是否开启配置
 	 	$res['version_php']=version_compare(PHP_VERSION, "5.6.0");
 	 	$sh="openssl rsa -RSAPublicKey_in -in ".ZSK_CERTPATH."public_rsa.pem -pubout -out ".ZSK_CERTPATH."public_0.pem";
 	 	shell_exec($sh);
 	 	$content1=str_replace("\n","",trim(file_get_contents(ZSK_CERTPATH."public_0.pem")));
 	 	$content2=str_replace("\n","",trim(file_get_contents(ZSK_CERTPATH."public.pem")));
 	 	$content1=str_replace("\r","",$content1);
 	 	$content2=str_replace("\r","",$content2);
 	 	 
 	 	if($content1!=$content2){
 	 		$res['openssl_local']=-1;
 	 	}else{
 	 		$res['openssl_local']=1;
 	 	}
 	 	$dis=ini_get("disable_functions");

 	 	$disabled=explode(",",$dis);
 	 	  
 	 	foreach ($disabled as $key => $val) {
 	 		if($val=="shell_exec"){
 	 			$res['func_exec']=-1;
 	 		}
 	 	}
 	 	$pu_key =openssl_pkey_get_public(file_get_contents(ZSK_CERTPATH."public.pem"));
		$encryptedBlock = '';
		$encrypted = '';
		// 用标准的RSA加密库对敏感信息进行加密，选择RSA_PKCS1_OAEP_PADDING填充模式
		// （eg：Java的填充方式要选 " RSA/ECB/OAEPWITHSHA-1ANDMGF1PADDING"）
		// 得到进行rsa加密并转base64之后的密文
	 
		if($writeable===false){
			$res['file_write']=false;
		}else{
			$res['file_write']=true;
		}
		$str="test...";
		$res['php-openssl']=openssl_public_encrypt($str,$encryptedBlock,$pu_key,OPENSSL_PKCS1_OAEP_PADDING);
		if(!$res['php-openssl']){
			$res['openssl_php']=-1;
		}else{
			$res['openssl_php']=1;
		}
 	 	return $res;
 	}

     public function advertisement(){
         global $_W,$_GPC;
         $shopid=getShopID();
         $uniacid=intval($_W['uniacid']);
         $modelAdvertisement=Model("advertisement");
         $where="uniacid=".$uniacid;
         if($_GPC['name1']){
             $where.=" and name like '%".$_GPC['name1']."%'";
         }
         $page = $modelAdvertisement->where($where)->limit(10)->order("id desc")->page("*");
         $advertisement=$page['dataset'];
         $modelCategory=Model("category");

         $setting = new Setting();
         $eventList = $this->eventList;
         $category=$modelCategory->where("uniacid=$uniacid and parentid < 1")->getall();
         $finds=Model("find")->where("uniacid=$uniacid and type=2 ")->order("id desc")->getall("id,content");
         $cates=Model("category")->where("uniacid=$uniacid")->getall("id,name");
         include $this->template("web/setting/advertisement");
     }

     public function editsave(){
         global $_W,$_GPC;
         $shopid=getShopID();
         $uniacid=intval($_W['uniacid']);
         if(is_mode() == 'POST'){
             $data = array(
                 'name'=>$_GPC['name'],
                 'advert_type'=>$_GPC['advert_type'],
                 'up_images'=>$_GPC['up_images'],
                 'weight'=>$_GPC['weight'],
                 'event'=>$_GPC['event'],
                 'compile'=>$_GPC['compile'],
             );
             if($data['advert_type'] == 2){
                 $data['fill'] = $_GPC['matching'];
             }else if($data['advert_type'] == 3){
                 $data['fill'] = $_GPC['goods_classify'];
             }
             $advertisementModel = $this->model('advertisement');
             if($_GPC['id']){
                 $res = $advertisementModel->where('id = '.$_GPC['id'])->save($data);
             }else{
                 $data['uniacid'] = $uniacid;
                 $data['shopid'] = $shopid;
                 $data['date'] = date('Y-m-d H:i:s',time());
                 $res = $advertisementModel->add($data);
             }
             if($res){
                 message("提交成功",$this->routeUrl("setting.advertisement"));
             }else{
                 message("提交失败");
             }

         }

     }

     public function advertisementid(){
         global $_W,$_GPC;
         if(is_mode() == 'POST'){
             $shopid=getShopID();
             $uniacid=intval($_W['uniacid']);
             $where="uniacid=".$uniacid.' and id='.$_GPC['id'];
             $modelAdvertisement=Model("advertisement");
             $advertisement = $modelAdvertisement->where($where)->get();
             $advertisement['url'] = ZSK_STATIC;
             $advertisement['attachurl'] = $_W['attachurl'];
             if($advertisement){
                 echo getInfo(true,'',$advertisement);
             }else{
                 echo getInfo(true,'错误提交');
             }
         }
     }

     public function deladv(){
         global $_W,$_GPC;
         $uniacid=intval($_W['uniacid']);
         $shopid=getShopID();
         $id=intval($_GPC['id']);
         $model=Model("advertisement");
         $model->limit(1)->delete("uniacid=$uniacid and id=$id  ");
         message("删除成功",$this->routeUrl("setting.advertisement"));
     }
     // 顶部公告列表
     public function announcement(){
     	global $_W,$_GPC;
     	$page =Model("announcement")->where("uniacid=".$_W['uniacid'])->page();
        $visitList=$page['dataset'];
        $page['url'] = $this->routeUrl('setting.announcement');
     	include $this->template("web/setting/announcement");
     }
     //添加公告
      public function addannouncement(){
      	global $_W,$_GPC;
      	if($_GPC['id']){
            $uniacid=intval($_W['uniacid']);
            $data = Model("announcement")->where('id='.$_GPC['id'].' and uniacid='.$uniacid)->get();
        }
      	include $this->template("web/setting/addannouncement");
      }
      //保存公告
      public function saveannouncement(){
      	global $_W,$_GPC;
      	$data['title'] = $_GPC['title'];
      	$data['text'] = $_GPC['text'];
      	$data['starttime'] = time();
      	$data['endtime'] = strtotime($_GPC['endtime'])+86400;
      	$data['uniacid'] = $_W['uniacid'];
      	if($_GPC['id']){
            Model("announcement")->where('id='.$_GPC['id'])->save($data);
        }else{
            Model("announcement")->add($data);
        }
      	message("保存成功",$this->routeUrl("setting.announcement"));
      }
      //删除短信
	public function delMember(){
 		global $_W,$_GPC;
 		$uniacid=intval($_W['uniacid']);  
 		$memberid=intval($_GPC['memberid']);
 		Model("announcement")->where("id=".$memberid)->limit(1)->delete(); 
 		message("删除成功",$this->routeUrl("setting.announcement"));
 	}
}