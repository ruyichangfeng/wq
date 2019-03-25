<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:25
 */


return array(
    /* SESSION前缀 */
    'session_prefix' => 'xxzt_',
    /* COOKIE前缀 */
    'cookie_prefix'  => 'xxzt_',

    /* Middleware */
    'middleware' => array(
        new \App\Middleware\UserMiddleware(),
        new \App\Middleware\AutoOrderSign(),
        new \App\Middleware\AutoCancelOrder(),
        new \App\Middleware\EndNotCompGroups(),
        new \App\Middleware\CheckRefundStatus(),
    )

);