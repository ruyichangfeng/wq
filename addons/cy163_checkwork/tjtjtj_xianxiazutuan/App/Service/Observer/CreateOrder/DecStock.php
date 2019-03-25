<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 10:44
 */

namespace App\Service\Observer\CreateOrder;

use \Core\Observer\Observer;

class DecStock implements Observer
{

    public function notify($data = null)
    {
        $goodsModel = \App\Service\Factory::proGoodsModel($data['goodsid']);
        $goodsModel->decStock($data['goodsnums']);
    }

}