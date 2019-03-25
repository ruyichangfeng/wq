<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/8 0008
 * Time: 下午 8:05
 */

namespace Core\Interceptor;

interface Interceptor
{
    public function run ($data = null);
}