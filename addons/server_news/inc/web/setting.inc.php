<?php 
global $_W,$_GPC;
$ops = array('index', 'news_detail'); // 只支持此 3 种操作.
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'index';
$tablename = 'imeepos_page_setting';
if($op == 'index'){
	if(checksubmit('submit')){
		if(!empty($_GPC['title'])){
		$sql = ' SELECT count(*) FROM '.tablename($tablename).'WHERE page_index = :index AND uniacid = :uniacid';
		$params = array(
			":index" => 1,
			':uniacid'=> $_W['uniacid']
			);
		$row = pdo_fetchcolumn($sql,$params);
		if($row == 0){
			$data['setting_title'] = $_GPC['title'];
			$data['setting_bar_color'] = $_GPC['title_color'];
			$data['setting_bar_bg'] = $_GPC['title_bg'];
			$data['setting_sub_color'] = $_GPC['nav_color'];
			$data['page_index'] = 1;
			$data['uniacid'] = $_W['uniacid'];
			$result = pdo_insert($tablename,$data);
			if($result){
				message('修改成功',$this->createWebUrl('setting'),array('op'=>'index'),'success');
			}else{
				message('修改失败',$this->createWebUrl('setting'),array('op'=>'index'),'error');
			}
		}else{
			$data['setting_title'] = $_GPC['title'];
			$data['setting_bar_color'] = $_GPC['title_color'];
			$data['setting_bar_bg'] = $_GPC['title_bg'];
			$data['setting_sub_color'] = $_GPC['nav_color'];
			$data['page_index'] = 1;
			$data['uniacid'] = $_W['uniacid'];
			$result = pdo_update($tablename,$data);
			if($result){
				message('修改成功',$this->createWebUrl('setting'),array('op'=>'index'),'success');
			}else{
				message('修改失败',$this->createWebUrl('setting'),array('op'=>'index'),'error');
			}
		 }
		}
	}
	if(checksubmit('delete')){
		$result = pdo_delete($tablename, array('page_index'=>1,'uniacid'=>$_W['uniacid']));
		if($result){
			message('删除配置成功',$this->createWebUrl('setting'),array('op'=>'index'),'success');
		}else{
			message('删除配置成功',$this->createWebUrl('setting'),array('op'=>'index'),'error');
		}
	}
	
}
if($op == 'news_detail'){
	if(checksubmit('submit')){
		if(!empty($_GPC['title'])){
		$sql = ' SELECT count(*) FROM '.tablename($tablename).'WHERE page_index = :index AND uniacid = :uniacid';
		$params = array(
			":index" => 2,
			':uniacid' =>$_W['uniacid']
		);
		$row = pdo_fetchcolumn($sql,$params);
		if($row == 0){
			$data['setting_title'] = $_GPC['title'];
			$data['setting_bar_color'] = $_GPC['title_color'];
			$data['setting_bar_bg'] = $_GPC['title_bg'];
			$data['setting_sub_color'] = '#fff';
			$data['page_index'] = 2;
			$data['uniacid'] = $_W['uniacid'];
			$result = pdo_insert($tablename,$data);
			if($result){
				message('修改成功',$this->createWebUrl('setting'),array('op'=>'news_detail'),'success');
			}else{
				message('修改失败',$this->createWebUrl('setting'),array('op'=>'news_detail'),'error');
			}
		}else{
			$data['setting_title'] = $_GPC['title'];
			$data['setting_bar_color'] = $_GPC['title_color'];
			$data['setting_bar_bg'] = $_GPC['title_bg'];
			$data['setting_sub_color'] = $_GPC['nav_color'];
			$data['page_index'] = 2;
			$data['uniacid'] = $_W['uniacid'];
			$result = pdo_update($tablename,$data);
			if($result){
				message('修改成功',$this->createWebUrl('setting'),array('op'=>'news_detail'),'success');
			}else{
				message('修改失败',$this->createWebUrl('setting'),array('op'=>'news_detail'),'error');
			}
		 }
		}
	}
	if(checksubmit('delete')){
		$result = pdo_delete($tablename, array('page_index'=>2,'uniacid'=>$_W['uniacid']));
		if($result){
			message('删除配置成功',$this->createWebUrl('setting'),array('op'=>'news_detail'),'success');
		}else{
			message('删除配置成功',$this->createWebUrl('setting'),array('op'=>'news_detail'),'error');
		}
	}
}
include $this->template('web/setting');