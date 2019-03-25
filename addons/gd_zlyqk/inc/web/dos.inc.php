<?php
//设置管理员

global $_GPC;
if(empty($_GPC['admin'])){
    $this->msg['msg']="设置失败";
    $this->echoAjax();
}
$adminInfo =$this->getAdminInfo($_GPC['admin']);
if(empty($adminInfo)){
    $this->msg['msg']="管理员未找到";
    $this->echoAjax();
}
isetcookie('m_name', $adminInfo['name'], 7 * 86400);
isetcookie('m_id', $adminInfo['id'], 7 * 86400);
isetcookie('m_avatar', $adminInfo['avatar'], 7 * 86400);

$this->msg['code']=1;
$this->msg['msg']="设置成功";
$this->echoAjax();