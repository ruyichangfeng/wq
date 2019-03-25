<?php
/**
 * 初音科技企业社会化营销荐读模块模块微站定义
 *
 * @author ruoling
 * @url truein.cc
 */
defined('IN_IA') or exit('Access Denied');
require IA_ROOT . '/addons/truein_jiandu/model.func.php';
class Truein_jianduModuleSite extends WeModuleSite {
	public $_uniacid = '';
	public $_staff = '';
	public $_rid = '';
	public $table_medias = 'truein_jiandu_medies';
	public function __construct() {
		global $_W;
		global $_GPC;
		$this->_staff = $_W['fans']['openid'];
		$this->_uniacid = $_W['uniacid'];
	}
	
	//后台广告管理
    public function doWebAdvert(){
        global $_GPC, $_W;
        $rid = intval($_GPC['rid']);
        $operation = !empty($_GPC['op'])? $_GPC['op'] : 'display';
        if ($operation == 'display'){
            $category = pdo_fetchall("SELECT * FROM " . tablename('truein_jiandu_ad') . " WHERE weid = :weid order by id desc",array(':weid' => $_W['uniacid']));
        }elseif ($operation == 'post'){
            load() -> func('tpl');
            $id = intval($_GPC['id']);
            if (!empty($id)){
                $category = pdo_fetch("SELECT * FROM " . tablename('truein_jiandu_ad') . " WHERE id = :id",array(':id' => $id));
            }
            if (checksubmit('submit')){
                if (empty($_GPC['title']))message('抱歉，请输入广告名称！');
                $data = array('weid' => $_W['uniacid'], 'title' => $_GPC['title'], 'thumb' => $_GPC['thumb'], 'description' => $_GPC['description'], 'url' => $_GPC['url']);
                if (!empty($id)){
                    pdo_update('truein_jiandu_ad', $data, array('id' => $id));
                }else{
                    pdo_insert('truein_jiandu_ad', $data);
                }
                message('更新广告成功！', $this -> createWebUrl('advert', array('op' => 'display')), 'success');
            }
        }elseif ($operation == 'delete'){
            $id = intval($_GPC['id']);
            pdo_delete('truein_jiandu_ad', array('id' => $id));
            message('广告删除成功！', $this -> createWebUrl('advert', array('op' => 'display')), 'success');
        }
        include $this -> template('advert');
    }
	
