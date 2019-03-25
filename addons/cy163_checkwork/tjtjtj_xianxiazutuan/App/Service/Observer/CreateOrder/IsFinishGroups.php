<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 10:59
 */

namespace App\Service\Observer\CreateOrder;

use \Core\Observer\Observer;

class IsFinishGroups implements Observer
{

    /**
     * 增加组团人数，并判断组团是否完成
     */
    public function notify($data = null)
    {
        if ($data['buyway'] == 'groups') {
            $groupModel = \App\Service\Factory::proGroupsModel($data['groupid']);
            $group = $groupModel->where()->get();
            if ($group['needpeople'] == ($group['donepeople'] + $data['goodsnums'])) {

                //微信通知 开始
                $tmp = pdo_fetchall(
                    'SELECT orderid FROM '.tablename('tjtjtj_xxzt_groups_records').' WHERE sid = :sid AND groupid = :groupid',
                    array(':sid' => $group['sid'], ':groupid' => $group['uid'])
                );
                foreach ($tmp as $val) {
                    $user  = \App\Service\Factory::proUserModel($val['userid'])->get();
                    $goods = \App\Service\Factory::proGoodsModel($group['gid'])->get();
                    sendGroupSuccessMessage($user['openid'], array_merge($group, $goods));
                }
                //微信通知 结束

                $groupModel->where()->update(array('status' => 1));
            }
            $groupModel->where()->update(array('donepeople' => ($data['goodsnums'] + $group['donepeople'])));
        }
    }

}