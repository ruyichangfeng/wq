<?php
/**
 * base.php
 * 这不是一个自由软件！。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * 开发: 冰源
 * 日期: 18-1-20
 * 时间: 下午5:17
 */

namespace ext\libs;


class base
{
    public $msg=array('code'=>2,"msg"=>"",'data'=>"");

    public function echoAjax(){
        echo json_encode($this->msg);
        die(1);
    }
}