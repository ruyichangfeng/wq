<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/8 0008
 * Time: 下午 8:09
 */

namespace Core\Observer;


interface Observer
{
    public function notify ($data = null);
}