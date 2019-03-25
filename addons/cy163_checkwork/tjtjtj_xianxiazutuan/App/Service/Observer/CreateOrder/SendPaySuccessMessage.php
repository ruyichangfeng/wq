<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/23 0023
 * Time: 下午 4:42
 */

namespace App\Service\Observer\CreateOrder;

use \Core\Observer\Observer;

class SendPaySuccessMessage implements Observer
{

    /**
     * 发送微信通知
     */
    public function notify($data = null)
    {
        $user = \App\Service\Factory::proUserModel($data['userid'])->get();
        $goods = \App\Service\Factory::proGoodsModel($data['goodsid'])->get();
        sendPaySuccessMessage($user['openid'], array('fee' => $data['fee'], 'goodsname' => $goods['name']));
    }

}