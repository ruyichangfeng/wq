<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:29
 */

namespace App\Middleware;

use \Core\Middleware\Middleware;

class UserMiddleware implements Middleware
{
    public function next($data = null)
    {
        global $_W;
        if (!isset($_SESSION[C('session_prefix').'user'])) {
            $userModel = \App\Service\Factory::proUserModel();
            $user      = $userModel->where(array('sid' => $_W['uniacid'], 'wid' => $_W['member']['uid']))->get();
            if ($user) {
                $_SESSION[C('session_prefix').'user'] = $user;
            } else {
                $dat = array(
                    'sid' => $_W['uniacid'],
                    'wid' => $_W['fans']['uid'],
                    'nickname' => $_W['fans']['nickname'],
                    'avatar'   => $_W['fans']['tag']['avatar'],
                    'mobile'   => '',
                    'openid'   => $_W['openid'],
                    'create_at' => time()
                );
                $uid = $userModel->insert($dat);
                $_SESSION[C('session_prefix').'user'] = $userModel->setUid($uid)->where()->get();
            }
        }
    }
}