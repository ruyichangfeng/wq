<?php
/**
 * 一沐官网模板模块微站定义
 *
 * @author 独孤飞01
 * @url http://www.yimucehua.com
 */
defined('IN_IA') or exit('Access Denied');

class Yimu_webpcModuleSite extends WeModuleSite {

	public function doMobileWebindex() {
		//这个操作被定义用来呈现 功能封面
		global $_W, $_GPC;
	}
	public function doWebGzindex() {
		//这个操作被定义用来呈现 规则列表
	}
	public function doWebSet() {
		//这个操作被定义用来呈现 管理中心导航菜单
       global $_W, $_GPC;
        load()->func('tpl');
        $_W['page']['title'] = '网站设置';
        $acid = $_W['acid'];
        $setting = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_shezhi'). " WHERE acid = :acid LIMIT 1", array(':acid' => $acid)); 
        $slide = unserialize($setting['slides']);
        $slides = serialize($_GPC['slides']);
        $data = array(
        'title' => trim($_GPC['title']),
        'slides' => $slides,
        'favicon' => trim($_GPC['favicon']),
        'flogo' => trim($_GPC['flogo']),
        'qq' => trim($_GPC['qq']),
        'name' => trim($_GPC['name']),
        'keywords' => trim($_GPC['keywords']),
        'description' => trim($_GPC['description']),      
        'address' => trim($_GPC['address']),
        'tel' => trim($_GPC['tel']),
        'code' => trim($_GPC['code']),
        'copyright' => trim($_GPC['copyright']),
        'acid' => trim($_GPC['acid']),
        );
      
		if(checksubmit('submit')) {
			if (empty($setting)){
				$result = pdo_insert('ym_webpc_shezhi', $data);
				if (!empty($result)) {
					message('设置成功！', $this->createWebUrl('set'));
				}
			}else{
				$result = pdo_update('ym_webpc_shezhi', $data, array('acid' => $acid));
				if (!empty($result)) {
					message('设置成功！', $this->createWebUrl('set'));
				}
			}
				

        
		}
		

		include $this->template('set');
	}
	public function doWebNemuset() {
	//这个操作被定义用来呈现 管理中心导航菜单
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '菜单设置';
        $setting = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_nemun'). " WHERE acid = :acid LIMIT 1", array(':acid' => $acid));
        if (empty($setting)){
        	$setting = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_nemun'). " WHERE id = :id LIMIT 1", array(':id' => '1'));
        }
        $usersetting = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_nemun'). " WHERE acid = :acid LIMIT 1", array(':acid' => $acid));
        $setbut = unserialize($setting['userbt']);
         $nemunbt = array(
        	'indexbt' => trim($_GPC['indexbt']),
        	'productbt' => trim($_GPC['productbt']),
        	'programbt' => trim($_GPC['programbt']),
        	'casebt' => trim($_GPC['casebt']),
        	'agentbt' => trim($_GPC['agentbt']),
        	'aboutbt' => trim($_GPC['aboutbt']),
        	'dlbt' => trim($_GPC['dlbt'])
        );
        $userbt = serialize($nemunbt);
        $nemundata = array(
          'acid' => trim($_GPC['acid']),
          'index' => trim($_GPC['index']),
          'product' => trim($_GPC['product']),
          'program' => trim($_GPC['program']),
          'case' => trim($_GPC['case']),
          'agent' => trim($_GPC['agent']),
          'about' => trim($_GPC['about']),
          'dl' => trim($_GPC['dl']),
          'userbt' => $userbt,
          'url' => trim($_GPC['url']),
          'html' => $_GPC['html'],
        );
       
        if (checksubmit('submit')){
			
		      	if (empty($usersetting)){
		      		$result = pdo_insert('ym_webpc_nemun', $nemundata);
					if (!empty($result)) {
						$uid = pdo_insertid();
						message('设置成功！', $this->createWebUrl('nemuset'));
					}		      	
             }else{
             	$result = pdo_update('ym_webpc_nemun', $nemundata, array('acid' => $acid));
				if (!empty($result)) {
					message('更新成功', $this->createWebUrl('nemuset'));
				}
             }
       
	}
	
	include $this->template('nemuset');
}
	public function doWebIndex() {
		//这个操作被定义用来呈现 管理中心导航菜单
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '首页设置';
        $setbut = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_index_set'). " WHERE acid = :acid LIMIT 1", array(':acid' => $acid));
        $data = array(        	
        	'functionbt' => trim($_GPC['functionbt']),
        	'scenebt' => trim($_GPC['scenebt']),
        	'toolbt' => trim($_GPC['toolbt']),
        	'casebt' => trim($_GPC['casebt']),
        	'advantagebt' => trim($_GPC['advantagebt']),
        	'programbt' => trim($_GPC['programbt']),
        	'processbt' => trim($_GPC['processbt']),
        	'timesbt' => trim($_GPC['timesbt']),
        	'acid' => trim($_GPC['acid']),
        	'imgbt' => trim($_GPC['imgbt'])
        );
        
        if (checksubmit('submit')){
        	
	      	if (empty($setbut)){
	      		$result = pdo_insert('ym_webpc_index_set', $data);
	     		if (!empty($result)){
	      			message('更新成功', $this->createWebUrl('index'));
	      		}        		
	     	}else{
	      		$query = pdo_update('ym_webpc_index_set', $data, array('acid' => $acid));
	      		if (!empty($query)){
	      			message('更新成功', $this->createWebUrl('index'));
	      		}
	      	}
        }
        
        include $this->template('index');
        
	}
	public function doWebDel(){
		global $_W,$_GPC;
		$anid = $_GPC['anid'];
		pdo_delete('ym_webpc_anli',array('id'=>$anid));
		message('删除成功！',$this->createWebUrl('anli'));
	}
	
