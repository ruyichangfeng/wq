<?php
/**
 * 朋友圈广告营销模块微站定义
 *
 * @author 指尖互联科技
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Zjhl_ad_marketingModuleSite extends WeModuleSite {

	public function doWebIndex() {
		global $_GPC,$_W;
		$title = "首页-".$this->modulename;

		$count_article = pdo_fetch("SELECT COUNT(*) AS `total` , SUM(`read`) as `read` FROM ".tablename('zjhl_ad_marketing_article')." WHERE publish_time BETWEEN ".mktime(0,0,0)." AND ".mktime(23,59,59));

		//这个操作被定义用来呈现 管理中心导航菜单
		include $this->template('index');
	}
	public function doWebUser()
	{
		global $_GPC,$_W;
		require "common/web_func.php";
		$psize = 10;
		$act = $_GPC['act'];
		$dos = array('display','edit','change','delete','search');
		$act = in_array($act, $dos) ? $act : 'display';
		load()->model('mc');
		if($act == 'display') {
			$_W['page']['title'] = '会员列表 - 会员 - 会员中心';
			$pindex = max(1, intval($_GPC['page']));

			$page_start = ($pindex-1)*$psize;
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename("zjhl_ad_marketing_user")." as ad LEFT JOIN ".tablename("mc_members")." as m on ad.uid = m.uid ");
			// $users = pdo_getslice("zjhl_ad_marketing_user",array(),array($page_start,$psize),$total);
			$users = pdo_fetchall("SELECT * FROM ".tablename("zjhl_ad_marketing_user")." as ad LEFT JOIN ".tablename("mc_members")." as m on ad.uid = m.uid LIMIT $page_start,$psize");

			$pager = pagination($total, $pindex, $psize);
		}elseif ($act == 'edit') {
			# code...
		}elseif ($act == 'change') {
			$time = $_GPC['time'];
			$uid = $_GPC['uid'];

			switch ($time) {
				case '1':
					$res = pdo_update('zjhl_ad_marketing_user',array('level'=>1,'end_time'=>strtotime("+1 day")),array('weid'=>$_W['weid'],'uid'=>$uid));
					break;
				case '30':
					$res = pdo_update('zjhl_ad_marketing_user',array('level'=>2,'end_time'=>strtotime("+30 day")),array('weid'=>$_W['weid'],'uid'=>$uid));
					break;
				case '365':
					$res = pdo_update('zjhl_ad_marketing_user',array('level'=>3,'end_time'=>strtotime("+365 day")),array('weid'=>$_W['weid'],'uid'=>$uid));
					break;
				default:
					# code...
					break;
			}
			if ($res) {
				exit('success');
			}else{
				exit('othererror');
			}
		}elseif ($act == 'delete') {
			if ($_W['ispost'] && checksubmit("submit")) {
				$uids = $_GPC['uid'];
				$uids = implode(',', $uids);
				$result = pdo_query("DELETE FROM ".tablename('zjhl_ad_marketing_user')." WHERE uid in (:uids)", array(':uids' => $uids));
				if (!empty($result)) {
				    message('删除成功','refresh','success');
				}
			}
		}elseif ($act == 'search') {
			$_W['page']['title'] = '会员搜索 - 会员 - 会员中心';
			$pindex = max(1, intval($_GPC['page']));

			$page_start = ($pindex-1)*$psize;
			$uid = $_GPC['uid'];
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename("zjhl_ad_marketing_user")." as ad LEFT JOIN ".tablename("mc_members")." as m on ad.uid = m.uid WHERE ad.uid = $uid");
			// $users = pdo_getslice("zjhl_ad_marketing_user",array(),array($page_start,$psize),$total);
			$users = pdo_fetchall("SELECT * FROM ".tablename("zjhl_ad_marketing_user")." as ad LEFT JOIN ".tablename("mc_members")." as m on ad.uid = m.uid WHERE ad.uid = $uid LIMIT $page_start,$psize ");

			$pager = pagination($total, $pindex, $psize);
		}
		include $this->template("user");
	}
	/***************************************************
	*  Web 端方法结束
	*  Mobile端方法开始
	****************************************************/
	// 手机端首页
	public function doMobileIndex()
	{
		global $_GPC,$_W;
		checkauth();
		$title = "个人中心"; 
		
		

		
		include $this->template("index");
	}
	
	// 添加广告
	public function doMobileAddAd()
	{
		global $_W,$_GPC;
		checkauth();
		$title = "发布广告";
		if (checksubmit('form_ad_post')) {
			$adtop1 = $_GPC['adtop1'];
			$adtop2 = $_GPC['adtop2'];
			$adbottom1 = $_GPC['adbottom1'];
			$adbottom2 = $_GPC['adbottom2'];
			$content = $_GPC['content'];
			$title = $_GPC['title'];
			$company = $_GPC['company'];
			$adid = empty($_GPC['adid'])?false:$_GPC['adid'];
			if($adid){
				pdo_update("zjhl_ad_marketing_ad",array("adtop1"=>$adtop1,"adbottom1"=>$adbottom1,"adtop2"=>$adtop2,"adbottom2"=>$adbottom2,"content"=>$content,"title"=>$title,"createtime"=>time(),"company"=>$company),array("id"=>$adid));
			}else{
				pdo_insert("zjhl_ad_marketing_ad",array("weid"=>$_W['weid'],"uid"=>$_W['member']['uid'],"adtop1"=>$adtop1,"adbottom1"=>$adbottom1,"adtop2"=>$adtop2,"adbottom2"=>$adbottom2,"content"=>$content,"title"=>$title,"createtime"=>time(),"company"=>$company));
			}
		}
		$ad = pdo_get("zjhl_ad_marketing_ad",array('weid'=>$_W['weid'],'uid'=>$_W['member']['uid']));
		$ad = empty($ad)?array():$ad;
		require "common/mobile_func.php";
		include $this->template("add_ad");
		
	}
	// 查看统计
	public function doMobileStatistics()
	{
		global $_W,$_GPC;
		checkauth();
		$title = "统计";
		$count = array(); 

		$count['article'] = pdo_fetch("SELECT COUNT(*) as `read` FROM ".tablename('zjhl_ad_marketing_article')." WHERE uid = :uid ", array(':uid' => $_W['member']['uid']));
		$count['article'] = $count['article']['read'];
		$count['article_read'] = pdo_fetch("SELECT SUM(`read`) `read` FROM ".tablename('zjhl_ad_marketing_article')." WHERE uid = :uid ", array(':uid' => $_W['member']['uid']));
		$count['article_read'] = $count['article_read']['read'];
		$count['ad_read'] = pdo_fetch("SELECT `read` FROM ".tablename('zjhl_ad_marketing_ad')." WHERE uid = :uid and weid = :weid ", array(':uid' => $_W['member']['uid'],":weid"=>$_W['weid']));
		$count['ad_read'] = $count['ad_read']['read'];

		
		include $this->template("statistics");
	}
	// 查看广告
	public function doMobileAd()
	{
		global $_W,$_GPC;
		$ad = pdo_get("zjhl_ad_marketing_ad",array('uid'=>$_GPC['uid']));
		$title = $ad['title'];
		pdo_update("zjhl_ad_marketing_ad", array("read"=>($ad['read']+1)), array('weid'=>$_W['weid'],"uid"=>$_W['member']['uid']));
		include $this->template("ad");
	}
	// 文章详情 
	public function doMobileArticle()
	{
		global $_W,$_GPC;
		$articleid = $_GPC['articleid'];

		$article = pdo_get("zjhl_ad_marketing_article",array('id'=>$articleid));
		$result = pdo_update("zjhl_ad_marketing_article", array("read"=>($article['read']+1)), array('id'=>$articleid));
		$ad = pdo_get("zjhl_ad_marketing_ad",array("uid"=>$article['uid'],'weid'=>$article['weid']));
		$user = pdo_get("zjhl_ad_marketing_user",array("uid"=>$article['uid'],'weid'=>$article['weid']));
		$title = $article['title'];

		include $this->template("article");
	}
}