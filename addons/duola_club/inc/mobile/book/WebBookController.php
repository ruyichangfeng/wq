<?php

/**
 * Created by PhpStorm.
 * User: liu
 * Date: 2017/3/12
 * Time: 上午9:48
 */
require_once 'BookController.php';
class WebBookController extends BookController
{
    public function __construct($schoolid, $openid, $weid)
    {
        parent::__construct($schoolid, $openid, $weid);
    }

    public function formatData($data)
    {
        // TODO: Implement formatData() method.
    }

    public function showBookUser(){

    }
}