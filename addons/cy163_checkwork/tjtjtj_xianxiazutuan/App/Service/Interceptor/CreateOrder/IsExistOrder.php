<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 30/04/2016
 * Time: 11:07
 */

namespace App\Service\Interceptor\CreateOrder;

use \Core\Interceptor\Interceptor;

class IsExistOrder implements Interceptor
{
    public function run($data = null)
    {
        global $_W;
        $ise = pdo_get('tjtjtj_xxzt_orders', array('orderid' => $data['orderid'], 'sid' => $_W['uniacid']));
        $ise && alert('订单已存在', referer(), 'error');
    }
}