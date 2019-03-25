<?php
/**
 * 微家教模块微站定义
 *
 * @author CW
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Cw_weijiajiaoModuleSite extends WeModuleSite {

	public $weid;
    public function __construct() { 
        global $_W;
        $this->weid = IMS_VERSION<0.6?$_W['weid']:$_W['uniacid'];
    }

	public $orgreply='jj_org_reply';
	public $teacher='jj_tec';
	public $res='jj_result';
	public $yuyue='jj_yuyue';

	public function doWebAbout() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	//教师管理
	public function doWebTeachers() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		load()->func('tpl');
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		$departments = pdo_fetchAll("SELECT * FROM".tablename($this->orgreply)." WHERE weid='{$_W['weid']}'");
		//print_r($departments);exit;
		if ($op == 'post') {
			if (!empty($_GPC['id'])) {
				$item = pdo_fetch("SELECT * FROM".tablename($this->teacher)." WHERE id='{$_GPC['id']}'");
			}
			
			$data = array(
				'weid'          => $_W['weid'],
				'tecsort'       => intval($_GPC['tecsort']),
				'tecname'       => $_GPC['tecname'],
				'texsex'        => $_GPC['texsex'],
				'tecage'        => $_GPC['tecage'],
				'tecculture'    => $_GPC['tecculture'],
				'teclesson'     => $_GPC['teclesson'],
				'tecpic'        => $_GPC['tecpic'],		
				'teccontent'    => htmlspecialchars_decode($_GPC['teccontent']),
				'department_id' => $_GPC['department_id'],
			);
			if ($_W['ispost']) {
				if (empty($_GPC['id'])) {
					pdo_insert($this->teacher,$data);
				}else{
					//print_r($data);exit;
					pdo_update($this->teacher,$data,array("id" => $_GPC['id']));
				}
				message("更新教师成功",$this->createWebUrl('teachers', array()),'success');
			}
		}elseif( $op == 'display'){
			$teacher = pdo_fetchAll("SELECT * FROM".tablename($this->teacher)." WHERE weid='{$_W['weid']}' order by tecsort asc");
			$list = array();
			foreach ($teacher as $key => $value) {
				$list[$key]['id'] = $value['id'];
				$list[$key]['tecsort'] = $value['tecsort'];
				$list[$key]['tecname'] = $value['tecname'];
				$list[$key]['tecsort'] = $value['tecsort'];
				$list[$key]['texsex'] = $value['texsex'];
				$list[$key]['tecage'] = $value['tecage'];
				$list[$key]['tecculture'] = $value['tecculture'];
				$list[$key]['teclesson'] = $value['teclesson'];
				$list[$key]['tecpic'] = $value['tecpic'];
				$list[$key]['teccontent'] = $value['teccontent'];
				$departments = pdo_fetch("SELECT * FROM".tablename($this->orgreply)." WHERE id='{$value['department_id']}'");
				$list[$key]['department'] = $departments['department'];
			}
		}elseif( $op == 'delete'){
			pdo_delete($this->teacher,array('id' => $_GPC['id'] ));
			message("删除教师成功",$this->createWebUrl('teachers', array()),'success');
		}
		include $this->template('teacher');
	}
	//成果管理
	public function doWebResult() {
		//这个操作被定义用来呈现 管理中心导航菜单
		global $_W,$_GPC;
		load()->func('tpl');
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		$departments = pdo_fetchAll("SELECT * FROM".tablename($this->orgreply)." WHERE weid='{$_W['weid']}'");
		//print_r($departments);exit;
		if ($op == 'post') {
			if (!empty($_GPC['id'])) {
				$item = pdo_fetch("SELECT * FROM".tablename($this->res)." WHERE id='{$_GPC['id']}'");
			}
			
			$data = array(
				'weid'          => $_W['weid'],
				'resname'       => $_GPC['resname'],
				'respic'        => $_GPC['respic'],
				'resinfo'       => $_GPC['resinfo'],
				'department_id' => $_GPC['department_id'],
				'ressort'       => $_GPC['ressort'],
			);
			if ($_W['ispost']) {
				if (empty($_GPC['id'])) {
					pdo_insert($this->res,$data);
				}else{
					//print_r($data);exit;
					pdo_update($this->res,$data,array("id" => $_GPC['id']));
				}
				message("更新成果成功",$this->createWebUrl('result', array()),'success');
			}
		}elseif( $op == 'display'){
			$result = pdo_fetchAll("SELECT * FROM".tablename($this->res)." WHERE weid='{$_W['weid']}' order by ressort asc");
			$list = array();
			foreach ($result as $key => $value) {
				$list[$key]['id'] = $value['id'];
				$list[$key]['resname'] = $value['resname'];
				$list[$key]['respic'] = $value['respic'];
				$list[$key]['resinfo'] = $value['resinfo'];
				$list[$key]['ressort'] = $value['ressort'];
				$departments = pdo_fetch("SELECT * FROM".tablename($this->orgreply)." WHERE id='{$value['department_id']}'");
				$list[$key]['department'] = $departments['department'];
			}
		}elseif( $op == 'delete'){
			pdo_delete($this->res,array('id' => $_GPC['id'] ));
			message("删除教师成功",$this->createWebUrl('teachers', array()),'success');
		}
		include $this->template('result');
	}
	public function doWebContact() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	//预约报名管理
	public function doWebOrders(){
		global $_GPC,$_W;
		load()->func('tpl');
		$list = pdo_fetchAll("SELECT * FROM".tablename($this->yuyue)."WHERE weid='{$_W['weid']}' order by id asc");
		$total = count($list);

		$orders = array();
		foreach ($list as $key => $value) {
			$orders[$key]['id'] = $value['id'];
			$orders[$key]['truename'] = $value['truename'];
			$orders[$key]['mobile'] = $value['mobile'];
			$orders[$key]['tecname'] = $value['tecname'];
			$orders[$key]['createtime'] = $value['createtime'];
			$orders[$key]['remate'] = $value['remate'];
			$departments = pdo_fetch("SELECT * FROM".tablename($this->orgreply)." WHERE id='{$value['department_id']}'");
			$orders[$key]['department'] = $departments['department'];
		}

		if ($_GPC['op'] == 'delete') {
			pdo_delete($this->yuyue,array('id' => $_GPC['id']));
			message('删除成功',$this->createWebUrl('orders', array()),'success');
		}
		include $this->template('orders');
	}
	//预约订单的详情
	public function doWebDetail(){
		global $_GPC,$_W;
		load()->func('tpl');
		$userinfo = pdo_fetch("SELECT * FROM".tablename($this->yuyue)."WHERE id='{$_GPC['id']}'");
		$department = pdo_fetchcolumn("SELECT department FROM".tablename($this->orgreply)."WHERE id='{$userinfo['department_id']}'");
		if ($_W['ispost']) {
			$data = array(
				'remate' => intval($_GPC['remate']),
				'kfinfo' => $_GPC['kfinfo'],
			);
			pdo_update($this->yuyue,$data,array('id' => $_GPC['id']));
			message('修改成功',$this->createWebUrl('orders', array()),'success');
		}
		include $this->template('detail');
	}

	//手机端
	public function doMobileIndex(){
		global $_W,$_GPC;
		$id = intval($_GPC['id']);
		

		$title = pdo_fetchcolumn("SELECT department FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id={$id}");
		$reply = pdo_fetch("SELECT * FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id={$id}");
		//print_r($reply);exit;

		$info_picurl = pdo_fetchcolumn("SELECT info_picurl FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id={$id}");
		$info_picurl2 = pdo_fetchcolumn("SELECT info_picurl2 FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id={$id}");
		include $this->template('index');
	}
	//机构介绍
	public function doMobileDepartment(){
		global $_GPC,$_W;
		$id = intval($_GPC['id']);		
		$detail = pdo_fetch("SELECT * FROM".tablename($this->orgreply)."WHERE id='{$_GPC['id']}'");
		$info_picurl = pdo_fetchcolumn("SELECT info_picurl FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id={$id}");		
		include $this->template('department');
	}
	//教师介绍
	public function doMobileteacher(){
		global $_GPC,$_W;
		$title = '教师介绍';
		$id = intval($_GPC['id']);
		$sql="SELECT a.* FROM ".tablename($this->teacher)." a inner join ".tablename($this->orgreply). " b on a.department_id=b.id WHERE b.weid='{$_W['weid']}' AND b.id='{$_GPC['id']}' order by a.tecsort asc";
		$teachers = pdo_fetchAll($sql);			
		$info_picurl = pdo_fetchcolumn("SELECT order_picurl FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id={$id}");
		//print_r('<pre>');print_r($teachers);exit;
		include $this->template('teacher');
	}	
	//成果介绍
	public function doMobileprofession(){
		global $_GPC,$_W;
		$title = '成果介绍';
		$id = intval($_GPC['id']);
		$sql="SELECT a.* FROM ".tablename($this->res)." a inner join ".tablename($this->orgreply). " b on a.department_id=b.id WHERE b.weid='{$_W['weid']}' AND b.id='{$_GPC['id']}' order by a.ressort asc";
		$results = pdo_fetchAll($sql);		
		$info_picurl = pdo_fetchcolumn("SELECT info_picurl FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id={$id}");
		//print_r('<pre>');print_r($classify);exit;
		include $this->template('profession');
	}	
	//预约报名
	public function doMobileReservation(){
		global $_GPC,$_W;
		$id = intval($_GPC['id']);
		$sql="SELECT a.* FROM ".tablename($this->teacher)." a inner join ".tablename($this->orgreply). " b on a.department_id=b.id WHERE a.weid='{$_W['weid']}' AND a.id='{$_GPC['id']}' ";
		$project = pdo_fetch($sql);		
		//$project = pdo_fetch("SELECT * FROM".tablename('bmhospital_project')."WHERE id='{$id}'");
		//print_r('<pre>');print_r($project);exit;		
		$info_picurl = pdo_fetchcolumn("SELECT tecpic FROM".tablename($this->teacher)."WHERE weid='{$_W['weid']}' and id={$id}");		
		include $this->template('reservation');
	}
	//预约报名保存动作
	public function doMobileyysave(){
		global $_GPC,$_W;		
		//$info_picurl = pdo_fetchcolumn("SELECT info_picurl FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id='{$_GPC['department_id']}'");		
		if ($_W['ispost']) {
			$data = array(
				'truename'   => $_GPC['truename'],
				'mobile'     => $_GPC['mobile'],
				'tecid'      => $_GPC['tecid'],
				'tecname'   => $_GPC['tecname'],
				'department_id'   => $_GPC['department_id'],
				'createtime' => TIMESTAMP,
				'remate'     => '0',
				'info'       => $_GPC['info'],
				'openid'     => $_W['fans']['from_user'],
				'weid'       => $_W['weid'],
				'idno'       => $_GPC['idno'],
				'sex'        => $_GPC['sex'],
				'restime'    => $_GPC['restime'],				
			);
			pdo_insert($this->yuyue,$data);
			$id = pdo_insertid();
			if ($id) {
				 $url = $this->createMobileUrl('mylist',array('department_id' => $_GPC['department_id']));
				 $arr=array('errno'=>1,'url'=>$url);
				  echo json_encode($arr);exit;
			}else{
				 $arr=array('errno'=>2);
           		 echo json_encode($arr);exit;
			}
		}
	}
	//显示我的预约
	public function doMobileMylist(){
		global $_GPC,$_W;	
		$rebs = pdo_fetchAll("SELECT * FROM".tablename($this->yuyue)."WHERE openid='{$_W['fans']['from_user']}'");
		if ($_GPC['op'] == 'delete') {
			pdo_delete($this->yuyue,array('id' => $_GPC['id']));
			message('删除成功',$this->createWebUrl('mylist', array()),'success');
		}
		$info_picurl = pdo_fetchcolumn("SELECT order_picurl FROM".tablename($this->orgreply)."WHERE weid='{$_W['weid']}' and id= '{$_GPC['department_id']}'");		
		include $this->template('mylist');
	}

}