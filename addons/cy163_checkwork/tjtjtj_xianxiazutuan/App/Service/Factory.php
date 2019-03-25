<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:19
 */

namespace App\Service;


class Factory
{

    /**
     * 生成UserModel
     */
    public static function proUserModel($uid = null)
    {
        return new \App\Model\User($uid);
    }

    /**
     * 生成AddressModel
     */
    public static function proAddressModel ($uid = null)
    {
        return new \App\Model\Address($uid);
    }

    /**
     * 生成GroupsModel
     */
    public static function proGroupsModel ($uid = null)
    {
        return new \App\Model\Groups($uid);
    }

    /**
     * 生成SlidersModel
     */
    public static function proSlidersModel ($uid = null)
    {
        return new \App\Model\Sliders($uid);
    }

    /**
     * 生成GoodsModel
     */
    public static function proGoodsModel ($uid = null)
    {
        return new \App\Model\Goods($uid);
    }

    /**
     * 生成OrderModel
     */
    public static function proOrderModel ($uid = null) {
        return new \App\Model\Order($uid);
    }

    /**
     * 生成LogisticsModel
     */
    public static function proLogisticsModel ($uid = null) {
        return new \App\Model\Logistics($uid);
    }


    /**
     * 生成订单控制器
     */
    public static function proOrderController () {
        $obj = new \App\Controller\OrderController();
        //增加拦截器
        $obj->addInterceptor(new \App\Service\Interceptor\CreateOrder\IsExistGroups());
        $obj->addInterceptor(new \App\Service\Interceptor\CreateOrder\IsExistGoods());
        $obj->addInterceptor(new \App\Service\Interceptor\CreateOrder\NumberLimit());
        //增加Observer
        $obj->addObserver(new \App\Service\Observer\CreateOrder\DecStock());
        $obj->addObserver(new \App\Service\Observer\CreateOrder\IsFinishGroups());
        $obj->addObserver(new \App\Service\Observer\CreateOrder\AddGoodsSales());
        $obj->addObserver(new \App\Service\Observer\CreateOrder\ChangeOrderStatus());
        $obj->addObserver(new \App\Service\Observer\CreateOrder\CreateGroupsRecords());
        $obj->addObserver(new \App\Service\Observer\CreateOrder\SendPaySuccessMessage());
        return $obj;
    }

}