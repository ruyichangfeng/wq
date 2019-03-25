<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/17 0017
 * Time: 下午 3:25
 */

namespace App\Service\Observer\CreateOrder;

use \Core\Observer\Observer;

class ChangeOrderStatus implements Observer
{

    /**
     * 修改订单状态
     */
    public function notify($data = null)
    {
        \App\Service\Factory::proOrderModel($data['uid'])->where()->update(array('status' => 1));
    }

}