	//后台文章管理
	public function doWebmedias() {
		global $_GPC;
		global $_W;
		load()->func('tpl');
		$uniacid = $_W['uniacid'];
		$action = 'medias';
		$title = $this->actions_titles[$action];
		$operation = ((!empty($_GPC['op']) ? $_GPC['op'] : 'display'));
		if ($operation == 'display') {
			
			$condition = '';
			if (!empty($_GPC['keyword'])) {
				$condition.= ' AND (title LIKE \'%' . $_GPC['keyword'] . '%\') ';
			}
			if (isset($_GPC['status']) && ($_GPC['status'] != '')) {
				$condition.= ' AND status=' . $_GPC['status'] . ' ';
			}
			
			$pindex = max(1, intval($_GPC['page']));
			$psize = 8;
			$start = ($pindex - 1) * $psize;
			$limit = '';
			$limit.= ' LIMIT ' . $start . ',' . $psize;
			$share = pdo_fetchall("SELECT * FROM " . tablename('truein_jiandu_share') . " WHERE uniacid = :uniacid order by id desc",array(':uniacid' => $uniacid));
			
			$mediaidarr = array();
			foreach($share as $key => $value){
				$mediaidarr[] = $value['mediaid'];
			}
			$mediaidstr = implode(',',$mediaidarr);
		
			if($mediaidstr){
				$list = pdo_fetchall('SELECT * FROM ' . tablename('truein_jiandu_medies') . 'where id in ('. $mediaidstr.') ' . 		$condition . ' ORDER BY id DESC ' . $limit );
				$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('truein_jiandu_medies') . 'where id in ('. $mediaidstr.') ORDER BY id DESC ' );
			}else{
				$list = array();
				$total = 0;
			}
			
			//用户数量
			$user_count = pdo_fetchall('SELECT mediaid,count(1) as count FROM ' . tablename('truein_jiandu_share') . '  GROUP BY mediaid');
			foreach($list as $key => $value){
				foreach($user_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['mediaid']){
						$list[$key]['usercount'] = $v['count'];
					}
				}
			}
			//分享数量
			$share_count = pdo_fetchall('SELECT mediaid,sum(sharecount) as sharecount FROM ' . tablename('truein_jiandu_share') . '  GROUP BY mediaid');
			foreach($list as $key => $value){
				foreach($share_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['mediaid']){
						$list[$key]['sharecount'] = $v['sharecount'];
					}
				}
			}
			//文章阅读量
			$read_count = pdo_fetchall('SELECT mediaid,sum(readcount) as readcount FROM ' . tablename('truein_jiandu_share') . '  GROUP BY mediaid');
			foreach($list as $key => $value){
				foreach($read_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['mediaid']){
						$list[$key]['readcount'] = $v['readcount'];
					}
				}
			}
			//广告点击量
			$click_count = pdo_fetchall('SELECT mediaid,sum(click) as clickcount FROM ' . tablename('truein_jiandu_share') . '  GROUP BY mediaid');
			foreach($list as $key => $value){
				foreach($click_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['mediaid']){
						$list[$key]['clickcount'] = $v['clickcount'];
					}
				}
			}

			$pager = pagination($total, $pindex, $psize);
		} else if ($operation == 'setstatus') {
			$id = intval($_GPC['id']);
			$status = intval($_GPC['status']);
			pdo_query('UPDATE' . tablename($this->table_medias) . ' SET status = abs(:status - 1) WHERE id=:id', array(':status' => $status, ':id' => $id));
			message('操作成功！', $this->createWebUrl('medias', array('op' => 'display')), 'success');
		}else if ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$artical = pdo_fetch('SELECT * FROM ' . tablename($this->table_medias) . ' WHERE id = :id', array(':id' => $id));  //文章
			if (empty($artical)) {
				message('抱歉，不存在或是已经被删除！', $this->createWebUrl('medias', array('op' => 'display')), 'error');
			}
			$shareid = pdo_fetchall('SELECT id FROM ' . tablename('truein_jiandu_share') . ' WHERE mediaid = :id and uniacid = :uniacid', array(':id' => $id,':uniacid' => $uniacid));
			$idarr = array();
			foreach($shareid as $key => $value){
				$idarr[$key] = $value['id'];
			}
			$idstr = implode(',',$idarr);
			
			if($idstr){
				$logs = pdo_fetchall('SELECT * FROM ' . tablename('truein_jiandu_logs') . 'where share_id in ('. $idstr.') ORDER BY id DESC ' );   //日志
			}
			//删除日志
			if(!empty($logs)){
				$sql = 'delete from ' . tablename('truein_jiandu_logs') . ' where share_id in ('. $idstr.')';
				pdo_query($sql);
			}
			//删除分享记录
			if(!empty($shareid)){
				pdo_delete('truein_jiandu_share', array('mediaid' => $id, 'uniacid' => $uniacid));
			}
			//删除文章
			pdo_delete($this->table_medias, array('id' => $id));
			
			message('删除成功！', $this->createWebUrl('medias', array('op' => 'display')), 'success'); 
		}
		include $this->template('medias');
	}
	
	//后台员工管理
	public function doWebstaffs() {
		global $_GPC;
		global $_W;
		load()->func('tpl');
		$uniacid = $_W['uniacid'];
		$action = 'staffs';
		$title = $this->actions_titles[$action];
		$operation = ((!empty($_GPC['op']) ? $_GPC['op'] : 'display'));
		if ($operation == 'display') {
			
			$condition = '';
			if (!empty($_GPC['keyword'])) {
				$condition.= ' AND (nickname LIKE \'%' . $_GPC['keyword'] . '%\' OR id=\'' . $_GPC['keyword'] . '\') ';
			}
			if (isset($_GPC['status']) && ($_GPC['status'] != '')) {
				$condition.= ' AND status=' . $_GPC['status'] . ' ';
			}
			
			$pindex = max(1, intval($_GPC['page']));
			$psize = 8;
			$start = ($pindex - 1) * $psize;
			$limit = '';
			$limit.= ' LIMIT ' . $start . ',' . $psize;
			$share = pdo_fetchall("SELECT * FROM " . tablename('truein_jiandu_share') . " WHERE uniacid = :uniacid order by id desc",array(':uniacid' => $uniacid));
		
			$list = pdo_fetchall('SELECT * FROM ' . tablename('truein_jiandu_staff') . " WHERE uniacid = :uniacid " . $condition . " order by id desc". $limit,array(':uniacid' => $uniacid));
			
			$artical_count = pdo_fetchall('SELECT staffid,count(mediaid) as articalcount FROM' . tablename('truein_jiandu_share') . '  GROUP BY staffid');
			foreach($list as $key => $value){
				foreach($artical_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['staffid']){
						$list[$key]['articalcount'] = $v['articalcount'];
					}
				}
			}
			//阅读量
			$read_count = pdo_fetchall('SELECT staffid,sum(readcount) as readcount FROM ' . tablename('truein_jiandu_share') . '  GROUP BY staffid');
			foreach($list as $key => $value){
				foreach($read_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['staffid']){
						$list[$key]['readcount'] = $v['readcount'];
					}
				}
			}
			//分享数量
			$share_count = pdo_fetchall('SELECT staffid,sum(sharecount) as sharecount FROM ' . tablename('truein_jiandu_share') . '  GROUP BY staffid');
			foreach($list as $key => $value){
				foreach($share_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['staffid']){
						$list[$key]['sharecount'] = $v['sharecount'];
					}
				}
			}
			//广告点击量
			$click_count = pdo_fetchall('SELECT staffid,sum(click) as clickcount FROM ' . tablename('truein_jiandu_share') . '  GROUP BY staffid');
			foreach($list as $key => $value){
				foreach($click_count as $k => $v){
					//$listidarr[] = $value['id'];
					if($value['id'] == $v['staffid']){
						$list[$key]['clickcount'] = $v['clickcount'];
					}
				}
			}
			
			$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename('truein_jiandu_staff') . " WHERE uniacid = :uniacid " . $condition . " order by id desc",array(':uniacid' => $uniacid));
			

			$pager = pagination($total, $pindex, $psize);
		} else if ($operation == 'setstatus') {
			$id = intval($_GPC['id']);
			$status = intval($_GPC['status']);
			pdo_query('UPDATE' . tablename('truein_jiandu_staff') . ' SET status = abs(:status - 1) WHERE id=:id', array(':status' => $status, ':id' => $id));
			message('操作成功！', $this->createWebUrl('staffs', array('op' => 'display')), 'success');
		}
		include $this->template('staffs');
	}
	
	//员工入口
	public function doMobileIndex() {
		global $_GPC, $_W;
		$this->_rid = $rid = $_GPC['rid'];
		$uniacid = $this->_uniacid;
	
		$replyid = pdo_fetch("SELECT id FROM " . tablename('truein_jiandu_reply') . " WHERE rid = :rid and uid = :uid", array(':rid' => $rid ,':uid' => $uniacid));
		if(empty($replyid)){
			message('参数错误！', '', 'warning');
		}	
		if (empty($_W['fans']['openid'])) {
			mc_oauth_userinfo();				
		}
		if(!isset($_COOKIE['openid'])){
			setcookie('openid', $_W['fans']['openid'], time() + (3600 * 10));
		}
		$data['openid'] = $_W['fans']['openid'];
		
		$staffid = 0;
		if($data['openid']){
			$staff = pdo_fetch("SELECT * FROM " . tablename('truein_jiandu_staff') . " WHERE openid = :openid", array(':openid' => $data['openid']));
			if(empty($staff)){
				//员工信息入库
				//$index_link = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=index&m=truein_jiandu&rid=' . $rid . '';
				//$userInfo = $this->doMobileOauth($index_link);
				$userInfo = $this->fansInfo($data['openid']);
				//print_r($userInfo['openid']);exit();
				$data['uniacid'] = $_W['fans']['uniacid'];
				$data['openid'] = $_W['fans']['openid'];
				$data['nickname'] = (!empty($_W['fans']['nickname']) ? $_W['fans']['nickname'] : $userInfo['nickname']);
				$data['headimgurl'] = (!empty($_W['fans']['avatar']) ? $_W['fans']['avatar'] : $userInfo['headimgurl']);
				$data['sex'] = (!empty($_W['fans']['tag']['sex']) ? $_W['fans']['tag']['sex'] : $userInfo['sex']);
				$data['country'] = (!empty($_W['fans']['tag']['country']) ? $_W['fans']['tag']['country'] : $userInfo['country']);
				$data['province'] = (!empty($_W['fans']['tag']['province']) ? $_W['fans']['tag']['province'] : $userInfo['province']);
				$data['city'] = (!empty($_W['fans']['tag']['city']) ? $_W['fans']['tag']['city'] : $userInfo['city']);
				$data['datetime'] = TIMESTAMP;	
				$res = pdo_insert("truein_jiandu_staff", $data);
				if(!empty($res)){
					$staffid = pdo_insertid();					
				}
			}elseif($staff['status'] == 0){
				message('您的账号已禁用！', '', 'warning');
			}else{
				$staffid = $staff['id'];
			}
		}else{
			message('请关注公众号：'.$_W['account']['name'].' 使用本功能！',  '', 'warning');
		}
		
		$mcount = pdo_fetch("SELECT COUNT(id) as mcount FROM " . tablename('truein_jiandu_share') . " WHERE staffid = :staffid and uniacid = :uniacid and rid = :rid ", array(':staffid' => $staffid, ':uniacid' => $uniacid, ':rid' => $rid ));
		$shareinfo = pdo_fetch("SELECT SUM(sharecount) AS scount,SUM(readcount) AS rcount,SUM(click) AS acount FROM " . tablename('truein_jiandu_share') . " WHERE staffid = :staffid and uniacid = :uniacid and rid = :rid ", array(':staffid' => $staffid, ':uniacid' => $uniacid, ':rid' => $rid ));	
		$nickname = $_W['fans']['nickname'];
		include $this -> template('index');

	}
	
	//提交贴广告
	public function doMobileSubmit() {		
		global $_W;
		global $_GPC;
		$uniacid = $this->_uniacid;
		$openid = $this->_staff;
		$rid = trim($_GPC["rid"]);
		if (empty($openid) || empty($rid)) {
			message('参数错误!',  '', 'warning');
		}
		
		$url = trim($_GPC['url']);
		if (empty($url)) {
			message('请输入文章网址!', $this->createMobileUrl('index', array('rid' => $rid)), 'warning');
		}
		if (!truein_getUrlfrom(trim($url))) {
			message('网址不正确!', $this->createMobileUrl('index', array('rid' => $rid)), 'warning');
		}
		$staffinfo = pdo_fetch('SELECT * FROM ' . tablename("truein_jiandu_staff") . ' WHERE openid=:openid AND uniacid=:uniacid LIMIT 1', array(':openid' => $openid, ':uniacid' => $uniacid));
		//print_r($openid);exit();
		if (empty($staffinfo)) {
			message('需要识别您的身份!',  $this->createMobileUrl('index', array('rid' => $rid)), 'warning');
		}
		if ($staffinfo['status'] == 0) {
			message('您的帐号已经被冻结了!', '', 'warning');
		}
		$res = truein_pushWXmedia($url,$rid);
		if (!$res['status']) {
			message('取不到文章的信息!', $this->createMobileUrl('index', array('rid' => $rid)), 'warning');
		}
		//广告信息
		$reply = pdo_fetch('SELECT * FROM ' . tablename("truein_jiandu_reply") . ' WHERE uid=:uniacid AND rid=:rid LIMIT 1', array(':uniacid' => $uniacid, ':rid' => $rid));
		
		if (empty($reply)) {
			message('活动不存在!'.$rid, $this->createMobileUrl('index', array('rid' => $rid)), 'warning');
		}
		$jdinfo = pdo_fetch('SELECT * FROM ' . tablename("truein_jiandu_share") . ' WHERE staffid=:staffid AND rid=:rid AND mediaid=:mediaid AND adid=:adid LIMIT 1', array(':staffid' => $staffinfo['id'], ':rid' => $rid, ':mediaid' => $res['status'], ':adid' => $reply['aid']));
		if (!empty($jdinfo)) {
			//已经制作过本篇文章
			message('贴广告成功', $this->createMobileUrl('shareinfo', array('sid' => $jdinfo['id'])), 'success');
		}

		$insert = array('uniacid' => $uniacid, 'staffid' => $staffinfo['id'], 'rid' => $rid, 'mediaid' => $res['status'], 'adid' => $reply['aid'], 'datetime' => TIMESTAMP);
		$res = pdo_insert('truein_jiandu_share', $insert);
		
		if (!empty($res)) {
			$sid = pdo_insertid();
			pdo_query("UPDATE ".tablename('truein_jiandu_ad')." SET share_num = share_num + 1 WHERE id = :id", array(':id' => $reply['aid']));
			message('贴广告成功', $this->createMobileUrl('shareinfo', array('sid' => $sid)), 'success');
			return null;
		}
		message('取不到文章的信息', $this->createMobileUrl('index', array('rid' => $rid)), 'warning');
	}
	
	//展现贴广告后文章
	public function doMobileShareinfo(){
		global $_W;
		global $_GPC;
		if (empty($_W['fans']['openid'])) {
			mc_oauth_userinfo();
		}
		if(!isset($_COOKIE['openid'])){
			setcookie('openid', $_W['fans']['openid'], time() + (3600 * 10));
		}
		$sid = $data['sid'] = $_GPC['sid'];
		$data['openid'] = $_W['fans']['openid'];
		$data['ip'] = $_W['clientip'];
		$data['os'] = $_W['os'];
		$data['container'] = $_W['container'];
		$accinfo['nickname'] = $_W['fans']['nickname'];
		$accinfo['accountname'] = $_W['account']['name'];

		//记录访问情况
		truein_logs($data);
		//贴广告
		$adurl = $_W['siteroot'] . 'app/' . $this->createMobileUrl('adclick', array('sid' => $sid), true);
		$res = truein_getContent1($sid,$adurl,$accinfo);
		if(!$res['status']){
			message($info['msg'], $this->createMobileUrl('index', array()));
			return null;
		}
		$share_url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('shareinfo', array('sid' => $sid), true);
		$share_desc = $res['msg']['share_desc'];
		$share_image = $res['msg']['share_image'];
		$title = $res['msg']['title'];
		$content = $res['msg']['content'];
		include $this -> template('shareinfo');
	}
	
	//分享回调
	public function doMobileShareact(){
		global $_W;
		global $_GPC;
		$sid = $_GPC['sid'];
		if($sid && $_COOKIE['openid']){
			//更新share表
			pdo_query("UPDATE ".tablename('truein_jiandu_share')." SET sharecount = sharecount + 1 WHERE id = :sid", array(':sid' => $sid));
			//增加分享记录
			$insert = array('share_id' => $sid,'from_openid' => $_COOKIE['openid'], 'from_ip' => $_W['clientip'], 'from_os' => $_W['os'],'from_container' => $_W['container'], 'share' =>1, 'datetime' => TIMESTAMP);
			pdo_insert("truein_jiandu_logs", $insert);
			
		}
		$url = $this->createMobileUrl('shareinfo', array('sid' => $sid), true);
		header('location:' . $url);
	}
	
	//广告点击统计
	public function doMobileAdclick(){
		global $_W;
		global $_GPC;
		$sid = $_GPC['sid'];
		
		$shares = pdo_fetch("SELECT * FROM " . tablename('truein_jiandu_share'). " WHERE id = :sid", array(':sid' => $sid));		
		$ads = pdo_fetch('SELECT * FROM ' . tablename("truein_jiandu_ad") . ' WHERE id=:id LIMIT 1', array(':id' => $shares['adid']));
		if(empty($ads) || !$ads['url']){
			$url = $this->createMobileUrl('shareinfo', array('sid' => $sid), true);
			header('location:' . $url);
		}		
		//更新share表
		$logsdate = pdo_fetchcolumn('SELECT datetime FROM ' . tablename("truein_jiandu_logs") . ' WHERE share_id=:sid AND from_openid=:openid AND `click`=1 order by datetime desc LIMIT 1', array(':sid' => $sid,':openid' => $_COOKIE['openid']));
		
		if(($logsdate + 60*60*24 < TIMESTAMP) || !$logsdate){
			pdo_query("UPDATE ".tablename('truein_jiandu_share')." SET click = click + 1 WHERE id = :sid", array(':sid' => $sid));
			//增加点击记录
			$insert = array('share_id' => $sid, 'from_openid' => $_COOKIE['openid'],  'from_ip' => $_W['clientip'], 'from_os' => $_W['os'],'from_container' => $_W['container'], 'click' =>1, 'datetime' => TIMESTAMP);
			pdo_insert("truein_jiandu_logs", $insert);			
		}
		header('location:' . $ads['url']);
	}

	
	//员工奖励政策
	public function doMobileGift(){
		global $_W;
		global $_GPC;
		$rid = trim($_GPC["rid"]);
		if (empty($rid)) {
			message('参数错误!',  '', 'warning');
		}
		$gift = pdo_fetchcolumn('SELECT gift FROM ' . tablename("truein_jiandu_reply") . ' WHERE rid=:rid LIMIT 1', array(':rid' => $rid));
		$shares = truein_defaultShare();
		include $this -> template('gift');
	}	
	
	//分享文章列表
	public function doMobileList(){
		global $_W;
		global $_GPC;
		$rid = trim($_GPC["rid"]);
		if (empty($rid)) {
			message('参数错误!',  '', 'warning');
		}
		if (empty($_W['fans']['openid'])) {
			mc_oauth_userinfo();				
		}
		
		$staff = pdo_fetch("SELECT * FROM " . tablename('truein_jiandu_staff') . " WHERE openid = :openid", array(':openid' => $_W['fans']['openid']));
		if(empty($staff)){
			message('需要识别您的身份！',  $this->createMobileUrl('index', array('rid' => $rid)), 'warning');
		}
		if($staff['status'] == 0){
			message('您的账号已禁用！', '', 'warning');
		}
		
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$start = ($pindex - 1) * $psize;		
		$limit = '';
		$limit.= ' LIMIT ' . $start . ',' . $psize;
		$counts = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('truein_jiandu_share'). " WHERE  rid = :rid AND staffid = :staffid", array(':rid' => $rid,':staffid' => $staff['id']));
		$topage = intval($counts/$psize);
		$prpage = max(1, $pindex-1);
		$nepage = min($topage, $pindex+1);
		$shares = pdo_fetchall("SELECT * FROM " . tablename('truein_jiandu_share'). " WHERE  rid = :rid AND staffid = :staffid order by id desc". $limit, array(':rid' => $rid,':staffid' => $staff['id']));
		
		$pager = pagination($counts, $pindex, $psize);

		$list = array();
		if(!empty($shares)){			
			foreach($shares as $k => $v){
				$mids = pdo_fetch ("SELECT title,status FROM " . tablename('truein_jiandu_medies'). " WHERE  id = :mediaid ", array(':mediaid' => $v['mediaid']));
				if($mids['title']){
					$list[$k]['title'] = $mids['title'];
					$list[$k]['sid'] = $v['id'];
					$list[$k]['sharecount'] = $v['sharecount'];
					$list[$k]['readcount'] = $v['readcount'];
					$list[$k]['click'] = $v['click'];
					$list[$k]['status'] = $v['status'];
				}
			}
		}
		$shares = truein_defaultShare();
		include $this -> template('list');
	}
	
	//使用帮助
	public function doMobileHelp(){
		global $_W;
		global $_GPC;
		$rid = trim($_GPC["rid"]);
		if (empty($rid)) {
			message('参数错误!',  '', 'warning');
		}
		$help = pdo_fetchcolumn('SELECT help FROM ' . tablename("truein_jiandu_reply") . ' WHERE rid=:rid LIMIT 1', array(':rid' => $rid));
		$shares = truein_defaultShare();
		include $this -> template('help');
	}
	
	//获取用户基本信息
	private function fansInfo($openid){
		global $_W;
		$acc = WeAccount::create($_W['account']['acid']);
		$data = $acc->fansQueryInfo($openid);
		return $data;
	}
	
	//获取用户详细信息
	/* private function doMobileOauth($redirect_url){
		global $_W, $_GPC;
		load()->func('communication');
		$appid = trim($_W['account']['key']);
		$secret = trim($_W['account']['secret']);
		
		//1.准备scope为snsapi_userInfo网页授权页面
		$redirecturl = urlencode($redirect_url);
		$snsapi_userInfo_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirecturl.'&response_type=code&scope=snsapi_userinfo&state=truein#wechat_redirect';
		
		//2.用户手动同意授权,同意之后,获取code
		//页面跳转至redirect_uri/?code=CODE&state=STATE
		$code = $_GPC['code'];
		if( !isset($code) ){
			header('Location:'.$snsapi_userInfo_url);
		}
		
		//3.通过code换取网页授权access_token
		$curl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
		$content = ihttp_get($curl);
		if (!is_error($content)){
			$result = @json_decode($content['content']);
			if (!empty($result->openid) && !empty($result->access_token)) {
			
				//4.通过access_token和openid拉取用户信息
				$webAccess_token = $result->access_token;
				$openid = $result->openid;
				$userInfourl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$webAccess_token.'&openid='.$openid.'&lang=zh_CN ';
				
				$recontent = ihttp_get($userInfourl);
				$userInfo = @json_decode($recontent['content'], true);
			
				return $userInfo;
			}else {
				die('微信授权失败');
			}
		}else {
			die('微信授权失败');
		}
	} */
}