<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/21 0021
 * Time: 下午 9:25
 */

namespace App\Service\Logic;


class Usd
{

    /**
     * 物流费用计算
     */
    public static function usd($aid, $lid)
    {
        // $logistics = \App\Service\Factory::proLogisticsModel($lid)->get();
        // $address   = \App\Service\Factory::proAddressModel($aid)->get();
        // $usd  = 0;
        // $area = explode('$', $logistics['area']);
        // if (in_array($address['province'], $area)) {
        //     $usd = $logistics['yesfee'];
        // } else {
        //     $usd = $logistics['nofee'];
        // }
        return 0;
    }

}