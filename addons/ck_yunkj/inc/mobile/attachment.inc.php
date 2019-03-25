<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

function uploadFile(){

	$picname = $_FILES['mypic']['name'];
	$picsize = $_FILES['mypic']['size']; //获取图片的大小

	if ($picname != "") {

		//图片大小的限制
		if ($picsize > 5120000) {
			echo '大小不能超过5M';
			exit;
		}

		//设置上传格式
		$allowArr = explode("|",'zip|rar|jpg|jpeg|bmp|gif|png|doc|docx|xls|xlsx');
		$upload_file_ext = strtolower(end(explode(".",$_FILES['mypic']['name'])));
		if(!in_array($upload_file_ext, $allowArr)){
			exit("$upload_file_ext:上传格式不正确！");
		}
		
		$attach_dir = '../attachment/files';
		if(!is_dir($attach_dir)){
			@mkdir($attach_dir, 0777);
			@fclose(fopen($attach_dir.'/index.htm', 'w'));
		}

		$type = strstr($picname, '.');

		//设置上传文件名
		$rand = rand(100, 999);
		$pics = date("YmdHis") . $rand . $type;

		//上传目录
		$uploadPath = $attach_dir.'/ '.$pics;
		move_uploaded_file($_FILES['mypic']['tmp_name'], $uploadPath);
	}

	$size = round($picsize/1024,2);
	$arr = array(
		'name' => $picname,
		'src' => $pics,
		'size' => $size
	);

	echo json_encode($arr);
}

/**
 * $.ajax({
 * 	url:'xxx/uploadFile'
 * })
 */
uploadFile();