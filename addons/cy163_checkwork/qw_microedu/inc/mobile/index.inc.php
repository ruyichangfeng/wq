<?php
defined('IN_IA') or exit('Access Denied');
include MODULE_ROOT . '/inc/common.php';
include MODULE_ROOT . '/inc/mobile/init.php';
$uniacid = $_W['uniacid'];
// 根据当前用户的身份跳转至相应的前端页面
switch ($user['role_type'])
{
    case 'parents':
        if($user['mobile'])
        {
            header("Location: " . $this->createMobileUrl('parent', array('page' => 'index')));
        }
        else
        {
            header("Location: " . $this->createMobileUrl('parent', array('page' => 'settings')));
        }
        break;
    case 'consultants':
        header("Location: " . $this->createMobileUrl('consultant', array('page' => 'index')));
        break;
    case 'tutors':
        header("Location: " . $this->createMobileUrl('tutor', array('page' => 'index')));
        break;
    default:
        header("Location: " . $this->createMobileUrl('parent', array('page' => 'settings')));
        return false;
}
