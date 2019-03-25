<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/17 0017
 * Time: 下午 5:06
 */

namespace App\Service\Observer\CreateOrder;

use \Core\Observer\Observer;

class CreateGroupsRecords implements Observer
{

    /**
     * 创建组团订单
     */
    public function notify($data = null)
    {
        if ($data['buyway'] == 'groups') {
            $dat = array(
                'sid' => $data['sid'],
                'groupid' => $data['groupid'],
                'orderid' => $data['uid'],
                'userid'  => $data['userid'],
                'status'  => 1
            );
            pdo_insert('tjtjtj_xxzt_groups_records', $dat);
        }
    }

}