<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 10:31
 */

namespace App\Service\Interceptor\CreateOrder;

use \Core\Interceptor\Interceptor;

class IsExistGoods implements Interceptor
{

    /**
     *
     * 检测商品是否存在
     *
     */
    public function run($data = null)
    {
        global $_W, $_GPC;
        $goodsModel = \App\Service\Factory::proGoodsModel($_GPC['goodsid']);
        $goods = $goodsModel->where()->get();
        if (!$goods) {
            alert('商品不存在', referer(), 'error');
        }
    }

}