<?php
class SaveCertComponent {

	static function save($settings_name,$url) {
		global $_W;
		//array(1) { ["appclient_cert"]=> array(5) { ["name"]=> string(18) "apiclient_cert.pem" ["type"]=> string(26) "application/x-x509-ca-cert" ["tmp_name"]=> string(24) "/data/home/tmp/phpEC3UZk" ["error"]=> int(0) ["size"]=> int(1590) } }
		if(!$_FILES) {
			exit("上传错误");
		}
		$path = dirname(dirname(dirname(__FILE__))).'/intelligent_kindergarten_cert/';
		if($_FILES['file']['size'] <=0 ) {
			exit("文件大小错误");
		}
		if(!is_dir($path)) {
			if(!mkdir($path)) {
				exit("创建目录失败");
			}
		}
		$filename = $_W['uniacid'].'_'.$_FILES['file']['name'];
		$r = move_uploaded_file($_FILES['file']['tmp_name'],$path.$filename);
		if(!$r) {
			exit("移动文件失败");
		}
		$r = SettingsModel::addItem($settings_name,$path.$filename);
		if($r) {
			header("location:".$url);
		}else {
			exit("写入数据失败");
		}
	}
}