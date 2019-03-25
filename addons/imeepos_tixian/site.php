<?php
/**
 * 米波提现模块微站定义
 *
 * @author imeepos
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define("MUI",true);

class Imeepos_tixianModuleSite extends WeModuleSite {
	function M($name){
		static $imeepos_tixian_model = array();
		if(empty($imeepos_tixian_model[$name])) {
			include IA_ROOT.'/addons/imeepos_tixian/model/'.$name.'.php';
			$class = "ImeeposTixian_".$name;
			$imeepos_tixian_model[$name] = new $class();
		}
		return $imeepos_tixian_model[$name];
	}
	public function __construct()
	{
		global $_W;
		$this->system = $this->M('setting')->getSetting('system');
		if(!empty($_W['openid'])){
			$this->M('member')->update();
		}
	}

	public function doWebfinish_paylog(){
		global $_W,$_GPC;
		$_GPC['do'] = 'finish_paylog';
		$act = trim($_GPC['act']);
		if($act == 'finish'){
			$to_openid = trim($_GPC['to_openid']);
			$credit = floatval($_GPC['credit']);
			//打款
			$member = $this->M('member')->getInfo($to_openid);
			$trade_no = random(32);
			$desc = date('Y-m-d H:i')."打款给".$member['nickname'].":".$credit."元";
			$return = $this->M('finance')->pay($to_openid,$credit * 100,$trade_no,$desc);
			if(is_error($return)){
				message($return['message'],'','error');
			}
			//打款成功后 改变订单状态
			pdo_update('imeepos_tixian_manage',array('status'=>1),array('openid'=>$to_openid,'status'=>0));

			$site = WeUtility::createModuleSite('imeepos_opensms');
			$title = "现金到账通知";
			$time = date('Y-m-d H:i',time);
			$remark = "您的现金已到账微信余额，请注意查收";
			$url = $this->createMobileUrl('index');
			$url = str_replace('./','',$url);
			$url = $_W['siteroot']."app/".$url;
			$site->sendTplCreditToCash($member,$title,$credit,$time,$remark,$url);
			message('打款成功',$this->createWebUrl('finish_paylog'),'success');
		}
		$sql = "SELECT SUM(credit) as credit,openid FROM ".tablename('imeepos_tixian_manage')." WHERE uniacid = :uniacid AND status = :status GROUP BY openid ORDER BY credit DESC";
		$params = array(':uniacid'=>$_W['uniacid'],':status'=>0);
		$list = pdo_fetchall($sql,$params);
		include $this->template('finish_paylog');
	}
	
	public function doMobilelog(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'log';
	    $act = trim($_GPC['act']);
		$page = intval($_GPC['page']);
		$page = $page>0?$page:1;
		$where = " AND openid = :openid";
		$status = trim($_GPC['status']);
		if($status == 'null'){

		}
		if($status == '0'){
			$where .= " AND status = 0";
		}
		if($status == '1'){
			$where .= " AND status = 1";
		}
		if($status == '2'){
			$where .= " AND status = 2";
		}
		$params = array(':openid'=>$_W['openid']);
		$psize = 10;
		$list = $this->M('manage')->getList($page,$where,$params,$psize);

		if($page>1){
			include $this->template('log_more');
			exit();
		}
	    include $this->template('log');
	}

	public function doMobileindex(){
	    global $_W,$_GPC;
	 //    ini_set("display_errors", "On");
		// error_reporting(E_ALL | E_STRICT);
		load()->model('mc');
		if(empty($_W['openid'])){
			message("获取openid失败",referer(),'error');
		}
	    $_GPC['do'] = 'index';
		$member = $this->M('member')->getInfo($_W['openid']);
		$uid = mc_openid2uid($_W['openid']);
		$user = mc_fetch($uid);
		$member['credit2'] = $user['credit2'];
		$act = trim($_GPC['act']);

		$setting = $this->M('setting')->getSetting('system');

		if($act == 'post'){
			$data = array();
			if(!empty($_GPC['credit'])){

			    $credit = floatval($_GPC['credit']);
			    //扣除提现手续费
			    $tixian_kouchu = floatval($setting['tixian_kouchu']) / 100;
			    $data['credit'] = (1 - $tixian_kouchu) * $credit;
				$uid = mc_openid2uid($_W['openid']);
				$return = mc_credit_update($uid,'credit2','-'.$credit,array());

				if(is_error($return)){
					$data = array();
					$data['status'] = 0;
					$data['message'] = $return['message'];
					die(json_encode($data));
				}
			}
			if(!empty($_GPC['message'])){
			    $data['message'] = trim($_GPC['message']);
			}
			$data['uniacid'] = $_W['uniacid'];
			$data['openid'] = $_W['openid'];
			$data['status'] = 0;
			$data['create_time'] = time();
			$this->M('manage')->update($data);

			$data = array();
			$data['status'] = 1;
			die(json_encode($data));
		}
	    include $this->template('index');
	}
	public function doWebmanage(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'manage';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
				$this->M('manage')->update($data);
	            message('保存成功',$this->createWebUrl('manage'),'success');
	        }
	        $item = $this->M('manage')->getInfo($id);
	        include $this->template('manage_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            if($_W['ispost']){
	                $data = array();
	                $data['status'] = 1;
	                $data['message'] = '参数错误';
	                die(json_encode($data));
	            }else{
	                message('参数错误',referer(),'error');
	            }
	        }
			$this->M('manage')->delete($id);
	        if($_W['ispost']){
	            $data = array();
	            $data['status'] = 1;
	            $data['message'] = '操作成功';
	            die(json_encode($data));
	        }else{
	            message('删除成功',referer(),'success');
	        }
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
	    $where = "";
		$list = $this->M('manage')->getList($page,$where);
	    include $this->template('manage');
	}
	public function doWebsetting(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'setting';
	    $code = $_GPC['code'];
	    if(empty($code)){
	        $code = 'system';
	    }
	    if(empty($code)){
	        message('参数错误',referer(),'error');
	    }
		$item = $this->M('setting')->getSetting($code);
		if(empty($item)){
			$item['module'] = 'imeepos_tixian';
		}
	    if($_W['ispost']){
	        $data = array();
	        $data['codename'] = $code;
			$_POST = array_merge($item,$_POST);
			if(!empty($_FILES)){
				foreach ($_FILES as $key => $file){
					$name = $file['name'];
					if(!empty($name)){
						$ext = substr($name, strrpos($name, '.')+1);
						if($ext != 'pem'){
							message("文件格式有误",referer(),'error');
						}
						$temp = $file['tmp_name'];
						$content = file_get_contents($temp);
						$path = IA_ROOT . '/addons/imeepos_tixian/public/cert/' . $_W['uniacid'] . '/';
						
						if (!is_dir($path)) {
							load()->func('file');
							mkdirs($path);
						}

						$cert_file = $path . $name;
						if(!is_file($cert_file)){
							file_put_contents($cert_file,$content);
						}
						$_POST[$key] = $cert_file;
					}
				}
			}
	        $data['value'] = serialize($_POST);
			$this->M('setting')->update($data);
	        message('保存成功',referer(),'success');
	    }

	    include $this->template('setting_'.$code);
	}
	public function doWebmember(){
	    global $_W,$_GPC;
	    $_GPC['do'] = 'member';
	    if ($_GPC['act'] == 'edit') {
	        $id = intval($_GPC['id']);
	        if($_W['ispost']){
	            $data = array();
	            $data['uniacid'] = $_W['uniacid'];
	            $data['create_time'] = time();
	            if(!empty($id)){
	                $data['id'] = $id;
	                unset($data['create_time']);
	            }
				$this->M('member')->update($data);
	            message('保存成功',$this->createWebUrl('member'),'success');
	        }
	        $item = M('member')->getInfo($id);
	        include $this->template('member_edit');
	        exit();
	    }
	    if ($_GPC['act'] == 'delete') {
	        $id = intval($_GPC['id']);
	        if(empty($id)){
	            if($_W['ispost']){
	                $data = array();
	                $data['status'] = 1;
	                $data['message'] = '参数错误';
	                die(json_encode($data));
	            }else{
	                message('参数错误',referer(),'error');
	            }
	        }
			$this->M('member')->delete($id);
	        if($_W['ispost']){
	            $data = array();
	            $data['status'] = 1;
	            $data['message'] = '操作成功';
	            die(json_encode($data));
	        }else{
	            message('删除成功',referer(),'success');
	        }
	    }
	    $page = !empty($_GPC['page'])?intval($_GPC['page']):1;
	    $where = "";
		$list = $this->M('member')->getList($page,$where);
	    include $this->template('member');
	}

}