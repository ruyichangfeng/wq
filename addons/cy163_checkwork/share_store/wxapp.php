<?php

defined('IN_IA') or exit('Access Denied');

class Share_storeModuleWxapp extends WeModuleWxapp {

    public function doPageTest(){
//        global $_GPC, $_W;
        $errno = 0;
        $message = '返回消息';
        $data = array();
        return $this->result($errno, $message, $data);
    }

}
