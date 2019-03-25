<?php


defined('IN_IA') or exit('Access Denied');
define("ASSETS_PATH",MODULE_URL.'public/assets/');
define("EDITOR_PATH",MODULE_URL.'public/editor/');
global $_W,$_GPC;
$path = $_SERVER['DOCUMENT_ROOT']."/attachment/images/";

//$save_name = time().$_FILES['img']['name'];
//
//if(move_uploaded_file($_FILES['img']['tmp_name'], $path.$save_name) == true)
//{
//    $save_path = $_W['siteroot']."attachment/images/".$save_name;
//}


if(count($_FILES) > 1)
{
    foreach ($_FILES as $k => $v)
    {
        $save_name = time().$_FILES[$k]['name'];
        if(move_uploaded_file($_FILES[$k]['tmp_name'], $path.$save_name) == true)
        {
            $save_path[] = $_W['siteroot']."attachment/images/".$save_name;
        }
    }
}

var_dump(count($_FILES));

$sql = "SELECT isread FROM ".tablename("liuyan_website")."WHERE id = 1";

$site_info = pdo_fetch($sql);

if($site_info['isread'] == 0)
{
    $status = 0;
}
else
{
    $status = 1;
}
if($_GPC['info'] != "")
{
    $data = array(
        'user' => $_W['fans']['nickname'],
        'uid' => $_W['fans']['uid'],
        'img' => serialize($save_path),
        'info' => $_GPC['info'],
        'time' => date("Y-m-d H:i:s"),
        'status' => $status
    );

    if(pdo_insert("liuyan_liuyan",$data))
    {
        message('发布成功', '', 'success');
    }
    else
    {
        message('发布失败', '', 'error');
    }
}



include $this->template("fabu");