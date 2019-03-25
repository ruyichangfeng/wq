<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/23 0023
 * Time: 上午 11:48
 */

namespace App\Middleware;

use \Core\Middleware\Middleware;

class EndNotCompGroups implements Middleware
{

    public function next($data = null)
    {
        global $_W;
        $rec = pdo_fetchall(
            'SELECT * FROM '.tablename('tjtjtj_xxzt_groups').' WHERE sid = :sid AND status = 0 AND end_at <= :eat',
            array(':sid' => $_W['uniacid'], ':eat' => time())
        );
        if ($rec) {
            foreach ($rec as $val) {
                if ($val['donepeople'] < $val['needpeople']) {
                    //组团失败
                    pdo_update('tjtjtj_xxzt_groups', array('status' => -1), array('uid' => $val['uid']));
                    //修改订单状态
                    $tmp = pdo_fetchall(
                        'SELECT orderid FROM '.tablename('tjtjtj_xxzt_groups_records').' WHERE sid = :sid AND groupid = :groupid',
                        array(':sid' => $_W['uniacid'], ':groupid' => $val['uid'])
                    );
                    if ($tmp) {
                        foreach ($tmp as $val) {

                            //微信通知 开始
                            $user  = \App\Service\Factory::proUserModel($val['userid'])->get();
                            $goods = \App\Service\Factory::proGoodsModel($rec['gid'])->get();
                            sendGroupFailMessage($user['openid'], array_merge($rec, $goods));
                            //微信通知 结束

                            pdo_update('tjtjtj_xxzt_orders', array('status' => -2), array('uid' => $val['orderid']));
                        }
                    }
                }
            }//遍历结束
        }
    }

}