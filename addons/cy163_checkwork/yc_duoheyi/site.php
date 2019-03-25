<?php
/**
 * 一键关注|一键拔号|一键生成引导关注H5模块微站定义
 *
 * @author flyerzsk
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Yc_duoheyiModuleSite extends WeModuleSite {

	public function doMobileDuoheyi() {
		//这个操作被定义用来呈现 功能封面
		
		global $_W,$_GPC; 
		$username = $_GPC['username'];
		$tips = $_GPC['tips'];
		$tel=$_GPC['tel'];
		$share_title = '这个公众号好强大，快来看看';
		$share_content = '公众号越来越多，这样高品质的号越加稀少了，赶紧关注起来';	
		if(!empty($tel)) {
			return "<a id='tel' href='tel:".$tel."'></a><script>document.getElementById('tel').click();</script>";
		}
		if (empty($username)) {
			include $this->template('index');
		}else{ 
		
			include $this->template('show');
		} 
		
	}
 
	public function doWebgetshorturl() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		$tel=$_GPC['tel']; 
		$url=$this->createMobileUrl("duoheyi")."&tel=".$tel;
		$url=$_W['siteroot']."app/".substr($url,2);
		exit(json_encode(array('code'=>3,'url'=>$url,'shorturl'=>$shorturl)));
		// return "<a id='tel' href='tel:".$tel."'></a><script>document.getElementById('tel').click();</script>";
	}
	public function doMobilecheckQrCode() {
		//这个操作被定义用来呈现 功能封面
		global $_W,$_GPC;
		$username = $_GPC['username'];
		load()->func('communication');
		$img = ihttp_get("http://open.weixin.qq.com/qr/code/?username=".$username);
		if (!empty($img['content'])) {
			$ret = array('ret' => 0);
		}else{
			$ret= array('ret' => 1);
		}
		exit(json_encode($ret));
	}
	
	public function doWebOnefollow() {
		//这个操作被定义用来呈现 管理中心导航菜单
		
		include $this->template('onefollow');
	}
	public function doWebOnelead() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		if($_W['isajax']){
			$username=$_GPC['username'];
			exit(json_encode(array('username'=>$username)));
		}
		
		include $this->template('onelead');
	}
	public function doWebOnetel() {
		//这个操作被定义用来呈现 管理中心导航菜单
		
		include $this->template('onetel');
	}
	public function dowebcheckQrCode() {
		//这个操作被定义用来呈现 功能封面 
		return $this->doMobilecheckQrCode();
	}
	  public function doMobileRedirect() {
        include_once 'template/mobile/redirect.php';
    }
	 
}
 
   