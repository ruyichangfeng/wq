<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/22 0022
 * Time: 下午 9:46
 */

namespace App\Middleware;

use \Core\Middleware\Middleware;

class AutoOrderSign implements Middleware
{

    public function next($data = null)
    {
        global $_W;
        $limit = $_SESSION['xxzt_config']['auto_sign_days'] * 24 * 3600;
        $now   = time();
        $res   = pdo_fetchall(
            'SELECT uid FROM '.tablename('tjtjtj_xxzt_orders').' WHERE deliver_at <= :dat AND sid = :sid AND status = 2',
            array(':dat' => $now - $limit, ':sid' => $_W['uniacid'])
        );
        if ($res) {
            foreach ($res as $val) {
                pdo_update('tjtjtj_xxzt_orders', array('status' => 3), array('uid' => $val['uid']));
            }
        }
    }

}