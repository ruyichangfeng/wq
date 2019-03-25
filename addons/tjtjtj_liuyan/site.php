<?php
/**
 * 留言板模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Tjtjtj_liuyanModuleSite extends WeModuleSite {

	//获取jssdk页面的相关设置参数!
	public function doMobileToken()
	{
		global $_W,$_GPC;
		$appid = $_W['account']['key'];
		$secret = $_W['account']['secret'];

		$token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;

		$token_data = ihttp_get($token_url);
		$url = $_GPC['url'];
		if($_GPC['val'] == "get_token")
		{
			echo json_encode($token_data);
		}

		if($_GPC['val'] == "post_token"){
			$token = $_GPC['token'];
			$token = $token['access_token'];

			$tocket_url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$token."&type=jsapi";

			$tic_data = ihttp_get($tocket_url);
			$tic_json = json_decode($tic_data['content'],true);
			$ticket = $tic_json['ticket'];

			$time = 1414587462;
			$nonceStr = "tjtjtj_liuyan";
			$urls = $url;

			$str = "jsapi_ticket={$ticket}&noncestr={$nonceStr}&timestamp={$time}&url={$urls}";
			$config = array(
				'time' => 1414587462,
				'nonceStr' => $nonceStr,
				'singatura' => sha1($str),
				'url' => $url
			);
			echo json_encode($config);
		}


	}

	public function doMobileFabus()
	{
		global $_W,$_GPC;
		//require 'inc/mobile/fabu.inc.php';
		define("ASSETS_PATH",MODULE_URL.'public/assets/');
		$ids = $_GPC['media_ids'];

		$info = $_GPC['info'];

		$site = pdo_fetch("SELECT isread FROM ".tablename("liuyan_website")." WHERE acid = ".$_W['account']['acid']);
		$status = $site['isread'];

		if($ids != "" && $info != "")
		{
			$filelist = array();
			$check_ids = explode(",",$ids );
			if(count($check_ids) != 0)
			{
				$filelist = $this->downloadFromWxServer($ids, $this->settings);
			}

			$data = array(
				'user' => $_W['fans']['nickname'],
				'uid' => $_W['fans']['uid'],
				'info' => $_GPC['info'],
				'img' => serialize($filelist),
				'time' => time(),
				'openid' => $_W['fans']['openid'],
				'headimg' => $_W['fans']['tag']['avatar'],
				'status' => $status,
				'acid' => $_W['account']['acid'],
			);



			if(pdo_insert("liuyan_liuyan",$data))
			{
				echo json_encode(1);
			}
			else
			{
				echo json_encode(0);
			}

		}

		include $this->template("fabu");


	}

	public function doMobileShow()
	{
		global $_W,$_GPC;
		define("ASSETS_PATH",MODULE_URL."public/assets/");
		$lid = intval($_GPC['lid']);
		$uid = intval($_GPC['uid']);

		$sql = "SELECT * FROM ".tablename("liuyan_liuyan")." WHERE id =".$lid;
		$linfo = pdo_fetch($sql);


		$linfo['img'] = unserialize($linfo['img']);

		unset($sql);

		$sql = "SELECT * FROM ".tablename("liuyan_huifu")." WHERE uid = ".$uid." AND lid = ".$lid;

		$hres = pdo_fetchall($sql);



		$site = pdo_fetch("SELECT * FROM ".tablename("liuyan_website")." WHERE acid = ".$_W['account']['acid']);



		include $this->template('show');
	}

	public function doWebDatadoing()
	{
		global $_W,$_GPC;
		$uid = $_GPC['uid'];
		$id = $_GPC['id'];
		$sql = "SELECT * FROM ".tablename("liuyan_huifu")." WHERE uid = :uid AND lid = :lid";

		$result = pdo_fetchall($sql,array(':uid'=>$uid,':lid'=>$id));

		echo json_encode($result);
	}

	public function doWebChange()
	{
		global $_W,$_GPC;

		$id = $_GPC['id'];

		if(pdo_update("liuyan_liuyan",array("status"=>1),array("id"=>$id)))
		{
			echo json_encode(1);
		}
		else
		{
			echo json_encode(0);
		}

	}

	public function doMobileIndex() {

		define("ASSETS_PATH", MODULE_URL.'public/assets/');
		global $_W,$_GPC;
		$action = $_GPC['action'];

		//把访问的新用户记录到数据库
if(empty($action))
	{
	if (empty($_W['fans']['nickname'])) {
		mc_oauth_userinfo();
	}
	$data = array(
		'uid' => $_W['fans']['uid'],
		'openid' => $_W['fans']['openid'],
		'name' => $_W['fans']['tag']['nickname'],
		'headimg' => $_W['fans']['tag']['avatar'],
		'sex' => $_W['fans']['tag']['sex'],
		'address' => $_W['fans']['tag']['city']."-".$_W['fans']['tag']['province']."-".$_W['fans']['tag']['country'],
		'acid' => $_W['account']['acid']
	);

	if($_W['fans']['openid'] = $data['openid'])
	{
		$set = pdo_fetch("SELECT * FROM ".tablename("liuyan_user")." WHERE openid = '".$_W['fans']['openid']."' ");
		if($set = "")
		{
			pdo_insert('liuyan_user',$data);
		}
	}
	else
	{
		"无法获取您的信息，拒绝访问。";
	}
	$user = pdo_fetch("SELECT * FROM ".tablename("liuyan_user")." WHERE openid = '".$_W['fans']['openid']."' ");
	}

		$sql = "SELECT * FROM ".tablename("liuyan_liuyan")." WHERE status = 1 AND acid = ".$_W['account']['acid'] ." order by time DESC";

		$result = pdo_fetchall($sql);
		foreach ($result as $k => $v)
		{
			$result[$k]['img'] = unserialize($result[$k]['img']);
		}

		$setting = pdo_fetch("SELECT * FROM ".tablename("liuyan_website")." WHERE acid = ".$_W['account']['acid']);

		$show_url = $this->createMobileUrl("show");
		$fabu_url = $this->createMobileUrl('Fabus');
		include $this->template('index');

	}

	public function doMobilePages()
	{
		global $_W,$_GPC;
		$pageindex = intval($_GPC['page']); // 当前页码
			$pagesize = 5; // 设置分页大小

			$nextpage = $pageindex+1;
			$sql = "SELECT COUNT(*) FROM ".tablename("liuyan_liuyan")." LEFT JOIN ".tablename("liuyan_user")." ON ".tablename("liuyan_liuyan").".uid = ".tablename("liuyan_user").".uid WHERE ".tablename("liuyan_liuyan").".status = 1 AND ".tablename("liuyan_liuyan").".acid = ".$_W['account']['acid'];

			$total = pdo_fetchcolumn($sql);

			$loading_count = ceil($total / $pagesize);

			//$sql = 'SELECT * FROM '.tablename("liuyan_liuyan")." WHERE acid = ".$_W['uniacid']." ORDER BY id asc LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;
			$sql = "SELECT * FROM ".tablename("liuyan_liuyan")." LEFT JOIN ".tablename("liuyan_user")." ON ".tablename("liuyan_liuyan").".uid = ".tablename("liuyan_user").".uid WHERE ".tablename("liuyan_liuyan").".status = 1 AND ".tablename("liuyan_liuyan").".acid = ".$_W['account']['acid']." ORDER BY time DESC LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;

			$result = pdo_fetchall($sql);
			foreach ($result as $k => $v)
			{
				$result[$k]['img'] = unserialize($result[$k]['img']);
			}

			echo $this->JSON($result);
	}

	public function JSON($array) {
		$this->arrayRecursive($array, 'urlencode', true);
		$json = json_encode($array);
		return urldecode($json);
	}

	public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
		{
		
			 foreach ($array as $key => $value) {
			  if (is_array($value)) {
			   self::arrayRecursive($array[$key], $function, $apply_to_keys_also);
			  } else {
			   $array[$key] = $function($value);
			  }
			  if ($apply_to_keys_also && is_string($key)) {
			   $new_key = $function($key);
			   if ($new_key != $key) {
			    $array[$new_key] = $array[$key];
			    unset($array[$key]);
			   }
			  }
			 }
			 $recursive_counter--;
	}
	

	public function doWebLiuyan() {
		global $_W,$_GPC;

		$pageindex = max(intval($_GPC['page']), 1); // 当前页码
		$pagesize = 10; // 设置分页大小

		$sql = 'SELECT COUNT(*) FROM '.tablename("liuyan_liuyan")." WHERE acid = ".$_W['account']['acid'];
		$total = pdo_fetchcolumn($sql);
		$pager = pagination($total, $pageindex, $pagesize);

		$sql = 'SELECT * FROM '.tablename("liuyan_liuyan")." WHERE acid = ".$_W['account']['acid']." ORDER BY id asc LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;

		$result = pdo_fetchall($sql);


			include $this->template('web/liyan_site');
	}

	public function doWebDelliuyan()
	{
		global $_W,$_GPC;

		$id = intval($_GPC['del_id']);

		pdo_delete('liuyan_liuyan', array('id'=>$id));

		echo 1;

	}

	public function doWebGetimg()
	{
		global $_W,$_GPC;
		if($_GPC['wid'] != "")
		{
			$liuyan = pdo_fetch("SELECT * FROM ".tablename("liuyan_liuyan")." WHERE id = :wid",array(":wid"=>$_GPC['wid']));
			$liuyan['img'] = unserialize($liuyan['img']);
			echo json_encode($liuyan);
			//echo $_GPC['wid'];

		}
	}

	public function doWebChuli() {
		global $_W,$_GPC;

		$pageindex = max(intval($_GPC['page']), 1); // 当前页码
		$pagesize = 10; // 设置分页大小

		$sql = 'SELECT COUNT(*) FROM '.tablename("liuyan_liuyan")." WHERE acid = ".$_W['account']['acid'];
		$total = pdo_fetchcolumn($sql);
		$pager = pagination($total, $pageindex, $pagesize);

		$sql = 'SELECT * FROM '.tablename("liuyan_liuyan")." WHERE acid = ".$_W['account']['acid']." ORDER BY id asc LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;
		$goodses = pdo_fetchall($sql);


		load()->func('tpl');


		if($_GPC['content'] != "" && $_GPC['uid'] != "")
		{
			$data = array(
				'content' => $_GPC['content'],
				'uid' => $_GPC['uid'],
				'lid' => $_GPC['lid'],
				'time' => date("Y-m-d H:i:s"),
				'type' => 0
			);

			if(pdo_insert("liuyan_huifu",$data))
			{
				message("回复成功","","success");
			}
			else
			{
				message("回复失败","","error");
			}
		}



		include $this->template('web/index2');
	}
	public function doWebCanshu() {
		global $_W,$_GPC;
		define("ASSETS_PATH", MODULE_URL.'public/assets/');
		define("UPLOAD_PATH",MODULE_URL."public/img/");

		$sql = "SELECT * FROM ".tablename("liuyan_website")."WHERE acid = ".$_W['account']['acid'];

		$setting = pdo_fetch($sql);

		$appid = $_W['account']['key'];
		$auth_info = pdo_fetch("SELECT * FROM ".tablename("liuyan_auth")." WHERE appid = :appid",array(':appid'=>$appid));


		if($_GPC['submit'] != "")
		{

			if($setting['acid'] == "")
			{
				pdo_insert("liuyan_website", array(
						'title'=>$_GPC['title'],
						'banner'=>$_GPC['banner'],
						'foot_img'=>$_GPC['foot_img'],
						'admins'=>$_GPC['admins'],
						'orders'=>$_GPC['orders'],
						'isread'=>$_GPC['isread'],
						'copy'=>$_GPC['copy'],
						'tiaoshu'=>$_GPC['tiaoshu'],
						'acid'=> $_W['account']['acid'],
					));
			}
			else
			{
				pdo_update("liuyan_website",
					array(
						'title'=>$_GPC['title'],
						'banner'=>$_GPC['banner'],
						'foot_img'=>$_GPC['foot_img'],
						'admins'=>$_GPC['admins'],
						'orders'=>$_GPC['orders'],
						'isread'=>$_GPC['isread'],
						'copy'=>$_GPC['copy'],
						'tiaoshu'=>$_GPC['tiaoshu']
					),
					array('acid'=>$_W['account']['acid'])
				);
			}


			$auth_data = array(
				'appid' => $_W['account']['key'],
				'acid' => $_W['account']['acid'],
				'time' => date("Y-m-d H:i:s")
			);


			if($auth_info['acid'] != $_W['account']['acid'])
			{
				pdo_insert("liuyan_auth",$auth_data);
			}

			message("操作成功",'','success');
		}

		include $this->template('web/index3');
	}

	static function downloadFromWxServer($media_ids, $settings)
	{
		global $_W, $_GPC;
		$media_ids = explode(',', $media_ids);
		if (!$media_ids) {
			echoJson(array('res' => '101', 'message' => 'media_ids error'));
		}
//		load()->classs('weixin.account');

		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$_W['account']['key']."&secret=".$_W['account']['secret'];

		$data_token = ihttp_get($url);

		$token = json_decode($data_token['content'],true);


		$access_token = $token['access_token'];
		load()->func('communication');
		load()->func('file');
		$contentType["image/gif"] = ".gif";
		$contentType["image/jpeg"] = ".jpeg";
		$contentType["image/png"] = ".png";
		foreach ($media_ids as $id) {
			$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=" . $access_token . "&media_id=" . $id;
			$data = ihttp_get($url);
			$filetype = $data['headers']['Content-Type'];

			if($filetype == "image/jpeg")
			{
				$filename = date('YmdHis') .'_' . rand(1000, 9999) . $contentType[$filetype];
				$wr = file_write('/images/tjtjtj_liuyan/' . $filename, $data['content']);
				if ($wr) {
					$file_succ[] = array('name' => $filename, 'path' => '/images/tjtjtj_liuyan/' . $filename, 'type' => 'local');
				}
			}
			else
			{
				$file_succ[] = array('name' => "", 'path' => '', 'type' => '');
			}

		}


		foreach ($file_succ as $key => $value) {

			$r = file_remote_upload('images/tjtjtj_liuyan/' . $value['name']);
			if (is_error($r)) {
				unset($file_succ[$key]);
				continue;
			}
			if($file_succ[$key]['name'] != "")
			{
				$file_succ[$key]['name'] = tomedia('images/tjtjtj_liuyan/' . $value['name']);
				$file_succ[$key]['type'] = 'other';
			}

		}

		return $file_succ;
	}

}


