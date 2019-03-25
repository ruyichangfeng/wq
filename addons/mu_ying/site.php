<?php
/**
 * 行业宝模块微站定义
 *
 * @author wangbosichuang
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Mu_yingModuleSite extends WeModuleSite {

	/*
		基础信息
	*/
	public function doWebBase() {
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_base') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$item['slide'] = unserialize($item['slide']);
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'title'=> $_GPC['title'],
					'tel'=> $_GPC['tel'],
					'slide' => serialize($_GPC['slide']),
					'db_img'=>$_GPC['db_img'],
					'wt_img'=>$_GPC['wt_img'],
					'headline'=>$_GPC['headline'],
					'headline_text'=>$_GPC['headline_text'],
					'bq_logo'	=>$_GPC['bq_logo'],
					'banquan'	=>$_GPC['banquan'],
					'wangzhi'	=>$_GPC['wangzhi'],
					'sy_img'=>$_GPC['sy_img'],
					'yx_title'=>$_GPC['yx_title'],
					'yx_youhui'=>$_GPC['yx_youhui'],
					'slide_header'=>$_GPC['slide_header'],
					'zx_title'=>$_GPC['zx_title'],
					'appid'=>$_GPC['appid'],
					'path'=>$_GPC['path'],
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_base', $data);
				} else {
					pdo_update('yuezi_zx_base', $data , array('uniacid' => $uniacid));
				} 
				message('基础信息更新成功!', $this -> createWebUrl('base', array('op' => 'display')), 'success');
				
			} 
		} 
		include $this -> template('base');
	} 
	//邮箱配置
	public function doWebEmail(){
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_email') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'mailhost'=> $_GPC['mailhost'],
					'mailport'=> $_GPC['mailport'],
					'mailhostname'=>$_GPC['mailhostname'],
					'mailformname'=>$_GPC['mailformname'],
					'mailusername'=>$_GPC['mailusername'],
					'mailpassword'=>$_GPC['mailpassword'],
					'mailsend'	=>$_GPC['mailsend']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_email', $data);
				} else {
					pdo_update('yuezi_zx_email', $data , array('uniacid' => $uniacid));
				} 
				message('邮箱配置更新成功!', $this -> createWebUrl('email', array('op' => 'display')), 'success');
				
			} 
		} 
		include $this->template('email');

	}

	//关于我们
	public function doWebGywm(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display','post','content','fendian','fendians','dd');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_gywm') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$item['slide'] = unserialize($item['slide']);
			$item['zhengshu'] = unserialize($item['zhengshu']);
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'slide' => serialize($_GPC['slide']),
					'img'=> $_GPC['img'],
					'title'=> $_GPC['title'],
					'rongyu'=>$_GPC['rongyu'],
					'miaoshu'=>$_GPC['miaoshu'],
					'zhengshu' => serialize($_GPC['zhengshu']),
					'pinpai'=>$_GPC['pinpai'],
					'pinpai_jianjie'=>$_GPC['pinpai_jianjie']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_gywm', $data);
				} else {
					pdo_update('yuezi_zx_gywm', $data , array('uniacid' => $uniacid));
				} 
				message('关于我们更新成功!', $this -> createWebUrl('gywm', array('op' => 'display')), 'success');
				
			}
		} 
		if ($op == 'post') {
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_zereng') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$item['img'] = unserialize($item['img']);
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'img' => serialize($_GPC['img']),
					'title'=> $_GPC['title'],
					'jianjie'=>$_GPC['jianjie'],
					'bq1_name'=>$_GPC['bq1_name'],
					'bq1_name2'=>$_GPC['bq1_name2'],
					'bq1_img'=> $_GPC['bq1_img'],
					'bq2_name'=> $_GPC['bq2_name'],
					'bq2_name2'=> $_GPC['bq2_name2'],
					'bq2_img'=> $_GPC['bq2_img'],
					'bq3_name'=> $_GPC['bq3_name'],
					'bq3_name2'=> $_GPC['bq3_name2'],
					'bq3_img'=> $_GPC['bq3_img']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_zereng', $data);
				} else {
					pdo_update('yuezi_zx_zereng', $data , array('uniacid' => $uniacid));
				} 
				message('责任使命更新成功!', $this -> createWebUrl('gywm', array('op' => 'post')), 'success');
				
			}
		} 
		if($op == "content"){
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_zhuangye') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			$item['img'] = unserialize($item['img']);
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'title'=> $_GPC['title'],
					'jianjie'=>$_GPC['jianjie'],
					'img1'=>$_GPC['img1'],
					'img1_title'=> $_GPC['img1_title'],
					'img2'=> $_GPC['img2'],
					'img2_title'=> $_GPC['img2_title'],
					'img3'=> $_GPC['img3'],
					'img3_title'=> $_GPC['img3_title']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_zhuangye', $data);
				} else {
					pdo_update('yuezi_zx_zhuangye', $data , array('uniacid' => $uniacid));
				} 
				message('专业力量更新成功!', $this -> createWebUrl('gywm', array('op' => 'content')), 'success');
				
			}
		}
		if ($op == "fendian"){
			//查询分店内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_fendian')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
		}
		if ($op == "fendians"){
			//查询楼层
			$louceng = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_fendian')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_fendian') . " WHERE id = :id" , array(':id' => $id));
				$item['slide'] = unserialize($item['slide']);
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				} 
				$data = array('uniacid' => $_W['uniacid'], 'title' => addslashes($_GPC['title']),'name'=>$_GPC['name'],'jianjie'=>$_GPC['jianjie'],'img'=>$_GPC['img'],'slide' => serialize($_GPC['slide']),);
				if (empty($id)) {
					pdo_insert('yuezi_zx_fendian', $data);
				} else {
					pdo_update('yuezi_zx_fendian', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('分店 添加/修改 成功!', $this -> createWeburl('gywm', array('op' => 'fendian')), 'success');
			} 
		}
		if ($op == 'dd') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_fendian') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('分店不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_fendian', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('gywm', array('op' => 'fendian')), 'success');
		} 
		include $this->template('gywm');
	}

	//套餐价格
	public function doWebTcjg(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display','post','posts','delete','fu');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		//var_dump($uniacid);
		if ($op == 'display') {
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_tc') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'img'=> $_GPC['img'],
					'title' =>$_GPC['title'],
					'img_title'=> $_GPC['img_title'],
					'img_name'=>$_GPC['img_name'],
					'img_js'=>$_GPC['img_js']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_tc', $data);
				} else {
					pdo_update('yuezi_zx_tc', $data , array('uniacid' => $uniacid));
				} 
				message('套餐宣传图更新成功!', $this -> createWebUrl('tcjg', array('op' => 'display')), 'success');
			}
		} 
		if ($op == 'post') {
			//查询套餐内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_tcnr')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
			//var_dump($products);
		} 
		if ($op == "posts"){
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_tcnr') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				} 
				$data = array('uniacid' => $_W['uniacid'], 'title' => addslashes($_GPC['title']),'f_title'=>$_GPC['f_title'],'img'=>$_GPC['img']);
				if (empty($id)) {
					pdo_insert('yuezi_zx_tcnr', $data);
				} else {
					pdo_update('yuezi_zx_tcnr', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('套餐 添加/修改 成功!', $this -> createWeburl('tcjg', array('op' => 'post')), 'success');
			} 
		}
		//楼层删除
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_tcnr') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('套餐不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_tcnr', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('tcjg', array('op' => 'post')), 'success');
		} 
		if ($op == "fu"){
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_tcfw') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'about'=> $_GPC['about']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_tcfw', $data);
				} else {
					pdo_update('yuezi_zx_tcfw', $data , array('uniacid' => $uniacid));
				} 
				message('套餐服务更新成功!', $this -> createWebUrl('tcjg', array('op' => 'fu')), 'success');
				
			}
		}
		include $this->template('tcjg');
	}

	//明星客户
	public function doWebMxkh(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display','post','posts','delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		//var_dump($uniacid);
		if ($op == 'display') {
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_mxkh') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'img'=> $_GPC['img'],
					'title'=> $_GPC['title'],
					'jianjie'=>$_GPC['jianjie']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_mxkh', $data);
				} else {
					pdo_update('yuezi_zx_mxkh', $data , array('uniacid' => $uniacid));
				} 
				message('更新成功!', $this -> createWebUrl('mxkh', array('op' => 'display')), 'success');
				
			}
		} 
		if ($op == 'post') {
			//查询案例内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_mxkhgl')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
			//var_dump($products);
		} 
		if ($op == "posts"){
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_mxkhgl') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['name'])) {
					message('姓名不能为空，请输入姓名！');
				} 
				$data = array(
					'uniacid'=>$_W['uniacid'],
					'name'=>$_GPC['name'],
					'title'=>$_GPC['title'],
					'img'=>$_GPC['img'],
					'start_time' =>$_GPC['Time']['start'],
					'end_time'=>$_GPC['Time']['end'],
					'leixing'=>$_GPC['leixing'],
					'fangxing'=>$_GPC['fangxing'],
					'jianjie'=>$_GPC['jianjie']
					);
				if (empty($id)) {
					pdo_insert('yuezi_zx_mxkhgl', $data);
				} else {
					pdo_update('yuezi_zx_mxkhgl', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('案例内容 添加/修改 成功!', $this -> createWeburl('mxkh', array('op' => 'post')), 'success');
			} 
		}
		//楼层删除
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_mxkhgl') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('案例不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_mxkhgl', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('mxkh', array('op' => 'post')), 'success');
		} 
		include $this->template('mxkh');
	}
	

	//环境介绍
	public function doWebHjjs(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display','post','delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		//var_dump($uniacid);
		if ($op == 'display') {
			$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_hjjs') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'hj'=> $_GPC['hj'],
					'jy'=> $_GPC['jy'],
					'fd'=>$_GPC['fd'],
					'sl'=>$_GPC['sl']
				);
				if (empty($item['uniacid'])) {
					pdo_insert('yuezi_zx_hjjs', $data);
				} else {
					pdo_update('yuezi_zx_hjjs', $data , array('uniacid' => $uniacid));
				} 
				message('环境介绍更新成功!', $this -> createWebUrl('hjjs', array('op' => 'display')), 'success');
				
			}
		} 
		if ($op == "post"){
			//查询标签内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_hjbq')." WHERE uniacid = :uniacid",array(':uniacid'=>$uniacid));
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_hjbq') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标签不能为空，请输入标签！');
				} 
				$data = array(
					'uniacid'=>$_W['uniacid'],
					'title'=>$_GPC['title']
					);
				if (empty($id)) {
					pdo_insert('yuezi_zx_hjbq', $data);
				} else {
					pdo_update('yuezi_zx_hjbq', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('标签 添加/修改 成功!', $this -> createWeburl('hjjs', array('op' => 'post')), 'success');
			} 
		}
		//案例删除
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_hjbq') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('案例不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_hjbq', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('hjjs', array('op' => 'post')), 'success');
		} 
		include $this->template('hjjs');
	}

	//九大服务
	public function doWebJdfw(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display','del', 'post','posts', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == "display"){
			//查询分类内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_fwfl')." WHERE uniacid = :uniacid",array(':uniacid'=>$uniacid));
			$id = intval($_GPC['fl_id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_fwfl') . " WHERE fl_id = :fl_id" , array(':fl_id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('分类名称不能为空，请输入分类名称！');
				} 
				$data = array(
					'uniacid'=>$_W['uniacid'],
					'title'=>$_GPC['title']
					);
				if (empty($id)) {
					pdo_insert('yuezi_zx_fwfl', $data);
				} else {
					pdo_update('yuezi_zx_fwfl', $data, array('fl_id' => $id , 'uniacid' => $uniacid));
				} 
				message('分类 添加/修改 成功!', $this -> createWeburl('jdfw', array('op' => 'display')), 'success');
			} 
		}
		//分类删除
		if ($op == 'del') {
			$id = intval($_GPC['fl_id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_fwfl') . " WHERE fl_id = :fl_id and uniacid = :uniacid ", array(':fl_id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('分类不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_fwfl', array('fl_id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('jdfw', array('op' => 'display')), 'success');
		} 
		if ($op == 'post') {
			$products = pdo_fetchall("select * from ".tablename("yuezi_zx_fwgl"). " where uniacid=:uniacid",array("uniacid"=>$uniacid));
		} 
		if ($op == 'posts') {
			//查询服务分类
			$louceng = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_fwfl')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_fwgl') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('分类标题不能为空，请输入分类标题！');
				} 
				$data = array('uniacid' => $_W['uniacid'], 'fl_id' => $_GPC['fl_id'], 'title' => addslashes($_GPC['title']),'text'=>$_GPC['text']);
				if (empty($id)) {
					pdo_insert('yuezi_zx_fwgl', $data);
				} else {
					pdo_update('yuezi_zx_fwgl', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('分类及内容 添加/修改 成功!', $this -> createWeburl('jdfw', array('op' => 'post')), 'success');
			} 
		} 
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_fwgl') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('分类不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_fwgl', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('jdfw', array('op' => 'post')), 'success');
		} 
		include $this->template('jdfw');
	}

	//常见问题
	public function doWebCjwt(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display','del','post','posts','delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		//var_dump($uniacid);
		if ($op == 'display') {
			//查询标签内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_wtfl')." WHERE uniacid = :uniacid",array(':uniacid'=>$uniacid));
			$id = intval($_GPC['wt_id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_wtfl') . " WHERE wt_id = :wt_id" , array(':wt_id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标签不能为空，请输入标签！');
				} 
				$data = array(
					'uniacid'=>$_W['uniacid'],
					'title'=>$_GPC['title']
					);
				if (empty($id)) {
					pdo_insert('yuezi_zx_wtfl', $data);
				} else {
					pdo_update('yuezi_zx_wtfl', $data, array('wt_id' => $id , 'uniacid' => $uniacid));
				} 
				message('分类 添加/修改 成功!', $this -> createWeburl('cjwt', array('op' => 'display')), 'success');
			} 
		} 
		//分类删除
		if ($op == 'del') {
			$id = intval($_GPC['wt_id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_wtfl') . " WHERE wt_id = :wt_id and uniacid = :uniacid ", array(':wt_id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('分类不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_wtfl', array('wt_id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('cjwt', array('op' => 'display')), 'success');
		} 
		if ($op == "post"){
			//查询问题及答案内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_wtgl')." WHERE uniacid = :uniacid",array(':uniacid'=>$uniacid));
		}
		if ($op == "posts"){
			//查询楼层
			$louceng = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_wtfl')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_wtgl') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('问题不能为空，请输入问题！');
				} 
				$data = array('uniacid' => $_W['uniacid'],'wt_id'=>$_GPC['wt_id'], 'title' => addslashes($_GPC['title']),'daan'=>$_GPC['daan']);
				if (empty($id)) {
					pdo_insert('yuezi_zx_wtgl', $data);
				} else {
					pdo_update('yuezi_zx_wtgl', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('问题及答案 添加/修改 成功!', $this -> createWeburl('cjwt', array('op' => 'post')), 'success');
			} 
		}
		//问题删除
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_wtgl') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('问题不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_wtgl', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('cjwt', array('op' => 'post')), 'success');
		} 
		include $this->template('cjwt');
	}

	//知识百科
	public function doWebZsbk(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$products = pdo_fetchall("select * from ".tablename("yuezi_zx_rj"). " where uniacid=:uniacid",array("uniacid"=>$uniacid));
		} 
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_rj') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题名称不能为空，请输入标题名称！');
				} 
				$data = array('uniacid' => $_W['uniacid'], 'jianjie' => addslashes($_GPC['jianjie']), 'title' => addslashes($_GPC['title']),'text'=>$_GPC['text'],'img'=>$_GPC['img'],'time'=>TIMESTAMP);
				if (empty($id)) {
					pdo_insert('yuezi_zx_rj', $data);
				} else {
					unset($data['time']);
					$data['time '] = TIMESTAMP;
					pdo_update('yuezi_zx_rj', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('分类及内容 添加/修改 成功!', $this -> createWeburl('zsbk', array('op' => 'display')), 'success');
			} 
		} 
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_rj') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('内容不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_rj', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('zsbk', array('op' => 'display')), 'success');
		} 
		include $this->template('zsbk');
	}

	//资讯管理
	public function doWebZxgl(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$products = pdo_fetchall("select * from ".tablename("yuezi_zx_zixun"). " where uniacid=:uniacid",array("uniacid"=>$uniacid));
		} 
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_zixun') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题名称不能为空，请输入标题名称！');
				} 
				$data = array('uniacid' => $_W['uniacid'], 'jianjie' => addslashes($_GPC['jianjie']), 'title' => addslashes($_GPC['title']),'text'=>$_GPC['text'],'img'=>$_GPC['img']);
				if (empty($id)) {
					pdo_insert('yuezi_zx_zixun', $data);
				} else {
					pdo_update('yuezi_zx_zixun', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('资讯内容 添加/修改 成功!', $this -> createWeburl('zxgl', array('op' => 'display')), 'success');
			} 
		} 
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_zixun') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('内容不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_zixun', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('zxgl', array('op' => 'display')), 'success');
		} 
		include $this->template('zxgl');
	}

	//特色服务
	public function doWebtsfw(){
		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$products = pdo_fetchall("select * from ".tablename("yuezi_zx_tsfw"). " where uniacid=:uniacid",array("uniacid"=>$uniacid));
		} 
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_tsfw') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题名称不能为空，请输入标题名称！');
				} 
				$data = array('uniacid' => $_W['uniacid'], 'title' => addslashes($_GPC['title']),'text'=>$_GPC['text'],'img'=>$_GPC['img']);
				if (empty($id)) {
					pdo_insert('yuezi_zx_tsfw', $data);
				} else {
					pdo_update('yuezi_zx_tsfw', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('特色服务内容 添加/修改 成功!', $this -> createWeburl('tsfw', array('op' => 'display')), 'success');
			} 
		} 
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_tsfw') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('内容不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_tsfw', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('tsfw', array('op' => 'display')), 'success');
		} 
		include $this->template('tsfw');
	}

	//预约管理
	public function doWebYuyue(){
		global $_W;
		global $_GPC;
		$op = $_GPC['op'];
		$ops = array('display', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		
		if($op == 'display'){
			$yuyue = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_yuyue')." WHERE uniacid =:uniacid",array(':uniacid'=>$uniacid));
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_yuyue') . " WHERE id = :id and uniacid= :uniacid ", array(':id' => $id,':uniacid'=>$uniacid));
			if (empty($row)) {
				message('留言不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_yuyue', array('id' => $id));
			message('删除成功!', $this -> createWebUrl('yuyue', array('op' => 'display')), 'success');
		}
		include $this->template('yuyue');
	}

	//首页菜单
	public function doWebSycd(){

		global $_W,$_GPC;
		$op = $_GPC['op'];
		$ops = array('display','displays','delete','post','content','contents','dd');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			//查询首页菜单
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_caidan')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
		} 
		if ($op == 'displays'){
			//查询链接
			$lianjie = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_lianjie'));
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_caidan') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				} 
				$data = array('uniacid' => $_W['uniacid'], 'title' => addslashes($_GPC['title']),'lianjie'=>$_GPC['lianjie'],'img'=>$_GPC['img']);
				if (empty($id)) {
					pdo_insert('yuezi_zx_caidan', $data);
				} else {
					pdo_update('yuezi_zx_caidan', $data, array('id' => $id , 'uniacid' => $uniacid));
				} 
				message('首页菜单 添加/修改 成功!', $this -> createWeburl('sycd', array('op' => 'display')), 'success');
			} 
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_caidan') . " WHERE id = :id and uniacid = :uniacid ", array(':id' => $id , ':uniacid' => $uniacid));
			if (empty($row)) {
				message('菜单不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_caidan', array('id' => $id , 'uniacid' => $uniacid));
			message('删除成功!', $this -> createWeburl('sycd', array('op' => 'display')), 'success');
		} 
		if ($op == 'post') {
			//查询链接
			$lianjie = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_lianjie'));
			$items = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_button') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			// var_dump($item);
			if (checksubmit('submit')) {
			$data = array(
					'uniacid' => $_W['uniacid'],
					'cd1_title'=> $_GPC['cd1_title'],
					'cd1_img'=>$_GPC['cd1_img'],
					'cd1_lianjie'=>$_GPC['cd1_lianjie'],
					'cd2_title'=> $_GPC['cd2_title'],
					'cd2_img'=>$_GPC['cd2_img'],
					'cd2_lianjie'=>$_GPC['cd2_lianjie'],
					'cd3_title'=> $_GPC['cd3_title'],
					'cd3_img'=>$_GPC['cd3_img'],
					'cd3_lianjie'=>$_GPC['cd3_lianjie']
				);
				if (empty($items['uniacid'])) {
					pdo_insert('yuezi_zx_button', $data);
				} else {
					pdo_update('yuezi_zx_button', $data , array('uniacid' => $uniacid));
				} 
				message('更新成功!', $this -> createWebUrl('sycd', array('op' => 'post')), 'success');
				
			}
		} 
		
		if ($op == "content"){
			//查询首页菜单链接内容
			$products = pdo_fetchall("SELECT * FROM ".tablename('yuezi_zx_lianjie'));
		}
		if ($op == "contents"){
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				//查询编辑内容
				$item = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_lianjie') . " WHERE id = :id" , array(':id' => $id));
				if (empty($item)) {
					message('抱歉，项目不存在或是已经删除！', '', 'error');
				} 
			} 
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				} 
				$data = array('title' => addslashes($_GPC['title']),'lianjie'=>$_GPC['lianjie']);
				if (empty($id)) {
					pdo_insert('yuezi_zx_lianjie', $data);
				} else {
					pdo_update('yuezi_zx_lianjie', $data, array('id' => $id));
				} 
				message('首页菜单链接 添加/修改 成功!', $this -> createWeburl('sycd', array('op' => 'content')), 'success');
			} 
		}
		if ($op == 'dd') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename('yuezi_zx_lianjie') . " WHERE id = :id", array(':id' => $id));
			if (empty($row)) {
				message('链接不存在或是已经被删除！');
			} 
			pdo_delete('yuezi_zx_lianjie', array('id' => $id));
			message('删除成功!', $this -> createWeburl('sycd', array('op' => 'content')), 'success');
		} 
		include $this->template('sycd');
	}

}