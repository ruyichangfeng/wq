<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 10:37
 */

namespace App\Model;

use \Core\Model;

class Order extends Model
{

    protected $tablename = 'tjtjtj_xxzt_orders';

    protected $fieldArray = array(
        'sid',
        'orderid',
        'goodsid',
        'groupid',
        'userid',
        'lid',
        'aid',
        'fee',
        'goodsnums',
        'usd',
        'buyway',
        'payway',
        'status',
        'create_at',
        'express',
        'expressid'
    );

    /**
     * 通过状态查询订单
     */
    public function queryOrderByStatus($status)
    {
        global $_W;
        return pdo_fetchall(
            'SELECT * FROM '.tablename($this->tablename).' WHERE status = :status AND sid = :sid',
            array(':status' => $status, ':sid' => $_W['uniacid']));
    }

}