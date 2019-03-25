<?php
/**
 * 轻报名模块微站定义
 *
 * @author unrooter
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class M_formModuleSite extends WeModuleSite {
	private $m_form  = 'form_acti';
	private $m_users = 'form_users';

	public function doMobileIndex() {
		global $_W,$_GPC;

		$sql      = "SELECT * FROM ".tablename($this->m_form)." WHERE uniacid=:uniacid LIMIT 1";
		$params   = array(':uniacid'=>$_W['uniacid']);
		$contents = pdo_fetch($sql, $params);
		if ($contents['end_time'] < time()) {
			$btn_img = $contents['start_img'];
		}else{
			$btn_img = $contents['end_img'];
		}
		if($_W['ispost']){
			$sub_data['username'] = htmlspecialchars($_GPC['username']);
			$sub_data['sex']      = intval($_GPC['sex']);
			$sub_data['phone']    = intval($_GPC['phone']);
			$sub_data['add_time'] = time();
			$sub_data['uniacid']  = $_W['uniacid'];

			if (empty($sub_data['username']) || $sub_data['sex'] == '' || empty($sub_data['phone'])) {
				message('请填写完整信息','','error');
			}
			if (!preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#',$sub_data['phone'])) {
		       message('请填写正确的手机号','','error');
		   }

			//是否已报名
			$sql1    = "SELECT * FROM ".tablename($this->m_users)." WHERE uniacid=:uniacid AND username = :username LIMIT 1";
			$params1 = array(':uniacid'=>$_W['uniacid'],':username'=>$sub_data['username']);
			$is_user = pdo_fetch($sql1, $params1);

			if(!empty($is_user)){
				message('您已经报名过了哦','','error');
			}
			if (!empty($sub_data)) {
				$ret = pdo_insert($this->m_users,$sub_data);
			}
			if (!empty($ret)) {
				message('报名成功',$contents['to_url'],'success');
			}else{
				message('报名失败','','error');
			}
		}
		include $this->template('index');
	}

	public function doWebSign() {
		global $_W,$_GPC;
		$op  = $_GPC['op'] ? $_GPC['op']:'edit';

		if($op == 'edit'){

				$sql	  = "SELECT * FROM ".tablename($this->m_form)." WHERE uniacid=:uniacid LIMIT 1";
				$params   = array(':uniacid'=>$_W['uniacid']);
				$contents = pdo_fetch($sql, $params);

			if (checksubmit()) {
				$id = intval($_GPC['id']);
				$data['theme']      = htmlspecialchars($_GPC['theme']);
				$data['start_time'] = $_GPC['sign_time']['start'];
				$data['end_time']   = $_GPC['sign_time']['end'];
				$data['theme_img']  = $_GPC['theme_img'];
				$data['rule_img']   = $_GPC['rule_img'];
				$data['start_img']  = $_GPC['start_img'];
				$data['end_img']    = $_GPC['end_img'];
				$data['form_color'] = $_GPC['form_color'];
				$data['word_color'] = $_GPC['word_color'];
				$data['to_url']     = $_GPC['to_url'];
				$data['add_time']   = time();
				$data['uniacid']    = $_W['uniacid'];
				if (empty($data['theme'])) {
					message('请填写主题名', '', 'error');
				}
				if (empty($data['theme_img']) || empty($data['rule_img']) || empty($data['start_img']) || empty($data['end_img'])) {
					message('请上传完整图片', '', 'error');
				}
				if (empty($contents)) {
					$ret = pdo_insert($this->m_form,$data);
				}else{
					$ret = pdo_update($this->m_form, $data, array('id'=>$id));
				}
				if (!empty($ret)) {
					message('设置成功',$this->createWebUrl('sign',array('op'=>'edit')),'success');
				}else{
					message('设置失败','','error');
				}
			}
			load()->func('tpl');
			include $this->template('sign');
		}
	}
	public function doWebUser() {
		global $_W,$_GPC;

		$ops = array('display','output','delete');
		$op  = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'display';

		if($op == 'display'){
			$sql       = 'SELECT COUNT(*) FROM '.tablename($this->m_users)." WHERE uniacid=:uniacid";
			$params    = array(':uniacid'=>$_W['uniacid']);
			$total     = pdo_fetchcolumn($sql, $params);
			$pageindex = max(intval($_GPC['page']), 1); // 当前页码
			$pagesize  = 10; // 设置分页大小
			$pager     = pagination($total, $pageindex, $pagesize);
			$sql = "SELECT * FROM".tablename($this->m_users)."WHERE uniacid=:uniacid LIMIT ".(($pageindex -1) * $pagesize).','. $pagesize;
			$contents = pdo_fetchall($sql, $params);

			include $this->template('user');
		}
		if ($op == 'output') {
			header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename=Export_test.xls");
			$tab="\t"; $br="\n";
			$head="编号".$tab."用户名".$tab."性别".$tab."联系方式".$br;
			$head=iconv("UTF-8", "GBK", $head);
			//输出内容如下：
			echo $head;
			//从数据库输出数据处理方式
			$params    = array(':uniacid'=>$_W['uniacid']);
			$sql = "SELECT * FROM".tablename($this->m_users)."WHERE uniacid=:uniacid";
			$contents = pdo_fetchall($sql, $params);
			$count = count($contents);
			foreach ($contents as $content) {
			 	echo  $content['id'].$tab;
				echo  iconv("UTF-8", "GBK", $content['username']).$tab;
				echo  $content['sex'].$tab;
				echo  $content['phone'].$tab;
				echo  $br;
			 }
		}

		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			if (empty($id)) {
				message('对不起，您要删除的报名用户不存在！');
			}
			$res = pdo_delete($this->m_users, array('id' => $id,'uniacid'=>$_W['uniacid']));
			if (!empty($res)) {
				message('删除成功',$this->createWebUrl('user',array('op'=>'display')),'success');
			}else{
				message('删除失败','','error');
			}
		}
	}
	public function doWebWord() {
		//这个操作被定义用来呈现 管理中心导航菜单
	}
	private function getSex($sex){
		if ($sex == 1) {
			$_html = "男";
		}else{
			$_html = "女";
		}
		return $_html;
	}

}