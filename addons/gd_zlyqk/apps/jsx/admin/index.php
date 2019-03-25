<?php
/**
 * index.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 17-12-16
 * 时间: 上午3:50
 */

namespace app\jsx\admin;

use app\controller;

class index extends controller
{
    public  function index(){
        global $_GPC,$_W;
        include  $this->template("index");
    }

    public function show(){

    }
}