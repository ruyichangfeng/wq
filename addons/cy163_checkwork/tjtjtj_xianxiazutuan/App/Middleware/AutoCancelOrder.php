<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/22 0022
 * Time: 下午 9:41
 */

namespace App\Middleware;

use \Core\Middleware\Middleware;

class AutoCancelOrder implements Middleware
{

    public function next($data = null)
    {
        global $_W;
        $limit = $_SESSION['xxzt_config']['auto_cancel_order_days'] * 24 * 3600;
        $now   = time();
        $res   = pdo_fetchall(
            'SELECT * FROM '.tablename('tjtjtj_xxzt_orders').' WHERE create_at <= :cat AND sid = :sid AND status = 0',
            array(':cat' => $now - $limit, ':sid' => $_W['uniacid'])
        );
        if ($res) {
            foreach ($res as $val) {

                //微信通知 开始
                $user    = \App\Service\Factory::proUserModel($val['userid'])->get();
                $address = \App\Service\Factory::proAddressModel($val['aid'])->get();
                sendOrderCancelMessage($user['openid'], array_merge($address, $val));
                //微信通知 结束

                pdo_update('tjtjtj_xxzt_orders', array('status' => -1), array('uid' => $val['uid']));
            }
        }
    }

}