	public function doWebDelprogram(){
		global $_W,$_GPC;
		$anid = $_GPC['anid'];
		pdo_delete('ym_webpc_program',array('id'=>$anid));
		message('删除成功！',$this->createWebUrl('programlist'));
	}
	
	public function doWebAnli() {
		//这个操作被定义用来呈现 管理中心导航菜单
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '案例设置';
        $setting = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_anli'). " WHERE acid = :acid", array(':acid' => $acid));
       
        include $this->template('anli');
	}
	public function doWebAnliindex() {
		//这个操作被定义用来呈现案例首页
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '案例设置';
        $setting = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_anliindex'). " WHERE acid = :acid", array(':acid' => $acid));
        $data = array(       	
        	'img' => $_GPC['img'],
        	'acid' => $acid        	
        );
        if (checksubmit('submit')){
        	if (empty($setting)){
        		$int = pdo_insert('ym_webpc_anliindex', $data);
        		if (!empty($int)){
	        			message('添加成功！', $this->createWebUrl('anliindex'));
	        		}
        	}else{
        		$up= pdo_update('ym_webpc_anliindex', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('anliindex'));
	    		}
        	}
        }
        include $this->template('anliindex');
	}
	public function doWebDelproduct(){
		global $_W,$_GPC;
		$id = $_GPC['productid'];
		pdo_delete('ym_webpc_product',array('id'=>$id));
		message('删除成功！',$this->createWebUrl('productlist'));
	}
	public function doWebIntanli() {
		//这个操作被定义用来呈现 管理中心导航菜单
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '案例设置';
        $id = $_GPC['anid'];
        $data = array(
        	'acid' => trim($acid),
        	'name' => trim($_GPC['name']),
        	'img' => trim($_GPC['img']),
        	'code' => trim($_GPC['code'])
        );
        $setting = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_anli'). " WHERE acid = :acid AND id = :id", array(':acid' => $acid, ':id' => $id));
        if (checksubmit('submit')){
        	if (empty($setting)){
        	$intanli = pdo_insert('ym_webpc_anli', $data);
	        	if (!empty($intanli)){
	        		message('新增案例成功！', $this->createWebUrl('intanli'));
	        	}
       		}else{
       			$upanli = pdo_update('ym_webpc_anli', $data, array('id' => $id));
       			if (!empty($upanli)){
       				message('更新成功！', $this->createWebUrl('intanli', array('anid' => $id)));
       			}
       		}
       }
        
       
        include $this->template('intanli');
	}
	
	
	public function doWebFunction(){
		//此处定义核心功能
		global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $id = $_GPC['itemid'];
        $setting = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_function') ." WHERE acid = :acid", array(':acid' => $acid));
//      foreach($setting as $val);
        if (empty($setting)){
        	$setting = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_function') ." WHERE acid = :acid", array(':acid' => '0'));
        }
        foreach($setting as $item);
        $data = array(
        	'title' => trim($_GPC['title']),
        	'img' => trim($_GPC['img']),
        	'introduce' => trim($_GPC['introduce']),
        	'title1' => trim($_GPC['title1']),
        	'img1' => trim($_GPC['img1']),
        	'introduce1' => trim($_GPC['introduce1']),
        	'title2' => trim($_GPC['title2']),
        	'img2' => trim($_GPC['img2']),
        	'introduce2' => trim($_GPC['introduce2']),
        	'title3' => trim($_GPC['title3']),
        	'img3' => trim($_GPC['img3']),
        	'introduce3' => trim($_GPC['introduce3']),
        	'title4' => trim($_GPC['title4']),
        	'img4' => trim($_GPC['img4']),
        	'introduce4' => trim($_GPC['introduce4']),
        	'acid' => $acid,
        );
        if(checksubmit('submit')){
        	$userfunc = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_function') ." WHERE acid = :acid", array(':acid' => $acid));
	      	if (empty($userfunc)){	      
	      		$intfunction = pdo_insert('ym_webpc_function', $data);
	        		if (!empty($intfunction)){
	        			message('更新成功！', $this->createWebUrl('function'));
	        		}
	   	    }else{
	    		$upfunction = pdo_update('ym_webpc_function', $data, array('acid' => $acid));
	    		if (!empty($upfunction)){
	    			message('更新成功！', $this->createWebUrl('function', array('fucid' => $acid)));
	    		}
	    	}
        	
        }
        include $this->template('function');
	}
	
	public function doWebCase(){
		//此处定义精彩案例
		global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $setting = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_case') ." WHERE acid = :acid", array(':acid' => $acid));
//      foreach($setting as $val);
        if (empty($setting)){
        	$setting = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_case') ." WHERE acid = :acid", array(':acid' => '0'));
        }
        $usercase = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_case') ." WHERE acid = :acid", array(':acid' => $acid));
        foreach($setting as $item);
        $data = array(
        	'title' => trim($_GPC['title']),
        	'img' => trim($_GPC['img']),
        	'category' => trim($_GPC['category']),
        	'code' => trim($_GPC['code']),
        	'title1' => trim($_GPC['title1']),
        	'img1' => trim($_GPC['img1']),
        	'category1' => trim($_GPC['category1']),
        	'code1' => trim($_GPC['code1']),
        	'title2' => trim($_GPC['title2']),
        	'img2' => trim($_GPC['img2']),
        	'category2' => trim($_GPC['category2']),
        	'code2' => trim($_GPC['code2']),
        	'title3' => trim($_GPC['title3']),
        	'img3' => trim($_GPC['img3']),
        	'category3' => trim($_GPC['category3']),
        	'code3' => trim($_GPC['code3']),
        	'acid' => $acid,
        );
        if(checksubmit('submit')){
        	
	      	if (empty($usercase)){	      
	      		$intfunction = pdo_insert('ym_webpc_case', $data);
	        		if (!empty($intfunction)){
	        			message('更新成功！', $this->createWebUrl('case'));
	        		}
	   	    }else{
	    		$upfunction = pdo_update('ym_webpc_case', $data, array('acid' => $acid));
	    		if (!empty($upfunction)){
	    			message('更新成功！', $this->createWebUrl('case', array('caseid' => $acid)));
	    		}
	    	}
        	
        }
        include $this->template('case');		
	}
	
	public function doWebProgram() {
		//这个操作被定义小程序案例
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '案例设置';
        $setting = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_program'). " WHERE acid = :acid", array(':acid' => $acid));
       
        include $this->template('programlist');
	}
	
	public function doWebProgramlist() {
		//这个操作被定义小程序案例
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '案例设置';
        $id = $_GPC['anid'];
        $item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_program'). " WHERE id = :id", array(':id' => $id));
        $data = array(
        	'title' => $_GPC['title'],
        	'code' => $_GPC['code'],
        	'select' => $_GPC['select'],
        	'acid' => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($_GPC['anid'])){
        		$intanli = pdo_insert('ym_webpc_program', $data);
        		if (!empty($intanli)){
	        			message('更新成功！', $this->createWebUrl('program'));
	        		}
        	}else{
        		$upanli = pdo_update('ym_webpc_program', $data, array('id' => $id));
	    		if (!empty($upanli)){
	    			message('更新成功！', $this->createWebUrl('program'));
	    		}
        	}
        }
        include $this->template('program');
	}
	
	public function doWebTimes() {
		//这个操作被定义小程序时代
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '案例设置';
        
        $item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_times'). " WHERE acid = :acid", array(':acid' => $acid));
        $data = array(
        	'partner' => $_GPC['partner'],
        	'industry' => $_GPC['industry'],
        	'access' => $_GPC['access'],
        	'product' => $_GPC['product'],
        	'business' => $_GPC['business'],
        	'acid' => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('ym_webpc_times', $data);
        		if (!empty($int)){
	        			message('更新成功！', $this->createWebUrl('times'));
	        		}
        	}else{
        		$up= pdo_update('ym_webpc_times', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('times'));
	    		}
        	}
        }
        include $this->template('times');
	}
	
	public function doWebAboutme() {
		//这个操作被定义关于我们
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '关于我们';
        $item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_about'). " WHERE acid = :acid", array(':acid' => $acid));
        $data = array(
        	'title' => $_GPC['title'],
        	'xtitle' => $_GPC['xtitle'],
        	'img' => $_GPC['img'],
        	'me' => $_GPC['me'],
        	'tell' => $_GPC['tell'],
        	'map' => $_GPC['map'],
        	'acid' => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('ym_webpc_about', $data);
        		if (!empty($int)){
	        			message('更新成功！', $this->createWebUrl('aboutme'));
	        		}
        	}else{
        		$up= pdo_update('ym_webpc_about', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('aboutme'));
	    		}
        	}
        }
        include $this->template('aboutme');
	}
	
	public function doWebDailis() {
		//这个操作被定义代理加盟
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $_W['page']['title'] = '代理加盟';
        $item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_dailis'). " WHERE acid = :acid", array(':acid' => $acid));
        $base = unserialize($item['baseimg']);
        $data = array(
        	'title' => $_GPC['title'],
        	'xtitle' => $_GPC['xtitle'],
        	'img' => $_GPC['img'],
        	'analysis' => $_GPC['analysis'],
        	'analysisimg' => $_GPC['analysisimg'],
        	'wximg' => $_GPC['wximg'],
        	'base' => $_GPC['base'],
        	'baseimg' => serialize($_GPC['baseimg']),
        	'acid' => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('ym_webpc_dailis', $data);
        		if (!empty($int)){
	        			message('更新成功！', $this->createWebUrl('dailis'));
	        		}
        	}else{
        		$up= pdo_update('ym_webpc_dailis', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('dailis'));
	    		}
        	}
        }
        include $this->template('dailis');
	}
	
	public function doWebProductindex() {
		//这个操作被定义产品中心首页
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $id = $_GPC['productid'];
        $_W['page']['title'] = '产品中心';
        $item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_productindex'). " WHERE acid = :acid", array(':acid' => $acid));
        $data = array(       	
        	'img' => $_GPC['img'],
        	'acid' => $acid        	
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('ym_webpc_productindex', $data);
        		if (!empty($int)){
	        			message('添加成功！', $this->createWebUrl('productindex'));
	        		}
        	}else{
        		$up= pdo_update('ym_webpc_productindex', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('productindex'));
	    		}
        	}
        }
        include $this->template('productindex');
	}
	
	public function doWebProduct() {
		//这个操作被定义产品中心
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $id = $_GPC['productid'];
        $_W['page']['title'] = '产品中心';
        $item = pdo_fetch("SELECT * FROM " .tablename('ym_webpc_product'). " WHERE id = :id", array(':id' => $id));
        $data = array(
        	'title' => $_GPC['title'],
        	'img' => $_GPC['img'],
        	'select' => $_GPC['select'],
        	'acid' => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($id)){
        		$int = pdo_insert('ym_webpc_product', $data);
        		if (!empty($int)){
	        			message('添加成功！', $this->createWebUrl('productlist'));
	        		}
        	}else{
        		$up= pdo_update('ym_webpc_product', $data, array('id' => $id));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('productlist'));
	    		}
        	}
        }
        include $this->template('product');
	}
	
	public function doWebProductlist() {
		//这个操作被定义产品列表
		 global $_W, $_GPC;
        load()->func('tpl');
        $acid = $_W['acid'];
        $id = $_GPC['productid'];
        $_W['page']['title'] = '产品中心';
        $setting = pdo_fetchall("SELECT * FROM " .tablename('ym_webpc_product'). " WHERE acid = :acid", array(':acid' => $acid));
       
        include $this->template('productlist');
	}

}

