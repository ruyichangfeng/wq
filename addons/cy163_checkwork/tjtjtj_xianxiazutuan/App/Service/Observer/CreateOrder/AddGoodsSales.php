<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/17 0017
 * Time: 下午 12:15
 */

namespace App\Service\Observer\CreateOrder;

use \Core\Observer\Observer;

class AddGoodsSales implements Observer
{

    /**
     * 增加商品销量
     */
    public function notify($data = null)
    {
        $goodsModel = \App\Service\Factory::proGoodsModel($data['goodsid']);
        $goods = $goodsModel->where()->get(array('sales'));
        $goodsModel->where()->update(array('sales' => $goods['sales'] + $data['goodsnums']));
    }

}