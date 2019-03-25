<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/11 0011
 * Time: 下午 7:36
 */

namespace App\Middleware;

use \Core\Middleware\Middleware;

class WeiqinMiddleware implements Middleware
{
    public function next($data = null)
    {
        global $_W;
        if (empty($_W['member'])) {
            exit('Please entry weixin.');
        }
    }
}