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
$type = isset($_GPC['fj'])?"fj":"image";
$file = $this->file_upload($_FILES['file'], $type, $setting['folder'] . $filename);
if (is_error($file)) {
    $this->msg['msg']= $file['message'];
    $this->echoAjax();
}
$pathname = $file['path'];
$fullname = 'attachment/' . $pathname;
$this->msg['code']=1;
$this->msg['name']=$file['name'];
$this->msg['url']=$fullname;
$this->msg['msg']="上传成功";
if(isset($_GPC['from'])){
    $this->msg['code']=0;
    unset($this->msg['name']);
    $this->msg['data']['src']="/".$fullname;
    $this->msg['data']['title']="文件";
}
$this->echoAjax();