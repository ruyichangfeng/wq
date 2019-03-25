<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 7:41
 */

namespace App\Controller;

class OrderController
{

    /**
     * @var interceptor
     */
    protected $interceptor = array();

    /**
     * @var notify
     */
    protected $observer    = array();

    /**
     * 添加interceptor
     */
    public function addInterceptor(\Core\Interceptor\Interceptor $interceptor)
    {
        $this->interceptor[] = $interceptor;
    }

    /**
     * 添加observer
     */
    public function addObserver(\Core\Observer\Observer $observer)
    {
        $this->observer[] = $observer;
    }

    /**
     * 创建订单
     */
    public function create()
    {
        global $_W,$_GPC;

        foreach ($this->interceptor as $interceptor) {
            $interceptor->run();
        }

        /**
         * 获取商品详情
         */
        $goodsModel = \App\Service\Factory::proGoodsModel($_GPC['goodsid']);
        $goods      = $goodsModel->where()->get();

        /**
         * 购买方式
         */
        $buyway = $_GPC['buyway'] == 'groups' ? 'groups' : 'single';

        /**
         * 计算邮费
         */
        $usd = \App\Service\Logic\Usd::usd($_GPC['aid'], $goods['lid']);

        /**
         * 计算价格
         */
        if ($buyway == 'groups') {
            $fee = $goods['gprice'] * intval($_GPC['goodsnums']) + $usd;
        } else {
            $fee = $goods['sprice'] * intval($_GPC['goodsnums']) + $usd;
        }

        $data = array(
            'sid' => $_W['uniacid'],
            'orderid' => $_GPC['orderid'],
            'goodsid' => $_GPC['goodsid'],
            'groupid' => $_GPC['groupid'],
            'userid'  => $_SESSION[C('session_prefix').'user']['uid'],
            'lid'     => $goods['lid'],
            'aid'     => intval($_GPC['aid']),
            'fee'     => $fee,
            'goodsnums' => $_GPC['goodsnums'],
            'usd'     => $usd,
            'buyway'  => $buyway,
            'payway'  => 'weixin',
            'create_at' => time()
        );

        \App\Service\Factory::proOrderModel()->insert($data);

        if (isset($_GPC['oldorderid']) && $_GPC['oldorderid'] != '') {
            pdo_query('DELETE FROM '.tablename('tjtjtj_xxzt_orders').' WHERE uid = :uid LIMIT 1', array(':uid' => intval($_GPC['oldorderid'])));
        }

        return $data;
    }

    /**
     * 执行Observer
     */
    public function runObserver($data = null)
    {
        foreach ($this->observer as $observer) {
            $observer->notify($data);
        }
    }
}