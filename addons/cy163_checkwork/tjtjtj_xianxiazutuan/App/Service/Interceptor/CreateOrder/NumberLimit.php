<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 7:50
 */

namespace App\Service\Interceptor\CreateOrder;

use \Core\Interceptor\Interceptor;

class NumberLimit implements Interceptor
{

    /**
     * 商品数量限制
     *
     * 1.商品库存查询
     *
     * 2.用户单次购买限制
     *
     * 3.用户多次购买限制
     *
     */
    public function run($data = null)
    {
        global $_GPC;
        if (intval($_GPC['goodsnums']) <= 0) {
            alert('请填写商品数量.', referer(), 'error');
            exit;
        }

        //商品模型
        $goodsModel = \App\Service\Factory::proGoodsModel($_GPC['goodsid']);
        $goods  = $goodsModel->where()->get();

        //1
        if ($goods['singlelimit'] != 0 && $goods['singlelimit'] < intval($_GPC['goodsnums'])) {
            //单次购买数量超过限制
            alert('您的购买数量超过限制.', referer(), 'error');
            exit;
        }

        //4
        if ($_GPC['buyway'] == 'groups') {
            $groupModel = \App\Service\Factory::proGroupsModel($_GPC['groupid']);
            $group = $groupModel->where()->get();
            if (($group['needpeople'] - $group['donepeople']) < $_GPC['goodsnums']) {
                alert('您最多可以购买'.($group['needpeople'] - $group['donepeople']).'件', referer(), 'error');
            }
        }

        //2
        $curnums = pdo_fetch('SELECT COUNT(goodsnums) AS c FROM '.tablename('tjtjtj_xxzt_orders').' WHERE goodsid = :gid and status > 0 LIMIT 1', array(':gid' => $goods['uid']));
        if ($goods['morelimit'] != 0 && $goods['morelimit'] < ($curnums['c'] + $_GPC['goodsnums'])) {
            //多次购买数量超过限制
            alert('您已经无法购买此商品.', referer(), 'error');
            exit;
        }

        //3
        if ($goods['stock'] != 0 && $goods['stock'] < intval($_GPC['numbers'])) {
            //库存不足
            alert('库存不足.', referer(), 'error');
            exit;
        }
    }

}