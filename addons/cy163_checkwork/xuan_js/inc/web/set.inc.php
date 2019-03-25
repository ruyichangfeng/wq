<?php
defined('IN_IA') or exit('Access Denied');
		global $_W, $_GPC;
		$sql = 'SELECT * FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
		$setting = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':module' => 'xuan_js'));
		$settings = iunserializer($setting['settings']);
		if ($_POST){
			if ($_FILES['weixin_cert_file']['name']) 
			{
				$_POST['weixin_cert'] = upload_cert('weixin_cert_file');
			}else{
				
			}
			if ($_FILES['weixin_key_file']['name']) 
			{
				$_POST['weixin_key'] = upload_cert('weixin_key_file');
			}
			if ($_FILES['weixin_root_file']['name']) 
			{
				$_POST['weixin_root'] = upload_cert('weixin_root_file');
			}

			$a = serialize($_POST);
			$user_data = array(
				'settings' => $a,
			);

			if (empty($setting)) {
				$user_data['uniacid']=$_W['uniacid'];
				$user_data['module']='xuan_js';
				$user_data['enabled']=1;
				$result = pdo_insert('uni_account_modules', $user_data);
			}else{
			$result = pdo_update('uni_account_modules', $user_data, array('module' => 'xuan_js','uniacid' => $_W['uniacid']));
			}	

			


			if (!empty($result)) {
				message('更新成功',$this->createWebUrl('set'));
			}
		}
		include $this->template('web/set');


function upload_cert($fileinput) 
	{
		global $_W;
		$path = IA_ROOT . '/addons/xuan_js/cert';
		load()->func('file');
		mkdirs($path);
		$f = $fileinput . '_' . $_W['uniacid'] . '.pem';
		$outfilename = $path . '/' . $f;
		$filename = $_FILES[$fileinput]['name'];
		$tmp_name = $_FILES[$fileinput]['tmp_name'];
		if (!empty($filename) && !empty($tmp_name)) 
		{
			$ext = strtolower(substr($filename, strrpos($filename, '.')));
			if ($ext != '.pem') 
			{
				$errinput = '';
				if ($fileinput == 'weixin_cert_file') 
				{
					$errinput = 'CERT文件格式错误';
				}
				else if ($fileinput == 'weixin_key_file') 
				{
					$errinput = 'KEY文件格式错误';
				}
				else if ($fileinput == 'weixin_root_file') 
				{
					$errinput = 'ROOT文件格式错误';
				}
				
			}
			return file_get_contents($tmp_name);
		}
		return '';
	}