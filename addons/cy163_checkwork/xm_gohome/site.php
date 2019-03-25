<?php
/**
 * @author 欣媒科技
 * @url http://www.n3.cn/ 
 */

defined('IN_IA') or exit('Access Denied');
define('POSTURL', 'http://cloud.n3.cn/gohome/');
define('SEND_SMS', POSTURL.'sms/sendsms_v2.php');
//define('SEND_SMS', 'http://dm.n3.cn/sms/sendsms_v2.php');
define('DBTACC', '');
define('DBTBBK', '');

require_once 'repair.php';

class Xm_gohomeModuleSite extends WeModuleSite {
	
	function __construct()
	{
		global $_W;
		$this->weid  = $_W['uniacid'];
		$this->temp  = 'u';
		$this->temp1 = 'staff/s';
		
		$item = pdo_fetch("select id,logo,title,banquan,key_info from ".tablename('xm_gohome_base')." where weid=".$_W['uniacid']);
		$this->logo    = $item['logo'];
		$this->title   = $item['title'];
		$this->banquan = $item['banquan'];
		
		if($item['key_info'] == '' || empty($item['key_info'])){
			$data_p['site'] = $_SERVER['HTTP_HOST'];
			$data_p['app'] = 'gohome';
			$url = POSTURL."getkey.php";
			$res = $this->post($url, $data_p, 5);
			$res = str_replace('(','',$res);
			$res = str_replace(')','',$res);
			
			$arr = json_decode($res,true);
			if(substr(trim($arr['key']),0,5) != 'error'){
				$data['key_info'] = $arr['key'];
				if(empty($item['id'])){
					$data['weid'] = $_W['uniacid'];
					$result = pdo_insert('xm_gohome_base',$data);
				}else{
					$result = pdo_update('xm_gohome_base', $data, array('id'=>$item['id']));
				}
			}
			$this->key_info = $arr['key'];
		}else{
			$this->key_info = $item['key_info'];
		}
	}
	
	function uploadImage($image,$path,$filename){
		global $_W,$_GPC;

		load()->classs('weixin.account');
		$accObj= WeixinAccount::create($acid);
		$access_token = $accObj->fetch_token();
			
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$image."";
		$img = file_get_contents($url);
		if(empty($filename)){
			$filename = date('YmdHis').'.jpg';
		}
		
		load()->func('file');
		$dir = ATTACHMENT_ROOT.$path;
		if(is_dir($dir)){
			$ret = file_put_contents(ATTACHMENT_ROOT.$path.$filename, $img);
		}else{
			mkdirs($dir);
			$ret = file_put_contents(ATTACHMENT_ROOT.$path.$filename, $img);
		}
		$pathname = $path.$filename;
		if (!empty($_W['setting']['remote']['type'])) {
            $remotestatus = file_remote_upload($pathname);
		    if (is_error($remotestatus)) {
		        message('远程附件上传失败，请检查配置并重新上传');
		    }else{
		    	file_delete($pathname);
		    }
		}
		return $filename;
	}

	function addPersonreg($entity){
		$avatar     = $entity['avatar'];
		if(!empty($avatar)){
			$path       = 'gohome/avatar/';
			$filename   = $this->uploadImage($avatar, $path);
			$data['avatar'] 	  = $filename;
		}
		
		$servetype  = $entity['servetype'];
		$serve_type = implode(",", $servetype);
		if(empty($serve_type)){
			$serve_type = 0;
		}
		
		$jw 		= $entity['jw'];
		$jw_arr 	=  explode(",", $jw);
		$lng 		= $jw_arr[0];
		$lat 		= $jw_arr[1];
		$adrstr 	= $this->encode_geohash($lat,$lng,12);
								
		$data['weid'] 		  = $entity['weid'];
		$data['openid'] 	  = $entity['openid'];
		$data['staff_name']   = $entity['staff_name'];
		$data['card'] 		  = $entity['card'];
		$data['staff_mobile'] = $entity['staff_mobile'];
		$data['sex'] 		  = $entity['sex'];
		$data['serve_type']   = $serve_type;
		$data['age'] 		  = $entity['age'];
		$data['year'] 		  = $entity['year'];
		$data['bank'] 		  = $entity['bank'];
		$data['bank_num']	  = $entity['bank_num'];
		$data['alipay'] 	  = $entity['alipay'];
		$data['stop'] 		  = 0;
		$data['flag'] 		  = 0;
		$data['money']        = 0;
		$data['grade_money']  = 0;
		$data['company_flag'] = 0;
		$data['log']          = $lng;
		$data['lat']          = $lat;
		$data['adrstr']       = $adrstr;
		$data['permanent']    = $entity['permanent'];	
		pdo_insert('xm_gohome_staff',$data);
		$res = pdo_insertid();

		return $res;	
	}
	
	function addCompanyreg($entity){
		$logo = $entity['logo'];
		if(!empty($logo)){
			$path 		 = 'gohome/avatar/';
			$filename    = $this->uploadImage($logo, $path);	
			$data['avatar']  = $filename;
		}
		$license_pic = $entity['license_pic'];
		if(!empty($license_pic)){
			$path 		 = 'gohome/license/';
			$filename1    = $this->uploadImage($license_pic, $path);	
			$data['license_pic']  = $filename1;
		}

		$id = $entity['id'];
		$data['openid'] 	  = $entity['openid'];
		$data['staff_name']   = $entity['staff_name'];
		$data['staff_mobile'] = $entity['staff_mobile'];
		$data['stop']         = 0;
		$data['flag'] 		  = 0;
		$data['company_name'] = $entity['company_name'];
		$data['contact'] 	  = $entity['contact'];
		$data['address']      = $entity['address'];
		$data['bank']         = $entity['bank'];
		$data['bank_num'] 	  = $entity['bank_num'];
		$data['alipay'] 	  = $entity['alipay'];
		$data['license'] 	  = $entity['license'];
		$data['company_mge']  = 1;
		$data['company_flag'] = 1;
		$data['money']        = 0;
		$data['grade_money']  = 0;
		if(empty($id)){
			$data['weid'] = $entity['weid'];
			$res = pdo_insert('xm_gohome_staff', $data);
		}else{
			$res = pdo_update('xm_gohome_staff', $data, array('id'=>$id));
		}

		return $res;
	}	
	
	public function doMobileGowork(){
		global $_W,$_GPC;	
		
		$flag   = intval($_GPC['flag']);
		$openid = $_GPC['openid'];
		if($flag == 1){
			$res = pdo_query("update ".tablename('xm_gohome_staff')." set stop=1 where openid='".$openid."' and weid=".$this->weid." and delstate=1");
		}else{
			$res = pdo_query("update ".tablename('xm_gohome_staff')." set stop=0 where openid='".$openid."' and weid=".$this->weid." and delstate=1");
		}
		if($res){
			message('操作成功！', $this->createMobileUrl('Validate', array()), 'success');
		}else{
			message('操作失败！');
		}
	}
	
	public function doMobileFa(){
		global $_W,$_GPC;
		
		checkauth();
		$openid = $_W['fans']['from_user'];
		if(empty($openid))
		{
			header('Location:'.$this->getBase('lead'));
		}
		$id = intval($_GPC['id']);
		
		$list = pdo_fetchall("select id,staff_name from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and company_mge=0 and delstate=1");
			
		include $this->template($this->temp1.'_fa');
	}
	
	public function doMobileCheckmoney(){
		global $_W,$_GPC;
		
		$start = $_GPC['start'];
		$end  = $_GPC['end'];
		$staff_id = $_GPC['staff_id'];
		$item =  pdo_fetch("select sum(getMoney) as yu from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and staff_id=".$staff_id." and addtime between '".$start."' and '".$end."' and fastate=0 and type != 1");
		
		if($item['yu'] == NULL){
			$yucount = 0;
		}else{
			$yucount = $item['yu'];
		}
		echo $yucount;
	}
	
	public function doMobileFafangok(){
		global $_W,$_GPC;
		
		$money = $_GPC['money'];
		$openid = $_GPC['openid'];
		$start = $_GPC['start'];
		$end = $_GPC['end'];
		$staff_id = $_GPC['staff_id'];
		if($money == 0){
			echo 0;
		}
		$data['weid'] = $this->weid;
		$data['openid'] = $openid;
		$data['money'] = $money;
		$data['staff_id'] = $staff_id;
		$res = pdo_insert('xm_gohome_falog',$data);
		if($res){
			pdo_query("update ".tablename('xm_gohome_paylog')." set fastate=1 where weid=".$this->weid." and staff_id=".$staff_id." and type != 1 and addtime between '".$start."' and '".$end."'");
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function doMobileFalist(){
		global $_W,$_GPC;
		
		$id = $_GPC['id'];
		if(!empty($id)){
			$list = pdo_fetchall("select * from ".tablename('xm_gohome_falog')." where weid=".$this->weid." and staff_id=".$id." order by addtime desc limit 0,100");
		}else{
			$list = pdo_fetchall("select * from ".tablename('xm_gohome_falog')." where weid=".$this->weid." order by addtime desc limit 0,100");
		}
		
		include $this->template($this->temp1.'_falist');
	}
	
	function checkreg(){
		global $_W, $engine;
		
		load()->model('mc');
		if(!empty($_W['member']) && (!empty($_W['member']['mobile']))) 
		{
			return true;
		}else{
			if(!empty($_W['openid'])) {
				$fan = mc_fansinfo($_W['openid'], $_W['acid'], $_W['uniacid']);
				if(_mc_login(array('uid' => intval($fan['uid'])))) {
					return true;
				}
			}else{
				include $this->template($this->temp.'_login');	
				exit();
			}	
		}
	}
	
	public function doMobileLogin(){
		global $_W,$_GPC;
		
		include $this->template($this->temp.'_login');	
	}
	
	public function doMobileLoginok(){
		global $_W,$_GPC;
		
		$sql = 'SELECT `uid`,`salt`,`password` FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$sql .= ' AND `mobile`=:mobile';
		$pars[':mobile'] = $_GPC['mobile'];
		
		$user = pdo_fetch($sql, $pars);
		if(empty($user)) {
			message('不存在该账号的用户资料');
			exit();
		}
		$hash = md5($_GPC['password'] . $user['salt'] . $_W['config']['setting']['authkey']);
		if($user['password'] != $hash) {
			message('密码错误');
			exit();
		}
		
		if(_mc_login($user)) {
			header("Location:".$this->createMobileUrl('Index',array('')));
		}
		message('未知错误导致登陆失败');
	}
	
	
	public function doMobileReg(){
		global $_W,$_GPC;
		
		$authen = $this->getBase('authen');
		if($authen){	
			$timeout = $this->getBase('timeout')*60;
		}
		
		include $this->template($this->temp.'_reg');		
	}
	
	public function doMobileRegok(){
		global $_W,$_GPC;
		
		$username = trim($_GPC['mobile']);
		$code     = trim($_GPC['code']);
		$password = trim($_GPC['pwd']);
		$repassword = trim($_GPC['rpwd']);
		if($repassword != $password){
			message('两次密码输入不一致');
			exit();
		}
		$authen = $this->getBase('authen');
		if($authen){
			if(empty($code)){
				message('验证码不能为空！');
				exit();
			}
			$nowtime = time();
			$check = pdo_fetch("select id,code from ".tablename('xm_gohome_code')." where weid=".$this->weid." and mobile=".$username." and type=1 and isUse=0 and ".$nowtime." between starttime and endtime");
			if(!empty($check)){
				if($check['code'] == $code){
					$this->regok($username,$password);
				}else{
					message('验证码错误或已失效！');
					exit();
				}
			}else{
				message('验证码错误或已失效！');
				exit();
			}	
		}else{
			$this->regok($username,$password);
		}
	}

	public function regok($username,$pwd){
		global $_W,$_GPC;
		
		$sql = 'SELECT `uid` FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
					
		$sql .= ' AND `mobile`=:mobile';
		$pars[':mobile'] = $username;
		$user = pdo_fetch($sql, $pars);
		if(!empty($user)) {
			message('该用户名已被注册，请输入其他用户名。');
		}
		if(!empty($_W['openid'])) {
			$fan = mc_fansinfo($_W['openid']);
			if (!empty($fan)) {
				$map_fans = $fan['tag'];
			}
			if (empty($map_fans) && isset($_SESSION['userinfo'])) {
				$map_fans = unserialize(base64_decode($_SESSION['userinfo']));
			}
		}
					
		$default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['uniacid']));
		$data = array(
			'uniacid' => $_W['uniacid'], 
			'salt' => random(8),
			'groupid' => $default_groupid, 
			'createtime' => TIMESTAMP,
		);
		$data['mobile'] = $username;
		$data['password'] = md5($pwd . $data['salt'] . $_W['config']['setting']['authkey']);

		if(!empty($map_fans)) {
			$data['nickname'] = $map_fans['nickname'];
			$data['gender'] = $map_fans['sex'];
			$data['residecity'] = $map_fans['city'] ? $map_fans['city'] . '市' : '';
			$data['resideprovince'] = $map_fans['province'] ? $map_fans['province'] . '省' : '';
			$data['nationality'] = $map_fans['country'];
			$data['avatar'] = rtrim($map_fans['headimgurl'], '0') . 132;
		}
		pdo_insert('mc_members', $data);
		$user['uid'] = pdo_insertid();
		if (!empty($fan) && !empty($fan['fanid'])) {
			pdo_update('mc_mapping_fans', array('uid'=>$user['uid']), array('fanid'=>$fan['fanid']));
		}
		if(_mc_login($user)) {
			$data_c['isUse'] = '1';
			pdo_update('xm_gohome_code', $data_c, array('id'=>$check['id']));
			header("Location:".$this->createMobileUrl('Index',array('')));
		}
		message('未知错误导致注册失败');
	}
	

