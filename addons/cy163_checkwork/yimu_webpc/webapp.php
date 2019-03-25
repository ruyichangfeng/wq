<?php
/**
 * 一沐官网模板模块PC接口定义
 *
 * @author 独孤飞01
 * @url http://www.yimucehua.com
 */
defined('IN_IA') or exit('Access Denied');

class Yimu_webpcModuleWebapp extends WeModuleWebapp {
	public function doPageTest(){
		global $_GPC, $_W;
		$errno = 0;
		$message = '返回消息';
		$data = array();
		return $this->result($errno, $message, $data);
	}

	public function doPageIndex() {
		//这个操作被定义用来呈现 PC版
		global $_GPC, $_W;
		load()->func('tpl');
        $id = $_GPC['i'];
        $setting = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_shezhi')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($setting)){
        	$setting = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_shezhi')." WHERE acid = :acid", array(':acid' => '0'));
        }
        $nemu = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_nemun')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($nemu)){
        	$nemu = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_nemun')." WHERE acid = :acid", array(':acid' => '0'));
        }
        $unnemu = unserialize($nemu['userbt']);
        $inx = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_index_set')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($inx)){
        	$inx = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_index_set')." WHERE acid = :acid", array(':acid' => '0'));
        }
        $imgs = unserialize($setting['slides']);
        //
        $function = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_function')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($function)){
        	$function = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_function')." WHERE acid = :acid", array(':acid' => '0'));
        }
        //
        $cases = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_case')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($case)){
        	$case = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_case')." WHERE acid = :acid", array(':acid' => '0'));
        }
        //
        $times = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_times')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($times)){
        	$times = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_times')." WHERE acid = :acid", array(':acid' => '0'));
        }
		
        include $this->template('intel/index');
	}
	
	
	public function doPageFooter() {
		//这个操作被定义用来呈现 dibu 
		global $_W, $_GPC;
        load()->func('tpl');
        $id = $_GPC['i'];
        $setting = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_shezhi') ." WHERE acid = :acid", array(':acid' => $id));
        include $this->template('intel/footer');
	}
	public function doPageHeader() {
		//这个操作被定义用来呈现 dibu 
		global $_W, $_GPC;
        load()->func('tpl');
        $id = $_GPC['i'];
        $setting = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_shezhi')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($setting)){
        	$setting = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_shezhi')." WHERE acid = :acid", array(':acid' => '0'));
        }
        $nemu = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_nemun')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($nemu)){
        	$nemu = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_nemun')." WHERE acid = :acid", array(':acid' => '0'));
        }
        $unnemu = unserialize($nemu['userbt']);
        $inx = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_index_set')." WHERE acid = :acid", array(':acid' => $id));
        if (empty($inx)){
        	$inx = pdo_fetch("SELECT * FROM ".tablename('ym_webpc_index_set')." WHERE acid = :acid", array(':acid' => '0'));
        }
        include $this->template('intel/header');
	}
	public function doPageProduct() {
		//这个操作被定义用来呈现 产品中心
		global $_GPC, $_W;
		load()->func('tpl');		
		$id = $_GPC['i'];
		require_once 'template/webapp/intel/inc/header.php';
		$item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_productindex'). " WHERE acid = :acid", array(':acid' => $id));
		$case = pdo_getall('ym_webpc_product', array('acid' => $id));
 		$case1 = pdo_getall('ym_webpc_product', array('acid' => $id, 'select' =>1));
		$case2 = pdo_getall('ym_webpc_product', array('acid' => $id, 'select' =>2));
		$case3 = pdo_getall('ym_webpc_product', array('acid' => $id, 'select' =>3));
		include $this->template('intel/product');
	}
	
	public function doPageCases() {
		//这个操作被定义用来呈现 经典案例
		global $_GPC, $_W;				
		$id = $_GPC['i'];
		require_once 'template/webapp/intel/inc/header.php';
		$item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_anliindex'). " WHERE acid = :acid", array(':acid' => $id));
		$cases = pdo_getall('ym_webpc_anli', array('acid' => $id));
		
		include $this->template('intel/cases');
	}
	
	public function doPageAboutus() {
		//这个操作被定义用来呈现 经典案例
		global $_GPC, $_W;				
		$id = $_GPC['i'];
		require_once 'template/webapp/intel/inc/header.php';
		$about = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_about'). " WHERE acid = :acid", array(':acid' => $id));
		
		
		include $this->template('intel/aboutus');
	}
	
	public function doPageJoinus() {
		//这个操作被定义用来呈现 经典案例
		global $_GPC, $_W;				
		$id = $_GPC['i'];
		require_once 'template/webapp/intel/inc/header.php';
		$dailis = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_dailis'). " WHERE acid = :acid", array(':acid' => $id));
		$base = unserialize($dailis['baseimg']);
		
		include $this->template('intel/joinus');
	}
	
	public function doPageNews() {
		//这个操作被定义用来呈现 经典案例
		global $_GPC, $_W;				
		$id = $_GPC['i'];
		require_once 'template/webapp/intel/inc/header.php';
		$item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_nemun'). " WHERE acid = :acid", array(':acid' => $id));
		$html = htmlspecialchars_decode($item['html']);
		
		include $this->template('intel/news');
	}
} 