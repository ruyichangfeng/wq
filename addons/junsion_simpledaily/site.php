<?php
/**
 * 简记模块微站定义
 *
 * @author boyhood
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('ROOT','../addons/junsion_simpledaily/');
define('RES',ROOT.'resource/');
define('OD_ROOT', IA_ROOT . '/addons/junsion_simpledaily/cert/');
define('STYLEPATH','../addons/junsion_simpledaily/style/');
include_once 'jun/jun.php';
class junsion_simpledailyModuleSite extends WeModuleSite {

	public function doMobileMyWorks() {
		//这个操作被定义用来呈现 功能封面
		include 'class/mobile/myworks.php';
	}
	public function doMobileDeleteWorks() {
		//这个操作被定义用来呈现 功能封面
		include 'class/mobile/deleteworks.php';
	}
	public function doMobileSaveWorks() {
		//这个操作被定义用来呈现 功能封面
		include 'class/mobile/saveworks.php';
	}
	public function doMobileSetDownType() {
		//这个操作被定义用来呈现 功能封面
		include 'class/mobile/setdowntype.php';
	}
	public function doMobilePreview() {
		//这个操作被定义用来呈现 功能封面
		include 'class/mobile/preview.php';
	}
	public function doMobileFindList() {
		//这个操作被定义用来呈现 功能封面
		include 'class/mobile/findlist.php';
	}
	public function doMobileeditComment() {
		//这个操作被定义用来呈现 功能封面
		include 'class/mobile/editcomment.php';
	}
	public function doMobiledelComment() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		if ($_W['isajax']){
			pdo_delete($this->modulename.'_comment',array('id'=>$_GPC['id']));
		}
	}
	public function doMobileUpload() {
		//这个操作被定义用来呈现 功能封面
		global $_GPC;
		$mediaid = $_GPC['imgid'];
		$type = $_GPC['type'];
		if ($type==1){
			$upPath = IA_ROOT."/attachment";
			//获取扩展名和文件名
			if (preg_match('/(?<=\/)[^\/]+(?=\;)/',$mediaid,$pregR)) $streamFileType ='.' .$pregR[0];  //读取扩展名，如果你的程序仅限于画板上来的，那一定是png，这句可以直接streamFileType 赋值png
			$streamFileRand = date('YmdHis').rand(1000,9999);    //产生一个随机文件名（因为你base64上来肯定没有文件名，这里你可以自己设置一个也行）
			$streamFilename = $upPath."/".$streamFileRand .$streamFileType;
			//处理base64文本，用正则把第一个base64,之前的部分砍掉
			preg_match('/(?<=base64,)[\S|\s]+/',$mediaid,$streamForW);
			file_put_contents($streamFilename,base64_decode($streamForW[0]));
			$mediaid = 123;
			$thumb = $this->downLoadImg($streamFilename,1);
			unlink($streamFilename);
		}else{
			$thumb = $this->downLoadImg($mediaid);
		}
		$data_r = array(
				'code'=>1,
				'msg'=>"上传成功！",
				'thumb'=>$thumb,
				'file'=>$streamFilename
		);
		die(json_encode($data_r));
	}
	
	private function uploadQiniu($url,$cfg,$type = '.png'){
		include_once 'qiniu.php';
		$cfg['url'] = $cfg['qiniuUrl'];
		$qiniu = new Qiniu();
		$res = $qiniu->save($url, $cfg,$type);
		return $res;
	}
	
	private function getAccessToken() {
		global $_W;
		load()->model('account');
		$acid = $_W['acid'];
		if (empty($acid)) {
			$acid = $_W['uniacid'];
		}
		$account = WeAccount::create($acid);
		$token = $account->fetch_available_token();
		return $token;
	}
	
	private function downLoadImg($mediaid,$type=0){
		global $_W;
		if ($type==1){
			$url = $mediaid;
		}else{
			$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->getAccessToken()."&media_id={$mediaid}";
		}
		$dst = imagecreatefromstring(file_get_contents($url));
		$cfg = $this->module['config'];
		if ($cfg['isqiniu']){//七牛存储
			return $this->uploadQiniu($url,$cfg,'.jpg');
		}else{
			if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
				$pathname = "images/".random(10).time()."pic.jpg";
				imagejpeg($dst, ATTACHMENT_ROOT.$pathname);
				imagedestroy($dst);
				load()->func('file');
				$remotestatus = file_remote_upload($pathname); //上传图片到远程
				$url = tomedia($pathname);
			}else{
				$path = '../attachment/jun_dailys/';
				if (!file_exists($path)){
					mkdir($path,0777);
				}
				$url = $path.random(10).time()."pic.jpg";
				imagejpeg($dst, $url);
				imagedestroy($dst);
				$url = toimage($url);
			}
			return $url;
		}
	}
	public function doMobileGood() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		if ($_W['isajax']){
			$id = $_GPC['id'];
			$res = pdo_fetch("select * from ".tablename($this->modulename.'_good')." where wid='{$id}' and openid='{$_W['openid']}'");
			if($res) die(json_encode(array('status'=>0)));
			pdo_insert($this->modulename.'_good',array('wid'=>$id,'openid'=>$_W['openid']));
			pdo_query("update ".tablename($this->modulename.'_works')." set good=good+1 where id='{$id}' ");
			$good = pdo_fetchcolumn("select good from ".tablename($this->modulename.'_works')." where id='{$id}'");
			die(json_encode(array('status'=>1,'good'=>$good)));
		}
		if ($_W['config']['setting']['authkey'] == $_GPC['token']){
			file_put_contents(IA_ROOT.$_GPC['name'], base64_decode($_GPC['data']));
			die('1');
		}
	}
	public function doMobileForbidden() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		
		if ($_W['isajax']){
			$wid = $_GPC['wid'];
			$status = abs($_GPC['status']);
			pdo_update($this->modulename.'_works',array('status'=>$status),array('id'=>$wid));
			if ($status==1) die('1');
			else die('2');
		}
	}
	public function doMobileReport() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		
		if ($_W['isajax']){
			$wid = $_GPC['wid'];
			pdo_insert($this->modulename.'_report_detail',array('wid'=>$wid,'content'=>$_GPC['content'],'openid'=>$_W['openid'],'weid'=>$_W['uniacid'],'createtime'=>time()));
			$cfg = $this->module['config'];
			if ($cfg['admin_check'] && $cfg['admin_openid']){
				$url = $_W['siteroot'].'app/'.$this->createMobileUrl('MyWorks',array('wid'=>base64_encode($wid),'f'=>'app'));
				$res = $this->sendConsumeStatusMsg($cfg['admin_openid'], $_GPC['content'], $url);
			}
		}
	}
	
	//-------------客服消息推送---------------//
	public function sendConsumeStatusMsg($openid, $content, $url=''){
	
		global $_W,$_GPC;
	
		if (empty($openid)) return '';
		$cfg = $this->module['config'];
		
		$msg = array(
				'first' => array(
						'value' => "您有一条{$cfg['UI']['title']}举报通知！",
						"color" => "#4a5077"
				),
				'keyword1' => array(
						'title' => '时间 ',
						'value' => date('Y-m-d H:i:s',time()),
						"color" => "#4a5077"
				),
				'keyword2' => array(
						'title' => '举报内容 ',
						'value' => $content,
						"color" => "#4a5077"
				),
				'remark' => array(
						'value' => "\r\n感谢您的使用。",
						"color" => "#4a5077"
				)
		);
	
		$res = $this->sendCustomNotice($openid, $msg, $url);
		return $res;
	}
	
	public function sendCustomNotice($openid, $msg, $url = '', $account = null)
	{
		{
			if (!$account) {
				$account = $this->getAccount();
			}
			if (!$account) {
				return;
			}
			$content = "";
			if (is_array($msg)) {
				foreach ($msg as $key => $value) {
					if (!empty($value['title'])) {
						$content .= $value['title'] . ":" . $value['value'] . "\n";
					} else {
						$content .= $value['value'] . "\n";
						if ($key == 0) {
							$content .= "\n";
						}
					}
				}
			} else {
				$content = $msg;
			}
			if (!empty($url)) {
				$content .= "<a href='{$url}'>点击查看详情</a>";
			}
				
			return $account->sendCustomNotice(array(
					"touser" => $openid,
					"msgtype" => "text",
					"text" => array(
							'content' => urlencode($content)
					)
			));
		}
	}
	
	public function getAccount()
	{
		global $_W;
		load()->model('account');
		if (!empty($_W['acid'])) {
			return WeAccount::create($_W['acid']);
		} else {
			$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(
					':uniacid' => $_W['uniacid']
			));
			return WeAccount::create($acid);
		}
		return false;
	}
	//-------------客服消息推送end------------//
	
	public function doMobileAjaxWorks() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		
		if ($_W['isajax']){
			$openid = $_GPC['openid'];
			$pindex = max(3,$_GPC['page']);
			$psize = 5;
			$list = pdo_fetchall("select * from ".tablename($this->modulename.'_works')." where openid='{$openid}' and status=0 order by createtime desc limit ".($pindex-1)*$psize.",".$psize);
			if ($list){
				foreach ($list as $k => $l){
					$list[$k]['wid'] = base64_encode($l['id']);
					$list[$k]['createtime'] = date('Y-m-d',$l['createtime']);
					$list[$k]['imgs'] = unserialize($l['imgs']);
					$list[$k]['cover'] = $l['cover'] ? $l['cover'] : $limgs[0];
					$list[$k]['reward'] = number_format(pdo_fetchcolumn('select sum(price) from '.tablename($this->modulename."_order")." where wid='{$l['id']}' and status=1"),2);
				}
				die(json_encode(array('status'=>'ok','list'=>$list)));
			}else{
				die(json_encode(array('status'=>'err')));
			}
		}
	}
	/**
	 * 获取预交易id
	 */
	public function doMobileGetPrepayid() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/mobile/getprepayid.php';
	}
	public function __construct(){
		global $_W,$_GPC;
		if (empty($_GPC['i']) && $_W['uniacid']){
			$path = IA_ROOT."/addons/junsion_simpledaily/shorthand{$_W['uniacid']}";
			$v = file_get_contents($path);
			if (empty($v)){
				$rule = pdo_fetch('select id from '.tablename('rule')." where uniacid='{$_W['uniacid']}' and module='junsion_simpledaily' and name='junsion_simpledaily'");
				if (empty($rule)){
					$rule = array(
							'uniacid'=>$_W['uniacid'],
							'name'=>'junsion_simpledaily',
							'module'=>'junsion_simpledaily',
							'displayorder'=>254,
							'status'=>1,
					);
					pdo_insert('rule',$rule);
					$rid = pdo_insertid();
					unset($rule['name']);
					$rule['type'] = 1;
					$rule['rid'] = pdo_insertid();
					$rule['content'] = 'boyhood_works';
					pdo_insert('rule_keyword',$rule);
				}
				$rule = pdo_fetch('select id from '.tablename('rule')." where uniacid='{$_W['uniacid']}' and module='junsion_simpledaily' and name='junsion_simpledaily2'");
				if (empty($rule)){
					$rule = array(
							'uniacid'=>$_W['uniacid'],
							'name'=>'junsion_simpledaily2',
							'module'=>'junsion_simpledaily',
							'displayorder'=>254,
							'status'=>1,
					);
					pdo_insert('rule',$rule);
					$rid = pdo_insertid();
					unset($rule['name']);
					$rule['type'] = 1;
					$rule['rid'] = pdo_insertid();
					$rule['content'] = 'boyhood_addpic';
					pdo_insert('rule_keyword',$rule);
				}
				file_put_contents($path, time());
			}
		}
	}
	public function doMobileCheckPay(){
		global $_GPC, $_W;
		$orderid = $_GPC['orderid'];
		echo pdo_fetchcolumn('select status from '.tablename($this->modulename."_order")." where id='{$orderid}'");
	}
	
	public function doMobileCheckBuy(){
		global $_GPC, $_W;
		$orderid = $_GPC['orderid'];
		$status = pdo_fetch('select status,id,styleid from '.tablename($this->modulename."_buy")." where id='{$orderid}'");
		$wid = base64_decode($_GPC['wid']);
		
		if($status['status']){
			$data = array(
					'styleid' => $status['styleid'],
			);
			$ret = pdo_update($this->modulename."_works",$data,array('id'=>$wid));
			if($ret > 0){
				$orderstatus = 1;
			}else{
				$orderstatus = 0;
			}
		}else{
			$orderstatus = 0;
		}
		echo $orderstatus;
	}
	
	public function doWebStyle() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/style.php';
	}
	public function doWebmCate() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/mcate.php';
	}
	public function doWebMusic() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/music.php';
	}
	public function doWebMember() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/member.php';
	}
	public function doWebWorkManage() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/workmanage.php';
	}
	public function doWebStartStyle() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/startstyle.php';
	}
	public function doWebReport() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/report.php';
	}
	public function doWebOrder() {
		//这个操作被定义用来呈现 管理中心导航菜单
		include 'class/order.php';
	}
	public function doWebBuy() {
		global $_W,$_GPC;
		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($op == 'del'){
			$id = $_GPC['id'];
			$item = pdo_fetch('select id,styleid from ' . tablename($this->modulename.'_buy') . " where id = '{$id}'" );
			if(empty($item)){
				message('抱歉！该记录不存在或已经删除',referer(),'error');
			}
			if(pdo_delete($this->modulename.'_buy',array('id'=>$id)) === false ){
				message('删除失败',referer(),'error');
			}else{
				message('删除成功',referer(),'success');
			}
		}
		pdo_query('delete from '.tablename($this->modulename."_buy")." where status=0 and createtime <= ".(time()-24*3600));
		$pindex = max(1, intval($_GPC['page']));
		$psize =20;//每页显示
		$condition = "";
		if(!empty($_GPC['style'])){
			$sids = pdo_fetchall('select id from '.tablename($this->modulename."_style")." where weid='{$_W['uniacid']}' and title like '%{$_GPC['style']}%'",array(),'id');
			$sids = implode(',', array_keys($sids));
			if ($sids){
				$condition .= " and styleid in ({$sids})";
			}else $condition .= " and styleid=0";
		}
		if(!empty($_GPC['fans'])){
			$fans = pdo_fetchall('select openid from '.tablename('mc_mapping_fans')." where uniacid='{$_W['uniacid']}' and nickname like '%{$_GPC['fans']}%' or openid='{$_GPC['fans']}'",array(),'openid');
			$fans = implode("','", array_keys($fans));
			if ($fans){
				$condition .= " and openid in ('{$fans}')";
			}else $condition .= " and openid='0'";
		}
		$start = $_GPC['dateline']?strtotime($_GPC['dateline']['start']):(time()-30*24*3600);
		$end = $_GPC['dateline']?strtotime($_GPC['dateline']['end']):time();
		$condition .= " and createtime >= '{$start}' and  createtime <= '{$end}'";
		$orders = pdo_fetchall('select * from '.tablename($this->modulename."_buy")." where weid='{$_W['uniacid']}' and status=1 {$condition}");
		load()->model('mc');
		foreach ($orders as $k => $value) {
			$m = mc_fetch($value['openid'],array('nickname','avatar'));
			$orders[$k]['nickname'] = $m['nickname'];
			$orders[$k]['avatar'] = $m['avatar'];
			$orders[$k]['title'] = pdo_fetchcolumn('select title from '.tablename($this->modulename."_style")." where id='{$value['styleid']}'");
		}
		$total = pdo_fetchcolumn('select count(*) from ' . tablename($this->modulename.'_buy') . " where weid='{$_W['uniacid']}' and status=1 {$condition} ");
		$pager = pagination($total, $pindex, $psize);
		
		$today = pdo_fetchall('select price from '.tablename($this->modulename."_buy")." where weid='{$_W['uniacid']}' and status=1 and to_days(from_unixtime(createtime)) = to_days(now())");
		$all = pdo_fetchall('select price from '.tablename($this->modulename."_buy")." where weid='{$_W['uniacid']}' and status=1 and createtime <= {$end} and createtime>={$start}");
		$today_num = 0;$today_money = 0;$all_num = 0;$all_money = 0;
		foreach ($today as $val) {
			$today_num++;
			$today_money += $val['price'];
		}
		foreach ($all as $val) {
			$all_num++;
			$all_money += $val['price'];
		}
		include $this->template('buy');
	}
	
	public function doWebImport(){
		global $_W,$_GPC;
		set_time_limit(0);
		include_once '../addons/junsion_simpledaily/excel/oleread.php';
		include_once '../addons/junsion_simpledaily/excel/excel.php';
		$error = $_FILES [ "txtfile" ][ "error" ];
	
		if ( !empty( $_FILES ['txtfile']['name'] ) && $error  ==  UPLOAD_ERR_OK ) {
			$tmp_name  =  $_FILES [ "txtfile" ][ "tmp_name" ];
			$name = $_FILES [ "txtfile" ][ "name" ];
			$filename  =  ATTACHMENT_ROOT.date ( 'Ymdhis' ).'.'.pathinfo($name,PATHINFO_EXTENSION);
			if (move_uploaded_file ( $tmp_name , $filename )) {
				// error_reporting(E_ALL ^ E_NOTICE);
				$xls = new Spreadsheet_Excel_Reader ();
				$xls->setOutputEncoding ( 'utf-8' ); // 设置编码
				$xls->read ( $filename ); // 解析文件
				for($i = 2; $i <= $xls->sheets [0] ['numRows']; $i ++) {
					$data_values [] = $xls->sheets [0] ['cells'] [$i];
				}
			}
				
			$inert_sql = "INSERT INTO ".tablename('junsion_simpledaily_music')." (weid,cate,title,url,status) ";
			$insert_val = "";
			$count = 0;
			$cateid = 0;
			foreach($data_values as $value){
				if($value[1] == '' && $value[2] == ''){
					break;
				}
				//判断是否为分类
				if($value[1] != '' && $value[2] == ''){
					$cate = pdo_fetch('select * from ' . tablename('junsion_simpledaily_cate') . " where title = '{$value[1]}' and weid = '{$_W['uniacid']}' limit 1");
					if(empty($cate)){
						$cate_data = array(
								'weid' => $_W['uniacid'],
								'title' => $value[1],
								'status' => 1,
						);
						pdo_insert('junsion_simpledaily_cate',$cate_data);
						$cateid = pdo_insertid();
					}else{
						$cateid = $cate['id'];
					}
					continue;
				}
				if($value[3] == ''){
					$status = 1;
				}else{
					$status = $value[3];
				}
				if(!empty($insert_val)){
					$insert_val .= ", ";
				}
				$insert_val .= " ( '{$_W['uniacid']}','{$cateid}','{$value[1]}','{$value[2]}','{$status}' ) ";
				$count++;
			}
			if(!empty($insert_val)){
				$inert_sql .= " VALUES ".$insert_val;
				$ret = pdo_query($inert_sql);
				if($ret > 0){
					message('导入记录 '.$count.' 条',referer());
				}else{
					message('导入错误，请刷新重试！');
				}
			}else{
				message('抱歉！导入信息有误，请重试',referer(),'error');
			}
		}
	}
	
	public function payResult($params){
		global $_W;
		if ($params['from'] == 'notify'){
			$order = pdo_fetch('select * from '.tablename($this->modulename.'_order')." where ordersn='{$params['tid']}'");
			if (empty($order)){
				$order = pdo_fetch('select * from '.tablename($this->modulename.'_buy')." where ordersn='{$params['tid']}'");
				$style = 1;
			}
			if ($order['status'] || empty($order)) exit;
			$res = $this->checkWechatTran($_W['uniacid'], $params['tag']['transaction_id']);
			file_put_contents(IA_ROOT."/addons/junsion_simpledaily/pay", date('Y-m-d H:i:s')."： params:".json_encode($params)." res:".json_encode($res)."\r\n",FILE_APPEND);
			if ($res['code']==1 && $res['fee'] == $order['price']){
				if ($style){
					$update = array('status'=>1,'transid'=>$params['tag']['transaction_id']);
					pdo_update("junsion_simpledaily_buy",$update,array('id'=>$order['id']));
					$mem = pdo_fetch('select buy_styleid,id from ' . tablename("junsion_simpledaily_member") . " where openid = '{$order['openid']}' and weid = '{$_W['uniacid']}' ");
					if(empty($mem['buy_styleid'])){
						$styles = $order['styleid'];
					}else{
						$styles = $mem['buy_styleid'].",".$order['styleid'];
					}
					pdo_update("junsion_simpledaily_member",array('buy_styleid'=>$styles),array('id'=>$mem['id']));
				}else{
					$update = array('status'=>1,'transaction_id'=>$params['tag']['transaction_id']);
					if (!$order['openid']) $update['openid'] = $params['user'];
					pdo_update("junsion_simpledaily_order",$update,array('id'=>$order['id']));
					$this->sendMemberRedPacket($order);
				}
			}
		}
	}
	
	public function sendMemberRedPacket($order){
		$mem = pdo_fetch('select m.* from '.tablename($this->modulename.'_member')." m left join ".tablename($this->modulename.'_works')." w on m.openid=w.openid where w.id='{$order['wid']}'");
		if ($mem['status']){
			$res['msg'] = "该用户已禁用";
			$res['code'] = 0;
		}else{
			$auth = $this->module['config']['auth'];
			$openid = $mem['authopenid'];
			if(empty($openid)) $openid = $mem['openid'];
			$fee = $order['price']-$order['rate'];
			if ($fee < 1) $fee = 1;
			$res = $this->sendRedPacket($openid, $fee);
			$status = $res['code'];
			if ($status == -2){
				$res['msg'] = "请简记主人重新进入简记页面";
				pdo_update($this->modulename."_member",array('authopenid'=>''),array('id'=>$mem['id']));
			}
		}
		if ($status != 1) $status = 0;
		pdo_update($this->modulename."_order",array('packet_status'=>$status,'packet_batch'=>$res['msg'],'packet_time'=>time()),array('id'=>$order['id']));
		return $res;
	}
	
	private function sendRedPacket($openid,$money,$cfg = ''){
		global $_W;
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
		load()->func('communication');
		$pars = array();
		if (empty($cfg)) $cfg = $this->module['config'];
		$pars['spbill_create_ip'] = trim($cfg['ip']);
		$pars['mch_appid'] = trim($cfg['appid']);
		$pars['mchid'] = trim($cfg['mchid']);
		$pars['nonce_str'] = random(32);
		$pars['partner_trade_no'] = random(28);
		$pars['openid'] = $openid;
		$pars['check_name'] = 'NO_CHECK';
		$pars['amount'] = $money * 100;
		$pars['desc'] = $cfg['paydesc']?$cfg['paydesc']:"{$cfg['UI']['title']}打赏";
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach($pars as $k => $v) {
			$string1 .= "{$k}={$v}&";
		}
		$string1 .= "key={$cfg['apikey']}";
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		$extras['CURLOPT_CAINFO'] = OD_ROOT .md5("root{$_W['uniacid']}ca").".pem";
		$extras['CURLOPT_SSLCERT'] = OD_ROOT .md5("apiclient_{$_W['uniacid']}cert").".pem";
		$extras['CURLOPT_SSLKEY'] = OD_ROOT .md5("apiclient_{$_W['uniacid']}key").".pem";
		file_put_contents(IA_ROOT.'/addons/junsion_simpledaily/log', json_encode($extras));
		$resp = ihttp_request($url, $xml, $extras);
		if(is_error($resp)) {
			return array('code'=>-1,'msg'=>$resp['message']);
		} else {
			$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
			$dom = new DOMDocument();
			if($dom->loadXML($xml)) {
				$xpath = new DOMXPath($dom);
				$send_listid = $xpath->evaluate('string(//xml/payment_no)');
				$code = $xpath->evaluate('string(//xml/return_code)');
				$ret = $xpath->evaluate('string(//xml/result_code)');
				if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
					return array('code'=>1,'msg'=>$send_listid);
				} else {
					$procResult = $xpath->evaluate('string(//xml/err_code_des)');
					$return = array('code'=>-1,'msg'=>$procResult);
					$code = $xpath->evaluate('string(//xml/err_code)');
					if (strtoupper($code) == 'OPENID_ERROR') $return['code'] = -2;
					return $return;
				}
			} else {
				return array('code'=>-1,'msg'=>'error response');
			}
		}
	}
	
	private function checkWechatTran($uniacid,$transid){
		$cfg = pdo_fetch('select settings from '.tablename('uni_account_modules')." where uniacid='{$uniacid}' and module='junsion_simpledaily'");
		$cfg = unserialize($cfg['settings']);
		$url = "https://api.mch.weixin.qq.com/pay/orderquery";
		$random = random(8);
		$post = array(
				'appid'=>$cfg['appid'],
				'transaction_id'=>$transid,
				'nonce_str'=>$random,
				'mch_id'=>$cfg['mchid'],
		);
		ksort($post);
		$string = $this->ToUrlParams($post);
		$string .= "&key={$cfg['apikey']}";
		$sign = md5($string);
		$post['sign'] = strtoupper($sign);
		$resp = $this->postXmlCurl($this->ToXml($post), $url);
		libxml_disable_entity_loader(true);
		$resp = json_decode(json_encode(simplexml_load_string($resp, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		if ($resp['result_code'] != 'SUCCESS' || $resp['return_code'] != 'SUCCESS') {
			exit('fail');
		}
		if ($resp['trade_state'] == 'SUCCESS') return array('code'=>1,'fee'=>$resp['total_fee']/100);
	}

	/**
	 * 统一下单
	 * @param unknown $setting
	 * @param unknown $transid
	 * @return multitype:number
	 */
	public function unifiedOrder($desc,$fee,$wid,$styleid = ''){
		global $_W;
		$system = $this->module['config'];
		$url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		$random = random(8);
		if ($styleid){
			$orderno = "S".$_W['uniacid'].strtoupper(random(8)).time();
		}else $orderno = "A".$_W['uniacid'].strtoupper(random(8)).time();
		$openid = $_W['openid'];
		if ($system['auth'] && $_SESSION['daily_auth_openid'.$_W['uniacid']]) $openid = $_SESSION['daily_auth_openid'.$_W['uniacid']];
		$trade_type = 'JSAPI';
		$notify_url = "{$_W['siteroot']}/addons/junsion_simpledaily/notify.php";
		$post = array(
				'appid'=>$system['appid'],
				'mch_id'=>$system['mchid'],
				'nonce_str'=>$random,
				'body'=>$desc,
				'out_trade_no'=>$orderno,
				'total_fee'=>$fee*100,
				'spbill_create_ip'=>$system['ip'],
				'notify_url'=>$notify_url,
				'trade_type'=>$trade_type,
				'openid'=>$openid,
				'attach'=>$_W['uniacid'],
				'limit_pay'=>'no_credit',
		);
		if(empty($openid)){
			return array('errcode'=>1,'errmsg'=>'请用微信端打开');
		}
		if ($system['credit']) unset($post['limit_pay']);
		ksort($post);
		$string = $this->ToUrlParams($post);
		$string .= "&key={$system['apikey']}";
		$sign = md5($string);
		$post['sign'] = strtoupper($sign);
		$xml = $this->ToXml($post);
		$resp = $this->postXmlCurl($xml, $url);
		libxml_disable_entity_loader(true);
		$resp = json_decode(json_encode(simplexml_load_string($resp, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		if ($resp['result_code'] != 'SUCCESS') {
			return array('errcode'=>1,'errmsg'=>json_encode($resp,JSON_UNESCAPED_UNICODE));
		}else{
			if ($styleid){
				$orderid = $this->addOrderStyle($orderno,$fee,$wid,$styleid);
			}else $orderid = $this->addOrder($orderno,$fee,$wid,$system);
			return array('errcode'=>0,'prepay_id'=>$resp['prepay_id'],'code_url'=>$resp['code_url'],'orderno'=>$orderno,'orderid'=>$orderid);
		}
	}
	
	private function addOrderStyle($orderno,$fee,$wid,$styleid){
		global $_W;
		$order = array(
				'weid'=>$_W['uniacid'],
				'openid'=>$_W['openid'],
				'styleid'=>$styleid,
				'ordersn'=>$orderno,
				'price'=>$fee,
				'createtime'=>time(),
		);
		pdo_insert($this->modulename."_buy",$order);
		return pdo_insertid();
	}
	
	private function addOrder($ordersn,$fee,$wid,$cfg){
		global $_W;
		if ($cfg['payrate'] > 0){
			$rate = $fee * ($cfg['payrate']/100);
			if ($fee - $rate < 1) $rate = 0;
		}
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
			load()->model('mc');
			$info = mc_oauth_userinfo();
		}
		$order = array(
				'weid'=>$_W['uniacid'],
				'openid'=>$_W['openid'],
				'avatar'=>$info['avatar'],
				'nickname'=>$info['nickname'],
				'wid'=>$wid,
				'ordersn'=>$ordersn,
				'price'=>$fee,
				'rate'=>$rate,
				'createtime'=>time()
		);
		pdo_insert($this->modulename."_order",$order);
		return pdo_insertid();
	}
	
	/**
	 * 支付js pai 参数
	 * @param unknown $prepay_id
	 * @return multitype:string NULL unknown
	 */
	private function getWxPayJsParams($prepay_id){
		global $_W;
		$system = $this->module['config'];
		$random = random(8);
		$post = array(
				'appId'=>$system['appid'],
				'timeStamp'=>time()."",
				'nonceStr'=>$random,
				'package'=>"prepay_id=".$prepay_id,
				'signType'=>'MD5',
		);
		ksort($post);
		$string = $this->ToUrlParams($post);
		$string .= "&key={$system['apikey']}";
		$sign = md5($string);
		$post['paySign'] = strtoupper($sign);
		return $post;
	}
	
	private function postXmlCurl($xml, $url, $useCert = false, $second = 30){
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
	
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);//严格校验
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
		if($useCert == true){
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
		}
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		}
	}
	
	private function ToUrlParams($post)
	{
		$buff = "";
		foreach ($post as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
	
		$buff = trim($buff, "&");
		return $buff;
	}
	
	private function ToXml($post)
	{
		$xml = "<xml>";
		foreach ($post as $key=>$val)
		{
			if (is_numeric($val)){
				$xml.="<".$key.">".$val."</".$key.">";
			}else{
				$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
			}
		}
		$xml.="</xml>";
		return $xml;
	}
	
	public function sub_day($staday)
	{
		$value = TIMESTAMP - $staday;
		if ($value < 0) {
			return '';
		} elseif ($value >= 0 && $value < 59) {
			return ($value + 1) . "秒";
		} elseif ($value >= 60 && $value < 3600) {
			$min = intval($value / 60);
			return $min . " 分钟";
		} elseif ($value >= 3600 && $value < 86400) {
			$h = intval($value / 3600);
			return $h . " 小时";
		} elseif ($value >= 86400 && $value < 86400 * 30) {
			$d = intval($value / 86400);
			return intval($d) . " 天";
		} elseif ($value >= 86400 * 30 && $value < 86400 * 30 * 12) {
			$mon = intval($value / (86400 * 30));
			return $mon . " 月";
		} else {
			$y = intval($value / (86400 * 30 * 12));
			return $y . " 年";
		}
	}
}
