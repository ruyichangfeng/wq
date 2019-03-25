<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/16 0016
 * Time: 下午 10:25
 */

namespace App\Service\Interceptor\CreateOrder;

use \Core\Interceptor\Interceptor;

class IsExistGroups implements Interceptor
{

    /**
     *
     * 检测组团是否存在
     *
     * 判断组团是否存在
     *
     */
    public function run($data = null)
    {
        global $_W, $_GPC;
        if ($_GPC['buyway'] == 'groups') {
            $groupsModel = \App\Service\Factory::proGroupsModel($_GPC['groupid']);
            $group = $groupsModel->where()->get();
            if (!$group) {
                alert('组团不存在', referer(), 'error');
            }
            if ($group['status'] != 0) {
                alert('组团已结束或已过期', referer(), 'error');
            }
        }
    }

}