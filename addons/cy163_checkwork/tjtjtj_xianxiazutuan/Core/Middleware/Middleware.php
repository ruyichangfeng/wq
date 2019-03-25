<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:28
 */

namespace Core\Middleware;


interface Middleware
{
    public function next($data = null);
}