	public function doMobileUploadPic(){
		global $_W,$_GPC;
		
		$serverId = $_GPC['serverId'];
		$path     = 'gohome/pic/';
		$filename   = $this->uploadImage($serverId, $path);
		$data['pic'] = $filename;
		
		$data['weid'] = $this->weid;
		$data['random'] = $_GPC['random'];
		$res = pdo_insert('xm_gohome_pic',$data);
		if($res){
			$arr = pdo_fetchall("select id,pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$_GPC['random']." order by id desc");
			echo json_encode($arr);
		}else{
			echo 0;
		}
	}
	
	public function doMobileDeletePic(){
		global $_W,$_GPC;
		
		$id = intval($_GPC['id']);
		$random = $_GPC['random'];
		$item = pdo_fetch("select * from ".tablename('xm_gohome_pic')." where id=".$id);
		$res = pdo_delete('xm_gohome_pic',array('id'=>$id));
		if($res){
			unlink(ATTACHMENT_ROOT.'gohome/pic/'.$item['pic']);
			$arr = pdo_fetchall("select id,pic from ".tablename('xm_gohome_pic')." where weid=".$this->weid." and random=".$random." order by id desc");
			if(empty($arr)){
				echo '1';
			}else{
				echo json_encode($arr);
			}
		}else{
			echo '0';
		}
	}

	function createok($order_id,$serve_type,$other_id,$staff_id){
		session_start();
		global $_W,$_GPC;
		
		$f_item = pdo_fetch("select fanwei,mode,temp_msg,send_sms,mode_openid,mode_mobile from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$serve_type);
		
		$fanwei     = $f_item['fanwei'];
		$tuistate   = $this->getBase('tuistate');
		$adrstr     = substr($_SESSION['adrstr'],0, $fanwei);
		
		$t_item     = pdo_fetch("select ordernumber,table_name from ".tablename('xm_gohome_order')." where id=".$order_id);
		$table_name  = $t_item['table_name'];
		$ordernumber = $t_item['ordernumber'];
		
		if($f_item['mode'] == 0 && empty($staff_id)){
			$orderItem = pdo_fetch("select * from ".tablename($table_name)." where id=".$other_id);
			if($f_item['temp_msg'] == 1){
				load()->classs('weixin.account');
				$accObj= WeixinAccount::create($acid);
				$access_token = $accObj->fetch_token();
				$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
				$mode_openid = $f_item['mode_openid'];
				$arr = explode(",", $mode_openid);
				foreach($arr as $val){
					$data = array(
						'touser' => $val,
						'template_id' => $this->getBase('pai_temp'),
						'url' => '',
						'topcolor' => '#FF0000',
						'data' => array(
							'first'	=> array(
								'value' => '您收到一条新的订单',
						 		'color' => '#173177',
							),
							'tradeDateTime' => array(
								'value' => $orderItem['addtime'],
								'color' => '#173177',
							),
							'orderType' => array(
								'value' =>  $this->getServeType($orderItem['serve_type']),
		                        'color' => '#AA0000',
							),
							'customerInfo' => array(
								'value' =>  $orderItem['fname'].",".$orderItem['fmobile'],
		                        'color' => '#173177',
							),
							'orderItemName' => array(
								'value' =>  '服务地点',
		                        'color' => '#173177',
							),
							'orderItemData' => array(
								'value' =>  $orderItem['fadr'],
		                        'color' => '#173177',
							),
							'remark' => array(
								'value' => '服务时间'.$orderItem['ftime'].',请尽快在后台指派服务人员',
								'color' => '#173177',
							),
						),
		            );
		        	ihttp_post($url, json_encode($data));	
				} 	
			}

			if($f_item['send_sms'] == 1){
				$msgbase = $this->getMessageBase();
				$smstype = $msgbase['platform'];
				$mobile  = $f_item['mode_mobile'];
				$q = $msgbase['qianming'];
				$q = str_replace("【", '', $q);
				$q = str_replace("】", '', $q);

				if($smstype == 1){
					$c = urlencode("有一条新的订单消息，服务项目：".$this->getServeType($orderItem['serve_type']).",用户信息：".$orderItem['fname'].$orderItem['fmobile'].",服务地点：".$orderItem['fadr'].",服务时间：".str_replace('T',' ',$orderItem['ftime']).",请尽快在后台指派服务人员");
				}else{
					$sms_arr = array(
						'to'     => $mobile,
						'tempid' => $msgbase['pai_tempid'],
						'order'  => $this->getServeType($orderItem['serve_type']),
						'nickname'=>$this->getMermberInfo($orderItem['openid'], 'nickname'),
						'fname'  => $orderItem['fname'],
						'fmobile'=> $orderItem['fmobile'],
						'fadr'   => $orderItem['fadr'],
						'ftime'  => $orderItem['ftime'],
						'money'  => $orderItem['dealprice'],
						'addtime'=> $orderItem['addtime']
					);
					$c = json_encode($sms_arr);
				}
					
				$data_modesms['app'] = 'gohome';
				$data_modesms['key'] = $this->getBase('key_info');
				$data_modesms['smstype'] = $smstype;
				$data_modesms['u'] = $msgbase['plat_name'];
				$data_modesms['p'] = $msgbase['plat_pwd'];
				$data_modesms['m'] = $mobile;
				$data_modesms['q'] = $q;
				$data_modesms['c'] = $c;
				
				$this->post(SEND_SMS, $data_modesms, 5);
			}
		}else{
			$condition = '';
			$params = array();
			if (!empty($fanwei)) {
				$condition .= " AND adrstr like '".$adrstr."%'";
			}
			if (!empty($tuistate)) {
				$condition .= " AND nowstate=0";
			}

			if(empty($staff_id)){
				$list  = pdo_fetchall("select id,openid,staff_mobile,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and serve_type != '' and find_in_set(".$serve_type.",serve_type) and openid != '' and stop=1 and delstate=1 ".$condition." limit 0,50");	
				$list1 = pdo_fetchall("select id,openid,staff_mobile,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and serve_type != '' and find_in_set(".$serve_type.",serve_type) and openid != '' and stop=1 and delstate=1 ".$condition." group by openid limit 0,50");	
			}else{
				$list  = pdo_fetchall("select id,openid,staff_mobile,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$staff_id);
				$list1 = pdo_fetchall("select id,openid,staff_mobile,serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$staff_id);
			}
			
			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=Stafforder&m=xm_gohome";
			for($k=0;$k<count($list);$k++){
				$data_t['weid'] = $this->weid;
				$data_t['openid'] = $list[$k]['openid'];
				$data_t['staff_id'] = $list[$k]['id'];
				$data_t['serve_type'] = $serve_type;
				$data_t['order_id'] = $order_id;
				$data_t['state'] = 0;
				$res = pdo_insert('xm_gohome_msglog', $data_t);
			}

			for($m=0;$m<count($list1);$m++){
				$openid = $list1[$m]['openid'];
				$this->send_tmpmsg('otmpmsg_id',$serve_type,$openid,$jump,$table_name,$other_id,'',0);
				$this->getFirend('otmpmsg_id',$openid,$serve_type,$jump,$table_name,$other_id);
			}
			
			$msgbase = $this->getMessageBase();      //获取短信设置数据
			if($msgbase['message1'] == 1 && $res>0){
				$list_m1 = pdo_fetchall("select staff_mobile from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and find_in_set(".$serve_type.",serve_type) and openid != '' and stop=1 and delstate=1 and company_flag=0 and adrstr like '".$adrstr."%' limit 0,50");
				$idStr = '';
				foreach($list_m1 as $value){
					$idStr .= $value['staff_mobile'].',';
				}
				$idStr = rtrim($idStr,',');
					
				$list_m2 = pdo_fetchall("select openid,staff_mobile from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and find_in_set(".$serve_type.",serve_type) and openid != '' and stop=1 and delstate=1 and company_flag=1 and adrstr like '".$adrstr."%' limit 0,50");
				$idStr1 = '';
				if(!empty($list_m2)){
					$get_openid = $list_m2[0]['openid'];
					$item_m = pdo_fetch("select staff_mobile from ".tablename('xm_gohome_staff')." where openid='".$get_openid."' and company_mge=1 and delstate=1");
					$idStr1 = $item_m['staff_mobile'];
				}
				
				if(empty($idStr)){
					$phone_list = $idStr1;	
				}elseif(empty($idStr1)){
					$phone_list = $idStr;
				}else{
					$phone_list = $idStr.','.$idStr1;
				}
				
				$smstype  = $msgbase['platform'];
				$q= $msgbase['qianming'];
				$q = str_replace("【", '', $q);
				$q = str_replace("】", '', $q);

				if($smstype == 1){
					$c = $this->getBao($serve_type, $table_name, $other_id, $staff_id, '0', $msgbase['message1_content']);
				}else{
					$tempid  = $msgbase['msg1_tempid'];
					$mobile  = $phone_list;
					$c = $this->getAlidayu($tempid, $mobile, $serve_type, $table_name, $other_id, $staff_id, '0');
				}
				
				$data_sms['app']     = 'gohome';
				$data_sms['key'] 	 = $this->getBase('key_info');
				$data_sms['smstype'] = $smstype;
				$data_sms['u'] 		 = $msgbase['plat_name'];
				$data_sms['p'] 		 = $msgbase['plat_pwd'];
				$data_sms['m'] 		 = $phone_list;
				$data_sms['q'] 		 = $q;
				$data_sms['c']       = $c;
				
				$res = $this->post(SEND_SMS, $data_sms, 5);
				return $res;
			}
		}
	}

	function sheng_tmpmsg($str, $flag, $jump, $id, $merchantid){
		global $_W,$_GPC;
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_tempmessagedefault')." where weid=".$this->weid);
		if(!empty($item[''.$str.''])){
			load()->classs('weixin.account');
			$accObj= WeixinAccount::create($acid);
			$access_token = $accObj->fetch_token();
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		
			$item_m = pdo_fetch("select msg_content from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and id=".$item[''.$str.'']);
			
			if($merchantid == 0){
				$item_s = pdo_fetch("select openid,staff_name,staff_mobile,company_name,shuoming,stime from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
			}else{
				$item_s = pdo_fetch("select openid,merchant_name,merchant_address,shuoming,stime from ".tablename('xm_gohome_merchant')." where weid=".$_W['uniacid']." and id=".$merchantid);
			}

			if($flag == 1) $state = '通过'; else $state = '未通过';
			if(empty($item_s['staff_name'])) $staff_name = ''; else $staff_name = $item_s['staff_name'];
			if(empty($item_s['staff_mobile'])) $staff_mobile = ''; else $staff_mobile = $item_s['staff_mobile'];
			if(empty($item_s['company_name'])) $company_name = ''; else $company_name = $item_s['company_name'];
			if(empty($item_s['merchant_name'])) $merchant_name = ''; else $merchant_name = $item_s['merchant_name'];
			if(empty($item_s['merchant_address'])) $merchant_adr=''; else $merchant_adr=$item_s['merchant_address'];
			
			$datavalue = base64_decode($item_m['msg_content']);
			$datavalue = str_replace("{url}", $jump, $datavalue);
			$datavalue = str_replace("{openid}", $item_s['openid'], $datavalue);
			$datavalue = str_replace("{state}", $state, $datavalue);
			$datavalue = str_replace("{staff_name}", $staff_name, $datavalue);
			$datavalue = str_replace("{staff_mobile}", $staff_mobile, $datavalue);
			$datavalue = str_replace("{company_name}", $company_name, $datavalue);
			$datavalue = str_replace("{merchant_name}",$merchant_name, $datavalue);
			$datavalue = str_replace("{merchant_address}",$merchant_adr, $datavalue);
			$datavalue = str_replace("{explain}", $item_s['shuoming'], $datavalue);
			$datavalue = str_replace("{stime}", $item_s['stime'], $datavalue);
			ihttp_post($url, $datavalue);
		}
	}
	
	function send_tmpmsg($str,$serve_type,$openid,$jump,$table_name,$other_id,$offer,$staff_id){
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_servetype')." where id=".$serve_type." and delstate=1");
		if($item[''.$str.''] == 0){
			$item_d = pdo_fetch("select ".$str." from ".tablename('xm_gohome_tempmessagedefault')." where weid=".$this->weid);
			$tmpmsg_id = $item_d[''.$str.''];
		}else{
			$tmpmsg_id = $item[''.$str.''];
		}
		
		if(!empty($tmpmsg_id)){
			load()->classs('weixin.account');
			$accObj= WeixinAccount::create($acid);
			$access_token = $accObj->fetch_token();
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
			
			$item_m = pdo_fetch("select msg_content from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and id=".$tmpmsg_id);
			
			$orderItem   = pdo_fetch("select * from ".tablename($table_name)." where id=".$other_id);
			$ordernumber = pdo_fetch("select ordernumber from ".tablename('xm_gohome_order')." where weid=".$this->weid." and serve_type=".$serve_type." and table_name='".$table_name."' and other_id=".$other_id);
			$number = $ordernumber['ordernumber'];

			$datavalue = base64_decode($item_m['msg_content']);	
			$datavalue = str_replace("{url}", $jump, $datavalue);
			$datavalue = str_replace("{openid}", $openid, $datavalue);
			$datavalue = str_replace("{ordernumber}", $number, $datavalue);
			$datavalue = str_replace("{order}", $this->getServeType($serve_type), $datavalue);
			$datavalue = str_replace("{ftime}", str_replace('T',' ',$orderItem['ftime']), $datavalue);
			$datavalue = str_replace("{fadr}", $orderItem['fadr'], $datavalue);
			$datavalue = str_replace("{username}", $orderItem['fname'], $datavalue);
			$datavalue = str_replace("{fmobile}", $orderItem['fmobile'], $datavalue);
			$datavalue = str_replace("{money}", $orderItem['dealprice'], $datavalue);
			$datavalue = str_replace("{nickname}", $this->getMemberInfo($orderItem['openid'], 'nickname'), $datavalue);
			$datavalue = str_replace("{addtime}",$orderItem['addtime'], $datavalue);
			$datavalue = str_replace("{offer}", $offer, $datavalue);	
			$datavalue = str_replace("{staff_name}", $this->getStaffInfo($staff_id,'staff_name'),$datavalue);
			$datavalue = str_replace("{staff_mobile}", $this->getStaffInfo($staff_id,'staff_mobile'),$datavalue);
			ihttp_post($url, $datavalue);
		}
	}

	function send_taketmpmsg($str,$openid,$jump,$orderid){
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_tempmessagedefault')." where weid=".$this->weid);
		if(!empty($item[''.$str.''])){
			$tmpmsg_id = $item[''.$str.''];
			
			load()->classs('weixin.account');
			$accObj= WeixinAccount::create($acid);
			$access_token = $accObj->fetch_token();
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
			
			$orderItem = pdo_fetch("select * from ".tablename("xm_gohome_takeorder")." where id=".$orderid);

			$m_item = pdo_fetch("select msg_content from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and id=".$tmpmsg_id);
			$datavalue = base64_decode($m_item['msg_content']);	
			$datavalue = str_replace("{url}", $jump, $datavalue);
			$datavalue = str_replace("{openid}", $openid, $datavalue);
			$datavalue = str_replace("{realname}", $orderItem['realname'], $datavalue);
			$datavalue = str_replace("{mobile}", $orderItem['mobile'], $datavalue);
			$datavalue = str_replace("{sex}", $orderItem['sex'], $datavalue);
			$datavalue = str_replace("{money}", $orderItem['amount'], $datavalue);
			$datavalue = str_replace("{address}", $orderItem['address'], $datavalue);
			$datavalue = str_replace("{addtime}",date('Y-m-d H:i:s',$orderItem['ctime']), $datavalue);
			$datavalue = str_replace("{ordernumber}", $orderItem['orderid'], $datavalue);
			$datavalue = str_replace("{merchant_name}", $this->getMerchantInfo($orderItem['merchantid'], 'merchant_name'), $datavalue);
			$datavalue = str_replace("{merchant_mobile}", $this->getMerchantInfo($orderItem['merchantid'], 'merchant_mobile'), $datavalue);
			$datavalue = str_replace("{merchant_type}", $this->getTypeInfo($this->getMerchantInfo($orderItem['merchantid'], 'type_id'), 'type_name'), $datavalue);
			
			ihttp_post($url, $datavalue);
		}
	}
	
	function getFirend($str,$openid,$serve_type,$jump,$table_name,$other_id){
		global $_W,$_GPC;
		
		$arr = pdo_fetchall("select * from ".tablename('xm_gohome_attend')." where weid=".$this->weid." and yopenid='".$openid."' and state=1");
		
		if(!empty($arr)){
			foreach($arr as $val){
				$this->send_tmpmsg($str,$serve_type,$val['jopenid'],$jump,$table_name,$other_id,'',0);
			}
		}
	}

	function send_needtmpmsg($str,$order_id,$openid,$jump,$offer,$merchant_id){
		global $_W,$_GPC;
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_tempmessagedefault')." where weid=".$this->weid);

		if(!empty($item)){
			$tmpmsg_id = $item[''.$str.''];

			load()->classs('weixin.account');
			$accObj= WeixinAccount::create($acid);
			$access_token = $accObj->fetch_token();
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
			
			$item_m = pdo_fetch("select msg_content from ".tablename('xm_gohome_tempmessage')." where weid=".$this->weid." and id=".$tmpmsg_id);
			$item_n = pdo_fetch("select * from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and id=".$order_id);
			
			$datavalue = base64_decode($item_m['msg_content']);	
			$datavalue = str_replace("{url}", $jump, $datavalue);
			$datavalue = str_replace("{openid}", $openid, $datavalue);
			$datavalue = str_replace("{ordernumber}", $item_n['orderid'], $datavalue);
			$datavalue = str_replace("{realname}", $item_n['realname'], $datavalue);
			$datavalue = str_replace("{mobile}", $item_n['mobile'], $datavalue);
			$datavalue = str_replace("{address}", $item_n['address'], $datavalue);
			$datavalue = str_replace("{goods}", $item_n['curry_name'], $datavalue);
			$datavalue = str_replace("{money}", $item_n['yuprice'], $datavalue);
			$datavalue = str_replace("{size}", $item_n['size'], $datavalue);
			$datavalue = str_replace("{gettime}", $item_n['gettime'], $datavalue);
			$datavalue = str_replace("{addtime}", $item_n['addtime'], $datavalue);
			$datavalue = str_replace("{offer}", $offer, $datavalue);
			$datavalue = str_replace("{merchant_name}", $this->getMerchantInfo($merchant_id, 'merchant_name'), $datavalue);

			ihttp_post($url, $datavalue);
		}
	}
	
	function selectok($id,$staff_id,$order_id){
		global $_W,$_GPC;
		
		$data['selected'] = 1;
		$data['selectedtime'] = date('Y-m-d H:i:s');
		pdo_update('xm_gohome_grab', $data, array('id'=>$id));
		$data_o['state'] = 1;
		$data_o['staff_id'] = $staff_id;
		$res = pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));
		if($res){
			pdo_query("update ".tablename('xm_gohome_msglog')." set state=2 where weid=".$this->weid." and state=0 and order_id=".$order_id);
			pdo_query("update ".tablename('xm_gohome_staff')." set get_order=get_order+1,nowstate=1 where id='".$staff_id."' and delstate=1");
			
			$sitem = pdo_fetch("select id,openid,staff_name,staff_mobile,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$staff_id." and delstate=1");
			$openid = $sitem['openid'];
			
			$oitem = pdo_fetch("select serve_type,table_name,other_id from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
			$serve_type = $oitem['serve_type'];

			$bitem =pdo_fetch("select offer from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id=".$order_id." and staff_id=".$staff_id);

			
			$jump = $_W['siteroot']."app/index.php?i=".$_W['uniacid']."&c=entry&do=stafforder&foo=order3&m=xm_gohome";
			$this->send_tmpmsg('xtmpmsg_id',$serve_type,$openid,$jump,$oitem['table_name'],$oitem['other_id'],$bitem['offer'],$staff_id);
			
			$serve_item = pdo_fetch("select gettype,bili_money,times from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$serve_type." and delstate=1");
			if($serve_item['gettype'] == 0 && $serve_item['times'] == 1){
				if($sitem['company_flag']==1){
					$citem = pdo_fetch("select id,staff_mobile,money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$sitem['openid']."' and company_flag=1 and company_mge=1 and delstate=1");
					$data_g['money'] = $citem['money']-$serve_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id'=>$citem['id']));
					
				}else{
					$data_g['money'] = $sitem['money']-$serve_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id'=>$staff_id));
					
				}
				$data1['weid'] = $this->weid;
				$data1['staff_id'] = $staff_id;
				$data1['serve_type'] = $serve_type;
				$data1['order_id'] = $order_id;
				$data1['getmoney'] = $serve_item['bili_money'];
				pdo_insert('xm_gohome_companygetmoney', $data1);
			}
		
			$msgbase = $this->getMessageBase();
			if($msgbase['message3'] == 1){
				if($sitem['company_flag']==1){
					$mobile = pdo_fetch("select staff_mobile from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$sitem['openid']."' and company_flag=1 and company_mge=1 and delstate=1");
					$mobile = $mobile['staff_mobile'];
				}else{
					$mobile = $sitem['staff_mobile'];
				}
				
				$smstype = $msgbase['platform'];
				$tempid  = $msgbase['msg3_tempid'];
				$q = $msgbase['qianming'];
				$q = str_replace("【", '', $q);
				$q = str_replace("】", '', $q);

				if($smstype == 1){
					$c = $this->getBao($serve_type, $oitem['table_name'], $oitem['other_id'], $staff_id, $bitem['offer'], $msgbase['message3_content']);
				}else{
					$c = $this->getAlidayu($tempid, $mobile, $serve_type, $oitem['table_name'], $oitem['other_id'], $staff_id, $bitem['offer']);
				}

				$data_modesms['app'] = 'gohome';
				$data_modesms['key'] = $this->getBase('key_info');
				$data_modesms['smstype'] = $smstype;
				$data_modesms['u'] = $msgbase['plat_name'];
				$data_modesms['p'] = $msgbase['plat_pwd'];
				$data_modesms['m'] = $mobile;
				$data_modesms['q'] = $q;
				$data_modesms['c'] = $c;
				
				$this->post(SEND_SMS, $data_modesms, 5);
			}
			return 1;
		}else{
			return 0;
		}
	}
	
	function getBao($serve_type, $table_name, $other_id, $staff_id, $offer, $msgcontent){
		global $_W,$_GPC;
		
		if(empty($staff_id)){
			$staff_id = 0;
		}
		if(empty($table_name) || empty($other_id)){
			return 'Table Error';
			exit();
		}
		$orderItem = pdo_fetch("select * from ".tablename($table_name)." where id=".$other_id);
		if(!empty($orderItem)){
			$c = str_replace("{order}", $this->getServeType($serve_type), $msgcontent);
			$c = str_replace("{ftime}", str_replace('T',' ',$orderItem['ftime']), $c);		 		
			$c = str_replace("{username}", $orderItem['fname'], $c);
			$c = str_replace("{nickname}", $this->getMemberInfo($orderItem['openid'], 'nickname'), $c);
			$c = str_replace("{fmobile}", $orderItem['fmobile'], $c);		
			$c = str_replace("{fadr}", $orderItem['fadr'], $c);
			$c = str_replace("{money}", $orderItem['dealprice'], $c);
			$c = str_replace("{addtime}", $orderItem['addtime'], $c);
			$c = str_replace("{staff_name}", $this->getStaffInfo($staff_id,'staff_name'),$c);
			$c = str_replace("{staff_mobile}", $this->getStaffInfo($staff_id,'staff_mobile'),$c);
			$c = str_replace("{offer}", $offer, $c);
			return urlencode($c);
		}
	}

	function getAlidayu($tempid, $mobile, $serve_type, $table_name, $other_id, $staff_id, $offer){
		global $_W,$_GPC;
		
		if(empty($staff_id)){
			$staff_id = 0;
		}
		if(empty($table_name) || empty($other_id)){
			return 'Table Error';
			exit();
		}
		$orderItem = pdo_fetch("select * from ".tablename($table_name)." where id=".$other_id);
		if(!empty($orderItem)){
			$sms_arr = array(
				'to'		  => $mobile,
				'tmplid'      => $tempid,
				'order'       => $this->getServeType($serve_type),
				'ftime'       => str_replace('T',' ',$orderItem['ftime']),
				'username'    => $orderItem['fname'],
				'fmobile'     => $orderItem['fmobile'],
				'nickname'    => $this->getMemberInfo($orderItem['openid'], 'nickname'),
				'fadr'        => $orderItem['fadr'],
				'money'       => $orderItem['dealprice'],
				'addtime'     => $orderItem['addtime'],
				'staff_name'  => $this->getStaffInfo($staff_id,'staff_name'),
				'staff_mobile'=> $this->getStaffInfo($staff_id,'staff_mobile'),
				'offer'       => $offer
			);
			$c = json_encode($sms_arr);
			return $c;
		}
	}

	function getBaoTakeout($orderid, $msg_content){
		global $_W,$_GPC;
		
		if(empty($orderid)){
			$orderid = 0;
		}
		$orderItem = pdo_fetch("select * from ".tablename("xm_gohome_takeorder")." where id=".$orderid);
		if(!empty($orderItem)){
			$c = base64_decode($msg_content);
			$c = str_replace("{realname}", $orderItem['realname'], $c);
			$c = str_replace("{mobile}", $orderItem['mobile'], $c);
			$c = str_replace("{sex}", $orderItem['sex'], $c);
			$c = str_replace("{money}", $orderItem['amount'], $c);
			$c = str_replace("{address}", $orderItem['address'], $c);
			$c = str_replace("{addtime}",date('Y-m-d H:i:s',$orderItem['ctime']), $c);
			$c = str_replace("{ordernumber}", $orderItem['orderid'], $c);
			$merchant_name   = $this->getMerchantInfo($orderItem['merchantid'], 'merchant_name');
			$merchant_mobile = $this->getMerchantInfo($orderItem['merchantid'], 'merchant_mobile');
			$merchant_type   = $this->getTypeInfo($this->getMerchantInfo($orderItem['merchantid'], 'type_id'), 'type_name');
			$c = str_replace("{merchant_name}", $merchant_price, $c);
			$c = str_replace("{merchant_mobile}", $merchant_mobile, $c);
			$c = str_replace("{merchant_type}", $merchant_type, $c);
			return urlencode($c);
		}
			
	}

	function getAlidayuTakeout($tempid, $mobile, $orderid){
		global $_W,$_GPC;
		
		if(empty($orderid)){
			$orderid = 0;
		}
		$orderItem = pdo_fetch("select * from ".tablename("xm_gohome_takeorder")." where id=".$orderid);
		if(!empty($orderItem)){
			$merchant_name   = $this->getMerchantInfo($orderItem['merchantid'], 'merchant_name');
			$merchant_mobile = $this->getMerchantInfo($orderItem['merchantid'], 'merchant_mobile');
			$merchant_type   = $this->getTypeInfo($this->getMerchantInfo($orderItem['merchantid'], 'type_id'), 'type_name');
			$sms_arr = array(
				'to'		  => $mobile,
				'tmplid'      => $tempid,
				'realname'    => $orderItem['realname'],
				'fmobile'     => $orderItem['mobile'],
				'sex'         => $orderItem['sex'],
				'money'       => $orderItem['amount'],
				'address'     => $orderItem['address'],
				'addtime'     => date('Y-m-d H:i:s', $orderItem['ctime']),
				'ordernumber' => $orderItem['orderid'],
				'merchant_name'  => $merchant_name,
				'merchant_mobile'=> $merchant_mobile,
				'merchant_type'  => $merchant_type
			);
			$c = json_encode($sms_arr);
			return $c;
		}		
	}
	
	public function doMobileGetPaylist(){
		global $_W,$_GPC;
		
		$this->checkreg();
		//checkauth();
		$openid = $_W['fans']['from_user'];
		$arr = pdo_fetchall("select * from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and openid='".$openid."'");
		
		return json_encode($arr);
	}
	
	public function payResult($params) {
		global $_W,$_GPC;
		
		$str = explode('#',$params['tid']);
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
			$weid = $_W['uniacid'];
			if($str[0] == 'A'){
				$uid    = $str[1];
				$openid = $str[2];
				$money  = $str[3];
				
				load()->model('mc');
				mc_credit_update($uid, 'credit2', $money);
				
				$data['weid']   = $weid;
				$data['openid'] = $openid;
				$data['type']   = 1;
				$data['money']  = $money;
				pdo_insert('xm_gohome_userrechargelog',$data);
			}
			
			if($str[0] == 'B'){
				$uid      = $str[1];
				$money    = $str[2];
				$order_id = $str[3];
				$bili     = $this->getBase("bili");
				$staff_id = $str[4];
				$endmoney = $str[5];
				$remark   = $str[6];
				
				load()->model('mc');
				//平台分成
				$oitem = pdo_fetch("select openid,serve_type from ".tablename('xm_gohome_order')." where weid=".$weid." and id=".$order_id);
				$openid     = $oitem['openid'];
				$serve_type = $oitem['serve_type'];

				$serve_item = pdo_fetch("select gettype,bili_bai,bili_money,start,end,times from ".tablename('xm_gohome_servetype')." where weid=".$weid." and id=".$serve_type);

				if($serve_item['gettype'] == 1){
					$getMoney = ($endmoney*$serve_item['bili_bai'])/100;
					
					$smoney =$getMoney;
					if($getMoney<=$serve_item['start']){
						$smoney = $serve_item['start'];
					}
					if($getMoney>=$serve_item['end'] && $serve_item['end']!=0){
						$smoney = $serve_item['end'];
					}
					$getMoney1 = $endmoney-$smoney;
					//平台流水日志
					$data_get = array(
						'weid'       => $weid,
						'staff_id'   => $staff_id,
						'serve_type' => $serve_type,
						'order_id'   => $order_id,
						'getmoney'   => $smoney,
						'type'       => 2,
						'way'        => 1
					);
					pdo_insert('xm_gohome_companygetmoney', $data_get);

					$item_s = pdo_fetch("select id,openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$weid." and id=".$staff_id);
					if($item_s['company_flag'] == 1){
						$item_c = pdo_fetch("select id,openid from ".tablename('xm_gohome_staff')." where weid=".$weid." and company_mge=1 and openid='".$item_s['openid']."'");
						$new_staff_id = $item_c['id'];
					}else{
						$new_staff_id = $staff_id;
					}
					//pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$weid." and id=".$new_staff_id);

				}else{

					$getMoney1 = $endmoney;
					if($serve_item['times'] == 0){
						$item_s = pdo_fetch("select openid,company_flag,money from ".tablename('xm_gohome_staff')." where weid=".$weid." and id=".$staff_id);
						if($item_s['company_flag']==1){
							$item_c = pdo_fetch("select id,money from ".tablename('xm_gohome_staff')." where weid=".$weid." and openid ='".$item_s['openid']."' and company_mge=1 and delstate=1");
							$data_g['money'] = $item_c['money'] - $serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id' => $item_c['id']));
							$new_staff_id = $item_c['id'];
						}else{
							$data_g['money'] = $item_s['money']-$serve_item['bili_money'];
							pdo_update('xm_gohome_staff', $data_g, array('id' => $staff_id));
							$new_staff_id = $staff_id;
						}
						$smoney = $serve_item['bili_money'];

						$data_get = array(
							'weid'       => $weid,
							'staff_id'   => $staff_id,
							'serve_type' => $serve_type,
							'order_id'   => $order_id,
							'getmoney'   => $serve_item['bili_money'],
							'type'       => 2,
							'way'        => 0
						);
						pdo_insert('xm_gohome_companygetmoney', $data_get);

						pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$weid." and id=".$new_staff_id);
					}
				}

				$data_p = array(
					'weid'     => $weid,
					'openid'   => $openid,
					'staff_id' => $staff_id,
					'order_id' => $order_id,
					'money'    => $money,
					'type'     => 2,
					'getmoney' => $getMoney1,
					'remark'   => $remark
				);
				$res = pdo_insert('xm_gohome_paylog', $data_p);
				if($res){
					$data_o['state'] = 2;
					$data_o['overtime'] = date('Y-m-d H:i:s');
					pdo_update('xm_gohome_order', $data_o, array('id'=>$order_id));

					$data_s['nowstate'] = 1;
					pdo_update('xm_gohome_staff', $data_s, array('id'=>$new_staff_id));
					
					pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where id=".$new_staff_id." and weid=".$weid);
				
					$credit1 = floor($endmoney/$bili);
					mc_credit_update($uid, 'credit1', $credit1);

					$data_r = array(
						'uid'     	 => $uid,
						'uniacid'    => $weid,
						'credittype' => 'credit1',
						'num'		 => $credit1,
						'operator'   => '1',
						'module'     => 'xm_gohome',
						'clerk_id'   => '0',
						'store_id'   => '0',
						'createtime' => $_W['timestamp'],
						'remark'     => '订单付款得到积分'.$credit1
					);
					pdo_insert('mc_credits_record', $data_r);
					//$url_index = $this->createMobileUrl('Index',array());
					//$url_order = $this->createMobileUrl('Orderinfo',array('id'=>$order_id));
					//include $this->template($this->temp.'_orderpayok');
				}else{
					message('付款失败!');
				}
			}
			
			if($str[0] == 'C'){
				$staff_id = $str[1];
				$openid   = $str[2];
				$money    = $str[3];
				
				$res = pdo_query("update ".tablename('xm_gohome_staff')." set money = money + ".$money." where weid=".$this->weid." and id=".$staff_id);
				if($res){
					$data_log = array(
						'weid'     => $weid,
						'staff_id' => $staff_id,
						'openid'   => $openid,
						'type'     => 2,
						'money'    => $money,
						'remark'   => '微信端余额充值' 
					);
					pdo_insert('xm_gohome_rechargelog', $data_log);
				}
			}
				
			if($str[0] == 'D'){
				$openid   = $str[1];
				$money    = $str[2];
				$staff_id = $str[3];
				$grade_id = $str[4];
					
				$item = pdo_fetch("select id,grade_money from ".tablename('xm_gohome_staff')." where weid=".$weid." and delstate=1 and id=".$staff_id);
				$n_money = $item['grade_money'] + $money;
				$data['grade_money'] = $n_money;
				$data['grade_id']    = $grade_id;
				$res = pdo_update('xm_gohome_staff', $data, array('id'=>$staff_id));
				if($res){
					$data_log = array(
						'weid'     => $weid,
						'staff_id' => $staff_id,
						'openid'   => $openid,
						'type'     => 3,
						'money'    => $money,
						'remark'   => '微信端保证金充值'
					);
					pdo_insert('xm_gohome_rechargelog', $data_log);
				}
			}

			if($str[0] == 'E'){
				$openid   = $str[1];
				$money    = $str[2];
				$order_id = $str[3];
				$staff_id = $str[4];
				
				$data_u['flag'] = 1;
				pdo_update('xm_gohome_order', $data_u, array('id'=>$order_id));

				$item = pdo_fetch("select serve_type,other_id from ".tablename('xm_gohome_order')." where weid=".$weid." and id=".$order_id);
				$data['weid']      = $weid;
				$data['openid']    = $openid;
				$data['money']     = $money;
				$data['servetype'] = $item['serve_type'];
				$data['type']      = 'submit';
				$res = pdo_insert('xm_gohome_userfrontlog', $data);
				if($res){
					$url = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=submitpayjump&order_id='.$order_id.'&serve_type='.$item['serve_type'].'&other_id='.$item['other_id'].'&staff_id='.$staff_id.'&m=xm_gohome';
					header("Location:".$url);	
				}
			}

			if($str[0] == 'F'){
				$openid   = $str[1];
				$money    = $str[2];
				$id       = $str[3];
				$order_id = $str[4];
				$staff_id = $str[5];
				
				$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_order')." where weid=".$weid." and id=".$order_id);
				$data = array(
					'weid'      => $weid,
					'openid'    => $openid,
					'money'     => $money,
					'servetype' => $item['serve_type'],
					'type'      => 'select'
				);
				$res = pdo_insert('xm_gohome_userfrontlog', $data);
				if($res){
					$url = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=selectpayjump&order_id='.$order_id.'&id='.$id.'&staff_id='.$staff_id.'&m=xm_gohome';
					header("Location:".$url);
				}
			}

			if($str[0] == 'G'){
				$weid = $str[1];
				$openid = $str[2];
				$money = $str[3];
				$order_id = $str[4];
				
				$u_info = array(
					'state'   => 4,
					'paytype' => 1,
					'ptime1'   => time()
				);
				$res = pdo_update('xm_gohome_takeorder', $u_info, array('id'=>$order_id));
				if($res){
					$urls = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=payjump&order_id='.$order_id.'&openid='.$openid.'&money='.$money.'&m=xm_gohome';
					header("Location:".$urls);
				}else{
					message('付款失败');
				}
			}

			if($str[0] == 'H'){
				$openid = $str[1];
				$money = $str[2];
				$order_id = $str[3];
				$merchant_id = $str[4];
				
				$data['state'] = 3;
				$data['paytime'] = date('Y-m-d H:i:s');
				$res = pdo_update('xm_gohome_needorder', $data, array('id'=>$order_id));
				if($res){
					$urls = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=needpayjump&order_id='.$order_id.'&openid='.$openid.'&money='.$money.'&m=xm_gohome';
					header("Location:".$urls);
				}else{
					message('付款失败');
				}
			}
		}
		
		if($params['from'] == 'return') {
            if ($params['result'] == 'success') {
				$weid   = $_W['uniacid'];
				if($str[0] == 'A'){
					
					include $this->template($this->temp.'_rechargeok');
				}

				if($str[0] == 'B'){
					$order_id = $str[3];
					$staff_id = $str[4];
					$url = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=payok&foo=show&order_id='.$order_id.'&staff_id='.$staff_id.'&m=xm_gohome';
					header("Location:".$url);
					//include $this->template($this->temp.'_orderpayok');
				}
				if($str[0] == 'C'){

					include $this->template('staff/recharge/s_rechargeok');
				}
				
				if($str[0] == 'D'){
					
					include $this->template($this->temp1.'_rechargeok');
				}
				
				if($str[0] == 'E'){
					$order_id = $str[3];
					$url = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=templateok&foo=submitok&order_id='.$order_id.'&m=xm_gohome';
					header("Location:".$url);
				}

				if($str[0] == 'F'){
					$url = $_W['siteroot'].'app/index.php?i='.$weid.'&c=entry&do=selected&foo=selectok&m=xm_gohome';
					header("Location:".$url);	
				}

				if($str[0] == 'G'){
					$weid = $str[1];
					$openid = $str[2];
					$money = $str[3];
					$orderid = $str[4];

					include $this->template('takeout/takepayok');
				}

				if($str[0] == 'H'){
					$openid = $str[1];
					$money = $str[2];
					$order_id = $str[3];
					$merchant_id = $str[4];
					include $this->template('needs/payok');
				}
            } else {
                message('支付失败！');
            }
        }
	}
	
	public function doMobileSubmitpayjump(){
		global $_W,$_GPC;

		$order_id   = intval($_GPC['order_id']);
		$serve_type = $_GPC['serve_type'];
		$other_id   = $_GPC['other_id'];
		$staff_id   = $_GPC['staff_id'];

		$this->createok($order_id,$serve_type,$other_id,$staff_id);
		header("Location:".$this->createMobileUrl('templateok',array('foo'=>'submitok','order_id'=>$order_id,'staff_id'=>$staff_id)));
	}

	public function doMobileSelectpayjump(){
		global $_W,$_GPC;

		$id       = $_GPC['id'];
		$order_id = $_GPC['order_id'];
		$staff_id = $_GPC['staff_id'];
		
		$this->selectok($id, $staff_id, $order_id);
		header("Location:".$this->createMobileUrl('selected',array('foo'=>'selectok')));
	}

	public function doMobilePayjump(){
		global $_W,$_GPC;

		$order_id = $_GPC['order_id'];
		$openid  = $_GPC['openid'];
		$money   = $_GPC['money'];

		$item = pdo_fetch("select id,merchantid,orderid from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$order_id);
		$merchantid = 0;
		if(!empty($item)){
			$merchantid = $item['merchantid'];
		}
		$orderid = $item['orderid'];
		
		$check = pdo_fetch("select id from ".tablename('xm_gohome_companygetmoney_merchant')." where weid=".$this->weid." and merchant_id=".$merchantid." and orderid='".$orderid."'");
		if(!empty($check['id'])){
			message("该订单已支付");
			exit();
		}

		$m_item = pdo_fetch("select openid,staff_id,type_id,merchant_mobile,gettype,bili_bai,bili_money,start,end from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and id=".$merchantid);

		$jump = $_W['siteroot']."app/index.php?i=".$this->weid."&c=entry&do=merchant&foo=order&id=".$m_item['staff_id']."&m=xm_gohome";
		$this->send_taketmpmsg('ttmpmsg_id', $m_item['openid'], $jump, $order_id);

		pdo_query("update ".tablename('xm_gohome_merchant')." set ordersum=ordersum+1 where id=".$item['merchantid']);
		$list = pdo_fetchall("select curryid,quantity from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");
		foreach ($list as $value) {
			pdo_query("update ".tablename('xm_gohome_curry')." set allsum=allsum+".$value['quantity']." where id=".$value['curryid']);
		}

		$msgbase = $this->getMessageBase();      //获取短信设置数据
		if($msgbase['message4'] == 1){
			$smstype  = $msgbase['platform'];
			$q = $msgbase['qianming'];
			$q = str_replace("【", '', $q);
			$q = str_replace("】", '', $q);
			$mobile  = $m_item['merchant_mobile'];

			if($smstype == 1){ 
				$c = $this->getBaoTakeout($order_id, $msgbase['message4_content']);
			}else{
				$tempid  = $msgbase['msg4_tempid'];
				$c = $this->getAlidayuTakeout($tempid, $mobile, $order_id);
			}
			$data_sms['app']     = 'gohome';
			$data_sms['key'] 	 = $this->getBase('key_info');
			$data_sms['smstype'] = $smstype;
			$data_sms['u'] 		 = $msgbase['plat_name'];
			$data_sms['p'] 		 = $msgbase['plat_pwd'];
			$data_sms['m'] 		 = $mobile;
			$data_sms['q'] 		 = $q;
			$data_sms['c']       = $c;
			
			$this->post(SEND_SMS, $data_sms, 5); 
		}

		//结算计算
		if(!empty($m_item['gettype'])){
			if($m_item['gettype'] == 1){
				$getMoney = ($money*$m_item['bili_bai'])/100;
				
				$smoney = $getMoney;
				if($getMoney<=$m_item['start']){
					$smoney = $m_item['start'];
				}
				if($getMoney>=$m_item['end'] && $m_item['end']!=0){
					$smoney = $m_item['end'];
				}
				$getMoney1 = $money-$smoney;
				//平台流水日志
				$data_get = array(
					'weid'       => $this->weid,
					'merchant_id'=> $item['merchantid'],
					'orderid'    => $orderid,
					'getmoney'   => $smoney,
					'type'       => 1,
					'way'        => 1
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
				//pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");

			}else{
				$getMoney1 = $money;
				$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
				$data_g['money'] = $item_s['money'] - $m_item['bili_money'];
				pdo_update('xm_gohome_staff', $data_g, array('id' => $m_item['staff_id']));
				
				$data_get = array(
					'weid'       => $this->weid,
					'merchant_id'=> $item['merchantid'],
					'orderid'    => $orderid,
					'getmoney'   => $m_item['bili_money'],
					'type'       => 1,
					'way'        => 0
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
			}
			$data_p = array(
				'weid'     	  => $this->weid,
				'openid'   	  => $openid,
				'merchant_id' => $item['merchantid'],
				'money'    	  => $money,
				'orderid' 	  => $item['orderid'],
				'type'        => 'takeout',
				'paytype'	  => '1',
				'getmoney'    => $getMoney1
			);
			$res = pdo_insert('xm_gohome_takepaylog', $data_p);

			pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
		}else{
			$t_item = pdo_fetch("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and delstate=1 and id=".$m_item['type_id']);
			if(!empty($t_item['gettype'])){
				if($t_item['gettype'] == 1){
					$getMoney = ($money*$t_item['bili_bai'])/100;
					
					$smoney = $getMoney;
					if($getMoney<=$t_item['start']){
						$smoney = $t_item['start'];
					}
					if($getMoney>=$t_item['end'] && $t_item['end']!=0){
						$smoney = $t_item['end'];
					}
					$getMoney1 = $money-$smoney;
					//平台流水日志
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $item['merchantid'],
						'orderid'    => $orderid,
						'getmoney'   => $smoney,
						'type'       => 1,
						'way'        => 1
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
					//pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");

				}else{
					$getMoney1 = $money;
					$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
					$data_g['money'] = $item_s['money'] - $t_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id' => $m_item['staff_id']));
					
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $item['merchantid'],
						'orderid'    => $orderid,
						'getmoney'   => $t_item['bili_money'],
						'type'       => 1,
						'way'        => 0
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
				}
				$data_p = array(
					'weid'     	  => $this->weid,
					'openid'   	  => $openid,
					'merchant_id' => $item['merchantid'],
					'money'    	  => $money,
					'orderid' 	  => $item['orderid'],
					'type'        => 'takeout',
					'paytype'	  => '1',
					'getmoney'    => $getMoney1
				);
				$res = pdo_insert('xm_gohome_takepaylog', $data_p);

				pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
			}
		}
	}

	public function doMobileneedpayjump(){
		global $_W,$_GPC;

		$order_id = $_GPC['order_id'];
		$openid  = $_GPC['openid'];
		$money   = $_GPC['money'];
		$item = pdo_fetch("select merchantid,orderid from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and id=".$order_id);
		if(empty($item)){
			$merchantid = 0;
		}
		$orderid = $item['orderid'];
		
		$m_item = pdo_fetch("select openid,staff_id,type_id,gettype,bili_bai,bili_money,start,end from ".tablename('xm_gohome_merchant')." where weid=".$this->weid." and delstate=1 and id=".$item['merchantid']);

		$jump = $_W['siteroot']."app/index.php?i=".$this->weid."&c=entry&do=merchant&foo=order&id=".$m_item['staff_id']."&m=xm_gohome";
		$this->send_taketmpmsg('ttmpmsg_id', $m_item['openid'], $jump, $order_id);

		pdo_query("update ".tablename('xm_gohome_merchant')." set ordersum=ordersum+1 where id=".$item['merchantid']);
		$list = pdo_fetchall("select curryid,quantity from ".tablename('xm_gohome_takeorderitem')." where weid=".$this->weid." and orderid='".$item['orderid']."'");
		foreach ($list as $value) {
			pdo_query("update ".tablename('xm_gohome_curry')." set allsum=allsum+".$value['quantity']." where id=".$value['curryid']);
		}
		//结算计算
		if(!empty($m_item['gettype'])){
			if($m_item['gettype'] == 1){
				$getMoney = ($money*$m_item['bili_bai'])/100;
				
				$smoney = $getMoney;
				if($getMoney<=$m_item['start']){
					$smoney = $m_item['start'];
				}
				if($getMoney>=$m_item['end'] && $m_item['end']!=0){
					$smoney = $m_item['end'];
				}
				$getMoney1 = $money-$smoney;
				//平台流水日志
				$data_get = array(
					'weid'       => $this->weid,
					'merchant_id'=> $item['merchantid'],
					'orderid'    => $orderid,
					'getmoney'   => $smoney,
					'type'       => 1,
					'way'        => 1
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
				//pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");

			}else{
				$getMoney1 = $money;
				$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
				$data_g['money'] = $item_s['money'] - $m_item['bili_money'];
				pdo_update('xm_gohome_staff', $data_g, array('id' => $m_item['staff_id']));
				
				$data_get = array(
					'weid'       => $this->weid,
					'merchant_id'=> $item['merchantid'],
					'orderid'    => $orderid,
					'getmoney'   => $m_item['bili_money'],
					'type'       => 1,
					'way'        => 0
				);
				pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
			}
			$data_p = array(
				'weid'     	  => $this->weid,
				'openid'   	  => $openid,
				'merchant_id' => $item['merchantid'],
				'money'    	  => $money,
				'orderid' 	  => $item['orderid'],
				'type'        => 'takeout',
				'paytype'	  => '1',
				'getmoney'    => $getMoney1
			);
			$res = pdo_insert('xm_gohome_takepaylog', $data_p);

			pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
		}else{
			$t_item = pdo_fetch("select * from ".tablename('xm_gohome_type')." where weid=".$this->weid." and delstate=1 and id=".$m_item['type_id']);
			if(!empty($t_item['gettype'])){
				if($t_item['gettype'] == 1){
					$getMoney = ($money*$t_item['bili_bai'])/100;
					
					$smoney = $getMoney;
					if($getMoney<=$t_item['start']){
						$smoney = $t_item['start'];
					}
					if($getMoney>=$t_item['end'] && $t_item['end']!=0){
						$smoney = $t_item['end'];
					}
					$getMoney1 = $money-$smoney;
					//平台流水日志
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $item['merchantid'],
						'orderid'    => $orderid,
						'getmoney'   => $smoney,
						'type'       => 1,
						'way'        => 1
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
					//pdo_query("update ".tablename('xm_gohome_staff')." set money = money-".$smoney." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");

				}else{
					$getMoney1 = $money;
					$item_s = pdo_fetch("select money from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
					$data_g['money'] = $item_s['money'] - $t_item['bili_money'];
					pdo_update('xm_gohome_staff', $data_g, array('id' => $m_item['staff_id']));
					
					$data_get = array(
						'weid'       => $this->weid,
						'merchant_id'=> $item['merchantid'],
						'orderid'    => $orderid,
						'getmoney'   => $t_item['bili_money'],
						'type'       => 1,
						'way'        => 0
					);
					pdo_insert('xm_gohome_companygetmoney_merchant', $data_get);
				}
				$data_p = array(
					'weid'     	  => $this->weid,
					'openid'   	  => $openid,
					'merchant_id' => $item['merchantid'],
					'money'    	  => $money,
					'orderid' 	  => $item['orderid'],
					'type'        => 'takeout',
					'paytype'	  => '1',
					'getmoney'    => $getMoney1
				);
				$res = pdo_insert('xm_gohome_takepaylog', $data_p);

				pdo_query("update ".tablename('xm_gohome_staff')." set money = money+".$getMoney1." where weid=".$this->weid." and id=".$m_item['staff_id']." and delstate=1");
			}
		}
	}
	
	public function doMobileAuthmobileok(){
		global $_W,$_GPC;
		
		$mobile = $_GPC['mobile'];
		$code   = $_GPC['code'];
		$nowtime = time();
		
		$check_m = pdo_fetch("select uid from ".tablename('mc_members')." where uniacid=".$this->weid." and mobile='".$mobile."'");
		if(empty($check_m)){
			$check = pdo_fetch("select id,code from ".tablename('xm_gohome_code')." where weid=".$this->weid." and mobile=".$mobile." and type=1 and isUse=0 and ".$nowtime." between starttime and endtime");
			if(empty($check)){
				echo 0;
			}else{
				if($code == $check['code']){
					/*$data['mobile'] = $mobile;
					load()->model('mc');
					$result = mc_update($_W['member']['uid'], $data);
					*/
					pdo_query("update ".tablename('mc_members')." set mobile='".$mobile."' where uniacid=".$this->weid." and uid=".$_W['member']['uid']);
					$data_c['isUse'] = '1';
					pdo_update('xm_gohome_code', $data_c, array('id'=>$check['id']));
					echo 1;
				}else{
					echo 0;
				}
			}
		}else{
			echo 2;
		}
	}
	
	public function doMobileCodeOk(){
		global $_W,$_GPC;
	
		$mobile = $_GPC['mobile'];
		$type   = $_GPC['type'];
		//短信内容数据
		$key_info = $this->key_info;
		$msgbase  = $this->getMessageBase();
		$smstype  = $msgbase['platform']; 
		$u   	  = $msgbase['plat_name'];
		$p 		  = $msgbase['plat_pwd'];
		$tempid   = $msgbase['tempid'];
		$code     = $this->generate_code(6);
		$q        = $msgbase['qianming'];
		$q 		  = str_replace("【", '', $q);
		$q 		  = str_replace("】", '', $q);
		
		if($smstype== 1){
			$c = '验证码:'.$code.',在'.$this->getBase('timeout').'分钟内有效，请勿告诉他人。';
			$c = urlencode($c);
		}else{
			$i_arr = array(
				'to'     => $mobile,
				'tmplid' => $tempid,
				'code'   => (string)$code,
				'time'   => $this->getBase('timeout')
			);
			$c = json_encode($i_arr);
		}
		$data_sms['app'] = 'gohome';
		$data_sms['key'] = $key_info;
		$data_sms['smstype'] = $smstype;
		$data_sms['u'] = $u;
		$data_sms['p'] = $p;
		$data_sms['m'] = $mobile;
		$data_sms['q'] = $q;
		$data_sms['c'] = $c;
		
		$result = $this->post(SEND_SMS, $data_sms, 5);
		$result = json_decode($result);
		$result = $result->errcode;
		//var_dump($result);
		//exit(); 
		if($result == 0){
			$data['weid'] = $this->weid;
			$data['mobile'] = $_GPC['mobile'];
			$data['code'] = $code;
			$data['type'] = $type;
			$data['starttime'] = time();
			$data['endtime'] = time() + $this->getBase('timeout')*60;
			pdo_insert('xm_gohome_code', $data);
			echo 1;
		}else{
			echo 0;
		}
	}
	
	function version_down($url,$ver,$sql){
		global $_W,$_GPC;
		
		ob_start();
		@set_time_limit(300);
	
		if($url != 'none'){
			$res = $this->xm_getupdate($url,MODULE_ROOT,'xmupdatefile.zip',0);
			if($res['error'] == 0){
				
				$newfname= MODULE_ROOT.'/xmupdatefile.zip';
				$zip_filepath =$newfname;
				if(!empty($zip_filepath)){
					if(!is_file($zip_filepath)){
						die('升级包"'.$zip_filepath.'"下载错误,请检查文件夹权限!');
					}
					$zip = new ZipArchive();
					$rs = $zip->open($zip_filepath);
					if($rs !== TRUE)
					{
						die('解压升级包失败!Error Code:'. $rs);
					}
					$zip->extractTo(MODULE_ROOT.'/');
					$zip->close();
					//sleep(1);
					repair();
				}
				unlink($newfname);
				
				if($sql != 'none'){
					$arr = explode("####", $sql);
					foreach($arr as $value){
						$res = pdo_query($value);
					}
					$res = 1;
				}else{
					$res = 1;
				}
			
				if($res>0){
					if(empty($ver)){
					 	return 1;
					}else{
						$res1 = pdo_query("update ".tablename('xm_gohome_base')." set version='".$ver."'");
						if($res1){
							return 1;
						}else{
							return 5;
						}
					}
				}else{
					return 4;
				}
			}elseif($res['error'] == 1){
				return 2;
			}elseif($res['error'] == 3){
				return 3;
			}else{
				return 4;
			}
		}
	}
	
	function getTablePre(){
		$tablename = tablename('xm_gohome_base');
		$pre = str_replace('xm_gohome_base',' ',$tablename);
		$pre = str_replace('`','',$pre);
		return $pre;
	}
	
	function xm_getupdate($url,$save_dir='',$filename='',$type=0){  
	    if(trim($url)==''){  
	        return array('file_name'=>'','save_path'=>'','error'=>1);  
	    }  
	    if(trim($save_dir)==''){  
	        $save_dir='./';  
	    }  
	    if(trim($filename)==''){
	        $ext=strrchr($url,'.');  
	        if($ext!='.zip')
			{  
	            return array('file_name'=>'','save_path'=>'','error'=>3);  
	        }  
	        $filename=time().$ext;  
	    }  
	    if(0!==strrpos($save_dir,'/')){  
	        $save_dir.='/';  
	    }  
	 
	    if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){  
	        return array('file_name'=>'','save_path'=>'','error'=>5);  
	    }  
	  
	    if($type){  
	        $ch=curl_init();  
	        $timeout=3;  
	        curl_setopt($ch,CURLOPT_URL,$url);  
	        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);  
	        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	        $xmupdate=curl_exec($ch);  
	        curl_close($ch);  
	    }else{  
	        ob_start();   
	        readfile($url);  
	        $xmupdate=ob_get_contents();   
	        ob_end_clean();   
	    }  
	 
	    $fp2=@fopen($save_dir.$filename,'w');  
	    fwrite($fp2,$xmupdate);  
	    fclose($fp2);  
	    unset($xmupdate,$url);  
	    return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);  
	}
	
	public function doWebCompanypic(){
		global $_W,$_GPC;
		
		$openid = $_GPC['openid'];
		$item = pdo_fetch("select id,license,license_pic from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and  openid='".$openid."' and company_mge=1");         
		
		include $this->template('web/company/company-pic');
	}
	
	function getBase($str){
		global $_W;
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_base')." where weid=".$this->weid);
		if(empty($item)){
			return '';
		}else{
			return $item[''.$str.''];
		}
	}

	function getSex($sex){
		if($sex == 1){
			return '男';
		}else{
			return '女';
		}
	}
	
	function getServeType($id){
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select type_name from ".tablename('xm_gohome_servetype')." where id=".$id);
		if(empty($item)){
			return '无项目';
		}else{
			return $item['type_name'];
		}
	}
	
	function getServeInfo($id,$str){
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$id);
		if(empty($item)){
			return '';
		}else{
			return $item[''.$str.''];
		}
	}
	
	function getTypeIcon($id){
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select icon from ".tablename('xm_gohome_servetype')." where id=".$id);
		if(empty($item)){
			return '';
		}else{
			return $item['icon'];
		}
	}
	
	function getServeName($order_id){
		global $_W,$_GPC;
		
		if(empty($order_id)){
			$order_id = 0;
		}
		$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
		if(empty($item)){
			return '无数据';
		}else{
			$str = pdo_fetch("select type_name from ".tablename('xm_gohome_servetype')." where weid=".$this->weid." and id=".$item['serve_type']);
			if(empty($str)){
				return '无数据';
			}else{
				return $str['type_name'];
			}
		}
	}

	function getOrderInfo($table_name,$id,$str){
		global $_W,$_GPC;
		
		$item = pdo_fetch("select ".$str." from ".tablename(''.$table_name.'')." where weid=".$this->weid." and id=".$id);
		if($item == ''){
			return '';
		}else{
			if($str == 'ftime'){
				return substr($item[''.$str.''],0,4).'年'.substr($item[''.$str.''],5,2).'月'.substr($item[''.$str.''],8,2).'日 '.substr($item[''.$str.''],11,2).'点'.substr($item[''.$str.''],14,2).'分';
			}else{
				return $item[''.$str.''];
			}	
		}
	}
	
	function getOrderInfoValue($table_name,$id,$str,$temp_id){
		global $_W,$_GPCl;
		 
		$item1 = pdo_fetch("select ".$str." from ".tablename(''.$table_name.'')." where weid=".$this->weid." and id=".$id);
		if($item1[''.$str.''] == ''){
			return '';
		}else{
			$item2 = pdo_fetch("select input_value,value_name from ".tablename('xm_gohome_tempvalue')." where weid=".$this->weid." and temp_id=".$temp_id." and input_name='".$str."'");
			$arr1 = explode("||", $item2['input_value']);
			$arr2 = explode("||", $item2['value_name']);
			
			$arr = explode(',', $item1[''.$str.'']);
			$idStr = '';
			foreach($arr as $val){
				$str = array_search($val, $arr1);
				$idStr .= $arr2[$str].'  ';
			}
			return $idStr;
		}
	}
	
	function getOrderTime($table_name,$id,$str){
		global $_W,$_GPC;
		
		$item = pdo_fetch("select ".$str." from ".tablename(''.$table_name.'')." where weid=".$this->weid." and id=".$id);
		$time = str_replace('T',' ', $item[''.$str.'']); 
		return substr($time, 5, 14);
	}

	function getOrderGrab($order_id,$str){
		global $_W,$_GPCl;
		if(empty($order_id)){
			return '';
		}else{
			$sql="select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id;
			$item = pdo_fetch($sql);
			$table_name = $item['table_name'];
			$id = $item['other_id'];
			$items = pdo_fetch("select ".$str." from ".tablename(''.$table_name.'')." where weid=".$this->weid." and id=".$id);
			if($str == 'ftime'){
				return substr($items[''.$str.''],0,4).'年'.substr($items[''.$str.''],5,2).'月'.substr($items[''.$str.''],8,2).'日 '.substr($items[''.$str.''],11,2).'点'.substr($items[''.$str.''],14,2).'分';
			}else{
				return $items[''.$str.''];
			}
		}
	}
	
	function getOrderOver($order_id){
		global $_W,$_GPCl;
		
		if(empty($order_id)){
			$order_id = 0;
		}
		$item = pdo_fetch("select overtime from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
		if(empty($item)){
			return '';
		}else{
			return $item['overtime'];
		}
	}
	
	function getWait($order_id){
		global $_W,$_GPC;
		
		$item = pdo_fetchall("select selected from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id=".$order_id);
		$str ='';
		foreach($item as $value){
			$str = $value['selected'].','.$str;
		}
		$newstr = substr($str,0,strlen($str)-1);
		$arr = explode(",", $newstr);
		if(in_array(1,$arr)){
			return 1;
		}else{
			return 0;
		}
	}
	
	function getOrderState($state,$mode){
		if($mode == 0){
			if($state == 0){
				return '待派单';
			}
			if($state == 1){
				return '服务中';
			}
			if($state == 2){
				return '已完成';
			}
			if($state == 4){
				return '已删除';
			}
		}else{
			if($state == 0){
				return '抢单中';
			}
			if($state == 1){
				return '服务中';
			}
			if($state == 2){
				return '已完成';
			}
			if($state == 3){
				return '抢单中';
			}
			if($state == 4){
				return '已删除';
			}
		}
	}
	
	function getGrabInfo($id,$str){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and selected=1 and order_id=".$id);
		return $item[''.$str.''];
	}
	
	function getGrabInfoTime($id,$str){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and selected=0 and order_id=".$id);
		return $item[''.$str.''];
	}
	
	function getGrabOneTime($id,$str){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id=".$id);
		return $item[''.$str.''];
	}
	
	function getGrabMoney($order_id){
		global $_W,$_GPC;
		
		if(empty($order_id)){
			$order_id = 0;
		}
		$item = pdo_fetch("select offer from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id=".$order_id." and selected=1");
		return $item['offer'];
	}

	function getOrderFront($order_id){
		global $_W,$_GPC;

		$item = pdo_fetch("select front from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
		if(empty($item['front'])){
			return 0;
		}else{
			return $item['front'];
		}
	}

	function getPayMoney($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select money from ".tablename('xm_gohome_paylog')." where weid=".$this->weid." and order_id=".$id);
		return $item['money'];
	}
	
	function getStaffName($order_id){
		if(empty($order_id)){
			$order_id = 0;
		}
		$item = pdo_fetch("select staff_id from ".tablename('xm_gohome_grab')." where weid=".$this->weid." and order_id=".$order_id." and selected=1");
		
		$sitem = pdo_fetch("select staff_name from ".tablename('xm_gohome_staff')." where id=".$item['staff_id']);
		if(empty($sitem)){
			return '无数据';
		}else{
			return $sitem['staff_name'];
		}
	}
	
	function getTempName($id){
		if(empty($id)){
			return '<span style="color:red;">暂无模板</span>';
		}else{
			$item = pdo_fetch("select temp_name from ".tablename('xm_gohome_temp')." where id=".$id);
			if(empty($item)){
				return '<span style="color:red;">暂无模板</span>';
			}else{
				return $item['temp_name'];
			}
		}
	}
	
	function getMsgId(){
		global $_W,$_GPC;
		$item = pdo_fetch("select * from ".tablename('xm_gohome_base')." where weid=".$this->weid);
		return $item;

	}
	
	function getStaffCompany($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
		if(empty($item)){
			return '无数据';
		}else{
			return $item['company_flag'];
		}
	}
	
	function getStaffInfo($id,$str){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
		if(empty($item)){
			return '';
		}else{
			return $item[''.$str.''];
		}
	}
	
	function getStaffOpenid($openid){
		global $_W,$_GPC;
		
		if(empty($openid)){
			return '';
		}
		$item = pdo_fetch("select staff_name,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid = '".$openid."'");
		if(empty($item)){
			return '无数据';
		}else{
			if($item['company_flag'] == 0){
				return $item['staff_name'];
			}else{
				$item1 = pdo_fetch("select staff_name,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid = '".$openid."' and company_flag=1 and company_mge=1");
				if(empty($item1)){
					return '无数据';
				}else{
					return $item1['staff_name'];
				}
			}
		}
	}
	
	function getStaffPro($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
		$arr = explode(",",$item['serve_type']);
		
		$idStr = '';
		for($i=0;$i<count($arr);$i++){
			if(empty($arr[$i])){
				$s_id = 0;
			}else{
				$s_id = $arr[$i];
			}
			$sitem = pdo_fetch("select type_name from ".tablename('xm_gohome_servetype')." where id=".$s_id." and delstate=1");
			if(!empty($sitem)){
				$idStr .= $sitem['type_name'].'/';
			}
		}
		$idStr = rtrim($idStr,'/');
		return $idStr;
	}
	
	function getProCard($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
		$arr = explode(",",$item['serve_type']);
		
		$idStr = '';
		for($i=0;$i<count($arr);$i++){
			$sitem = pdo_fetch("select cardname from ".tablename('xm_gohome_servetype')." where id=".$arr[$i]);
			$idStr .= $sitem['cardname'].' ';
		}
		//$idStr = rtrim($idStr,'/');
		return $idStr;
	}
	
	function getStaffProject($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
		$arr = explode(",",$item['serve_type']);
		
		$idStr = '';
		for($i=0;$i<count($arr);$i++){
			$sitem = pdo_fetch("select id,type_name from ".tablename('xm_gohome_servetype')." where id=".$arr[$i]." and delstate=1");
			if(!empty($sitem)){
				$tid = $sitem['id'];
				$type_name = $sitem['type_name'];
				$url = $this->createMobileUrl('templateok',array('foo'=>'index', 'id'=>$tid, 'staff_id'=>$id));
				$idStr .= '<li><a href="'.$url.'" class="block-in uinn2-1 uba b-gra5 umar-a">'.$type_name.'</a></li>';
			}
		}
		$idStr = rtrim($idStr,'/');
		return $idStr;
	}

	function getStaffProOne($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select serve_type from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and id=".$id);
		$arr = explode(",",$item['serve_type']);
		
		$sitem = pdo_fetch("select id,type_name from ".tablename('xm_gohome_servetype')." where id=".$arr[0]." and delstate=1");
		
		if(empty($sitem)){
			return '';
		}else{
			return $sitem['type_name'];
		}
	}
	
	function getStaffFen($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select xing,cperson from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and id=".$id);
		if($item['xing'] == 0 || $item['cperson'] == 0){
			return 0;
		}else{
			return intval($item['xing']/$item['cperson']);
		}
	}

	function getMemberInfo($openid,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("select uid from ".tablename('mc_mapping_fans')." where openid = '".$openid."' and uniacid=".$this->weid);

		if(empty($item)){
			return '';
		}else{
			$item_i = pdo_fetch("select ".$str." from ".tablename('mc_members')." where uid =".$item['uid']." and uniacid=".$this->weid);
			if(empty($item_i)){
				return '';
			}else{
				return $item_i[''.$str.''];
			}
		}
	}
	
	function getMemberOpenid($uid){
		global $_W,$_GPC;
		$item = pdo_fetch("select openid from ".tablename('mc_mapping_fans')." where uid = '".$uid."'");
		if(empty($item)){
			return '无数据';
		}else{
			return $item['openid'];
		}
	}
	
	function getCompanyName($str){
		global $_W,$_GPC;
		
		$item = pdo_fetch("select company_name from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$str."' and company_mge=1");
		if(empty($item)){
			return '暂无公司';
		}else{
			return $item['company_name'];
		}
	}

	function getOptionType($id){
		if($id == 1){
			return '单选';
		}
		if($id == 2){
			return '多选';
		}
		if($id == 3){
			return '文本';
		}
	}
	
	function getInputType($id){
		if($id == 1){
			return 'radio';
		}
		if($id == 2){
			return 'checkbox';
		}
		if($id == 3){
			return 'text';
		}
	}
	
	function getCheckbox($id){
		if(empty($id)){
			$id = 0;
		}
		$list = pdo_fetchall("select id,type_name from ".tablename('xm_gohome_servetype')." where parent_id=".$id." and delstate=1");
		return $list;
	}
	
	function getBlackState($openid){
		global $_W,$_GPC;
		
		$item = pdo_fetch("select state from ".tablename('xm_gohome_blacklist')." where openid='".$openid."'");
		if(empty($item)){
			return 0;
		}else{
			return $item['state'];
		}
	}

	function getMessageBase(){
		global $_W,$_GPC;
		
		$item = pdo_fetch("select * from ".tablename('xm_gohome_message')." where weid=".$this->weid." and selected=1");
		if(empty($item['id'])){
			return '';
		}else{
			return $item;
		}
	}
	
	function getJsgs($id){
		global $_W,$_GPC;
		
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select jsgs from ".tablename('xm_gohome_temp')." where id=".$id);
		if(empty($item['jsgs'])){
			return '';
		}else{
			return $item['jsgs'];
		}
	}
	
	function creattmpletarr($tmpid,$tuser,$url,$color_title,$color_content,$dataname,$datavalue)
	{
		$datanamearr=explode("||",$dataname);
		$datavaluearr=explode("||",$datavalue);
		$str = '{"touser":"'.$tuser.'","template_id":"'. $tmpid .'","url":"'.$url.'","data":{';
		$datastr='';
		foreach($datanamearr as $name)
		{
			if($name=="remark")
			  $fg = '';
			else
			  $fg =',';  
			  
		         $arr_temp=each($datavaluearr);
                           $datastr .=  '"'.$name.'": {"value":"'.$arr_temp[1].'","color":"'.$color_content.'"}'.$fg;
		}
		$datastr = $str.$datastr.'}}';
		$jsontmp=json_encode($datastr);
		return(json_decode($jsontmp,false));
	}
	
	function getReplace($order_id,$xiaopiao){
		global $_W,$_GPC;
		
		$item = pdo_fetch("select * from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
		$orderItem = pdo_fetch("select * from ".tablename($item['table_name'])." where id=".$item['other_id']);
		//参数值替换
		$piao = strip_tags($xiaopiao,'<BR><CB><B><C><L><W><QR><CODE>');
		$piao = str_replace("&nbsp;", "", $piao);
		$piao = str_replace("<br/>", "", $piao);
		$piao = str_replace("{order}", $this->getServeType($orderItem['serve_type']), $piao);
		$piao = str_replace("{money}", $orderItem['money'], $piao);		
		$piao = str_replace("{fmobile}", $orderItem['fmobile'], $piao);		
		$piao = str_replace("{ftime}", $orderItem['ftime'], $piao);		 		
		$piao = str_replace("{fadr}",$orderItem['fadr'], $piao);
		$piao = str_replace("{fprice}",$orderItem['dealprice'], $piao);
		$piao = str_replace("{fname}",$orderItem['fname'], $piao);
		$piao = str_replace("{usernick}",$this->getMemberInfo($orderItem['openid'], 'nickname'), $piao);
		$piao = str_replace("{ordertime}", $orderItem['addtime'], $piao);
		$piao = str_replace("{staffname}",$this->getStaffInfo($item['staff_id'],'staff_name'), $piao);
		$piao = str_replace("{offer}",$this->getGrabInfo($order_id,'offer'), $piao);
		$piao = str_replace("{suremoney}",$this->getGrabInfo($order_id,'suremoney'), $piao);
		
		return $piao;
	}
	
	function getStaffId($openid){
		global $_W,$_GPC;
		$arr = pdo_fetchall("select id from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and delstate=1");
		if(empty($arr)){
			return 0;
		}else{
			$idStr = '';
			foreach($arr as $value){
				$idStr .= $value['id'].',';
			}
			$idStr = rtrim($idStr,',');
			return $idStr;
		}
	}
	
	function getGradeInfo($id, $str){
		global $_W,$_GPC;
		if(empty($id)){
			$id = 0;
		}
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_grade')." where weid=".$this->weid." and id=".$id." and delstate=1");
		if(empty($item)){
			return '';
		}else{
			return $item[''.$str.''];
		}
	}

	function getOrderFor($table_name, $id, $str){
		global $_W,$_GPC;

		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_order')." where weid=".$this->weid." and table_name='".$table_name."' and other_id=".$id);
		if(empty($item)){
			return '';
		}else{
			return $item[''.$str.''];
		}
	}

	function checkexamine($openid){
		global $_W,$_GPC;
		
		$item = pdo_fetch("select id from ".tablename('xm_gohome_examine')." where weid=".$this->weid." and openid='".$openid."'");
		if(empty($item['id'])){
			return 0;
		}else{
			return 1;
		}
	}
	
	function getOpenid($uid){
		global $_W,$_GPC;
		
		if(empty($uid)){
			$uid = 0;	
		}
		
		$item = pdo_fetch("select openid from ".tablename('mc_mapping_fans')." where uniacid=".$this->weid." and uid=".$uid);
		if(empty($item['openid'])){
			return '';
		}else{
			return $item['openid'];
		}
	}
	
	function getFansInfo($uid,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('mc_members')." WHERE uniacid=".$this->weid." AND uid=".$uid);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}

	public function createServeOrder(){
		$ordernumber = $this->generate_code(10);
		$item = pdo_fetch("select id from ".tablename('xm_gohome_order')." where weid=".$this->weid." and ordernumber=".$ordernumber);
		if(empty($item['id'])){
			return $ordernumber;
		}else{
			$this->createServeOrder($table);
		}
	}
	
	function getAdrInfo($id,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('xm_gohome_address')." WHERE weid=".$this->weid." AND id=".$id);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}
	
	function getOrderCount($id){
		global $_W,$_GPC;
		
		$count = pdo_fetchcolumn("select count(*) from ".tablename('xm_gohome_order')." where weid=".$this->weid." and serve_type=".$id." and flag=1");
		return $count;
	}

	function getGrade($str,$openid,$con){
		global $_W,$_GPC;
		if(empty($str)){
			return '';
		}else{
			$item = pdo_fetch("select ".$con." from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_name='".$str."' and company_mge=1 and openid='".$openid."' and delstate=1");
			if(!empty($item)){
				return $item[''.$con.''];
			}else{
				return '';
			}
		}
	}
	
	function getMerchantInfo($id,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('xm_gohome_merchant')." WHERE weid=".$this->weid." AND id=".$id);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}
	
	function getMenuInfo($id,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('xm_gohome_menu')." WHERE weid=".$this->weid." AND id=".$id);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}

	function getLidoInfo($id,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('xm_gohome_lido')." WHERE weid=".$this->weid." AND id=".$id);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}

	function getTypeInfo($id,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('xm_gohome_type')." WHERE weid=".$this->weid." AND id=".$id);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}

	function getCurryInfo($id,$str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('xm_gohome_curry')." WHERE weid=".$this->weid." AND id=".$id);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}

	function getCurryList($merchant_id,$menu_id){
		if(empty($merchant_id) && empty($menu_id)){
			return '';
		}else{
			$arr = pdo_fetchall("select * from ".tablename('xm_gohome_curry')." where weid=".$this->weid." and merchant_id=".$merchant_id." and menu_id=".$menu_id." and stop=1 and delstate=1 order by top asc");
			if(empty($arr)){
				return '';
			}else{
				return $arr;
			}
		}
	}

	function getCurryCode($code, $str){
		global $_W,$_GPC;
		$item = pdo_fetch("SELECT ".$str." FROM ".tablename('xm_gohome_curry')." WHERE weid=".$this->weid." AND barcode_number='".$code."' limit 0,1");
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];	
		}
	}

	function getNeedOrder($id, $str){
		global $_W,$_GPC;
		if(empty($id)){
			return '';
		}else{
			$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and id=".$id);
			if(empty($item[''.$str.''])){
				return '';
			}else{
				return $item[''.$str.''];
			}
		}
	}

	public function createTakeoutOrder(){
		$orderid = $this->generate_code(10);
		$item = pdo_fetch("select id from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and orderid=".$orderid);
		if(empty($item['id'])){
			return $orderid;
		}else{
			$this->createTakeoutOrder();
		}
	}

	public function createNeedsOrder(){
		$orderid = $this->generate_code(10);
		$item = pdo_fetch("select id from ".tablename('xm_gohome_needorder')." where weid=".$this->weid." and orderid=".$orderid);
		if(empty($item['id'])){
			return $orderid;
		}else{
			$this->createNeedsOrder();
		}
	}

	public function getOrderId($orderid){
		$item = pdo_fetch("select id from ".tablename('xm_gohome_takeorder')." where weid=".$this->weid." and orderid=".$orderid);
		if(empty($item['id'])){
			return 0;
		}else{
			return $item['id'];
		}
	}

	function getNeedWait($order_id){
		global $_W,$_GPC;
		
		$item = pdo_fetchall("select selected from ".tablename('xm_gohome_needgrab')." where weid=".$this->weid." and order_id=".$order_id);
		$str ='';
		foreach($item as $value){
			$str = $value['selected'].','.$str;
		}
		$newstr = substr($str,0,strlen($str)-1);
		$arr = explode(",", $newstr);
		if(in_array(1,$arr)){
			return 1;
		}else{
			return 0;
		}
	}

	public function randColor(){
		$arr = array('c-blu','c-blu1','c-blu2','c-blu2','c-gra','c-gra1','c-gra2','c-org','c-pink');
		return $arr[rand(0,2)];
	}
	
	public function getXing($id){
		$yu = intval(5-$id);
		$str = '';
		for($i=0;$i<$id;$i++){
			$str .= '<i class="iconfont icon-wujiaoxing t-org"></i> ';
		}
		for($j=0;$i<$yu;$j++){
			$str .= '<i class="iconfont icon-wujiaoxing t-gra"></i> ';
		}
		return $str;	
	}

	public function getKeep($id,$openid){
		global $_W,$_GPC;
		if(empty($id)){
			return 0;
		}else{
			$item = pdo_fetch("select id from ".tablename('xm_gohome_takekeep')." where weid=".$this->weid." and merchantid=".$id." and openid='".$openid."'");
			if(empty($item)){
				return 1;
			}else{
				return 0;
			}
		}
	}

	function getMerchantState($openid){
		global $_W,$_GPC;
		if(empty($openid)){
			return 0;
		}else{
			$item = pdo_fetch("select id,openid,company_flag,company_mge,merchant_state from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and openid='".$openid."'");
			if(empty($item)){
				return 0;
			}else{
				if($item['company_flag'] == 1){
					$c_item = pdo_fetch("select id,openid,merchant_state from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and delstate=1 and openid='".$item['openid']."'");
					return $c_item['merchant_state'];
				}else{
					return $item['merchant_state'];
				}
			}
		}
	}

	function getDiscInfo($merchant_id, $str){
		global $_W,$_GPC;
		if(empty($merchant_id)){
			$merchant_id = 0;
		}
		$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_activity')." where weid=".$this->weid." and merchant_id=".$merchant_id);
		if(empty($item[''.$str.''])){
			return '';
		}else{
			return $item[''.$str.''];
		}
	}

	function getStaffForId($openid){
		$item_s = pdo_fetch("select id,openid,company_flag from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and openid='".$openid."' and delstate=1");
		if($item_s['company_flag'] == 1){
			$item_c = pdo_fetch("select id,openid from ".tablename('xm_gohome_staff')." where weid=".$this->weid." and company_mge=1 and company_flag=1 and openid='".$item_s['openid']."' and delstate=1");
			$id = $item_c['id'];
		}else{
			$id = $item_s['id'];
		}
		return $id;
	}

	function getUserInfo($openid, $str){
		global $_W,$_GPC;
		if(empty($openid)){
			return '';
		}else{
			$item = pdo_fetch("select ".$str." from ".tablename('xm_gohome_members')." where weid=".$this->weid." and openid='".$openid."'");
			if($item[''.$str.''] == ''){
				return '';
			}else{
				return $item[''.$str.''];
			}
		}
	}

	function getUserTitle($order_id){
		global $_W,$_GPC;
		if(empty($order_id)){
			return '';
		}else{
			$item = pdo_fetch("select openid from ".tablename('xm_gohome_order')." where weid=".$this->weid." and id=".$order_id);
			$item_u = pdo_fetch("select title from ".tablename('xm_gohome_members')." where weid=".$this->weid." and openid='".$item['openid']."'");
			if($item_u['title'] == ''){
				return '';
			}else{
				return $item_u['title'];
			}
		}
	}

	function getBaseAdr($str){
		global $_W;
		$item = pdo_get('xm_gohome_adrstr', array('weid'=>$_W['uniacid']), array(''.$str.''));
		return $item[''.$str.''];
	}

	function getNav($str){
		global $_W;

		$item = pdo_get('xm_gohome_nav', array('weid'=>$_W['uniacid']), array(''.$str.''));
		return $item[''.$str.''];
	}

	function encode_geohash($latitude, $longitude, $deep)
	{
		$BASE32	= '0123456789bcdefghjkmnpqrstuvwxyz';
		$bits = array(16,8,4,2,1);
		$lat = array(-90.0, 90.0);
		$lon = array(-180.0, 180.0);
	
		$bit = $ch = $i = 0;
		$is_even = 1;
		$i = 0;
		$mid;
		$geohash = '';
		while($i < $deep)
		{
			if ($is_even)
			{
				$mid = ($lon[0] + $lon[1]) / 2;
				if($longitude > $mid)
				{
					$ch |= $bits[$bit];
					$lon[0] = $mid;
				}else{
					$lon[1] = $mid;
				}
			} else{
				$mid = ($lat[0] + $lat[1]) / 2;
				if($latitude > $mid)
				{
					$ch |= $bits[$bit];
					$lat[0] = $mid;
				}else{
					$lat[1] = $mid;
				}
			}
	
			$is_even = !$is_even;
			if ($bit < 4)
				$bit++;
			else {
				$i++;
				$geohash .= $BASE32[$ch];
				$bit = 0;
				$ch = 0;
			}
		}
		return $geohash;
	}
	
	
	public function getDistance($lat1, $lng1, $lat2, $lng2){
		$earthRadius = 6367000;
		$lat1 = ($lat1 * pi() ) / 180;
		$lng1 = ($lng1 * pi() ) / 180;
	 
		$lat2 = ($lat2 * pi() ) / 180;
		$lng2 = ($lng2 * pi() ) / 180;
	 
		$calcLongitude = $lng2 - $lng1;
		$calcLatitude = $lat2 - $lat1;
		$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
		$calculatedDistance = $earthRadius * $stepTwo;
		if($calculatedDistance>1000){
			return round($calculatedDistance/1000)."千米";
		}else{
			return round($calculatedDistance)."米";	
		}				 
	}
	
	function post($url, $post_data = '', $timeout = 5){
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        if($post_data != ''){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
 
        }
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }
	
	function generate_code($length = 4) {
		return rand(pow(10,($length-1)), pow(10,$length)-1);
	}
	
	function logger($log_content)
	{
		$max_size = 100000;
		$log_filename = MODULE_ROOT."/log.xml";
		if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
		file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
	}
	
}