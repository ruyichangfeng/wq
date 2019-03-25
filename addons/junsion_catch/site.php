<?php
/**
 * 节日抓抓抓模块微站定义
 *
 * @author junsion
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Junsion_catchModuleSite extends WeModuleSite {

	public function doWebManage() {
		global $_W,$_GPC;
		$op = $_GPC['op'];
		if (empty($op)) $op = 'list';
		$rid = $_GPC['rid'];
		if ($op == 'list'){
			$list = pdo_fetchall('select m.*,r.name from '.tablename($this->modulename.'_rule')." m left join "
						.tablename('rule')." r on r.id=m.rid "." where m.weid='{$_W['weid']}' order by rid desc");
			//参与人数
			foreach ($list as $key => $value) {
				$list[$key]['attend'] = pdo_fetchcolumn('select count(id) from '.tablename($this->modulename."_player")." where rid='{$value['rid']}'");
				$count = pdo_fetchcolumn('select count(id) from '.tablename($this->modulename."_player")." where rid='{$value['rid']}'");
				$list[$key]['award'] = $count;
			}
		}else if ($op == 'player'){
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			//FIXME 奖品信息  
			$prize = pdo_fetchall('select * from '.tablename($this->modulename."_prize")." where rid='{$rid}' order by id ");
			$ptotal = 0;
			$plist = array();
			foreach ($prize as $key => $value) {
				for ($i = 0; $i < $value['prizetotal']; $i++) {
					$plist[count($plist)] = $value['prizename'];
				}
				$ptotal += $value['prizetotal'];
			}
			$rule = pdo_fetch('select * from '.tablename($this->modulename.'_rule')." where rid='{$rid}'");
			$list = pdo_fetchall('select *,(select count(id) from '.tablename($this->modulename."_share").' where pid=p.id) bnum from '.tablename($this->modulename.'_player')." p where p.rid='{$rid}' order by p.score desc,p.createtime  LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_player') . " where rid='{$rid}'");
			$pager = pagination($total, $pindex, $psize);
		}else if ($op == 'friend'){
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$list = pdo_fetchall("select * from ".tablename($this->modulename."_share")." where pid={$_GPC['pid']}  LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_share') . " where pid={$_GPC['pid']}");
			$pager = pagination($total, $pindex, $psize);
		}else if ($op == 'take'){
			if (pdo_update($this->modulename."_player",array('status'=>1,'lasttime'=>time()),array('id'=>$_GPC['pid'])) === false){
				message('发奖失败！');
			}else{
				@unlink("../attachment/images/junsion_catch_qrocde_{$rid}_{$_GPC['pid']}.png");
				message('发奖成功！',$this->createWebUrl('manage',array('op'=>'player','rid'=>$rid)));
			}
		}
		include $this->template('manage');
	}
	
	public function doMobileIndex(){
		global $_W,$_GPC;
		$pid = $_GPC['pid'];
		$openid = $this->getOpenid();
		load()->model('mc');
		$fans = mc_fansinfo($openid, $_W['acid'], $_W['uniacid']);
		$follow = $fans['follow'];
		$cfg = $this->module['config'];
		$rid = $_GPC['rid'];
		$rule = pdo_fetch('select * from '.tablename($this->modulename."_rule")." where rid='{$rid}'");
		$slide = pdo_fetchall('select * from '.tablename($this->modulename."_slider")." where rid='{$rid}'");
		
		//FIXME 奖品列表
		$prize = pdo_fetchall('select * from '.tablename($this->modulename."_prize")." where rid='{$rid}' order by id");
		$rank = pdo_fetchall('select * from '.tablename($this->modulename."_player")." where rid='{$rid}' order by score desc limit 0,".intval($rule['rank']));
		
		$player = $this->getPlayer($rid);
		
		if ($rule['endtime'] <= time()){//活动结束
			//获取当前粉丝排名和奖品
			$plist = array();
			foreach ($prize as $key => $value) {
				for ($i = 0; $i < $value['prizetotal']; $i++) {
					$plist[count($plist)+1] = $value;
				}
				$ptotal += $value['prizetotal'];
			}
			$curRank = 0;//当前排名
			$rank2 = pdo_fetchall('select * from '.tablename($this->modulename."_player")." where rid='{$rid}' order by score desc ");
			foreach ($rank2 as $key=>$value) {
				if ($value['id'] == $player['id']){
					$curRank = $key + 1;
					break;
				}
			}
			$award = '';
			if ($curRank <= $ptotal){//排名在奖品数量以内 则有奖
				$award = array('prize'=>$plist[$curRank],'qrcode'=>$this->Qrcode($rid,$player['id']),'rank'=>$curRank);				
			}
		}else{
			if (!empty($pid) && $pid != $player['id']){
				$share = pdo_fetch('select id from '.tablename($this->modulename."_share")." where pid = '{$pid}' and openid='{$openid}' ");
				if (empty($share)){
					$count = $rule['love_limit'];
					$limit = explode(',',$rule['love_limit']);
					if (count($limit) == 2){
						$count = intval(mt_rand($limit[0],$limit[1]));
					}
					pdo_insert($this->modulename."_share",array('weid'=>$_W['uniacid'],'rid'=>$rid,'openid'=>$openid,'avatar'=>$player['avatar'],'nickname'=>$player['nickname'],'pid'=>$pid,'blessing_num'=>$count,'createtime'=>time()));
					pdo_query('update '.tablename($this->modulename."_player")." set times=times+{$count} where id='{$pid}'");
				}
			}
			
			$down = 0;
			$rate = $rule['more_times'] / ($rule['more_time'] * 60); //每秒增加的次数
			$time = time()-$player['lasttime']; //最后一次增长时间至今的时间
			//时间倒数设置
			if (empty($rule['more_type'])){//一开始就增长
				$count = intval($time * $rate);
				$down = date('i:s',$rule['more_time'] * 60 - ( $time - $count / $rate ));
			}elseif ($rule['more_type'] && $rule['more_num'] >= $player['times']){
				$count = intval($time * $rate);
				if ($player['times'] + $count > $rule['more_num']) $count = $rule['more_num'] - $player['times']; //若剩余的加上增长的大于等于最低限制时 增长只能为两者之差
				if ($rule['more_num'] > $player['times'] + $count || $count == 0)
					$down = date('i:s',$rule['more_time'] * 60 - ( $time - $count / $rate ));
			}
			if ($count > 0){
				$now = time();
				pdo_query('update '.tablename($this->modulename."_player")." set times=times+{$count},lasttime={$now} where id='{$player['id']}'");
				$player['times'] += $count;
			}
			$mc = mc_fetch($openid);
		}
		$objs = array();
		$objs[] = array(
			'fname'=>$rule['fname'],
			'frame'=>$rule['frame'],
			'frameW'=>$rule['frameW'],
			'frameH'=>$rule['frameH'],
			'fspeed1'=>$rule['fspeed1'],
			'fspeed2'=>$rule['fspeed2'],
			'ftotal'=>$rule['ftotal'],
			'score'=>$rule['score'],
			'fthumb'=>$rule['fthumb'],
			'fthumb2'=>$rule['fthumb2'],
		);
		$os = unserialize($rule['morebirds']);
		foreach ($os as $value) {
			$objs[] = array(
				'fname'=>$value['fname'],
				'frame'=>$value['frame'],
				'fspeed1'=>$value['fspeed1'],
				'fspeed2'=>$value['fspeed2'],
				'ftotal'=>$value['ftotal'],
				'score'=>$value['score'],
				'fthumb'=>$value['fthumb'],
				'fthumb2'=>$value['fthumb2'],
				'frameW'=>$value['frameW'],
				'frameH'=>$value['frameH'],
			);
		}
		include $this->template('index');
	}
	
	public function doMobileScore(){
		global $_W,$_GPC;
		$rid = $_GPC['rid'];
		$rule = pdo_fetch('select * from '.tablename($this->modulename."_rule")." where rid='{$rid}'");
		$score = intval($_GPC['score']);
		$player = $this->getPlayer($rid);
		if (!empty($player)){
			//若是增长模式为低于多少次数时开始增长时，最后一次时间则为低于那次数 之前 即 若不低于那次数 每次都更新时间
			$sql = '';
			if ($rule['more_type'] && $rule['more_num'] > $player['times']) $sql = ',lasttime='.time();
			pdo_query('update '.tablename($this->modulename.'_player')." set times=times-1,score=score+{$score} {$sql} where id='{$player['id']}'");
		}
	}
	
	public function doMobileInfo(){
		global $_W,$_GPC;
		$pid = $_GPC['pid'];
		$player = pdo_fetch('select * from '.tablename($this->modulename."_player")." where id='{$pid}'");
		$isinfo = pdo_fetchcolumn('select isinfo from '.tablename($this->modulename."_rule")." where rid='{$player['rid']}'");
		if(!empty($_GPC['mobile']) && !preg_match("/^1[34578]\d{9}$/", $_GPC['mobile'])) die('请填写正确的手机号码');
		if(!empty($_GPC['email']) && !preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/", $_GPC['email'])) die('请填写正确的邮箱');
		$data = array(
				'realname'=>$_GPC['realname'],
				'mobile'=>$_GPC['mobile'],
				'qq'=>$_GPC['qq'],
				'email'=>$_GPC['email'],
				'address'=>$_GPC['address'],
		);
		if (pdo_update($this->modulename.'_player',$data,array('id'=>$player['id'])) === false){
			die('保存个人信息失败！');
		}
		if ($isinfo){//更新信息到系统会员表
			load()->model('mc');
			$mc = array();
			if (!empty($data['realname'])) $mc['realname'] = $data['realname'];
			if (!empty($data['mobile'])) $mc['mobile'] = $data['mobile'];
			if (!empty($data['qq'])) $mc['qq'] = $data['qq'];
			if (!empty($data['email'])) $mc['email'] = $data['email'];
			if (!empty($data['address'])) $mc['address'] = $data['address'];
			mc_update($player['openid'],$mc);
		}
		die('1');
	}
	
	public function doWebCheat(){
		global $_W,$_GPC;
		if (pdo_update($this->modulename."_player",array('times'=>$_GPC['times'],'score'=>$_GPC['score']),array('id'=>$_GPC['pid'])) === false){
			die('0');
		}else die('1');
	}
	
	public function doMobileTimes(){
		global $_W,$_GPC;
		$pid = $_GPC['pid'];
		$now = time();
		pdo_query('update '.tablename($this->modulename.'_player')." set times=times+1,lasttime={$now} where id='{$pid}'");
	}
	
	public function doMobileQrcode(){
		global $_W,$_GPC;
		$pid = $_GPC['pid'];
		$rid = $_GPC['rid'];
		$player = pdo_fetch('select * from '.tablename($this->modulename.'_player')." where rid='{$rid}' and id='{$pid}'");
		if (empty($player)){
			message('不存在该粉丝玩家！');
			exit;
		}
		if ($player['status']){
			message('该粉丝玩家已领奖，领奖时间:'.date('Y-m-d H:i:s',$player['lasttime']));
			exit;
		}
		//获取当前粉丝排名和奖品
		$prize = pdo_fetchall('select * from '.tablename($this->modulename."_prize")." where rid='{$rid}' order by id ");
		$plist = array();
		foreach ($prize as $key => $value) {
			for ($i = 0; $i < $value['prizetotal']; $i++) {
				$plist[count($plist)+1] = $value;
			}
			$ptotal += $value['prizetotal'];
		}
		$curRank = 0;//当前排名
		$rank = pdo_fetchall('select * from '.tablename($this->modulename."_player")." where rid='{$rid}' order by score desc");
		foreach ($rank as $key=>$value) {
			if ($value['id'] == $player['id']){
				$curRank = $key + 1;
				break;
			}
		}
		$award = $plist[$curRank];
		include $this->template('award');
	}
	
	public function doMobileAward(){
		global $_W,$_GPC;
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($userAgent, 'MicroMessenger')) {
			message('请使用微信浏览器打开！');
		}
		$pid = $_GPC['pid'];
		$rid = $_GPC['rid'];
		if (pdo_update($this->modulename."_player",array('status'=>1,'lasttime'=>time()),array('id'=>$pid)) === false){
			die('0');
		}else{
			@unlink("../attachment/images/junsion_catch_qrocde_{$rid}_{$pid}.png");
			die('1');
		}
	}
	
	public function doMobileMap(){
		global $_W,$_GPC;
		$store = $this->module['config'];
		include $this->template('map');
	}
	
	private function getPlayer($rid){
		global $_W,$_GPC;
		$openid = $this->getOpenid();
		$player = pdo_fetch('select * from '.tablename($this->modulename.'_player')." where rid='{$rid}' and openid='{$openid}'");
		if (empty($player)){
			return $this->createPlayer($rid);
		}else return $player;
	}
	
	private function createPlayer($rid){
		global $_W,$_GPC;
		$openid = $this->getOpenid();
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (strpos($userAgent, 'MicroMessenger')) {
			load()->model('mc');
			$info = mc_oauth_userinfo();
		}
		
		$data = array(
				'weid'=>$_W['uniacid'],
				'rid'=>$rid,
				'openid'=>$openid,
				'avatar'=>$info['avatar'],
				'nickname'=>$info['nickname'],
				'status'=>0,
				'createtime'=>time(),
				'lasttime'=>time(),
				'score'=>0,
				'times'=>pdo_fetchcolumn('select free_times from '.tablename($this->modulename.'_rule')." where rid='{$rid}'"),
		);
		pdo_insert($this->modulename.'_player',$data);
		return pdo_fetch('select * from '.tablename($this->modulename.'_player')." where rid='{$rid}' and openid='{$openid}'");
	}
	
	private function getOpenid(){
		global $_W;
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if (!strpos($userAgent, 'MicroMessenger')) {
			//TODO
		//	message('请使用微信浏览器打开！');
 			return $openid = 'junsion';
		}
		load()->model('mc');
		$info = mc_oauth_userinfo();
		return $info['openid'];
	}
	
	private function Qrcode($rid,$pid){
		/*生成二维码*/
		global $_W, $_GPC;
		include "phpqrcode.php";/*引入PHP QR库文件*/
		$path = '../attachment/images/';
		if(! is_dir($path)){
			mkdir($path);
			@chmod($path,777);
		}
		$imgurl = $path."junsion_catch_qrocde_{$rid}_{$pid}.png";
		if (file_exists($imgurl)) return $imgurl;
		$url = $_W['siteroot'].$this->createMobileUrl('qrcode', array('pid'=>$pid,'rid'=>$rid));
		$errorCorrectionLevel = "L";
		$matrixPointSize = "0";
		QRcode::png($url, $imgurl, $errorCorrectionLevel, $matrixPointSize);
		return $imgurl;
	}

}