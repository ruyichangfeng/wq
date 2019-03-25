<?php
//上传图片

global $_W,$_GPC;
$setting = $_W['setting']['upload']['image'];
if (empty($_FILES['file']['name'])) {
    $this->msg['msg']= '上传失败, 请选择要上传的文件！';
    $this->echoAjax();
}
if ($_FILES['file']['error'] != 0) {
    $this->msg['msg']= '上传失败, 请重试.';
    $this->echoAjax();
}
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$ext = strtolower($ext);
$filename = $this->file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
$file = $this->file_upload($_FILES['file'], 'image', $setting['folder'] . $filename);
if (is_error($file)) {
    $this->msg['msg']= $file['message'];
    $this->echoAjax();
}
$pathname = $file['path'];
$oldName =$_FILES['file']['name'];
$fullname = 'attachment/' . $pathname;
$insert['uniacid']=$_W['uniacid'];
$insert['name']=$oldName;
$insert['type']="image";
$insert['url']=$fullname;
$insert['create_time']=time();
pdo_insert("gd_images",$insert);
$info['link']="/".$fullname;
echo json_encode($info);